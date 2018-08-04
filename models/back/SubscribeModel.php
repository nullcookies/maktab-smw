<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class SubscribeModel extends Model {

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

        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $data['controls'] = $controls;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
    }

    public function list_ajax() {
        
        $data = [];

        $controls = [];

        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['add'] = $this->linker->getUrl($this->control . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->control . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);

        $_POST = $this->cleanForm($_POST);

        $data['draw'] = (int)$_POST['draw'];

        $total = $this->qb->select('id')->count('??subscribe');
        $data['recordsTotal'] = $total;

        $limit = (int)$_POST['length'];
        if($limit < 1){
            $limit = 10;
        }
        $offset = (int)$_POST['start'];

        $getOrder = (int)$_POST['order'][0]['column'];
        $orderDir = ($_POST['order'][0]['dir'] == 'asc') ? 'ASC' : 'DESC';
        switch ($getOrder) {
            case 0:
                $order = 'id';
                break;
            
            case 1:
                $order = 'name';
                break;
            
            case 2:
                $order = 'email';
                break;
            
            case 3:
                $order = 'phone';
                break;
            
            case 4:
                $order = 'status';
                break;

            case 5:
                $order = 'id';
                break;
            
            default:
                $order = 'id';
                break;
        }

        $recordsFiltered = $total;


        $where_params = null;
        $search_where = '';

        $search = $_POST['search']['value'];
        $searchText = substr($search, 0, 65536);

        if($searchText){
            $where_params = [];
            $search_where = " (name LIKE ? OR email LIKE ? OR phone LIKE ?) ";
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $where_params[] = '%' . $searchText . '%';
            $querySearch = 'SELECT id FROM ??subscribe WHERE ' . $search_where . ' GROUP BY id';
            $sth1 = $this->qb->prepare($querySearch);
            $sth1->execute($where_params);
            $recordsFiltered = $sth1->rowCount();
        }
        $data['recordsFiltered'] = $recordsFiltered;


        $query = 'SELECT * FROM ??subscribe ';
        if($search_where){
            $query .= ' WHERE ' . $search_where . ' ';
        }
        $query .= ' ORDER BY ' . $order . ' ' . $orderDir . ' ';
        $query .= ' LIMIT ' . $offset . ', ' . $limit . ' ';

        $getSubscribes = $this->qb->prepare($query);
        $getSubscribes->execute($where_params);

        $subscribes = [];
        if($getSubscribes->rowCount() > 0){
            $subscribes = $getSubscribes->fetchAll();
        }

        $subscribesData = [];

        foreach($subscribes as $value){
            $subscribesDataRow = [];

            $subscribesDataRow[0] = $value['id'];
            $subscribesDataRow[1] = $value['name'];
            $subscribesDataRow[2] = $value['email'];
            $subscribesDataRow[3] = $value['phone'];
            $subscribesDataRow[4] =   '<div class="status-change">' . 
                                    '<input data-toggle="toggle" data-on="' . $this->getTranslation('toggle on') . '" data-off="' . $this->getTranslation('toggle off') . '" data-onstyle="warning" type="checkbox" name="status" data-controller="subscribe" data-table="subscribe" data-id="' . $value['id'] . '" class="status-toggle" ' . (($value['status']) ? 'checked' : '') . '>' .
                                    '</div>';
            $subscribesDataRow[5] =   '<a class="btn btn-info" title="' . $this->getTranslation('btn edit') . '" href="' . $controls['edit'] . $value['id'] . '">' .
                                        '<i class="fa fa-edit"></i>' .
                                    '</a> ' . 
                                    '<a class="btn btn-danger" href="' . $controls['delete'] . $value['id'] . '" data-toggle="confirmation" data-btn-ok-label="' . $this->getTranslation('confirm yes') . '" data-btn-ok-icon="fa fa-check" data-btn-ok-class="btn-success btn-xs" data-btn-cancel-label=" ' . $this->getTranslation('confirm no') . '" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-danger btn-xs" data-title="' . $this->getTranslation('are you sure') . '" >' . 
                                        '<i title="' . $this->getTranslation('btn delete') . '" class="fa fa-trash-o"></i>' . 
                                    '</a>';
            $subscribesData[] = $subscribesDataRow;
        }

        $data['data'] = $subscribesData;

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
            $getSubscribe = $this->qb->where('id', '?')->get('??subscribe', [$id]);
            if($getSubscribe->rowCount() > 0){
                $current = $getSubscribe->fetch();
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

        if(!$new) {
            $id = (int)$_POST['id'];
        }

        $rules = [ 
            'post' => [
                'email' => ['isRequired', 'isEmail']
            ]
        ];

        $_POST = $this->cleanForm($_POST);

        $data['post'] = $_POST;

        $valid = $this->validator->validate($rules, $data);

        if(!$valid){

            if(!$new){
                $this->errorText = $this->getTranslation('error edit ' . $this->control . ' file');
            }
            $this->errorText = 'unknown error';
            $this->errors = $this->validator->lastErrors;
            return false;
        }
        else{

            $update = [];
            $update['name'] = $_POST['name'];
            $update['email'] = $_POST['email'];
            $update['phone'] = $_POST['phone'];
            $update['date_modify'] = time();
            $update["status"] = ($_POST["status"]) ? 1 : 0;
            $update['token'] = md5(mt_rand());
            $update["type"] = 1;

            if(!$new) {
                $updateResult = $this->qb->where('id', '?')->update('??subscribe', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control);
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{
                    $this->successText = $this->getTranslation('success edit ' . $this->control);
                    return true;
                }
                
            }
            else{
                $update['date_add'] = time();
                $insertResult = $this->qb->insert('??subscribe', $update);
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->control);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $this->successText = $this->getTranslation('success add ' . $this->control);
                    return true;
                }
                echo $this->errorText;
                echo $this->successText;
            }
        }
    }

    public function toggle() {
        $id = $_GET['param1'];
        $status = (int)$_GET['param2'];
        $return = '';
        if($id){
            $result = $this->qb->where('id', '?')->update('??subscribe', ['status' => $status], [$id]);
            if($result){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }
    
    public function delete($force_id = NULL){

        $id = (int)$_GET['param1'];
        
        if($force_id){
            $id = $force_id;
        }

        if(!$id) {
            $this->errors['error empty id'];
            return false;
        }

        //удаляем файл
        $resultDelete = $this->qb->where('id', '?')->delete('??subscribe', [$id]);
        
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

