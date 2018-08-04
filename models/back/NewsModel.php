<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class NewsModel extends PostModel {

    public function __construct() {
        parent::__construct();
        $this->type = 2;
        $this->name = 'news';
        $this->route = 'news';
    }
    
}

