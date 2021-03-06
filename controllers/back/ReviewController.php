<?php

namespace controllers\back;

use \system\Controller;
use \models\back\ReviewModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class ReviewController extends Controller {

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
        $model = new ReviewModel;

        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('review-list');
    }
    
    /*
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

        $model = new ReviewModel;
        $viewFile = 'review-add';
        if($model){
            if(isset($_POST['btn_add'])){
                if($model){
                    $result = $model->save(true);
                }
            }
            if($result){
                $model->index();
                $viewFile = 'review-list';
            }
            else{
                $model->add();
            }

            $this->data = $model->data;
            $this->document = $model->document;
        }
        
        $this->content = $this->render($viewFile);

    }
    */
    
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

        $model = new ReviewModel;

        $viewFile = 'review-edit';
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
                $viewFile = 'review-list';
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
        $model = new ReviewModel;
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
        
        $model = new ReviewModel;
        if($model){
            $id = (int)$_GET['param1'];
            if($id){
                $resultDelete = $model->delete();
            }
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('review-list');
    }
    

    
}


