<?php

namespace models\back;

use \system\Document;
use \system\Model;
use \models\back\FileModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class GalleryModel extends Model {

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

        // $files = [];
        // $getFiles = $this->qb->order('id', true)->get('??file');
        // if($getFiles->rowCount() > 0){
        //     $files = $getFiles->fetchAll();
        //     $files = $this->langDecode($files, ['alt_name']);
        // }
        // $data['files'] = $files;

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

        //ssp
        // $sql_details = array(
        //     'user' => $this->config['db']['username'],
        //     'pass' => $this->config['db']['password'],
        //     'db'   => $this->config['db']['dbname'],
        //     'host' => $this->config['db']['host']
        // );
        // $table = $this->config['db']['prefix'] . 'product';
        // $primaryKey = 'id';
        // $columns = [
        //     [ 
        //         'db' => 'first_name', 
        //         'dt' => 0,
        //         'formatter' => function( $d, $row ) {
        //             return date( 'jS M y', strtotime($d));
        //         }
        //     ],
            
        // ];

        // $getData = SSPModel::simple( $_POST, $sql_details, $table, $primaryKey, $columns );

        $data['draw'] = (int)$_POST['draw'];

        $total = $this->qb->select('id')->count('??file');
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
                $order = 'id';
                break;
            
            case 2:
                $order = 'path';
                break;
            
            case 3:
                $order = 'sort_number';
                break;
            
            case 4:
                $order = 'name';
                break;
            
            default:
                $order = 'id';
                break;
        }

        $recordsFiltered = $total;


        $where_params = null;
        // $search_where = '';

        // $search = $_POST['search']['value'];
        // $searchText = substr($search, 0, 65536);

        // if($searchText){
        //     $where_params = [];
        //     $search_where = " (ps.search_text LIKE ? OR cs.search_text LIKE ?) ";
        //     $where_params[] = '%' . $searchText . '%';
        //     $where_params[] = '%' . $searchText . '%';
        //     $querySearch = 'SELECT p.id FROM ??product p LEFT JOIN ??product_search ps ON p.id = ps.product_id LEFT JOIN ??category_search cs ON p.category_id = cs.category_id WHERE ' . $search_where . ' GROUP BY p.id';
        //     $sth1 = $this->qb->prepare($querySearch);
        //     $sth1->execute($where_params);
        //     $recordsFiltered = $sth1->rowCount();
        // }
        $data['recordsFiltered'] = $recordsFiltered;


        $query = 'SELECT f.*, fn.name alt_name FROM ??file f LEFT JOIN ??file_name fn ON f.id = fn.file_id ';

        $query .= ' WHERE fn.lang_id = ' . LANG_ID . ' ';
        // if($searchText){
        //     $query .= ' AND ' . $search_where;
        // }
        $query .= ' GROUP BY f.id';
        $query .= ' ORDER BY ' . $order . ' ' . $orderDir . ' ';
        $query .= ' LIMIT ' . $offset . ', ' . $limit . ' ';

        $getFiles = $this->qb->prepare($query);
        $getFiles->execute($where_params);

        $files = [];
        if($getFiles->rowCount() > 0){
            $files = $getFiles->fetchAll();
        }

        $filesData = [];

        foreach($files as $value){
            $filesDataRow = [];

            $filesDataRow[0] = $value['id'];
            if($value['mime'] == 'image/jpeg' || $value['mime'] == 'image/jpg' || $value['mime'] == 'image/png' || $value['mime'] == 'image/gif'){
                $filesDataRow[1] = '<img src="' . $this->linker->getIcon($this->media->resize($value['path'], 80, 60, false, true)) . '" alt="" >';
            }
            else{
                $filesDataRow[1] = $value['mime'];
            }
            $filesDataRow[2] = $this->linker->getIcon($value['path']);
            $filesDataRow[3] = $value['sort_number'];
            $filesDataRow[4] = $value['name'];

            $filesDataRow[5] =   '<a class="btn btn-info" title="' . $this->getTranslation('btn edit') . '" href="' . $controls['edit'] . $value['id'] . '">' .
                                        '<i class="fa fa-edit"></i>' .
                                    '</a> ' . 
                                    '<a class="btn btn-danger" href="' . $controls['delete'] . $value['id'] . '" data-toggle="confirmation" data-btn-ok-label="' . $this->getTranslation('confirm yes') . '" data-btn-ok-icon="fa fa-check" data-btn-ok-class="btn-success btn-xs" data-btn-cancel-label=" ' . $this->getTranslation('confirm no') . '" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-danger btn-xs" data-title="' . $this->getTranslation('are you sure') . '" >' . 
                                        '<i title="' . $this->getTranslation('btn delete') . '" class="fa fa-trash-o"></i>' . 
                                    '</a>';
            $filesData[] = $filesDataRow;
        }

        $data['data'] = $filesData;

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
            'name' => $this->getTranslation('add ' . $this->control . ' file'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation('add ' . $this->control . ' file');

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

        $data['recommendedSizeProduct'] = $this->getOption('icon_product_large_w') . 'x' . $this->getOption('icon_product_large_h');
        $data['recommendedSizeCategory'] = $this->getOption('icon_category_w') . 'x' . $this->getOption('icon_category_h');
        $data['recommendedSizePost'] = $this->getOption('icon_medium_w') . 'x' . $this->getOption('icon_medium_h');

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
            'name' => $this->getTranslation('edit ' . $this->control . ' file'),
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
        $fileName = [];
        if($id){
            $getFile = $this->qb->where('id', '?')->get('??file', [$id]);
            if($getFile->rowCount() > 0){
                $file = $getFile->fetchAll();
                //$file = $this->langDecode($file, ['name']);
                $current = $file[0];
            }
            $getFileName = $this->qb->where('file_id', '?')->get('??file_name', [$id]);
            if($getFileName->rowCount() > 0){
                $getFileName = $getFileName->fetchAll();
                foreach($getFileName as $key => $value){
                    $fileName[$value['lang_id']] = $value['name'];
                }
            }
        }
        $data['fileName'] = $fileName;
        $data[$this->control] = $current;



        $data['recommendedSizeProduct'] = $this->getOption('icon_product_large_w') . 'x' . $this->getOption('icon_product_large_h');
        $data['recommendedSizeCategory'] = $this->getOption('icon_category_w') . 'x' . $this->getOption('icon_category_h');
        $data['recommendedSizePost'] = $this->getOption('icon_medium_w') . 'x' . $this->getOption('icon_medium_h');

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
                //'name' => ['isRequired']
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

            if(!$new) {

                $update = [];
                if(is_array($_POST['name'])){
                    foreach($_POST['name'] as $key => $value){
                        $updateResult = $this->qb->where([['file_id', '?'], ['lang_id', '?']])->update('??file_name', ['name' => $value], [$id, $key]);
                    }
                }

                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->control . ' file');
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{
                    $this->successText = $this->getTranslation('success edit ' . $this->control . ' file');
                    return true;
                }
                
            }
        }
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

        $file = [];
        $getFile = $this->qb->where('id', '?')->get('??file', [$id]);
        if($getFile->rowCount() > 0){
            $file = $getFile->fetch();
        }

        $fileModel = new FileModel();
        $cacheIcons = $fileModel->getCashIcons();
        
        //удаляем картинки
        if($file['path']){
            $this->media->delete($file['path'], $cacheIcons);
        }

        //удаляем name
        $this->qb->where('file_id', '?')->delete('??file_name', [$id]);

        //удаляем файл
        $resultDelete = $this->qb->where('id', '?')->delete('??file', [$id]);
        
        if(!$resultDelete){
            $this->errorText = $this->getTranslation('error delete ' . $this->control . ' file');
            $this->errors['error db'];
            return false;
        }
        else{
            $this->successText = $this->getTranslation('success delete ' . $this->control . ' file');
            return true;
        }
    }
    
}

