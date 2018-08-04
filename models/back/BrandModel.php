<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class BrandModel extends Model {

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
        $data['controls'] = $controls;

        $brands = [];
        $getBrands = $this->qb->order('sort_number')->get('??brand');
        if($getBrands->rowCount() > 0){
            $brands = $getBrands->fetchAll();
            $brands = $this->langDecode($brands, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }

        $data['brands'] = $brands;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function add(){
        
        $data = [];

        $brandIconW = (int)$this->getOption('icon_brand_w');
        $brandIconH = (int)$this->getOption('icon_brand_h');
        $data['recommendedSize'] = $brandIconW . 'x' . $brandIconH;

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

        $brandIconW = (int)$this->getOption('icon_brand_w');
        $brandIconH = (int)$this->getOption('icon_brand_h');
        $data['recommendedSize'] = $brandIconW . 'x' . $brandIconH;

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
            $getBrand = $this->qb->where('id', '?')->order('name')->get('??brand', [$id]);
            if($getBrand->rowCount() > 0){
                $brand = $getBrand->fetchAll();
                $brand = $this->langDecode($brand, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                $current = $brand[0];

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

                $update["status"] = ($_POST["status"]) ? 1 : 0;
                $update["sort_number"] = (int)$_POST["sort_number"];

                $updateResult = $this->qb->where('id', '?')->update('??brand', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control);
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{
                    //обновление url
                    $urlInsertUpdate = [
                        'alias' => htmlspecialchars($_POST['alias']),
                        'route' => $this->control . '/view/' . $id
                    ];
                    $this->qb->insertUpdate('??url', $urlInsertUpdate);
                    
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

                $insert["status"] = ($_POST["status"]) ? 1 : 0;
                $insert["sort_number"] = (int)$_POST["sort_number"];

                $insertResult = $this->qb->insert('??brand', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $id = $this->qb->lastInsertId();
                    
                    //обновление url
                    $urlInsert = [
                        'alias' => htmlspecialchars($_POST['alias']),
                        'route' => $this->control . '/view/' . $id
                    ];

                    $this->qb->insert('??url', $urlInsert);

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
            $result = $this->qb->where('id', '?')->update('??brand', ['status' => $status], [$id]);
            if($result){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }
    
    public function delete(){

        $id = (int)$_GET['param1'];
        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }
        $getBrand = $this->qb->where('id', '?')->get('??brand', [$id]);
        if($getBrand->rowCount() > 0){
            $brand = $getBrand->fetch();
        }
        
        if($brand['image']){
            $this->media->delete($brand['image']);
        }
        if($brand['images']){
            $images = json_decode($brand['images']);
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
		
		$this->qb->where('route', '?')->delete('??url', ['brand/view/' . $id]);
        $resultDelete = $this->qb->where('id', '?')->delete('??brand', [$id]);
        
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
    
}

