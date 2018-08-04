<?php

namespace controllers\front;

use \system\Controller;
use \models\front\CategoryParamsModel;
use \models\front\CategoryModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryParamsController extends Controller {

    public function index() {
        $model = new CategoryModel;
        $model->view();
        $this->data = $model->data;
        $this->content = $this->render('category-params');
    }


}


