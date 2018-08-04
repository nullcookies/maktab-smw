<?php

defined('BASEPATH') OR exit('No direct script access allowed');

return [
    'sitename' => 'Smartweb',
    'sitenameShort' => 'SW',
    'timezone' => 'Asia/Tashkent',
    'db' => include(BASEPATH. '/config/db.php'),
    'params' => include(BASEPATH. '/config/params.php'),
    'alias' => include(BASEPATH. '/config/alias.php'),
    'routes' => include(BASEPATH. '/config/routes.php'),
    'prettyUrl' => true,
    'adminAccess' => 'admin',
    'developer' => 'Ulugbek',
    'developerEmail' => 'ulugbek.yu@gmail.com',
    'synchronized' => true,
    'synchUploads' => 'http://domain.uz/uploads/',
    'synchApi' => 'http://domain.uz/api/',
    'synchApiKey' => '', //same between synchronized sites, (string)1234567890123456789012
    'synchKey' => '', //unique for each site, (string)09876543210987654321098
    'external_site' => 'http://domain.uz/',
    'paycom' => [
        'merchant_id' => '',
        'keyFile' => BASEPATH . '/config/password.paycom'
    ]
];