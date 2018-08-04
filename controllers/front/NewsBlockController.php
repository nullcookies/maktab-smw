<?php

namespace controllers\front;

use \system\Controller;
use \models\front\NewsBlockModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class NewsBlockController extends Controller {

    public function index() {
        $model = new NewsBlockModel;
        if($model){
            $model->index();
            $this->data = $model->data;
        }
        $this->content = $this->render('news-block');
    }
    
}
