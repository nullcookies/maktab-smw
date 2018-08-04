<?php

namespace controllers\front;

use \system\Controller;
use \models\front\CategoryModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryController extends Controller {

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
        $model = new CategoryModel;
        if($model){
            $model->index();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('category');
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
        $model = new CategoryModel;
        $result = $model->view();
        if(!$result){
            $this->header404 = true;
        }

        $this->data = $model->data;

        $viewFile = 'category-parent';

        //if subcategory 
        if($this->data['categoryType'] == 'subcategory'){
            $viewFile = 'category-single';
            //$this->layout = 'layout-column';
            $this->layout = 'layout';
            $modulesSingle = [
                // [
                //     'side' => 'front',
                //     'controller' => 'mainMenu',
                //     'action' => 'index',
                //     'position' => 'left'
                // ],
                // [
                //     'side' => 'front',
                //     'controller' => 'categoryParams',
                //     'action' => 'index',
                //     'position' => 'top'
                // ],
            ];
            $this->modules = array_merge($this->modules, $modulesSingle);
        }

        $this->document = $model->document;
        $this->content = $this->render($viewFile);

        if(isset($_POST['getJson'])){
            $response = [];
            $response['content'] = $this->content;
            $response['params'] = $this->render('category-params');
            echo json_encode($response);
            exit;
        }
    }

    public function type() {
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
                'controller' => 'bottomText',
                'action' => 'index',
                'position' => 'bottom'
            ]
        ];
        $model = new CategoryModel;
        if($model){
            $result = $model->type();
            if(!$result){
                $this->header404 = true;
            }
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('category-single');
    }

}


