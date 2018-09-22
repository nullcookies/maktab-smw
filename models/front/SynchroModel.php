<?php

namespace models\front;

use \system\Document;
use \system\Model;

use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7;
use \GuzzleHttp\Exception\RequestException;

defined('BASEPATH') OR exit('No direct script access allowed');

class SynchroModel extends Model {

    public function index(){

        $data = [];

        $data['success'] = true;
        
        $this->data = $data;

        return $this;
    }
    
    public function start(){

        ini_set('max_execution_time', 300);
        set_time_limit(3600);
        
        $data = [];
        $errors = [];

        if(!isset($_GET['synchkey']) || $_GET['synchkey'] != $this->config['synchKey']){
            $errors['synchkey'] = $this->t('invalid');
        }
        
        if(count($errors) == 0){

            $client = new Client(['base_uri' => $this->config['synchApi']]);

            /*brand synch start*/
            $brand = [];
            $response = $client->request('GET', 'brand/?apikey=' . $this->config['synchApiKey']);
            $getBrand = json_decode($response->getBody(), true);
            if($getBrand['success']){

                $brand['success'] = true;
                $brand['imported'] = 0;
                
                $brands = $getBrand['brand'];
                
                if(NULL != $brands && count($brands) > 0){
                    $this->qb->query("UPDATE ??brand SET status = -1");
                    $tableKeys = array_keys($brands[0]);

                    $checkSth = $this->qb->prepare("SELECT id FROM ??brand WHERE id = :id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??brand (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    array_shift($tableKeys);
                    $tableUpdateSql = '';
                    foreach ($tableKeys as $value) {
                        $tableUpdateSql .= $value . ' = :' . $value . ', ';
                    }
                    $tableUpdateSql = substr($tableUpdateSql, 0, -2);
                    $updateSth = $this->qb->prepare("UPDATE ??brand SET " . $tableUpdateSql . " WHERE id = :id ");

                    $brands = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $brands);

                    foreach ($brands as $item) {
                        $checkSth->execute([':id' => $item[':id']]);
                        if($checkSth->rowCount() > 0){
                            $result = $updateSth->execute($item);
                        }
                        else{
                            $result = $insertSth->execute($item);
                        }
                        if($result){
                            $brand['imported']++;
                        }
                    }
                }

                $brand['success'] = true;
            }
            else{
                $brand['success'] = false;
            }
            $data['brand'] = $brand;

            /*category synch start*/
            $category = [];
            $response = $client->request('GET', 'category/?apikey=' . $this->config['synchApiKey']);
            $getCategory = json_decode($response->getBody(), true);
            if($getCategory['success']){

                $category['success'] = true;
                $category['imported'] = 0;
                
                $categories = $getCategory['category'];
                $categoryNames = $getCategory['category_name'];
                $categorySearch = $getCategory['category_search'];
                
                if(NULL != $categories && count($categories) > 0){
                    $this->qb->query("UPDATE ??category SET status = -1");
                    $tableKeys = array_keys($categories[0]);

                    $checkSth = $this->qb->prepare("SELECT id FROM ??category WHERE id = :id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??category (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    array_shift($tableKeys);
                    $tableUpdateSql = '';
                    foreach ($tableKeys as $value) {
                        $tableUpdateSql .= $value . ' = :' . $value . ', ';
                    }
                    $tableUpdateSql = substr($tableUpdateSql, 0, -2);
                    $updateSth = $this->qb->prepare("UPDATE ??category SET " . $tableUpdateSql . " WHERE id = :id ");

                    $categories = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $categories);

                    foreach ($categories as $item) {
                        $checkSth->execute([':id' => $item[':id']]);
                        if($checkSth->rowCount() > 0){
                            $result = $updateSth->execute($item);
                        }
                        else{
                            $result = $insertSth->execute($item);
                        }
                        if($result){
                            $category['imported']++;
                        }
                    }
                }

                if(NULL != $categoryNames && count($categoryNames) > 0){
                    $tableKeys = array_keys($categoryNames[0]);

                    $checkSth = $this->qb->prepare("SELECT category_id, lang_id FROM ??category_name WHERE category_id = :category_id AND lang_id = :lang_id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??category_name (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");
                    $updateSth = $this->qb->prepare("UPDATE ??category_name SET name = :name WHERE category_id = :category_id AND lang_id = :lang_id ");

                    $categoryNames = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $categoryNames);

                    foreach ($categoryNames as $item) {
                        $checkSth->execute([':category_id' => $item[':category_id'], ':lang_id' => $item[':lang_id']]);
                        if($checkSth->rowCount() > 0){
                            $updateSth->execute($item);
                        }
                        else{
                            $insertSth->execute($item);
                        }
                    }
                }
                
                if(NULL != $categorySearch && count($categorySearch) > 0){
                    $tableKeys = array_keys($categorySearch[0]);

                    $checkSth = $this->qb->prepare("SELECT id FROM ??category_search WHERE id = :id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??category_search (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    array_shift($tableKeys);
                    $tableUpdateSql = '';
                    foreach ($tableKeys as $value) {
                        $tableUpdateSql .= $value . ' = :' . $value . ', ';
                    }
                    $tableUpdateSql = substr($tableUpdateSql, 0, -2);
                    $updateSth = $this->qb->prepare("UPDATE ??category_search SET " . $tableUpdateSql . " WHERE id = :id ");

                    $categorySearch = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $categorySearch);

                    foreach ($categorySearch as $item) {
                        $checkSth->execute([':id' => $item[':id']]);
                        if($checkSth->rowCount() > 0){
                            $updateSth->execute($item);
                        }
                        else{
                            $insertSth->execute($item);
                        }
                    }
                }

                $category['success'] = true;
            }
            else{
                $category['success'] = false;
            }
            $data['category'] = $category;


            /*product synch start*/
            $product = [];
            $response = $client->request('GET', 'product/?apikey=' . $this->config['synchApiKey']);
            $getProduct = json_decode($response->getBody(), true);
            if($getProduct['success']){
                $product['success'] = true;
                $product['imported'] = 0;
                
                $products = $getProduct['product'];
                $productNames = $getProduct['product_name'];
                $productSearch = $getProduct['product_search'];
                
                if(NULL != $products && count($products) > 0){
                    $this->qb->query("UPDATE ??product SET status = -1");
                    $tableKeys = array_keys($products[0]);

                    $checkSth = $this->qb->prepare("SELECT id FROM ??product WHERE id = :id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??product (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    array_shift($tableKeys);
                    $tableUpdateSql = '';
                    foreach ($tableKeys as $value) {
                        $tableUpdateSql .= $value . ' = :' . $value . ', ';
                    }
                    $tableUpdateSql = substr($tableUpdateSql, 0, -2);
                    $updateSth = $this->qb->prepare("UPDATE ??product SET " . $tableUpdateSql . " WHERE id = :id ");

                    $products = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $products);

                    foreach ($products as $item) {
                        $checkSth->execute([':id' => $item[':id']]);
                        if($checkSth->rowCount() > 0){
                            $result = $updateSth->execute($item);
                        }
                        else{
                            $result = $insertSth->execute($item);
                        }
                        if($result){
                            $product['imported']++;
                        }
                    }
                }

                if(NULL != $productNames && count($productNames) > 0){
                    $tableKeys = array_keys($productNames[0]);

                    $checkSth = $this->qb->prepare("SELECT product_id, lang_id FROM ??product_name WHERE product_id = :product_id AND lang_id = :lang_id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??product_name (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");
                    $updateSth = $this->qb->prepare("UPDATE ??product_name SET name = :name WHERE product_id = :product_id AND lang_id = :lang_id ");

                    $productNames = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $productNames);

                    foreach ($productNames as $item) {
                        $checkSth->execute([':product_id' => $item[':product_id'], ':lang_id' => $item[':lang_id']]);
                        if($checkSth->rowCount() > 0){
                            $updateSth->execute($item);
                        }
                        else{
                            $insertSth->execute($item);
                        }
                    }
                }
                
                if(NULL != $productSearch && count($productSearch) > 0){
                    $tableKeys = array_keys($productSearch[0]);

                    $checkSth = $this->qb->prepare("SELECT id FROM ??product_search WHERE id = :id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??product_search (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    array_shift($tableKeys);
                    $tableUpdateSql = '';
                    foreach ($tableKeys as $value) {
                        $tableUpdateSql .= $value . ' = :' . $value . ', ';
                    }
                    $tableUpdateSql = substr($tableUpdateSql, 0, -2);
                    $updateSth = $this->qb->prepare("UPDATE ??product_search SET " . $tableUpdateSql . " WHERE id = :id ");

                    $productSearch = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $productSearch);

                    foreach ($productSearch as $item) {
                        $checkSth->execute([':id' => $item[':id']]);
                        if($checkSth->rowCount() > 0){
                            $updateSth->execute($item);
                        }
                        else{
                            $insertSth->execute($item);
                        }
                    }
                }

                $product['success'] = true;
            }
            else{
                $product['success'] = false;
            }
            $data['product'] = $product;



            /*filter synch start*/
            $filter = [];
            $response = $client->request('GET', 'filter/?apikey=' . $this->config['synchApiKey']);
            $getFilter = json_decode($response->getBody(), true);
            if($getFilter['success']){
                $filter['success'] = true;
                $filter['imported'] = 0;
                
                $filters = $getFilter['filter'];
                $filterValues = $getFilter['filter_value'];
                $filterToCategory = (isset($getFilter['filter_to_category'])) ? $getFilter['filter_to_category'] : [];
                $filterToProduct = (isset($getFilter['filter_to_product'])) ? $getFilter['filter_to_product'] : [];
                
                if(NULL != $filters && count($filters) > 0){
                    $tableKeys = array_keys($filters[0]);

                    $checkSth = $this->qb->prepare("SELECT id FROM ??filter WHERE id = :id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??filter (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    array_shift($tableKeys);
                    $tableUpdateSql = '';
                    foreach ($tableKeys as $value) {
                        $tableUpdateSql .= $value . ' = :' . $value . ', ';
                    }
                    $tableUpdateSql = substr($tableUpdateSql, 0, -2);
                    $updateSth = $this->qb->prepare("UPDATE ??filter SET " . $tableUpdateSql . " WHERE id = :id ");

                    $filters = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $filters);

                    foreach ($filters as $item) {
                        $checkSth->execute([':id' => $item[':id']]);
                        if($checkSth->rowCount() > 0){
                            $result = $updateSth->execute($item);
                        }
                        else{
                            $result = $insertSth->execute($item);
                        }
                        if($result){
                            $filter['imported']++;
                        }
                    }
                }
                
                if(NULL != $filterValues && count($filterValues) > 0){
                    $tableKeys = array_keys($filterValues[0]);

                    $checkSth = $this->qb->prepare("SELECT id FROM ??filter_value WHERE id = :id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??filter_value (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    array_shift($tableKeys);
                    $tableUpdateSql = '';
                    foreach ($tableKeys as $value) {
                        $tableUpdateSql .= $value . ' = :' . $value . ', ';
                    }
                    $tableUpdateSql = substr($tableUpdateSql, 0, -2);
                    $updateSth = $this->qb->prepare("UPDATE ??filter_value SET " . $tableUpdateSql . " WHERE id = :id ");

                    $filterValues = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $filterValues);

                    foreach ($filterValues as $item) {
                        $checkSth->execute([':id' => $item[':id']]);
                        if($checkSth->rowCount() > 0){
                            $updateSth->execute($item);
                        }
                        else{
                            $insertSth->execute($item);
                        }
                    }
                }
                
                if(NULL != $filterToCategory && count($filterToCategory) > 0){
                    $tableKeys = array_keys($filterToCategory[0]);
                    $this->qb->query("TRUNCATE table ??filter_to_category");

                    $insertSth = $this->qb->prepare("INSERT INTO ??filter_to_category (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    $filterToCategory = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $filterToCategory);

                    foreach ($filterToCategory as $item) {
                        $insertSth->execute($item);
                    }
                }
                
                if(NULL != $filterToProduct && count($filterToProduct) > 0){
                    $tableKeys = array_keys($filterToProduct[0]);
                    $this->qb->query("TRUNCATE table ??filter_to_product");

                    $insertSth = $this->qb->prepare("INSERT INTO ??filter_to_product (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    $filterToProduct = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $filterToProduct);

                    foreach ($filterToProduct as $item) {
                        $insertSth->execute($item);
                    }
                }
            }
            else{
                $filter['success'] = false;
            }
            $data['filter'] = $filter;


            /*file synch start new table synchro*/
            $file = [];
            $response = $client->request('GET', 'file/?apikey=' . $this->config['synchApiKey']);
            $getFile = json_decode($response->getBody(), true);
            if($getFile['success']){
                $file['success'] = true;
                $file['imported'] = 0;
                
                $files = $getFile['file'];
                $fileNames = $getFile['file_name'];
                
                if(NULL != $files && count($files) > 0){
                    $tableKeys = array_keys($files[0]);

                    $checkSth = $this->qb->prepare("SELECT id FROM ??file_synchro WHERE id = :id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??file_synchro (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");

                    array_shift($tableKeys);
                    $tableUpdateSql = '';
                    foreach ($tableKeys as $value) {
                        $tableUpdateSql .= $value . ' = :' . $value . ', ';
                    }
                    $tableUpdateSql = substr($tableUpdateSql, 0, -2);
                    $updateSth = $this->qb->prepare("UPDATE ??file_synchro SET " . $tableUpdateSql . " WHERE id = :id ");

                    $files = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $files);

                    foreach ($files as $item) {
                        $checkSth->execute([':id' => $item[':id']]);
                        $currentFile = $this->config['synchUploads'] . $item[':path'];
                        $saveFile = BASEPATH . '/uploads-synchro/' . $item[':path'];
                        $saveFileDir = dirname($saveFile);
                        if(!is_dir($saveFileDir)){
                            mkdir($saveFileDir, 0755, true);
                        }
                        try {
                            if(!file_exists($saveFile) || (isset($_GET['downloadimages']))){
                                if(file_exists($saveFile)){
                                    unlink($saveFile);
                                }
                                $resp = $client->request('GET', $currentFile);
                                $fileContent = $resp->getBody();
                                if(!$fileContent){
                                    exit;
                                }
                                $resource = fopen($saveFile, 'w');
                                //$client->request('GET', $currentFile, ['sink' => $resource]);
                                fwrite($resource, $fileContent);
                                fclose($resource);
                            }
                                
                        } catch (RequestException $e) {
                            //echo $resp->getStatusCode() . ' - ' . $currentFile;
                        }
                            

                        if($checkSth->rowCount() > 0){
                            $result = $updateSth->execute($item);
                        }
                        else{
                            $result = $insertSth->execute($item);
                        }
                        if($result){
                            $file['imported']++;
                        }
                    }
                }

                if(NULL != $fileNames && count($fileNames) > 0){
                    $tableKeys = array_keys($fileNames[0]);

                    $checkSth = $this->qb->prepare("SELECT file_id, lang_id FROM ??file_name_synchro WHERE file_id = :file_id AND lang_id = :lang_id");

                    $insertSth = $this->qb->prepare("INSERT INTO ??file_name_synchro (" . implode(', ', $tableKeys) . ") VALUES (:" . implode(', :', $tableKeys) . ")");
                    $updateSth = $this->qb->prepare("UPDATE ??file_name_synchro SET name = :name WHERE file_id = :file_id AND lang_id = :lang_id ");

                    $fileNames = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $fileNames);

                    foreach ($fileNames as $item) {
                        $checkSth->execute([':file_id' => $item[':file_id'], ':lang_id' => $item[':lang_id']]);
                        if($checkSth->rowCount() > 0){
                            $updateSth->execute($item);
                        }
                        else{
                            $insertSth->execute($item);
                        }
                    }
                }

                $file['success'] = true;
            }
            else{
                $file['success'] = false;
            }
            $data['file'] = $file;


            /*url synch start new table synchro*/
            $url = [];
            $response = $client->request('GET', 'url/?apikey=' . $this->config['synchApiKey']);
            $getURL = json_decode($response->getBody(), true);
            if($getURL['success']){
                $url['success'] = true;
                $url['imported'] = 0;
                
                $urls = $getURL['url'];
                
                if(NULL != $urls && count($urls) > 0){
                    $tableKeys = array_keys($urls[0]);

                    $checkSth = $this->qb->prepare("SELECT alias FROM ??url WHERE alias = :alias");

                    $insertSth = $this->qb->prepare("INSERT INTO ??url (alias, route) VALUES (:alias, :route)");

                    $updateSth = $this->qb->prepare("UPDATE ??url SET route = :route WHERE alias = :alias ");

                    $urls = array_map(function($item) {
                        $return = [];
                        foreach($item as $key => $value){
                            $return[':' . $key] = $value;
                        }
                        return $return; 
                    }, $urls);

                    foreach ($urls as $item) {
                        $checkSth->execute([':alias' => $item[':alias']]);

                        if($checkSth->rowCount() > 0){
                            $result = $updateSth->execute([':alias' => $item[':alias'], ':route' => $item[':route']]);
                        }
                        else{
                            $result = $insertSth->execute([':alias' => $item[':alias'], ':route' => $item[':route']]);
                        }
                        if($result){
                            $url['imported']++;
                        }
                    }
                }

                $url['success'] = true;
            }
            else{
                $url['success'] = false;
            }
            $data['url'] = $url;
        }
            
        
        $this->data = $data;

        return $this;
    }
    
}



