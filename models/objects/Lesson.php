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

class Lesson extends ActiveRecord{
	
	public function find($id, $secure = true)
    {
    	$found = parent::find($id, $secure);
    	
    	$this->students = [];

	    	
        if($found){

        	//find students
        	$args = new ArgumentArray;
			$query = new SelectQuery;
			$query->select('u.id')
			    ->from(DB_PREFIX . 'user', 'u')
			    ->where()
			    ->equal('s2g.group_id', new Bind('group_id', $this->group_id));
			$query->join(DB_PREFIX . 'student_to_group')
			        ->as('s2g')
			        ->on('s2g.student_id = u.id')
			    ;
			$sql = $query->toSql($this->driver, $args);
			$sth = $this->db->prepare($sql);
			if($sth !== false){
	        	$result = $sth->execute((array)$args);
				if($result){
					$students = $sth->fetchAll(\PDO::FETCH_ASSOC);
					foreach ($students as $value) {
						$this->students[$value['id']] = [
							'attendance' => '',
							'mark' => '',
						];
					}
				}
	        }

	        //set attendance
	        $args = new ArgumentArray;
	        $query = new SelectQuery;
			$query->select('*')
			    ->from(DB_PREFIX . 'student_attendance')
			    ->where()
			    ->equal('lesson_id', new Bind('lesson_id', $this->id));
			$sql = $query->toSql($this->driver, $args);
			$sth = $this->db->prepare($sql);
			if($sth !== false){
	        	$result = $sth->execute((array)$args);
				if($result){
					$lessonAttendance = $sth->fetchAll(\PDO::FETCH_ASSOC);
					foreach ($lessonAttendance as $value) {
						$this->students[$value['student_id']]['attendance'] = $value['attended'];
					}
				}
	        }

	        //set marks
	        $args = new ArgumentArray;
	        $query = new SelectQuery;
			$query->select('*')
			    ->from(DB_PREFIX . 'student_mark')
			    ->where()
			    ->equal('lesson_id', new Bind('lesson_id', $this->id));
			$sql = $query->toSql($this->driver, $args);
			$sth = $this->db->prepare($sql);
			if($sth !== false){
	        	$result = $sth->execute((array)$args);
				if($result){
					$lessonAttendance = $sth->fetchAll(\PDO::FETCH_ASSOC);
					foreach ($lessonAttendance as $value) {
						$this->students[$value['student_id']]['mark'] = $value['mark'];
					}
				}
	        }

	        //set start time format
        	$this->start_time = date('d-m-Y H:i', $this->start_time);
        }
        

        return $found;
    }
}
