<?php

namespace models\front;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class HeaderModel extends Model {

    public $stocks = [1, 2, 3];

    public function index() {
        
        $data = [];
        
        $data['curLang'] = [];
        $getCurLang = $this->qb->where('id', '?')->get('??lang', [LANG_ID]);

        if($getCurLang->rowCount() > 0){
            $curLang = $getCurLang->fetch();
            $curLang['icon'] = $this->linker->getIcon($curLang['icon']);
        }
        $data['curLang'] = $curLang;

        $data['lang'] = [];
        $getLang = $this->qb->where('status', '1')->get('??lang');
        if($getLang->rowCount() > 0){
            $lang = $getLang->fetchAll();
        
            foreach($lang as $key => $value){
                $lang[$key]['icon'] = $this->linker->getIcon($value['icon']);
                $lang[$key]['url'] = $this->linker->getUrl("lang/set/" . $value['id']);
            }
            $data['lang'] = $lang;
        }

        $data['phone1'] = $this->getOption('phone1');
        $data['phone2'] = $this->getOption('phone2');
        $data['phone3'] = $this->getOption('phone3');
        $data['address'] = $this->getOption('address');

        
        $data['home'] = [
            'name' => $this->translation('home'),
            'url' => $this->linker->getUrl('')
        ];

        $data['searchUrl'] = $this->linker->getUrl('product/search');
        $data['ordersUrl'] = $this->linker->getUrl('user/orders');
        $data['accountUrl'] = $this->linker->getUrl('user/account');
        $data['registerUrl'] = $this->linker->getUrl('user/register');
        $data['loginUrl'] = $this->linker->getUrl('user/login');
        $data['logoutUrl'] = $this->linker->getUrl('user/logout');
        $data['forgetPasswordUrl'] = $this->linker->getUrl('user/forgetPassword');
        $data['adminUrl'] = $this->linker->getUrl($this->config['adminAccess']);
        
        $user = [];
        if(isset($_SESSION['user_id'])){
            $user_id = (int)$_SESSION['user_id'];
            $getUser = $this->qb->where('id', '?')->get('??user', [$user_id])->fetch();
            if($getUser){
                $user['name'] = $getUser['name'];
            }
        }
        $data['user'] = $user;

        
        $headerLinkPages = [1, 2, 20, 22];
        $headerLinks = $this->getSitePages($headerLinkPages);
        if(CONTROLLER == 'information' && isset($_GET['param1']) && isset($headerLinks[$_GET['param1']])) {
            $headerLinks[$_GET['param1']]['active'] = true;
        }
        $data['headerLinks'] = $headerLinks;

        $privacyPages = $this->getSitePages([11, 24]);
        $data['privacyPage'] = $privacyPages[11];
        $data['rulesPage'] = $privacyPages[24];

        
        $this->data = $data;

        return $this;
    }

    public function stock(){
        $stockId = (int)$_GET['param1'];
        if(in_array($stockId, $this->stocks)){
            $_SESSION['stock'] = $stockId;
        }
        echo $_SESSION['stock'];
    }
    
}


