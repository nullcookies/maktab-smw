<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class BannerModel extends Model {

    public $positions = ['bottom', 'news section'];

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

        $banners = [];
        $getBanners = $this->qb->order('position')->order('sort_number')->get('??banner');
        if($getBanners->rowCount() > 0){
            $banners = $getBanners->fetchAll();
            $banners = $this->langDecode($banners, ['name', 'url']);
        }

        $data['banners'] = $banners;

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

        $data['positions'] = $this->positions;

        
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

        $data['positions'] = $this->positions;
        
        $controls = [];
        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/edit/' . $id, true);
        $data['controls'] = $controls;

        $loadedImages = [];
        $initialPreview = [];
        $initialPreviewConfig = [];

        $current = [];
        if($id){
            $getBanner = $this->qb->where('id', '?')->order('name')->get('??banner', [$id]);
            if($getBanner->rowCount() > 0){
                $banner = $getBanner->fetchAll();
                $banner = $this->langDecode($banner, ['name', 'url']);
                $current = $banner[0];

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
        
        if(!$new) {
            $id = (int)$_POST['id'];
        }

        $rules = [ 
            'post' => [
                'name' => ['isRequired'],
                'position' => ['isRequired'],
            ],
            'files' => [
                
            ]

        ];

        // if($_FILES['image']['error'] == 0){
        //     $rules['files']['image'] = ['isImage', ['maxSize', 3000000]];
        //     $data['files'] = $_FILES;
        // }

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

                $update['images'] = json_encode($_POST['images'], JSON_UNESCAPED_UNICODE);

                $update['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $update['url'] = json_encode($_POST['url'], JSON_UNESCAPED_UNICODE);

                $update['position'] = (in_array($_POST['position'], $this->positions)) ? $_POST['position'] : $this->positions[0];

                $update["status"] = ($_POST["status"]) ? 1 : 0;
                $update["sort_number"] = (int)$_POST["sort_number"];

                $updateResult = $this->qb->where('id', '?')->update('??banner', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control);
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{                    
                    $this->successText = $this->getTranslation('success edit ' . $this->control);
                    return true;
                }
                
            }
            else{
                $insert = [];
                
                $insert['images'] = json_encode($_POST['images'], JSON_UNESCAPED_UNICODE);

                $insert['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $insert['url'] = json_encode($_POST['url'], JSON_UNESCAPED_UNICODE);

                $insert['position'] = (in_array($_POST['position'], $this->positions)) ? $_POST['position'] : $this->positions[0];

                $insert["status"] = ($_POST["status"]) ? 1 : 0;
                $insert["sort_number"] = (int)$_POST["sort_number"];

                $insertResult = $this->qb->insert('??banner', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $id = $this->qb->lastInsertId();

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
            $result = $this->qb->where('id', '?')->update('??banner', ['status' => $status], [$id]);
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
        $getBanner = $this->qb->where('id', '?')->get('??banner', [$id]);
        if($getBanner->rowCount() > 0){
            $banner = $getBanner->fetch();
        }
        
        if($banner['image']){
            $this->media->delete($banner['image']);
        }
        if($banner['images']){
            $images = json_decode($banner['images']);
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
		
        $resultDelete = $this->qb->where('id', '?')->delete('??banner', [$id]);
        
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

