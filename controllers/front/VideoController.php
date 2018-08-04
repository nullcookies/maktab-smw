<?php

namespace controllers\front;

use \system\Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class VideoController extends PostController {

    public function __construct() {
        parent::__construct();
        $this->name = 'video';
        $this->modelName = '\\models\\front\\' . ucfirst($this->name) . 'Model';
    }

}


