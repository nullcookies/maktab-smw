<?php

namespace controllers\back;

use \system\Controller;
use \models\back\HeaderModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class HeaderController extends Controller {
    
    public function index() {
        $model = new HeaderModel;
        if($model){
            $model->index();
            $this->data = $model->data;
        }
        $this->content = $this->render('header');
    }
    
}