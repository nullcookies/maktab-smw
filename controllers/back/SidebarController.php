<?php

namespace controllers\back;

use \system\Controller;
use \models\back\SidebarModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class SidebarController extends Controller {
    
    public function index() {
        $model = new SidebarModel;
        if($model){
            $model->index();
            $this->data = $model->data;
        }
        $this->content = $this->render('sidebar');
    }
    
}