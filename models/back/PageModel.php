<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class PageModel extends Model {

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

        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $data['controls'] = $controls;

        $pages = [];
        $getPages = $this->qb->order('id')->get('??page');
        if($getPages->rowCount() > 0){
            $pages = $getPages->fetchAll();
            $pages = $this->langDecode($pages, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }

        $data['pages'] = $pages;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function add(){
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('add ' . $this->control),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation('add ' . $this->control);

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
        $controls['action'] = $this->linker->getUrl($this->control . '/add', true);

        $data['controls'] = $controls;

        $data[$this->control] = [];
        if($_POST){
            $data[$this->control] = $_POST;
        }

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }
    
    public function edit() {
        
        $id = (int)$_GET['param1'];
        if(!$id){
            $id = (int)$_POST['id'];
        }
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->control . ' page'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('edit ' . $this->control),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->control);

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
        $controls['action'] = $this->linker->getUrl($this->control . '/edit/' . $id, true);

        $data['controls'] = $controls;

        $current = [];
        if($id){
            $getPage = $this->qb->where('id', '?')->get('??page', [$id]);
            if($getPage->rowCount() > 0){
                $page = $getPage->fetchAll();
                $page = $this->langDecode($page, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                $current = $page[0];
                $getAlias = $this->qb->select('id')->where('route', '?')->get('??url', [$current['controller'] . '/' . $current['method'] . '/' . $current['id']]);
                if($getAlias->rowCount() > 0){
                    $aliasId = $getAlias->fetch()['id'];
                }
                else{
                    $aliasId = 0;
                }
                $current['alias_id'] = $aliasId;
            }
        }
        if($_POST){
            $current = $_POST;
        }

        $data[$this->control] = $current;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }
    
    public function save($new = false){
        
        $isUniqueParams = [
            'table' => '??url',
            'column' => 'alias'
        ];

        if(!$new) {
            $id = (int)$_POST['id'];
            $alias_id = (int)$_POST['alias_id'];
            $isUniqueParams['id'] = $alias_id;
        }

        $rules = [ 
            'post' => [
                'name' => ['isRequired'],
                'side' => ['isRequired'],
                'layout' => ['isRequired'],
                'controller' => ['isRequired'],
            ],
            'files' => [
                
            ]
        ];
        if($_POST['controller'] != 'home'){
            $rules['post']['alias'] = ['isRequired', 'isAlias', ['isUnique', $isUniqueParams]];
        }

        $_POST = $this->cleanForm($_POST);
        $_POST['alias'] = strtolower($_POST['alias']);
        $_POST['controller'] = strtolower($_POST['controller']);

        $data['post'] = $_POST;

        $valid = $this->validator->validate($rules, $data);

        if(!$valid){

            if(!$new){
                $this->errorText = $this->getTranslation('error edit ' . $this->control);
            }
            else{
                $this->errorText = $this->getTranslation('error add ' . $this->control);
            }
            $this->errors = $this->validator->lastErrors;
            return false;

        }
        else{

            if(!$new) {

                $update = [];
                $update['controller'] = $_POST['controller'];
                $update['method'] = $_POST['method'];
                $update['side'] = $_POST['side'];
                $update['layout'] = $_POST['layout'];
                $update['alias'] = $_POST['alias'];
                $update['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $update['text_name'] = json_encode($_POST['text_name'], JSON_UNESCAPED_UNICODE);
                $update['nav_name'] = json_encode($_POST['nav_name'], JSON_UNESCAPED_UNICODE);
                $update['descr'] = json_encode($_POST['descr'], JSON_UNESCAPED_UNICODE);
                $update['descr_full'] = json_encode($_POST['descr_full'], JSON_UNESCAPED_UNICODE);
                $update['meta_t'] = json_encode($_POST['meta_t'], JSON_UNESCAPED_UNICODE);
                $update['meta_d'] = json_encode($_POST['meta_d'], JSON_UNESCAPED_UNICODE);
                $update['meta_k'] = json_encode($_POST['meta_k'], JSON_UNESCAPED_UNICODE);
                $update["status"] = ($_POST["status"]) ? 1 : 0;

                $updateResult = $this->qb->where('id', '?')->update('??page', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control);
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{
                    $urlInsertUpdate = [
                        'alias' => htmlspecialchars($_POST['alias']),
                        'route' => $update['controller'] . '/' . $update['method'] . '/' . $id
                    ];
                    $this->qb->insertUpdate('??url', $urlInsertUpdate);
                    
                    $this->successText = $this->getTranslation('success edit ' . $this->control);
                    return true;
                }
                
            }
            else{
                $insert = [];
                
                $insert['controller'] = $_POST['controller'];
                $insert['method'] = $_POST['method'];
                $insert['side'] = $_POST['side'];
                $insert['layout'] = $_POST['layout'];
                $insert['alias'] = $_POST['alias'];
                $insert['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
                $insert['text_name'] = json_encode($_POST['text_name'], JSON_UNESCAPED_UNICODE);
                $insert['nav_name'] = json_encode($_POST['nav_name'], JSON_UNESCAPED_UNICODE);
                $insert['descr'] = json_encode($_POST['descr'], JSON_UNESCAPED_UNICODE);
                $insert['descr_full'] = json_encode($_POST['descr_full'], JSON_UNESCAPED_UNICODE);
                $insert['meta_t'] = json_encode($_POST['meta_t'], JSON_UNESCAPED_UNICODE);
                $insert['meta_d'] = json_encode($_POST['meta_d'], JSON_UNESCAPED_UNICODE);
                $insert['meta_k'] = json_encode($_POST['meta_k'], JSON_UNESCAPED_UNICODE);
                $insert["status"] = ($_POST["status"]) ? 1 : 0;

                $insertResult = $this->qb->insert('??page', $insert);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $id = $this->qb->lastInsertId();
                    $urlInsert = [
                        'alias' => htmlspecialchars($_POST['alias']),
                        'route' => $insert['controller'] . '/' . $insert['method'] . '/' . $id
                    ];

                    $this->qb->insert('??url', $urlInsert);

                    $this->successText = $this->getTranslation('success add ' . $this->control);
                    return true;
                }
            }
        }
    }

    public function toggle() {
        $id = $_GET['param1'];
        $status = (int)$_GET['param2'];
        $return = '';
        if($id){
            $result = $this->qb->where('id', '?')->update('??page', ['status' => $status], [$id]);
            if($result){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }
    
    public function delete(){

        $id = (int)$_GET['param1'];
        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }
        $getPage = $this->qb->where('id', '?')->get('??page', [$id]);
        if($getPage->rowCount() > 0){
            $page = $getPage->fetch();
        }
        $route = $page['controller'] . '/' . $page['method'] . '/' . $page['id'];
        $this->qb->where('route', '?')->delete('??url', [$route]);
        $resultDelete = $this->qb->where('id', '?')->delete('??page', [$id]);
        
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

