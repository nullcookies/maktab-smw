<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class CouponModel extends Model {

    public $couponTypes = [
        'percent',
        'amount',
    ];

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

        $coupons = [];
        $getCoupons = $this->qb->order('id', true)->get('??coupon');
        if($getCoupons->rowCount() > 0){
            $coupons = $getCoupons->fetchAll();
            $coupons = $this->langDecode($coupons, ['name', 'descr']);
            foreach ($coupons as $key => $value) {
                $coupons[$key]['date_start'] = date('d-m-Y', $value['date_start']);
                $coupons[$key]['date_end'] = date('d-m-Y', $value['date_end']);
            }
        }

        $data['coupons'] = $coupons;

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

        $current = [];
        if($_POST){
            $current = $_POST;
        }
        $data[$this->control] = $current;

        $data['couponTypes'] = $this->couponTypes;

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

        $current = [];
        if($id){
            $getCoupon = $this->qb->where('id', '?')->get('??coupon', [$id]);
            if($getCoupon->rowCount() > 0){
                $coupon = $getCoupon->fetchAll();
                $coupon = $this->langDecode($coupon, ['name', 'descr']);
                $coupon[0]['date_start'] = date('d-m-Y', $coupon[0]['date_start']);
                $coupon[0]['date_end'] = date('d-m-Y', $coupon[0]['date_end']);
                $current = $coupon[0];
            }
        }
        if($_POST){
            $current = $_POST;
        }

        $data[$this->control] = $current;

        $data['couponTypes'] = $this->couponTypes;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }
    
    public function save($new = false){
        
        $isUniqueParams = [
            'table' => '??coupon',
            'column' => 'coupon_code'
        ];
        if(!$new) {
            $id = (int)$_POST['id'];
            $isUniqueParams['id'] = $id;
        }

        $rules = [ 
            'post' => [
                'name' => ['isRequired'],
                'coupon_code' => ['isRequired', ['isUnique', $isUniqueParams]],
            ],
            'files' => [
                
            ]

        ];

        $_POST = $this->cleanForm($_POST);

        $_POST['coupon_code'] = strtoupper(preg_replace('#[^a-zA-Z0-9]#', '', $_POST["coupon_code"]));

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

            $update = [];
            $update['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
            $update['descr'] = json_encode($_POST['descr'], JSON_UNESCAPED_UNICODE);

            $update["status"] = ($_POST["status"]) ? 1 : 0;
            $update["coupon_code"] = $_POST['coupon_code'];
            if(!in_array($_POST["coupon_type"], $this->couponTypes)){
                $_POST["coupon_type"] = $this->couponTypes[0];
            }
            $update["coupon_type"] = $_POST["coupon_type"];
            $_POST["coupon_value"] = (float)$_POST["coupon_value"];
            if($_POST["coupon_type"] == 'percent' && $_POST["coupon_value"] > 100){
                $_POST["coupon_value"] = 100;
            }
            if($_POST["coupon_type"] == 'percent' && $_POST["coupon_value"] < 0){
                $_POST["coupon_value"] = 0;
            }
            $update["coupon_value"] = $_POST["coupon_value"];
            $update["min_price"] = (float)$_POST["min_price"];

            //$update["min_quantity"] = $_POST["min_quantity"];

            $dateStart = \DateTime::createFromFormat('d-m-Y', $_POST["date_start"]);
            $dateEnd = \DateTime::createFromFormat('d-m-Y', $_POST["date_end"]);

            $update["date_start"] = ($dateStart !== false) ? $dateStart->getTimestamp() : 0;
            $update["date_end"] = ($dateEnd !== false) ? $dateEnd->getTimestamp() : time() + 7 * 86400;

            if(!$new) {
                $updateResult = $this->qb->where('id', '?')->update('??coupon', $update, [$id]);
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
                $insertResult = $this->qb->insert('??coupon', $update);
                
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
            $result = $this->qb->where('id', '?')->update('??coupon', ['status' => $status], [$id]);
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
		
        $resultDelete = $this->qb->where('id', '?')->delete('??coupon', [$id]);
        
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

