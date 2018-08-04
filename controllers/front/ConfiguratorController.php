<?php

namespace controllers\front;

use \system\Controller;
use \models\front\ConfiguratorModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class ConfiguratorController extends Controller {

    public function index() {
        $this->modules = [
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
            ],
            [
                'side' => 'front',
                'controller' => 'mainMenu',
                'action' => 'index',
                'position' => 'left'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'side',
                'position' => 'left'
            ]
        ];
        $model = new ConfiguratorModel;
        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        //$this->content = $this->render('configurator');
    }

    public function view() {
        $this->modules = [
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
            ],
            [
                'side' => 'front',
                'controller' => 'mainMenu',
                'action' => 'index',
                'position' => 'left'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'side',
                'position' => 'left'
            ]
        ];
        $model = new ConfiguratorModel;
        if($model){
            $model->view();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('configurator-single');
    }

}


