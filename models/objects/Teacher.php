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

	public function find($id, $secure = true)
    {
    	$found = parent::find($id, $secure);

    	if($found){

    		$args = new ArgumentArray;

	    	$this->group_id = [];
			$query = new SelectQuery;
			$query->select('*')
			    ->from(DB_PREFIX . 'teacher_to_group')
			    ->where()
			    ->equal('teacher_id', new Bind('teacher_id', $this->id));
			$sql = $query->toSql($this->driver, $args);
			$sth = $this->db->prepare($sql);
			if($sth !== false){
	        	$result = $sth->execute((array)$args);
				if($result){
					$teacherToGroup = $sth->fetchAll(\PDO::FETCH_ASSOC);
					foreach ($teacherToGroup as $value) {
						$this->group_id[] = $value['group_id'];
					}
				}
	        }

	        $this->subject_id = [];
	        $query = new SelectQuery;
	        $query->select('*')
			    ->from(DB_PREFIX . 'subject_to_teacher')
			    ->where()
			    ->equal('teacher_id', new Bind('teacher_id', $this->id));
			$sql = $query->toSql($this->driver, $args);
			$sth = $this->db->prepare($sql);
			if($sth !== false){
	        	$result = $sth->execute((array)$args);
				if($result){
					$subjectToTeacher = $sth->fetchAll(\PDO::FETCH_ASSOC);
					foreach ($subjectToTeacher as $value) {
						$this->subject_id[] = $value['subject_id'];
					}
				}
	        }

	        $this->icon = $this->linker->getIcon($this->media->resize($this->image, 150, 150));

	        // set date birth
	        // set in parent (User class)
        	// $this->date_birth = date('d-m-Y', $this->date_birth);
    	}

        return $found;
    }
}
