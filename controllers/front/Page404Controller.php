<?php

namespace controllers\front;

use \system\Controller;
use \models\front\Page404Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class Page404Controller extends Controller {
	
    public function index() {
        /*$this->modules = [
            [
                'side' => 'front',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'front',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ]
        ];*/
        $model = new Page404Model;
        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }

        $this->header404 = true;
        $this->content = $this->render('page404');
    }

}

