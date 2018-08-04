<?php

namespace controllers\front;

use \system\Controller;
use \models\front\BannerModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class BannerController extends Controller {

    public function index() {
        $model = new BannerModel;
        if($model){
            $model->index();
            $this->data = $model->data;
        }
        
        $this->content = $this->render('banner-index');
    }

    public function bottom() {
        $model = new BannerModel;
        if($model){
            $model->bottom();
            $this->data = $model->data;
        }
        
        $this->content = $this->render('banner-bottom');
    }
    
}