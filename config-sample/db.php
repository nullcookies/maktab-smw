<?php

$db_config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'dbname' => 'db',
    'charset' => 'utf8',
    'username' => 'root',
    'password' => '',
    'prefix' => 'prefix_',
];

$db_config['dsn'] = $db_config['driver'] . ':host=' . $db_config['host'] . ';dbname=' . $db_config['dbname'] . ';charset=' . $db_config['charset'];

return $db_config;

