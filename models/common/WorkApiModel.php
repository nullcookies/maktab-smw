<?php

namespace models\common;

use \system\Document;
use \system\Model;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Work App Information API Model
 */
class WorkApiModel extends Model 
{

	/**
	 * App host name
	 */
	public $host = 'http://domain.com';

	/**
	 * cookie file path
	 */
	public $cookie_file;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->cookie_file = BASEPATH . '/library/workapi_cookiefile.txt';
	}

	/**
	 * получить категории и подкат
	 */
	public function get_categories()
	{
        $url = $this->host . "/jsonapi/get_categories/";
        $json = $this->CURLgetPageRu($url, "", $this->cookie_file, false, "", "", "");

        return $json;
    }
    
    /**
     * получить задания
     */
	public function get_tasks()
	{
        $url = $this->host . "/jsonapi/get_tasks/";

        //$data['catids'] = "2,1";
        //$data['lt_tid'] = "5";
        //$data['gt_tid'] = "15";
        //$data['offset'] = "0";
        //$data['limit'] = "2";        
        //$data['ascdesc'] = "asc";
        //$data['sortfield'] = "tid";
        //$data['lastupdate'] = "2018-04-18T10:45:00+0500";
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "", "");

        return $json;
    }
    
    /**
     * получить свои задания
     */
	public function get_own_tasks()
	{
        $url = $this->host . "/jsonapi/get_own_tasks/";

        //$data['catids'] = "2,1";
        //$data['lt_tid'] = "5";
        //$data['gt_tid'] = "15";
        //$data['offset'] = "0";
        //$data['limit'] = "2";          
        //$data['ascdesc'] = "asc";
        //$data['sortfield'] = "tid";
        //$data['lastupdate'] = "2018-04-18T10:45:00+0500";
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998712230436", "LHI7nB9ibW4TCWx"); //"+998974466055", ""

        return $json;
    }
    
    /**
     * получить задания, которые я выполняю или выполнил
     */
	public function get_taskswork()
	{
        $url = $this->host . "/jsonapi/get_taskswork/";

        //$data['catids'] = "2,1";
        //$data['lt_tid'] = "5";
        //$data['gt_tid'] = "15";
        //$data['offset'] = "0";
        //$data['limit'] = "2";         
        //$data['ascdesc'] = "asc";
        //$data['sortfield'] = "tid";
        //$data['lastupdate'] = "2018-04-18T10:45:00+0500";

        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998712230436", "LHI7nB9ibW4TCWx"); //"+998974466055", ""

        return $json;
    }
    
    /**
     * получить задание
     */
	public function get_task()
	{
        $url = $this->host . "/jsonapi/get_task/";

        $data['tid'] = "1";
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", ""); //auth params optional

        return $json;
    }

    /**
     * получить возможные поля и их значения для данной категории
     */
	public function get_taskform_fields()
	{
        $url = $this->host . "/jsonapi/get_taskform_fields/";

        $data['tid'] = "0";
        $data['catid'] = "2";
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998712230436", "LHI7nB9ibW4TCWx"); //"+998974466055", ""

        return $json;
    }
    
    /**
     * обновление задания (черновика)
     */
	public function set_draft_task()
	{
        $url = $this->host . "/jsonapi/set_draft_task/";
         
        $data = array(
            'tid' => "23",
            'name' => "Name",
            'descr' => "Descr",
            'privinfo' => "privinfo",
            'addr' => "addr",
            'price' => "100",
            'currency' => "0",
            'tel' => "+79375217725",
            'sdate' => "",//"2017-05-17T05:00:31+0500",
            'edate' => "",//"2018-01-26T11:49:00+0000",
            "fieldsvals[10]"=>rand(0,1),
            "fieldsvals[2]"=>"Хорошо",// rand(0,1),
            "fieldsvals[3]"=>'totalniy',//rand(0,1),
            "fieldsvals[40]"=>rand(0,1),            
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", "");        
        return $json;
    }
    
    /**
     * ред/доб задания
     */
	public function set_task_add_edit()
	{
        $url = $this->host . "/jsonapi/set_task_add_edit/";
        

        //edit        
        $data = array(
            "tid"=>"1",
            "name"=>"New name",
            "catid"=>"",
            "descr"=>"New description",
            "privinfo"=>"Private info",
            "sdate"=>"2017-05-17T05:00:31+0500",
            "edate"=>"2017-05-17T05:00:55+0500",
            "price"=>"100",
            "currency"=>"1",
            "tel"=>"+998974140436",
            "addr"=>"Askiya 25 36",            
            "fieldsvals[10]"=>rand(0,1),
            "fieldsvals[2]"=>"Хер вам",// rand(0,1),
            "fieldsvals[3]"=>'totalniy',//rand(0,1),
            "fieldsvals[40]"=>rand(0,1),
            /*"imgs[0]"=>'@'.realpath('tmpimages/1.jpg'),
            "imgs[1]"=>'@'.realpath('tmpimages/3.jpg'),
            "imgs[2]"=>'@'.realpath('tmpimages/4.jpg'),
            "imgs[3]"=>'@'.realpath('tmpimages/spuf.jpg'),
            "imgs[4]"=>'@'.realpath('tmpimages/spufgif.jpg'),
            "imgs[5]"=>'@'.realpath('tmpimages/load.gif'),
            "imgs[6]"=>'@'.realpath('tmpimages/broken.jpg'),
            "imgs[7]"=>'@'.realpath('tmpimages/icons.png'),*/
        );
                
        /*
        //add
        $data = array(
            "name"=>"New 10",
            "catid"=>"2",
            "descr"=>"Added task description",
            "privinfo"=>"Added Private info",
            "sdate"=>"2017-05-17T05:00:31+0500",
            "edate"=>"2017-05-17T05:00:55+0500",
            "price"=>"100",
            "currency"=>"1",
            "tel"=>"+998974140436",
            "addr"=>"Added Askiya 25 36",            
            "fieldsvals[10]"=>rand(0,1),
            "fieldsvals[2]"=>"Хер вам",// rand(0,1),
            "fieldsvals[3]"=>'totalniy',//rand(0,1),
            "fieldsvals[5]"=>rand(0,1),
            /*"imgs[0]"=>'@'.realpath('tmpimages/1.jpg'),
            "imgs[1]"=>'@'.realpath('tmpimages/2.jpg'),
            "imgs[2]"=>'@'.realpath('tmpimages/4.jpg'),
            "imgs[3]"=>'@'.realpath('tmpimages/spuf.jpg'),
            "imgs[4]"=>'@'.realpath('tmpimages/spufgif.jpg'),
            "imgs[5]"=>'@'.realpath('tmpimages/load.gif'),
            "imgs[6]"=>'@'.realpath('tmpimages/broken.jpg'),*/
            /*"imgs[7]"=>'@'.realpath('tmpimages/icons.png'),
            "imgs[8]"=>'@'.realpath('tmpimages/a.jpg'),
            "imgs[9]"=>'@'.realpath('tmpimages/b.jpg'),
            "imgs[10]"=>'@'.realpath('tmpimages/c.jpg'),
            "imgs[11]"=>'@'.realpath('tmpimages/d.jpg'),
            "imgs[12]"=>'@'.realpath('tmpimages/e.jpg'),
            "imgs[13]"=>'@'.realpath('tmpimages/f.jpg'),
            "imgs[14]"=>'@'.realpath('tmpimages/g.jpg'),*/
        /*);*/
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", "");

        return $json;
    }
    
    
    /**
     * удаление картинки задания
     */
	public function task_images_delete()
	{
        $url = $this->host . "/jsonapi/task_images_delete/";
        
        $data = array(
            "imgids"=>"4,"
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998712230436", "LHI7nB9ibW4TCWx");

        return $json;
    }
    
    /**
     * доб фото
     */
	public function task_images_add()
	{
        $url = $this->host . "/jsonapi/task_images_add/";


        $data = array(
            "tid"=>"18",
            "imgs[0]"=>'@'.realpath('tmpimages/1.jpg'),
            "imgs[1]"=>'@'.realpath('tmpimages/e.jpg'),
            "imgs[2]"=>'@'.realpath('tmpimages/f.jpg'),
            "imgs[3]"=>'@'.realpath('tmpimages/1.jpg'),
            "imgs[4]"=>'@'.realpath('tmpimages/e.jpg'),
            "imgs[5]"=>'@'.realpath('tmpimages/f.jpg'),
            "imgs[6]"=>'@'.realpath('tmpimages/1.jpg'),
            "imgs[7]"=>'@'.realpath('tmpimages/e.jpg'),
            "imgs[8]"=>'@'.realpath('tmpimages/f.jpg'),
            "imgs[9]"=>'@'.realpath('tmpimages/1.jpg'),
            /*"imgs[3]"=>'@'.realpath('tmpimages/spuf.jpg'),
            "imgs[4]"=>'@'.realpath('tmpimages/spufgif.jpg'),
            "imgs[5]"=>'@'.realpath('tmpimages/load.gif'),
            "imgs[6]"=>'@'.realpath('tmpimages/broken.jpg'),
            "imgs[7]"=>'@'.realpath('tmpimages/icons.png'),*/
        );
                
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", "");
        return $json;
    }
    
    
    /**
     * удаление задания
     */
	public function task_delete()
	{
        $url = $this->host . "/jsonapi/task_delete/";
        
        $data = array(
            "tid"=>22
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974140436", "");

        return $json;
    }

    /**
     * отменить задание (state=1)
     */
	public function task_cancel()
	{
        $url = $this->host . "/jsonapi/task_cancel/";
        
        $data = array(
            "tid"=>10
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974140436", "");

        return $json;
    }

    /**
     * отменить задание (state=1)
     */
	public function task_completed()
	{
        $url = $this->host . "/jsonapi/task_completed/";
        
        $data = array(
            "tid"=>205
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998712230436", "LHI7nB9ibW4TCWx"); //"+998974140436", ""

        return $json;
    }

    /**
     * получить юзера
     */
	public function get_user()
	{
        $url = $this->host . "/jsonapi/get_user/";
        
        $data = array(
            "userid"=>12
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998712230436", "LHI7nB9ibW4TCWx"); //"+998974466055", ""

        return $json;
    }
    
    /**
     * создать юзера
     */
	public function set_user_add()
	{
        $url = $this->host . "/jsonapi/set_user_add/";
        
        $data = array(
            "tel"=>"+998974466055",
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "", "");

        return $json;
    }

    /**
     * запрос получения sms кода
     */
	public function get_sms_code()
	{
        $url = $this->host . "/jsonapi/get_sms_code/";
        
        $data = array(
            "tel"=>"+998974466055",
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "", "");

        return $json;
    }

    /**
     * активация
     */
	public function set_user_active()
	{
        $url = $this->host . "/jsonapi/set_user_active/";
        
        $data = array(
            "tel"=>"+998974466055",
            "smscode"=>"892640",
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "", "");

        return $json;
    }

    /**
     * редактирование юзера
     */
	public function set_user_edit()
	{
        $url = $this->host . "/jsonapi/set_user_edit/";
        
        $data = array(
            "tel"=>"+998974466055",
            "email"=>"ivan@bk.ru",
            "first_name"=>"Иван",
            "last_name"=>"Иваныч",
            "userphoto"=>'@'.realpath('tmpimages/ivan.jpg'),
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", "");

        return $json;
    }
    
    /**
     * запрос перед тем как выполнить авторизацию
     */
	public function login_prepare()
	{
        $url = $this->host . "/jsonapi/login_prepare/";
        
        $data = array(
            "tel"=>"+998974140436",
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "", "");

        return $json;
    }
    
    /**
     * получить отзывы о юзере
     */
	public function get_user_reviews()
	{
        $url = $this->host . "/jsonapi/get_user_reviews/";
        
        $data = array(
            "userid"=>"2",
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", "");

        return $json;
    }
    
    /**
     * отправить отзыв о юзере
     */
	public function set_user_review()
	{
        $url = $this->host . "/jsonapi/set_user_review/";
        
        $data = array(
            "userid"=>2,
            "ball"=>rand(1,5),
            "comment"=>"New comment<b> ".time(),
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", "");

        return $json;
    }
    
    /**
     * получить задания
     */
	public function get_own_bids()
	{
        $url = $this->host . "/jsonapi/get_own_bids/";

        //$data['lt_paydate'] = "";
        //$data['gt_paydate'] = "";
        //$data['offset'] = "0";
        //$data['limit'] = "2";                
        //$data['lastupdate'] = "2018-04-18T10:45:00+0500";
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", ""); //"+998712230436", "LHI7nB9ibW4TCWx"

        return $json;
    }
    
    /**
     * получить задания
     */
	public function get_task_bids()
	{
        $url = $this->host . "/jsonapi/get_task_bids/";

        $data['tid'] = "4";
        //$data['lt_paydate'] = "";
        //$data['gt_paydate'] = "";
        //$data['offset'] = "0";
        //$data['limit'] = "2";                
        //$data['lastupdate'] = "2018-04-18T10:45:00+0500";
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", ""); //"+998712230436", "LHI7nB9ibW4TCWx"

        return $json;
    }
    
    /**
     * отправить свое предложение хозяину задания
     */
	public function set_task_bid()
	{
        $url = $this->host . "/jsonapi/set_task_bid/";
        
        //Add
        $data = array(        
            "tid"=>"14",
            "currency"=>1,
            "price"=>"1000",                        
            "comment"=>"Alll!",
        );
        
        /*
        //Edit
        $data = array(
            "bidid"=>8,
            "tid"=>"1",
            "currency"=>1,
            "price"=>"2000",
            "comment"=>"Edited 2!",
        );*/
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998712230436", "LHI7nB9ibW4TCWx");//"+998974466055", ""

        return $json;
    }
    
    /**
     * принять выбранный бид для своего задания
     */
	public function accept_task_bid()
	{
        $url = $this->host . "/jsonapi/accept_task_bid/";
        
        $data = array(
            "bidid"=>"71",
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", ""); // "+998712230436", "LHI7nB9ibW4TCWx"

        return $json;
    }
    
    /**
     * отменить свой бид
     */
	public function cancel_mybid()
	{
        $url = $this->host . "/jsonapi/cancel_mybid/";
        
        $data = array(
            "bidid"=>"63",
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", "");

        return $json;
    }
    
    /**
     * отменить бид для своего задания от какого либо пользователя
     */
	public function cancel_task_executor()
	{
        $url = $this->host . "/jsonapi/cancel_task_executor/";
        
        $data = array(
            "bidid"=>"68",
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998974466055", "");

        return $json;
    }
    
    /**
     * получение списка уведомлений
     */
	public function get_notices()
	{
        $url = $this->host . "/jsonapi/get_notices/";
        
        $data = array(
            "getall"=>"1",
            "notids"=>"",
            "dzinids"=>"",
        );
        
        $json = $this->CURLgetPageRu($url, $data, $this->cookie_file, false, "", "+998712230436", "LHI7nB9ibW4TCWx"); //"+998974466055", ""

        return $json;
    }

	/**
	 * get content
	 */
	private function CURLgetPageRu($url, $data, $cookiefile="", $debug=false, $useproxy=false, $login="", $pass="")
	{

	  	global $debug_headers;

	    $ch = curl_init();
	    
	    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt ($ch, CURLOPT_TIMEOUT, 200);
	    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt ($ch, CURLOPT_MAXREDIRS, 0);
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_REFERER, '');

	    curl_setopt ($ch, CURLOPT_URL,$url);
	    curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)");
	    
	    if(!empty($login))
	      curl_setopt ($ch, CURLOPT_USERPWD, $login.":".$pass);
	 
	    //curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, true);

	    if(!empty ($data))
	    {
	        curl_setopt ($ch, CURLOPT_POST, true);
	        curl_setopt ($ch, CURLOPT_NOBODY, false);
	        curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	    }
	    if($cookiefile != "")
	    {
	        $cooka = array();
	        $datainfile = file($cookiefile);
	        for($i=0; $i<count($datainfile); $i++)
	        {
	            $cooka[] = trim(substr($datainfile[$i],1,strlen($datainfile[$i])-3));
	        }            
	        $cooka = implode("; ", $cooka);
	        //print $cooka;
	        curl_setopt($ch, CURLOPT_COOKIE, $cooka);
	        //curl_setopt($ch, CURLOPT_COOKIESESSION, true);  
	        /*curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
	        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);*/
	    }
	    if($debug)
	    {
	        curl_setopt ($ch, CURLOPT_HEADER, true); //DEBUG PURPOSES - SHOWS RETURNED HTTP HEADER
	        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	        //$f = fopen('./request.txt', 'w');
	        //curl_setopt ($ch, CURLOPT_STDERR, $f);
	        //curl_setopt ($ch, CURLOPT_VERBOSE, true);
	    }

		$result = curl_exec ($ch);
		
	    if($cookiefile)
	    {
	        
	        /*$result = 'Set-Cookie:  csrftoken1=AOkp3ilOfOOJF2B3pwIz8Vnb3DALGhiWgra65JuIOXiStLUSg6MhLhAXO04Fj28a6; expires=Fri, 14-Sep-2018 11:45:09 GMT; Max-Age=31449600; Path=/'."\n".
	                  'Set-Cookie:  csrftoken2=Okp3ilOfOOJF2B3pwIz8Vnb3DALGhiWgra65JuIOXiStLUSg6MhLhAXO04Fj28a6; expires=Fri, 14-Sep-2018 11:45:09 GMT; Max-Age=31449600; Path=/'."\n".
	                  'Set-Cookie:  csrftoken3=BOkp3ilOfOOJF2B3pwIz8Vnb3DALGhiWgra65JuIOXiStLUSg6MhLhAXO04Fj28a6; expires=Fri, 14-Sep-2018 11:45:09 GMT; Max-Age=31449600; Path=/'."\n";
	        print $result."\n\n";
	         */
	        
	        $datainfile = file_get_contents($cookiefile);
	                                
	        $pattern = '#Set-Cookie:\s+(?<cook>.*;)#Uis';
	        preg_match_all($pattern, $result, $matches);
	        //print_r($matches);
	        foreach($matches['cook'] as $cookie1)
	        {
	            $varname = explode("=", $cookie1);
	            $varname = trim($varname[0]);                
	            
	            //print trim($cookie1)."\n";
	            if(stripos($datainfile,";$varname=")!==false)
	                $datainfile = preg_replace("#(;$varname=.*;)#Uis", ";".trim($cookie1), $datainfile);                    
	            else
	                $datainfile .= ";".trim($cookie1)."\n";
	        }
	        
	        //print $datainfile;
	        $ck = fopen($cookiefile,"w");
	        fwrite($ck, $datainfile);
	        fclose($ck);
	    }
	            
	    if($debug)
	    {
	        $debug_headers = curl_getinfo($ch);
	        var_dump ($debug_headers);      
	        
	        //$headerSent = curl_getinfo($curlHandle, CURLINFO_HEADER_OUT ); // request headers
	        //print $headerSent;
	    }
	        
		curl_close($ch);
		return $result;


	}
    
}
