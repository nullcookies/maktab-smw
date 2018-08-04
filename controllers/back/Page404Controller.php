<?php

namespace controllers\back;

use \system\Controller;
use \models\back\Page404Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class Page404Controller extends Controller {
	
    public function index() {
        $this->modules = [
            [
                'side' => 'back',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'back',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'back',
                'controller' => 'sidebar',
                'action' => 'index',
                'position' => 'sidebar'
            ]
        ];
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

