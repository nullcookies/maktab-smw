<?php

namespace controllers\front;

use \system\Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class AreaSmallController extends Controller {

    public function index() {
        $this->content = $this->render('area-small');
    }
    
}
