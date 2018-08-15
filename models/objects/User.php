<?php

namespace models\objects;

use \system\ActiveRecord;

class User extends ActiveRecord
{
    
    public function save()
    {
    	if(
    		empty($_SESSION['usergroup']) ||
    		empty($_SESSION['user_id']) ||
    		$this->usergroup < $_SESSION['usergroup'] || 
    		(
    			!empty($this->id) &&
    			$this->usergroup == $_SESSION['usergroup'] && 
    			$this->id != $_SESSION['user_id']
    		) 
    	){
    		exit('Access Error');
    	}
    	
    	parent::save();
    }

}
