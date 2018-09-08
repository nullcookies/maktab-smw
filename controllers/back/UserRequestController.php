<?php

namespace controllers\back;

use \system\Controller;
use \models\back\UserRequestModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class UserRequestController extends Controller {
    
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
        $model = new UserRequestModel;

        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('user-request-list');
    }

    public function list_ajax() {
        $model = new UserRequestModel;

        $model->list_ajax();
        $this->data = $model->data;
        $this->json($this->data);
    }

    public function toggle() {
        $model = new UserRequestModel;
        $model->toggle();
        $this->data = $model->data;
        if($this->isAjax()){
            $this->json($this->data);
        }
    }

}
