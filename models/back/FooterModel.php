<?php

namespace models\back;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class FooterModel extends Model {
    
    public function index() {	
        
        $data = array();

        $social = array();
        $social['twitter'] = $this->getOption('SOCIAL_TWITTER');
        $social['facebook'] = $this->getOption('SOCIAL_FACEBOOK');
        $social['googleplus'] = $this->getOption('SOCIAL_GOOGLEPLUS');
        $social['rss'] = $this->linker->getUrl('rss');
        $data['social'] = $data;

        $gallery = [];
        $getFiles = $this->qb->where([['mime', 'image/jpeg', 'OR'], ['mime', 'image/png', 'OR'], ['mime', 'image/gif', 'OR']])->order('id', true)->get('??file');
        if($getFiles->rowCount() > 0){
            $getFiles = $getFiles->fetchAll();
            foreach ($getFiles as $key => $value) {
                $checkFileCategory = explode('/', $value['path']);
                if(in_array($checkFileCategory[0], ['brand', 'category', 'product', 'post', 'common'])){
                    $value['file_category'] = $checkFileCategory[0];
                    $value['icon'] = $this->linker->getIcon($this->media->resize($value['path'], 80, 60));
                    $gallery[] = $value;
                }
            }
        }
        $data['gallery'] = $gallery;
        //$this->ppp($gallery);

        $data['sitemap'] = $this->linker->getUrl("sitemap");

        $data['homeURL'] = $this->linker->getHomeUrl();
        $data['loadGalleryUrl'] = $this->linker->getUrl('view/footer/gallery', true);

        $data['phone'] = $this->getOption('TELEPHONE');
        $data['mail'] = $this->getOption('EMAIL');

        $this->data = $data;

        return $this;
    }

    public function gallery(){

        $data = array();

        $gallery = [];
        $getFiles = $this->qb->where([['mime', 'image/jpeg', 'OR'], ['mime', 'image/png', 'OR'], ['mime', 'image/gif', 'OR']])->order('id', true)->get('??file');
        if($getFiles->rowCount() > 0){
            $getFiles = $getFiles->fetchAll();
            foreach ($getFiles as $key => $value) {
                $checkFileCategory = explode('/', $value['path']);
                if(in_array($checkFileCategory[0], ['brand', 'category', 'product', 'post', 'common'])){
                    $value['file_category'] = $checkFileCategory[0];
                    $value['icon'] = $this->linker->getIcon($this->media->resize($value['path'], 80, 60));
                    $gallery[] = $value;
                }
            }
        }
        $data['gallery'] = $gallery;

        $this->data = $data;

        return $this;
    }
    
}



