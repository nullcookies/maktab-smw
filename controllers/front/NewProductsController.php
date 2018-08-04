<?php

namespace controllers\front;

use \system\Controller;
use \models\front\NewProductsModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class NewProductsController extends Controller {

    public function index() {
        $model = new NewProductsModel;
        if($model){
            $model->index();
            $this->data = $model->data;
        }
        
        $this->content = $this->render('new-products-block');
    }

    public function side() {
        $model = new NewProductsModel;
        if($model){
            $model->side();
            $this->data = $model->data;
        }
        
        $this->content = $this->render('new-products-box');
    }
    
}