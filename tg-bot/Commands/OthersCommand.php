<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\DB;

use Longman\TelegramBot\Commands\SystemCommands\StartCommand;
use \system\Model;

class OthersCommand extends UserCommand
{
    protected $name = 'others';
    protected $description = 'Прочее.';
    protected $usage = '/others';
    protected $version = '1.0.0';

    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $user_id = $message->getFrom()->getId();
        $text    = trim($message->getText(true));
        
        $lang_id = StartCommand::getLanguage($user_id);

        $keyboard = StartCommand::getOthersKeyboard($lang_id);

        $model = new Model();
		
        if($text == 'contacts'){

            $keyboard = StartCommand::getKeyboard($lang_id);

            $phone1 = $model->getOption('phone1');
            $phone2 = $model->getOption('phone2');
            $contact_mail = $model->getOption('contact_mail');
            $address = $model->getOption('address');

            $sendtext =     self::t($lang_id, 'our_contacts') . "\n";
            $sendtext .=    self::t($lang_id, 'phone') . ': ' . $phone1 . "\n";
            $sendtext .=    self::t($lang_id, 'phone') . ': ' . $phone2 . "\n";
            $sendtext .=    self::t($lang_id, 'email') . ': ' . $contact_mail . "\n";
            // $sendtext .=    self::t($lang_id, 'site') . ': ' . 'www.domain.uz';
            $sendtext .=    self::t($lang_id, 'address') . ': ' . $address;
        }
        elseif($text == 'school_schedule'){
            
            $scheduleFile = $model->getOption('school_schedule_file');
            $scheduleFileUrl = $model->linker->getIcon($scheduleFile);

        	$keyboard = StartCommand::getOthersKeyboard($lang_id);
            $resp = Request::sendPhoto([
                'chat_id' => $chat_id,
                'photo' => $scheduleFileUrl,
                'reply_markup' => $keyboard
            ]);

             return $resp;
        }
        else{
            $sendtext = self::t($lang_id, 'choose_action');
        }
		
		
        
        $data = [
            'chat_id'      => $chat_id,
            'reply_markup' => $keyboard,
            'text'         => $sendtext,
        ];

        return Request::sendMessage($data);
    }
}