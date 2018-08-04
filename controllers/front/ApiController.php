<?php

namespace controllers\front;

use \system\Controller;
use \models\front\ApiModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class ApiController extends Controller {
    
    public function index() {
        $model = new ApiModel;
        $model->index();
        $this->json($model->data);
    }
    
    public function brand() {
        $model = new ApiModel;
        $model->brand();
        $this->json($model->data);
    }
    
    public function category() {
        $model = new ApiModel;
        $model->category();
        $this->json($model->data);
    }
    
    public function product() {
        $model = new ApiModel;
        $model->product();
        $this->json($model->data);
    }
    
    public function filter() {
        $model = new ApiModel;
        $model->filter();
        $this->json($model->data);
    }
    
    public function file() {
        $model = new ApiModel;
        $model->file();
        $this->json($model->data);
    }
    
    public function url() {
        $model = new ApiModel;
        $model->url();
        $this->json($model->data);
    }

}
