<?php

namespace models\objects;

use \system\ActiveRecord;

class User extends ActiveRecord
{
    protected $secureAssignColumns = ['password'];
    
    public function save($secure = true)
    {
    	if(
            $secure &&
        	(
                empty($_SESSION['usergroup']) ||
                empty($_SESSION['user_id']) ||
                $this->usergroup < $_SESSION['usergroup'] || 
                (
                    !empty($this->id) &&
                    $this->usergroup == $_SESSION['usergroup'] && 
                    $this->id != $_SESSION['user_id']
                ) 
            )
    	){
    		exit('Access Error');
    	}
    	
    	parent::save();
    }

	public function find($id, $secure = true)
    {
    	$found = parent::find($id, $secure);

    	if($found){

	        $this->icon = $this->linker->getIcon($this->media->resize($this->image, 150, 150));

	        //set date birth
        	$this->date_birth = date('d-m-Y', $this->date_birth);
    	}

        return $found;
    }

}
