<?php

namespace controllers\front;

use \system\Controller;
use \models\front\SynchroModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class SynchroController extends Controller {
    
    public function index() {
        $model = new SynchroModel;
        $model->index();
        $this->json($model->data);
    }
    
    public function start() {
        $model = new SynchroModel;
        $model->start();
        $this->json($model->data);
    }

}
