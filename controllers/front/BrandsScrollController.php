<?php

namespace controllers\front;

use \system\Controller;
use \models\front\BrandModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class BrandsScrollController extends Controller {

    public function index() {
        $model = new BrandModel;
        $model->slider();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('brands-scroll');
    }
    
}
