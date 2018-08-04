<?php

namespace controllers\back;

use \system\Controller;
use \models\back\FileModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class FileController extends Controller {

    public function upload() {

        $model = new FileModel;
        if($model){
            $param1 = $_GET['param1'];

            $param2 = '';
            if($_GET['param2']){
                $param2 = preg_replace('#[^a-z0-9]#', '', strtolower($_GET['param2']));
            }
            if(!$param2){
                $param2 = 'file';
            }
            $model->path = $param2;
            if($param1 == 'image'){
                $model->uploadImage();
            }
            elseif($param1 == 'video'){
                $model->uploadVideo();
            }
            elseif($param1 == 'pdf'){
                $model->uploadPdf();
            }
            $this->data = $model->data;
        }
        $this->json($this->data);
    }

    public function delete() {
        
        $model = new FileModel;
        if($model){
            $model->delete();
            $this->data = $model->data;
        }
        $this->json($this->data);
    }

    public function sort() {
        
        $model = new FileModel;
        if($model){
            $model->sort();
            $this->data = $model->data;
        }
        $this->json($this->data);
    }

    
    
    
}


