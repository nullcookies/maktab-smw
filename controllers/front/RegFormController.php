<?php

namespace controllers\front;

use \system\Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class RegFormController extends Controller {

    public function index() {
        $this->content = $this->render('regform');
    }
    
}
