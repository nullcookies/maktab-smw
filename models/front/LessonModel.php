<?php

namespace models\front;

use \system\Document;
use \system\Model;

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
        $controls['view'] = $this->linker->getUrl('lesson/view');
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


        
        $this->data = $data;

        return $this;
    }
    
    public function view(){
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


        if(isset($_POST['btn_save'])){
            $this->ppp($_POST);
        }

        $group_id = (isset($_GET['group_id'])) ? $_GET['group_id'] : '';
        $subject_id = (isset($_GET['subject_id'])) ? $_GET['subject_id'] : '';
        $start_time = (isset($_GET['start_time'])) ? $_GET['start_time'] : date('d-m-Y H:i');
        $students = [];

        $errors = [];

        if($group_id && $subject_id){
            $checkGroup = $this->qb->where([['teacher_id', '?'], ['group_id', '?']])->get('??teacher_to_group', [$_SESSION['user_id'], $group_id]);
            if($checkGroup && $checkGroup->rowCount() == 0){
                $errors['group_id'] = 'error not this teacher group';
            }

            $checkSubject = $this->qb->where([['teacher_id', '?'], ['subject_id', '?']])->get('??subject_to_teacher', [$_SESSION['user_id'], $subject_id]);
            if($checkSubject && $checkSubject->rowCount() == 0){
                $errors['subject_id'] = 'error not this teacher subject';
            }
            if(!$errors){
                $getStudents = $this->qb->select('u.id, u.firstname, u.lastname')->where('s2g.group_id', '?')->join('??student_to_group s2g', 's2g.student_id = u.id')->get('??user u', [$group_id]);
                $students = $getStudents->fetchAll();
            }
        }

        $data['group_id'] = $group_id;
        $data['subject_id'] = $subject_id;
        $data['start_time'] = $start_time;
        $data['students'] = $students;

        $data['errors'] = $errors;


        $this->data = $data;

        return $this;
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
}



