<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

abstract class PostModel extends Model {

    public $postTypes = [1];

    /*
        $type - post type, e.g. post, news etc.
    */
    public $type = 0;

    /*
        $name = post id for translations
    */
    public $name = 'post';

    /*
        $route for urls and image folder
    */
    public $route = 'post';

    public function index() {
        
        $data = [];

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->name . ' page'),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->name . ' page');

        $this->document->addStyle(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.css');
        
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/jquery.dataTables.min.js');
        $this->document->addScript(THEMEURL_ADMIN . '/plugins/datatables/dataTables.bootstrap.min.js');

        $controls = [];
        $controls['add'] = $this->linker->getUrl($this->name . '/add', true);
        $controls['edit'] = $this->linker->getUrl($this->name . '/edit', true);
        $controls['delete'] = $this->linker->getUrl($this->name . '/delete', true);
        $data['controls'] = $controls;

        $posts = [];
        $getPosts = $this->qb->order('date_add', true)->where('type', $this->type)->get('??post');
        if($getPosts->rowCount() > 0){
            $posts = $getPosts->fetchAll();
            $posts = $this->langDecode($posts, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }

        $data['posts'] = $posts;
        $data['route'] = $this->route;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;


        $this->data = $data;

        return $this;
    }

    public function add(){
        
        $data = [];

        $data['icon_medium_size'] = $this->getOption('icon_medium_w') . 'x' . $this->getOption('icon_medium_h');

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->name . ' page'),
            'url' => $this->linker->getUrl($this->name, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('add ' . $this->name),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation('add ' . $this->name);

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
        $controls['back'] = $this->linker->getUrl($this->name, true);
        $controls['action'] = $this->linker->getUrl($this->name . '/add', true);
        $data['controls'] = $controls;

        $loadedImages = [];
        $initialPreview = [];
        $initialPreviewConfig = [];

        $current = [];
        if($_POST){
            if($_POST['images']){
                $getLoadedImages = $this->loadedImages($_POST['images']);
                $loadedImages = $getLoadedImages['loadedImages'];
                $initialPreview = $getLoadedImages['initialPreview'];
                $initialPreviewConfig = $getLoadedImages['initialPreviewConfig'];
            }
            $current = $_POST;
        }
        $data[$this->name] = $current;

        $data['loadedImages'] = $loadedImages;
        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $data['postTypes'] = $this->postTypes;
        $data['route'] = $this->route;

        $this->data = $data;

        return $this;
    }
    
    public function edit() {
        
        $id = (int)$_GET['param1'];
        if(!$id){
            $id = (int)$_POST['id'];
        }
        
        $data = [];

        $data['icon_medium_size'] = $this->getOption('icon_medium_w') . 'x' . $this->getOption('icon_medium_h');

        $breadcrumbs = [];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('main page'),
            'url' => $this->linker->getAdminUrl()
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation($this->name . ' page'),
            'url' => $this->linker->getUrl($this->name, true)
        ];
        $breadcrumbs[] = [
            'name' => $this->getTranslation('edit ' . $this->name),
            'url' => 'active'
        ];

        $data['breadcrumbs'] = $breadcrumbs;
        
        $this->document = new Document();
        $this->document->title = $this->getTranslation('control panel') . ' - ' . $this->getTranslation($this->name);

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
        $controls['back'] = $this->linker->getUrl($this->name, true);
        $controls['action'] = $this->linker->getUrl($this->name . '/edit/' . $id, true);
        $data['controls'] = $controls;

        $loadedImages = [];
        $initialPreview = [];
        $initialPreviewConfig = [];

        $current = [];
        if($id){
            $getpost = $this->qb->where('id', '?')->get('??post', [$id]);
            if($getpost->rowCount() > 0){
                $post = $getpost->fetchAll();
                $post = $this->langDecode($post, ['name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                $current = $post[0];

                //картинки
                $existImages = json_decode($current['images'], true);
                $getLoadedImages = $this->loadedImages($existImages);
                $loadedImages = $getLoadedImages['loadedImages'];
                $initialPreview = $getLoadedImages['initialPreview'];
                $initialPreviewConfig = $getLoadedImages['initialPreviewConfig'];

                //url
                $getAlias = $this->qb->select('id')->where('route', '?')->get('??url', [$this->route . '/view/' . $id]);
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
            if($_POST['images']){
                $getLoadedImages = $this->loadedImages($_POST['images']);
                $loadedImages = $getLoadedImages['loadedImages'];
                $initialPreview = $getLoadedImages['initialPreview'];
                $initialPreviewConfig = $getLoadedImages['initialPreviewConfig'];
            }
            $current = $_POST;
        }

        $data[$this->name] = $current;

        $data['loadedImages'] = $loadedImages;
        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;

        $data['errors'] = $this->errors;
        $data['errorText'] = $this->errorText;
        $data['successText'] = $this->successText;

        $data['postTypes'] = $this->postTypes;
        $data['route'] = $this->route;

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
                'alias' => ['isRequired', 'isAlias', ['isUnique', $isUniqueParams]],
            ],
            'files' => [
                
            ]

        ];

        /*if($_FILES['image']['error'] == 0){
            $rules['files']['image'] = ['isImage', ['maxSize', 3000000]];
            $data['files'] = $_FILES;
        }*/

        $_POST = $this->cleanForm($_POST);

        $_POST['alias'] = strtolower($_POST['alias']);

        $data['post'] = $_POST;

        $valid = $this->validator->validate($rules, $data);

        if(!$valid){

            if(!$new){
                $this->errorText = $this->getTranslation('error edit ' . $this->name);
            }
            else{
                $this->errorText = $this->getTranslation('error add ' . $this->name);
            }
            $this->errors = $this->validator->lastErrors;
            return false;

        }
        else{

            $update = [];
            $update['images'] = json_encode($_POST['images'], JSON_UNESCAPED_UNICODE);
            $update['alias'] = $_POST['alias'];
            
            $update['type'] = $this->type;

            $update['name'] = json_encode($_POST['name'], JSON_UNESCAPED_UNICODE);
            $update['descr'] = json_encode($_POST['descr'], JSON_UNESCAPED_UNICODE);
            $update['descr_full'] = json_encode($_POST['descr_full'], JSON_UNESCAPED_UNICODE);
            $update['meta_t'] = json_encode($_POST['meta_t'], JSON_UNESCAPED_UNICODE);
            $update['meta_d'] = json_encode($_POST['meta_d'], JSON_UNESCAPED_UNICODE);
            $update['meta_k'] = json_encode($_POST['meta_k'], JSON_UNESCAPED_UNICODE);

            $update['video_code'] = $_POST['video_code'];

            $update["date"] = $_POST['date'];
            $update["date_modify"] = time();

            //$update["sort_number"] = (int)$_POST["sort_number"];

            $update["status"] = ($_POST["status"]) ? 1 : 0;

            if(!$new) {

                $path = $this->name . '/view/' . $id;
                $alias = ($_POST['alias']) ? $_POST['alias'] : $path;
                $update['alias'] = $alias;

                $updateResult = $this->qb->where('id', '?')->update('??post', $update, [$id]);
                if(!$updateResult){
                    $this->errorText = $this->getTranslation('error edit ' . $this->name);
                    $this->errors['error db'] = $this->getTranslation('error db');
                    return false;
                }
                else{

                    //обновление url
                    
                    $urlInsertUpdate = [
                        'alias' => $alias,
                        'route' => $path
                    ];
                    $this->qb->insertUpdate('??url', $urlInsertUpdate);
                    
                    $this->successText = $this->getTranslation('success edit ' . $this->name);
                    return true;
                }
                
            }
            else{

                $update["date_add"] = time();

                $insertResult = $this->qb->insert('??post', $update);
                
                if(!$insertResult){
                    $this->errorText = $this->getTranslation('error add ' . $this->name);
                    $this->errors['error db'];
                    return false;
                }
                else{
                    $id = $this->qb->lastInsertId();
                    //обновление url
                    $path = $this->name . '/view/' . $id;
                    $alias = ($_POST['alias']) ? $_POST['alias'] : $path;

                    $urlInsert = [
                        'alias' => $alias,
                        'route' => $path
                    ];
                    $this->qb->insert('??url', $urlInsert);

                    $this->qb->where('id', '?')->update('??post', ['alias' => $alias], [$id]);

                    $this->successText = $this->getTranslation('success add ' . $this->name);
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
            $result = $this->qb->where('id', '?')->update('??post', ['status' => $status], [$id]);
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
        $getpost = $this->qb->where('id', '?')->get('??post', [$id]);
        if($getpost->rowCount() > 0){
            $post = $getpost->fetch();
        }
        
        if($post['image']){
            $this->media->delete($post['image']);
        }
        if($post['images']){
            $images = json_decode($post['images']);
            if($images){
                foreach($images as $key => $value){
                    $images[$key] = (int)$value;
                }
                $files = $this->qb->where('id IN', $images)->get('??file')->fetchAll();
                if($files){
                    $imageDeleteSth = $this->qb->prepare('DELETE FROM ??file WHERE id = ?');
                    foreach($files as $value){
                        $file = BASEPATH . '/uploads/' . $value['path'];
                        if(file_exists($file)){
                            unlink($file);
                        }
                        $imageDeleteSth->execute([$value['id']]);
                    }
                }
            }
        }
		
		$this->qb->where('route', '?')->delete('??url', [$this->name . '/view/' . $id]);
        $resultDelete = $this->qb->where('id', '?')->delete('??post', [$id]);
        
        if(!$resultDelete){
            $this->errorText = $this->getTranslation('error delete ' . $this->name);
            $this->errors['error db'];
            return false;
        }
        else{
            $this->successText = $this->getTranslation('success delete ' . $this->name);
            return true;
        }
    }
    
}

