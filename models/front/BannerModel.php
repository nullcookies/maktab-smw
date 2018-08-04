<?php

namespace models\front;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class BannerModel extends Model {

    public function index() {	
        
        $data = [];
        

        $this->data = $data;
        return $this;
    }

    public function bottom() {	
        
        $data = [];

        $banners = [];
        $getBanners = $this->qb->where([['position', 'bottom'], ['status', '1']])->order('sort_number')->get('??banner');
        if($getBanners->rowCount() > 0){
            $banners = $getBanners->fetchAll();
            $banners = $this->langDecode($banners, ['name', 'url']);
            foreach ($banners as $key => $value) {
                $mainIcon = $this->getMainIcon($value['images']);
                $banners[$key]['icon'] = $this->linker->getIcon($mainIcon);
            }
        }
        $data['banners'] = $banners;

        $this->data = $data;
        return $this;
    }
    
}


