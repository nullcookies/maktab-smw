<?php

namespace controllers\front;

use \system\Controller;
use \models\front\UserModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Controller {
    
    public function index() {}

    public function register() {
        /*$this->modules = [
            [
                'side' => 'front',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'front',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ]
        ];*/
        $model = new UserModel;
        $model->register();
        echo json_encode($model->data);
        exit;
        //$this->data = $model->data;
        //$this->document = $model->document;
        //$this->content = $this->render('user-login');
    }
    public function login() {
        /*$this->modules = [
            [
                'side' => 'front',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'front',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ]
        ];*/
        $model = new UserModel;
        $model->login();
        $this->json($model->data);
        
        //$this->data = $model->data;
        //$this->document = $model->document;
        //$this->content = $this->render('user-login');
    }

    public function forgetPassword() {
        $model = new UserModel;
        $model->forgetPassword();
        $this->json($model->data);
    }

    public function logout() {
        $model = new UserModel;
        if($model){
            $model->logout();
        }
    }

    public function account() {
        $this->modules = [
            [
                'side' => 'front',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'front',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'index',
                'position' => 'bottom'
            ],
            [
                'side' => 'front',
                'controller' => 'banner',
                'action' => 'bottom',
                'position' => 'bottom'
            ],
        ];
        $model = new UserModel;
        if($model){
            $model->account();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render('user-account');
    }

    public function restore() {
        $this->modules = [
            [
                'side' => 'front',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'front',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'index',
                'position' => 'bottom'
            ],
            [
                'side' => 'front',
                'controller' => 'banner',
                'action' => 'bottom',
                'position' => 'bottom'
            ],
        ];
        $model = new UserModel;
        if($model){
            $model->restore();
            $this->data = $model->data;
            $this->document = $model->document;
        }
        if(isset($this->data['ajax']) && $this->data['ajax'] == true){
            $this->json($this->data['ajaxData']);
        }
        else{
            $this->content = $this->render('user-restore-password');
        }
    }

    public function orders() {
        $this->modules = [
            [
                'side' => 'front',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'front',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'index',
                'position' => 'bottom'
            ],
            [
                'side' => 'front',
                'controller' => 'banner',
                'action' => 'bottom',
                'position' => 'bottom'
            ],
        ];
        $model = new UserModel;

        $viewFile = 'user-orders';
        if($model){
            if(isset($_GET['param1'])){
                $viewFile = 'user-order-view';
                $model->orderView();
            }
            else{
                $model->orders();
            }
            
            $this->data = $model->data;
            $this->document = $model->document;
        }
        $this->content = $this->render($viewFile);
    }

    public function activate() {
        
        $this->modules = [
            [
                'side' => 'front',
                'controller' => 'header',
                'action' => 'index',
                'position' => 'header'
            ],
            [
                'side' => 'front',
                'controller' => 'footer',
                'action' => 'index',
                'position' => 'footer'
            ],
            [
                'side' => 'front',
                'controller' => 'newProducts',
                'action' => 'index',
                'position' => 'bottom'
            ],
            [
                'side' => 'front',
                'controller' => 'banner',
                'action' => 'bottom',
                'position' => 'bottom'
            ],
        ];

        $model = new UserModel;

        $viewFile = 'user-activate';
        $model->activate();
        $this->data = $model->data;
        $this->document = $model->document;
        $this->content = $this->render($viewFile);
    }

}
