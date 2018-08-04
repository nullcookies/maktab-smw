<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class Option {

    public static $options;
    
    public function __construct(){
        if(self::$options === null){
            $getOptions = $this->db->query('SELECT * FROM ??option');
            if($getOptions->rowCount() > 0){
                $options = $getOptions->fetchAll();
                foreach($options as $value){
                    self::$options[$value['option']] = $value['content'];
                }
            }
        }
        
    }

    public function getOptions() {
        return self::$options;
    }

}
