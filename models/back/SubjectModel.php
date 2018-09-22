<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\objects\User;
use \models\objects\Subject;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class SubjectModel extends Model
{

    public function index()
    {

        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->t('main page', 'back'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->t($this->control . ' page', 'back'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->t('control panel', 'back') . ' - ' . $this->t($this->control . ' page', 'back');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/mixitup-3/dist/mixitup.min.js');
        
        $controls = [];
        $controls['save-schedule'] = $this->linker->getUrl($this->control . '/save-schedule', true);
        $controls['list_ajax'] = $this->linker->getUrl($this->control . '/list_ajax', true);
        $controls['view'] = $this->linker->getUrl($this->control . '/view', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);
        $data['controls'] = $controls;

        $dataTableAjaxParams = [];
        $dataTableAjaxParams['page-start'] = (!empty($_GET['page_start'])) ? $_GET['page_start'] : '';
        $dataTableAjaxParams['page-length'] = (!empty($_GET['page_length'])) ? $_GET['page_length'] : '';
        $dataTableAjaxParams['page-order-column'] = (!empty($_GET['page_order_column'])) ? $_GET['page_order_column'] : '';
        $dataTableAjaxParams['page-order-dir'] = (!empty($_GET['page_order_dir'])) ? $_GET['page_order_dir'] : '';
        $data['dataTableAjaxParams'] = $dataTableAjaxParams;

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
        $controls['view'] = $this->linker->getUrl($this->control . '/view', true);
        $controls['delete'] = $this->linker->getUrl($this->control . '/delete', true);
        $data['controls'] = $controls;

        $_POST = $this->cleanForm($_POST);

        $data['draw'] = (int)$_POST['draw'];
        $checkYear = date('Y') - 1;
        $totalRows = $this->qb->select('id')->count('??subject');
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
                $order = 'id';
                break;
            
            case 1:
                $order = 'name';
                break;

            default:
                $order = 'name';
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
            $where_params = [];
            $search_where = " (name LIKE ?) ";
            $where_params[] = '%' . $searchText . '%';
            $querySearch = 'SELECT id FROM ??subject WHERE ' . $search_where . ' GROUP BY id ';
            $sth1 = $this->qb->prepare($querySearch);
            $sth1->execute($where_params);
            $recordsFiltered = $sth1->rowCount();
        }
        $data['recordsFiltered'] = $recordsFiltered;


        $query = 'SELECT * FROM ??subject ';

        if($searchText){
            $query .= ' WHERE ' . $search_where;
        }
        $query .= ' GROUP BY id ';
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
            $itemsDataRow[1] = $value['name'];
            
            $itemsDataRow[2] =   '<div class="status-change">' . 
                                    '<input data-toggle="toggle" data-on="' . $this->t('toggle on', 'back') . '" data-off="' . $this->t('toggle off', 'back') . '" data-onstyle="warning" type="checkbox" name="status" data-controller="subject" data-table="subject" data-id="' . $value['id'] . '" class="status-toggle" ' . (($value['status']) ? 'checked' : '') . '>' .
                                    '</div>';
            $itemsDataRow[3] =   '<a class="btn btn-info entry-edit-btn" title="' . $this->t('btn edit', 'back') . '" href="' . $controls['view'] . '?id=' .  $value['id'] . '">' .
                                        '<i class="fa fa-edit"></i>' .
                                    '</a> ' . 
                                    '<a class="btn btn-danger entry-delete-btn" href="' . $controls['delete'] . '?id=' . $value['id'] . '" data-toggle="confirmation" data-btn-ok-label="' . $this->t('confirm yes', 'back') . '" data-btn-ok-icon="fa fa-check" data-btn-ok-class="btn-success btn-xs" data-btn-cancel-label=" ' . $this->t('confirm no', 'back') . '" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-danger btn-xs" data-title="' . $this->t('are you sure', 'back') . '" >' . 
                                        '<i title="' . $this->t('btn delete', 'back') . '" class="fa fa-trash-o"></i>' . 
                                    '</a>';
            $itemsData[] = $itemsDataRow;
        }



        $data['data'] = $itemsData;

        $this->data = $data;

        return $this;
    }
    
    public function view()
    {
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : (!empty($_POST['subject']['id']) ? (int)$_POST['subject']['id'] : 0);
        
        $subject = new Subject();

        if($id){
            $subject->find($id);
        }

        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->t('main page', 'back'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->t($this->control . ' page', 'back'),
            'url' => $this->linker->getUrl($this->control, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->t('view ' . $this->control, 'back'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->t('control panel', 'back') . ' - ' . $this->t($this->control, 'back');

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
        $controls['view'] = $this->linker->getUrl($this->control . '/view', true);
        $data['controls'] = $controls;

        if(isset($this->subject)){
            $subject = $this->subject;
        }
        elseif(!empty($_POST['subject'])){
            $subject->setFields($_POST['subject']);
        }

        $data['subject'] = $subject;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $this->data = $data;

        return $this;
        
    }
    
    public function save()
    {
        
        $subject = new Subject();

        $_POST = $this->cleanForm($_POST);
        $info = $_POST['subject'];
        
        $new = true;
        $id = (int)$info['id'];
        if($id && $subject->find($id)){
            $new = false;
        }

        $checkData = [];
        $checkData['info'] = $info;

        $rules = [ 
            'info' => [
                'name' => ['isRequired'],
            ],
            'files' => [
                
            ]
        ];

        $valid = $this->validator->validate($rules, $checkData);
        
        if(!$valid){

            if(!$new){
                $this->errorText = $this->t('error edit ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error add ' . $this->control, 'back');
            }
            $this->errors = $this->validator->lastErrors;

            return false;

        }
        else{

            $subject->setFields($info);
            $subject->status = 1;

            $subject->save();

            if($subject->savedSuccess){
                $this->subject = $subject;
                $this->successText = $this->t('success edit ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error edit ' . $this->control, 'back');
                $this->errors['error db'] = $this->t('error db', 'back');
            }
            return $subject->savedSuccess;
        }
    }

    public function toggle()
    {
        $id = $_GET['param1'];
        $status = (int)$_GET['param2'];

        $return = '';

        $subject = new Subject();
        if($id && $subject->find($id)){
            $subject->status = $status;
            $subject->save();

            if($subject->savedSuccess){
                $return = ($status) ? 'on' : 'off';
            }
        }
        return $return;
    }
    
    public function delete()
    {
        $return = false;

        $id = (int)$_GET['id'];
        $subject = new Subject();

        if($id && $subject->find($id)) {

        	$this->qb->where('subject_id', '?')->delete('??subject_to_teacher', [$subject->id]);

            $subject->remove();
            
            if($subject->removedSuccess){
                $this->successText = $this->t('success delete ' . $this->control, 'back');
            }
            else{
                $this->errorText = $this->t('error delete ' . $this->control, 'back');
                $this->errors['error db'];
            }

            $return = $subject->removedSuccess;
        }
        else{
            $this->errors['error invalid id'];
        }

        return $return;
    }

    public function saveSchedule()
    {
        $rules = [ 
            'post' => [

            ],
            'files' => [
                'new_file' => [ ['isImage', ['isRequired' => 1]] ]
            ]

        ];
        $_POST = $this->cleanForm($_POST);

        $data['post'] = $_POST;
        $data['files'] = $_FILES;

        $valid = $this->validator->validate($rules, $data);
        if(!$valid){
            $this->errorText = $this->t('error schedule file upload', 'back');
            $this->errors = $this->validator->lastErrors;
            return false;
        }
        else{
            $update = [];
            
            $file = $_FILES['new_file'];
            
            $ext = substr(strrchr($file['name'], '.'), 1);
            $mimeType = $file['type'];
            $tmpName = $file['tmp_name'];

            $currentFileName = $this->getOption('school_schedule_file');
            $currentFile = BASEPATH . '/uploads/' . $currentFileName;

            $update['content'] = $fileName;

            if(file_exists($currentFile)){
                unlink($currentFile);
            }

            $newFileName = 'schedule' . rand(10000, 99999) . '.' . $ext;
            $newFile = BASEPATH . '/uploads/' . $newFileName;
            $uploadResult = move_uploaded_file($tmpName, $newFile);

            $updateResult = $this->qb->where('name', 'school_schedule_file')->update('??option', ['content' => $newFileName]);

            if(!$uploadResult || !$updateResult){
                $this->errorText = $this->t('error schedule file upload', 'back');
                $this->errors['error db'] = $this->t('error db', 'back');
                return false;
            }
            else{                    
                $this->successText = $this->t('success schedule file upload', 'back');
                return true;
            }
        }
    }

}
