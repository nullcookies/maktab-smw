<?php

namespace models\front;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class FooterModel extends Model {
    
    public function index() {	
        
        $data = array();

        $social = array();
        $social['twitter'] = $this->getOption('SOCIAL_TWITTER');
        $social['facebook'] = $this->getOption('SOCIAL_FACEBOOK');
        $social['googleplus'] = $this->getOption('SOCIAL_GOOGLEPLUS');
        $social['vkontakte'] = $this->getOption('SOCIAL_VKONTAKTE');
        $social['odnoklassniki'] = $this->getOption('SOCIAL_ODNOKLASSNIKI');
        $social['youtube'] = $this->getOption('SOCIAL_YOUTUBE');
        $social['rss'] = $this->linker->getUrl('rss');
        $data['social'] = $social;

        $pageLinks = [];
        $getPageLinks = $this->qb->select('id, name, nav_name, alias')->where('status', '1')->get('??page');
        if($getPageLinks->rowCount() > 0){
            $getPageLinks = $getPageLinks->fetchAll();
            $getPageLinks = $this->langDecode($getPageLinks, ['name', 'nav_name']);
            foreach ($getPageLinks as $key => $value) {
                $pageLinks[$value['id']] = [
                    'name' => $value['nav_name'][LANG_ID],
                    'url' => $this->linker->getUrl($value['alias'])
                ];
            }
        }

        $bottomMenu = [
            [
                'name' => $this->translation('main bottom menu'),
                'ids' => [1, 7, 2, 20, 21],
                'values' => []
            ],
            [
                'name' => $this->translation('customer service'),
                'ids' => [8, 9, 11, 23],
                'values' => []
            ],
            [
                'name' => $this->translation('information'),
                'ids' => [3, 12, 15],
                'values' => []
            ],
        ];



        foreach($bottomMenu as $key => $value){
            if(is_array($value['ids'])){
                foreach ($value['ids'] as $key1 => $value1) {
                    if(isset($pageLinks[$value1])){
                        $bottomMenu[$key]['values'][] = $pageLinks[$value1];
                    }
                }
            }
        }



        $data['pageLinks'] = $pageLinks;
        $data['bottomMenu'] = $bottomMenu;


        $data['storeName'] = $this->getOption('store_name');

        $data['address'] = $this->getOption('address');
        $data['phone1'] = $this->getOption('phone1');
        $data['phone2'] = $this->getOption('phone2');
        $data['phone3'] = $this->getOption('phone3');
        $data['fax'] = $this->getOption('fax');
        $data['contact_mail'] = $this->getOption('contact_mail');

        $data['counters'] = $this->getOption('counters');

        $data['accountUrl'] = $this->linker->getUrl('user/account');
        $data['ordersUrl'] = $this->linker->getUrl('user/orders');

        $this->data = $data;

        return $this;
    }
    
}



