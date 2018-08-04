<?php

namespace controllers\back;

use \system\Controller;
use \models\back\FooterModel;

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

    public function gallery() {
        $model = new FooterModel;
        if($model){
            $model->gallery();
            $this->data = $model->data;
        }
        $this->content = $this->render('footer-gallery');
    }
    
}