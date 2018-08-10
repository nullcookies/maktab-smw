<?php

namespace system;

use SQLBuilder\ArgumentArray;
use SQLBuilder\Bind;
use SQLBuilder\ParamMarker;
use SQLBuilder\Criteria;
use SQLBuilder\Driver\MySQLDriver;
use SQLBuilder\Universal\Query\SelectQuery;
use SQLBuilder\Universal\Query\InsertQuery;
use SQLBuilder\Universal\Query\UpdateQuery;
use SQLBuilder\Universal\Query\DeleteQuery;

defined('BASEPATH') OR exit('No direct script access allowed');

abstract class ActiveRecord extends Object {
	
	public $tableName;
	public $primaryKey;
	protected $driver;
	protected $fields = [];
	protected $columns = [];
	protected $changedColumns = [];
	
	public function __construct()
	{
		parent::__construct();
		$this->tableName = $this->config['db']['prefix'] . $this->generateTableName();
		$getColumns = $this->db->query('SHOW COLUMNS FROM ' . $this->tableName)->fetchAll();
		foreach ($getColumns as $value) {
			//set column names
			$this->columns[] = $value['Field'];
			
			//set values
			$fieldValue = $value['Default'] ? $value['Default'] : NULL;
			if(NULL === $fieldValue){
				if (strpos($value['Type'], 'tinyint') == 0 || strpos($value['Type'], 'smallint') == 0 || strpos($value['Type'], 'mediumint') == 0 || strpos($value['Type'], 'int') == 0 || strpos($value['Type'], 'bigint') == 0 || strpos($value['Type'], 'decimal') == 0 || strpos($value['Type'], 'float') == 0 || strpos($value['Type'], 'double') == 0 || strpos($value['Type'], 'real') == 0) {
					$fieldValue = 0;
				}
				elseif (strpos($value['Type'], 'boolean') == 0){
					$fieldValue = 0;
				}
				elseif (strpos($value['Type'], 'char') == 0 || strpos($value['Type'], 'varchar') == 0 || strpos($value['Type'], 'tinytext') == 0 || strpos($value['Type'], 'text') == 0 || strpos($value['Type'], 'mediumtext') == 0 || strpos($value['Type'], 'longtext') == 0){
					$fieldValue = '';
				}
				elseif (strpos($value['Type'], 'datetime') == 0){
					$fieldValue = '0000-00-00 00:00:00';
				}
				elseif (strpos($value['Type'], 'date') == 0){
					$fieldValue = $fieldValue = '0000-00-00';
				}
				elseif (strpos($value['Type'], 'timestamp') == 0){
					$fieldValue = 0;
				}
				elseif (strpos($value['Type'], 'time') == 0){
					$fieldValue = '00:00:00';
				}
				elseif (strpos($value['Type'], 'year') == 0){
					$fieldValue = '0000';
				}
			}
			$this->fields[$value['Field']] = $fieldValue;

			//set primary key
			if($value['Key'] == 'PRI'){
				$this->primaryKey = $value['Field'];
			}
		}
		$this->driver = new MySQLDriver;
	}

	public function __set($name, $value) 
    {
    	if (in_array($name, $this->columns)) {
        	$this->fields[$name] = $value;
        }
        else{
        	$this->$name = $value;
        }
    }

    public function __get($name) 
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }
        elseif (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }

    public function setTableName($name)
    {
    	$this->tableName = $name;
    }

    public function generateTableName()
    {
    	return $this->fromCamelCase((new \ReflectionClass($this))->getShortName());
    }

    public function save()
    {
    	$primaryKey = $this->primaryKey;
    	if(!empty($primaryKey)){
    		$primaryKeyValue = $this->$primaryKey;
    		$args = new ArgumentArray;
    		$querySet = [];
		    foreach ($this->fields as $key => $value) {
		    	$querySet[$key] = new Bind($key, $value);
		    }
    		if(!empty($primaryKeyValue)){
    			
    			$query = new UpdateQuery;
			    $query->update($this->tableName);
		        $query->set($querySet);


		        $query->where()
		        	->equal($primaryKey, new Bind($primaryKey, $primaryKeyValue));
    		}
    		else{
    			$query = new InsertQuery;
			    $query->insert($querySet)->into($this->tableName);
    		}
	        $sql = $query->toSql($this->driver, $args);
	        $sth = $this->db->prepare($sql);
	        if($sth !== false){
	        	$this->savedSuccess = $sth->execute((array)$args);
				if(!$this->savedSuccess){
					var_dump($this->db->errorInfo());
					$this->errorInfo = $this->db->errorInfo();
				}
	        }
    	}
    	return $this;
    }

    public function findOne($id)
    {
    	if(!empty($this->primaryKey)){
    		$args = new ArgumentArray;
    		$query = new SelectQuery;
			$query->select('*')
			    ->from($this->tableName)
			    ->where()
			    	->equal($this->primaryKey, new Bind($this->primaryKey, $id));
			$sql = $query->toSql($this->driver, $args);
			$sth = $this->db->prepare($sql);
			if($sth !== false){
	        	$result = $sth->execute((array)$args);
				if($result){
					$this->fields = $sth->fetch(\PDO::FETCH_ASSOC);
				}
	        }
    	}
    	return $this;
    }

    public function test()
    {
    	$driver = new MySQLDriver;
    	$args = new ArgumentArray;

		// $query = new InsertQuery;
		// $query->insert([ 'name' => new Bind('name', 'John'), 'confirmed' => new Bind('confirmed', true) ])->into('users');
		// $query->returning('id');
		// $sql = $query->toSql($driver, $args);

		// var_dump($sql);
		// var_dump((array)$args);

		$query = new SelectQuery;
		$query->select('*')
		    ->from($this->tableName)
		    ->where('u.name LIKE :name', [ ':name' => '%John%' ]);
		$sql = $query->toSql($driver, $args);

		var_dump($sql);
		var_dump((array)$args);
    }

}
