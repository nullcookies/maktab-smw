<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends Model {

    public function index(){
        $data = [];
        $this->document = new Document();
        
        $this->data = $data;
        return $this;
    }

    public function view(){
        
        $data = [];
        $this->document = new Document();

        $smallIconW = $this->getOption('icon_small_w');
        $smallIconH = $this->getOption('icon_small_h');
        $mediumIconW = $this->getOption('icon_medium_w');
        $mediumIconH = $this->getOption('icon_medium_h');
        $productIconW = $this->getOption('icon_product_w');
        $productIconH = $this->getOption('icon_product_h');
        $productIconLargeW = $this->getOption('icon_product_large_w');
        $productIconLargeH = $this->getOption('icon_product_large_h');
        $productIconSmallW = $this->getOption('icon_product_small_w');
        $productIconSmallH = $this->getOption('icon_product_small_h');
        
        $breadcrumbs = [];
        $name = '';
        $product = [];
        $newProducts = [];
        $similarProducts = [];
        $upsells = [];
        $crosssells = [];

        $brand = [];

        $categoryName = '';
        $categoryUrl = '';

        $id = (int)$_GET['param1'];

        $breadcrumbPages = ['home'];
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


        $currentProduct = $this->qb->where([['id', '?'], ['status', '1']])->get('??product', [$id])->fetch();
        if($currentProduct){
            
            //увеличиваем счетчик
            $this->qb->where('id', '?')->update('??product', ['views' => ($currentProduct['views'] + 1)], [$id]);

            $currentProduct = $this->langDecode($currentProduct, ['name', 'descr', 'descr_full', 'specifications', 'meta_t', 'meta_d', 'meta_k'], false);
            $currentProduct['options'] = json_decode($currentProduct['options'], true);

            $baseUrl = $this->linker->getUrl($currentProduct['alias']);
            
            $this->document->title = ($currentProduct['meta_t'][LANG_ID]) ? $currentProduct['meta_t'][LANG_ID] : $currentProduct['name'][LANG_ID];
            $this->document->description = $currentProduct['meta_d'][LANG_ID];
            $this->document->keywords = $currentProduct['meta_k'][LANG_ID];
            $this->document->canonical = $baseUrl;

            $data['feedbackUrl'] = $baseUrl;

            //картинки
            $name = $currentProduct['name'][LANG_ID];
            $currentProductImages = $this->getIcons($currentProduct['images']);
            foreach($currentProductImages as $value){
                $currentProduct['gallery'][] = [
                    'icon_small' => $this->linker->getIcon($this->media->resize($value, $productIconSmallW, $productIconSmallH, true)),
                    'icon' => $this->linker->getIcon($this->media->resize($value, $productIconW, $productIconH, true)),
                    'icon_large' => $this->linker->getIcon($this->media->resize($value, $productIconLargeW, $productIconLargeH, true)),
                    'image' => $this->linker->getIcon($value)
                ];
            }

            //цена
            $getPrice = $this->getPrice($currentProduct);
            $currentProduct['price_show'] = $getPrice['price_show'];
            $currentProduct['price_old'] = $getPrice['price_old'];
            
            
            //категория и раздел
            $currentCategory = $this->qb->where([['id', '?'], ['status', '1']])->get('??category', [$currentProduct['category_id']])->fetch();
            $currentCategoryParent = $this->qb->where([['id', '?'], ['status', '1']])->get('??category', [$currentCategory['parent_category_id']])->fetch();
            if($currentCategoryParent){
                $currentCategoryParent = $this->langDecode($currentCategoryParent, ['name'], false);
                $breadcrumbs[] = [
                    'name' => $currentCategoryParent['name'][LANG_ID],
                    'url' => $this->linker->getUrl($currentCategoryParent['alias'])
                ];
            }
            if($currentCategory){
                $currentCategory = $this->langDecode($currentCategory, ['name'], false);
                $categoryName = $currentCategory['name'][LANG_ID];
                $categoryUrl = $this->linker->getUrl($currentCategory['alias']);
                $breadcrumbs[] = [
                    'name' => $currentCategory['name'][LANG_ID],
                    'url' => $this->linker->getUrl($currentCategory['alias'])
                ];
            }

            //бренд
            $brand = $this->qb->where([['id', '?'], ['status', '1']])->get('??brand', [$currentProduct['brand_id']])->fetch();
            if($brand){
                $brand = $this->langDecode($brand, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k'], false);
                $brandMainIcon = $this->getMainIcon($brand['images']);

                $brand['icon'] = $this->linker->getIcon($this->media->resize($brandMainIcon, 160, 120));
                $brand['image'] = $this->linker->getIcon($brandMainIcon);
                $brand['url'] = $this->linker->getUrl($brand['alias']);
            }

            //breadcrubms
            $breadcrumbs[] = [
                'name' => $currentProduct['name'][LANG_ID],
                //'url' => $this->linker->getUrl($currentProduct['alias'])
                'url' => 'active'
            ];

            //reviews

            $reviews = $this->qb->where([['product_id', '?'], ['status', '1']])->get('??review', [$currentProduct['id']])->fetchAll();


            $links = $this->getLinks('product/view/%');


            //похожие товары
            $getSimilarProducts = $this->qb->where([['status', '1'], ['id !=', '?'], ['category_id', '?']])->limit(15)->order('price', true)->order('date_modify', true)->get('??product', [$currentProduct['id'], $currentProduct['category_id']]);
            //$getSimilarProducts = $this->qb->where([['status', '1'], ['id !=', '?'], ['category_id', '?'], ['price >', '?'], ['price <', '?']])->limit(3)->order('date_modify', true)->get('??product', [$currentProduct['id'], $currentProduct['category_id'], $currentProduct['price'] - 3000, $currentProduct['price'] + 3000]);
            if($getSimilarProducts->rowCount() > 0){
                $similarProducts = $getSimilarProducts->fetchAll();
                foreach($similarProducts as $key => $value){
                    $currentImage = $this->getMainIcon($value['images']);
                    $similarProducts[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $productIconW, $productIconH));
                    $mainLink = 'product/view/' . $value['id'];
                    $aliasLink = $links[$mainLink];
                    if($aliasLink){
                        $similarProducts[$key]['url'] = $this->linker->getUrl($aliasLink);
                    }
                    else{
                        $similarProducts[$key]['url'] = $this->linker->getUrl($mainLink);
                    }
                    //цена
                    $getPrice = $this->getPrice($value);
                    $similarProducts[$key]['price_show'] = $getPrice['price_show'];
                    $similarProducts[$key]['price_old'] = $getPrice['price_old'];
                }
                $similarProducts = $this->langDecode($similarProducts, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
            }

            //upsells
            $currentProduct['up_sells'] = json_decode($currentProduct['up_sells'], true);
            if($currentProduct['up_sells']){
                $getUpsells = $this->qb->where([['status', '1'], ['id IN', $currentProduct['up_sells']]])->limit(15)->order('price', true)->order('date_modify', true)->get('??product');
                if($getUpsells->rowCount() > 0){
                    $upsells = $getUpsells->fetchAll();
                    foreach($upsells as $key => $value){
                        $currentImage = $this->getMainIcon($value['images']);
                        $upsells[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $productIconW, $productIconH));
                        $mainLink = 'product/view/' . $value['id'];
                        $aliasLink = $links[$mainLink];
                        if($aliasLink){
                            $upsells[$key]['url'] = $this->linker->getUrl($aliasLink);
                        }
                        else{
                            $upsells[$key]['url'] = $this->linker->getUrl($mainLink);
                        }
                        //цена
                        $getPrice = $this->getPrice($value);
                        $upsells[$key]['price_show'] = $getPrice['price_show'];
                        $upsells[$key]['price_old'] = $getPrice['price_old'];
                    }
                    $upsells = $this->langDecode($upsells, ['name', 'descr']);
                }
            }

            //crosssells
            $currentProduct['cross_sells'] = json_decode($currentProduct['cross_sells'], true);
            if($currentProduct['cross_sells']){
                $getCrosssells = $this->qb->where([['status', '1'], ['id IN', $currentProduct['cross_sells']]])->limit(15)->order('price', true)->order('date_modify', true)->get('??product');
                if($getCrosssells->rowCount() > 0){
                    $crosssells = $getCrosssells->fetchAll();
                    foreach($crosssells as $key => $value){
                        $currentImage = $this->getMainIcon($value['images']);
                        $crosssells[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $productIconW, $productIconH));
                        $mainLink = 'product/view/' . $value['id'];
                        $aliasLink = $links[$mainLink];
                        if($aliasLink){
                            $crosssells[$key]['url'] = $this->linker->getUrl($aliasLink);
                        }
                        else{
                            $crosssells[$key]['url'] = $this->linker->getUrl($mainLink);
                        }
                        //цена
                        $getPrice = $this->getPrice($value);
                        $crosssells[$key]['price_show'] = $getPrice['price_show'];
                        $crosssells[$key]['price_old'] = $getPrice['price_old'];
                    }
                    $crosssells = $this->langDecode($crosssells, ['name', 'descr']);
                }
            }
                




            //new products
            $getNewProducts = $this->qb->where('status', '1')->limit(4)->order('date_modify', true)->get('??product');
            if($getNewProducts->rowCount() > 0){
                $newProducts = $getNewProducts->fetchAll();
                foreach($newProducts as $key => $value){
                    $currentImage = $this->getMainIcon($value['images']);
                    $newProducts[$key]['icon'] = $this->linker->getIcon($this->media->resize($currentImage, $smallIconW, $smallIconH));
                    $mainLink = 'product/view/' . $value['id'];
                    $aliasLink = $links[$mainLink];
                    if($aliasLink){
                        $newProducts[$key]['url'] = $this->linker->getUrl($aliasLink);
                    }
                    else{
                        $newProducts[$key]['url'] = $this->linker->getUrl($mainLink);
                    }
                }
                $newProducts = $this->langDecode($newProducts, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
            }
            $product = $currentProduct;
        }
        else{
            return false;
        }

        $prevProduct = [];
        $nextProduct = [];
        if($currentCategory){
            $prevProduct = $this->qb->where([['id <', '?'], ['status', '1'], ['category_id', '?']])->order('id', true)->limit(1)->get('??product', [$id, $currentCategory['id']])->fetch();
            if($prevProduct){
                $prevProduct = $this->langDecode($prevProduct, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k'], false);
                $prevProduct['url'] = $this->linker->getUrl($prevProduct['alias']);
            }
            $nextProduct = $this->qb->where([['id >', '?'], ['status', '1'], ['category_id', '?']])->order('id', false)->limit(1)->get('??product', [$id, $currentCategory['id']])->fetch();
            if($nextProduct){
                $nextProduct = $this->langDecode($nextProduct, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k'], false);
                $nextProduct['url'] = $this->linker->getUrl($nextProduct['alias']);
            }
        }
        $data['prevProduct'] = $prevProduct;
        $data['nextProduct'] = $nextProduct;

        $user = [];
        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
            $user = $this->qb->select(['firstname', 'email'])->where('id', '?')->get('??user', [$_SESSION['user_id']])->fetch();
        }
        $data['user'] = $user;

        $data['name'] = $name;
        $data['product'] = $product;
        $data['newProducts'] = $newProducts;
        $data['upsells'] = $upsells;
        $data['crosssells'] = $crosssells;
        $data['similarProducts'] = $similarProducts;
        $data['breadcrumbs'] = $breadcrumbs;

        $data['brand'] = $brand;
        $data['reviews'] = $reviews;

        $data['categoryName'] = $categoryName;
        $data['categoryUrl'] = $categoryUrl;

        $data['addReviewUrl'] = $this->linker->getUrl('product/addreview');


        $data['requestProductUrl'] = $this->linker->getUrl('cart/request');
        $data['addCartUrl'] = $this->linker->getUrl('cart/add');
        $data['checkoutUrl'] = $this->linker->getUrl('cart/checkout');
        $data['changeCartUrl'] = $this->linker->getUrl('cart/change');
        $data['deleteCartUrl'] = $this->linker->getUrl('cart/delete');

        
        $this->data = $data;

        return $this;
    }

    public function addreview() {   
        
        $data = [];
        $success = false;
        $message = '';
        $errors = [];

        $rules = [ 
            'post' => [
                'product_id' => ['isRequired'],
                'name' => ['isRequired'],
                'email' => ['isEmail'],
                'message' => ['isRequired'],
            ],
            'files' => [
                
            ]
        ];
        $_POST = $this->cleanForm($_POST);

        $valid = $this->validator->validate($rules, ['post' => $_POST]);

        if(!$valid){
            $errors = $this->validator->lastErrors;
            $message = $this->translation('please fill in all fields');
        }
        else{
            $insertRow = [];
            $insertRow['product_id'] = $_POST['product_id'];
            $insertRow['name'] = $_POST['name'];
            $insertRow['email'] = $_POST['email'];
            $insertRow['message'] = $_POST['message'];
            $insertRow['user_id'] = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;
            $insertRow['rating'] = 0;
            $insertRow['date_add'] = time();
            $insertRow['status'] = 0;
            $insertRow['new'] = 1;


            $result = $this->qb->insert('??review', $insertRow);
            if($result == false){
                $success = false;
                $message = $this->translation('error database connect');
            }
            else{
                $success = true;
                $message = $this->translation('you review accepted');
            }
        }

        $data['message'] = $message;
        $data['success'] = $success;
        $data['errors'] = $errors;
        

        $this->data = $data;
        return $this;
    }

    public function search() {

        $smallIconW = $this->getOption('icon_small_w');
        $smallIconH = $this->getOption('icon_small_h');
        $mediumIconW = $this->getOption('icon_medium_w');
        $mediumIconH = $this->getOption('icon_medium_h');
        $productIconW = $this->getOption('icon_product_w');
        $productIconH = $this->getOption('icon_product_h');

        $data = [];
        $this->document = new Document();

        $breadcrumbPages = ['home'];
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
        $this->document->title = $this->translation('search');
        $breadcrumbs[] = [
            'name' => $this->translation('search'),
            'url' => $this->linker->getUrl('product/search')
        ];

        $page = (isset($_GET['page'])) ? (int)$_GET['page']: 1;
        if($page < 1) $page = 1;
        $quantity = (isset($_GET['quantity'])) ? (int)$_GET['quantity']: 12;
        if($quantity < 1) $quantity = 1;
        $offset = ($page - 1) * $quantity;

        $links = $this->getLinks('product/view/%');

        $allQuantity = 0;
        $products = [];
        $pagination = [];
        $id = (int)$_GET['param1'];
        $getProducts = [];

        $search = '';
        $searchText = '';

        if($_POST['search']){
            $search = $_POST['search'];
            $searchText = substr(htmlspecialchars(trim($_POST['search'])), 0, 65536);
            $searchTextlength = mb_strlen($searchText, "UTF-8");
            $params1 = [];
            $params2 = [];
            if($searchTextlength == 2 || $searchTextlength == 3){
                
                $where = ' WHERE ';
                $searchText = explode(' ', $searchText);
                foreach($searchText as $key => $value){
                    if(strlen(trim($value)) > 1){
                        $where .= ' p.name LIKE ? AND ';
                        $params1[] = '%' . $value . '%';
                    }
                }
                $where = substr($where, 0, -4);
                $queryCount1 = 'SELECT COUNT(*) cnt FROM ??product p' . $where;
                $sth1 = $this->qb->prepare($queryCount1);
                $sth1->execute($params1);
                $resultCount1 = (int)$sth1->fetch()['cnt'];
                if($resultCount1 > 0){
                    $allQuantity = $resultCount1;
                    $query1 = 'SELECT * FROM ??product p ' . $where . ' LIMIT ?, ?';
                    $sthProducts1 = $this->qb->prepare($query1);
                    $params1Count = count($params1);
                    for($i = 1; $i <= $params1Count; $i++){
                        $sthProducts1->bindParam($i, $params1[$i - 1]);
                    }
                    $sthProducts1->bindParam(++$params1Count, $offset, \PDO::PARAM_INT);
                    $sthProducts1->bindParam(++$params1Count, $quantity, \PDO::PARAM_INT);
                    $sthProducts1->execute();
                    if($sthProducts1->rowCount() > 0){
                        $getProducts = $sthProducts1->fetchAll();
                    }
                }
            }
            elseif($searchTextlength > 3){
                $searchText = explode(' ', $searchText);
                foreach($searchText as $key => $value){
                    $searchText[$key] = $value . '*';
                }
                $searchText = implode(' ', $searchText);
                
                $queryCount2 = "SELECT COUNT(*) cnt FROM ??product p INNER JOIN ??product_search ps ON ps.product_id = p.id WHERE MATCH(ps.search_text) AGAINST (? IN BOOLEAN MODE) > 0";
                $params2[] = $searchText;
                $sth2 = $this->qb->prepare($queryCount2);
                $sth2->execute($params2);
                $resultCount2 = (int)$sth2->fetch()['cnt'];
                if($resultCount2 > 0){
                    $allQuantity = $resultCount2;
                    $query2 = 'SELECT p.*, MATCH(ps.search_text) AGAINST (? IN BOOLEAN MODE) as rel FROM ??product p INNER JOIN ??product_search ps ON ps.product_id = p.id WHERE MATCH(ps.search_text) AGAINST (? IN BOOLEAN MODE) > 0 ORDER BY MATCH(ps.search_text) AGAINST (? IN BOOLEAN MODE) DESC LIMIT ?, ?';

                    $sthProducts2 = $this->qb->prepare($query2);
                    $sthProducts2->bindParam(1, $searchText);
                    $sthProducts2->bindParam(2, $searchText);
                    $sthProducts2->bindParam(3, $searchText);
                    $sthProducts2->bindParam(4, $offset, \PDO::PARAM_INT);
                    $sthProducts2->bindParam(5, $quantity, \PDO::PARAM_INT);
                    $sthProducts2->execute();
                    if($sthProducts2->rowCount() > 0){
                        $getProducts = $sthProducts2->fetchAll();
                    }
                } 
            }

            $paginationParams = [
                'urlParams' => ['alias' => 'product/search', 'quantity' => $quantity],
                'allQuantity' => $allQuantity,
                'quantity' => $quantity,
                'page' => $page
            ];
            $pagination = $this->getPagination($paginationParams);

            if($getProducts){
                $productModel = new ProductModel();
                $products = $getProducts;
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
        }

        $data['search'] = $search;

        $data['allQuantity'] = $allQuantity;
        $data['products'] = $products;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pagination'] = $pagination;

        $data['addCartUrl'] = $this->linker->getUrl('cart/add');
        $data['checkoutUrl'] = $this->linker->getUrl('cart/checkout');

        $this->data = $data;
        return $this;

    }

    public function getPrice($product) {
        $return = [];
        $exchange = $this->getExchangeRate();

        $return['price_show'] = round($product['price'] * $exchange, 2);
        $return['price_old'] = round($product['price'] * $exchange, 2);
        if($product['discount'] > 0){
            $return['price_show'] = round($product['price'] * (1 - $product['discount'] / 100) * $exchange, 2);
        }
        return $return;
    }

    public function getExchangeRate() {
        $exchange = 1;
        if(null !== $this->getOption('exchange')){
            $exchange = (int)$this->getOption('exchange');
            if($exchange <= 0){
                $exchange = 1;
            }
        }
        return $exchange;
    }
    
}



