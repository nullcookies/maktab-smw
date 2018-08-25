<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class Document {
    
    public $title;
    public $description;
    public $keywords;
    public $canonical;
    public $styles;
    public $scripts;
    public $charset;
    public $favicon;
    public $bodyClass;
    
    public function __construct(){
        $this->title = '';
        $this->description = '';
        $this->keywords = '';
        $this->canonical = '';
        $this->styles = [];
        $this->scripts = [];
        $this->charset = 'utf-8';
        $this->favicon = '';
        $this->bodyClass = [];
    }
    
    public function addStyle($style){
        $this->styles[] = $style;
    }
    public function addScript($script){
        $this->scripts[] = $script;
    }

}
