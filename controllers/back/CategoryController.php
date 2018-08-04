<?php

namespace controllers\back;

use \system\Controller;
use \models\back\CategoryModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class CategoryController extends Controller {

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
        $model = new CategoryModel;

        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('category-list');
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

        $model = new CategoryModel;
        $viewFile = 'category-add';
        if($model){
            if(isset($_POST['btn_add'])){
                if($model){
                    $result = $model->save(true);
                }
            }
            if($result){
                $model->index();
                $viewFile = 'category-list';
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

        $model = new CategoryModel;

        $viewFile = 'category-edit';
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
                $viewFile = 'category-list';
            }
            else{
                $model->edit();
            }
        
            $this->data = $model->data;
            $this->document = $model->document;
        }

        $this->content = $this->render($viewFile);
        
    }

    public function deleteConfirm() {	
        
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

        $model = new CategoryModel;

        $viewFile = 'category-delete-confirm';
        if($model){
            
            $model->deleteConfirm();
    
            $this->data = $model->data;
            $this->document = $model->document;
        }

        $this->content = $this->render($viewFile);
        
    }

    public function toggle() {
        $model = new CategoryModel;
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
        
        $model = new CategoryModel;
        if($model){
            $id = (int)$_GET['param1'];
            if($id){
                $resultDelete = $model->delete();
            }
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('category-list');
    }


    
    public function addType(){
        
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

        $model = new CategoryModel;
        $viewFile = 'category-type-add';
        if($model){
            if(isset($_POST['btn_add'])){
                if($model){
                    $result = $model->saveType(true);
                }
            }
            if($result){
                $model->index();
                $viewFile = 'category-list';
            }
            else{
                $model->addType();
            }

            $this->data = $model->data;
            $this->document = $model->document;
        }
        
        $this->content = $this->render($viewFile);

    }
    
    public function editType() {    
        
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

        $model = new CategoryModel;

        $viewFile = 'category-type-edit';
        if($model){
            if(isset($_POST['btn_edit'])){
                $id = (int)$_POST['id'];
                if(!$id){
                    $this->index();
                    return;
                }
                $result = $model->saveType();
            }
            if($result){
                $model->index();
                $viewFile = 'category-list';
            }
            else{
                $model->editType();
            }
        
            $this->data = $model->data;
            $this->document = $model->document;
        }

        $this->content = $this->render($viewFile);
        
    }

    public function toggleType() {
        $model = new CategoryModel;
        $this->content = $model->toggleType();
    }

    public function deleteType() {
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
        
        $model = new CategoryModel;
        if($model){
            $id = (int)$_GET['param1'];
            if($id){
                $resultDelete = $model->deleteType();
            }
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('category-list');
    }
    

    
}


