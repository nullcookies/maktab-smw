<?php

namespace models\objects;

use \system\ActiveRecord;

class Student extends User{

	public $tableName = 'user';

	public function __construct()
	{
		parent::__construct();
		$this->usergroup = 11;
	}

	public function find($id)
    {
    	$found = parent::find($id);
    	if($found){
    		$this->testProp = 'test';
    	}
    	return $found;
    }
}
