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
		
        if($text == 'contacts'){

            $keyboard = StartCommand::getKeyboard($lang_id);

            $sendtext =     self::t($lang_id, 'our_contacts') . "\n";
            $sendtext .=    self::t($lang_id, 'phone') . ': ' . '00-000-00-00' . "\n";
            $sendtext .=    self::t($lang_id, 'email') . ': ' . 'info@domain.uz' . "\n";
            $sendtext .=    self::t($lang_id, 'site') . ': ' . 'www.domain.uz';
        }
        elseif($text == 'school_schedule'){
            $model = new Model();
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