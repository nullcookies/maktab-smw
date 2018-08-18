<?php

namespace controllers\back;

use \system\Controller;
use \models\back\StudentModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class StudentController extends Controller {
    
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
        $model = new StudentModel;

        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('student-list');
    }

    public function list_ajax() {
        $model = new StudentModel;

        $model->list_ajax();
        $this->data = $model->data;
            
        $this->json($this->data);
    }
    
    public function view() {    
        
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

        $model = new StudentModel;

        $viewFile = 'student-view';
        
        if(isset($_POST['btn_save'])){
            $result = $model->save();
        }
        $model->view();
    
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render($viewFile);
        
    }

    public function toggle() {
        $model = new StudentModel;
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
        
        $model = new StudentModel;
        $id = (int)$_GET['id'];
        if($id){
            $resultDelete = $model->delete();
        }
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('student-list');
    }


}
