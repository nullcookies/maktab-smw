<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class Page404Model extends Model {
    
    public function index(){
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
        	'name' => $this->getTranslation('main page'),
        	'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
        	'name' => $this->getTranslation('404 error'),
        	'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        $data['mainPage'] = $this->linker->getAdminUrl();

        $this->document = new Document();
        $this->data = $data;

        return $this;
    }
}



