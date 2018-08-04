<?php

namespace controllers\front;

use \system\Controller;
use \models\front\ProductModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends Controller {

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
                'controller' => 'mainMenu',
                'action' => 'index',
                'position' => 'left'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'side',
                'position' => 'left'
            ]
        ];
        $model = new ProductModel;
        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        //$this->content = $this->render('product');
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
        $model = new ProductModel;
        if($model){
            $model->view();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('product-single');
    }

    public function search() {
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
        $model = new ProductModel;
        if($model){
            $model->search();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('product-search');

        if(isset($_POST['getJson'])){
            $response = [];
            $response['content'] = $this->content;
            echo json_encode($response);
            exit;
        }
    }

    public function addreview() {
        $model = new ProductModel;
        $model->addreview();
        $this->data = $model->data;
        $this->json($this->data);
    }

}


