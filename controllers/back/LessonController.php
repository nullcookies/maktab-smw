<?php

namespace controllers\back;

use \system\Controller;
use \models\back\LessonModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class LessonController extends Controller {
    
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
            ],
        ];
        
        $model = new LessonModel;
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $viewFile = 'lesson-list';

        $this->content = $this->render($viewFile);
    }

    public function list_ajax() {
        $model = new LessonModel;

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
            ],
    	];
    	
        $model = new LessonModel;

        if(isset($_POST['btn_save'])){
            $result = $model->save();
        }

        $model->view();
        $this->data = $model->data;
        $this->document = $model->document;

        $viewFile = 'lesson-view';

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
            ],
        ];
        
        $model = new LessonModel;
        if(!empty($_GET['id'])){
            $resultDelete = $model->delete();
        }
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('lesson-list');
    }

}
