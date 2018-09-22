<?php

namespace controllers\back;

use \system\Controller;
use \models\back\OptionModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class OptionController extends Controller {

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
        $model = new OptionModel;

        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('option-list');
    }

    public function additional() {   
        
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
        $model = new OptionModel;

        if($model){
            $model->additional();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('option-additional');
    }

    public function fixLangTables() {
        $model = new OptionModel;
        $response = $model->fixLangTables();
        $this->json($response);
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

        $model = new OptionModel;
        $viewFile = 'option-add';
        if($model){
            if(isset($_POST['btn_add'])){
                if($model){
                    $result = $model->save(true);
                }
            }
            if(!empty($result)){
                $model->index();
                $viewFile = 'option-list';
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

        $model = new OptionModel;
        $viewFile = 'option-edit';
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
                $viewFile = 'option-list';
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
        $model = new OptionModel;
        $this->content = $model->toggle();
    }

    public function clean() {
        $model = new OptionModel;
        $result = $model->clean();
        echo (int)$result;
        exit;
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
        
        $model = new OptionModel;
        if($model){
            $id = (int)$_GET['param1'];
            if($id){
                $resultDelete = $model->delete();
            }
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('option-list');
    }
    

    
}


