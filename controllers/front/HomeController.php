<?php

namespace controllers\front;

use \system\Controller;
use \models\front\HomeModel;
use \models\objects\User;
use \models\objects\Teacher;
use \models\objects\Student;

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends Controller {
    
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
    	
        $model = new HomeModel;
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $user = new User();
        $teacher = new Teacher();
        $student = new Student();

        $viewFile = 'home';


        switch($_SESSION['usergroup']){
            case $teacher->usergroup: 
                $viewFile = 'home-teacher';
                break;
            case $student->usergroup: 
                $viewFile = 'home-student';
                break;
            case 1:
            case 2:
            case 3:
                $viewFile = 'home-admin';
                break;
            default: 
                $viewFile = 'home';
        }

        $this->content = $this->render($viewFile);
    }

}
