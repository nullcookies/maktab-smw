<?php

namespace controllers\front;

use \system\Controller;
use \models\front\BottomTextModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class BottomTextController extends Controller {

    public function index() {
        $model = new BottomTextModel;
        if($model){
            $model->index();
            $this->data = $model->data;
        }
        
        $this->content = $this->render('bottom-text');
    }
    
}