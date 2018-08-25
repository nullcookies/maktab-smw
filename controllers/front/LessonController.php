<?php

namespace controllers\front;

use \system\Controller;
use \models\front\LessonModel;

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
        
        $model = new LessonModel;
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $viewFile = 'lesson';

        $this->content = $this->render($viewFile);
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
        $model->view();
        $this->data = $model->data;
        $this->document = $model->document;

        $viewFile = 'lesson-view';

        $this->content = $this->render($viewFile);
    }

}
