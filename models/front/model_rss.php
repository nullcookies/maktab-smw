<?php

class Model_Rss extends Model
{
    public function get_data(){	
        
        $content = array();
        $items = array();
        
        $info = $this->db->selectRow("information", "`alias` = 'main' AND `lang` = " . LANGUAGE);
        
        $main = array();
        $main['title'] = $info['meta_t'];
        $main['description'] = $info['meta_d'];
        $main['link'] = $this->linker->get_home_url();
        
        $main['language'] = LANGUAGE_PREFIX;
        $main['managingEditor'] = $this->configuration->get("EMAIL");
        $main['webMaster'] = Config::TECH_EMAIL;
        $main['generator'] = Config::CMS . " v" . Config::CMS_VERSION;
        
        $content['main'] = $main;
        
        $news = $this->db->select("news", "*", "`lang` = " . LANGUAGE, array("date" => true), 50);
        if($news){
            foreach($news as $value){
                $link = $this->linker->get_url(Config::NEWS_URL . '/' . $value['alias']);
                $items[] = array(
                    "title" => htmlspecialchars($value['name']),
                    "link" => $link,
                    "description" => htmlspecialchars($value['descr']),
                    "pubDate" => date(DATE_RSS, $value['date']),
                    "guid" => $link
                );
            }
        }
        
        $content['items'] = $items;
        
        $this->page['content'] = $content;
        return $this->page;
    }
}



?>