<?php

namespace controllers\front;

use \system\Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class NewsController extends PostController {

    public function __construct() {
        parent::__construct();
        $this->name = 'news';
        $this->modelName = '\\models\\front\\' . ucfirst($this->name) . 'Model';
    }

}


