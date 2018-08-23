<?php

namespace models\back;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class HeaderModel extends Model {

    public function index() {	
        
        $data = [];

        
        $data['curLang'] = [];
        $getCurLang = $this->qb->where('id', '?')->get('??lang', [LANG_ID]);
        if($getCurLang->rowCount() > 0){
            $curLang = $getCurLang->fetch();
        }
        $data['curLang'] = $curLang;

        $data['lang'] = [];
        $getLang = $this->qb->where('status', '1')->get('??lang');
        if($getLang->rowCount() > 0){
            $lang = $getLang->fetchAll();
        
            foreach($lang as $key => $value){
                $lang[$key]['icon'] = $this->linker->getIcon($value['icon']);
                $lang[$key]['url'] = "/lang/index/id/" . $value['id'];

            }
            $data['lang'] = $lang;
        }

        $user = [];
        $currentUser = [];

	    if(!empty($_SESSION['user_id'])){
	    	$getUser = $this->qb->where('id', '?')->get('??user', [$_SESSION['user_id']]);
	        if($getUser->rowCount() > 0){
	            $user = $getUser->fetch();
	        }
	        $currentUser['name'] = $user['firstname'] . ' ' . $user['lastname'];
	        $currentUser['usergroup'] = $user['usergroup'];
	        $currentUser['email'] = $user['email'];
	        
	        if(!$user['image']){
	            if($user['gender'] == 1){
	                $user['image'] = 'user/avatar-m.png';
	            }
	            else{
	                $user['image'] = 'user/avatar-f.png';
	            }
	        }
	        $currentUser['icon'] = $this->linker->getIcon($user['image']);
	        $currentUser['profile'] = $this->linker->getUrl('user/edit/' . $user['id'], true);
	        $currentUser['reg'] = date('Y/m/d', $user['created_at']);
	    }

        $data['user'] = $currentUser;
        $data['logout'] = $this->linker->getUrl('user/logout/', true);

        $newOrders = $this->qb->where('new', '1')->count('??order');
        $data['newOrders'] = (int)$newOrders;
        $data['newOrdersUrl'] = $this->linker->getUrl('order', true);


        $data['sitename'] = $this->config['sitename'];
        $data['sitenameShort'] = $this->config['sitenameShort'];
        $data['mainPage'] = $this->linker->getAdminUrl();
        $data['homePage'] = $this->linker->getHomeUrl();


        $this->data = $data;

        return $this;
    }
    
}


