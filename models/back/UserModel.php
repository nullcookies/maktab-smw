<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class UserModel extends Model {
    
    public $usergroups = [1, 2, 3, 4, 5, 10];

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

        $users = [];
        //TODO: user module access
        if($_SESSION['usergroup'] > 0 && $_SESSION['usergroup'] <= 3){
            if($_SESSION['usergroup'] > 1){
                $this->qb->where('usergroup >=', $_SESSION['usergroup']);
            }
            
            $this->qb->order('id', true);
            $getUsers = $this->qb->get('??user');
            if($getUsers->rowCount() > 0){
                $users = $getUsers->fetchAll();
            }
        }

        $data['users'] = $users;

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
        $usergroups = $this->usergroups;
        foreach ($usergroups as $key => $value) {
            if($value < $_SESSION['usergroup']){
                unset($usergroups[$key]);
            }
        }
        $data['usergroups'] = $usergroups;
        

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
            $getuser = $this->qb->where('id', '?')->order('name')->get('??user', [$id]);
            if($getuser->rowCount() > 0){
                $user = $getuser->fetchAll();
                $current = $user[0];
            }
        }
        if($_POST){
            $current = $_POST;
        }
        $current['icon'] = $this->linker->getIcon($this->media->resize($current['image'], 150, 150, NULL, true));

        $usergroups = $this->usergroups;
        foreach ($usergroups as $key => $value) {
            if($value < $_SESSION['usergroup']){
                unset($usergroups[$key]);
            }
        }
        $data['usergroups'] = $usergroups;

        $data[$this->control] = $current;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }
    
    public function save($new = false){
        
        $isUniqueParams = [
            'table' => '??user',
            'column' => 'username'
        ];
        $isUniqueParamsEmail = [
            'table' => '??user',
            'column' => 'email'
        ];
        if(!$new) {
            $id = (int)$_POST['id'];
            $isUniqueParams['id'] = $id;
            $isUniqueParamsEmail['id'] = $id;
        }

        $rules = [ 
            'post' => [
                //'name' => ['isRequired'],
                'email' => ['isRequired', 'isEmail', ['isUnique', $isUniqueParamsEmail]],
                'username' => ['isRequired', 'isUsername', ['isUnique', $isUniqueParams]],
                'usergroup' => ['isRequired'],
            ],
            'files' => [
                
            ]

        ];

        if($_FILES['image']['error'] == 0){
            $rules['files']['image'] = ['isImage', ['maxSize', 3000000]];
            $data['files'] = $_FILES;
        }

        if($new){
            $rules['post']['password'] = ['isRequired'];
        }

        $_POST = $this->cleanForm($_POST);

        $_POST['username'] = strtolower($_POST['username']);
        if(isset($_POST['usergroup'])){
            if($_POST['usergroup'] < $_SESSION['usergroup']){
                $_POST['usergroup'] = $_SESSION['usergroup'];
            }
        }

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
                if($_FILES['image']['error'] == 0){
                    $imageUploaded = $this->media->upload($_FILES['image'], $this->control, $this->control . '-' . $id, true);
                    if($imageUploaded){
                        $update['image'] = $_POST['image'] = $imageUploaded;
                    }
                }
                if($_POST['new_password']){
                    $update['password'] = $this->hashPassword($_POST['new_password']);
                }
                $update['username'] = $_POST['username'];
                //$update['name'] = $_POST['name'];
                $update['email'] = $_POST['email'];
                $update['usergroup'] = (int)$_POST['usergroup'];
                $update['phone'] = $_POST['phone'];
                $update['address'] = $_POST['address'];
                
                $update['firstname'] = $_POST['firstname'];
                $update['lastname'] = $_POST['lastname'];
                $update['middlename'] = $_POST['middlename'];
                //$update['company_name'] = $_POST['company_name'];

                //$update['balance'] = (int)$_POST['balance'];
                //$update['bank_name'] = $_POST['bank_name'];
                //$update['checking_account'] = $_POST['checking_account'];
                //$update['mfo'] = $_POST['mfo'];
                //$update['inn'] = $_POST['inn'];
                //$update['okonx'] = $_POST['okonx'];
                //$update['requisites'] = $_POST['requisites'];
                
                //$update['contract_number'] = $_POST['contract_number'];
                //$update['contract_date_start'] = $_POST['contract_date_start'];
                //$update['contract_date_end'] = $_POST['contract_date_end'];
                
                //$update['address_jur'] = $_POST['address_jur'];
                //$update['address_phy'] = $_POST['address_phy'];
                //$update['license_number'] = $_POST['license_number'];
                //$update['license_date_end'] = $_POST['license_date_end'];


                $updateResult = $this->qb->where('id', '?')->update('??user', $update, [$id]);
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
                
                $insert['date_reg'] = time();
                $insert['status'] = 1;
                $insert['activationkey'] = 1;

                $insert['password'] = $this->hashPassword($_POST['password']);
                $insert['username'] = htmlspecialchars($_POST['username']);
                //$insert['name'] = $_POST['name'];
                $insert['email'] = $_POST['email'];
                $insert['usergroup'] = (int)$_POST['usergroup'];
                $insert['phone'] = $_POST['phone'];
                $insert['address'] = $_POST['address'];
                
                $insert['firstname'] = $_POST['firstname'];
                $insert['lastname'] = $_POST['lastname'];
                $insert['middlename'] = $_POST['middlename'];
                //$insert['company_name'] = $_POST['company_name'];

                //$insert['balance'] = (int)$_POST['balance'];
                //$insert['bank_name'] = $_POST['bank_name'];
                //$insert['checking_account'] = $_POST['checking_account'];
                //$insert['mfo'] = $_POST['mfo'];
                //$insert['inn'] = $_POST['inn'];
                //$insert['okonx'] = $_POST['okonx'];
                //$insert['requisites'] = $_POST['requisites'];
                
                //$insert['contract_number'] = $_POST['contract_number'];
                //$insert['contract_date_start'] = $_POST['contract_date_start'];
                //$insert['contract_date_end'] = $_POST['contract_date_end'];
                
                //$insert['address_jur'] = $_POST['address_jur'];
                //$insert['address_phy'] = $_POST['address_phy'];
                //$insert['license_number'] = $_POST['license_number'];
                //$insert['license_date_end'] = $_POST['license_date_end'];

                $insertResult = $this->qb->insert('??user', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $id = $this->qb->lastInsertId();
                    $imageUploaded = $this->media->upload($_FILES['image'], $this->control, $this->control . '-' . $id, true);
                    if($imageUploaded){
                        $update = [];
                        $update['image'] = $_POST['image'] = $imageUploaded;
                        $this->qb->where('id', '?')->update('??user', $update, [$id]);
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
            $result = $this->qb->where('id', '?')->update('??user', ['status' => $status], [$id]);
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
        $getuser = $this->qb->where('id', '?')->get('??user', [$id]);
        if($getuser->rowCount() > 0){
            $user = $getuser->fetch();
        }
        
        if($user['image']){
            $this->media->delete($user['image']);
        }

        $resultDelete = $this->qb->where('id', '?')->delete('??user', [$id]);
        
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

    public function login(){
        $data = [];

        $this->document = new Document();
        $this->document->title = $this->getTranslation('login page');
        $this->document->bodyClass = 'login-page';

        foreach($_POST as $key => $value){
        	$_POST[$key] = trim($value);
        }
        $errors = [];
        $username = '';
        if(isset($_POST['username']) && isset($_POST['password'])){
        	$username = strtolower($_POST['username']);
        	$password = $_POST['password'];
        	if(empty($_POST['username'])) $errors['username'] = $this->getTranslation('error username empty');
        	if(empty($_POST['password'])) $errors['password'] = $this->getTranslation('error password empty');
        	$checkUserExist = $this->qb->where('username', '?')->get('??user', [$username]);
			if($checkUserExist->rowCount() == 0){
				$errors['username'] = $this->getTranslation('error no such username');
			}
        	if(!$errors){
        		$password = $this->hashPassword($password);
        		$checkUser = $this->qb->where([['username', '?'], ['password', '?']])->get('??user', [$username, $password]);
        		
        		if($checkUser->rowCount() > 0){
        			$user = $checkUser->fetch();
        			$_SESSION['user_id'] = $user['id'];
        			$_SESSION['usergroup'] = $user['usergroup'];
        			$update = [
        				'phpsessid' => $_COOKIE['PHPSESSID'],
        				'last_ip' => $_SERVER['REMOTE_ADDR'],
        				'last_login' => time(),
        				'date_activity' => time()
        			];
        			$this->qb->where('id', '?')->update('??user', $update, [$user['id']]);
        			header('Location: ' . BASEURL_ADMIN . '/');
    				exit;
        		}
        	}
        	if(!empty($_POST['password'])) $errors['password'] = $this->getTranslation('error password');
        	
        }
        $data['username'] = $_POST['username'];
        $data['errors'] = $errors;

        $data['action'] = BASEURL_ADMIN . '/user/login/';

        $this->data = $data;

        return $this;
    }

    public function logout(){
    	unset($_SESSION['user_id']);
    	unset($_SESSION['usergroup']);
    	session_destroy();
    	header('Location: ' . BASEURL_ADMIN . '/');
    	exit;
    }

}



