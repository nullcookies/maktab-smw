<?php

namespace system;

use \models\objects\User;

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

        define('DB_DRIVER', $this->config['db']['driver']);
        define('DB_HOST', $this->config['db']['host']);
        define('DB_NAME', $this->config['db']['dbname']);
        define('DB_USER', $this->config['db']['username']);
        define('DB_PASSWORD', $this->config['db']['password']);
        define('DB_PREFIX', $this->config['db']['prefix']);
        
    }
    
    public function run(){

        mb_internal_encoding("UTF-8");

        session_start();
        
        if(!isset($_SESSION['stock'])){
            $_SESSION['stock'] = 1;
        }

        $user = new User();
        // if(!empty($_COOKIE['AUTH']) && $user->findByAuthkey($_COOKIE['AUTH'])){
        //     $result = $user->login();
        // }

        
        date_default_timezone_set($this->config['timezone']);
        // var_dump($_COOKIE);
        // var_dump($_SESSION);
        $pageParams = $this->router->parseUrl();
        $this->page->get($pageParams);
    }


}
