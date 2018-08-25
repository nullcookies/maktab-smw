<?php

namespace models\front;

use \system\Model;
use \models\objects\User;

defined('BASEPATH') OR exit('No direct script access allowed');

class SidebarModel extends Model {
    
    public function index() {	
        
        $data = array();

        $user = [];
        if(isset($_SESSION['user_id'])){
            $user = new User();
            $user->find($_SESSION['user_id']);
        }
        $userImg = ($user->image) ? $user->image : 'no-image.jpg';
        $user->icon = $this->linker->getIcon($this->media->resize($userImg, 100, 100, true));
        $data['user'] = $user;

        $menu = [];

        $menu[] = [
            'label'     => $this->t('dashboard', 'front'),
            'url'       => $this->linker->getHomeUrl(),
            'active'    => (CONTROLLER == 'home') ? true : false,
            'icon'      => 'home',
        ];
        $menu[] = [
            'label'     => $this->t('lessons', 'front'),
            'url'       => $this->linker->getUrl('lesson'),
            'active'    => (CONTROLLER == 'lesson') ? true : false,
            'icon'      => 'book',
        ];

        $data['menu'] = $menu;



        $this->data = $data;

        return $this;
    }
    
}
