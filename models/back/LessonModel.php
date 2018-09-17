<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\objects\Lesson;
use \models\back\GroupModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class LessonModel extends Model 
{
    
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

        $groupModel = new GroupModel();
        $groups = [];
        $getGroups = $this->qb->get('??group');
        if($getGroups->rowCount() > 0){
            $groups = $getGroups->fetchAll();
            foreach ($groups as $key => $value) {
                $groups[$key]['grade'] = $groupModel->getGrade($value['start_year'], $value['end_year']) . ' - ' . $value['name'];
            }
        }
        $data['groups'] = $groups;

        $subjects = [];
        $getSubjects = $this->qb->get('??subject');
        if($getSubjects->rowCount() > 0){
            $subjects = $getSubjects->fetchAll();
        }
        $data['subjects'] = $subjects;

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

        $groupModel = new GroupModel();

        $_POST = $this->cleanForm($_POST);

        $data['draw'] = (int)$_POST['draw'];

        $totalRows = $this->qb->select('id')->count('??lesson');
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
                $order = 'l.id';
                break;
            
            case 1:
                $order = 'u.lastname';
                $order2 = 'u.firstname';
                break;
            
            case 2:
                $order = 'g.start_year';
                $order2 = 'g.name';
                break;
            
            case 3:
                $order = 's.name';
                break;
            
            case 4:
                $order = 'l.start_time';
                break;
            
            default:
                $order = 'l.start_time';
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
        	//todo: search by group name preg
        	$search_where = " ( ";
            $where_params = [];
            $search_where .= " s.name LIKE ? OR u.lastname LIKE ? OR u.firstname LIKE ? ";
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
	            if(preg_match('/\d{2}-\d{2}-\d{4}/', trim($searchText))){
	            	$dateTime = \DateTime::createFromFormat('d-m-Y H:i:s', trim($searchText . ' 00:00:00'));
	            	$dayStart = $dateTime->getTimestamp();
	            	$dayEnd = $dayStart + 86400;
	            	$search_where .= " OR (l.start_time >= ? AND l.start_time <= ? ) ";
	            	$where_params[] = $dayStart;
	            	$where_params[] = $dayEnd;
	            }
            }
	            
            

            $search_where .= " ) ";

            $querySearch = 'SELECT l.id FROM ??lesson l LEFT JOIN ??group g ON l.group_id = g.id LEFT JOIN ??subject s ON l.subject_id = s.id LEFT JOIN ??user u ON l.teacher_id = u.id WHERE ' . $search_where . ' GROUP BY l.id ';
            $sth1 = $this->qb->prepare($querySearch);
            $sth1->execute($where_params);
            $recordsFiltered = $sth1->rowCount();
        }
        $data['recordsFiltered'] = $recordsFiltered;


        $query = 'SELECT l.*, g.name g_name, g.start_year g_start_year, g.end_year g_end_year, s.name s_name, u.firstname u_firstname, u.lastname u_lastname FROM ??lesson l LEFT JOIN ??group g ON l.group_id = g.id LEFT JOIN ??subject s ON l.subject_id = s.id LEFT JOIN ??user u ON l.teacher_id = u.id ';

        if($searchText){
            $query .= ' WHERE ' . $search_where;
        }
        $query .= ' GROUP BY l.id ';
        $query .= ' ORDER BY ' . $order . ' ' . $orderDir . ' ' . (!empty($order2) && !empty($orderDir2) ? (', ' . $order2 . ' ' . $orderDir2) : '') . ' ';
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
            $itemsDataRow[1] = $value['u_lastname'] . ' ' . $value['u_firstname'];
            $itemsDataRow[2] = $groupModel->getGrade($value['g_start_year'], $value['g_end_year']) . ' - ' . $value['g_name'];
            $itemsDataRow[3] = $value['s_name'];
            $itemsDataRow[4] = date('d-m-Y H:i', $value['start_time']);
            $itemsDataRow[5] = '<a class="btn btn-info entry-edit-btn" title="' . $this->t('btn edit', 'back') . '" href="' . $controls['view'] . '?id=' .  $value['id'] . '">' .
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

    	$id = !empty($_GET['id']) ? (int)$_GET['id'] : (!empty($_POST['lesson']['id']) ? (int)$_POST['lesson']['id'] : 0);
        
        $lesson = new Lesson();

        if($id){
            $lesson->find($id);
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

        $groups = [];
        $getGroups = $this->qb->get('??group');
        if($getGroups->rowCount() > 0){
            $groups = $getGroups->fetchAll();
            foreach ($groups as $key => $value) {
                $groups[$key]['grade'] = $this->getGrade($value['start_year'], $value['end_year']) . ' - ' . $value['name'];
            }
        }
        $data['groups'] = $groups;

        $subjects = [];
        $getSubjects = $this->qb->get('??subject');
        if($getSubjects->rowCount() > 0){
            $subjects = $getSubjects->fetchAll();
        }
        $data['subjects'] = $subjects;
        
        if(isset($this->lesson)){
            $lesson = $this->lesson;
        }
        elseif(!empty($_POST['lesson'])){
            $lesson->setFields($_POST['lesson']);
        }
        $lessonStartTime = $lesson->start_time;
        if(empty($lessonStartTime)){
        	$lesson->start_time = date('d-m-Y H:i');
        }

        $students = [];
        if(!$this->errors){
            $getStudents = $this->qb->select('u.id, u.firstname, u.lastname')->where('s2g.group_id', '?')->join('??student_to_group s2g', 's2g.student_id = u.id')->get('??user u', [$lesson->group_id]);
            $students = $getStudents->fetchAll();
        }

        $data['lesson'] = $lesson;
        $data['students'] = $students;


        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function save()
    {
        
        $lesson = new Lesson();

        $_POST = $this->cleanForm($_POST);
        $info = $_POST['lesson'];

        $new = true;
        $id = (int)$info['id'];

        if($id && $lesson->find($id)){
            $new = false;
        }

        $checkData = [];
        $checkData['info'] = $info;

        $rules = [ 
            'info' => [

            ]
        ];

        $valid = $this->validator->validate($rules, $checkData);
        if(!$valid){
        	$this->errorText = $this->t('error save lesson', 'back');
            $this->errors = $this->validator->lastErrors;
            return false;
        }
        else{
            $lesson->setFields($info);

            if($new) {
                $lesson->created_at = time();
            }
            $lesson->updated_at = time();
            // $lesson->teacher_id = $_SESSION['user_id'];

            $dateTime = \DateTime::createFromFormat('d-m-Y H:i:s', $lesson->start_time . ':01');
        	if($dateTime != false){
        		$lesson->start_time = $dateTime->getTimestamp();
        	}

            $lesson->save();

            if($lesson->savedSuccess){
            	if(!$new) {
	                $this->qb->where('lesson_id', '?')->delete('??student_attendance', [$lesson->id]);
	                $this->qb->where('lesson_id', '?')->delete('??student_mark', [$lesson->id]);
	            }
                if(!empty($_POST['lesson']['students']) && is_array($_POST['lesson']['students']) ){
                    foreach ($_POST['lesson']['students'] as $key => $value) {
	            		$checkStudentToGroup = $this->qb->where([['group_id', '?'], ['student_id', '?']])->get('??student_to_group', [$lesson->group_id, $key]);
	            		$studentAttended = (!empty($value['attendance']) && $value['attendance'] == 'on') ? 1 : 0;
	            		$studentMark = (!empty($value['mark'])) ? (int)$value['mark'] : 0;

	            		if($checkStudentToGroup && $checkStudentToGroup->rowCount() > 0){
	            			$lesson->students[$key]['attendance'] = $studentAttended;
	            			$lesson->students[$key]['mark'] = $studentMark;
	            			$this->qb->insert('??student_attendance', ['lesson_id' => $lesson->id, 'student_id' => $key, 'attended' => $studentAttended]);
	            			$this->qb->insert('??student_mark', ['lesson_id' => $lesson->id, 'student_id' => $key, 'mark' => $studentMark]);
	            		}
                    }
                }

                $this->lesson = $lesson;
                $this->successText = $this->t('success save lesson', 'back');
            }
            else{
                $this->errorText = $this->t('error save lesson', 'back');
                $this->errors['error db'] = $this->t('error db', 'back');
            }
            return $lesson->savedSuccess;
        }
    }
    
    public function delete()
    {
        $return = false;

        $id = (int)$_GET['id'];
        $lesson = new Lesson();

        if($id && $lesson->find($id)) {

            // if($lesson->teacher_id != $_SESSION['user_id']){
            //     exit('Access Error');
            // }

            $this->qb->where('lesson_id', '?')->delete('??student_attendance', [$lesson->id]);
            $this->qb->where('lesson_id', '?')->delete('??student_mark', [$lesson->id]);

            $lesson->remove();
            
            if($lesson->removedSuccess){
                $this->successText = $this->t('success delete lesson', 'back');
            }
            else{
                $this->errorText = $this->t('error delete lesson', 'back');
                $this->errors['error db'];
            }

            $return = $lesson->removedSuccess;
        }
        else{
            $this->errors['error invalid id'];
        }

        return $return;
    }
}



