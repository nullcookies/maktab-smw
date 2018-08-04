<?php

namespace controllers\front;

use \system\Controller;
use \models\front\ProductModel;
use \models\front\PaymePaymentModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class PaymePaymentController extends Controller {

    public function index() {
        
        $model = new PaymePaymentModel;
        $model->index();

        exit;
        //$this->json($model->data);
    }

}


