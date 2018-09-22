<?php

namespace models\front;

use \system\Document;
use \system\Model;
use \models\objects\User;
use \models\objects\Teacher;

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeModel extends Model {
    
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
        
        $getHome = $this->qb->where([['side', 'front'], ['controller', 'home']])->get('??page');
        if($getHome->rowCount() > 0){
            $home = $getHome->fetchAll();
            $home = $this->langDecode($home, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
            $home = $home[0];
        }
        if(isset($home)){
            $this->document->title = ($home['meta_t'][LANG_ID]) ? $home['meta_t'][LANG_ID] : $home['name'][LANG_ID];
            $this->document->description = $home['meta_d'][LANG_ID];
            $this->document->keywords = $home['meta_k'][LANG_ID];
        }
        $data['home'] = $home;

        $adminsMaxUsergroup = 4;

        $teachers = [];
        $subjects = [];
        $groups = [];

        $teacher = new Teacher();
        $user = new User();
        $teacherUserGroup = $teacher->usergroup;

        if(!empty($_SESSION['user_id']) && !empty($_SESSION['usergroup']) && ( $_SESSION['usergroup'] == $teacherUserGroup || $_SESSION['usergroup'] <= $adminsMaxUsergroup ) ) {
        	$found = $user->find($_SESSION['user_id']);
        	if($found) {
        		
                //get subjects
                $this->qb->select('s.name');
                if($_SESSION['usergroup'] == $teacherUserGroup) {
                    $this->qb->join('??subject_to_teacher s2t', 's.id = s2t.subject_id')->where('s2t.teacher_id', $user->id);
                }
                $getSubjects = $this->qb->get('??subject s');
        		if($getSubjects && $getSubjects->rowCount() > 0){
        			$subjects = $getSubjects->fetchAll();
        		}

                //get groups
                $this->qb->select('g.*');
                if($_SESSION['usergroup'] == $teacherUserGroup) {
                    $this->qb->join('??teacher_to_group t2g', 'g.id = t2g.group_id')->where('t2g.teacher_id', $user->id);
                }
                $getGroups = $this->qb->order([['g.start_year', true], ['g.name', false]])->get('??group g');
                if($getGroups && $getGroups->rowCount() > 0){
                    $lessonModel = new LessonModel();
                    $groups = $getGroups->fetchAll();
                    foreach ($groups as $key => $value) {
                        $groups[$key]['grade'] = $lessonModel->getGrade($value['start_year'], $value['end_year']);
                    }
                }

                //get teachers
                if($_SESSION['usergroup'] <= $adminsMaxUsergroup){
                    $getTeachers = $this->qb->select('id, firstname, lastname, username')->where('usergroup', $teacherUserGroup)->order([['lastname', false], ['firstname', false]])->get('??user');
                    if($getTeachers && $getTeachers->rowCount() > 0){
                        $teachers = $getTeachers->fetchAll();
                    }
                }
            		
        		
        	}
        }
        $data['user'] 	= $user;
        $data['teachers']   = $teachers;
        $data['subjects'] 	= $subjects;
        $data['groups'] 	= $groups;


        $data['themeURL'] = THEMEURL;
        $this->data = $data;

        return $this;
    }
}



