<?php

namespace controllers\front;

use \system\Controller;
use \models\front\FooterModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class FooterController extends Controller {

    public function index() {
        $model = new FooterModel;
        if($model){
            $model->index();
            $this->data = $model->data;
        }
        $this->content = $this->render('footer');
    }
    
}