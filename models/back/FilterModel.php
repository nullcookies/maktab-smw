<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class FilterModel extends Model {

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
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');

        $controls = [];

        $controls['view'] = $this->linker->getUrl($this->control . '/view', true);
        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $data['controls'] = $controls;

        $filters = [];
        $filterNames = [];
        $getFilters = $this->qb->get('??filter');
        if($getFilters->rowCount() > 0){
            $filters = $getFilters->fetchAll();
            foreach($filters as $key => $value){
                $filterNames[$value['id']] = json_decode($value['name'], true);
            }
            $filters = $this->langDecode($filters, ['name']);
        }

        $data['filters'] = $filters;
        $data['filterNames'] = $filterNames;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function add(){
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('add ' . $this->control),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation('add ' . $this->control);
        
        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/add', true);

        $data['controls'] = $controls;

        //все категории
        $productModel = new ProductModel;
        $categories = $productModel->getCategoryNames();
        $data['categories'] = $categories;

        $data[$this->control] = [];
        if($_POST){
            $data[$this->control] = $_POST;
        }

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }
    
    public function edit() {
        
        $id = (int)$_GET['param1'];
        if(!$id){
            $id = (int)$_POST['id'];
        }
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('edit ' . $this->control),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/edit/' . $id, true);

        $data['controls'] = $controls;

        //все категории
        $productModel = new ProductModel;
        $categories = $productModel->getCategoryNames();
        $data['categories'] = $categories;

        $current = [];
        if($id){
            $getfilter = $this->qb->where('id', '?')->order('name')->get('??filter', [$id]);
            if($getfilter->rowCount() > 0){
                $filter = $getfilter->fetchAll();
                $filter = $this->langDecode($filter, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                $current = $filter[0];
                $getAlias = $this->qb->select('id')->where('route', '?')->get('??url', [$this->control . '/view/' . $id]);
                if($getAlias->rowCount() > 0){
                    $aliasId = $getAlias->fetch()['id'];
                }
                else{
                    $aliasId = 0;
                }
                $current['alias_id'] = $aliasId;

                $filterCategories = [];
                $getFilterCategories = $this->qb->where('filter_id', '?')->get('??filter_to_category', [$id]);
                if($getFilterCategories->rowCount() > 0){
                    $getFilterCategories = $getFilterCategories->fetchAll();
                    foreach($getFilterCategories as $value){
                        $filterCategories[] = $value['category_id'];
                    }
                }
                $current['category_id'] = $filterCategories;
            }
        }
        if($_POST){
            $current = $_POST;
        }

        $data[$this->control] = $current;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }
    
    public function save($new = false){

        if(!$new) {
            $id = (int)$_POST['id'];
        }

        $rules = [ 
            'post' => [
                'name' => ['isRequired'],
            ]
        ];

        $_POST = $this->cleanForm($_POST);

        $data['post'] = $_POST;

        $valid = $this->validator->validate($rules, $data);

        if(!$valid){
            if(!$new){
                $this->errorText = $this->getTranslation('error edit ' . $this->control);
            }
            else{
                $this->errorText = $this->getTranslation('error add ' . $this->control);
            }
            $this->errors = $this->validator->lastErrors;
            return false;
        }
        else{
            if(!$new) {
                $update = [];
                $update['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);

                $updateResult = $this->qb->where('id', '?')->update('??filter', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control);
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{
                    //обновление категорий
                    $filterCategoryIds = [];

                    if(is_array($_POST['category_id'])){
                        foreach($_POST['category_id'] as $value){
                            $filterCategoryIds[] = $value;
                        }
                    }
                    $this->qb->query('DELETE FROM ??filter_to_category WHERE filter_id = ' . $id);
                    $filter2categorySth = $this->qb->prepare('INSERT INTO ??filter_to_category (filter_id, category_id) VALUES (?, ?)');
                    foreach($filterCategoryIds as $value){
                        $filter2categorySth->execute([$id, $value]);
                    }

                    $this->successText = $this->getTranslation('success edit ' . $this->control);
                    return true;
                }
            }
            else{
                $insert = [];
                $insert['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);

                $insertResult = $this->qb->insert('??filter', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $id = $this->qb->lastInsertId();

                    //обновление категорий
                    $filterCategoryIds = [];
                    if(is_array($_POST['category_id'])){
                        foreach($_POST['category_id'] as $value){
                            $filterCategoryIds[] = $value;
                        }
                    }
                    $this->qb->query('DELETE FROM ??filter_to_category WHERE filter_id = ' . $id);
                    $filter2categorySth = $this->qb->prepare('INSERT INTO ??filter_to_category (filter_id, category_id) VALUES (?, ?)');
                    foreach($filterCategoryIds as $value){
                        $filter2categorySth->execute([$id, $value]);
                    }

                    $this->successText = $this->getTranslation('success add ' . $this->control);
                    return true;
                }
            }
        }
    }
    
    public function delete(){

        $id = (int)$_GET['param1'];
        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }
        $getfilter = $this->qb->where('id', '?')->get('??filter', [$id]);
        if($getfilter->rowCount() > 0){
            $filter = $getfilter->fetch();
            $this->qb->where('filter_id', '?')->delete('??filter_value', [$id]);
        }

        //удаляем привязку к категориям
        $f2cSth = $this->qb->prepare('DELETE FROM ??filter_to_category WHERE filter_id = ?');
        $f2cSth->execute([$id]);

        //удаляем значения фильтра и привязку к товарам
        $filterValues = $this->qb->where('filter_id', '?')->get('??filter_value', [$id])->fetchAll();
        if($filterValues){
            $f2pSth = $this->qb->prepare('DELETE FROM ??filter_to_product WHERE filter_value_id = ?');
            foreach($filterValues as $value){
                $f2pSth->execute([$value['id']]);
            }
        }
        $this->qb->where('filter_id', '?')->delete('??filter_value', [$id]);


        //удаляем фильтр
        $resultDelete = $this->qb->where('id', '?')->delete('??filter', [$id]);
        
        if(!$resultDelete){
            $this->errorText = $this->getTranslation('error delete ' . $this->control);
            $this->errors['error db'];
            return false;
        }
        else{
            $this->successText = $this->getTranslation('success delete ' . $this->control);
            return true;
        }
    }

    public function view() {
        
        $data = [];

        $filter_id = (int)$_GET['param1'];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' value page'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control . ' value page');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');

        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['add'] = $this->linker->getUrl($this->control . '/addValue/' . $filter_id, true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/editValue/' . $filter_id, true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/deleteValue/' . $filter_id, true);

        $data['controls'] = $controls;

        $filterValues = [];
        if($filter_id){
            $getFilterValues = $this->qb->where('filter_id', '?')->order('sort_number')->get('??filter_value', [$filter_id]);
        }
        else{
            $getFilterValues = $this->qb->get('??filter_value');
        }
        
        if($getFilterValues->rowCount() > 0){
            $filterValues = $getFilterValues->fetchAll();
            $filterValues = $this->langDecode($filterValues, ['name']);
        }
        $data['filterValues'] = $filterValues;

        $filters = [];
        $filterNames = [];
        $getfilters = $this->qb->select('id, name')->get('??filter');
        if($getfilters->rowCount() > 0){
            $filters = $getfilters->fetchAll();
            $filters = $this->langDecode($filters, ['name']);
            foreach($filters as $value){
                $filterNames[$value['id']] = $value['name'];
            }
        }
        $data['filters'] = $filters;
        $data['filterNames'] = $filterNames;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function addValue(){
        
        $data = [];

        $filter_id = (int)$_GET['param1'];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' value page'),
            'url' => $this->linker->getUrl($this->control . '/view/' . $filter_id, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('add ' . $this->control . ' value'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation('add ' . $this->control);
        
        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/addValue/' . $filter_id, true);

        $data['controls'] = $controls;

        $filters = [];
        $getfilters = $this->qb->select('id, name')->get('??filter');
        if($getfilters->rowCount() > 0){
            $filters = $getfilters->fetchAll();
            $filters = $this->langDecode($filters, ['name']);
        }
        $data['filters'] = $filters;

        $data['filter_id'] = $filter_id;

        $data['filterValue'] = [];
        if($_POST){
            $data['filterValue'] = $_POST;
        }

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }
    
    public function editValue() {

        $filter_id = (int)$_GET['param1'];
        
        $id = (int)$_GET['param2'];
        if(!$id){
            $id = (int)$_POST['id'];
        }
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' value page'),
            'url' => $this->linker->getUrl($this->control . '/view/' . $filter_id, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('edit ' . $this->control . ' value'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/editValue/' . $filter_id . '/' . $id, true);

        $data['controls'] = $controls;

        $filters = [];
        $getfilters = $this->qb->select('id, name')->get('??filter');
        if($getfilters->rowCount() > 0){
            $filters = $getfilters->fetchAll();
            $filters = $this->langDecode($filters, ['name']);
        }
        $data['filters'] = $filters;
        
        $data['filter_id'] = $filter_id;

        $current = [];
        if($id){
            $getfilterValue = $this->qb->where('id', '?')->get('??filter_value', [$id]);
            if($getfilterValue->rowCount() > 0){
                $filterValue = $getfilterValue->fetch();
                $current = $this->langDecode($filterValue, ['name'], false);
            }
        }
        if($_POST){
            $current = $_POST;
        }

        $data['filterValue'] = $current;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }
    
    public function saveValue($new = false){

        if(!$new) {
            $id = (int)$_POST['id'];
        }

        $rules = [ 
            'post' => [
                'name' => ['isRequired'],
                'filter_id' => ['isRequired'],
            ]
        ];

        $_POST = $this->cleanForm($_POST);
        
        $data['post'] = $_POST;

        $valid = $this->validator->validate($rules, $data);

        if(!$valid){
            if(!$new){
                $this->errorText = $this->getTranslation('error edit ' . $this->control . ' value');
            }
            else{
                $this->errorText = $this->getTranslation('error add ' . $this->control . ' value');
            }
            $this->errors = $this->validator->lastErrors;
            return false;
        }
        else{
            if(!$new) {
                $update = [];
                $update['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $update['color'] = $_POST['color'];
                $update['filter_id'] = (int)$_POST['filter_id'];
                $update['sort_number'] = (int)$_POST['sort_number'];
                //var_dump($update);
                //exit;
                

                $updateResult = $this->qb->where('id', '?')->update('??filter_value', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control . ' value');
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{                    
                    $this->successText = $this->getTranslation('success edit ' . $this->control . ' value');
                    return true;
                }
            }
            else{
                $insert = [];
                $insert['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $insert['color'] = $_POST['color'];
                $insert['filter_id'] = (int)$_POST['filter_id'];
                $insert['sort_number'] = (int)$_POST['sort_number'];

                $insertResult = $this->qb->insert('??filter_value', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control . ' value');
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $id = $this->qb->lastInsertId();
                    $this->successText = $this->getTranslation('success add ' . $this->control . ' value');
                    return true;
                }
            }
        }
    }
    
    public function deleteValue(){

        $filter_id = (int)$_GET['param1'];
        $id = (int)$_GET['param2'];
        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }

        //удаляем привязку к товарам
        $this->qb->where('filter_value_id', '?')->delete('??filter_to_product', [$id]);
        
        //удаляем значение фильтра
        $resultDelete = $this->qb->where('id', '?')->delete('??filter_value', [$id]);
        
        if(!$resultDelete){
            $this->errorText = $this->getTranslation('error delete ' . $this->control . ' value');
            $this->errors['error db'];
            return false;
        }
        else{
            $this->successText = $this->getTranslation('success delete ' . $this->control . ' value');
            return true;
        }
    }


    public function getFilter() {
        $data = [];

        $data['success'] = false;

        $filters = [];
        $filterIds = [];

        $getFilterIds = $_POST['filterIds'];
        if(is_array($getFilterIds)){
            foreach($getFilterIds as $value){
                $filterIds[] = (int)$value;
            }
        }
        if($filterIds){
            $filters = $this->qb->where('id IN', $filterIds)->get('??filter')->fetchAll();
        }
        if($filters){
            $filters = $this->langDecode($filters, ['name']);
            $filterValuesSth = $this->qb->prepare('SELECT * FROM ??filter_value WHERE filter_id = ?');
            
            foreach($filters as $key => $value){
                $filters[$key]['values'] = [];
                $filterValuesSth->execute([$value['id']]);
                if($filterValuesSth->rowCount() > 0){
                    $getFilterValues = $filterValuesSth->fetchAll(\PDO::FETCH_ASSOC);
                    $getFilterValues = $this->langDecode($getFilterValues, ['name']);
                    foreach($getFilterValues as $key1 => $value1){
                        $getFilterValues[$key1]['name'] = $value1['name'][LANG_ID];
                    }
                    $filters[$key]['values'] = $getFilterValues;
                }
                $filters[$key]['name'] = $value['name'][LANG_ID];
            }
            $data['success'] = true;
        }

        $data['filters'] = $filters;

        $this->data = $data;
        return $this;
    }
    
}

