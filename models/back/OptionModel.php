<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class OptionModel extends Model {

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
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/slimScroll/jquery.slimscroll.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/fastclick/fastclick.js');

        $controls = [];

        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $data['controls'] = $controls;

        $options = [];
        $getOptions = $this->qb->where('visible', '1')->order('name')->get('??option');
        if($getOptions->rowCount() > 0){
            $options = $getOptions->fetchAll();
        }

        $data['options'] = $options;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function additional() {
        
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
            'name' => $this->getTranslation('additional settings'),
            'url' => 'active'
        ];

        $data['cleanCacheUrl'] = $this->linker->getUrl($this->control . '/clean/cache', true);
        $data['cacheSize'] = $this->showSize(BASEPATH . '/uploads/cache/');
        $data['cacheSynchroSize'] = $this->showSize(BASEPATH . '/uploads-synchro/cache/');
        

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

        $maintainance = 0;
        $options = [];
        $getOptions = $this->qb->order('name')->get('??option');
        if($getOptions->rowCount() > 0){
            $options = $getOptions->fetchAll();
            foreach ($options as $value) {
            	if($value['name'] == 'maintainance'){
            		$maintainance = $value['content'];
            	}
            }
        }
        $data['options'] = $options;
        $data['maintainance'] = $maintainance;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function fixLangTables(){
        $response = [];
        $response['inserted_file_name'] = 0;
        $response['inserted_product_name'] = 0;
        $response['inserted_category_name'] = 0;
        
        $lang = [];
        $getLang = $this->qb->where('status', '1')->get('??lang');
        if($getLang->rowCount() > 0){
            $lang = $getLang->fetchAll();
        }
        
        $files = $this->qb->select('id')->get('??file');
        if($files->rowCount() > 0){
            $files = $files->fetchAll();
            $selectSth = $this->qb->prepare("SELECT file_id, lang_id FROM ??file_name WHERE file_id = ? AND lang_id = ?");
            $insertSth = $this->qb->prepare("INSERT INTO ??file_name (file_id, name, lang_id) VALUES (?, '', ?)");
            if(count($lang) > 0){
                foreach($files as $fileValue){
                    foreach($lang as $langValue){
                        $selectSth->execute([$fileValue['id'], $langValue['id']]);
                        if($selectSth->rowCount() == 0){
                            $resultInsert = $insertSth->execute([$fileValue['id'], $langValue['id']]);
                            if($resultInsert){
                                $response['inserted_file_name']++;
                            }
                        }
                    }
                }
            }
        }
        
        $products = $this->qb->select('id')->get('??product');
        if($products->rowCount() > 0){
            $products = $products->fetchAll();
            $selectSth = $this->qb->prepare("SELECT product_id, lang_id FROM ??product_name WHERE product_id = ? AND lang_id = ?");
            $insertSth = $this->qb->prepare("INSERT INTO ??product_name (product_id, name, lang_id) VALUES (?, '', ?)");
            if(count($lang) > 0){
                foreach($products as $productValue){
                    foreach($lang as $langValue){
                        $selectSth->execute([$productValue['id'], $langValue['id']]);
                        if($selectSth->rowCount() == 0){
                            $resultInsert = $insertSth->execute([$productValue['id'], $langValue['id']]);
                            if($resultInsert){
                                $response['inserted_product_name']++;
                            }
                        }
                    }
                }
            }
        }
        
        $categories = $this->qb->select('id')->get('??category');
        if($categories->rowCount() > 0){
            $categories = $categories->fetchAll();
            $selectSth = $this->qb->prepare("SELECT category_id, lang_id FROM ??category_name WHERE category_id = ? AND lang_id = ?");
            $insertSth = $this->qb->prepare("INSERT INTO ??category_name (category_id, name, lang_id) VALUES (?, '', ?)");
            if(count($lang) > 0){
                foreach($categories as $categoryValue){
                    foreach($lang as $langValue){
                        $selectSth->execute([$categoryValue['id'], $langValue['id']]);
                        if($selectSth->rowCount() == 0){
                            $resultInsert = $insertSth->execute([$categoryValue['id'], $langValue['id']]);
                            if($resultInsert){
                                $response['inserted_category_name']++;
                            }
                        }
                    }
                }
            }
        }


        $response['success'] = true;

        return $response;

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
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/timepicker/bootstrap-timepicker.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/select2/select2.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/css/fileinput.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/select2/select2.full.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/input-mask/jquery.inputmask.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/input-mask/jquery.inputmask.date.extensions.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/input-mask/jquery.inputmask.extensions.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/min/moment.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/locale/ru.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/bootstrap-datepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/locales/bootstrap-datepicker.' . LANG_PREFIX . '.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/timepicker/bootstrap-timepicker.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/slimScroll/jquery.slimscroll.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/iCheck/icheck.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/fileinput.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/locales/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/ckeditor.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/fastclick/fastclick.js');
        
        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/add', true);

        $data['controls'] = $controls;

        $data['option'] = [];
        if($_POST){
            $data['option'] = $_POST;
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
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control);

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datepicker/datepicker3.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/iCheck/all.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/timepicker/bootstrap-timepicker.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/select2/select2.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/css/fileinput.css');
        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/select2/select2.full.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/input-mask/jquery.inputmask.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/input-mask/jquery.inputmask.date.extensions.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/input-mask/jquery.inputmask.extensions.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/min/moment.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/moment/locale/ru.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/daterangepicker/daterangepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/bootstrap-datepicker.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datepicker/locales/bootstrap-datepicker.' . LANG_PREFIX . '.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/colorpicker/bootstrap-colorpicker.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/timepicker/bootstrap-timepicker.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/slimScroll/jquery.slimscroll.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/iCheck/icheck.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/cropper/dist/cropper.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/fileinput.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-fileinput/js/locales/'.LANG_PREFIX.'.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/ckeditor/ckeditor.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/fastclick/fastclick.js');
        
        $controls = [];

        $controls['back'] = $this->linker->getUrl($this->control, true);
        $controls['action'] = $this->linker->getUrl($this->control . '/edit/' . $id, true);

        $data['controls'] = $controls;

        $current = [];
        if($id){
            $getOption = $this->qb->where('id', '?')->get('??option', [$id]);
            if($getOption->rowCount() > 0){
                $option = $getOption->fetchAll();
                $current = $option[0];
            }
        }
        if($_POST){
            $current = $_POST;
        }

        $data['option'] = $current;

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

        $isUniqueParams = [
            'table' => '??option',
            'column' => 'name'
        ];
        if(!$new) {
            $isUniqueParams['id'] = $id;
        }

        $data = [];
        $rules = [ 
            'post' => [
                'name' => ['isRequired', ['isUnique', $isUniqueParams]],
                'content' => ['isRequired'],
            ],
            'files' => [
                
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

                $update['name'] = $_POST['name'];
                $update['content'] = $_POST['content'];
                $update['comment'] = $_POST['comment'];

                $updateResult = $this->qb->where('id', '?')->update('??option', $update, [$id]);
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
                
                $insert['name'] = $_POST['name'];
                $insert['content'] = $_POST['content'];
                $insert['comment'] = $_POST['comment'];
                $insert['visible'] = 1;

                $insertResult = $this->qb->insert('??option', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
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
            $result = $this->qb->where('id', '?')->update('??option', ['content' => $status], [$id]);
            if($result){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }

    public function clean() {
        $action = $_GET['param1'];
        $return = false;
        $dir = BASEPATH . '/uploads/cache';
        $dir2 = BASEPATH . '/uploads-synchro/cache';
        if($action == 'cache'){
            $this->removeDirectory($dir);
            $this->removeDirectory($dir2);
            $return = true;
        }
        return $return;
    }

    private function removeDirectory($dir) {
        if(!is_dir($dir)){
            return false;
        }
        if ($objs = glob($dir . "/*")) {
           foreach($objs as $obj) {
             is_dir($obj) ? $this->removeDirectory($obj) : unlink($obj);
           }
        }
        return rmdir($dir);
    }
    
    public function delete(){

        $id = (int)$_GET['param1'];
        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }
        $getOption = $this->qb->where('id', '?')->get('??option', [$id]);
        if($getOption->rowCount() > 0){
            $option = $getOption->fetch();
        }

        $resultDelete = $this->qb->where('id', '?')->delete('??option', [$id]);
        
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

