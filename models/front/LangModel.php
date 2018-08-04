<?php

namespace models\front;

use \system\Model;
use \system\Linker;

defined('BASEPATH') OR exit('No direct script access allowed');

class LangModel extends Model {
    
    public function set() {
        
        $getLocation = parse_url($_SERVER['HTTP_REFERER']);
        $getPath = explode("/", trim($getLocation['path'], "/"));
        $location_prefix = $getPath[0];

        $location = '';



        $id = (int)$_GET['param1'];
        if(!$id) $id = LANG_ID;
        
        $lang_prefix_old = $this->qb->where('id', '?')->get('??lang', [LANG_ID])->fetch()['lang_prefix'];
        
        if($location_prefix == $lang_prefix_old) {
            array_shift($getPath);
        }
        $location = implode("/", $getPath);

        $lang_prefix_new = '';
        $get_lang_prefix_new = $this->qb->where('id', '?')->get('??lang', [$id])->fetch();
        if(!$get_lang_prefix_new['main']){
            $lang_prefix_new = $get_lang_prefix_new['lang_prefix'];

        }
        $linker = new Linker($lang_prefix_new);
        
        if($lang_prefix_old != $lang_prefix_new){
            $_SESSION['lang_id'] = $id;
            setcookie('lang_id', $id, time() + 365 * 86400, '/');
        }
        
        if($location == '/' || !$location){
            $location = $linker->getHomeUrl();
        }
        else{
            $location = $linker->getUrl(trim($location, '/'));
        }

        return $location;
    }
    
    

}

