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

class Student extends User{

	public $tableName = 'user';

	public function __construct()
	{
		parent::__construct();
		$this->usergroup = 11;
	}

	public function find($id, $secure = true)
    {
    	$found = parent::find($id, $secure);

    	if($found){
    		$args = new ArgumentArray;

			$query = new SelectQuery;
			$query->select('*')
			    ->from(DB_PREFIX . 'student_to_group')
			    ->where()
			    ->equal('student_id', new Bind('student_id', $this->id));
			$sql = $query->toSql($this->driver, $args);
			$sth = $this->db->prepare($sql);
			if($sth !== false){
	        	$result = $sth->execute((array)$args);
				if($result){
					$studentToGroup = $sth->fetch(\PDO::FETCH_ASSOC);
					$this->group_id = $studentToGroup['group_id'];
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
