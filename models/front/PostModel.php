<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class PostModel extends Model {

    /*
        $type - post type, e.g. post, news etc.
    */
    public $type = 0;

    /*
        $name = post id for translations
    */
    public $name = 'post';

    /*
        $pageId = page id id database
    */
    public $pageId = 0;

    /*
        post per page
    */
    public $postPerPage = 6;


    public function index(){

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

        $data = [];

        $data['type'] = $this->type;
        $data['typeName'] = $this->name;

        $this->document = new Document();
        //echo $this->linker->getUrl('');
        $breadcrumbs = [];
        $breadcrumbPages = [1, $this->pageId];
        $statement = $this->qb->where('id', '?')->getStatement('??page');
        $sth = $this->qb->prepare($statement);

        $pageFound = false;
        if($sth){
            foreach ($breadcrumbPages as $value) {
                $sth->execute([$value]);
                if($sth->rowCount() > 0){
                    $breadcrumb = $sth->fetchAll();
                    $breadcrumb = $this->langDecode($breadcrumb, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                    $breadcrumb = $breadcrumb[0];
                    $breadcrumbs[] = [
                        'name' => $breadcrumb['nav_name'][LANG_ID],
                        'url' => (($this->pageId == $breadcrumb['id']) ? 'active' : $this->linker->getUrl($breadcrumb['alias']))
                    ];
                    if($this->pageId == $breadcrumb['id']){
                        $pageFound = true;
                    }
                }
            }
            
        }

        $name = '';
        $textName = '';
        $textContent = '';

        //page hasn't been added yet 
        if(!$pageFound){
            if(ENVIRONMENT == 'dev'){
                echo 'add page ' . $this->pageId . ' - ' . $this->name;
            }
            return false;
        }
        else{
            $this->document->title = ($breadcrumb['meta_t'][LANG_ID]) ? $breadcrumb['meta_t'][LANG_ID] : $breadcrumb['name'][LANG_ID];
            $this->document->description = $breadcrumb['meta_d'][LANG_ID];
            $this->document->keywords = $breadcrumb['meta_k'][LANG_ID];
            $name = $breadcrumb['name'][LANG_ID];
            $textName = $breadcrumb['text_name'][LANG_ID];
            $textContent = $breadcrumb['descr_full'][LANG_ID];
        }

        $data['name'] = $name;
        $data['textName'] = $textName;
        $data['textContent'] = $textContent;

        $links = $this->getLinks($this->name . '/view/%');

        $pagination = [];
        $page = (isset($_GET['page'])) ? (int)$_GET['page']: 1;
        if($page < 1) $page = 1;
        $quantity = (isset($_GET['quantity'])) ? (int)$_GET['quantity']: $this->postPerPage;
        if($quantity < 1) $quantity = $this->postPerPage;
        $offset = ($page - 1) * $quantity;

        $allQuantity = $this->qb->select('id')->where([['status', '1'], ['type', $this->type]])->count('??post');
        $paginationParams = [
            'urlParams' => [
                'alias' => $breadcrumb['alias'],
                //'quantity' => $quantity
            ],
            'allQuantity' => $allQuantity,
            'quantity' => $quantity,
            'page' => $page
        ];
        $pagination = $this->getPagination($paginationParams);

        $posts = [];
        $getPosts = $this->qb->where([['status', '1'], ['type', $this->type]])->order('date_modify', true)->limit($quantity)->offset($offset)->get('??post');
        if($getPosts->rowCount() > 0){
            $posts = $getPosts->fetchAll();
            foreach($posts as $key => $value){
                $datetime = \DateTime::createFromFormat('d-m-Y', $value['date']);
                $posts[$key]['date'] = ($datetime !== false) ? $datetime->format('d-m-Y') : date('d-m-Y', $value['date_modify']);
                $currentImage = $this->getMainIcon($value['images']);
                $posts[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $postIconW, $postIconH, true));
                $mainLink = $this->name . '/view/' . $value['id'];
                $aliasLink = $links[$mainLink];
                if($aliasLink){
                    $posts[$key]['url'] = $this->linker->getUrl($aliasLink);
                }
                else{
                    $posts[$key]['url'] = $this->linker->getUrl($this->name . '/view/' . $value['id']);
                }
            }
            $posts = $this->langDecode($posts, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['posts'] = $posts;

        //banners
        $banners = [];
        $getBanners = $this->qb->where([['position', 'news section'], ['status', '1']])->order('sort_number')->get('??banner');
        if($getBanners->rowCount() > 0){
            $banners = $getBanners->fetchAll();
            $banners = $this->langDecode($banners, ['name', 'url']);
            foreach ($banners as $key => $value) {
                $mainIcon = $this->getMainIcon($value['images']);
                $banners[$key]['icon'] = $this->linker->getIcon($mainIcon);
            }
        }
        $data['banners'] = $banners;
        
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pagination'] = $pagination;


        $this->data = $data;

        return $this;
    }
    
    public function view(){
        
        $data = [];
        $this->document = new Document();

        $mediumIconW = (int)$this->getOption('icon_medium_w');
        $mediumIconH = (int)$this->getOption('icon_medium_h');
        
        $breadcrumbs = [];
        $breadcrumbPages = [1, $this->pageId];
        $statement = $this->qb->where('id', '?')->getStatement('??page');
        $sth = $this->qb->prepare($statement);
        if($sth){
            foreach ($breadcrumbPages as $value) {
                $sth->execute([$value]);
                if($sth->rowCount() > 0){
                    $breadcrumb = $sth->fetchAll();
                    $breadcrumb = $this->langDecode($breadcrumb, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                    $breadcrumb = $breadcrumb[0];
                    $breadcrumbs[] = [
                        'name' => $breadcrumb['nav_name'][LANG_ID],
                        'url' => $this->linker->getUrl($breadcrumb['alias'])
                    ];
                }
            }
            
        }

        $post = [];

        $id = (int)$_GET['param1'];

        $currentPost = $this->qb->where([['id', '?'], ['status', '1']])->get('??post', [$id])->fetch();
        if($currentPost){
            $currentPost = $this->langDecode($currentPost, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k'], false);
            $this->document->title = ($currentPost['meta_t'][LANG_ID]) ? $currentPost['meta_t'][LANG_ID] : $currentPost['name'][LANG_ID];
            $this->document->description = $currentPost['meta_d'][LANG_ID];
            $this->document->keywords = $currentPost['meta_k'][LANG_ID];

            $currentImage = $this->getMainIcon($currentPost['images']);
            $currentPost['icon'] = $this->linker->getIcon($this->media->resize($currentImage, 620, 392, true));

            $currentImages = $this->getIcons($currentPost['images']);
            array_shift($currentImages);
            foreach($currentImages as $value){
                $currentPost['gallery'][] = [
                    'icon' => $this->linker->getIcon($this->media->resize($value, $mediumIconW, $mediumIconH, true)),
                    'image' => $this->linker->getIcon($value)
                ];
            }

            $post = $currentPost;

            // $breadcrumbs[] = [
            //     'name' => $currentPost['name'][LANG_ID],
            //     //'url' => $this->linker->getUrl($currentPost['alias'])
            //     'url' => 'active'
            // ];

        }
        else{
            return false;
        }

        //banners
        $banners = [];
        $getBanners = $this->qb->where([['position', 'news section'], ['status', '1']])->order('sort_number')->get('??banner');
        if($getBanners->rowCount() > 0){
            $banners = $getBanners->fetchAll();
            $banners = $this->langDecode($banners, ['name', 'url']);
            foreach ($banners as $key => $value) {
                $mainIcon = $this->getMainIcon($value['images']);
                $banners[$key]['icon'] = $this->linker->getIcon($mainIcon);
            }
        }
        $data['banners'] = $banners;

        $page = $this->getSitePages($this->pageId);
        $data['page'] = $page[$this->pageId];

        $data['post'] = $post;

        $data['breadcrumbs'] = $breadcrumbs;

        
        $this->data = $data;

        return $this;
    }
    
}



