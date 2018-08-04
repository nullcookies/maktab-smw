<?php

namespace controllers\back;

use \system\Controller;
use \models\back\StatsModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class StatsController extends Controller {

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
        $model = new StatsModel;

        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('stats-list');
    }

    public function contract_completion() {   
        
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
        $model = new StatsModel;
        
        $param1 = $_GET['param1'];
        if($param1 == 'view'){
            $model->contract_completion_view();
            $this->data = $model->data;
            $this->document = $model->document;

            $this->content = $this->render('stats-contract-completion-view');
        }
        else{
            $model->contract_completion();
            $this->data = $model->data;
            $this->document = $model->document;

            $this->content = $this->render('stats-contract-completion');
        }
    }

    public function sales() {   
        
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
        $model = new StatsModel;
        
        $param1 = $_GET['param1'];
        if($param1 == 'view'){
            $model->sales_view();
            $this->data = $model->data;
            $this->document = $model->document;

            $this->content = $this->render('stats-sales-view');
        }
        else{
            $model->sales();
            $this->data = $model->data;
            $this->document = $model->document;

            $this->content = $this->render('stats-sales');
        }
    }
    
}


