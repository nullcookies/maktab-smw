<?php

namespace models\objects;

use \system\ActiveRecord;

class Teacher extends User{

	public $tableName = 'user';

	public function __construct()
	{
		parent::__construct();
		$this->usergroup = 5;
	}
}
