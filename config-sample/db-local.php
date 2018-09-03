<?php

$db_config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'dbname' => 'database',
    'charset' => 'utf8',
    'username' => 'root',
    'password' => '',
    'prefix' => 'prefix_',
];

$db_config['dsn'] = $db_config['driver'] . ':host=' . $db_config['host'] . ';dbname=' . $db_config['dbname'] . ';charset=' . $db_config['charset'];
$db_config['database'] = $db_config['dbname'];
$db_config['user'] = $db_config['username'];
$db_config['pass'] = $db_config['password'];

return $db_config;

