<?php

namespace controllers\front;

use \system\Controller;
use \models\front\MainMenuModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class MainMenuController extends Controller {

    public function index() {
        $model = new MainMenuModel;
        if($model){
            $model->index();
            $this->data = $model->data;
        }
        
        $this->content = $this->render('main-menu');
    }
    
}