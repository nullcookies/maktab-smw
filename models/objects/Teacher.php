<?php

namespace models\objects;

use \system\ActiveRecord;
use SQLBuilder\ArgumentArray;
use SQLBuilder\Bind;
use SQLBuilder\ParamMarker;
use SQLBuilder\Criteria;
use SQLBuilder\Driver\MySQLDriver;
use SQLBuilder\Universal\Query\SelectQuery;
use SQLBuilder\Universal\Query\InsertQuery;
use SQLBuilder\Universal\Query\UpdateQuery;
use SQLBuilder\Universal\Query\DeleteQuery;

class Teacher extends User{

	public $tableName = 'user';

	public function __construct()
	{
		parent::__construct();
		$this->usergroup = 5;
	}

	// public function find($id)
 //    {
 //    	parent::find($id);

 //    	$args = new ArgumentArray;

	// 	// $query = new InsertQuery;
	// 	// $query->insert([ 'name' => new Bind('name', 'John'), 'confirmed' => new Bind('confirmed', true) ])->into('users');
	// 	// $query->returning('id');
	// 	// $sql = $query->toSql($driver, $args);

	// 	// var_dump($sql);
	// 	// var_dump((array)$args);

	// 	$query = new SelectQuery;
	// 	$query->select('*')
	// 	    ->from(DB_PREFIX . 'teacher_to_group')
	// 	    ->where()
	// 	    ->equal('teacher_id', new Bind('teacher_id', $this->id));
	// 	$sql = $query->toSql($this->driver, $args);

	// 	var_dump($sql);
	// 	var_dump((array)$args);
 //    }
}
