<?php

/**
 * Bts.uz Bot 1.0.0
 *
 * Bts.uz telegram bot
 *
 * Copyright (c) 2017, U Y
 *
 *
*/

define('ENVIRONMENT', 'dev'); // dev, prod

if(ENVIRONMENT == 'dev'){
    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
else{
	ini_set('display_errors', 0);
	error_reporting(0);
}

$botDir = 'tg-bot';

$serverName = 'http' . ((isset($_SERVER['HTTPS'])) ? 's' : '') . '://' . $_SERVER['SERVER_NAME'];
define('BASEPATH', dirname(__DIR__));
define('BOTPATH', BASEPATH . '/' . $botDir);
define('BASEURL', $serverName);
define('BOTURL', $serverName . '/' . $botDir);

//language constants
define('LANG_MAIN', '1');
define('LANG_ID', '1');
define('LANG_PREFIX', 'ru');

require_once(BASEPATH . '/system/Autoloader.php');
require BASEPATH . '/vendor/autoload.php';

$config = require BASEPATH . '/config/config.php';
$telegramConfig = $config['telegram'];


mb_internal_encoding("UTF-8");
date_default_timezone_set($config['timezone']);

$bot_api_key  = $telegramConfig['bot_api_key'];
$bot_username  = $telegramConfig['bot_username'];

// Define all paths for your custom commands in this array (leave as empty array if not used)
$commands_paths = $telegramConfig['commands_paths'];
// Define all IDs of admin users in this array (leave as empty array if not used)
$admin_users = $telegramConfig['admin_users'];

// Enter your MySQL database credentials
$mysql_credentials = $config['db'];
define('DB_PREFIX', $config['db']['prefix']);
define('DB_PREFIX_TGBOT', $config['db']['prefix'] . 'tgbot_');

$botan_token = $telegramConfig['botan_token'];


try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
    // Add commands paths containing your custom commands
    $telegram->addCommandsPaths($commands_paths);
    // Enable admin users
    $telegram->enableAdmins($admin_users);

    // Enable MySQL
    $telegram->enableMySql($mysql_credentials, DB_PREFIX_TGBOT);
    // Logging (Error, Debug and Raw Updates)
    Longman\TelegramBot\TelegramLog::initErrorLog(BOTPATH . "/logs/{$bot_username}_error.log");
    //Longman\TelegramBot\TelegramLog::initDebugLog(BOTPATH . "/logs/{$bot_username}_debug.log");
    //Longman\TelegramBot\TelegramLog::initUpdateLog(BOTPATH . "/logs/{$bot_username}_update.log");
    // If you are using a custom Monolog instance for logging, use this instead of the above
    //Longman\TelegramBot\TelegramLog::initialize($your_external_monolog_instance);
    // Set custom Upload and Download paths
    $telegram->setDownloadPath(BOTPATH . '/Download');
    $telegram->setUploadPath(BOTPATH . '/Upload');
    // Here you can set some command specific parameters
    // e.g. Google geocode/timezone api key for /date command
    //$telegram->setCommandConfig('date', ['google_api_key' => 'your_google_api_key_here']);
    //$telegram->setCommandConfig('weather', ['owm_api_key' => '389dd893796f5b46e8ad03fcfbbd7b46']);
    //$telegram->setCommandConfig('order', ['store_manager_id' => $config['store_manager_id'], 'sales_email' => $config['sales_email'], 'robot_email' => $config['robot_email'], 'sitename' => $config['sitename']]);
    $telegram->setCommandConfig('feedback', ['store_manager_id' => $telegramConfig['store_manager_id'], 'sales_email' => $telegramConfig['sales_email'], 'robot_email' => $telegramConfig['robot_email'], 'sitename' => $config['sitename']]);
    //$telegram->setCommandConfig('mail', ['store_manager_id' => $config['store_manager_id'], 'sales_email' => $config['sales_email'], 'robot_email' => $config['robot_email'], 'sitename' => $config['sitename']]);
    // Botan.io integration
    //$telegram->enableBotan($botan_token);
    // Requests Limiter (tries to prevent reaching Telegram API limits)
    $telegram->enableLimiter();

    // Handle telegram webhook request
    $telegram->handle();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    //echo $e;
    // Log telegram errors
    Longman\TelegramBot\TelegramLog::error($e);
} catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
    // Silence is golden!
    // Uncomment this to catch log initialisation errors
    //echo $e;
}

