<?php

namespace controllers\front;

use \system\Controller;
use \models\front\HeaderModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class HeaderController extends Controller {
    
    public function index() {
        $model = new HeaderModel;
        $model->index();
        $this->data = $model->data;
        $this->content = $this->render('header');
    }

    public function stock(){
        $model = new HeaderModel;
        $model->stock();
        exit;
    }
    
}