<?php

namespace models\front;

use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class NewProductsModel extends Model {

    public function index() {	
        
        $data = [];

        $mediumIconW = (int)$this->getOption('icon_medium_w');
        $mediumIconH = (int)$this->getOption('icon_medium_h');

        $productIconW = (int)$this->getOption('icon_product_w');
        if(!$productIconW){
            $productIconW = $mediumIconW; 
        }
        $productIconH = (int)$this->getOption('icon_product_h');
        if(!$productIconH){
            $productIconH = $mediumIconH; 
        }
        
        $productModel = new ProductModel();

        $productLinks = $this->getLinks('product/view/%');
        $newProducts = [];
        $getNewProducts = $this->qb->where([['status', '1']])->order('date_modify', true)->limit(10)->get('??product');

        if($getNewProducts->rowCount() > 0){
            $newProducts = $getNewProducts->fetchAll();
            foreach($newProducts as $key => $value){
                //цена
                $getPrice = $productModel->getPrice($value);
                $newProducts[$key]['price_show'] = $getPrice['price_show'];
                $newProducts[$key]['price_old'] = $getPrice['price_old'];

                $newProductImage = $this->getMainIcon($value['images']);
                $newProducts[$key]['icon'] = $this->linker->getIcon($this->media->resize($newProductImage, $productIconW, $productIconH, true));
                $mainLink = 'product/view/' . $value['id'];
                $aliasLink = $productLinks[$mainLink];
                if($aliasLink){
                    $newProducts[$key]['url'] = $this->linker->getUrl($aliasLink);
                }
                else{
                    $newProducts[$key]['url'] = $this->linker->getUrl($mainLink);
                }
            }
            $newProducts = $this->langDecode($newProducts, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['newProducts'] = $newProducts;

        $getCategoryPage = $this->getSitePages(2);
        $categoryPage = (isset($getCategoryPage[2])) ? $getCategoryPage[2] : [];
        $data['categoryPage'] = $categoryPage;

        $data['addCartUrl'] = $this->linker->getUrl('cart/add');
        $data['checkoutUrl'] = $this->linker->getUrl('cart/checkout');

        $this->data = $data;
        return $this;
    }

    public function side() {   
        
        $data = [];

        $smallIconW = (int)$this->getOption('icon_small_w');
        $smallIconH = (int)$this->getOption('icon_small_h');
        
        $productModel = new ProductModel();

        $productLinks = $this->getLinks('product/view/%');
        $newProducts = [];
        $getNewProducts = $this->qb->where([['status', '1'], ['request_product', '0']])->order('date_modify', true)->limit(5)->get('??product');
        if($getNewProducts->rowCount() > 0){
            $newProducts = $getNewProducts->fetchAll();
            foreach($newProducts as $key => $value){
                //цена
                $getPrice = $productModel->getPrice($value);
                $newProducts[$key]['price_show'] = $getPrice['price_show'];
                $newProducts[$key]['price_old'] = $getPrice['price_old'];

                $newProductImage = $this->getMainIcon($value['images']);
                $newProducts[$key]['icon'] = $this->linker->getIcon($this->media->resize($newProductImage, $smallIconW, $smallIconH));
                $mainLink = 'product/view/' . $value['id'];
                $aliasLink = $productLinks[$mainLink];
                if($aliasLink){
                    $newProducts[$key]['url'] = $this->linker->getUrl($aliasLink);
                }
                else{
                    $newProducts[$key]['url'] = $this->linker->getUrl($mainLink);
                }
            }
            $newProducts = $this->langDecode($newProducts, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['newProducts'] = $newProducts;

        $data['addCartUrl'] = $this->linker->getUrl('cart/add');
        $data['checkoutUrl'] = $this->linker->getUrl('cart/checkout');

        $this->data = $data;
        return $this;
    }
    
}


