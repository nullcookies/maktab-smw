<?php

namespace models\front;

use \system\Document;
use \system\Model;
use \models\common\WorkApiModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeModel extends Model {
    
    public function index(){
        $data = [];
        $this->document = new Document();

        $mediumIconW = (int)$this->getOption('icon_medium_w');
        $mediumIconH = (int)$this->getOption('icon_medium_h');

        $postIconW = (int)$this->getOption('icon_post_w');
        $postIconH = (int)$this->getOption('icon_post_h');
        if(!$postIconW){
            $postIconW = $mediumIconW;
        }
        if(!$postIconH){
            $postIconH = $mediumIconH;
        }
        
        $getHome = $this->qb->where([['side', 'front'], ['controller', 'home']])->get('??page');
        if($getHome->rowCount() > 0){
            $home = $getHome->fetchAll();
            $home = $this->langDecode($home, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
            $home = $home[0];
        }
        if(isset($home)){
            $this->document->title = ($home['meta_t'][LANG_ID]) ? $home['meta_t'][LANG_ID] : $home['name'][LANG_ID];
            $this->document->description = $home['meta_d'][LANG_ID];
            $this->document->keywords = $home['meta_k'][LANG_ID];
        }

        $data['home'] = $home;

        $twowork = new WorkApiModel();

        //$categories = $twowork->get_categories();

        

        $data['categories'] = json_decode($categories, true);


        $data['themeURL'] = THEMEURL;


        $this->data = $data;

        return $this;
    }
}



