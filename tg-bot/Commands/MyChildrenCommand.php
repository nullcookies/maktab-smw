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





		// if(strpos($text, 'group_') !== false) {
  //           $region_id = (int)substr($text, mb_strlen('group_'));
  //           $sendtext = self::getGroups($region_id, $lang_id);
  //           $keyboard = StartCommand::getKeyboard($lang_id);
  //       }
  //       else{
  //           $sendtext = self::t($lang_id, 'contact_page_text') . "\n";
  //           $keyboard = self::getInlineKeyboard($lang_id);
  //       }

        

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
        	//запрос изменения пароля
	        if(stripos($text, 'add_children') === 0){
	            //self::getGroups($user_id);
	            $sendtext = 'test';
	            $keyboard = self::getInlineKeyboard($lang_id);
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
			$sendtext .= self::t($lang_id, 'children_quantity') . ': ' . count($myStudents);
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
            [self::t($lang_id, 'button_add_children'), self::t($lang_id, 'button_main_page')]
        );
        $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(false)
            ->setSelective(false);
        return $keyboard;
    }

    public static function chooseGroupKeyboard($lang_id)
    {
    	$keyboard = new InlineKeyboard(
    		[['text' => 'group 1', 'callback_data' => 'group_1'], ['text' => 'group 2', 'callback_data' => 'group_2']],
    		[['text' => 'group 3', 'callback_data' => 'group_3'], ['text' => 'group 4', 'callback_data' => 'group_4']],
    		[['text' => 'group 5', 'callback_data' => 'group_5'], ['text' => 'group 6', 'callback_data' => 'group_6']]
    	);
    	return $keyboard;

        $keyboard_buttons = [];
        $groups = self::getGroups($lang_id);
        foreach ($regions as $value) {
            $keyboard_buttons[] = [new InlineKeyboardButton(
                [
                    'text'          => $value['content'],
                    'callback_data' => 'region_' . $value['id'],
                ]
            )];
        }
        
        
        if(version_compare(PHP_VERSION, '5.6.0', '>=')){
            $keyboard = new InlineKeyboard(...$keyboard_buttons);
        } else {
            $reflect  = new \ReflectionClass('Longman\TelegramBot\Entities\InlineKeyboard');
            $keyboard = $reflect->newInstanceArgs($keyboard_buttons);
        }
        
        
        return $keyboard;
    }

    public static function getRegionText($id, $lang_id)
    {
    	$region = self::getRegion($id, $lang_id);
    	$regionText = strtoupper($region['content']) . "\n";
    	$offices  = self::getOffices($id, $lang_id);
    	if($offices){
    		foreach($offices as $value){
                file_put_contents('ppp.txt', $value['content']);
    			$value['content'] = json_decode($value['content'], true);
    			foreach ($value['content'] as $key1 => $value1) {
    				$regionText .= self::t($lang_id, $key1) . ": " . $value1 . "\n";
    			}
    		}
    		$regionText .= "\n";
	    		
    	}
        return $regionText;
    }

    public static function getOffices($id, $lang_id)
    {
    	//$lang_id = 1;
    	$pdo = DB::getPdo();
        $items = [];
        $getItems = $pdo->query("SELECT * FROM " . TB_INFORMATION . " WHERE parent_id = " . (int)$id . " AND language_id = " . (int)$lang_id . " AND type = 'office' ORDER BY sort_number");
        if($getItems->rowCount() > 0){
            $items = $getItems->fetchAll();
        }
        return $items;
    }

    public static function getRegions($lang_id)
    {
    	//$lang_id = 1;
    	$pdo = DB::getPdo();
        $items = [];
        $getItems = $pdo->query("SELECT * FROM " . TB_INFORMATION . " WHERE type = 'region' AND language_id = " . (int)$lang_id . " ORDER BY sort_number");
        if($getItems->rowCount() > 0){
            $items = $getItems->fetchAll();
        }
        // foreach ($items as $key => $value) {
        // 	$items[$key]['content'] = json_decode($value['content'], true);
        // }
        return $items;
    }

    public static function getRegion($id, $lang_id)
    {
    	//$lang_id = 1;
    	$pdo = DB::getPdo();
        $item = [];
        $getItem = $pdo->query("SELECT * FROM " . TB_INFORMATION . " WHERE type = 'region' AND language_id = " . (int)$lang_id . " AND id = " . (int)$id);
        if($getItem->rowCount() > 0){
            $item = $getItem->fetch();
        }
        return $item;
    }
}