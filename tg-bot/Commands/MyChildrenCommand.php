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
use \system\Model;
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
            if(stripos($text, 'add_student') === 0){

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
	        elseif(stripos($text, 'delete_student') === 0){
                $sendtext = '';
                if(count($myStudents)){
                    $sendtext .= self::t($lang_id, 'choose_student_to_delete');
                    $keyboard = self::getMystudentsKeyboard($lang_id, $myStudents, 'delete');
                }
                else{
                    $sendtext .= self::t($lang_id, 'no_students_added');
                    $keyboard = self::getKeyboard($lang_id);
                }
                $data = [
                    'chat_id'      => $chat_id,
                    'reply_markup' => $keyboard,
                    'text'         => $sendtext,
                ];
                return Request::sendMessage($data);

	            
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
                $checkIsStudent->bindValue(':id', $student_id);
                $checkIsStudent->bindValue(':usergroup', $student->usergroup);
                $checkIsStudent->execute();
                

                $checkAddedBefore = $pdo->prepare("SELECT * FROM " . DB_PREFIX . "student_to_user WHERE student_id = :student_id AND user_id = :user_id");
                $checkAddedBefore->bindValue(':student_id', $student_id);
                $checkAddedBefore->bindValue(':user_id', $mainUser['id']);
                $checkAddedBefore->execute();

                $sendtext = '';
                $keyboard = self::getKeyboard($lang_id);

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
                    $model = new Model();
                    $checkRequestedBefore = $pdo->prepare("SELECT * FROM " . DB_PREFIX . "user_request WHERE user_id = :user_id AND target_id = :target_id AND type = :type");
                    $checkRequest = [];
                    $checkRequest[':user_id'] = $mainUser['id'];
                    $checkRequest[':type'] = UserRequest::TYPE_ADD_USER_STUDENT;
                    $checkRequest[':target_id'] = $student_id;
                    $checkRequestedBefore->execute($checkRequest);
                    if($checkRequestedBefore->rowCount() == 0){
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
                            $sendtext .= self::t($lang_id, 'there_was_an_error');
                        }
                    }
                    else{
                        $requestContent = $checkRequestedBefore->fetch();
                        $sendtext .= self::t($lang_id, 'your_request_status') . ': ' . $model->t('user_request_status_result ' . $requestContent['status'], 'back') . "\n";
                    }
                        
                }
                $data = [
                    'chat_id'      => $chat_id,
                    'reply_markup' => $keyboard,
                    'text'         => $sendtext,
                ];
                return Request::sendMessage($data);
            }
            elseif(strpos($text, 'mychildren_view_student_id_') !== false) {
                $sendtext = '';
                $keyboard = self::getKeyboard($lang_id);

                $student_id = (int)substr($text, mb_strlen('mychildren_view_student_id_'));
                $student = new Student();
                $checkIsStudent = $pdo->prepare("SELECT id FROM " . DB_PREFIX . "user WHERE id = :id AND usergroup = :usergroup");
                $checkIsStudent->bindValue(':id', $student_id);
                $checkIsStudent->bindValue(':usergroup', $student->usergroup);
                $checkIsStudent->execute();

                if($checkIsStudent->rowCount() == 0){
                    //student_id does not belong to students usergroup
                    $sendtext .= self::t($lang_id, 'there_was_an_error');
                }
                else{
                    $keyboard = self::studentSubjectsKeyboard($lang_id, $student_id);
                    if($keyboard != false){
                        $sendtext = self::t($lang_id, 'choose_subject');
                    }
                    else{
                        $keyboard = self::getKeyboard($lang_id);
                        $sendtext = self::t($lang_id, 'no_lessons_added');
                    }
                }

                $data = [
                    'chat_id'      => $chat_id,
                    'reply_markup' => $keyboard,
                    'text'         => $sendtext,
                ];
                return Request::sendMessage($data);
            }
            elseif(strpos($text, 'mychildren_delete_student_id_') !== false) {
                $sendtext = '';
                $keyboard = self::getKeyboard($lang_id);

                $student_id = (int)substr($text, mb_strlen('mychildren_delete_student_id_'));
                $student = new Student();
                $checkIsStudent = $pdo->prepare("SELECT id FROM " . DB_PREFIX . "user WHERE id = :id AND usergroup = :usergroup");
                $checkIsStudent->bindValue(':id', $student_id);
                $checkIsStudent->bindValue(':usergroup', $student->usergroup);
                $checkIsStudent->execute();

                if($checkIsStudent->rowCount() == 0){
                    //student_id does not belong to students usergroup
                    $sendtext .= self::t($lang_id, 'there_was_an_error');
                }
                else{
                    $deleteUserStudent = $pdo->prepare("DELETE FROM " . DB_PREFIX . "student_to_user WHERE student_id = :student_id AND user_id = :user_id");
                    $deleteUserStudent->bindValue(':student_id', $student_id);
                    $deleteUserStudent->bindValue(':user_id', $mainUser['id']);
                    $deleted = $deleteUserStudent->execute();
                    if($deleted){
                        $deleteRequest = $pdo->prepare("DELETE FROM " . DB_PREFIX . "user_request WHERE target_id = :target_id AND user_id = :user_id AND type = :type");
                        $deleteRequest->bindValue(':target_id', $student_id);
                        $deleteRequest->bindValue(':user_id', $mainUser['id']);
                        $deleteRequest->bindValue(':type', UserRequest::TYPE_ADD_USER_STUDENT);
                        $deleteRequest->execute();
                        $sendtext .= self::t($lang_id, 'user_student_deleted');
                    }
                    else{
                        $sendtext .= self::t($lang_id, 'there_was_an_error');
                    }
                }

                $data = [
                    'chat_id'      => $chat_id,
                    'reply_markup' => $keyboard,
                    'text'         => $sendtext,
                ];
                return Request::sendMessage($data);
            }
        	elseif(strpos($text, 'mychildren_view_lessons_') !== false) {
	            $sendtext = '';
                $keyboard = self::getKeyboard($lang_id);

                $lessons = [];
                $errors = [];

                $info = substr($text, mb_strlen('mychildren_view_lessons_'));
                $student = new Student();
                $ids = explode('_', $info);

                if(count($ids) != 2){
                    $errors['data'] = self::t($lang_id, 'there_was_an_error');
                }
                $student_id = (int)$ids[0];
                $subject_id = (int)$ids[1];
                $checkIsStudent = $pdo->prepare("SELECT id FROM " . DB_PREFIX . "user WHERE id = :id AND usergroup = :usergroup");
                $checkIsStudent->bindValue(':id', $student_id);
                $checkIsStudent->bindValue(':usergroup', $student->usergroup);
                $checkIsStudent->execute();
                $found = $student->find($student_id);

	            if($checkIsStudent->rowCount() == 0 || !$found){
                    $errors['student'] = self::t($lang_id, 'student_not_found');
	            }

                $time = time();
                
                $studyPeriod = array();
                $getStudyPeriod = $pdo->prepare("SELECT * FROM " . DB_PREFIX . "study_period WHERE start_time <= :start_time AND end_time >= :end_time ORDER BY id DESC");
                $getStudyPeriod->bindValue(':start_time', $time);
                $getStudyPeriod->bindValue(':end_time', $time);
                $getStudyPeriod->execute();
                if($getStudyPeriod->rowCount() > 0){
                    $studyPeriod = $getStudyPeriod->fetch();
                }

                $group = array();
                $getGroup = $pdo->prepare("SELECT g.id FROM " . DB_PREFIX . "student_to_group s2g LEFT JOIN " . DB_PREFIX . "group g ON s2g.group_id = g.id WHERE s2g.student_id = :student_id");
                $getGroup->bindValue(':student_id', $student_id);
                $getGroup->execute();
                if($getGroup->rowCount() > 0){
                    $group = $getGroup->fetch();
                }

                $subject = array();
                $getSubject = $pdo->prepare("SELECT * FROM " . DB_PREFIX . "subject WHERE id = :id");
                $getSubject->bindValue(':id', $subject_id);
                $getSubject->execute();
                if($getSubject->rowCount() > 0){
                    $subject = $getSubject->fetch();
                }

                if(!$studyPeriod){
                    $errors['period'] = self::t($lang_id, 'study_period_not_found');
                }

                if(!$group){
                    $errors['group'] = self::t($lang_id, 'group_not_found');
                }

                if(!$subject){
                    $errors['subject'] = self::t($lang_id, 'subject_not_found');
                }

	            if(count($errors) == 0){
                    $sendtext .= $subject['name'] . ' - ' . $student->lastname . ' ' . $student->firstname;
                    $sendtext .= "\n";
                    $getLessons = $pdo->prepare("SELECT l.*, sm.mark, sa.attended FROM " . DB_PREFIX . "lesson l LEFT JOIN " . DB_PREFIX . "student_mark sm ON sm.lesson_id = l.id LEFT JOIN " . DB_PREFIX . "student_attendance sa ON sa.lesson_id = l.id WHERE l.group_id = :group_id AND l.subject_id = :subject_id AND l.start_time >= :period_start_time AND l.start_time <= :period_end_time AND sm.student_id = :sm_student_id AND sa.student_id = :sa_student_id ORDER BY l.start_time DESC");
                    $getLessons->bindValue(':group_id', $group['id']);
                    $getLessons->bindValue(':subject_id', $subject['id']);
                    $getLessons->bindValue(':period_start_time', $studyPeriod['start_time']);
                    $getLessons->bindValue(':period_end_time', $studyPeriod['end_time']);
                    $getLessons->bindValue(':sm_student_id', $student_id);
                    $getLessons->bindValue(':sa_student_id', $student_id);
                    $getLessons->execute();
                    if($getLessons->rowCount() > 0){
                        $lessons = $getLessons->fetchAll();
                    }
	            }

                if(count($lessons)){
                    foreach ($lessons as $value) {
                        $sendtext .= date('d-m-Y H:i', $value['start_time']) . ' - ' . (($value['attended']) ? self::t($lang_id, 'student_was_present') : self::t($lang_id, 'student_was_absent')) . ' - ' . self::t($lang_id, 'student_mark') . ': ' . (($value['mark'] > 0) ? $value['mark'] : self::t($lang_id, 'student_no_mark'));
                        $sendtext .= "\n";
                    }
                    $sendtext .= self::t($lang_id, 'last_hometask') . ': ' . ( ($lessons[0]['hometask']) ? $lessons[0]['hometask'] : '-' );
                }
                else{
                    $sendtext = self::t($lang_id, 'lessons_not_found');
                }



	            $data = [
		            'chat_id'      => $chat_id,
		            'reply_markup' => $keyboard,
		            'text'         => $sendtext,
		        ];
		        return Request::sendMessage($data);
	        }

        }

		$sendtext = '';
        $sendStudentsKeyboard = false;
        if(count($myStudents)){
            $sendtext .= self::t($lang_id, 'my_students_quantity') . ': ' . count($myStudents);
            $studentsKeyboard = self::getMystudentsKeyboard($lang_id, $myStudents);
            $sendStudentsKeyboard = true;
        }
        else{
            $sendtext .= self::t($lang_id, 'no_students_added');
        }

        //send main message and keyboard
		$keyboard = self::getKeyboard($lang_id);
        $data = [
            'chat_id'      => $chat_id,
            'reply_markup' => $keyboard,
            'text'         => self::t($lang_id, 'choose_student'),
        ];
        $response = Request::sendMessage($data);

        //send students list inline keyboard
        if($sendStudentsKeyboard){
            $data = [
                'chat_id'       => $chat_id,
                'reply_markup'  => $studentsKeyboard,
                'text'          => $sendtext,
            ];
            Request::sendMessage($data);
        }

        return $response;
    }

    public static function getKeyboard($lang_id)
    {
    	$keyboard = new Keyboard(
            [self::t($lang_id, 'button_my_students'), self::t($lang_id, 'button_add_student')],
            [self::t($lang_id, 'button_delete_student'), self::t($lang_id, 'button_main_page')]
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
        $getGroups->bindValue(':start_year', $startYear);
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
        $getStudents->bindValue(':group_id', $group_id);
        $getStudents->execute();
        if($getStudents->rowCount() > 0){
            $students = $getStudents->fetchAll();
        }
        return $students;
    }

    public static function getMystudentsKeyboard($lang_id, $myStudents, $type = 'view')
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
                    'callback_data' => 'mychildren_' . $type . '_student_id_' . $value['id'],
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

    public static function studentSubjectsKeyboard($lang_id, $student_id)
    {
        $keyboard_buttons = [];
        $subjects = self::getStudentSubjects($student_id);
        if(count($subjects)){
            $startIndex = 0;
            foreach ($subjects as $value) {
                if(isset($keyboard_buttons[$startIndex]) && count($keyboard_buttons[$startIndex]) == 3){
                    $startIndex++;
                }
                if(!array_key_exists($startIndex, $keyboard_buttons)){
                    $keyboard_buttons[$startIndex] = [];
                }
                $keyboard_buttons[$startIndex][] = 
                [
                    'text'          => $value['name'],
                    'callback_data' => 'mychildren_view_lessons_' . $student_id . '_' . $value['id'],
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

    public static function getStudentSubjects($student_id)
    {
        $subjects = [];

        $pdo = DB::getPdo();
        // $model = new Model();
        // $study_start_month = $model->getOption('study_start_month');
        // $start_year = (date('n') >= $study_start_month) ? date('Y') : date('Y') - 1;
        // $end_year = $start_year + 1;

        $time = time();
        
        $studyPeriod = array();
        $getStudyPeriod = $pdo->prepare("SELECT * FROM " . DB_PREFIX . "study_period WHERE start_time <= :start_time AND end_time >= :end_time ORDER BY id DESC");
        $getStudyPeriod->bindValue(':start_time', $time);
        $getStudyPeriod->bindValue(':end_time', $time);
        $getStudyPeriod->execute();
        if($getStudyPeriod->rowCount() > 0){
            $studyPeriod = $getStudyPeriod->fetch();
        }

        $group = array();
        $getGroup = $pdo->prepare("SELECT g.id FROM " . DB_PREFIX . "student_to_group s2g LEFT JOIN " . DB_PREFIX . "group g ON s2g.group_id = g.id WHERE s2g.student_id = :student_id");
        $getGroup->bindValue(':student_id', $student_id);
        $getGroup->execute();
        if($getGroup->rowCount() > 0){
            $group = $getGroup->fetch();
        }

        if($studyPeriod && $group){
            $subjectIds = [];
            $getSubjectIds = $pdo->prepare("SELECT DISTINCT subject_id FROM " . DB_PREFIX . "lesson WHERE group_id = :group_id AND start_time >= :period_start_time AND start_time <= :period_end_time");
            $getSubjectIds->bindValue(':group_id', $group['id']);
            $getSubjectIds->bindValue(':period_start_time', $studyPeriod['start_time']);
            $getSubjectIds->bindValue(':period_end_time', $studyPeriod['end_time']);
            $getSubjectIds->execute();
            if($getSubjectIds->rowCount() > 0){
                $getSubjectIds = $getSubjectIds->fetchAll();
                foreach ($getSubjectIds as $value) {
                    $subjectIds[] = $value['subject_id'];
                }
            }


            if(count($subjectIds)){
                $getSubjects = $pdo->prepare("SELECT * FROM " . DB_PREFIX . "subject WHERE id IN (" . implode(',', $subjectIds) . ")");
                $getSubjects->execute();
                if($getSubjects->rowCount() > 0){
                    $subjects = $getSubjects->fetchAll();
                }
            }
        }

        return $subjects;
    }

}