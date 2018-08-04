<?php

namespace models\front;

use \system\Document;
use \system\Linker;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class SitemapModel extends Model {
    
    public function index(){
		
		$data = [];
		
		$linkers = [];
        
		//получаем модели линкеров для каждого языка
        $lang = $this->qb->where('status', '1')->get('??lang')->fetchAll();
        if($lang){
            foreach($lang as $value){
                if($value['main'] == 1){
                    $langPrefix = false;
                }
                else{
                    $langPrefix = $value['lang_prefix'];
                }
                $linkers[$value['id']] = new Linker($langPrefix);
            }
        }
        else{
            exit("no language");
        }
        
		//генерируем ссылки для каждого языка
        foreach($linkers as $linker){
            			
			//общие страницы
			$getPages = $this->qb->where([['status', '1'], ['side', 'front']])->get('??page')->fetchAll();
            if($getPages){
                foreach($getPages as $value){
                    $urls[] = array(
                        "loc" => $linker->getUrl($value['alias']),
                        "priority" => "0.9"
                    );
                }
            }
			
			//категории
            $getItems = $this->qb->where('status', '1')->get('??category')->fetchAll();
            if($getItems){
				$links = $this->getLinks('category/view/%');				
                foreach($getItems as $value){
					$mainLink = 'category/view/' . $value['id'];
					$aliasLink = $links[$mainLink];
					$url = '';
					if($aliasLink){
						$url = $linker->getUrl($aliasLink);
					}
					else{
						$url = $linker->getUrl($mainLink);
					}
					if($url){
						$urls[] = array(
							"loc" => $url,
							"priority" => "0.8"
						);
					}
                }
            }
			
			//бренды
            $getItems = $this->qb->where('status', '1')->get('??brand')->fetchAll();
            if($getItems){
				$links = $this->getLinks('brand/view/%');				
                foreach($getItems as $value){
					$mainLink = 'brand/view/' . $value['id'];
					$aliasLink = $links[$mainLink];
					$url = '';
					if($aliasLink){
						$url = $linker->getUrl($aliasLink);
					}
					else{
						$url = $linker->getUrl($mainLink);
					}
					if($url){
						$urls[] = array(
							"loc" => $url,
							"priority" => "0.7"
						);
					}
                }
            }
			
			//товары
            $getItems = $this->qb->where('status', '1')->get('??product')->fetchAll();
            if($getItems){
				$links = $this->getLinks('product/view/%');				
                foreach($getItems as $value){
					$mainLink = 'product/view/' . $value['id'];
					$aliasLink = $links[$mainLink];
					$url = '';
					if($aliasLink){
						$url = $linker->getUrl($aliasLink);
					}
					else{
						$url = $linker->getUrl($mainLink);
					}
					if($url){
						$urls[] = array(
							"loc" => $url,
							"priority" => "0.6"
						);
					}
                }
            }
        }
		
		//максимум 50к ссылок в файле
        $urls_count = count($urls);
        if($urls_count > 50000){
            $urls = array_slice($urls, 0, 50000);
        }
		
		$data['urls'] = $urls;
		
        $this->data = $data;

        return $this;
    }
}
