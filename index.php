<?php

/**
 * SmartWeb 2.1.0
 *
 * An open source application development framework for PHP
 *
 * Copyright (c) 2017, U Y
 *
 *
*/
$time_start = microtime(true);

if(isset($_COOKIE['developer'])){
	define('ENVIRONMENT', 'dev'); // dev, prod
}
else{
	define('ENVIRONMENT', 'dev'); // dev, prod
}

if(ENVIRONMENT == 'dev'){
	ini_set('display_errors', 1);
	//error_reporting(E_ALL);
}
else{
	ini_set('display_errors', 0);
	//error_reporting(0);
}

$serverName = 'http' . ((isset($_SERVER['HTTPS'])) ? 's' : '') . '://' . $_SERVER['SERVER_NAME'];
define('BASEPATH', $_SERVER['DOCUMENT_ROOT']);
define('BASEURL', $serverName);

require_once(BASEPATH . '/system/Autoloader.php');
if(file_exists(__DIR__ . '/vendor/autoload.php')){
	require __DIR__ . '/vendor/autoload.php';
}


(new system\SmartWeb())->run();

$time_end = microtime(true);
$time = round($time_end - $time_start, 3);
//echo "Время выполнения: $time секунд\n";
