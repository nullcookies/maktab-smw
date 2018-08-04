<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class Linker {
    
    private $url;
    public $lang_prefix;
    private $extensions;

    public function __construct($lang_prefix = false){
        if($lang_prefix){
            $this->lang_prefix = $lang_prefix;
        }
        $this->extensions = array("jpg", "jpeg", "png", "gif", "js", "css", "html", "xml", "mp3", "ogg", "mp4", "3gp");
    }
    
    private function url($getParams = false){
        $this->urlBuild($getParams);
        if($this->lang_prefix){
            $this->url = '/' . $this->lang_prefix . $this->url;
        }
        $this->url = BASEURL . $this->url;
        return $this->url;
    }
    private function urlAdmin($getParams = false){
        $this->urlBuild($getParams);
        if($this->lang_prefix){
            //$this->url = '/' . $this->lang_prefix . $this->url;
        }
        $this->url = BASEURL_ADMIN . $this->url;
        return $this->url;
    }
    private function urlBuild($getParams = false){
        $checkUrlExtension = trim(strrchr(trim($this->url, '/'), '.'), '.');
        if(in_array($checkUrlExtension, $this->extensions)){
            $this->url = substr($this->url, 0, -1);
        }
        if($getParams){
            $this->url = rtrim($this->url, '/');
        }
    }

    private function icon(){
        $this->url = BASEURL . $this->url;
        return $this->url;
    }
    
    public function getIcon($icon, $synchronized = false){
        $uploadsDir = ($synchronized) ? 'uploads-synchro' : 'uploads';
        $this->url = '/' . $uploadsDir . '/' . $icon;
        return $this->icon();
    }
    
    public function getFile($file, $synchronized = false){
        $uploadsDir = ($synchronized) ? 'uploads-synchro' : 'uploads';
        $this->url = '/' . $uploadsDir . '/' . $file;
        return $this->icon();
    }
    
    public function getUrl($params, $admin = false){
        $this->url = '/';
        if($params){
            if(is_string($params)){
                $params = explode('/', trim(trim($params), '/'));
            }
            if(is_array($params)){
                if(count($params)){
                    foreach($params as $value){
                        $value = preg_replace('#[^0-9a-zA-Z-_\.,\/]#', '', preg_replace('#\s{1,}#', '-', $value));
                        $this->url .= $value . '/';
                    }
                }
            }
        }

        if($admin){
            return $this->urlAdmin();
        }
        else{
            return $this->url();
        }
        
    }
    public function getPaginationUrl($params, $page, $admin = false){
        $this->url = '/';
        if($params['alias']){
            $this->url .= $params['alias'];
            unset($params['alias']);
        }
        $this->url .= '/?page=' . (int)$page;

        if($params){
            foreach($params as $key => $value){
                $this->url .= '&' . urlencode($key). '=' . urlencode($value);
            }
        }

        if($admin){
            return $this->urlAdmin(true);
        }
        else{
            return $this->url(true);
        }
        
    }
    
    public function getHomeUrl(){
        $this->url = '/';
        return $this->url();
    }
    
    public function getAdminUrl(){
        $this->url = '/';
        return $this->urlAdmin();
    }

}

