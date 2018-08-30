<?php

namespace models\front;

use \system\Document;
use \system\Model;
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

        $subjects = [];
        $groups = [];

        $teacher = new Teacher();
        if(!empty($_SESSION['user_id']) && !empty($_SESSION['usergroup']) && $_SESSION['usergroup'] == $teacher->usergroup){
        	$found = $teacher->find($_SESSION['user_id']);
        	if($found){
        		$getSubjects = $this->qb->select('s.name')->join('??subject_to_teacher s2t', 's.id = s2t.subject_id')->where('s2t.teacher_id', $teacher->id)->get('??subject s');
        		if($getSubjects && $getSubjects->rowCount() > 0){
        			$subjects = $getSubjects->fetchAll();
        		}
        		$getGroups = $this->qb->select('g.*')->join('??teacher_to_group t2g', 'g.id = t2g.group_id')->where('t2g.teacher_id', $teacher->id)->get('??group g');
        		if($getGroups && $getGroups->rowCount() > 0){
        			$lessonModel = new LessonModel();
        			$groups = $getGroups->fetchAll();
        			foreach ($groups as $key => $value) {
        				$groups[$key]['grade'] = $lessonModel->getGrade($value['start_year'], $value['end_year']);
        			}
        		}
        		
        	}
        }
        $data['teacher'] 	= $teacher;
        $data['subjects'] 	= $subjects;
        $data['groups'] 	= $groups;


        $data['themeURL'] = THEMEURL;
        $this->data = $data;

        return $this;
    }
}



