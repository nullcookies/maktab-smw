<?php

namespace models\back;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class FileModel extends Model {

    public $path = 'file';

    public function uploadImage() {

        $data = [];
        $files = [];
        $result = [];
        $errors = [];

        if(is_array($_FILES['images']['name'])){
            foreach($_FILES['images']['name'] as $key => $value){
                $files[$key] = [
                    'name' => $_FILES['images']['name'][$key],
                    'type' => $_FILES['images']['type'][$key],
                    'tmp_name' => $_FILES['images']['tmp_name'][$key],
                    'error' => $_FILES['images']['error'][$key],
                    'size' => $_FILES['images']['size'][$key]
                ];
            }
        }
        else{
            $files[] = [
                'name' => $_FILES['images']['name'],
                'type' => $_FILES['images']['type'],
                'tmp_name' => $_FILES['images']['tmp_name'],
                'error' => $_FILES['images']['error'],
                'size' => $_FILES['images']['size']
            ];
        }
        
        foreach ($files as $key => $value) {
            $isValid = $this->validator->isImage($value);

            if($isValid){
                $result[$key] = $this->media->upload($value, $this->path, 'file');
            }
            else{
                $errors[] = [
                    'file' => $value['name'],
                    'error' => $this->getTranslation($this->validator->lastError),
                ];
            }
        }


        $initialPreview = [];
        $initialPreviewConfig = [];


        //for alt names
        $lang = [];
        $getLang = $this->qb->where('status', '1')->get('??lang');
        if($getLang->rowCount() > 0){
            $lang = $getLang->fetchAll();
        }

        foreach($result as $key => $value){
            $insertSth = $this->qb->insert('??file', ['path' => $value, 'name' => htmlspecialchars($files[$key]['name']), 'mime' => $files[$key]['type']]);

            if($insertSth->rowCount() > 0){
                $lastId = $this->qb->lastInsertId();
                $initialPreview[] = $this->linker->getIcon($this->media->resize($value, 80, 60, false, true));
                $initialPreviewConfig[] = [
                    'caption'=> $files[$key]['name'], 
                    'size'=> $files[$key]['size'], 
                    'width'=> '80px', 
                    'url'=> '/' . $this->config['adminAccess'] . '/file/delete/' . $lastId, // server delete action 
                    'key'=> $lastId, 
                    'extra'=> ['id'=> $lastId]
                ];

                //alt names
                foreach($lang as $langValue){
                    $this->qb->insert('??file_name', ['file_id' => $lastId, 'name' => '', 'lang_id' => $langValue['id']]);
                }
            }
        }

        if(count($initialPreview) > 0){
            $data['success'] = true;
        }
        else{
            $data['success'] = false;
        }

        $data['errors'] = $errors;

        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;

        $this->data = $data;
        return $this;
    }

    public function uploadVideo() {
        
        $data = [];
        $files = [];
        $result = [];

        if(is_array($_FILES['videos']['name'])){
            foreach($_FILES['videos']['name'] as $key => $value){
                $files[$key] = [
                    'name' => $_FILES['videos']['name'][$key],
                    'type' => $_FILES['videos']['type'][$key],
                    'tmp_name' => $_FILES['videos']['tmp_name'][$key],
                    'error' => $_FILES['videos']['error'][$key],
                    'size' => $_FILES['videos']['size'][$key]
                ];
            }
        }
        else{
            $files[] = [
                'name' => $_FILES['videos']['name'],
                'type' => $_FILES['videos']['type'],
                'tmp_name' => $_FILES['videos']['tmp_name'],
                'error' => $_FILES['videos']['error'],
                'size' => $_FILES['videos']['size']
            ];
        }

        foreach ($files as $key => $value) {
            $isValid = $this->validator->isVideo($value);
            if($isValid){
                $result[$key] = $this->media->upload($value, $this->path, 'file');
            }
        }


        $initialPreview = [];
        $initialPreviewConfig = [];


        //for alt names
        $lang = [];
        $getLang = $this->qb->where('status', '1')->get('??lang');
        if($getLang->rowCount() > 0){
            $lang = $getLang->fetchAll();
        }

        foreach($result as $key => $value){
            $insertSth = $this->qb->insert('??file', ['path' => $value, 'name' => htmlspecialchars($files[$key]['name']), 'mime' => $files[$key]['type']]);

            if($insertSth->rowCount() > 0){
                $lastId = $this->qb->lastInsertId();
                $initialPreview[] = $this->linker->getFile($value);
                $initialPreviewConfig[] = [
                    'caption'=> $files[$key]['name'], 
                    'size'=> $files[$key]['size'], 
                    'filetype'=> $files[$key]['type'], 
                    'url'=> '/' . $this->config['adminAccess'] . '/file/delete/' . $lastId, // server delete action 
                    'key'=> $lastId, 
                    'extra'=> ['id'=> $lastId]
                ];

                //alt names
                foreach($lang as $langValue){
                    $this->qb->insert('??file_name', ['file_id' => $lastId, 'name' => '', 'lang_id' => $langValue['id']]);
                }
            }
        }

        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;

        $this->data = $data;
        return $this;
    }

    public function uploadPdf() {
        $data = [];

        $files = [];
        $result = [];
        if(is_array($_FILES['pdf']['name'])){
            foreach($_FILES['pdf']['name'] as $key => $value){
                $files[$key] = [
                    'name' => $_FILES['pdf']['name'][$key],
                    'type' => $_FILES['pdf']['type'][$key],
                    'tmp_name' => $_FILES['pdf']['tmp_name'][$key],
                    'error' => $_FILES['pdf']['error'][$key],
                    'size' => $_FILES['pdf']['size'][$key]
                ];
            }
        }
        else{
            $files[] = [
                'name' => $_FILES['pdf']['name'],
                'type' => $_FILES['pdf']['type'],
                'tmp_name' => $_FILES['pdf']['tmp_name'],
                'error' => $_FILES['pdf']['error'],
                'size' => $_FILES['pdf']['size']
            ];
        }

        foreach ($files as $key => $value) {
            $isValid = $this->validator->isPdf($value);
            if($isValid){
                $result[$key] = $this->media->upload($value, $this->path, 'file');
            }
        }


        $initialPreview = [];
        $initialPreviewConfig = [];


        foreach($result as $key => $value){
            $insertSth = $this->qb->insert('??file', ['path' => $value, 'name' => htmlspecialchars($files[$key]['name']), 'mime' => $files[$key]['type']]);
            if($insertSth->rowCount() > 0){
                $lastId = $this->qb->lastInsertId();
                $initialPreview[] = $this->linker->getIcon($value);
                $initialPreviewConfig[] = [
                    'caption'=> $files[$key]['name'], 
                    'size'=> $files[$key]['size'], 
                    'width'=> '80px', 
                    'url'=> '/' . $this->config['adminAccess'] . '/file/delete/' . $lastId, // server delete action 
                    'key'=> $lastId, 
                    'extra'=> ['id'=> $lastId]
                ];
            }
            
        }

        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;

        $this->data = $data;
        return $this;
    }

    public function delete() {
        $data = [];

        $cacheIcons = $this->getCashIcons();
        
        $id = $_GET['param1'];
        $data['id'] = '';
        if($id){
            $file = $this->qb->where('id', '?')->get('??file', [$id])->fetch();
            if($file){
                $deleteResult = $this->media->delete($file['path'], $cacheIcons);
                if($deleteResult){
                    $this->qb->where('id', '?')->delete('??file', [$id]);
                    $data['id'] = $id;
                }
            }
        }
        
        $this->data = $data;
        return $this;
    }

    public function sort() {
        $data = [];
        $sort = $_POST['sort'];
        $sth = $this->qb->prepare('UPDATE ??file SET sort_number = ? WHERE id = ?');
        if(is_array($sort)){
            foreach($sort as $key => $value){
                $sth->execute([$key, $value]);
            }
        }

        $this->data = $data;
        return $this;
    }

    public function getCashIcons(){
        $cacheIcons = [];
        $cacheIcons['smallIcon'] = $this->getOption('icon_small_w') . 'x' . $this->getOption('icon_small_h');
        $cacheIcons['mediumIcon'] = $this->getOption('icon_medium_w') . 'x' . $this->getOption('icon_medium_h');
        $cacheIcons['largeIcon'] = $this->getOption('icon_large_w') . 'x' . $this->getOption('icon_large_h');
        $cacheIcons['productIcon'] = $this->getOption('icon_product_large_w') . 'x' . $this->getOption('icon_product_large_h');
        $cacheIcons['productIcon'] = $this->getOption('icon_product_w') . 'x' . $this->getOption('icon_product_h');
        $cacheIcons['categoryIcon'] = $this->getOption('icon_category_w') . 'x' . $this->getOption('icon_category_h');
        $cacheIcons['postIcon'] = $this->getOption('icon_post_w') . 'x' . $this->getOption('icon_post_h');
        $cacheIcons['loadedIcon'] = $this->getOption('80x60');
        return $cacheIcons;
    }
    
}

