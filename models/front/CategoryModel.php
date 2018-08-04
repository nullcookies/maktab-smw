<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryModel extends Model {

    public function index(){

        $mediumIconW = (int)$this->getOption('icon_medium_w');
        $mediumIconH = (int)$this->getOption('icon_medium_h');

        $categoryIconW = (int)$this->getOption('icon_category_w');
        if(!$categoryIconW){
            $categoryIconW = $mediumIconW; 
        }
        $categoryIconH = (int)$this->getOption('icon_category_h');
        if(!$categoryIconH){
            $categoryIconH = $mediumIconH; 
        }

        $productIconW = (int)$this->getOption('icon_product_w');
        if(!$productIconW){
            $productIconW = $mediumIconW; 
        }
        $productIconH = (int)$this->getOption('icon_product_h');
        if(!$productIconH){
            $productIconH = $mediumIconH; 
        }

        $data = [];

        $this->document = new Document();
        //echo $this->linker->getUrl('');
        $breadcrumbs = [];
        $breadcrumbPages = [1, 2];
        $statement = $this->qb->where([['side', 'front'], ['id', '?']])->getStatement('??page');
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
                        'url' => ($value == 2) ? 'active' : $this->linker->getUrl($breadcrumb['alias']),
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

        $links = $this->getLinks('category/view/%');
        $linksProduct = $this->getLinks('product/view/%');

        $categories = [];
        $getCategories = $this->qb->where('status', '1')->order('sort_number')->get('??category');
        $productsStatement = $this->qb->select('id, name, alias, images')->where([['status', '1'], ['recommended', '1'], ['category_id', '?']])->limit(20)->getStatement('??product');
        $productsSth = $this->qb->prepare($productsStatement);

        if($getCategories->rowCount() > 0){
            
            $categories = $getCategories->fetchAll();
            foreach($categories as $key => $value){
                $mainIcon = $this->getMainIcon($value['images']);
                $categories[$key]['icon'] = $this->linker->getIcon($this->media->resize($mainIcon, $categoryIconW, $categoryIconH, true));
                $mainLink = 'category/view/' . $value['id'];
                $aliasLink = $links[$mainLink];
                if($aliasLink){
                    $categories[$key]['url'] = $this->linker->getUrl($aliasLink);
                }
                else{
                    $categories[$key]['url'] = $this->linker->getUrl($mainLink);
                }
                $categories[$key]['products'] = [];
                $productsSth->execute([$value['id']]);
                if($productsSth->rowCount() > 0){
                    $categories[$key]['products'] = $productsSth->fetchAll();
                    $categories[$key]['products'] = $this->langDecode($categories[$key]['products'], ['name']);
                    foreach ($categories[$key]['products'] as $key1 => $value1) {
                        $mainProductIcon = $this->getMainIcon($value1['images']);
                        $categories[$key]['products'][$key1]['icon'] = $this->linker->getIcon($this->media->resize($mainProductIcon, $productIconW, $productIconH));
                        $mainProductLink = 'product/view/' . $value1['id'];
                        $aliasProductLink = $linksProduct[$mainProductLink];
                        if($aliasProductLink){
                            $categories[$key]['products'][$key1]['url'] = $this->linker->getUrl($aliasProductLink);
                        }
                        else{
                            $categories[$key]['products'][$key1]['url'] = $this->linker->getUrl($mainProductLink);
                        }
                    }
                }
            }
            $categories = $this->langDecode($categories, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['categories'] = $categories;
        $data['breadcrumbs'] = $breadcrumbs;

        $data['addCartUrl'] = $this->linker->getUrl('cart/add');
        $data['checkoutUrl'] = $this->linker->getUrl('cart/checkout');
        
        $this->data = $data;

        return $this;
    }
    
    public function view(){

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
        
        $data = [];
        $this->document = new Document();
        
        $breadcrumbs = [];
        $breadcrumbPages = [1, 2];
        $statement = $this->qb->where([['side', 'front'], ['id', '?']])->getStatement('??page');
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
        $brands = [];

        $categoryBaseUrl = '';

        $id = (int)$_GET['param1'];

        $currentCategory = $this->qb->where([['id', '?'], ['status', '1']])->get('??category', [$id])->fetch();
        if($currentCategory){
            $currentCategory = $this->langDecode($currentCategory, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k'], false);
            $this->document->title = ($currentCategory['meta_t'][LANG_ID]) ? $currentCategory['meta_t'][LANG_ID] : $currentCategory['name'][LANG_ID];
            $this->document->description = $currentCategory['meta_d'][LANG_ID];
            $this->document->keywords = $currentCategory['meta_k'][LANG_ID];
            $name = $currentCategory['name'][LANG_ID];

            $categoryBaseUrl = $this->linker->getUrl($currentCategory['alias']);
            $this->document->canonical = $categoryBaseUrl;
            $categoryBaseUrlOptions = $categoryBaseUrl;
            $categoryBaseUrlAdditional = [];

            //subcategories
            //$getCategories = $this->qb->where([['status', '1'], ['parent_category_id', '?']])->order('sort_number')->get('??category', [$currentCategory['id']]);
            //all categories
            $getCategories = $this->qb->select('id, name, alias, images, descr')->where([['status', '1']])->order('sort_number')->get('??category');
            if($getCategories->rowCount() > 0){
                $categories = $getCategories->fetchAll();
                $countCatProductsSth = $this->qb->prepare('SELECT COUNT(id) cnt FROM ??product WHERE category_id = ? AND status = 1');
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

                    //количество товаров
                    $countCatProductsSth->execute([$value['id']]);
                    $categories[$key]['cnt'] = $countCatProductsSth->fetch()['cnt'];
                }
                $categories = $this->langDecode($categories, ['name', 'descr']);
            }


            //родительская категория
            if($currentCategory['parent_category_id'] > 0){
                $currentParentCategory = $this->qb->where([['id', '?'], ['status', '1']])->get('??category', [$currentCategory['parent_category_id']])->fetch();
                if($currentParentCategory){
                    $currentParentCategory = $this->langDecode($currentParentCategory, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k'], false);
                    //крошки родительской категории
                    $breadcrumbs[] = [
                        'name' => $currentParentCategory['name'][LANG_ID],
                        'url' => $this->linker->getUrl($currentParentCategory['alias'])
                    ];
                }
            }


            //товары сортировка
            $brand_id = (isset($_GET['brand'])) ? (int)$_GET['brand']: '';
            if($brand_id){
                $categoryBaseUrlAdditional[] = 'brand=' . $brand_id;
            }
            $data['brand_id'] = $brand_id;

            $tag_id = (isset($_GET['tag'])) ? (int)$_GET['tag']: '';
            if($tag_id){
                $categoryBaseUrlAdditional[] = 'tag=' . $tag_id;
            }
            $data['tag_id'] = $tag_id;

            $filterIds = [];
            $filterValueIds = [];
            $filtersSelected = [];
            if(is_array($_POST['filter'])){
                foreach($_POST['filter'] as $key => $value){
                    $filterIds[] = $key;
                    if(is_array($value) && count($value) > 0){
                        if(!isset($filtersSelected[$key])){
                            $filtersSelected[$key] = [];
                        }
                        foreach($value as $key1 => $value1){
                            if($value1){
                                $filterValueIds[] = $key1;
                                $filtersSelected[$key][] = $key1;
                            }
                        }
                    }
                }
            }
            $data['filterValueIds'] = $filterValueIds;
            $data['filtersSelected'] = $filtersSelected;

            $order = (isset($_GET['order'])) ? (int)$_GET['order']: 3;
            if(isset($_POST['order'])){
                $order = (int)$_POST['order'];
            }
            if($order < 1) $order = 3;
            $categoryBaseUrlAdditional[] = 'order=' . $order;
            $data['order'] = $order;

            $page = (isset($_GET['page'])) ? (int)$_GET['page']: 1;
            if($page < 1) $page = 1;
            $categoryBaseUrlAdditional[] = 'page=' . $page;

            $quantity = (isset($_GET['quantity'])) ? (int)$_GET['quantity']: 12;
            if(isset($_POST['quantity'])){
                $quantity = (int)$_POST['quantity'];
            }
            if($quantity < 1) $quantity = 12;
            $categoryBaseUrlAdditional[] = 'quantity=' . $quantity;
            $data['quantity'] = $quantity;

            $offset = ($page - 1) * $quantity;

            $links = $this->getLinks('product/view/%');

            $sqlWhere = [];
            $sqlParams = [];

            $sqlWhere[] = ['p.status', '1'];
            $sqlWhere[] = ['p.category_id', '?'];
            $sqlParams[] = $id;

            $productIds = [];
            $noProducts = false;

            $tagProductIds = [];
            $filterProductIds = [];

            if($tag_id){
                $getTagProductIds = $this->qb->select('product_id')->where('tag_id', '?')->get('??tag_to_product', [$tag_id]);
                if($getTagProductIds->rowCount() > 0){
                    while($tagProductId = $getTagProductIds->fetchColumn()){
                        $tagProductIds[] = (int)$tagProductId;
                    }
                }
                if(!tagProductIds){
                    $noProducts = true;
                }
            }

            if($filterIds && $filterValueIds && $filtersSelected){
                $filterProductIds = [];
                $filterProductIdsCheck = [];

                $filterGroupsCnt = count($filtersSelected);

                $filtersQuery = 'SELECT f2p.product_id FROM ??filter_to_product f2p LEFT JOIN ??filter_value fv ON f2p.filter_value_id = fv.id LEFT JOIN ??filter f ON fv.filter_id = f.id WHERE f2p.filter_value_id IN (' . implode(',', $filterValueIds) . ') GROUP BY f2p.product_id HAVING COUNT(f.id) >= ' . $filterGroupsCnt;
                $checkFilterSth = $this->qb->prepare('SELECT COUNT(*) cnt FROM ??filter_to_product f2p LEFT JOIN ??filter_value fv ON f2p.filter_value_id = fv.id LEFT JOIN ??filter f ON fv.filter_id = f.id WHERE f2p.product_id = ? GROUP BY f.id');
                $getFilterProductIds = $this->qb->query($filtersQuery);
                if($getFilterProductIds->rowCount() > 0){
                    while($filterProductId = $getFilterProductIds->fetchColumn()){
                        $filterProductIdsCheck[] = $filterProductId;
                        $checkFilterSth->execute([$filterProductId]);
                        if($checkFilterSth->rowCount() >= $filterGroupsCnt){
                            $filterProductIds[] = (int)$filterProductId;
                        }
                    }
                }

                if(!$filterProductIds){
                    $noProducts = true;
                }
            }
            if(!$noProducts){
                if($tagProductIds){
                    $productIds = $tagProductIds;
                }
                if($filterProductIds){
                    if($productIds){
                        $productIds = array_intersect($productIds, $filterProductIds);
                        if(!$productIds){
                            $noProducts = true;
                        }
                    }
                    else{
                        $productIds = $filterProductIds;
                    }
                }
            }
            else{
                $productIds = [0];
            }

            if($productIds){
                $sqlWhere[] = ['p.id IN', $productIds];
            }

            //бренд
            if($brand_id){
                $sqlWhere[] = ['p.brand_id', '?'];
                $sqlParams[] = $brand_id;
                
            }

            //тег
            if($tag_id){
                
            }

            //price range
            $exchangeRate = (float)$this->getOption('exchange');
            if($exchangeRate <= 0){
                $exchangeRate = 1;
            }

            $price_range = [];
            if(isset($_POST['price_range'])){
                $price_range = explode(';', $_POST['price_range']);
                if(count($price_range) == 2){
                    $price_range[0] = (float)$price_range[0] / $exchangeRate;
                    $price_range[1] = (float)$price_range[1] / $exchangeRate;
                    if($price_range[0] > $price_range[1]){
                        $price_range_temp = $price_range[0];
                        $price_range[0] = $price_range[1];
                        $price_range[1] = $price_range_temp;
                    }
                }
                else{
                    $price_range = [];
                }
            }

            if($price_range){
                $sqlWhere[] = ['p.price >=', '?'];
                $sqlParams[] = $price_range[0];
                $sqlWhere[] = ['p.price <=', '?'];
                $sqlParams[] = $price_range[1];
            }

            $minPrice = (float)$this->qb->select('MIN(p.price) min_price')->where([['p.category_id', '?'], ['p.status', '1']])->get('??product p', [$id])->fetch()['min_price'];
            $maxPrice = (float)$this->qb->select('MAX(p.price) max_price')->where([['p.category_id', '?'], ['p.status', '1']])->get('??product p', [$id])->fetch()['max_price'];

            $data['categoryPriceRange'] = [$minPrice * $exchangeRate, $maxPrice * $exchangeRate];
            $data['selectedPriceRange'] = (count($price_range) == 2) ? [$price_range[0] * $exchangeRate, $price_range[1] * $exchangeRate] : [];            

            //all selected products quantity
            $allQuantity = $this->qb->select('p.id')->where($sqlWhere)->count('??product p', $sqlParams);

            $paginationParams = [
                'urlParams' => [
                    'alias' => $currentCategory['alias'], 
                    'order' => $order, 
                    'quantity' => $quantity
                ],
                'allQuantity' => $allQuantity,
                'quantity' => $quantity,
                'page' => $page
            ];
            if($tag_id){
                $paginationParams['urlParams']['tag'] = $tag_id;
            }
            if($brand_id){
                $paginationParams['urlParams']['brand'] = $brand_id;
            }
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
                case '6': 
                    $this->qb->order('p.price');
                    break;
                case '7': 
                    $this->qb->order('p.price', true);
                    break;
            }
            $getProducts = $this->qb->select('p.*')->where($sqlWhere)->offset($offset)->limit($quantity)->get('??product p', $sqlParams);
            //$this->ppp($getProducts);
            if($getProducts->rowCount() > 0){
                $productModel = new ProductModel();
                $products = $getProducts->fetchAll();
                foreach($products as $key => $value){
                    $currentImage = $this->getMainIcon($value['images']);
                    $products[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $mediumIconW, $mediumIconH));
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

            //фильтры
            $getFilters = $this->qb->select('fv.*, f.id f_id, f.name f_name')->join('??filter f', 'fv.filter_id = f.id')->order('fv.sort_number')->get('??filter_value fv')->fetchAll();
            $getFilters = $this->langDecode($getFilters, ['name', 'f_name']);
            foreach($getFilters as $value){
                if(!isset($filters[$value['filter_id']])){
                    $filters[$value['filter_id']] = [
                        'id' => $value['filter_id'],
                        'name' => $value['f_name'][LANG_ID],
                        'values' => [],
                    ];
                }
                $filters[$value['filter_id']]['values'][$value['id']] = [
                    'id' => $value['id'],
                    'name' => $value['name'][LANG_ID],
                    'color' => $value['color'],
                ];
            }

            //теги
            $getTags = $this->qb->select('t.id, t.name, COUNT(*) cnt')->join('??tag t', 't2p.tag_id = t.id')->join('??product p', 't2p.product_id = p.id')->where([['t.lang_id', '?'], ['p.category_id', '?']])->group('t2p.tag_id')->order('cnt', true)->get('??tag_to_product t2p', [LANG_ID, $id])->fetchAll();
            
            if($getTags){
                $tags = $getTags;
            }

            //бренды категории
            $catBrandIds = [];
            $getBrandIds = $this->qb->select('brand_id')->group('brand_id')->where('category_id', '?')->get('??product', [$id])->fetchAll();
            if($getBrandIds){
                foreach($getBrandIds as $value){
                    $catBrandIds[] = $value['brand_id'];
                }
            }

            if($catBrandIds){
                $getBrands = $this->qb->where('id IN', $catBrandIds)->get('??brand')->fetchAll();
                if($getBrands){
                    $getBrands = $this->langDecode($getBrands, ['name']);
                    foreach($getBrands as $key => $value){
                        $getBrands[$key]['url'] = $categoryBaseUrl . '?brand=' . $value['id'];
                    }
                    $brands = $getBrands;
                }

            }


            //крошки самой категории
            $breadcrumbs[] = [
                'name' => $currentCategory['name'][LANG_ID],
                //'url' => $this->linker->getUrl($currentCategory['alias'])
                'url' => 'active'
            ];

        }
        else{
            return false;
        }

        $data['currentCategory'] = $currentCategory;

        //category type variant 1
        // $categoryType = 'parent';
        // if($currentCategory['parent_category_id'] > 0){
        //     $categoryType = 'subcategory';
        // }

        //category type variant 2
        $categoryType = 'subcategory';
        $data['categoryType'] = $categoryType;

        $data['name'] = $name;
        $data['categories'] = $categories;
        $data['products'] = $products;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pagination'] = $pagination;

        $data['filters'] = $filters;
        $data['tags'] = $tags;
        $data['brands'] = $brands;

        if($categoryBaseUrlAdditional){
            $categoryBaseUrlOptions .= '?' . implode('&', $categoryBaseUrlAdditional);
        }

        $data['categoryBaseUrlOptions'] = $categoryBaseUrlOptions;
        $data['categoryBaseUrl'] = $categoryBaseUrl;

        $data['addCartUrl'] = $this->linker->getUrl('cart/add');
        $data['checkoutUrl'] = $this->linker->getUrl('cart/checkout');
        
        $this->data = $data;

        return $this;
    }

    private function getParentsTree($currentCat, $parents = array()){
        if($currentCat['parent_category_id'] != 0){
            $getParentCat = $this->db->select("category c", array("c.*", "cd.*"), "`id` = '" . $currentCat['parent_category_id'] . "' AND cd.lang = " . LANGUAGE, null, null, "LEFT JOIN `" . $this->db->prefix . "category_description` cd ON c.id = cd.category_id");
            $parentCat = $getParentCat[0];
			$parents[] = $parentCat;
            return $this->getParentsTree($parentCat, $parents);
        }
        else{
            return $parents;
        }
    }
    
}



