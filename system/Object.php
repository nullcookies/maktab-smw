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

    public function generatePassword($length = 8, $add_dashes = false, $available_sets = 'lud')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }
    
    public function hashPassword($password)
    {
        return md5($this->config['params']['salt'] . $password);
    }
}
