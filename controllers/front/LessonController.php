<?php

namespace controllers\front;

use \system\Controller;
use \models\front\LessonModel;
use \models\objects\Teacher;

defined('BASEPATH') OR exit('No direct script access allowed');

class LessonController extends Controller {
    
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
                'controller' => 'sidebar',
                'action' => 'index',
                'position' => 'sidebar'
            ],
        ];
        
        $model = new LessonModel();
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $teacher = new Teacher();

        $viewFile = 'lesson-all';

        switch($_SESSION['usergroup']){
            case 1: 
            case 2: 
            case 3: 
            case 4: 
                $viewFile = 'lesson-all';
                break;
            case $teacher->usergroup: 
                $viewFile = 'lesson';
                break;
            default: 
                exit('Access Error!');
        }

        $this->content = $this->render($viewFile);
    }

    public function list_ajax() {
        $model = new LessonModel;

        $model->list_ajax();
        $this->data = $model->data;
            
        $this->json($this->data);
    }

    public function list_ajax_full() {
        $model = new LessonModel;

        $model->list_ajax_full();
        $this->data = $model->data;
            
        $this->json($this->data);
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
                'controller' => 'sidebar',
                'action' => 'index',
                'position' => 'sidebar'
            ],
    	];
    	
        $model = new LessonModel;
        if(isset($_POST['btn_save'])){
            $result = $model->save();
        }
        $model->view();
        $this->data = $model->data;
        $this->document = $model->document;

        $viewFile = 'lesson-view-all';

        switch($_SESSION['usergroup']){
            case 1: 
            case 2: 
            case 3: 
            case 4: 
                $viewFile = 'lesson-view-all';
                break;
            case $teacher->usergroup: 
                $viewFile = 'lesson-view';
                break;
            default: 
                exit('Access Error!');
        }

        $this->content = $this->render($viewFile);
    }

    public function delete() {
        
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
                'controller' => 'sidebar',
                'action' => 'index',
                'position' => 'sidebar'
            ],
        ];
        
        $model = new LessonModel;
        if(!empty($_GET['id'])){
            $resultDelete = $model->delete();
        }
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('lesson');
    }

}
