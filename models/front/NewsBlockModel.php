<?php

namespace models\front;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class NewsBlockModel extends Model {

    public function index() {	
        
        $data = [];

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
        
        //новости
        $news = [];
        $news1 = [];
        $news2 = [];
        $newsLinks = $this->getLinks('news/view/%');

        $getNews1 = $this->qb->select('id, name, descr, images, video_code, date, date_modify')->where([['status', '11'], ['type', 2], ['video_code !=', '?']])->order('date_modify', true)->limit(1)->get('??post', ['']);
        $news2Limit = 3;
        $newsHasVideo = false;
        if($getNews1->rowCount() > 0){
            $news2Limit = 2;
            $newsHasVideo = true;
        }
        $data['newsHasVideo'] = $newsHasVideo;

        $getNews2 = $this->qb->select('id, name, descr, images, date, date_modify')->where([['status', '1'], ['type', 2], ['video_code', '?']])->order('date_modify', true)->limit($news2Limit)->get('??post', ['']);
        if($getNews1->rowCount() > 0){
            $news1 = $getNews1->fetchAll();
        }        
        if($getNews2->rowCount() > 0){
            $news2 = $getNews2->fetchAll();
        }
        $news = array_merge($news1, $news2);
        
        foreach($news as $key => $value){
            $datetime = \DateTime::createFromFormat('Y/m/d', $value['date']);
            $news[$key]['date'] = ($datetime !== false) ? $datetime->format('d-m-Y') : date('d-m-Y', $value['date_modify']);
            $currentImage = $this->getMainIcon($value['images']);
            $news[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $postIconW, $postIconH, true));
            $news[$key]['icon_big'] = $this->linker->getIcon($this->media->resize($currentImage, 620, 349, true));
            $mainLink = 'news/view/' . $value['id'];
            $aliasLink = $newsLinks[$mainLink];
            if($aliasLink){
                $news[$key]['url'] = $this->linker->getUrl($aliasLink);
            }
            else{
                $news[$key]['url'] = $this->linker->getUrl($this->name . '/view/' . $value['id']);
            }
        }
        $news = $this->langDecode($news, ['name', 'descr']);
        $data['news'] = $news;

        $newsLink = [
            'name' => '',
            'url' => '',
        ];
        $getNewsLink = $this->qb->select('name, alias')->where([['controller', 'news'], ['method', 'index']])->get('??page');
        if($getNewsLink->rowCount() > 0){
            $getNewsLink = $getNewsLink->fetchAll();
            $getNewsLink = $this->langDecode($getNewsLink, ['name']);
            $getNewsLink = $getNewsLink[0];
            $newsLink['name'] = $getNewsLink['name'][LANG_ID];
            $newsLink['url'] = $this->linker->getUrl($getNewsLink['alias']);
        }
        $data['newsLink'] = $newsLink;


        $this->data = $data;
        return $this;
    }
    
}


