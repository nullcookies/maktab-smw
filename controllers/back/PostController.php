<?php

namespace controllers\back;

use \system\Controller;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

abstract class PostController extends Controller {

    public $model = '\models\back\PostModel';

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
        $model = new $this->model;

        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render($model->name . '-list');
    }
    
    public function add(){
        
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

        $model = new $this->model;
        $viewFile = $model->name . '-add';
        if($model){
            if(isset($_POST['btn_add'])){
                if($model){
                    $result = $model->save(true);
                }
            }
            if($result){
                $model->index();
                $viewFile = $model->name . '-list';
            }
            else{
                $model->add();
            }

            $this->data = $model->data;
            $this->document = $model->document;
        }
        
        $this->content = $this->render($viewFile);

    }
    
    public function edit() {	
        
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

        $model = new $this->model;
        
        $viewFile = $model->name . '-edit';
        if($model){
            if(isset($_POST['btn_edit'])){
                $id = (int)$_POST['id'];
                if(!$id){
                    $this->index();
                    return;
                }
                $result = $model->save();
            }
            if($result){
                $model->index();
                $viewFile = $model->name . '-list';
            }
            else{
                $model->edit();
            }
        
            $this->data = $model->data;
            $this->document = $model->document;
        }

        $this->content = $this->render($viewFile);
        
    }

    public function toggle() {
        $model = new $this->model;
        $this->content = $model->toggle();
    }

    public function delete() {
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
        
        $model = new $this->model;
        if($model){
            $id = (int)$_GET['param1'];
            if($id){
                $resultDelete = $model->delete();
            }
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render($model->name . '-list');
    }
    

    
}


