<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class VideoModel extends PostModel {

    public function __construct() {
        parent::__construct();
        $this->type = 3;
        $this->name = 'video';
        $this->route = 'video';
    }
    
}

