<?php

namespace models\front;

use \system\Document;
use \system\Model;
use \models\objects\Lesson;

defined('BASEPATH') OR exit('No direct script access allowed');

class LessonModel extends Model {
    
    public function index(){
        $data = [];
        $this->document = new Document();

        $mediumIconW = (int)$this->getOption('icon_medium_w');
        $mediumIconH = (int)$this->getOption('icon_medium_h');

        $postIconW = (int)$this->getOption('icon_post_w');
        $postIconH = (int)$this->getOption('icon_post_h');
        if(!$postIconW){
            $postIconW = $mediumIconW;
        }
        if(!$postIconH){
            $postIconH = $mediumIconH;
        }

        $controls = [];
        $controls['list_ajax'] = $this->linker->getUrl('lesson/list_ajax');
        $controls['view'] = $this->linker->getUrl('lesson/view');
        $controls['delete'] = $this->linker->getUrl('lesson/delete');
        $data['controls'] = $controls;

        $groups = [];
        $getGroups = $this->qb->select('g.*')->where('t2g.teacher_id', '?')->join('??teacher_to_group t2g', 't2g.group_id = g.id')->get('??group g', [$_SESSION['user_id']]);
        if($getGroups->rowCount() > 0){
            $groups = $getGroups->fetchAll();
            foreach ($groups as $key => $value) {
                $groups[$key]['grade'] = $this->getGrade($value['start_year'], $value['end_year']) . ' - ' . $value['name'];
            }
        }
        $data['groups'] = $groups;

        $subjects = [];
        $getSubjects = $this->qb->select('s.*')->where('s2t.teacher_id', '?')->join('??subject_to_teacher s2t', 's2t.subject_id = s.id')->get('??subject s', [$_SESSION['user_id']]);
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

    public function list_ajax() {
        
        $data = [];

        $controls = [];
        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax');
        $controls['view'] = $this->linker->getUrl($this->control . '/view');
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete');
        $data['controls'] = $controls;

        $_POST = $this->cleanForm($_POST);

        $data['draw'] = (int)$_POST['draw'];

        $totalRows = $this->qb->select('id')->where('teacher_id', $_SESSION['user_id'])->count('??lesson');
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
                $order = 'l.group_id';
                break;
            
            case 2:
                $order = 'l.subject_id';
                break;
            
            case 3:
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


        $recordsFiltered = $totalRows;

        $search_where = '';
        $where_params = null;

        $search = $_POST['search']['value'];
        $searchText = substr($search, 0, 65536);


        if($searchText){
        	//todo: search by group name preg
        	$search_where = " ( ";
            $where_params = [];
            $search_where .= " s.name LIKE ? ";
            $where_params[] = '%' . $searchText . '%';
            
            $matches = [];
            $checkRegex = preg_match('/^(\d{1,2})\s?-?\s?(.)$/u', trim($searchText), $matches);

            if(isset($matches[1]) && isset($matches[2])){
            	$searchStartYear = $this->getStartYear($matches[1]);
            	$search_where .= " OR (g.start_year = ? AND g.name = ?)";
	        	$where_params[] = $searchStartYear;
	        	$where_params[] = $matches[2];
            }
            else{
            	if( mb_strlen($searchText) == 1 ){
	            	$search_where .= " OR g.name LIKE ? ";
	        		$where_params[] = '%' . $searchText . '%';
	            }
	            if( is_numeric($searchText) && $searchText >=1 && $searchText <=11 ){
	            	$searchStartYear = $this->getStartYear($searchText);
	            	$search_where .= " OR g.start_year LIKE ? ";
	            	$where_params[] = '%' . $searchStartYear . '%';
	            }
	            if(preg_match('/\d{2}-\d{2}-\d{4}/', trim($searchText))){
	            	file_put_contents('ppp2.txt', $searchText);
	            	$dateTime = \DateTime::createFromFormat('d-m-Y H:i:s', trim($searchText . ' 00:00:00'));
	            	$dayStart = $dateTime->getTimestamp();
	            	$dayEnd = $dayStart + 86400;
	            	$search_where .= " OR (l.start_time >= ? AND l.start_time <= ? )";
	            	$where_params[] = $dayStart;
	            	$where_params[] = $dayEnd;
	            }
            }
	            
            

            $search_where .= " ) ";

            $querySearch = 'SELECT l.id FROM ??lesson l LEFT JOIN ??group g on l.group_id = g.id LEFT JOIN ??subject s on l.subject_id = s.id WHERE ' . $search_where . ' AND l.teacher_id = ' . $_SESSION['user_id'] . ' GROUP BY l.id ';
            $sth1 = $this->qb->prepare($querySearch);
            $sth1->execute($where_params);
            $recordsFiltered = $sth1->rowCount();
        }
        $data['recordsFiltered'] = $recordsFiltered;


        $query = 'SELECT l.*, g.name g_name, g.start_year g_start_year, g.end_year g_end_year, s.name s_name FROM ??lesson l LEFT JOIN ??group g on l.group_id = g.id LEFT JOIN ??subject s on l.subject_id = s.id  ';

        $query .= ' WHERE l.teacher_id = ' . $_SESSION['user_id'] . ' ';
        if($searchText){
            $query .= ' AND ' . $search_where;
        }
        $query .= ' GROUP BY l.id ';
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
            $itemsDataRow[1] = $this->getGrade($value['g_start_year'], $value['g_end_year']) . ' - ' . $value['g_name'];
            $itemsDataRow[2] = $value['s_name'];
            $itemsDataRow[3] = date('d-m-Y H:i', $value['start_time']);
            $itemsDataRow[4] = '<a class="btn btn-info entry-edit-btn" title="' . $this->t('edit', 'front') . '" href="' . $controls['view'] . '?id=' .  $value['id'] . '">' .
                                        '<i class="fa fa-edit"></i>' .
                                    '</a> ' . 
                                    '<a class="btn btn-danger entry-delete-btn" href="' . $controls['delete'] . '?id=' . $value['id'] . '" title="' . $this->t('delete', 'front') . '" data-confirm-text="' . $this->t('are you sure?', 'front') . '" >' . 
                                        '<i class="fa fa-trash-o"></i>' . 
                                    '</a>';
            $itemsData[] = $itemsDataRow;
        }



        $data['data'] = $itemsData;

        $this->data = $data;

        return $this;
    }
    
    public function view(){

    	$id = !empty($_GET['id']) ? (int)$_GET['id'] : (!empty($_POST['lesson']['id']) ? (int)$_POST['lesson']['id'] : 0);
        
        $lesson = new Lesson();
        if($id){
            $lesson->find($id);
        }


        $data = [];
        $this->document = new Document();

        $mediumIconW = (int)$this->getOption('icon_medium_w');
        $mediumIconH = (int)$this->getOption('icon_medium_h');

        $postIconW = (int)$this->getOption('icon_post_w');
        $postIconH = (int)$this->getOption('icon_post_h');
        if(!$postIconW){
            $postIconW = $mediumIconW;
        }
        if(!$postIconH){
            $postIconH = $mediumIconH;
        }

        $groups = [];
        $getGroups = $this->qb->select('g.*')->where('t2g.teacher_id', '?')->join('??teacher_to_group t2g', 't2g.group_id = g.id')->get('??group g', [$_SESSION['user_id']]);
        if($getGroups->rowCount() > 0){
            $groups = $getGroups->fetchAll();
            foreach ($groups as $key => $value) {
                $groups[$key]['grade'] = $this->getGrade($value['start_year'], $value['end_year']) . ' - ' . $value['name'];
            }
        }
        $data['groups'] = $groups;

        $subjects = [];
        $getSubjects = $this->qb->select('s.*')->where('s2t.teacher_id', '?')->join('??subject_to_teacher s2t', 's2t.subject_id = s.id')->get('??subject s', [$_SESSION['user_id']]);
        if($getSubjects->rowCount() > 0){
            $subjects = $getSubjects->fetchAll();
        }
        $data['subjects'] = $subjects;

        $controls = [];
        $controls['back'] = $this->linker->getUrl('lesson');
        $controls['view'] = $this->linker->getUrl('lesson/view');
        $data['controls'] = $controls;
        
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

        if($lesson->group_id){
            $checkGroup = $this->qb->where([['teacher_id', '?'], ['group_id', '?']])->get('??teacher_to_group', [$_SESSION['user_id'], $lesson->group_id]);
            if($checkGroup && $checkGroup->rowCount() == 0){
                $this->errors['group_id'] = 'error not this teacher group';
            }
        }
        if($lesson->subject_id){
            $checkSubject = $this->qb->where([['teacher_id', '?'], ['subject_id', '?']])->get('??subject_to_teacher', [$_SESSION['user_id'], $lesson->subject_id]);
            if($checkSubject && $checkSubject->rowCount() == 0){
                $this->errors['subject_id'] = 'error not this teacher subject';
            }
        }
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

        $groupBelongs = [
        	'table' => '??teacher_to_group',
        	'columns' => [
	        	'teacher_id' => $_SESSION['user_id'],
	        	'group_id' => $info['group_id'],
	        ]
        ];
        $subjectBelongs = [
        	'table' => '??subject_to_teacher',
        	'columns' => [
	        	'teacher_id' => $_SESSION['user_id'],
	        	'subject_id' => $info['subject_id'],
	        ]
        ];

        $rules = [ 
            'info' => [
                'group_id' => [['belongsTo', $groupBelongs], 'isRequired'],
                'subject_id' => [['belongsTo', $subjectBelongs], 'isRequired'],
            ]
        ];

        $valid = $this->validator->validate($rules, $checkData);
        if(!$valid){
        	$this->errorText = $this->t('error save lesson', 'front');
            $this->errors = $this->validator->lastErrors;
            return false;
        }
        else{
            $lesson->setFields($info);

            if($new) {
                $lesson->created_at = time();
            }
            $lesson->updated_at = time();
            $lesson->teacher_id = $_SESSION['user_id'];

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
                $this->successText = $this->t('success save lesson', 'front');
            }
            else{
                $this->errorText = $this->t('error save lesson', 'front');
                $this->errors['error db'] = $this->t('error db', 'front');
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

            if($lesson->teacher_id != $_SESSION['user_id']){
                exit('Access Error');
            }

            $this->qb->where('lesson_id', '?')->delete('??student_attendance', [$lesson->id]);
            $this->qb->where('lesson_id', '?')->delete('??student_mark', [$lesson->id]);

            $lesson->remove();
            
            if($lesson->removedSuccess){
                $this->successText = $this->t('success delete lesson', 'front');
            }
            else{
                $this->errorText = $this->t('error delete lesson', 'front');
                $this->errors['error db'];
            }

            $return = $lesson->removedSuccess;
        }
        else{
            $this->errors['error invalid id'];
        }

        return $return;
    }

    public function getGrade($start_year, $end_year)
    {
        $studyStartMonth = $this->getOption('study_start_month');
        $currentYear = date('Y');
        $currentMonth = date('n');
        //для определения номера класса
        $addition = ($currentMonth < $studyStartMonth) ? 0 : 1;

        $grade = $currentYear - $start_year + $addition;
        return ($grade <= 11) ? $grade : $this->t('study finished', 'front') . ' ' . $end_year;
    }

    public function getStartYear($grade)
    {
        $studyStartMonth = $this->getOption('study_start_month');
        $currentYear = date('Y');
        $currentMonth = date('n');
        //для определения номера класса
        $addition = ($currentMonth < $studyStartMonth) ? 0 : 1;

        $start_year = $currentYear - $grade + $addition;
        return $start_year;
    }
}



