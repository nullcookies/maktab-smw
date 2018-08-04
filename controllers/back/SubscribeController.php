<?php

namespace controllers\back;

use \system\Controller;
use \models\back\SubscribeModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class SubscribeController extends Controller {

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
        $model = new SubscribeModel;

        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('subscribe-list');
    }

    public function list_ajax() {
        $model = new SubscribeModel;

        if($model){
            $model->list_ajax();
            $this->data = $model->data;
        }
        $this->json($this->data);
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

        $model = new SubscribeModel;
        $viewFile = 'subscribe-add';
        
        if(isset($_POST['btn_add'])){
            $result = $model->save(true);
        }
        if($result){
            //$model->edit($model->productId);
            //$viewFile = 'subscribe-edit';
            $model->index();
            $viewFile = 'subscribe-list';
        }
        else{
            $model->add();
        }

        $this->data = $model->data;
        $this->document = $model->document;

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

        $model = new SubscribeModel;

        $viewFile = 'subscribe-edit';
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
            $viewFile = 'subscribe-list';
        }
        else{
            $model->edit();
        }
    
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render($viewFile);
        
    }

    public function toggle() {
        $model = new SubscribeModel;
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
        
        $model = new SubscribeModel;
        if($model){
            $id = (int)$_GET['param1'];
            if($id){
                $resultDelete = $model->delete();
            }
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('subscribe-list');
    }
    
}


