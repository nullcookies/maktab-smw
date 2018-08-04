<?php

namespace controllers\front;

use \system\Controller;
use \models\front\LangModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class LangController extends Controller {
    
    public function set() {
        $model = new LangModel;
        $location = $model->set();
        //echo $location;
        //exit;
        header("Location: " . $location);
        exit;
    }

}





