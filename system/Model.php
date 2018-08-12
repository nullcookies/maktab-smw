<?php

namespace system;

use SQLBuilder\ArgumentArray;
use SQLBuilder\Bind;
use SQLBuilder\ParamMarker;
use SQLBuilder\Criteria;
use SQLBuilder\Driver\MySQLDriver;
use SQLBuilder\Universal\Query\SelectQuery;
use SQLBuilder\Universal\Query\InsertQuery;
use SQLBuilder\Universal\Query\UpdateQuery;
use SQLBuilder\Universal\Query\DeleteQuery;

defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends Component {

    public $data;
    public $errors;
    public $errorText;
	public $successText;
	public $linker;
    public $document;

    protected $view;
	protected $control;

    public function __construct(){
        parent::__construct();
        $this->data = [];
        $this->errors = [];
        $this->errorText = '';
        $this->successText = '';
        $lang_prefix = (LANG_ID != LANG_MAIN) ? LANG_PREFIX : '';
        $this->linker = new Linker($lang_prefix);
        $this->document = false;
        $this->control = $this->getControl();
        $this->view = new View();
    }

    protected function getControl() {
        $getControl = explode('\\', get_class($this));
        $control = strtolower(array_pop($getControl));
        $control = preg_replace('#(.*?)model$#', '\1', $control);
        return $control;
    }

    //$_POST, $_GET clean
    protected function cleanForm($post) {
        $return = [];
        foreach ($post as $key => $value){
            $return[$key] = $post[$key];
            if(is_string($value)){
                $return[$key] = htmlspecialchars(trim($value), ENT_QUOTES);
            }
            if(is_array($value)){
                foreach ($return[$key] as $k => $v){
                    if(is_string($v)){
                        $return[$key][$k] = htmlspecialchars(trim($v), ENT_QUOTES);
                    }
                }
            }
        }
        return $return;
    }

    protected function loadedImages($arrayImageIds) {
        $data = [];
        $loadedImages = [];
        $initialPreview = [];
        $initialPreviewConfig = [];
        if(is_array($arrayImageIds)){
            $fileIds = [];
            foreach($arrayImageIds as $value){
                $fileIds[] = (int)$value;
            }
            $getFiles = $this->qb->where('id IN', $fileIds)->order('sort_number')->get('??file');
            if($getFiles->rowCount() > 0){
                $files = $getFiles->fetchAll();
                foreach($files as $rawFile){
                    $file = BASEPATH . '/uploads/' . $rawFile['path'];
                    if(file_exists($file)){
                        $loadedImages[] = $rawFile['id'];
                        $initialPreview[] = $this->linker->getIcon($this->media->resize($rawFile['path'], 80, 60, false, true));
                        $rawFilePathArray = explode('/', $rawFile['path']);
                        $initialPreviewConfig[] = [
                            'caption' => array_pop($rawFilePathArray),
                            'width' => '80px',
                            'size' => filesize($file),
                            'url' => '/' . $this->config['adminAccess'] . '/file/delete/' . $rawFile['id'], // server delete action 
                            'key' => $rawFile['id'],
                            'extra' => ['id' => $rawFile['id']]
                        ];
                    }
                }
            }
                
        }
        $data['loadedImages'] = $loadedImages;
        $data['initialPreview'] = $initialPreview;
        $data['initialPreviewConfig'] = $initialPreviewConfig;
        return $data;
    }

    protected function loadedVideos($arrayFileIds) {
        $data = [];
        $loadedVideos = [];
        $initialPreviewVideo = [];
        $initialPreviewConfigVideo = [];
        if(is_array($arrayFileIds)){
            $fileIds = [];
            foreach($arrayFileIds as $value){
                $fileIds[] = (int)$value;
            }
            $getFiles = $this->qb->where('id IN', $fileIds)->order('sort_number')->get('??file');
            if($getFiles->rowCount() > 0){
                $files = $getFiles->fetchAll();
                foreach($files as $rawFile){
                    $file = BASEPATH . '/uploads/' . $rawFile['path'];
                    if(file_exists($file)){
                        $loadedVideos[] = $rawFile['id'];
                        $initialPreviewVideo[] = $this->linker->getFile($rawFile['path']);
                        $rawFilePathArray = explode('/', $rawFile['path']);
                        $initialPreviewConfigVideo[] = [
                            'caption' => array_pop($rawFilePathArray),
                            'size' => filesize($file),
                            'filetype' => $rawFile['mime'],
                            'url' => '/' . $this->config['adminAccess'] . '/file/delete/' . $rawFile['id'], // server delete action 
                            'key' => $rawFile['id'],
                            'extra' => ['id' => $rawFile['id']]
                        ];
                    }
                }
            }
                
        }
        $data['loadedVideos'] = $loadedVideos;
        $data['initialPreviewVideo'] = $initialPreviewVideo;
        $data['initialPreviewConfigVideo'] = $initialPreviewConfigVideo;
        return $data;
    }

    protected function loadedPdf($arrayFileIds) {

        $data = [];
        $loadedPdf = [];
        $initialPreviewPdf = [];
        $initialPreviewConfigPdf = [];
        if(is_array($arrayFileIds)){
            foreach($arrayFileIds as $value){
                $getFile = $this->qb->where('id', '?')->get('??file', [$value]);

                if($getFile->rowCount() > 0){
                    $rawFile = $getFile->fetch();
                    $file = BASEPATH . '/uploads/' . $rawFile['path'];
                    if(file_exists($file)){
                        $loadedPdf[$rawFile['id']] = $rawFile['id'];
                        $initialPreviewPdf[] = '<img src="' . $this->linker->getIcon($rawFile['path']) . '" class="file-preview-image" alt="">';
                        $rawFilePathArray = explode('/', $rawFile['path']);
                        $initialPreviewConfigPdf[] = [
                            'caption' => array_pop($rawFilePathArray),
                            'width' => '200px',
                            'size' => filesize($file),
                            'url' => '/' . $this->config['adminAccess'] . '/file/delete/' . $rawFile['id'], // server delete action 
                            'key' => $rawFile['id'],
                            'extra' => ['id' => $rawFile['id']]
                        ];
                    }
                }
            }
        }
        $data['loadedPdf'] = $loadedPdf;
        $data['initialPreviewPdf'] = $initialPreviewPdf;
        $data['initialPreviewConfigPdf'] = $initialPreviewConfigPdf;
        return $data;
    }
	
	protected function getLinks($urlRoute) {
        $links = [];
        $getLinksSth = $this->qb->prepare('SELECT * FROM ??url WHERE route LIKE ?');
        $getLinksSth->execute([$urlRoute]);
        if($getLinksSth->rowCount() > 0){
            $getLinks = $getLinksSth->fetchAll();
            foreach($getLinks as $value){
                $links[$value['route']] = $value['alias'];
            }
        }
        return $links;
    }
    protected function getMainIcon($images, $synchronized = false) {
        $file_table = ($synchronized) ? '??file_synchro' : '??file';
        $image = '';
        $images = json_decode($images, true);
        if(is_array($images)){
            $imageId = array_shift($images);
            $image = $this->qb->where('id', '?')->get($file_table, [$imageId])->fetch()['path'];
        }
        return $image;
    }
    protected function getIcons($images, $synchronized = false) {
        $file_table = ($synchronized) ? '??file_synchro' : '??file';
        $return = [];
        $images = json_decode($images, true);
        if(is_array($images)){
            foreach($images as $value){
                $return[] = $this->qb->where('id', '?')->get($file_table, [$value])->fetch()['path'];
            }
        }
        return $return;
    }

    protected function buildProducts($products, $curLang = false) {
		
        $smallIconW = $this->getOption('icon_small_w');
        $smallIconH = $this->getOption('icon_small_h');
        $mediumIconW = $this->getOption('icon_medium_w');
        $mediumIconH = $this->getOption('icon_medium_h');
		
        $links = $this->getLinks('product/view/%');
        $cLinks = $this->getLinks('category/view/%');
        $bLinks = $this->getLinks('brand/view/%');

        foreach($products as $key => $value){
            if($value['images']){
                $mainImage = $this->getMainIcon($value['images']);
                $products[$key]['icon'] = $this->linker->getIcon($this->media->resize($mainImage, $mediumIconW, $mediumIconH, true));
                $products[$key]['icon_small'] = $this->linker->getIcon($this->media->resize($mainImage, $smallIconW, $smallIconH, true));
            }
            
            $mainLink = 'product/view/' . $value['id'];
            $aliasLink = $links[$mainLink];
            if($aliasLink){
                $products[$key]['url'] = $this->linker->getUrl($aliasLink);
            }
            else{
                $products[$key]['url'] = $this->linker->getUrl('product/view/' . $value['id']);
            }

            $bLink = 'brand/view/' . $value['b_id'];
            $bAliasLink = $bLinks[$bLink];
            if($bAliasLink){
                $products[$key]['b_url'] = $this->linker->getUrl($bAliasLink);
            }
            else{
                $products[$key]['b_url'] = $this->linker->getUrl('brand/view/' . $value['b_id']);
            }

            $cLink = 'category/view/' . $value['c_id'];
            $cAliasLink = $cLinks[$cLink];
            if($cAliasLink){
                $products[$key]['c_url'] = $this->linker->getUrl($cAliasLink);
            }
            else{
                $products[$key]['c_url'] = $this->linker->getUrl('category/view/' . $value['c_id']);
            }
        }
        if($curLang){
            $products = $this->langDecode($products, ['c_name', 'b_name', 'sale_info_1', 'sale_info_2', 'name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k'], true, true);
        }
        else{
            $products = $this->langDecode($products, ['c_name', 'b_name', 'sale_info_1', 'sale_info_2', 'name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
        }
        
        return $products;
    }

    protected function getPagination($paginationParams){
        $pagination = [];
        $allQuantity = $paginationParams['quantity'];
        $allPages = ceil($paginationParams['allQuantity'] / $paginationParams['quantity']);
        $lastPage = $allPages;
        $quantity = $paginationParams['quantity'];
        $currentPage = $paginationParams['page'];
        $urlParams = $paginationParams['urlParams'];
        if($allPages > 1){
            
            $pagination['first'] = [
                'name' => 'first',
                'url' => '',
                'active' => false,
                'disabled' => false
            ];
            $pagination['last'] = [
                'name' => 'last',
                'url' => '',
                'active' => false,
                'disabled' => false
            ];
            $pagination['prev'] = [
                'name' => 'prev',
                'url' => '',
                'active' => false,
                'disabled' => false
            ];
            $pagination['next'] = [
                'name' => 'next',
                'url' => '',
                'active' => false,
                'disabled' => false
            ];
            $pagination['pages'] = [];

            if($currentPage > 1){
                $pagination['first']['url'] = $this->linker->getPaginationUrl($urlParams, 1);
                $prevPage = $currentPage - 1;
                $pagination['prev']['url'] = $this->linker->getPaginationUrl($urlParams, $prevPage);
            }
            else{
                $pagination['first']['disabled'] = true;
                $pagination['prev']['disabled'] = true;
            }
            if($currentPage < $lastPage){
                $pagination['last']['url'] = $this->linker->getPaginationUrl($urlParams, $lastPage);
                $nextPage = $currentPage + 1;
                $pagination['next']['url'] = $this->linker->getPaginationUrl($urlParams, $nextPage);
            }
            else{
                $pagination['last']['disabled'] = true;
                $pagination['next']['disabled'] = true;
            }

            for($i = 1; $i <= $allPages; $i++){
                $active = ($currentPage == $i) ? true : false;
                $pagination['pages'][] = [
                    'name' => $i,
                    'url' => $this->linker->getPaginationUrl($urlParams, $i),
                    'active' => $active,
                    'disabled' => false
                ];
            }
        }
        return $pagination;
    }


    protected function num2str($num) {
        $nul='ноль';
        $ten=array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        );
        $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
        $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
        $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
        $unit=array( // Units
            array('тийин' ,'тийин' ,'тийин',    1),
            //array('копейка' ,'копейки' ,'копеек',    1),
            array('сум'   ,'сум'   ,'сум'    ,0),
            //array('рубль'   ,'рубля'   ,'рублей'    ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','миллиарда','миллиардов',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = $this->morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        $out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }

    //function defination to convert array to xml
    public function arrayToXML($array, &$xml) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    
                    $subnode = $xml->addChild("$key");
                    $this->arrayToXML($value, $subnode);
                }else{
                    $subnode = $xml->addChild("item$key");
                    $this->arrayToXML($value, $subnode);
                }
            }else {
                $xml->addChild("$key","$value");
            }
        }
    }

    public function getActiveLangKeys() {
        $lang = [];
        $getLanguages = $this->qb->where('status', '1')->get('??lang');
        if($getLanguages){
            $getLanguages = $getLanguages->fetchAll();
            foreach ($getLanguages as $value) {
                $lang[$value['id']] = $value['lang_prefix'];
            }
        }
        return $lang;
    }

    public function getSitePages($ids) {
        $pages = [];
        if(!is_array($ids)){
            $ids = [$ids];
        }
        $getLinks = $this->qb->select('id, name, nav_name, alias')->where('id IN', $ids)->get('??page')->fetchAll();
        if($getLinks){
            $getLinks = $this->langDecode($getLinks, ['name', 'nav_name']);
            foreach($getLinks as $value){
                $pages[$value['id']] = [
                    'name' => $value['name'][LANG_ID],
                    'nav_name' => $value['nav_name'][LANG_ID],
                    'url' => $this->linker->getUrl($value['alias']),
                    'active' => false
                ];
            }
        }
        return $pages;
    }

    /**
     * Склоняем словоформу
     * @ author runcore
     */
    protected function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }

    protected function render($template, $data, $type = 'html') {
        return $this->view->render(THEMEPATH . '/tpl/' . $template . '.php', $data, $type);
    }

    protected static function cmp($a, $b) {
        return strcmp($a["name"], $b["name"]);
    }

    public static function sortByName($a, $b) {
        if ($a['name'] == $b['name']) {
            return 0;
        }
        return ($a['name'] > $b['name']) ? +1 : -1;
    }


}


