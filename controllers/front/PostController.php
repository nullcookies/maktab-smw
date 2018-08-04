<?php

namespace controllers\front;

use \system\Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class PostController extends Controller {

    public $name;
    public $modelName;

    public function __construct(){
        parent::__construct();
        $this->name = 'post';
        $this->modelName = '\\models\\front\\' . ucfirst($this->name) . 'Model';
    }

    public function index() {

        
        $model = new $this->modelName;
        if($model){
            $result = $model->index();
            if(false === $result){
                $this->header404 = true;
            }
            $this->data = $model->data;
            $this->document = $model->document;
        }
        else{
            $this->header404 = true;
        }

        if(isset($this->header404) && true === $this->header404){
            $template = 'page404';
        }
        else{
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
                ]
            ];
            $template = $this->name;
        }

        $this->content = $this->render($template);
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
            ]
        ];
        $model = new $this->modelName;
        if($model){
            $result = $model->view();
            if(!$result){
                $this->header404 = true;
            }
            $this->data = $model->data;
            $this->document = $model->document;
        }
        else{
            $this->header404 = true;
        }
        $this->content = $this->render($this->name . '-single');
    }

}


