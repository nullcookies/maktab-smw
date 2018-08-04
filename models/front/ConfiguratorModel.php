<?php

namespace models\front;

use \system\Document;
use \system\Model;
use \models\front\ProductModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class ConfiguratorModel extends Model {

    public function index(){
        $data = [];
        $this->document = new Document();
        
        $this->data = $data;
        return $this;
    }

    public function view(){
        
        $data = [];
        $this->document = new Document();

        $productModel = new ProductModel();

        $smallIconW = $this->getOption('icon_small_w');
        $smallIconH = $this->getOption('icon_small_h');
        $mediumIconW = $this->getOption('icon_medium_w');
        $mediumIconH = $this->getOption('icon_medium_h');
        $productIconW = $this->getOption('icon_product_w');
        $productIconH = $this->getOption('icon_product_h');
        
        $breadcrumbs = [];

        $products = [];

        $breadcrumbPages = ['home', 'configurator'];
        $statement = $this->qb->where([['side', 'front'], ['controller', '?']])->getStatement('??page');
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

        $name = '';
        $textName = '';
        $textContent = '';
        if(isset($breadcrumb)){
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




        $getProducts = $this->qb->where([['status', '1'], ['request_product', '1']])->get('??product')->fetchAll();
        
        if($getProducts){
            foreach($getProducts as $product){

                $product = $this->langDecode($product, ['name', 'descr', 'descr_full', 'specifications', 'meta_t', 'meta_d', 'meta_k'], false);
                $product['options'] = json_decode($product['options'], true);

                //картинки
                $currentProductImages = $this->getIcons($product['images']);
                foreach($currentProductImages as $value){
                    $product['gallery'][] = [
                        'icon_small' => $this->linker->getIcon($this->media->resize($value, $smallIconW, $smallIconH)),
                        'icon' => $this->linker->getIcon($this->media->resize($value, $mediumIconW, $mediumIconH)),
                        'icon_product' => $this->linker->getIcon($this->media->resize($value, $productIconW, $productIconH)),
                        'image' => $this->linker->getIcon($value)
                    ];
                }

                //цена
                $getPrice = $productModel->getPrice($product);
                $product['price_show'] = $getPrice['price_show'];
                $product['price_old'] = $getPrice['price_old'];
                
                
                
                $products[] = $product;
            }
        }
        else{
            return false;
        }

        $user = [];
        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
            $user = $this->qb->select(['firstname', 'email'])->where('id', '?')->get('??user', [$_SESSION['user_id']])->fetch();
        }
        $data['user'] = $user;

        $data['products'] = $products;
        $data['breadcrumbs'] = $breadcrumbs;


        $data['requestProductUrl'] = $this->linker->getUrl('cart/request');
        $data['addCartUrl'] = $this->linker->getUrl('cart/add');
        $data['changeCartUrl'] = $this->linker->getUrl('cart/change');
        $data['deleteCartUrl'] = $this->linker->getUrl('cart/delete');

        
        $this->data = $data;

        return $this;
    }
    
}
