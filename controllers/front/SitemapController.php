<?php

namespace controllers\front;

use \system\Controller;
use \models\front\SitemapModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class SitemapController extends Controller {
    
    public function index() {
    	$this->modules = [
    		
    	];
        $model = new SitemapModel;
		$model->index();
		$this->data = $model->data;
			
        $this->content = $this->render('sitemap');
		header('Content-Type: text/xml');
		echo $this->content;
		exit;
    }

}
