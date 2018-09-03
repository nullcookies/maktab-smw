<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Autoloader {
    public static function loader($className) {
        $filename = BASEPATH . '/' . str_replace('\\', '/', $className) . ".php";
        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
spl_autoload_register('Autoloader::loader');
