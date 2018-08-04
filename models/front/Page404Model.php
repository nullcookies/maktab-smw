<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class Page404Model extends Model {
    
    public function index(){

        $data = [];

        $data['homeUrl'] = $this->linker->getUrl('');
        $data['searchAction'] = $this->linker->getUrl('search');

        $this->document = new Document();
        $this->data = $data;

        return $this;
    }
}



