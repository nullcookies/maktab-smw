<?php

namespace controllers\front;

use \system\Controller;
use \models\front\TopSliderModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class TopSliderController extends Controller {

    public function index() {
        $model = new TopSliderModel;
        if($model){
            $model->index();
            $this->data = $model->data;
        }
        
        $this->content = $this->render('topslider');
    }
    
}