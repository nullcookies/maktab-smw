<?php

namespace controllers\front;

use \system\Controller;
use \models\front\ContactModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class ContactController extends Controller {
    
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
            ]
    	];
        $model = new ContactModel;
        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('contact');
    }

}
