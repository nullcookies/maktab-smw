<?php

namespace controllers\front;

use \system\Controller;
use \models\front\BrandModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class BrandController extends Controller {

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
        $model = new BrandModel;
        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('brand');
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
        $model = new BrandModel;
        if($model){
            $result = $model->view();
            if(!$result){
                $this->header404 = true;
            }
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('brand-single');

        if(isset($_POST['getJson'])){
            $response = [];
            $response['content'] = $this->content;
            $response['params'] = $this->render('category-params');
            echo json_encode($response);
            exit;
        }
    }

}


