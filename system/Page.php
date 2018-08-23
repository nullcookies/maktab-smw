<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Component {

    public $layout;

    public function __construct(){
        parent::__construct();
        $this->layout = 'layout';
    }

    public function get($pageParams = []) {
        
        if(!$pageParams){
            echo 'Page Parameters Error';
            exit;
        }

        $access = true;
        if(defined('BASEURL_ADMIN')){
            $checkAccess = $this->qb->where('alias', '?')->get('??module', [$pageParams['controller']])->fetch();
            if($checkAccess){
                $moduleAccess = (int)$checkAccess['access'];
                if($moduleAccess < 1 || $checkAccess['status'] == 0){
                    $access = false;
                }
                elseif(!empty($_SESSION['usergroup']) && $_SESSION['usergroup'] > $moduleAccess){
                    $access = false;
                }
            }
        }
        
        define('CONTROLLER', $pageParams['controller']);
        define('ACTION', $pageParams['action']);

        $controllerName = '\\controllers\\' . $pageParams['side'] . '\\' . $this->toCamelCase($pageParams['controller'], true) . 'Controller';
        
        if(!class_exists($controllerName) || !method_exists($controllerName, $pageParams['action']) || !$access){
            $controllerName = '\\controllers\\' . $pageParams['side'] . '\\Page404Controller';
            $pageParams['action'] = 'index';
        }

        $controller = new $controllerName;
        $controller->viewsPath = BASEPATH . '/views/' . $pageParams['side'];
        $controller->params = $pageParams['params'];

        $controller->$pageParams['action']();
        
        $controllerPath = explode('\\', $controllerName);
        

        if($pageParams['renderMode'] == 'page'){
            $sth = $this->qb->where([['controller', '?'], ['side', '?']])->get('??page', [$pageParams['controller'], $pageParams['side']]);
            $pageModules = [];
            if($sth->rowCount() > 0){
                $page = $sth->fetchAll()[0];

                $page_id = $page['id'];
                
                $modulesSth = $this->qb->where([['page_id', '?'], ['action', '?']])->get('??page_module', [$page_id, $pageParams['action']]);
                if($modulesSth->rowCount() > 0){
                    $pageModules = $modulesSth->fetchAll(\PDO::FETCH_ASSOC);
                }
            }
            $controller->modules = array_merge($pageModules, $controller->modules);
            
            $controller->getModules();

            if($controller->header404){
                header('HTTP/1.0 404 Not Found');
            }
            
            echo $controller->renderPage();
        }
        else{
            echo $controller->content;
        }
    }
    
}
