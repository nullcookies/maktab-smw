<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\DB;
use Longman\TelegramBot\Conversation;

use Longman\TelegramBot\Commands\SystemCommands\StartCommand;
use \models\objects\User;
use \models\objects\Student;
use \models\objects\UserRequest;
use \models\front\LessonModel;

class MyChildrenCommand extends UserCommand
{
    protected $name = 'mychildren';
    protected $description = 'My Children';
    protected $usage = '/mychildren';
    protected $version = '1.0.0';

    public function execute()
    {
        if($callback_query = $this->getCallbackQuery()){
            $message = $callback_query->getMessage();
            //todo: check callback query from bot changing from_id to chat_id for conversation
            $user    = $message->getChat();
            //$user    = $message->getFrom();
        }
        else{
            $message = $this->getMessage();
            $user    = $message->getFrom();
        }

        $chat    = $message->getChat();
        $chat_id = $chat->getId();
        $user_id = $user->getId();
        $text    = trim($message->getText(true));

        $user = StartCommand::getUser($user_id);
        $lang_id = StartCommand::getLanguage($user_id);


        $pdo = DB::getPdo();

        $mainUser = [];
        $myStudents = [];

        $checkMainUser = [];
        $checkMainUser = $pdo->prepare("SELECT * FROM " . DB_PREFIX . "user WHERE username = :username");
        $checkMainUser->execute([':username' => $user['phone']]);
        if($checkMainUser->rowCount() > 0){
            $mainUser = $checkMainUser->fetch();
        }
        if($mainUser){

        	$getMystudents = $pdo->prepare("SELECT u.id, u.firstname, u.lastname FROM " . DB_PREFIX . "student_to_user s2u LEFT JOIN " . DB_PREFIX . "user u ON s2u.student_id = u.id WHERE s2u.user_id = :user_id" );
        	$getMystudents->execute([':user_id' => $mainUser['id']]);
        	if($getMystudents->rowCount() > 0){
        		$myStudents = $getMystudents->fetchAll();
        	}


        	//список групп для добавления ребенка
	        if(stripos($text, 'add_children') === 0){

	            $keyboard = self::chooseGroupKeyboard($lang_id);
	        	if($keyboard != false){
	        		$sendtext = self::t($lang_id, 'choose_group');
	        	}
	            else{
	            	$keyboard = self::getKeyboard($lang_id);
	            	$sendtext = self::t($lang_id, 'no_groups_added');
	            }
	            $data = [
		            'chat_id'      => $chat_id,
		            'reply_markup' => $keyboard,
		            'text'         => $sendtext,
		        ];
		        return Request::sendMessage($data);
        	}
        	elseif(strpos($text, 'mychildren_group_id_') !== false) {
	            $group_id = (int)substr($text, mb_strlen('mychildren_group_id_'));

	            $keyboard = self::chooseStudentKeyboard($lang_id, $group_id);
	        	if($keyboard != false){
	        		$sendtext = self::t($lang_id, 'choose_student');
	        	}
	            else{
	            	$keyboard = self::getKeyboard($lang_id);
	            	$sendtext = self::t($lang_id, 'no_students_added');
	            }
	            $data = [
		            'chat_id'      => $chat_id,
		            'reply_markup' => $keyboard,
		            'text'         => $sendtext,
		        ];
		        return Request::sendMessage($data);
	        }
            elseif(strpos($text, 'mychildren_add_student_id_') !== false) {

                $student_id = (int)substr($text, mb_strlen('mychildren_add_student_id_'));
                $student = new Student();
                $checkIsStudent = $pdo->prepare("SELECT id FROM " . DB_PREFIX . "user WHERE id = :id AND usergroup = :usergroup");
                $checkIsStudent->bindParam(':id', $student_id);
                $checkIsStudent->bindParam(':usergroup', $student->usergroup);
                $checkIsStudent->execute();
                

                $checkAddedBefore = $pdo->prepare("SELECT * FROM " . DB_PREFIX . "student_to_user WHERE student_id = :student_id AND user_id = :user_id");
                $checkAddedBefore->bindValue(':student_id', $student_id);
                $checkAddedBefore->bindValue(':user_id', $mainUser['id']);
                $checkAddedBefore->execute();

                $sendtext = '';
                if($checkAddedBefore->rowCount() > 0){
                    //student added before
                    $sendtext .= self::t($lang_id, 'student_has_been_already_added');
                }
                elseif($checkIsStudent->rowCount() == 0){
                    //student_id does not belong to students usergroup
                    $sendtext .= self::t($lang_id, 'there_was_an_error');
                }
                else{
                    //no errors
                    $addRequestStudent = $pdo->prepare("INSERT INTO " . DB_PREFIX . "user_request (user_id, type, target_id, date, status) VALUES (:user_id, :type, :target_id, :date, :status)");
                    $newRequest = [];
                    $newRequest[':user_id'] = $mainUser['id'];
                    $newRequest[':type'] = UserRequest::TYPE_ADD_USER_STUDENT;
                    $newRequest[':target_id'] = $student_id;
                    $newRequest[':date'] = time();
                    $newRequest[':status'] = UserRequest::STATUS_PENDING;
                    if($addRequestStudent->execute($newRequest)){
                        $sendtext .= self::t($lang_id, 'request_has_been_sent') . "\n";
                        $sendtext .= self::t($lang_id, 'wait_for_approval');
                    }
                    else{
                        $sendtext .= self::t($lang_id, 'there_was_an_error') . ' 2';
                    }
                }
                $keyboard = self::getKeyboard($lang_id);

                $data = [
                    'chat_id'      => $chat_id,
                    'reply_markup' => $keyboard,
                    'text'         => $sendtext,
                ];
                return Request::sendMessage($data);
            }
        	elseif(strpos($text, 'mychildren_view_student_id_') !== false) {

	            $student_id = (int)substr($text, mb_strlen('mychildren_view_student_id_'));
	            $student = new Student();
	            $checkIsStudent = $pdo->prepare("SELECT id FROM " . DB_PREFIX . "user WHERE id = :id AND usergroup = :usergroup");
	            $checkIsStudent->bindParam(':id', $student_id);
	            $checkIsStudent->bindParam(':usergroup', $student->usergroup);
	            $checkIsStudent->execute();

	            $sendtext = '';
	            if($checkIsStudent->rowCount() == 0){
	            	//student_id does not belong to students usergroup
	            	$sendtext .= self::t($lang_id, 'there_was_an_error');
	            }
	            else{
	            	//no errors
	            	$getGroup = $pdo->prepare("SELECT g.id FROM " . DB_PREFIX . "student_to_group s2g LEFT JOIN " . DB_PREFIX . "group g ON s2g.group_id = g.id WHERE s2g.student_id = :student_id");
                    $getGroup->bindValue(':student_id', $student_id);
                    $getGroup->execute();

	            	if($getGroup->rowCount() > 0){
                        $group = $getGroup->fetch();
	            		$sendtext .= self::t($lang_id, 'group_Id') . $group['id'] . "\n";
	            	}
	            	else{
	            		$sendtext .= self::t($lang_id, 'there_was_an_error') . ' 2';
	            	}
	            }
	            $keyboard = self::getKeyboard($lang_id);

	            $data = [
		            'chat_id'      => $chat_id,
		            'reply_markup' => $keyboard,
		            'text'         => $sendtext,
		        ];
		        return Request::sendMessage($data);
	        }

        }

		$sendtext = '';
		$keyboard = self::getKeyboard($lang_id);

		if(count($myStudents)){
            $keyboard = self::getMystudentsKeyboard($lang_id, $myStudents);
			$sendtext .= self::t($lang_id, 'my_children_quantity') . ': ' . count($myStudents);
		}
		else{
			$sendtext .= self::t($lang_id, 'no_children_added');
		}
        $data = [
            'chat_id'      => $chat_id,
            'reply_markup' => $keyboard,
            'text'         => $sendtext,
        ];
        return Request::sendMessage($data);
    }

    public static function getKeyboard($lang_id)
    {
    	$keyboard = new Keyboard(
            [self::t($lang_id, 'button_my_children'), self::t($lang_id, 'button_add_children')],
            [self::t($lang_id, 'button_main_page')]
        );
        $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(false)
            ->setSelective(false);
        return $keyboard;
    }

    public static function chooseGroupKeyboard($lang_id)
    {
        $keyboard_buttons = [];
        $groups = self::getGroups();
        if(count($groups)){
        	foreach ($groups as $value) {
        		if(!array_key_exists($value['start_year'], $keyboard_buttons)){
        			$keyboard_buttons[$value['start_year']] = [];
        		}
	            $keyboard_buttons[$value['start_year']][] = 
	            [
                    'text'          => $value['grade'] . '-' . $value['name'],
                    'callback_data' => 'mychildren_group_id_' . $value['id'],
                ];
	        }
	        krsort($keyboard_buttons);
        }
        else{
        	return false;
        }


        if(version_compare(PHP_VERSION, '5.6.0', '>=')){
            $keyboard = new InlineKeyboard(...$keyboard_buttons);
        } else {
            $reflect  = new \ReflectionClass('Longman\TelegramBot\Entities\InlineKeyboard');
            $keyboard = $reflect->newInstanceArgs($keyboard_buttons);
        }
        
        return $keyboard;
    }

    public static function getGroups()
    {
    	$groups = [];
    	$pdo = DB::getPdo();
        $getGroups = $pdo->prepare('SELECT * FROM ' . DB_PREFIX . 'group WHERE start_year >= :start_year');
        $lesson = new LessonModel();
        $studyStartMonth = $lesson->getOption('study_start_month');
        $startYear = (date('n') >= $studyStartMonth) ? date('Y') - 11 : date('Y') - 12;
        $getGroups->bindParam(':start_year', $startYear);
        $getGroups->execute();
        if($getGroups->rowCount() > 0){
        	$groups = $getGroups->fetchAll();
        	foreach ($groups as $key => $value) {
        		$groups[$key]['grade'] = $lesson->getGrade($value['start_year'], $value['end_year']);
        	}
        }
        return $groups;
    }

    public static function chooseStudentKeyboard($lang_id, $group_id)
    {
        $keyboard_buttons = [];
        $students = self::getStudents($group_id);
        if(count($students)){
        	$startIndex = 0;
        	foreach ($students as $value) {
        		if(isset($keyboard_buttons[$startIndex]) && count($keyboard_buttons[$startIndex]) == 3){
        			$startIndex++;
        		}
        		if(!array_key_exists($startIndex, $keyboard_buttons)){
        			$keyboard_buttons[$startIndex] = [];
        		}
	            $keyboard_buttons[$startIndex][] = 
	            [
                    'text'          => $value['lastname'] . ' ' . $value['firstname'],
                    'callback_data' => 'mychildren_add_student_id_' . $value['id'],
                ];
	        }
        }
        else{
        	return false;
        }

        if(version_compare(PHP_VERSION, '5.6.0', '>=')){
            $keyboard = new InlineKeyboard(...$keyboard_buttons);
        } else {
            $reflect  = new \ReflectionClass('Longman\TelegramBot\Entities\InlineKeyboard');
            $keyboard = $reflect->newInstanceArgs($keyboard_buttons);
        }
        
        return $keyboard;
    }

    public static function getStudents($group_id)
    {
    	$students = [];
    	$pdo = DB::getPdo();
        $getStudents = $pdo->prepare('SELECT u.* FROM ' . DB_PREFIX . 'student_to_group s2g LEFT JOIN ' . DB_PREFIX . 'user u ON s2g.student_id = u.id WHERE s2g.group_id = :group_id ORDER BY u.lastname');
        $getStudents->bindParam(':group_id', $group_id);
        $getStudents->execute();
        if($getStudents->rowCount() > 0){
        	$students = $getStudents->fetchAll();
        }
        return $students;
    }

    public static function getMystudentsKeyboard($lang_id, $myStudents)
    {
        $keyboard_buttons = [];
        if(count($myStudents)){
            $startIndex = 0;
            foreach ($myStudents as $value) {
                if(isset($keyboard_buttons[$startIndex]) && count($keyboard_buttons[$startIndex]) == 3){
                    $startIndex++;
                }
                if(!array_key_exists($startIndex, $keyboard_buttons)){
                    $keyboard_buttons[$startIndex] = [];
                }
                $keyboard_buttons[$startIndex][] = 
                [
                    'text'          => $value['lastname'] . ' ' . $value['firstname'],
                    'callback_data' => 'mychildren_view_student_id_' . $value['id'],
                ];
            }
        }
        else{
            return false;
        }

        if(version_compare(PHP_VERSION, '5.6.0', '>=')){
            $keyboard = new InlineKeyboard(...$keyboard_buttons);
        } else {
            $reflect  = new \ReflectionClass('Longman\TelegramBot\Entities\InlineKeyboard');
            $keyboard = $reflect->newInstanceArgs($keyboard_buttons);
        }
        
        return $keyboard;
    }

}