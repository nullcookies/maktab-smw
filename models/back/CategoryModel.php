<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\back\ProductModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class CategoryModel extends Model {

    public $category_show_in = [1, 2, 3];
    
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
        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);
        $controls['deleteConfirm'] = $this->linker->getUrl($this->control . '/deleteConfirm', true);
        $data['controls'] = $controls;

        $categories = [];
        $productModel = new ProductModel;
        $categoryNames = $productModel->getCategoryNames();
        $getCategories = $this->qb->select('id, status')->get('??category');
        if($getCategories->rowCount() > 0){
            $categories = $getCategories->fetchAll();
        }
        $data['categories'] = $categories;
        $data['categoryNames'] = $categoryNames;

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

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datepicker/datepicker3.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/iCheck/all.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/select2/select2.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/css/fileinput.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/select2/select2.full.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/min/moment.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/locale/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/bootstrap-datepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/locales/bootstrap-datepicker.' . LANG_PREFIX . '.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/iCheck/icheck.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/plugins/sortable.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/fileinput.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/locales/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/ckeditor.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/adapters/jquery.js');
        
        $controls = [];
        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/add', true);
        $data['controls'] = $controls;

        $loadedImages = [];
        $initialPreview = [];
        $initialPreviewConfig = [];

        $current = [];
        if($_POST){
            if($_POST['images']){
                $getLoadedImages = $this->loadedImages($_POST['images']);
                $loadedImages = $getLoadedImages['loadedImages'];
                $initialPreview = $getLoadedImages['initialPreview'];
                $initialPreviewConfig = $getLoadedImages['initialPreviewConfig'];
            }
            $current = $_POST;
        }
        $data[$this->control] = $current;

        $data['loadedImages'] = $loadedImages;
        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;

        //все категории
        $ids = [];
        $data['child_ids'] = $ids;
        $categories = [];
        $productModel = new ProductModel;
        $categories = $productModel->getCategoryNames();
        $data['categories'] = $categories;


        $data['category_show_in'] = $this->category_show_in;
        
        $data['hide_blocks'] = ['category_show_in'];

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
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control);

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datepicker/datepicker3.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/iCheck/all.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/select2/select2.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/css/fileinput.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/select2/select2.full.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/min/moment.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/locale/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/bootstrap-datepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/locales/bootstrap-datepicker.' . LANG_PREFIX . '.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/iCheck/icheck.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/plugins/sortable.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/fileinput.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/locales/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/ckeditor.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/adapters/jquery.js');
        
        $controls = [];
        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/edit/' . $id, true);
        $data['controls'] = $controls;

        $loadedImages = [];
        $initialPreview = [];
        $initialPreviewConfig = [];

        $current = [];
        if($id){
            $getCategory = $this->qb->where('id', '?')->get('??category', [$id]);
            if($getCategory->rowCount() > 0){
                $category = $getCategory->fetchAll();
                $category = $this->langDecode($category, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                $current = $category[0];

                //картинки
                $existImages = json_decode($current['images'], true);
                $getLoadedImages = $this->loadedImages($existImages);
                $loadedImages = $getLoadedImages['loadedImages'];
                $initialPreview = $getLoadedImages['initialPreview'];
                $initialPreviewConfig = $getLoadedImages['initialPreviewConfig'];
                
                //url
                $getAlias = $this->qb->select('id')->where('route', '?')->get('??url', [$this->control . '/view/' . $id]);
                if($getAlias->rowCount() > 0){
                    $aliasId = $getAlias->fetch()['id'];
                }
                else{
                    $aliasId = 0;
                }
                $current['alias_id'] = $aliasId;
            }
        }
        if($_POST){
            if($_POST['images']){
                $getLoadedImages = $this->loadedImages($_POST['images']);
                $loadedImages = $getLoadedImages['loadedImages'];
                $initialPreview = $getLoadedImages['initialPreview'];
                $initialPreviewConfig = $getLoadedImages['initialPreviewConfig'];
            }
            $current = $_POST;
        }

        $data[$this->control] = $current;

        $data['loadedImages'] = $loadedImages;
        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;

        //все категории
        $ids = $this->getChildCategoryIds($id, []);
        $ids[] = $id;
        $data['child_ids'] = $ids;
        $categories = [];
        $productModel = new ProductModel;
        $categories = $productModel->getCategoryNames();
        $data['categories'] = $categories;


        $data['category_show_in'] = $this->category_show_in;
        
        $data['hide_blocks'] = ['category_show_in'];

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }
    
    public function save($new = false){
        
        $isUniqueParams = [
            'table' => '??url',
            'column' => 'alias'
        ];
        if(!$new) {
            $id = (int)$_POST['id'];
            $alias_id = (int)$_POST['alias_id'];
            $isUniqueParams['id'] = $alias_id;
        }

        $rules = [ 
            'post' => [
                'name' => ['isRequired'],
                'alias' => ['isRequired', 'isAlias', ['isUnique', $isUniqueParams]],
            ],
            'files' => [
                
            ]

        ];

        /*if($_FILES['image']['error'] == 0){
            $rules['files']['image'] = ['isImage', ['maxSize', 3000000]];
            $data['files'] = $_FILES;
        }*/

        $_POST = $this->cleanForm($_POST);

        $_POST['alias'] = strtolower($_POST['alias']);

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

                $update['images'] = json_encode($_POST['images'], JSON_UNESCAPED_UNICODE);
                $update['alias'] = $_POST['alias'];

                $update['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $update['descr'] = json_encode($_POST['descr'], JSON_UNESCAPED_UNICODE);
                $update['descr_full'] = json_encode($_POST['descr_full'], JSON_UNESCAPED_UNICODE);
                $update['meta_t'] = json_encode($_POST['meta_t'], JSON_UNESCAPED_UNICODE);
                $update['meta_d'] = json_encode($_POST['meta_d'], JSON_UNESCAPED_UNICODE);
                $update['meta_k'] = json_encode($_POST['meta_k'], JSON_UNESCAPED_UNICODE);

                $update['parent_category_id'] = (int)$_POST['parent_category_id'];
                $update['category_show_in'] = (int)$_POST['category_show_in'];

                $update["status"] = ($_POST["status"]) ? 1 : 0;
                $update["sort_number"] = (int)$_POST["sort_number"];

                $updateResult = $this->qb->where('id', '?')->update('??category', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control);
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{
                    //обновление url категории
                    $urlInsertUpdate = [
                        'alias' => htmlspecialchars($_POST['alias']),
                        'route' => $this->control . '/view/' . $id
                    ];
                    $this->qb->insertUpdate('??url', $urlInsertUpdate);

                    //обновление поисковой и сортировочной информации категории
                    $searchInsertUpdate = [
                        'category_id' => $id,
                        //'search_text' => implode(' ', $_POST['name']) . ' ' . implode(' ', $_POST['descr'])
                        'search_text' => implode(' ', $_POST['name'])
                    ];
                    $this->qb->insertUpdate('??category_search', $searchInsertUpdate);
                    foreach($_POST['name'] as $key => $value){
                        $nameInsertUpdate = [
                            'category_id' => $id,
                            'lang_id' => $key,
                            'name' => $value
                        ];
                        $this->qb->insertUpdate('??category_name', $nameInsertUpdate);
                    }
                    
                    $this->successText = $this->getTranslation('success edit ' . $this->control);
                    return true;
                }
                
            }
            else{
                $insert = [];
                
                $insert['images'] = json_encode($_POST['images'], JSON_UNESCAPED_UNICODE);
                $insert['alias'] = $_POST['alias'];

                $insert['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $insert['descr'] = json_encode($_POST['descr'], JSON_UNESCAPED_UNICODE);
                $insert['descr_full'] = json_encode($_POST['descr_full'], JSON_UNESCAPED_UNICODE);
                $insert['meta_t'] = json_encode($_POST['meta_t'], JSON_UNESCAPED_UNICODE);
                $insert['meta_d'] = json_encode($_POST['meta_d'], JSON_UNESCAPED_UNICODE);
                $insert['meta_k'] = json_encode($_POST['meta_k'], JSON_UNESCAPED_UNICODE);

                $insert['parent_category_id'] = (int)$_POST['parent_category_id'];
                $insert['category_show_in'] = (int)$_POST['category_show_in'];

                $insert["status"] = ($_POST["status"]) ? 1 : 0;
                $insert["sort_number"] = (int)$_POST["sort_number"];

                $insertResult = $this->qb->insert('??category', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $id = $this->qb->lastInsertId();

                    //обновление url
                    $urlInsert = [
                        'alias' => $_POST['alias'],
                        'route' => $this->control . '/view/' . $id
                    ];
                    $this->qb->insert('??url', $urlInsert);

                    //обновление поисковой и сортировочной информации категории
                    $searchInsert = [
                        'category_id' => $id,
                        //'search_text' => implode(' ', $_POST['name']) . ' ' . implode(' ', $_POST['descr'])
                        'search_text' => implode(' ', $_POST['name'])
                    ];
                    $this->qb->insert('??category_search', $searchInsert);

                    foreach($_POST['name'] as $key => $value){
                        $nameInsertUpdate = [
                            'category_id' => $id,
                            'lang_id' => $key,
                            'name' => $value
                        ];
                        $this->qb->insertUpdate('??category_name', $nameInsertUpdate);
                    }

                    $this->successText = $this->getTranslation('success add ' . $this->control);
                    return true;
                }
            }
        }
    }

    public function toggle() {
        $id = $_GET['param1'];
        $status = (int)$_GET['param2'];
        $return = '';
        if($id){
            $result = $this->qb->where('id', '?')->update('??category', ['status' => $status], [$id]);
            if($result){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }
    
    public function deleteConfirm(){

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
            'name' => $this->getTranslation('delete confirm ' . $this->control),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control);

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datepicker/datepicker3.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/iCheck/all.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/select2/select2.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/css/fileinput.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/select2/select2.full.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/min/moment.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/locale/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/bootstrap-datepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/locales/bootstrap-datepicker.' . LANG_PREFIX . '.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/iCheck/icheck.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/plugins/sortable.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/fileinput.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/locales/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/themes/explorer/theme.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/ckeditor.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/adapters/jquery.js');
        
        $controls = [];
        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/delete/' . $id, true);
        $data['controls'] = $controls;

        

        $current = [];
        if($id){
            $getCategory = $this->qb->where('id', '?')->get('??category', [$id]);
            if($getCategory->rowCount() > 0){
                $category = $getCategory->fetchAll();
                $category = $this->langDecode($category, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                $current = $category[0];
            }
        }
        $data[$this->control] = $current;

        //все категории
        $categories = [];
        $getCategories = $this->qb->select('id, name')->where('id !=', '?')->get('??category', [$id]);
        if($getCategories->rowCount() > 0){
            $categories = $getCategories->fetchAll();
            $categories = $this->langDecode($categories, ['name']);
        }
        $data['categories'] = $categories;

        $this->data = $data;

        return $this;
    }

    public function delete(){
        $id = (int)$_GET['param1'];
        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }
        $getCategory = $this->qb->where('id', '?')->get('??category', [$id]);
        if($getCategory->rowCount() > 0){
            $category = $getCategory->fetch();
            //изменение родителя внутренних категорий
            $this->qb->where('parent_category_id', $category['id']);
            $this->qb->update('??category', ['parent_category_id' => $category['parent_category_id']]);
        }

        //управление товарами
        $productsAction = $_POST['product_action'];
        if($productsAction == 'move'){
            $newCatId = (int)$_POST['move_to_category'];
            $this->qb->where('category_id', '?')->update('??product', ['category_id' => $newCatId], [$id]);
            
        }
        else{
            $productModel = new ProductModel;
            $products = $this->qb->where('category_id', '?')->get('??product', [$id])->fetchAll();
            foreach ($products as $value) {
                $productModel->delete($value['id']);
            }
        }
        
        //удаляем картинки
        if($category['image']){
            $this->media->delete($category['image']);
        }
        if($category['images']){
            $images = json_decode($category['images']);
            if($images){
				foreach($images as $key => $value){
					$images[$key] = (int)$value;
				}
                $files = $this->qb->where('id IN', $images)->get('??file')->fetchAll();
                if($files){
                    $imageDeleteSth = $this->qb->prepare('DELETE FROM ??file WHERE id = ?');
                    foreach($files as $value){
                        $file = BASEPATH . '/uploads/' . $value['path'];
                        if(file_exists($file)){
                            unlink($file);
                        }
                        $imageDeleteSth->execute([$value['id']]);
                    }
                }
            }
        }

		//удаляем url
		$this->qb->where('route', '?')->delete('??url', ['category/view/' . $id]);
        $resultDelete = $this->qb->where('id', '?')->delete('??category', [$id]);

        //удаляем search
        $this->qb->where('category_id', '?')->delete('??category_search', [$id]);

        //удаляем name
        $this->qb->where('category_id', '?')->delete('??category_name', [$id]);
        
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


    private function getChildCategoryIds($categoryId, $ids = array()){
        $categoryId = (int)$categoryId;
        $getCategories = $this->qb->select('id')->where('parent_category_id', '?')->get('??category', [$categoryId]);
        if($getCategories->rowCount() > 0){
            $categories = $getCategories->fetchAll();
            foreach($categories as $value){
                $ids[] = $value['id'];
                $ids = $this->getChildCategoryIds($value['id'], $ids);
            }
            return $ids;
        }
        else{
            return $ids;
        }
    }


    
}

