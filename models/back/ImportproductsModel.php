<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class ImportproductsModel extends Model {

    public function index() {
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control . ' page');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/css/fileinput.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/plugins/sortable.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/fileinput.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/locales/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.js');

        $controls = [];
        $controls['main'] = $this->linker->getUrl($this->control . '/index', true);
        $controls['export'] = $this->linker->getUrl($this->control . '/export', true);
        $controls['import'] = $this->linker->getUrl($this->control . '/import', true);
        $data['controls'] = $controls;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function export() {
        
        $filename = BASEPATH . '/uploads/xml/' . 'products.xml';

        $lang = $this->getActiveLangKeys();

        $getProducts = $this->qb->get('??product');
        if($getProducts->rowCount() > 0){
            $products = $getProducts->fetchAll();
            $products = $this->langDecode($products, ['name', 'descr', 'descr_full', 'specifications', 'meta_t', 'meta_d', 'meta_k']);
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="yes"?><catalog xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></catalog>');

            foreach ($products as $value) {
                $product = $xml->addChild('product');
                $product->addChild('sku', $value['sku']);
                $product->addChild('category_id', $value['category_id']);
                $product->addChild('alias', $value['alias']);
                $product->addChild('sort_number', $value['sort_number']);
                $product->addChild('price', $value['price']);
                $product->addChild('discount', $value['discount']);
                $product->addChild('stock_1', $value['stock_1']);
                $product->addChild('request_product', $value['request_product']);
                $product->addChild('status', $value['status']);
                
                $product_name = $product->addChild('name');
                foreach ($lang as $langKey => $langValue) {
                    $product_name->addChild($langValue, $value['name'][$langKey]);
                }
                $product_descr = $product->addChild('descr');
                foreach ($lang as $langKey => $langValue) {
                    $product_descr->addChild($langValue, $value['descr'][$langKey]);
                }
                $product_descr_full = $product->addChild('descr_full');
                foreach ($lang as $langKey => $langValue) {
                    $product_descr_full->addChild($langValue, $value['descr_full'][$langKey]);
                }
                $product_specifications = $product->addChild('specifications');
                foreach ($lang as $langKey => $langValue) {
                    $product_specifications->addChild($langValue, $value['specifications'][$langKey]);
                }
                $product_meta_t = $product->addChild('meta_t');
                foreach ($lang as $langKey => $langValue) {
                    $product_meta_t->addChild($langValue, $value['meta_t'][$langKey]);
                }
                $product_meta_d = $product->addChild('meta_d');
                foreach ($lang as $langKey => $langValue) {
                    $product_meta_d->addChild($langValue, $value['meta_d'][$langKey]);
                }
                $product_meta_k = $product->addChild('meta_k');
                foreach ($lang as $langKey => $langValue) {
                    $product_meta_k->addChild($langValue, $value['meta_k'][$langKey]);
                }
            }
            $xml->asXML($filename);
        }
        return $filename;
    }

    public function xml_escape($string){
        return '<![CDATA[' . $string . ']]>';
    }
    
    public function import(){

        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control . ' page');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/css/fileinput.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/plugins/sortable.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/fileinput.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/locales/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.js');

        $controls = [];
        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['export'] = $this->linker->getUrl($this->control . '/export', true);
        $controls['import'] = $this->linker->getUrl($this->control . '/import', true);
        $data['controls'] = $controls;

        $updated = 0;
        $inserted = 0;
        $errors = [];
        $fileErrors = [];

        $lang = $this->getActiveLangKeys();

        $rules = [ 
            'get' => [
                //'content' => ['isRequired'],
            ],
            'files' => [
                'file' => ['isXML'],
            ]
        ];
        $data['files'] = $_FILES;

        $data['errors'] = [];

        $valid = $this->validator->validate($rules, $data);

        if(!$valid){
            $this->errors = $this->validator->lastErrors;
            $this->errorText = $this->getTranslation('error file ' . $this->control);
        }
        else{
            $xml = simplexml_load_file($_FILES['file']['tmp_name']);
            if($xml){
                $sth = $this->qb->prepare('SELECT id FROM ??product WHERE sku = ?');
                $sthUpdate = $this->qb->prepare('UPDATE ??product SET alias = :alias, category_id = :category_id, sort_number = :sort_number, price = :price, discount = :discount, stock_1 = :stock_1, request_product = :request_product, status = :status, name = :name,  descr = :descr,  descr_full = :descr_full,  specifications = :specifications,  meta_t = :meta_t,  meta_d = :meta_d,  meta_k = :meta_k ,  date_modify = :date_modify WHERE id = :id');
                $sthInsert = $this->qb->prepare('INSERT INTO ??product (sku, alias, category_id, sort_number, price, discount, stock_1, request_product, status, name, descr, descr_full, specifications, meta_t, meta_d, meta_k, date_add, date_modify) VALUES  (:sku, :alias, :category_id, :sort_number, :price, :discount, :stock_1, :request_product, :status, :name, :descr, :descr_full, :specifications, :meta_t, :meta_d, :meta_k, :date_add, :date_modify)');
                foreach($xml as $product){
                    $rowErrors = [];
                    //validation sku
                    $productSKU = (string)$product->sku;
                    if($productSKU == ''){
                        $rowErrors[] =  $this->getTranslation('error sku empty');
                    }
                    $sth->execute([$productSKU]);

                    $productInsertUpdate = '';
                    $currentProduct = [];
                    if($sth->rowCount() > 0){
                        //update product
                        $productInsertUpdate = 'update';
                        $currentProduct = $sth->fetch();
                    }
                    else{
                        //insert product
                        $productInsertUpdate = 'insert';
                    }

                    //validation
                    $productAlias = strtolower(htmlspecialchars($product->alias));
                    $isUniqueParamsAlias = [
                        'table' => '??url',
                        'column' => 'alias'
                    ];
                    if($productInsertUpdate == 'update'){
                        $checkAlias = $this->qb->select('id')->where('route', 'product/view/' . $currentProduct['id'])->get('??url');
                        if($checkAlias->rowCount() > 0){
                            $aliasId = $checkAlias->fetch()['id'];
                            $isUniqueParamsAlias['id'] = $aliasId;
                        }
                    }
                    if(!$this->validator->isAlias($productAlias) ){
                        $rowErrors[] =  $this->getTranslation('error not alias');
                    }
                    elseif (!$this->validator->isUnique($productAlias, $isUniqueParamsAlias)) {
                        $rowErrors[] =  $this->getTranslation('error alias exist');
                    }

                    $categoryID = (int)$product->category_id;
                    if($categoryID == 0){
                        $rowErrors[] =  $this->getTranslation('error enter category ID');
                    }

                    //don't insert/update if errors
                    if(count($rowErrors)){
                        $fileErrors[$productSKU] = $rowErrors;
                        continue;
                    }



                    $updateProduct = [];
                    $updateProduct[':alias']            = $productAlias;
                    $updateProduct[':category_id']            = $categoryID;
                    $updateProduct[':sort_number']      = (int)$product->sort_number;
                    $updateProduct[':price']            = (float)$product->price;
                    $updateProduct[':discount']         = (int)$product->discount;
                    $updateProduct[':stock_1']          = (int)$product->stock_1;
                    $updateProduct[':request_product']  = ($product->request_product) ? 1 : 0;
                    $updateProduct[':status']           = ($product->status) ? 1 : 0;
                    
                    $updateProduct[':name']             = [];
                    $updateProduct[':descr']            = [];
                    $updateProduct[':descr_full']       = [];
                    $updateProduct[':specifications']   = [];
                    $updateProduct[':meta_t']           = [];
                    $updateProduct[':meta_d']           = [];
                    $updateProduct[':meta_k']           = [];
                    foreach ($lang as $key => $value) {
                        $updateProduct[':name'][$key]           = htmlspecialchars($product->name->{$value});
                        $updateProduct[':descr'][$key]          = htmlspecialchars($product->descr->{$value});
                        $updateProduct[':descr_full'][$key]     = htmlspecialchars($product->descr_full->{$value});
                        $updateProduct[':specifications'][$key] = htmlspecialchars($product->specifications->{$value});
                        $updateProduct[':meta_t'][$key]         = htmlspecialchars($product->meta_t->{$value});
                        $updateProduct[':meta_d'][$key]         = htmlspecialchars($product->meta_d->{$value});
                        $updateProduct[':meta_k'][$key]         = htmlspecialchars($product->meta_k->{$value});
                    }
                    $updateProduct[':name']             = json_encode($updateProduct[':name'], JSON_UNESCAPED_UNICODE);
                    $updateProduct[':descr']            = json_encode($updateProduct[':descr'], JSON_UNESCAPED_UNICODE);
                    $updateProduct[':descr_full']       = json_encode($updateProduct[':descr_full'], JSON_UNESCAPED_UNICODE);
                    $updateProduct[':specifications']   = json_encode($updateProduct[':specifications'], JSON_UNESCAPED_UNICODE);
                    $updateProduct[':meta_t']           = json_encode($updateProduct[':meta_t'], JSON_UNESCAPED_UNICODE);
                    $updateProduct[':meta_d']           = json_encode($updateProduct[':meta_d'], JSON_UNESCAPED_UNICODE);
                    $updateProduct[':meta_k']           = json_encode($updateProduct[':meta_k'], JSON_UNESCAPED_UNICODE);
                    $updateProduct[':date_modify']      = time();


                    $productID = 0;
                    if($productInsertUpdate == 'update'){
                        //update product
                        $productID = $currentProduct['id'];
                        $updateProduct[':id'] = $productID;
                        $resultUpdate = $sthUpdate->execute($updateProduct);
                        if(!$resultUpdate){
                            $rowErrors[] = $this->getTranslation('db update error');
                        }
                        else{
                            $updated++;
                        }
                    }
                    elseif($productInsertUpdate == 'insert'){
                        //insert product
                        $updateProduct[':sku'] = $productSKU;
                        $updateProduct[':date_add'] = time();
                        $resultInsert = $sthInsert->execute($updateProduct);
                        if(!$resultInsert){
                            $rowErrors[] = $this->getTranslation('db update error');
                        }
                        else{
                            $inserted++;
                        }
                        $productID = $this->qb->lastInsertId();
                    }

                    if($productID > 0){
                        $insertUpdateProductName = json_decode($updateProduct[':name'], true);
                        //обновление url товара
                        $urlInsertUpdate = [
                            'alias' => $productAlias,
                            'route' => 'product/view/' . $productID
                        ];
                        $this->qb->insertUpdate('??url', $urlInsertUpdate);

                        //обновление поисковой и сортировочной информации товара
                        $searchInsertUpdate = [
                            'product_id' => $productID,
                            'search_text' => implode(' ', $insertUpdateProductName)
                        ];
                        $this->qb->insertUpdate('??product_search', $searchInsertUpdate);
                        foreach($insertUpdateProductName as $key => $value){
                            $nameInsertUpdate = [
                                'product_id' => $productID,
                                'lang_id' => $key,
                                'name' => $value
                            ];
                            $this->qb->insertUpdate('??product_name', $nameInsertUpdate);
                        }
                    }

                    if(count($rowErrors)){
                        $fileErrors[$productSKU] = $rowErrors;
                        continue;
                    }
                    
                }
            }

            $this->successText = $this->getTranslation('success file ' . $this->control);
        }

        $data['fileErrors'] = $fileErrors;
        $data['inserted'] = $inserted;
        $data['updated'] = $updated;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        //return $data;

        $this->data = $data;
        return $this;
        
    }
    
    
}

