<?php

namespace models\front;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class TopSliderModel extends Model {

    public function index() {	

        $largeIconW = (int)$this->getOption('icon_large_w');
        $largeIconH = (int)$this->getOption('icon_large_h');

        $data = [];
        $slider = [];
        $getSlider = $this->qb->where('status', '1')->order('sort_number')->get('??slider');
        
        if($getSlider->rowCount() > 0){
            $slider = $getSlider->fetchAll();
            $slider = $this->langDecode($slider, ['name', 'url', 'descr_full']);
            foreach($slider as $key => $value){
                $slider[$key]['image'] = $this->linker->getIcon($value['image']);
                $slider[$key]['icon'] = $this->linker->getIcon($this->media->resize($value['image'], $largeIconW, $largeIconH, true));
            }
        }
        $data['slider'] = $slider;

        $this->data = $data;
        return $this;
    }
    
}


