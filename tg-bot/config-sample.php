<?php

defined('BASEPATH') OR exit('No direct script access allowed');

return [
    'sitename' => 'Tg Bot Name',
    'timezone' => 'Asia/Tashkent',
    'db' => [
        'host' 		=> 'localhost',
        'user' 		=> 'root',
        'password' 	=> '',
        'database' 	=> 'dbname',
        'prefix' 	=> 'prefix_',
    ],		
    'bot_username' => 'TG_BOT_USERNAME',
    'bot_api_key' => 'TG_BOT_APIKEY',
    'commands_paths' => [
        BASEPATH . '/Commands',
    ],
    'admin_users' => [
        (int)USER_ID
    ],
    'store_manager_id' => [
        (int)USER_ID
    ],
    'sales_email' => 'info@domain.uz',
    'robot_email' => 'no-reply@domain.uz',
    'botan_token' => '',
];