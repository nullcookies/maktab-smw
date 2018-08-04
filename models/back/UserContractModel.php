<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class UserContractModel extends Model {

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

        $usercontracts = [];
        $getUsercontracts = $this->qb->select('uc.*, u.company_name')->join('??user u', 'uc.user_id = u.id')->order('uc.contract_year', true)->order('u.company_name')->get('??usercontract uc');
        if($getUsercontracts->rowCount() > 0){
            $usercontracts = $getUsercontracts->fetchAll();
        }

        $data['usercontracts'] = $usercontracts;


        $controls = [];

        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $data['controls'] = $controls;

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

        $data[$this->control] = [];
        if($_POST){
            $data[$this->control] = $_POST;
        }
        
        $categories = [];
        $getCategories = $this->qb->select('id, name')->where('status', '1')->order('name')->get('??category');
        if($getCategories->rowCount() > 0){
            $categories = $getCategories->fetchAll();
            $categories = $this->langDecode($categories, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['categories'] = $categories;

        $users = [];
        $getUsers = $this->qb->select('id, company_name')->where('usergroup', '6')->order('company_name')->get('??user');
        if($getUsers->rowCount() > 0){
            $users = $getUsers->fetchAll();
        }
        $data['users'] = $users;

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
            $getUserContract = $this->qb->where('id', '?')->get('??usercontract', [$id]);
            if($getUserContract->rowCount() > 0){
                $userContract = $getUserContract->fetch();
                $userContractQuarters = [
                    'quarter_1', 
                    'quarter_2', 
                    'quarter_3', 
                    'quarter_4'
                ];
                foreach($userContractQuarters as $value){
                    $userContract[$value] = json_decode($userContract[$value], true);
                }
                $userContract['price'] = json_decode($userContract['price'], true);
                $current = $userContract;
            }
        }
        if($_POST){
            $current = $_POST;
        }

        $data[$this->control] = $current;

        $categories = [];
        $getCategories = $this->qb->select('id, name')->where('status', '1')->order('name')->get('??category');
        if($getCategories->rowCount() > 0){
            $categories = $getCategories->fetchAll();
            $categories = $this->langDecode($categories, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        $data['categories'] = $categories;

        $users = [];
        $getUsers = $this->qb->select('id, company_name')->where('usergroup', '6')->order('company_name')->get('??user');
        if($getUsers->rowCount() > 0){
            $users = $getUsers->fetchAll();
        }
        $data['users'] = $users;

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
                'contract_number' => ['isRequired'],
                'contract_year' => ['isRequired'],
                'user_id' => ['isRequired'],
            ],
            'files' => [
                
            ]

        ];

        $postQuarters = [
            'quarter_1' => $_POST['quarter_1'], 
            'quarter_2' => $_POST['quarter_2'], 
            'quarter_3' => $_POST['quarter_3'], 
            'quarter_4' => $_POST['quarter_4']
        ];
        foreach($postQuarters as $key => $value){
            if(is_array($value)){
                foreach($value as $key1 => $value1){
                    $_POST[$key][$key1] = (float)$value1;
                }
            }
        }
        if(is_array($_POST['price'])){
            foreach($_POST['price'] as $key => $value){
                $_POST['price'][$key] = (int)$value;
            }
        }

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

                $update['user_id'] = (int)$_POST['user_id'];
                $update['contract_year'] = $_POST['contract_year'];
                $update['contract_number'] = $_POST['contract_number'];

                $update['quarter_1'] = json_encode($_POST['quarter_1'], JSON_UNESCAPED_UNICODE);
                $update['quarter_2'] = json_encode($_POST['quarter_2'], JSON_UNESCAPED_UNICODE);
                $update['quarter_3'] = json_encode($_POST['quarter_3'], JSON_UNESCAPED_UNICODE);
                $update['quarter_4'] = json_encode($_POST['quarter_4'], JSON_UNESCAPED_UNICODE);

                $update['price'] = json_encode($_POST['price'], JSON_UNESCAPED_UNICODE);

                $updateResult = $this->qb->where('id', '?')->update('??usercontract', $update, [$id]);
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
                
                $insert['user_id'] = (int)$_POST['user_id'];
                $insert['contract_year'] = $_POST['contract_year'];
                $insert['contract_number'] = $_POST['contract_number'];

                $insert['quarter_1'] = json_encode($_POST['quarter_1'], JSON_UNESCAPED_UNICODE);
                $insert['quarter_2'] = json_encode($_POST['quarter_2'], JSON_UNESCAPED_UNICODE);
                $insert['quarter_3'] = json_encode($_POST['quarter_3'], JSON_UNESCAPED_UNICODE);
                $insert['quarter_4'] = json_encode($_POST['quarter_4'], JSON_UNESCAPED_UNICODE);

                $insert['price'] = json_encode($_POST['price'], JSON_UNESCAPED_UNICODE);

                $insertResult = $this->qb->insert('??usercontract', $insert);
                
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
            $result = $this->qb->where('id', '?')->update('??usercontract', ['status' => $status], [$id]);
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
        
        $resultDelete = $this->qb->where('id', '?')->delete('??usercontract', [$id]);
        
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

