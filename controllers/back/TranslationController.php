<?php

namespace controllers\back;

use \system\Controller;
use \models\back\TranslationModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class TranslationController extends Controller {

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
        $model = new TranslationModel;

        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('translation-list');
    }
    
    public function save() {

        $model = new TranslationModel;
        $result = $model->save();
        echo json_encode($result);
        exit;
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
        
        $model = new TranslationModel;
        if($model){
            $id = (int)$_GET['param1'];
            if($id){
                $resultDelete = $model->delete();
            }
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('translation-list');
    }
    

    
}


