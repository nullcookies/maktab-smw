<?php

namespace models\objects;

use \system\ActiveRecord;

class User extends ActiveRecord
{
    
    public function save()
    {
    	if($this->usergroup < $_SESSION['usergroup'] || ($this->usergroup == $_SESSION['usergroup'] && $this->id != $_SESSION['userid']) ){
    		exit('Access Error');
    	}
    	
    	parent::save();
    }

}
