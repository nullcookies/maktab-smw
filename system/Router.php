<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class Router extends Component {

    
    public $route;
    public $side;
    public $renderMode;
    public $languages;
    public $controller;
    public $action;
    public $params;

    public function __construct(){
        parent::__construct();
        $this->route == '';
        $this->side = 'front';
        $this->renderMode = 'page';
        $this->languages = [];
        $this->controller = $this->getOption('default_controller');
        $this->action = $this->getOption('default_action');
        $this->params = [];

        $sthLang = $this->qb->where([['status', '1'], ['main', '1', 'OR']])->get('??lang');
        if($sthLang->rowCount() > 0){
            $languages = $sthLang->fetchAll();
            foreach($languages as $value){
                $this->languages[$value['id']] = $value['lang_prefix'];
                if($value['main']){
                    if(!defined('LANG_MAIN')){
                        define('LANG_MAIN', $value['id']);
                    }
                    $this->languages['main'] = [
                        'id' => $value['id'],
                        'lang_prefix' => $value['lang_prefix']
                    ];
                }
            }
        }
        else{
            exit('No Language');
        }

        /*if($_SESSION['lang_id']){
            if(isset($this->languages[$_SESSION['lang_id']])){
                define('LANG_PREFIX', $this->languages[$_SESSION['lang_id']]);
                define('LANG_ID', $_SESSION['lang_id']);
            }
        }
        elseif($_COOKIE['lang_id']){
            if(isset($this->languages[$_COOKIE['lang_id']])){
                define('LANG_PREFIX', $this->languages[$_COOKIE['lang_id']]);
                define('LANG_ID', $_COOKIE['lang_id']);
            }
        }*/
    }

    public function parseUrl() {
        
        //парсим url
        $this->setRoute();
        $this->route = trim(trim($this->route), '/');
        $urlPieces = explode('/', $this->route);
        
        //определяем язык сайта
        $lang_id = array_search($urlPieces[0], $this->languages);
        if($lang_id !== false ){
            if(!defined('LANG_PREFIX')){
                define('LANG_PREFIX', $urlPieces[0]);
            }
            if(!defined('LANG_ID')){
                define('LANG_ID', $lang_id);
            }
            array_shift($urlPieces);
        }
        if(!defined('LANG_PREFIX')){
            define('LANG_PREFIX', $this->languages['main']['lang_prefix']);
        }
        if(!defined('LANG_ID')){
            define('LANG_ID', $this->languages['main']['id']);
        }

        //заново объединяем и проверяем url является ли алиасом другого url, затем разделяем снова на массив
        $this->route = implode('/', $urlPieces);
        $sth = $this->qb->select('route')->where('alias', '?')->get('??url', [$this->route]);
        if($sth->rowCount() > 0){
            $this->route = $sth->fetch()['route'];
        }
        foreach($this->config['routes'] as $key => $value){
            if(preg_match($key, $this->route)){
                $this->route = preg_replace($key, $value, $this->route);
                break;
            }
        }
        $urlPieces = explode('/', $this->route);

        //если url ведет в админку проверяем и переходим
        if($urlPieces[0] == $this->config['adminAccess']){
            $this->side = 'back';
            define('BASEURL_ADMIN', BASEURL . '/' . $this->config['adminAccess']);
            array_shift($urlPieces);
            $adminAccess = false;
            

            if(isset($_SESSION['usergroup']) && isset($_SESSION['user_id'])){
                if($_SESSION['usergroup'] <= 3){
                    if(isset($_COOKIE['PHPSESSID'])){
                        $phpsessid = $_COOKIE['PHPSESSID'];
                        $lastPhpsessid = $this->qb->select('phpsessid')->where('id', '?')->get('??user', [$_SESSION['user_id']])->fetch()['phpsessid'];
                        if($phpsessid != $lastPhpsessid){
                            unset($_SESSION['usergroup']);
                            unset($_SESSION['user_id']);
                        }
                        else{
                            $adminAccess = true;
                        }
                    }
                }
                else{
                    exit('Access Error');
                }
            }
            if(!$adminAccess){
                $urlPieces = ['user', 'login'];
                //header('Location: ' . BASEURL . '/' . $this->config['adminAccess'] . '/user/login/' );
                //exit;
            }
        }
        else{
            //если не админка и включена режим обслуживания выходим
            if($this->getOption('maintainance') == 1){
                exit('Site under maintainance');
            }
        }

        //если url начинается с 'view' показываем только блок модуля
        if($urlPieces[0] == 'view'){
            $this->renderMode = 'module';
            array_shift($urlPieces);
        }

        //контроллер
        if($urlPieces[0]){
            $this->controller = array_shift($urlPieces);
        }
        else{
            $this->controller = $this->getOption('default_controller');
        }

        //метод
        if(isset($urlPieces[0]) && $urlPieces[0] !== false){
            $this->action = array_shift($urlPieces);
        }
        else{
            $this->action = $this->getOption('default_action');
        }
        
        //остальные параметры url в массив GET с ключами param1, param2, ..., paramN
        $this->params = $urlPieces;
        foreach($urlPieces as $key => $value){
            $_GET['param' . ($key + 1)] = trim($value);
        }
        

        return [
            'side' => $this->side,
            'renderMode' => $this->renderMode,
            'controller' => $this->controller,
            'action' => $this->action,
            'params' => $this->params
        ];
    }

    private function setRoute() {
        $route = '';
        if($this->config['prettyUrl']){
            $route = $_SERVER['REQUEST_URI'];
            $checkRoute = strpos($route, '?');
            if($checkRoute !== false){
                $route = substr($route, 0, $checkRoute);
            }
        }
        else{
            if(isset($_GET['route'])){
                $route = $_GET['route'];
            }
            else{
                $route = '404';
            }
        }
        $this->route = trim(trim($route), '/');

    }
    
    
}



