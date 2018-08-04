<?php

namespace controllers\back;

use \system\Controller;
use \models\back\ImportproductsModel;

defined('BASEPATH') OR exit('No direct script access allowed');
defined('BASEURL_ADMIN') OR exit('No direct script access allowed');

class ImportproductsController extends Controller {

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
        $model = new ImportproductsModel;
        $model->index();
        $this->data = $model->data;
        $this->document = $model->document;
        $this->content = $this->render('import-products');
    }

    public function export() {   
        
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
        $model = new ImportproductsModel;

        $filename = $model->export();

        $file_extension = strtolower(substr(strrchr($filename,"."),1));
        if( $filename == "" )
        {
                  echo "ОШИБКА: не указано имя файла.";
                  exit;
        } elseif ( ! file_exists( $filename ) ) // проверяем существует ли указанный файл
        {
                  echo "ОШИБКА: данного файла не существует.";
                  exit;
        };
        switch( $file_extension )
        {
            case "xml": $ctype="text/xml"; break;
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "mp3": $ctype="audio/mp3"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;  
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            default: $ctype="application/force-download";
        }
        header("Pragma: public"); 
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false); // нужен для некоторых браузеров
        header("Content-Type: $ctype");
        header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($filename)); // необходимо доделать подсчет размера файла по абсолютному пути
        readfile("$filename");
        exit();
    }
    
    public function import() {
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
        $model = new ImportproductsModel;
        $result = $model->import();
        
        $this->data = $model->data;
        $this->document = $model->document;
        //echo json_encode($result);
        //exit;
        $this->content = $this->render('import-result');
    }
    
}


