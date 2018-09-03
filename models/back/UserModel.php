<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\objects\User;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class UserModel extends Model {
    
    public $usergroups = [1, 2, 3, 4, 5, 10, 11];
    public $fullAccess = [1, 2];

    public function index()
    {
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->t('main page', 'back'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->t($this->control . ' page', 'back'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->t('control panel', 'back') . ' - ' . $this->t($this->control . ' page', 'back');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/mixitup-3/dist/mixitup.min.js');
        
        $controls = [];
        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['view'] = $this->linker->getUrl($this->control . '/view', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);
        $data['controls'] = $controls;

        $dataTableAjaxParams = [];
        $dataTableAjaxParams['page-start'] = (!empty($_GET['page_start'])) ? $_GET['page_start'] : '';
        $dataTableAjaxParams['page-length'] = (!empty($_GET['page_length'])) ? $_GET['page_length'] : '';
        $dataTableAjaxParams['page-order-column'] = (!empty($_GET['page_order_column'])) ? $_GET['page_order_column'] : '';
        $dataTableAjaxParams['page-order-dir'] = (!empty($_GET['page_order_dir'])) ? $_GET['page_order_dir'] : '';
        $data['dataTableAjaxParams'] = $dataTableAjaxParams;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }

    public function list_ajax()
    {
        
        $data = [];

        $controls = [];
        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['view'] = $this->linker->getUrl($this->control . '/view', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);
        $data['controls'] = $controls;

        $_POST = $this->cleanForm($_POST);

        $data['draw'] = (int)$_POST['draw'];
        
        $totalWhere = [];
        if($_SESSION['usergroup'] > 0 && $_SESSION['usergroup'] <= 3){
            if(in_array($_SESSION['usergroup'], $this->fullAccess)){
                $totalWhere[] = ['usergroup >=', $_SESSION['usergroup']];
            }
            else{
            	$totalWhere[] = ['usergroup >', $_SESSION['usergroup']];
            }
        }
        else{
        	exit('Access Error');
        }


        $totalRows = $this->qb->select('id')->where($totalWhere)->count('??user');
        $data['recordsTotal'] = $totalRows;

        $offset = (int)$_POST['start'];
        // if(isset($_POST['page_start'])){
        //     $offset = (int)$_POST['page_start'];
        // }

        $limit = (int)$_POST['length'];
        // if(isset($_POST['page_length'])){
        //     $limit = (int)$_POST['page_length'];
        // }
        if($limit < 1){
            $limit = 10;
        }

        $getOrder = (int)$_POST['order'][0]['column'];
        // if(isset($_POST['page_order_column'])){
        //     $getOrder = (int)$_POST['page_order_column'];
        // }
        switch ($getOrder) {
            case 0:
                $order = 'id';
                break;
            
            case 1:
                $order = 'username';
                break;
            
            case 2:
                $order = 'usergroup';
                break;
            
            case 3:
                $order = 'lastname';
                break;
            
            case 4:
                $order = 'firstname';
                break;
            
            case 5:
                $order = 'phone';
                break;
            
            case 6:
                $order = 'email';
                break;
            
            case 7:
                $order = 'status';
                break;
            
            default:
                $order = 'id';
                break;
        }

        $getOrderDir = $_POST['order'][0]['dir'];
        // if(isset($_POST['page_order_dir'])){
        //     $getOrderDir = $_POST['page_order_dir'];
        // }
        $orderDir = ($getOrderDir == 'desc') ? 'DESC' : 'ASC';


        $recordsFiltered = $totalRows;

        $search_where = '';
        $where_params = null;

        $search = $_POST['search']['value'];
        $searchText = substr($search, 0, 65536);

        if($searchText){
            $where_params = [];
            $search_where = " (username LIKE ? OR email LIKE ? OR phone LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR middlename LIKE ?) ";
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $querySearch = 'SELECT id FROM ??user WHERE ' . $search_where . ' AND ' . implode(' ', $totalWhere[0]) . ' GROUP BY id ';
            $sth1 = $this->qb->prepare($querySearch);
            $sth1->execute($where_params);
            $recordsFiltered = $sth1->rowCount();
        }
        $data['recordsFiltered'] = $recordsFiltered;


        $query = 'SELECT id, firstname, lastname, middlename, username, phone, email, usergroup, status, activity_at FROM ??user ';

        $query .= ' WHERE ' . implode(' ', $totalWhere[0]) . ' ';
        if($searchText){
            $query .= ' AND ' . $search_where;
        }
        $query .= ' GROUP BY id ';
        $query .= ' ORDER BY ' . $order . ' ' . $orderDir . ' ';
        $query .= ' LIMIT ' . $offset . ', ' . $limit . ' ';

        $getItems = $this->qb->prepare($query);
        $getItems->execute($where_params);

        $items = [];
        if($getItems->rowCount() > 0){
            $items = $getItems->fetchAll();
        }

        $itemsData = [];
        foreach($items as $value){
            $itemsDataRow = [];

            $itemsDataRow[0] = $value['id'];
            $itemsDataRow[1] = $value['username'];
            $itemsDataRow[2] = $this->t('usergroup ' . $value['usergroup'], 'back');
            $itemsDataRow[3] = $value['lastname'];
            $itemsDataRow[4] = $value['firstname'];
            $itemsDataRow[5] = $value['phone'];
            $itemsDataRow[6] = $value['email'];
            
            $itemsDataRow[7] =   '<div class="status-change">' . 
                                    '<input data-toggle="toggle" data-on="' . $this->t('toggle on', 'back') . '" data-off="' . $this->t('toggle off', 'back') . '" data-onstyle="warning" type="checkbox" name="status" data-controller="user" data-table="user" data-id="' . $value['id'] . '" class="status-toggle" ' . (($value['status']) ? 'checked' : '') . '>' .
                                    '</div>';
            $itemsDataRow[8] =   '<a class="btn btn-info entry-edit-btn" title="' . $this->t('btn edit', 'back') . '" href="' . $controls['view'] . '?id=' .  $value['id'] . '">' .
                                        '<i class="fa fa-edit"></i>' .
                                    '</a> ' . 
                                    '<a class="btn btn-danger entry-delete-btn" href="' . $controls['delete'] . '?id=' . $value['id'] . '" data-toggle="confirmation" data-btn-ok-label="' . $this->t('confirm yes', 'back') . '" data-btn-ok-icon="fa fa-check" data-btn-ok-class="btn-success btn-xs" data-btn-cancel-label=" ' . $this->t('confirm no', 'back') . '" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-danger btn-xs" data-title="' . $this->t('are you sure', 'back') . '" >' . 
                                        '<i title="' . $this->t('btn delete', 'back') . '" class="fa fa-trash-o"></i>' . 
                                    '</a>';
            $itemsData[] = $itemsDataRow;
        }



        $data['data'] = $itemsData;

        $this->data = $data;

        return $this;
    }

    public function view()
    {
        
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : (!empty($_POST['user']['id']) ? (int)$_POST['user']['id'] : 0);
        
        $user = new User();

        if($id){
            $user->find($id);
        }

        if($user->usergroup < $_SESSION['usergroup'] || ($user->usergroup == $_SESSION['usergroup'] && $user->id != $_SESSION['user_id']) ){
            exit('Access Error');
        }

        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->t('main page', 'back'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->t($this->control . ' page', 'back'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->t('view ' . $this->control, 'back'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->t('control panel', 'back') . ' - ' . $this->t($this->control, 'back');

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
        $controls['view'] = $this->linker->getUrl($this->control . '/view', true);
        $data['controls'] = $controls;
        
        if(isset($this->user)){
            $user = $this->user;
        }
        elseif(!empty($_POST['user'])){
            $user->setFields($_POST['user']);
        }

        if($user->date_birth == 0){
        	$user->date_birth = date('d-m-Y', time() - 35 * 365 * 86400);
        }
        $data['user'] = $user;

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
    
    public function save($new = false)
    {
        
        $user = new User;

        $isUniqueParams = [
            'table' => '??user',
            'column' => 'username'
        ];
        $isUniqueParamsEmail = [
            'table' => '??user',
            'column' => 'email'
        ];

        $_POST = $this->cleanForm($_POST);

        $info = $_POST['user'];
        $info['username'] = strtolower($info['username']);

        $new = true;
        $id = (int)$info['id'];

        if($id && $user->find($id)){
            $isUniqueParams['id'] = $id;
            $isUniqueParamsEmail['id'] = $id;
            $new = false;
        }

        if($user->usergroup < $_SESSION['usergroup'] || ($user->usergroup == $_SESSION['usergroup'] && $user->id != $_SESSION['user_id']) ){
            exit('Access Error');
        }

        $checkData = [];
        $checkData['info'] = $info;

        //usergroup 1, 2 - administrator
        //usergroup access control 1, 2 - full access

        $rules = [ 
            'info' => [
                //'name' => ['isRequired'],
                //'email' => ['isRequired', 'isEmail', ['isUnique', $isUniqueParamsEmail]],
                'username' => ['isRequired', 'isUsername', ['isUnique', $isUniqueParams]],
                'usergroup' => ['isRequired', [ 'accessControl', ['type' => '>=', 'value' => $_SESSION['usergroup']] ]],
            ],
            'files' => [
                
            ]
        ];
        if($new){
            $rules['info']['password'] = ['isRequired'];
        }

        if($_FILES['image']['error'] == 0){
            $rules['files']['image'] = ['isImage', ['maxSize', $this->config['params']['max_image_size']]];
            $checkData['files'] = $_FILES;
        }
        
        $valid = $this->validator->validate($rules, $checkData);
        
        if(!$valid){

            if(!$new){
                $this->errorText = $this->t('error edit ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error add ' . $this->control, 'back');
            }
            $this->errors = $this->validator->lastErrors;

            return false;

        }
        else{

            $user->setFields($info);
            
            if(!empty($info['password'])){
                $user->password = $this->hashPassword($info['password']);
            }

            $user->status = 1;

            if($new) {
                $user->created_at = time();
            }
            $user->updated_at = time();

            //convert date to timestamp
	        if(isset($info['date_birth'])){
	        	$dateTime = \DateTime::createFromFormat('d-m-Y H:i:s', $info['date_birth'] . ' 00:00:00');
	        	if($dateTime != false){
	        		$user->date_birth = $dateTime->getTimestamp();
	        	}
	        }

            $user->save();

            if($user->savedSuccess){

                if($_FILES['image']['error'] == 0){
                    $imageUploaded = $this->media->upload($_FILES['image'], $this->control, $this->control . '-' . $user->id, true);
                    if($imageUploaded){
                    	if(!empty($user->image)){
                    		$this->media->delete($user->image);
                    	}
                        $user->image = $imageUploaded;
                        $user->save();
                    }
                }

                $this->user = $user;
                $this->successText = $this->t('success edit ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error edit ' . $this->control, 'back');
                $this->errors['error db'] = $this->t('error db', 'back');
            }
            return $user->savedSuccess;
        }
    }

    public function toggle()
    {
        $id = $_GET['param1'];
        $status = (int)$_GET['param2'];

        $return = '';

        $user = new User();
        if($id && $user->find($id)){

            if($user->usergroup < $_SESSION['usergroup'] || ($user->usergroup == $_SESSION['usergroup'] && $user->id != $_SESSION['userid']) ){
                exit('Access Error');
            }
            $user->status = $status;
            $user->save();

            if($user->savedSuccess){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }
    
    public function delete()
    {
    	$return = false;

        $id = (int)$_GET['id'];
        $user = new User();

        if($id && $user->find($id)) {

            if($user->usergroup < $_SESSION['usergroup'] || ($user->usergroup == $_SESSION['usergroup'] && $user->id != $_SESSION['userid']) ){
                exit('Access Error');
            }

            if($user->image){
                $this->media->delete($user->image);
            }

            $user->remove();
            
            if($user->removedSuccess){
                $this->successText = $this->t('success delete ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error delete ' . $this->control, 'back');
                $this->errors['error db'];
            }

            $return = $user->removedSuccess;
        }
        else{
            $this->errors['error invalid id'];
        }

        return $return;
    }

    public function login()
    {
        $data = [];

        $this->document = new Document();
        $this->document->title = $this->getTranslation('login page');
        $this->document->bodyClass[] = 'login-page';

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

    public function logout()
    {
    	unset($_SESSION['user_id']);
    	unset($_SESSION['usergroup']);
    	session_destroy();
    	header('Location: ' . BASEURL_ADMIN . '/');
    	exit;
    }

}
