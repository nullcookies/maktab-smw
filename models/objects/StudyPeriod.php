<?php

namespace models\objects;

use \system\ActiveRecord;

class StudyPeriod extends ActiveRecord
{
	
	public function find($id, $secure = true)
    {
    	$found = parent::find($id, $secure);	    	
        if($found){

	        //set start time format
        	$this->start_time = date('d-m-Y', $this->start_time);

	        //set end time format
        	$this->end_time = date('d-m-Y', $this->end_time);

        }
        return $found;
    }
	
}
