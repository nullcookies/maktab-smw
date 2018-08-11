<?php

namespace controllers\back;

use \system\Controller;
use \models\back\TeacherModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class TeacherController extends Controller {
    
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
        $model = new TeacherModel;

        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('teacher-list');
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

        $model = new TeacherModel;

        $viewFile = 'teacher-view';
        $model->edit();
        if(isset($_POST['btn_save'])){
            $result = $model->save();
        }
    
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render($viewFile);
        
    }

    public function toggle() {
        $model = new TeacherModel;
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
        
        $model = new TeacherModel;
        if($model){
            $id = (int)$_GET['param1'];
            if($id){
                $resultDelete = $model->delete();
            }
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('teacher-list');
    }


}
