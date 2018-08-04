<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class DownloadModel extends Model {
    
    public function getFile(){
        $id = (int)$_GET['param1'];
        $file = $this->qb->where('id', '?')->get('??file', [$id])->fetch();
        if($file){
            $file['path'] = BASEPATH . '/uploads/' . $file['path'];
        }
        else{
            $file = false;
        }
        return $file;
    }
}



