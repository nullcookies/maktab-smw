<?php

namespace controllers\back;

use \system\Controller;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class VideoController extends PostController {

    public function __construct() {
        parent::__construct();
        $this->model = '\models\back\VideoModel';
    }

    
}


