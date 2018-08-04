<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class SmartWeb extends Component {

    private $page;
    private $router;

    public function __construct(){
        parent::__construct();
        $this->router = new \system\Router;
        $this->page = new \system\Page;

        define('PROJECT_NAME', 'SmartWeb');
        define('PROJECT_VERSION', '1.0.0.');

        define('THEMEURL', BASEURL . '/views/front/' . $this->getOption('theme'));
        define('THEMEPATH', BASEPATH . '/views/front/' . $this->getOption('theme'));
        define('THEMEURL_ADMIN', BASEURL . '/views/back/' . $this->getOption('theme_admin'));
        define('THEMEPATH_ADMIN', BASEPATH . '/views/back/' . $this->getOption('theme_admin'));
    }
    
    public function run(){
        session_start();
        
        if(!isset($_SESSION['stock'])){
            $_SESSION['stock'] = 1;
        }

        date_default_timezone_set($this->config['timezone']);
        //var_dump($_COOKIE);
        //var_dump($_SESSION);
        $pageParams = $this->router->parseUrl();
        $this->page->get($pageParams);
    }


}
