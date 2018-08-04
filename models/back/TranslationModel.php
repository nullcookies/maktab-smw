<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class TranslationModel extends Model {

    public function index() {
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control . ' page');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');

        $controls = [];

        $controls['main'] = $this->linker->getUrl($this->control . '/index', true);
        $controls['save'] = $this->linker->getUrl($this->control . '/save', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $data['controls'] = $controls;

        $languages = $this->qb->where('status', '1')->get('??lang');
        $data['languages'] = $languages;

        $langId = ($_GET['param1']) ? (int)$_GET['param1'] : LANG_ID;
        $data['langId'] = $langId;

        $words = [];
        $getWords = $this->qb->where([['lang', '?'], ['side', 'front']])->order('name')->get('??translation', [$langId]);
        if($getWords->rowCount() > 0){
            $words = $getWords->fetchAll();
        }

        $data['words'] = $words;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }
    
    public function save(){

        $rules = [ 
            'post' => [
                'content' => ['isRequired'],
            ]
        ];
        $id = (int)$_GET['param1'];

        $_POST = $this->cleanForm($_POST);

        $data['post'] = $_POST;
        $data['errors'] = [];

        $valid = $this->validator->validate($rules, $data);

        if(!$valid){
            $data['errors'] = $this->validator->lastErrors;
        }
        else{

            $update = [];

            $update['content'] = $_POST['content'];

            $updateResult = $this->qb->where('id', '?')->update('??translation', $update, [$id]);
            if(!$updateResult){
                $data['result'] = false;
            }
            else{
                $data['result'] = true;
            }
            
        }

        return $data;
    }
    
    public function delete(){

        $id = (int)$_GET['param2'];
        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }

        $resultDelete = $this->qb->where('id', '?')->delete('??translation', [$id]);
        
        if(!$resultDelete){
            $this->errorText = $this->getTranslation('error delete ' . $this->control);
            $this->errors['error db'];
            return false;
        }
        else{
            $this->successText = $this->getTranslation('success delete ' . $this->control);
            return true;
        }
    }
    
}

