<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\objects\User;
use \models\objects\Teacher;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class TeacherModel extends Model
{
    
    /**
     * Teacher Usergroup
     */
    public $usergroup = 5;

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
                $order = 'id';
                break;
            
            case 1:
                $order = 'lastname';
                break;
            
            case 2:
                $order = 'firstname';
                break;
            
            case 3:
                $order = 'username';
                break;
            
            case 4:
                $order = 'email';
                break;
            
            case 5:
                $order = 'phone';
                break;
            
            case 6:
                $order = 'status';
                break;
            
            default:
                $order = 'lastname';
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
            $querySearch = 'SELECT id FROM ??user WHERE ' . $search_where . ' AND usergroup = ' . $this->usergroup . ' GROUP BY id ';
            $sth1 = $this->qb->prepare($querySearch);
            $sth1->execute($where_params);
            $recordsFiltered = $sth1->rowCount();
        }
        $data['recordsFiltered'] = $recordsFiltered;


        $query = 'SELECT id, firstname, lastname, middlename, username, phone, email, status, activity_at FROM ??user ';

        $query .= ' WHERE usergroup = ' . $this->usergroup . ' ';
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
            $itemsDataRow[1] = $value['lastname'];
            $itemsDataRow[2] = $value['firstname'];
            $itemsDataRow[3] = $value['username'];
            $itemsDataRow[4] = $value['phone'];
            $itemsDataRow[5] = $value['email'];
            
            $itemsDataRow[6] =   '<div class="status-change">' . 
                                    '<input data-toggle="toggle" data-on="' . $this->t('toggle on', 'back') . '" data-off="' . $this->t('toggle off', 'back') . '" data-onstyle="warning" type="checkbox" name="status" data-controller="teacher" data-table="user" data-id="' . $value['id'] . '" class="status-toggle" ' . (($value['status']) ? 'checked' : '') . '>' .
                                    '</div>';
            $itemsDataRow[7] =   '<a class="btn btn-info entry-edit-btn" title="' . $this->t('btn edit', 'back') . '" href="' . $controls['view'] . '?id=' .  $value['id'] . '">' .
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
        
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : (!empty($_POST['teacher']['id']) ? (int)$_POST['teacher']['id'] : 0);
        
        $teacher = new Teacher();

        if($id){
            $teacher->find($id);
        }

        if($teacher->usergroup <= $_SESSION['usergroup']){
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
        
        if(isset($this->teacher)){
            $teacher = $this->teacher;
        }
        elseif(!empty($_POST['teacher'])){
            $teacher->setFields($_POST['teacher']);
            $teacher->group_id = $_POST['group_id'];
            $teacher->subject_id = $_POST['subject_id'];
        }
        //$teacher->icon = $this->linker->getIcon($this->media->resize($teacher->image, 150, 150, NULL, true));

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

        $subjects = [];
        $getSubjects = $this->qb->where('status', 1)->order('name')->get('??subject');
        if($getSubjects->rowCount()){
            $subjects = $getSubjects->fetchAll();
        }
        $data['subjects'] = $subjects;

        $data['teacher'] = $teacher;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }
    
    public function save()
    {
        
        $teacher = new Teacher();

        $isUniqueParams = [
            'table' => '??user',
            'column' => 'username'
        ];
        $isUniqueParamsEmail = [
            'table' => '??user',
            'column' => 'email'
        ];

        $_POST = $this->cleanForm($_POST);
        $info = $_POST['teacher'];
        $info['username'] = strtolower($info['username']);

        $new = true;
        $id = (int)$info['id'];

        if($id && $teacher->find($id)){
            $isUniqueParams['id'] = $id;
            $isUniqueParamsEmail['id'] = $id;
            $new = false;
        }

        if($teacher->usergroup <= $_SESSION['usergroup']){
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

            $teacher->setFields($info);
            
            if(!empty($info['password'])){
                $teacher->password = $this->hashPassword($info['password']);
            }



            $teacher->status = 1;

            if($new) {
                $teacher->created_at = time();
            }
            $teacher->updated_at = time();

            $teacher->save();

            if($teacher->savedSuccess){

                if($_FILES['image']['error'] == 0){
                    $imageUploaded = $this->media->upload($_FILES['image'], $this->control, $this->control . '-' . $teacher->id, true);
                    if($imageUploaded){
                    	if(!empty($teacher->image)){
                    		$this->media->delete($teacher->image);
                    	}
                        $teacher->image = $imageUploaded;
                        $teacher->save();
                    }
                }

                if( !empty($_POST['group_id']) && is_array($_POST['group_id']) ){
                	$this->qb->where('teacher_id', '?')->delete('??teacher_to_group', [$teacher->id]);
                	$teacher->group_id = [];
                    foreach ($_POST['group_id'] as $value) {
                        $group_id = (int)$value;
                        if($value > 0){
                            $teacher->group_id[] = $value;
                            $this->qb->insert('??teacher_to_group', ['teacher_id' => $teacher->id, 'group_id' => $value]);
                        }
                    }
                }

                if( !empty($_POST['subject_id']) && is_array($_POST['subject_id']) ){
                	$this->qb->where('teacher_id', '?')->delete('??subject_to_teacher', [$teacher->id]);
                	$teacher->subject_id = [];
                	foreach ($_POST['subject_id'] as $value) {
                		$subject_id = (int)$value;
                		if($value > 0){
                			$teacher->subject_id[] = $value;
                			$this->qb->insert('??subject_to_teacher', ['teacher_id' => $teacher->id, 'subject_id' => $value]);
                		}
                	}
                }

                $this->teacher = $teacher;
                $this->successText = $this->t('success edit ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error edit ' . $this->control, 'back');
                $this->errors['error db'] = $this->t('error db', 'back');
            }
            return $teacher->savedSuccess;
        }
    }

    public function toggle()
    {
        $id = $_GET['param1'];
        $status = (int)$_GET['param2'];

        $return = '';

        $teacher = new Teacher();
        if($id && $teacher->find($id)){

            if($teacher->usergroup <= $_SESSION['usergroup']){
                exit('Access Error');
            }
            $teacher->status = $status;
            $teacher->save();

            if($teacher->savedSuccess){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }
    
    public function delete()
    {
        $return = false;

        $id = (int)$_GET['id'];
        $teacher = new Teacher();

        if($id && $teacher->find($id)) {

            if($teacher->usergroup <= $_SESSION['usergroup']){
                exit('Access Error');
            }

            if($teacher->image){
                $this->media->delete($teacher->image);
            }

            $this->qb->where('teacher_id', '?')->delete('??teacher_to_group', [$teacher->id]);
            $this->qb->where('teacher_id', '?')->delete('??subject_to_teacher', [$teacher->id]);

            $teacher->remove();
            
            if($teacher->removedSuccess){
                $this->successText = $this->t('success delete ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error delete ' . $this->control, 'back');
                $this->errors['error db'];
            }

            $return = $teacher->removedSuccess;

            return $teacher->removedSuccess;
        }
        else{
            $this->errors['error invalid id'];
        }

        return $return;
    }

}
