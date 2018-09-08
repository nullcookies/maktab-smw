<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller extends Component {

    private $view;

    public $data;
    public $content;
    public $document;
    public $params;
    public $modules;
    public $modulesContent;

    public $viewsPath;
    public $theme;
    public $layout;

    public $header404;

    public function __construct() {

        parent::__construct();
        $this->view = new View();
        $this->params = [];
        $this->modules = [];
        $this->data = [];
        $this->modulesContent = [];
        $this->content = '';
        $this->document = new Document();
        $this->viewsPath = BASEPATH . 'views/front';
        $this->layout = 'layout';
        if(defined('BASEURL_ADMIN')){
            $this->theme = $this->getOption('theme_admin');
        }
        else{
            $this->theme = $this->getOption('theme');
        }
        $this->header404 = false;
    }

    public function getModules() {
        $this->modulesContent = [];
        
        foreach($this->modules as $value){
            if(!isset($this->modulesContent[$value['position']])){
                $this->modulesContent[$value['position']] = '';
            }
            $moduleControllerName = '\\controllers\\' . $value['side'] . '\\' . ucfirst($value['controller']) . 'Controller';
            
            $moduleController = new $moduleControllerName;
            $moduleController->viewsPath = BASEPATH . '/views/' . $value['side'];
            $moduleController->theme = $this->theme;
            $moduleController->params = $this->params;

            $moduleController->$value['action']();
            

            $this->modulesContent[$value['position']] .= $moduleController->content;
        }
        
    }



    public function json($data, $return = false) {
        header("Content-Type: application/json;charset=utf-8");

        // Collect what you need in the $data variable.
        $json = json_encode($data);
        if ($json === false) {
            $json = json_encode(array("jsonError", json_last_error_msg()));
            if ($json === false) {
                $json = '{"jsonError": "unknown"}';
            }
            http_response_code(500);
        }
        if($return){
            return $json;
        }
        echo $json;
        exit;
    }

    public function render($module = '') {
        $content = '';
        if($module){
            $content = $this->view->render($this->viewsPath . '/' . $this->theme . '/tpl/' . $module . '.php', $this->data);
        }
        return $content;
    }

    public function renderPage() {
        $content = '';
        $content = $this->view->renderPage($this->viewsPath . '/' . $this->theme . '/' . $this->layout . '.php', $this->document, $this->content, $this->modulesContent);
        return $content;
    }
    
    
    
    protected function is_cached($cache_dir, $cache_file, $cache_time = 300){
        $file = $cache_dir . $cache_file;
        if(!is_dir($cache_dir)){
            mkdir($cache_dir, 0777, true);
        }
        if(file_exists($file)) {
            if((time() - $cache_time) < filemtime($file)){
                return file_get_contents($file);
            }
        }
        
        return false;
    }
    
    protected function cache($cache_dir, $cache_file, $content){
        $file = $cache_dir . $cache_file;
        $handle = fopen($file, 'w');
        if($handle){
            fwrite($handle, $content);
            fclose($handle);
        }
    }



}
