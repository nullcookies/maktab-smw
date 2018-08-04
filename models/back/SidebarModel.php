<?php

namespace models\back;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class SidebarModel extends Model {

    public function index() {	
        
        $data = [];

        $topmenu = [];
        $access = $_SESSION['usergroup'];
        if(empty($access)) {
            header('Location: ' . BASEURL_ADMIN . '/');
            exit;
        }

        $menu = [];
        $getModules = $this->qb->where([['status', '1'], ['show_menu', '1'], ['access >=', '?']])->order('sort_order')->get('??module', [$access]);
        
        $currentController = strtolower(str_replace('Controller', '', CONTROLLER));

        if($getModules->rowCount() > 0){
            $getMenu = $getModules->fetchAll();
            

            foreach($getMenu as $value){
                $active = ($currentController == $value['alias']) ? true : false;
                $menu[] = [
                    'alias' => $value['alias'],
                    'url' => $this->linker->getUrl($value['alias'], true),
                    'active' => $active
                ];
            }
        }

        $data['controller'] = $currentController;
        $data['menu'] = $menu;

        $data['mainPage'] = $this->linker->getAdminUrl();
        
        $user = [];
        $getUser = $this->qb->where('id', '?')->get('??user', [$_SESSION['user_id']]);
        if($getUser->rowCount() > 0){
            $user = $getUser->fetch();
        }

        $currentUser = [];

        $currentUser['name'] = $user['firstname'] . ' ' . $user['lastname'];
        $currentUser['rank'] = $user['rank'];
        $currentUser['email'] = $user['email'];
        
        if(!$user['image']){
            if($user['gender'] == 1){
                $user['image'] = 'user/avatar-f.png';
            }
            else{
                $user['image'] = 'user/avatar-m.png';
            }
        }
        $currentUser['icon'] = $this->linker->getIcon($this->media->resize($user['image'], 50, 50, true));
        $currentUser['profile'] = $this->linker->getUrl('user/edit/' . $user['id'], true);
        $currentUser['reg'] = date('d/m/Y', $user['id']);

        $data['user'] = $currentUser;
		
		$data['commonSettingsUrl'] = $this->linker->getUrl('option', true);
        $data['additionalSettingsUrl'] = $this->linker->getUrl('option/additional', true);
        $data['translationsUrl'] = $this->linker->getUrl('translation', true);
        $data['xmlUploadUrl'] = $this->linker->getUrl('importproducts', true);

        $this->data = $data;

        return $this;
    }
    
}


