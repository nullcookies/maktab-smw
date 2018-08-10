<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Object {
	
	protected $config;
    protected $db;
	
	public function __construct() {
		
		$config = include(BASEPATH . '/config/config.php');
		if(!$config){
            exit('Set configuration file Component');
        }
        $this->config = $config;
        $this->db = DataBase::getInstance($this->config['db']);
	}

    public function fromCamelCase($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    public function ppp($var, $exit = false, $mode = 1) {
        echo '<pre>';
        if($mode == 1){
            var_dump($var);
        }
        elseif($mode == 2){
            print_r($var);
        }
        echo '</pre>';
        if($exit){
            exit;
        }
    }
    
    protected function hashPassword($password) {
        return md5($this->config['params']['salt'] . $password);
    }
}
