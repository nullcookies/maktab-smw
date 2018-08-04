<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class View extends Component {
    
    public $module;
    public $layoutPath;

    public function __construct() {
        parent::__construct();
        $this->layoutPath = BASEPATH . '/views/';
    }

    public function renderPage($layout, $document, $content, $modulesContent) {
        
        if(is_array($modulesContent)) {
            extract($modulesContent);
        }

        ob_start();
        if( file_exists($layout) ){
            include $layout;
        }
        return ob_get_clean();
    }
    
    public function render($module, $data = [], $type = 'html') {
        
        ob_start();
        if(is_array($data)) {
            extract($data);
        }
        
        if( file_exists($module) ){
            include $module;
        }
        return ob_get_clean();
    }

    public function renderBreadcrumbs($breadcrumbs = []) {
        $content = '';
        if(count($breadcrumbs) > 0){
            $content .= '<ul class="breadcrumb">';
            foreach($breadcrumbs as $value){
                if($value['url'] != 'active'){
                    $content .= '<li><a href="' . $value['url'] . '">' . $value['name'] . '</a></li>';
                }
                else{
                    $content .= '<li class="active">' . $value['name'] . '</li>';
                }
                
            }
            $content .= '</ul>';
        }
        echo $content;
    }

    public function renderNotifications($successText = '', $errorText = '') {
        $content = '';
        if($successText != ''){ 
            $content .= '<div class="alert alert-success">';
            $content .= '<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>';
            $content .= $successText;
            $content .= '</div>';
        }
        if($errorText != ''){ 
            $content .= '<div class="alert alert-danger">';
            $content .= '<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>';
            $content .= $errorText;
            $content .= '</div>';
        }
        echo $content;
    }

    public function arrayToJsObject($array){
        $return = '{';
        foreach($array as $key => $value){
            $return .= $key . ': ';
            if(is_array($value)){
                $return .= $this->arrayToJsObject($value) . ',';
            }
            else{
                $return .= '\'' . $value . '\',';
            }
        }
        $return = substr($return, 0, -1);
        $return .= '}';

        return $return;
    }
      
    
}

