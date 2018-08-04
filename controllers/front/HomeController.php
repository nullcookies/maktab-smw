<?php

namespace controllers\front;

use \system\Controller;
use \models\front\HomeModel;

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
            // [
            //     'side' => 'front',
            //     'controller' => 'topSlider',
            //     'action' => 'index',
            //     'position' => 'top'
            // ],
            // [
            //     'side' => 'front',
            //     'controller' => 'newsBlock',
            //     'action' => 'index',
            //     'position' => 'bottom'
            // ],
            // [
            //     'side' => 'front',
            //     'controller' => 'newProducts',
            //     'action' => 'index',
            //     'position' => 'bottom'
            // ],
            // [
            //     'side' => 'front',
            //     'controller' => 'banner',
            //     'action' => 'bottom',
            //     'position' => 'bottom'
            // ],
            // [
            //     'side' => 'front',
            //     'controller' => 'mainCategories',
            //     'action' => 'side',
            //     'position' => 'top'
            // ],
            // [
            //     'side' => 'front',
            //     'controller' => 'brandsScroll',
            //     'action' => 'index',
            //     'position' => 'bottom'
            // ],
    	];
    	
        $model = new HomeModel;
        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }

        $this->content = $this->render('home');
    }

}
