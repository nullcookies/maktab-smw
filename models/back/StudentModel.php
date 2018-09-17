<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\objects\User;
use \models\objects\Student;
use \models\back\GroupModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class StudentModel extends Model
{
    
    /**
     * Student Usergroup
     */
    public $usergroup = 11;

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

    public function list_ajax() {
        
        $data = [];

        $controls = [];
        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['view'] = $this->linker->getUrl($this->control . '/view', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);
        $data['controls'] = $controls;

        $groupModel = new GroupModel();

        $_POST = $this->cleanForm($_POST);

        $data['draw'] = (int)$_POST['draw'];

        $totalRows = $this->qb->select('id')->where('usergroup', $this->usergroup)->count('??user');
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
                $order = 'u.id';
                break;
            
            case 1:
                $order = 'u.lastname';
                break;
            
            case 2:
                $order = 'u.firstname';
                break;
            
            case 3:
                $order = 'g.start_year';
                $order2 = 'g.name';
                break;
            
            case 4:
                $order = 'u.username';
                break;
            
            case 5:
                $order = 'u.email';
                break;
            
            case 6:
                $order = 'u.phone';
                break;
            
            case 7:
                $order = 'u.status';
                break;
            
            default:
                $order = 'u.lastname';
                break;
        }

        $getOrderDir = $_POST['order'][0]['dir'];
        // if(isset($_POST['page_order_dir'])){
        //     $getOrderDir = $_POST['page_order_dir'];
        // }
        $orderDir = ($getOrderDir == 'desc') ? 'DESC' : 'ASC';
        if(isset($order2)){
        	$orderDir2 = $orderDir;
        }
        if($order == 'g.start_year'){
        	$orderDir = ($orderDir == 'DESC') ? 'ASC' : 'DESC';
        }


        $recordsFiltered = $totalRows;

        $search_where = '';
        $where_params = null;

        $search = $_POST['search']['value'];
        $searchText = substr($search, 0, 65536);

        if($searchText){

        	$search_where = " ( ";
            $where_params = [];
            
            $search_where .= " u.username LIKE ? OR u.email LIKE ? OR u.phone LIKE ? OR u.firstname LIKE ? OR u.lastname LIKE ? OR u.middlename LIKE ? ";
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';


            $matches = [];
            $checkRegex = preg_match('/^(\d{1,2})\s?-?\s?(.)$/u', trim($searchText), $matches);

            if(isset($matches[1]) && isset($matches[2])){
            	$searchStartYear = $groupModel->getStartYear($matches[1]);
            	$search_where .= " OR (g.start_year = ? AND g.name = ?) ";
	        	$where_params[] = $searchStartYear;
	        	$where_params[] = $matches[2];
            }
            else{
            	if( mb_strlen($searchText) == 1 ){
	            	$search_where .= " OR g.name LIKE ? ";
	        		$where_params[] = '%' . $searchText . '%';
	            }
	            if( is_numeric($searchText) && $searchText >= 1 && $searchText <= 11 ){
	            	$searchStartYear = $groupModel->getStartYear($searchText);
	            	$search_where .= " OR g.start_year LIKE ? ";
	            	$where_params[] = '%' . $searchStartYear . '%';
	            }
            } 

            $search_where .= " ) ";


            $querySearch = 'SELECT u.id FROM ??user u WHERE ' . $search_where . ' AND u.usergroup = ' . $this->usergroup . ' GROUP BY u.id ';
            $sth1 = $this->qb->prepare($querySearch);
            $sth1->execute($where_params);
            $recordsFiltered = $sth1->rowCount();
        }
        $data['recordsFiltered'] = $recordsFiltered;


        $query = 'SELECT u.id, u.firstname, u.lastname, u.middlename, u.username, u.phone, u.email, u.status, u.activity_at, g.name g_name, g.start_year, g.end_year FROM ??user u LEFT JOIN ??student_to_group s2g ON u.id = s2g.student_id LEFT JOIN ??group g ON s2g.group_id = g.id ';

        $query .= ' WHERE u.usergroup = ' . $this->usergroup . ' ';
        if($searchText){
            $query .= ' AND ' . $search_where;
        }
        $query .= ' GROUP BY u.id ';
        $query .= ' ORDER BY ' . $order . ' ' . $orderDir . ' ' . (!empty($order2) && !empty($orderDir2) ? (', ' . $order2 . ' ' . $orderDir2) : '') . ' ';
        $query .= ' LIMIT ' . $offset . ', ' . $limit . ' ';


        file_put_contents('ppp1.txt', print_R($query,true));
        file_put_contents('ppp2.txt', print_R($where_params,true));

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
            $itemsDataRow[1] = $value['lastname'];
            $itemsDataRow[2] = $value['firstname'];
            $itemsDataRow[3] = $groupModel->getGrade($value['start_year'], $value['end_year']) . ' - ' . $value['g_name'];
            $itemsDataRow[4] = $value['username'];
            $itemsDataRow[5] = $value['phone'];
            $itemsDataRow[6] = $value['email'];
            
            $itemsDataRow[7] =   '<div class="status-change">' . 
                                    '<input data-toggle="toggle" data-on="' . $this->t('toggle on', 'back') . '" data-off="' . $this->t('toggle off', 'back') . '" data-onstyle="warning" type="checkbox" name="status" data-controller="student" data-table="user" data-id="' . $value['id'] . '" class="status-toggle" ' . (($value['status']) ? 'checked' : '') . '>' .
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
        
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : (!empty($_POST['student']['id']) ? (int)$_POST['student']['id'] : 0);
        
        $student = new Student();

        if($id){
            $student->find($id);
        }

        if($student->usergroup <= $_SESSION['usergroup']){
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

        if(isset($this->student)){
            $student = $this->student;
        }
        elseif(!empty($_POST['student'])){
            $student->setFields($_POST['student']);
            $student->group_id = !empty($_POST['group_id']) ? $_POST['group_id'] : '';
        }

        if($student->date_birth == 0){
        	$student->date_birth = date('d-m-Y', time() - 7 * 365 * 86400);
        }
        //$student->icon = $this->linker->getIcon($this->media->resize($student->image, 150, 150, NULL, true));

        $currentYear = date('Y');
        $groupModel = new GroupModel();
        $groups = [];
        $getGroups = $this->qb->where('end_year >=', $currentYear)->order('start_year', true)->get('??group');
        if($getGroups->rowCount()){
            $groups = $getGroups->fetchAll();
            foreach ($groups as $key => $value) {
                $groups[$key]['grade'] = $groupModel->getGrade($value['start_year'], $value['end_year']);
            }
        }
        $data['groups'] = $groups;

        $data['student'] = $student;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }
    
    public function save()
    {
        
        $student = new Student();

        $isUniqueParams = [
            'table' => '??user',
            'column' => 'username'
        ];
        $isUniqueParamsEmail = [
            'table' => '??user',
            'column' => 'email'
        ];

        $_POST = $this->cleanForm($_POST);

        $info = $_POST['student'];
        $info['username'] = strtolower($info['username']);
        
        $new = true;
        $id = (int)$info['id'];

        if($id && $student->find($id)){
            $isUniqueParams['id'] = $id;
            $isUniqueParamsEmail['id'] = $id;
            $new = false;
        }

        if($student->usergroup <= $_SESSION['usergroup']){
            exit('Access Error');
        }

        $checkData = [];
        $checkData['info'] = $info;

        $rules = [ 
            'info' => [
                //'name' => ['isRequired'],
                //'email' => ['isRequired', 'isEmail', ['isUnique', $isUniqueParamsEmail]],
                'username' => ['isRequired', 'isUsername', ['isUnique', $isUniqueParams]],
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

            $student->setFields($info);
            
            if(!empty($info['password'])){
                $student->password = $this->hashPassword($info['password']);
            }

            $student->status = 1;

            if($new) {
                $student->created_at = time();
            }
            $student->updated_at = time();

            //convert date to timestamp
	        if(isset($info['date_birth'])){
	        	$dateTime = \DateTime::createFromFormat('d-m-Y H:i:s', $info['date_birth'] . ' 00:00:00');
	        	if($dateTime != false){
	        		$student->date_birth = $dateTime->getTimestamp();
	        	}
	        }

            $student->save();

            if($student->savedSuccess){

            	if($_FILES['image']['error'] == 0){
                    $imageUploaded = $this->media->upload($_FILES['image'], $this->control, $this->control . '-' . $student->id, true);
                    if($imageUploaded){
                    	if(!empty($student->image)){
                    		$this->media->delete($student->image);
                    	}
                        $student->image = $imageUploaded;
                        $student->save();
                    }
                }

                if(isset($_POST['group_id'])){
                	$this->qb->where('student_id', '?')->delete('??student_to_group', [$student->id]);
                	$this->qb->insert('??student_to_group', ['student_id' => $student->id, 'group_id' => $_POST['group_id']]);
                	$student->group_id = $_POST['group_id'];
                }

                $this->student = $student;
                $this->successText = $this->t('success edit ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error edit ' . $this->control, 'back');
                $this->errors['error db'] = $this->t('error db', 'back');
            }
            return $student->savedSuccess;
        }
    }

    public function toggle()
    {
        $id = $_GET['param1'];
        $status = (int)$_GET['param2'];

        $return = '';

        $student = new Student();
        if($id && $student->find($id)){

            if($student->usergroup <= $_SESSION['usergroup']){
                exit('Access Error');
            }
            $student->status = $status;
            $student->save();

            if($student->savedSuccess){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }
    
    public function delete()
    {
        $return = false;

        $id = (int)$_GET['id'];
        $student = new Student();
        
        if($id && $student->find($id)) {
            
            if($student->usergroup <= $_SESSION['usergroup']){
                exit('Access Error');
            }

            if($student->image){
                $this->media->delete($student->image);
            }

            $this->qb->where('student_id', '?')->delete('??student_to_group', [$student->id]);

            $student->remove();
            
            if($student->removedSuccess){
                $this->successText = $this->t('success delete ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error delete ' . $this->control, 'back');
                $this->errors['error db'];
            }

            $return = $student->removedSuccess;

            return $student->removedSuccess;
        }
        else{
            $this->errors['error invalid id'];
        }

        return $return;
    }

}
