<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class VideoModel extends \models\front\PostModel {

    public function __construct() {
        parent::__construct();
        $this->pageId = 22;
        $this->type = 3;
        $this->name = 'video';
        $this->postPerPage = 10;
    }
    
}

	