<?php

namespace models\front;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class MainMenuModel extends Model {

    public function index() {	
        
        $data = [];
        $menu = [];
        
        $links = $this->getLinks('category/view/%');
        $firstParent = 0;
        $menu = $this->getCategoriesTree($firstParent, $links);
        $data['menu'] = $menu;

        $categoryPage = false;
        $currentCategories = [];
        if(CONTROLLER == 'category'){
            $categoryPage = true;
        }
        if(CONTROLLER == 'category' || CONTROLLER == 'product'){
            $id = $_GET['param1'];
            if($id){

            }
        }
        $data['categoryPage'] = $categoryPage;
        $data['currentCategories'] = $currentCategories;

        $this->data = $data;
        return $this;
    }

    public function getCategoriesTree($parentCategoryId, $links = []){
        $menu = [];
        $parentCategoryId = (int)$parentCategoryId;
        $getMenu = $this->qb->where([['status', '1'], ['parent_category_id', '?']])->order('sort_number')->get('??category', [$parentCategoryId])->fetchAll();
        if($getMenu){
            $getMenu = $this->langDecode($getMenu, ['name']);
            foreach($getMenu as $key => $value){
                $currentImage = $this->getMainIcon($value['images']);
                $menu[$key]['name'] = $value['name'][LANG_ID];
                $menu[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, 20, 20, true));
                $mainLink = 'category/view/' . $value['id'];
                $aliasLink = $links[$mainLink];
                if($aliasLink){
                    $menu[$key]['url'] = $this->linker->getUrl($aliasLink);
                }
                else{
                    $menu[$key]['url'] = $this->linker->getUrl($mainLink);
                }
                $menu[$key]['submenu'] = $this->getCategoriesTree($value['id'], $links);

            }
        }
        return $menu;
    }
    
}


