<?php

namespace controllers\front;

use \system\Controller;
use \models\front\SubscribeModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class SubscribeController extends Controller {

    public function index() {
        $model = new SubscribeModel;
        $model->index();
        $this->data = $model->data;
        $this->json($this->data);
    }
    
}