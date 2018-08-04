<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class NewsModel extends \models\front\PostModel {

    public function __construct() {
        parent::__construct();
        $this->pageId = 20;
        $this->type = 2;
        $this->name = 'news';
        $this->postPerPage = 10;
    }
    
}

	