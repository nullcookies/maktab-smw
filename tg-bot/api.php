<?php

/**
 * Bts.uz Bot API
 *
 *
*/

define('ENVIRONMENT', 'dev'); // dev, prod

if(ENVIRONMENT == 'dev'){
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
else{
	ini_set('display_errors', 0);
	error_reporting(0);
}

$serverName = 'http' . ((isset($_SERVER['HTTPS'])) ? 's' : '') . '://' . $_SERVER['SERVER_NAME'];
define('BASEPATH', dirname(__DIR__));
define('BASEURL', $serverName);
define('BOTURL', $serverName . '/tg-bot');

require BASEPATH . '/vendor/autoload.php';
require BASEPATH . 'tg-bot//ApiClass.php';

$config = require BASEPATH . '/config.php';
$telegramConfig = $config['telegram'];

mb_internal_encoding("UTF-8");

$bot_api_key  = $telegramConfig['bot_api_key'];
$bot_username  = $telegramConfig['bot_username'];

$mysql_credentials = $config['db'];

$api = new \InterIntellect\TelegramBot\Api($config);
$api->handle();
