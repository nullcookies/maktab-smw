<?php

namespace controllers\back;

use \system\Controller;
use \models\back\GalleryModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class GalleryController extends Controller {

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
        $model = new GalleryModel;

        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('gallery-list');
    }

    public function list_ajax() {
        $model = new GalleryModel;

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

        $model = new GalleryModel;
        $viewFile = 'gallery-add';
        $model->add();

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

        $model = new GalleryModel;

        $viewFile = 'gallery-edit';
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
            $viewFile = 'gallery-list';
        }
        else{
            $model->edit();
        }
    
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render($viewFile);
        
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
        
        $model = new GalleryModel;
        if($model){
            $id = (int)$_GET['param1'];
            if($id){
                $resultDelete = $model->delete();
            }
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('gallery-list');
    }
    
}


