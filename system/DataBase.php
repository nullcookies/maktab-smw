<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class DataBase {
	
    private static $_instance;

    private $query;

    private $pdo;
    public $prefix;

    public static function getInstance($params = []) {

        if (self::$_instance === null) {
            self::$_instance = new self($params);
        }

        return self::$_instance;
    }

	private function __construct($params) { 
        if(!$params){
            echo 'DB params Error';
            exit;
        }

        try {
            $this->pdo = new \PDO($params['dsn'], $params['username'], $params['password']);
            $this->pdo->exec("set names utf8");
        } catch (PDOException $e) {
            echo 'Error DB: ' . $e->getMessage() . '<br>';
            //echo 'Error DB: ' . $e->getTraceAsString();
            exit();
        }
        $this->prefix = $params['prefix'];
	}

    public function prepare($statement, $driver_options = []) {
        $statement = $this->replacePrefix($statement);
        return $this->pdo->prepare($statement, $driver_options);
    }

    public function query($statement) {
        $statement = $this->replacePrefix($statement);
        return $this->pdo->query($statement);
    }

    public function lastInsertId($name = NULL){
        return $this->pdo->lastInsertId($name);
    }

    private function replacePrefix($statement) {
        return str_replace('??', $this->prefix, $statement);
    }
	
    private function __clone() {
    }
   
    private function __wakeup() {

    }
	
	public function __destruct() {
        $this->pdo = null;
		self::$_instance = null;
	}
	
}

