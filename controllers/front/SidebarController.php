<?php

namespace controllers\front;

use \system\Controller;
use \models\front\SidebarModel;
use \models\objects\User;
use \models\objects\Teacher;
use \models\objects\Student;

defined('BASEPATH') OR exit('No direct script access allowed');

class SidebarController extends Controller {

    public function index() {

        $model = new SidebarModel;
        $model->index();

        $this->data = $model->data;

        $user = new User();
        $teacher = new Teacher();
        $student = new Student();

        $viewFile = 'sidebar';

        switch($_SESSION['usergroup']){
            case $teacher->usergroup: 
                $viewFile = 'sidebar-teacher';
                break;
            case $student->usergroup: 
                $viewFile = 'sidebar-student';
                break;
            case 1:
            case 2:
            case 3:
            case 4:
                $viewFile = 'sidebar-admin';
                break;
            default: 
                $viewFile = 'sidebar';
        }

        $this->content = $this->render($viewFile);
    }
    
}
