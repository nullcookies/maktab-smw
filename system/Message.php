<?php

class Message {
	
	private $data;
	
	public function __construct($file = false) {

        if(!$file) $file = dirname(__DIR__) . "/config/messages.ini";
        if(!file_exists($file)) file_put_contents($file, "");
        $this->data = parse_ini_file($file);
	}
	
	public function get($name) {
		return $this->data[$name];
	}
	
}

