<?php

namespace models\front;

use \system\Model;
use \Paycom\Application;

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = '';
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

class PaymePaymentModel extends Model {

    public function index(){
        $data = [];

        // load configuration
        $paycomConfig = [
            // Get it in merchant's cabinet in cashbox settings
            'merchant_id' => $this->config['paycom']['merchant_id'],

            // Login is always "Paycom"
            'login' => 'Paycom',

            // File with cashbox key (key can be found in cashbox settings)
            'keyFile' => $this->config['paycom']['keyFile'],

            // Your database settings
            'db' => [
                'database' => $this->config['db']['dbname'],
                'username' => $this->config['db']['username'],
                'password' => $this->config['db']['password']
            ],
        ];

        $application = new Application($paycomConfig);
        $application->run();

        $this->data = $data;
        return $this;
    }
    
}



