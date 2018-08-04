<?php

namespace controllers\front;

use \system\Controller;
use \models\front\DownloadModel;

defined('BASEPATH') OR exit('No direct script access allowed');

class DownloadController extends Controller {
    
    public function file() {   
        $model = new DownloadModel;
        $file = $model->getFile();
        if($file) {
            if(file_exists($file['path'])) {
                // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
                // если этого не сделать файл будет читаться в память полностью!
                if (ob_get_level()) {
                    ob_end_clean();
                }
                // заставляем браузер показать окно сохранения файла
                header('Content-Description: File Transfer');
                header('Content-Type: ' . $file['mime']);
                header('Content-Disposition: attachment; filename="' . str_replace('"', '', $file['name'])) . '"';
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file['path']));
                // читаем файл и отправляем его пользователю
                readfile($file['path']);
                exit;
            }
        }
    }

}
