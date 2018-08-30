<?php

namespace controllers\back;

use \system\Controller;
use \models\back\UserModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class UserController extends Controller {
    
    public function index() {
    	
    	$this->modules = [
    		[
                'side' => 'back',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'back',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'back',
                'controller' => 'sidebar',
                'action' => 'index',
                'position' => 'sidebar'
            ]
    	];
        $model = new UserModel;

        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('user-list');
    }

    public function list_ajax() {
        $model = new UserModel;

        $model->list_ajax();
        $this->data = $model->data;
            
        $this->json($this->data);
    }

    public function view() {    
        
        $this->modules = [
            [
                'side' => 'back',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'back',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'back',
                'controller' => 'sidebar',
                'action' => 'index',
                'position' => 'sidebar'
            ]
        ];

        $model = new UserModel;

        $viewFile = 'user-view';
        
        if(isset($_POST['btn_save'])){
            $result = $model->save();
        }
        $model->view();
    
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render($viewFile);
        
    }

    public function toggle() {
        $model = new UserModel;
        $this->content = $model->toggle();
    }

    public function delete() {
        $this->modules = [
            [
                'side' => 'back',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'back',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'back',
                'controller' => 'sidebar',
                'action' => 'index',
                'position' => 'sidebar'
            ]
        ];
        
        $model = new UserModel;
        if(!empty($_GET['id'])){
            $resultDelete = $model->delete();
        }
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('user-list');
    }

    public function login() {
        $loggedIn = false;
        if(isset($_SESSION['usergroup']) && isset($_SESSION['user_id'])){
            $loggedIn = true;
        }
        if($loggedIn){
            $this->index();
        }
        else{
            $model = new UserModel;
            $model->login();
            $this->data = $model->data;
            $this->document = $model->document;

            $this->content = $this->render('login');
        }
            
    }

    public function logout() {
        $model = new UserModel;
        $model->logout();
    }

}
