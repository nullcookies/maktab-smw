<?php

namespace controllers\front;

use \system\Controller;
use \models\front\InformationModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class InformationController extends Controller {
    
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
                'controller' => 'newsBlock',
                'action' => 'index',
                'position' => 'bottom'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'index',
                'position' => 'bottom'
            ],
            [
                'side' => 'front',
                'controller' => 'banner',
                'action' => 'bottom',
                'position' => 'bottom'
            ],
    	];
        $model = new InformationModel;
        $model->view();
        $this->data = $model->data;
        $this->document = $model->document;
        $this->content = $this->render('information');
    }

}
