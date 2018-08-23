<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\objects\User;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class UserModel extends Model {
    
    public $usergroups = [1, 2, 3, 4, 5, 10];
    public $fullAccess = [1, 2];

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
            if(!in_array($_SESSION['usergroup'], $this->fullAccess)){
                $this->qb->where('usergroup >=', $_SESSION['usergroup']);
            }
            else{
                $this->qb->where('usergroup >', $_SESSION['usergroup']);
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

        // $mysql = new \SQLBuilder\Driver\MySQLDriver;
        // $args = new \SQLBuilder\ArgumentArray;

        // $query = new \SQLBuilder\Universal\Query\SelectQuery;
        // $query->select(array('id', 'name', 'phone', 'address','confirmed'))
        //     ->from('users', 'u')
        //     ->partitions('u1', 'u2', 'u3')
        //     ->where()
        //         ->is('confirmed', true)
        //         ->in('id', [1,2,3])
        //     ;
        // $query
        //     ->join('posts')
        //         ->as('p')
        //         ->on('p.user_id = u.id')
        //     ;
        // $query
        //     ->orderBy('rand()')
        //     ->orderBy('id', 'DESC')
        //     ;

        // $sql = $query->toSql($mysql, $args);

        // var_dump($sql);
        // var_dump($args);
        
        $id = (int)$_GET['param1'];
        if(!$id){
            $id = (int)$_POST['id'];
        }

        $user = new User;
        $user->find($id);
        if($user->usergroup < $_SESSION['usergroup']){
            exit('Access Error');
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
            $getuser = $this->qb->where([['id', '?'], ['usergroup >=', '?']])->get('??user', [$id, $_SESSION['usergroup']]);
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
        
        $user = new User;
        

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
            $user->find($id);
        }

        
        if($user->usergroup < $_SESSION['usergroup']){
            exit('Access Error');
        }

        //usergroup 1, 2 - administrator
        //usergroup access control 1, 2 - full access

        $rules = [ 
            'post' => [
                //'name' => ['isRequired'],
                'email' => ['isRequired', 'isEmail', ['isUnique', $isUniqueParamsEmail]],
                'username' => ['isRequired', 'isUsername', ['isUnique', $isUniqueParams]],
                'usergroup' => ['isRequired', [ 'accessControl', ['type' => '>=', 'value' => $_SESSION['usergroup']] ]],
            ],
            'files' => [
                
            ]

        ];

        if($_FILES['image']['error'] == 0){
            $rules['files']['image'] = ['isImage', ['maxSize', $this->config['params']['max_image_size']]];
            $data['files'] = $_FILES;
        }

        if($new){
            $rules['post']['password'] = ['isRequired'];
        }

        $_POST = $this->cleanForm($_POST);

        $_POST['username'] = strtolower($_POST['username']);

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

            $user->username = $_POST['username'];

            $user->email = $_POST['email'];
            $user->usergroup = (int)$_POST['usergroup'];
            $user->phone = $_POST['phone'];
            $user->address = $_POST['address'];
            
            $user->firstname = $_POST['firstname'];
            $user->lastname = $_POST['lastname'];
            $user->middlename = $_POST['middlename'];

            $user->status = 1;

            if(!$new) {
                if(!empty($_POST['new_password'])){
                    $user->password = $this->hashPassword($_POST['new_password']);
                }
            }
            else{
                $user->created_at = time();
                $user->password = $this->hashPassword($_POST['password']);
            }

            $user->save();

            if($user->savedSuccess){
                
                if($_FILES['image']['error'] == 0){
                    $imageUploaded = $this->media->upload($_FILES['image'], $this->control, $this->control . '-' . $id, true);
                    if($imageUploaded){
                        $user->image = $imageUploaded;
                        $user->save();
                    }
                }

                $this->successText = $this->getTranslation('success edit ' . $this->control);
            }
            else{
                $this->errorText = $this->getTranslation('error edit ' . $this->control);
                $this->errors['error db'] = $this->getTranslation('error db');
            }
            return $user->savedSuccess;
        }
    }

    public function toggle() {
        $id = $_GET['param1'];
        $user = new User;
        $user->find($id);
        if($user->usergroup < $_SESSION['usergroup'] || ($user->usergroup == $_SESSION['usergroup'] && $user->id != $_SESSION['userid']) ){
            exit('Access Error');
        }

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
        
        $user = new User;
        $user->find($id);
        if($user->usergroup < $_SESSION['usergroup'] || ($user->usergroup == $_SESSION['usergroup'] && $user->id != $_SESSION['userid']) ){
            exit('Access Error');
        }

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
        				'activity_at' => time()
        			];
        			$this->qb->where('id', '?')->update('??user', $update, [$user['id']]);
        			header('Location: ' . BASEURL_ADMIN . '/');
    				exit;
        		}
        	}
        	if(!empty($_POST['password'])) $errors['password'] = $this->getTranslation('error password');
        	
        }
        $data['username'] = (!empty($_POST['username'])) ? $_POST['username'] : '';
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



