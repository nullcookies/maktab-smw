<?php

namespace controllers\back;

use \system\Controller;
use \models\back\SubjectModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class SubjectController extends Controller
{
    
    public function index()
    {
        
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
        $model = new SubjectModel;

        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('subject-list');
    }

    public function list_ajax()
    {
        $model = new SubjectModel;

        $model->list_ajax();
        $this->data = $model->data;
            
        $this->json($this->data);
    }
    
    public function view()
    {    
        
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

        $model = new SubjectModel;

        $viewFile = 'subject-view';
        
        if(isset($_POST['btn_save'])){
            $result = $model->save();
        }
        $model->view();
    
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render($viewFile);
    }

    public function toggle()
    {
        $model = new SubjectModel;
        $this->content = $model->toggle();
    }

    public function delete()
    {
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
        
        $model = new SubjectModel;
        $id = (int)$_GET['id'];
        if($id){
            $resultDelete = $model->delete();
        }
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('subject-list');
    }

    public function saveSchedule()
    {
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
        
        $model = new SubjectModel;
        $model->saveSchedule();
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;

        $this->content = $this->render('subject-list');
    }

}
