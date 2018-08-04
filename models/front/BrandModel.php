<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class BrandModel extends Model {

    public function index(){

        $mediumIconW = (int)$this->getOption('icon_medium_w');
        $mediumIconH = (int)$this->getOption('icon_medium_h');

        $data = [];
        $this->document = new Document();
        //echo $this->linker->getUrl('');
        $breadcrumbs = [];
        $breadcrumbPages = ['home', 'brand'];
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
                        'url' => (($value == 'brand') ? 'active' : $this->linker->getUrl($breadcrumb['alias']))
                    ];
                }
            }
            
        }
        $name = '';
        $textName = '';
        $textContent = '';
        if(isset($breadcrumb)){
            $this->document->title = ($breadcrumb['meta_t'][LANG_ID]) ? $breadcrumb['meta_t'][LANG_ID] : $breadcrumb['name'][LANG_ID];
            $name = $breadcrumb['name'][LANG_ID];
            $textName = $breadcrumb['text_name'][LANG_ID];
            $textContent = $breadcrumb['descr_full'][LANG_ID];

        }
        $data['name'] = $name;
        $data['textName'] = $textName;
        $data['textContent'] = $textContent;

        $getLinksSth = $this->qb->prepare('SELECT * FROM ??url WHERE route LIKE ?');
        $getLinksSth->execute(['brand/view/%']);
        $links = [];
        if($getLinksSth->rowCount() > 0){
            $getLinks = $getLinksSth->fetchAll();
            foreach($getLinks as $value){
                $links[$value['route']] = $value['alias'];
            }
        }

        $brands = [];
        $getBrands = $this->qb->where('status', '1')->order('sort_number')->get('??brand');
        if($getBrands->rowCount() > 0){
            $brands = $getBrands->fetchAll();
            foreach($brands as $key => $value){
                $currentImage = $this->getMainIcon($value['images']);
                $brands[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $mediumIconW, $mediumIconH));
                $mainLink = 'brand/view/' . $value['id'];
                $aliasLink = $links[$mainLink];
                if($aliasLink){
                    $brands[$key]['url'] = $this->linker->getUrl($aliasLink);
                }
                else{
                    $brands[$key]['url'] = $this->linker->getUrl('brand/view/' . $value['id']);
                }
            }
            $brands = $this->langDecode($brands, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['brands'] = $brands;
        

        

        $data['breadcrumbs'] = $breadcrumbs;




        
        $this->data = $data;

        return $this;
    }
    
    public function view(){
        
        $data = [];
        $this->document = new Document();

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
        
        $breadcrumbs = [];
        $breadcrumbPages = ['home', 'brand'];
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
        $categories = [];
        $products = [];
        $pagination = [];
        $filters = [];
        $tags = [];

        $currentBaseUrl = '';

        $id = (int)$_GET['param1'];

        $currentBrand = $this->qb->where([['id', '?'], ['status', '1']])->get('??brand', [$id])->fetch();
        if($currentBrand){
            $currentBrand = $this->langDecode($currentBrand, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k'], false);
            $this->document->title = ($currentBrand['meta_t'][LANG_ID]) ? $currentBrand['meta_t'][LANG_ID] : $currentBrand['name'][LANG_ID];
            $this->document->description = $currentBrand['meta_d'][LANG_ID];
            $this->document->keywords = $currentBrand['meta_k'][LANG_ID];
            $name = $currentBrand['name'][LANG_ID];

            $currentBaseUrl = $this->linker->getUrl($currentBrand['alias']);
            $this->document->canonical = $currentBaseUrl;
            $currentBaseUrlOptions = $currentBaseUrl;
            $currentBaseUrlAdditional = [];

            //подкатегории
            $categoryIds = [];
            $getBrandCategories = $this->qb->select('category_id')->where('brand_id', '?')->group('category_id')->get('??product', [$id]);
            $brandCategories = $getBrandCategories->fetchAll();
            if($brandCategories){
                foreach($brandCategories as $value){
                    $categoryIds[] = $value['category_id'];
                }
                $getCategories = $this->qb->where([['status', '1'], ['id IN', $categoryIds]])->order('sort_number')->get('??category');
                if($getCategories->rowCount() > 0){
                    $categories = $getCategories->fetchAll();
                    $countCatProductsSth = $this->qb->prepare('SELECT COUNT(id) cnt FROM ??product WHERE category_id = ? AND brand_id = ? AND status = 1');
                    $categoryLinks = $this->getLinks('category/view/%');
                    foreach($categories as $key => $value){
                        $currentImage = $this->getMainIcon($value['images']);
                        $categories[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $mediumIconW, $mediumIconH));
                        $mainLink = 'category/view/' . $value['id'];
                        $aliasLink = $categoryLinks[$mainLink];
                        if($aliasLink){
                            $categories[$key]['url'] = $this->linker->getUrl($aliasLink);
                        }
                        else{
                            $categories[$key]['url'] = $this->linker->getUrl($mainLink);
                        }
                        $categories[$key]['url'] .= '?brand=' . $id;

                        //количество товаров
                        $countCatProductsSth->execute([$value['id'], $id]);
                        $categories[$key]['cnt'] = $countCatProductsSth->fetch()['cnt'];
                    }
                    $categories = $this->langDecode($categories, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                }
            }

            //товары сортировка
            $order = (isset($_GET['order'])) ? (int)$_GET['order']: 1;
            if(isset($_POST['order'])){
                $order = (int)$_POST['order'];
            }
            if($order < 1) $order = 1;
            $currentBaseUrlAdditional[] = 'order=' . $order;
            $data['order'] = $order;

            $page = (isset($_GET['page'])) ? (int)$_GET['page']: 1;
            if($page < 1) $page = 1;
            $currentBaseUrlAdditional[] = 'page=' . $page;

            $quantity = (isset($_GET['quantity'])) ? (int)$_GET['quantity']: 20;
            if(isset($_POST['quantity'])){
                $quantity = (int)$_POST['quantity'];
            }
            if($quantity < 1) $quantity = 10;
            $currentBaseUrlAdditional[] = 'quantity=' . $quantity;
            $data['quantity'] = $quantity;

            $offset = ($page - 1) * $quantity;

            $links = $this->getLinks('product/view/%');

            $sqlWhere = [];
            $sqlParams = [];

            $sqlWhere[] = ['p.status', '1'];
            $sqlWhere[] = ['p.brand_id', '?'];
            $sqlParams[] = $id;

            
            $allQuantity = $this->qb->select('p.id')->where($sqlWhere)->count('??product p', $sqlParams);

            $paginationParams = [
                'urlParams' => [
                    'alias' => $currentBrand['alias'], 
                    'order' => $order, 
                    'quantity' => $quantity
                ],
                'allQuantity' => $allQuantity,
                'quantity' => $quantity,
                'page' => $page
            ];
            $pagination = $this->getPagination($paginationParams);

            switch($order){
                case '1': 
                    $this->qb->order('p.views', true);
                    break;
                case '2': 
                    $this->qb->order('p.date_modify');
                    break;
                case '3': 
                    $this->qb->order('p.date_modify', true);
                    break;
                case '4': 
                    $this->qb->order('pn.name');
                    $this->qb->join('??product_name pn', 'p.id = pn.product_id');
                    $sqlWhere[] = ['pn.lang_id', LANG_ID];
                    break;
                case '5': 
                    $this->qb->order('pn.name', true);
                    $this->qb->join('??product_name pn', 'p.id = pn.product_id');
                    $sqlWhere[] = ['pn.lang_id', LANG_ID];
                    break;
            }
            $getProducts = $this->qb->select('p.*')->where($sqlWhere)->offset($offset)->limit($quantity)->get('??product p', $sqlParams);

            if($getProducts->rowCount() > 0){
                $productModel = new ProductModel();
                $products = $getProducts->fetchAll();
                foreach($products as $key => $value){
                    $currentImage = $this->getMainIcon($value['images']);
                    $products[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $productIconW, $productIconH));
                    $mainLink = 'product/view/' . $value['id'];
                    $aliasLink = $links[$mainLink];
                    if($aliasLink){
                        $products[$key]['url'] = $this->linker->getUrl($aliasLink);
                    }
                    else{
                        $products[$key]['url'] = $this->linker->getUrl($mainLink);
                    }
                    $getPrice = $productModel->getPrice($value);
                    $products[$key]['price_show'] = $getPrice['price_show'];
                    $products[$key]['price_old'] = $getPrice['price_old'];
                }
                $products = $this->langDecode($products, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
            }


            //крошки самой категории
            $breadcrumbs[] = [
                'name' => $currentBrand['name'][LANG_ID],
                //'url' => $this->linker->getUrl($currentBrand['alias'])
                'url' => 'active'
            ];

        }
        else{
            return false;
        }

        $data['name'] = $name;
        $data['categories'] = $categories;
        $data['products'] = $products;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pagination'] = $pagination;

        $data['filters'] = $filters;
        $data['tags'] = $tags;

        if($currentBaseUrlAdditional){
            $currentBaseUrlOptions .= '?' . implode('&', $currentBaseUrlAdditional);
        }

        $data['currentBaseUrlOptions'] = $currentBaseUrlOptions;
        $data['currentBaseUrl'] = $currentBaseUrl;
        
        $this->data = $data;

        return $this;
    }

    public function slider(){

        $data = [];

        $brandIconW = (int)$this->getOption('icon_brand_w');
        $brandIconH = (int)$this->getOption('icon_brand_h');

        $links = $this->getLinks('brand/view/%');

        $brands = [];
        $getBrands = $this->qb->where('status', '1')->order('sort_number')->get('??brand');
        if($getBrands->rowCount() > 0){
            $brands = $getBrands->fetchAll();
            foreach($brands as $key => $value){
                $mainIcon = $this->getMainIcon($value['images']);
                $brands[$key]['icon'] = $this->linker->getIcon($this->media->resize($mainIcon, $brandIconW, $brandIconH));
                //$brands[$key]['icon'] = $this->linker->getIcon($mainIcon);
                $mainLink = 'brand/view/' . $value['id'];
                $aliasLink = $links[$mainLink];
                if($aliasLink){
                    $brands[$key]['url'] = $this->linker->getUrl($aliasLink);
                }
                else{
                    $brands[$key]['url'] = $this->linker->getUrl('brand/view/' . $value['id']);
                }
            }
            $brands = $this->langDecode($brands, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['brands'] = $brands;
        

        

        $data['breadcrumbs'] = $breadcrumbs;




        
        $this->data = $data;

        return $this;
    }
    
}



