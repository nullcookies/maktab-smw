<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class ApiModel extends Model {

    public function index(){

        $data = [];

        
        $data['success'] = true;
        
        $this->data = $data;

        return $this;
    }
    
    public function brand(){
        
        $data = [];
        $errors = [];

        if(!$this->checkApiKey()){
            $errors['apikey'] = true;
        }

        if(count($errors) == 0){
            $data['success'] = true;

            $id = false;
            if(isset($_GET['id'])){
                $id = (int)$_GET['id'];
            }

            if(!$id){
                $getBrands = $this->qb->get('??brand');
                if($getBrands->rowCount() > 0){
                    $data['brand'] = $getBrands->fetchAll();
                }

            }
        }
        else{
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        $this->data = $data;

        return $this;
    }
    
    public function category(){
        
        $data = [];
        $errors = [];

        if(!$this->checkApiKey()){
            $errors['apikey'] = true;
        }

        if(count($errors) == 0){
            $data['success'] = true;

            $id = false;
            if(isset($_GET['id'])){
                $id = (int)$_GET['id'];
            }

            if(!$id){
                $getCategories = $this->qb->get('??category');
                if($getCategories->rowCount() > 0){
                    $data['category'] = $getCategories->fetchAll();
                }
                
                $getCategoryNames = $this->qb->get('??category_name');
                if($getCategoryNames->rowCount() > 0){
                    $data['category_name'] = $getCategoryNames->fetchAll();
                }
                
                $getCategorySearch = $this->qb->get('??category_search');
                if($getCategorySearch->rowCount() > 0){
                    $data['category_search'] = $getCategorySearch->fetchAll();
                }

            }
        }
        else{
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        $this->data = $data;

        return $this;
    }
    
    public function product(){
        
        $data = [];
        $errors = [];

        if(!$this->checkApiKey()){
            $errors['apikey'] = true;
        }

        if(count($errors) == 0){
            $data['success'] = true;

            $id = false;
            if(isset($_GET['id'])){
                $id = (int)$_GET['id'];
            }

            if(!$id){
                $getProducts = $this->qb->get('??product');
                if($getProducts->rowCount() > 0){
                    $data['product'] = $getProducts->fetchAll();
                }
                
                $getProductNames = $this->qb->get('??product_name');
                if($getProductNames->rowCount() > 0){
                    $data['product_name'] = $getProductNames->fetchAll();
                }
                
                $getProductySearch = $this->qb->get('??product_search');
                if($getProductySearch->rowCount() > 0){
                    $data['product_search'] = $getProductySearch->fetchAll();
                }

            }
        }
        else{
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        $this->data = $data;

        return $this;
    }
    
    public function filter(){
        
        $data = [];
        $errors = [];

        if(!$this->checkApiKey()){
            $errors['apikey'] = true;
        }

        if(count($errors) == 0){
            $data['success'] = true;

            $id = false;
            if(isset($_GET['id'])){
                $id = (int)$_GET['id'];
            }

            if(!$id){
                $getFilters = $this->qb->get('??filter');
                if($getFilters->rowCount() > 0){
                    $data['filter'] = $getFilters->fetchAll();
                }

                $getFilterValues = $this->qb->get('??filter_value');
                if($getFilterValues->rowCount() > 0){
                    $data['filter_value'] = $getFilterValues->fetchAll();
                }

                $getFilterToCategory = $this->qb->get('??filter_to_category');
                if($getFilterToCategory->rowCount() > 0){
                    $data['filter_to_category'] = $getFilterToCategory->fetchAll();
                }

                $getFilterToProduct = $this->qb->get('??filter_to_product');
                if($getFilterToProduct->rowCount() > 0){
                    $data['filter_to_product'] = $getFilterToProduct->fetchAll();
                }

            }
        }
        else{
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        $this->data = $data;

        return $this;
    }
    
    public function file(){
        
        $data = [];
        $errors = [];

        if(!$this->checkApiKey()){
            $errors['apikey'] = true;
        }

        if(count($errors) == 0){
            $data['success'] = true;

            $id = false;
            if(isset($_GET['id'])){
                $id = (int)$_GET['id'];
            }

            if(!$id){
                $getFiles = $this->qb->get('??file');
                if($getFiles->rowCount() > 0){
                    $data['file'] = $getFiles->fetchAll();
                }
                
                $getFileNames = $this->qb->get('??file_name');
                if($getFileNames->rowCount() > 0){
                    $data['file_name'] = $getFileNames->fetchAll();
                }

            }
        }
        else{
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        $this->data = $data;

        return $this;
    }
    
    public function url(){
        
        $data = [];
        $errors = [];

        if(!$this->checkApiKey()){
            $errors['apikey'] = true;
        }

        if(count($errors) == 0){
            $data['success'] = true;

            $id = false;
            if(isset($_GET['id'])){
                $id = (int)$_GET['id'];
            }

            if(!$id){
                $getURLs = $this->qb->get('??url');
                if($getURLs->rowCount() > 0){
                    $data['url'] = $getURLs->fetchAll();
                }
            }
        }
        else{
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        $this->data = $data;

        return $this;
    }

    private function checkApiKey(){
        if(isset($_GET['apikey']) && $_GET['apikey'] == $this->config['synchApiKey']){
            return true;
        }
        return false;
    }
    
}



