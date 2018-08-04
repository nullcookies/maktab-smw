<?php

namespace models\front;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

class InformationModel extends Model {
    
    public function view(){
        
        $data = [];
        $this->document = new Document();

        $id = $_GET['param1'];

        $breadcrumbs = [];
        $breadcrumbPages = ['home'];
        $statement = $this->qb->where([['side', 'front'], ['controller', '?']])->getStatement('??page');
        $sth = $this->qb->prepare($statement);
        if($sth){
            foreach ($breadcrumbPages as $value) {
                $sth->execute([$value]);
                if($sth->rowCount() > 0){
                    $breadcrumb = $sth->fetchAll();
                    $breadcrumb = $this->langDecode($breadcrumb, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k']);
                    $breadcrumb = $breadcrumb[0];
                    $breadcrumbs[] = [
                        'name' => $breadcrumb['nav_name'][LANG_ID],
                        'url' => $this->linker->getUrl($breadcrumb['alias'])
                    ];
                }
            }
        }

        $infoPage = $this->qb->where('id', '?')->get('??page', [$id])->fetch();

        if($infoPage){
            $infoPage = $this->langDecode($infoPage, ['name', 'text_name', 'nav_name', 'descr', 'descr_full', 'meta_t', 'meta_d', 'meta_k'], false);
            $this->document->title = ($infoPage['meta_t'][LANG_ID]) ? $infoPage['meta_t'][LANG_ID] : $infoPage['name'][LANG_ID];
            $this->document->description = $infoPage['meta_d'][LANG_ID];
            $this->document->keywords = $infoPage['meta_k'][LANG_ID];
            $breadcrumbs[] = [
                'name' => $infoPage['nav_name'][LANG_ID],
                'url' => 'active'
            ];
        }

        $data['infoPage'] = $infoPage;
        $data['breadcrumbs'] = $breadcrumbs;
        

        $this->data = $data;

        return $this;
    }
}



