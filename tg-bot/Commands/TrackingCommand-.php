<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\KeyboardButton;
use Longman\TelegramBot\Entities\PhotoSize;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\DB;

use Longman\TelegramBot\Commands\SystemCommands\StartCommand;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * User "/survey" command
 *
 * Command that demonstrated the Conversation funtionality in form of a simple survey.
 */
class TrackingCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'tracking';

    /**
     * @var string
     */
    protected $description = 'Tracking';

    /**
     * @var string
     */
    protected $usage = '/tracking';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * @var bool
     */
    protected $need_mysql = true;

    /**
     * @var bool
     */
    protected $private_only = true;

    /**
     * Conversation Object
     *
     * @var \Longman\TelegramBot\Conversation
     */
    protected $conversation;

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();


        $chat    = $message->getChat();
        $user    = $message->getFrom();
        $text    = trim($message->getText(true));
        $chat_id = $chat->getId();
        $user_id = $user->getId();

        $lang_id = StartCommand::getLanguage($user_id);

        //Preparing Response
        $data = [
            'chat_id' => $chat_id,
        ];

        //Conversation start
        $this->conversation = new Conversation($user_id, $chat_id, $this->getName());

        $notes = &$this->conversation->notes;
        !is_array($notes) && $notes = [];

        $result = Request::emptyResponse();

        if ($text === self::t($lang_id, 'button_back')) {
            if($notes['state'] > 0){
                $notes['state']--;
            }
            $text = '';
        }

        //cache data from the tracking session if any
        $state = 0;
        if (isset($notes['state'])) {
            $state = $notes['state'];
        }

        //State machine
        //Entrypoint of the machine state if given by the track
        //Every time a step is achieved the track is updated
        //get order details switch
        switch ($state) {
            case 0:
                if ($text === '') {
                    $notes['state'] = 0;
                    $this->conversation->update();

                    $data['text'] = self::t($lang_id, 'choose_action');
                    $data['reply_markup'] = self::getKeyboard($lang_id);

                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['type'] = $text;
                $text = '';

            // no break
            case 1:
                if ($text === '') {
                    $notes['state'] = 1;
                    $this->conversation->update();

                    $keyboardArray = [self::t($lang_id, 'button_back')];

                    if($notes['type'] == self::t($lang_id, 'phone_number')){
                        $data['text'] = self::t($lang_id, 'enter_tracking_phone_number');
                        $user = StartCommand::getUser($user_id);
                        if($user['phone'] != ''){
                            array_unshift($keyboardArray, $user['phone']);
                        }
                    }
                    else{
                        $data['text'] = self::t($lang_id, 'enter_tracking_barcode');
                    }
                    
                    
                    $data['reply_markup'] = (new Keyboard(
                        $keyboardArray
                    ))
                        ->setOneTimeKeyboard(false)
                        ->setResizeKeyboard(true)
                        ->setSelective(true);

                    $result = Request::sendMessage($data);
                    break;
                }

                $notes['value'] = $text;
                $text = '';

            // no break
            case 2:
                //TODO: get tracking information
                $message = 'tracking information for: ' . $notes['value'];

                //if tracking info success stop conversation and go to main page
                $data['text'] = $message;
                //$data['reply_markup'] = self::getKeyboard($lang_id);
                $data['reply_markup'] = StartCommand::getKeyboard($lang_id);
                $result = Request::sendMessage($data);

                $notes['state'] = 0;
                $this->conversation->update();
                $this->conversation->stop();

        }

        return $result;
    }

    public static function getKeyboard($lang_id)
    {
        $keyboard = (new Keyboard(
            [self::t($lang_id, 'phone_number'), self::t($lang_id, 'barcode')],
            [self::t($lang_id, 'button_main_page')]
        ))
            ->setOneTimeKeyboard(false)
            ->setResizeKeyboard(true)
            ->setSelective(true);

        return $keyboard;
    } 
}
