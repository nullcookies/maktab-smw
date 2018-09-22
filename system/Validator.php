<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class Validator {

	public $lastError;
	public $lastErrorParams = [];
	public $lastErrors;

	private $blacklist;
	private $qb;
	private $config;

	public function __construct($config = [], $qb = false) {
		$this->lastError = '';
		$this->lastErrors = [];
		$this->blacklist = ["php","html","htm","phtml","php3","php4","php5","htaccess"];
		$this->config = $config;
		if($qb){
			$this->qb = $qb;
		}
	}

	public function validate($rules, $data) {
		$this->lastErrors = [];
		$valid = true;
		foreach($rules as $key => $value){
			foreach($rules[$key] as $rulesKey => $rulesValue){
				
				foreach($rules[$key][$rulesKey] as $item){
					$param = null;
					if(is_array($item)){
						$function = $item[0];
						$param = $item[1];
					}
					else{
						$function = $item;
					}
					if($param !== null) {
						if(is_array($data[$key][$rulesKey]) && $key != 'files'){
							foreach($data[$key][$rulesKey] as $dataKey => $dataValue){
								$check = $this->$function($dataValue, $param);
								if(!$check){
									$valid = false;
									$this->lastError($rulesKey, $dataKey);
								}
							}
						}
						else{
							$check = $this->$function($data[$key][$rulesKey], $param);
							if(!$check){
								$valid = false;
								$this->lastError($rulesKey);
							}
						}
					}
					else {
						if(is_array($data[$key][$rulesKey]) && $key != 'files'){
							foreach($data[$key][$rulesKey] as $dataKey => $dataValue){
								$check = $this->$function($dataValue);
								if(!$check){
									$valid = false;
									$this->lastError($rulesKey, $dataKey);
								}
							}
						}
						else{
							$check = $this->$function($data[$key][$rulesKey]);
							if(!$check){
								$valid = false;
								$this->lastError($rulesKey);
							}
						}

					}
				}
			}
		}

		$lastErrors = [];
		return $valid;
	}

	private function lastError($key, $dataKey = false){
		if($dataKey){
			$this->lastErrors[$key][$dataKey] = $this->lastError;
		}
		else{
			$this->lastErrors[$key] = $this->lastError;
		}
		
		$this->lastError = '';
		$this->lastErrorParams = [];
	} 

	public function isRequired($string) {
        $return = true;
        if($string === null || $string === ''){
        	$return = false;
        	$this->lastError = 'error empty';
        }
        return $return;
    }
    
    public function isAlias($string, $strict = false) {
        $return = true;
        if($strict){
            $pattern = "/^[0-9a-z]+([0-9a-z-_\.\/]*[0-9a-z]+)*$/";
        }
        else{
            $pattern = "/^[0-9a-z]+([0-9a-z-_\.,\/]*[0-9a-z]+)*$/";
        }
        
        if(!preg_match($pattern, $string)) {
			$return = false;
        	$this->lastError = 'error not alias';
        }
        return $return;
    }
    
    public function isUsername($string) {
        $return = true;
        if(!preg_match("/^\+?[0-9a-zA-Z][0-9a-zA-Z-_]+[0-9a-zA-Z]$/", $string)) {
			$return = false;
        	$this->lastError = 'error not username';
        }
        return $return;
    }
    
    public function isEmail($email) {
        $return = true;
        if(!preg_match("/.+@.+\..+/i", $email)) {
			$return = false;
        	$this->lastError = 'error not email';
        }
        return $return;
    }
    
    public function isNaturalNumber($number) {
        $return = true;
        if(!is_int($number) || $number < 1) {
			$return = false;
        	$this->lastError = 'error choose category';
        }
        return $return;
    }

    public function isUnique($string, $params) {
        $return = true;
        $sqlParams = [];
        $id = (isset($params['id'])) ? $params['id'] : 0;
        $table = $params['table'];
        $column = $params['column'];
        if($id){
        	$this->qb->where('id !=', '?');
        	$sqlParams[] = $id;
        }
        $sqlParams[] = $string;

        $check = $this->qb->where($column, '?')->get($table, $sqlParams);
        if($check->rowCount() > 0){
        	$return = false;
        	$this->lastError = 'error not unique';
        }
        return $return;
    }

    public function belongsTo($string, $params) {
        $return = false;
        $sqlParams = [];
        $where = [];
        $table = $params['table'];
        foreach ($params['columns'] as $key => $value) {
        	$where[] = [$key, '?'];
        	$sqlParams[] = $value;
        }

        $check = $this->qb->where($where)->get($table, $sqlParams);
        if($check && $check->rowCount() > 0){
        	$return = true;
        }
        if(!$return){
        	$this->lastError = 'error not belongs to';
        }
        return $return;
    }

    public function accessControl($string, $params)
    {
    	$return = false;
    	if(
    		($params['type'] == '==' && $string == $params['value']) ||
    		($params['type'] == '>=' && $string >= $params['value']) ||
    		($params['type'] == '>' && $string > $params['value'])
    	){
    		$return = true;
    	}
    	else{
    		$this->lastError = 'error usergroup';
    	}

        return $return;
    }
    
    public function isInt($number) {
        $return = true;
        if(!is_int($number) && !is_string($number)) {
			$return = false;
        }
        if(!preg_match("/^-?(([1-9][0-9]*|0))$/", $number)) {
			$return = false;
        }
        if(!$return){
        	$this->lastError = 'error not int';
        }
        return $return;
    }
    
    public function isSecure($file, $maxSize = 3000000) {
		$return = true;
		foreach($this->blacklist as $val){
			if(preg_match("/$val/i",strrchr($file["name"],"."))){
				$return = false;
				$this->lastError = 'error not allowed file';
			}
		}
		$size = $file["size"];
		$type = $file["type"];
		//if(($type != "image/jpeg") && ($type != "image/jpg") && ($type != "image/png") && ($type != "image/gif")) return false;
		if($size > $maxSize) {
			$return = false;
        	$this->lastError = 'error not allowed file';
        }
        return $return;
	}
    
    public function isImage($file, $params = ['isRequired' => false]) {

		$return = true;
		$size = $file["size"];
		$type = $file["type"];
		if(isset($params['isRequired']) && $params['isRequired'] && $file['error'] > 0){
			$return = false;
			$this->lastError = 'error file not uploaded';
		}
		if ($return && count($this->blacklist)){
			foreach($this->blacklist as $val){
				if(preg_match("/$val/i", strrchr($file["name"], "."))){
					$return = false;
					$this->lastError = 'error not allowed file';
					break;
				}
			}
		}
		if($return && ($type != "image/jpeg") && ($type != "image/jpg") && ($type != "image/png") && ($type != "image/gif")){
			$return = false;
			$this->lastError = 'error not allowed file';
		}
		if($return && $size > $this->config['params']['max_image_size']){
			$return = false;
			$this->lastError = 'error max image size: ' . ($this->config['max_image_size'] / 1024 / 1024) . 'mb';
		}

		if($return && $file['error'] === 0) {
			//than check image sizes
			list($width, $height) = getimagesize($file['tmp_name']);
			if($width > $this->config['params']['max_image_width'] || $height > $this->config['params']['max_image_height']){
				$return = false;
				$this->lastError = 'error max image dimensions: ' . $this->config['params']['max_image_width'] . 'x' . $this->config['params']['max_image_height'];
			}
		}
			

		return $return;
	}
    
    public function isVideo($file) {
		$return = true;
		foreach($this->blacklist as $val){
			if(preg_match("/$val/i",strrchr($file["name"],"."))){
				$return = false;
				$this->lastError = 'error not allowed file';
				break;
			}
		}
		$size = $file["size"];
		$type = $file["type"];
		if($type != "video/mp4" && $type != "video/webm"){
			$return = false;
			$this->lastError = 'error not allowed file';
		}
		if($size > 20 * 1024 * 1024){ //3mb
			$return = false;
			$this->lastError = 'error not allowed file';
		}
		return $return;
	}
    
    public function isXML($file) {
		$return = true;
		foreach($this->blacklist as $val){
			if(preg_match("/$val/i",strrchr($file["name"],"."))){
				$return = false;
				$this->lastError = 'error not allowed file';
				break;
			}
		}
		$size = $file["size"];
		$type = $file["type"];
		if( ($type != "application/xml") && ($type != "text/xml")){
			$return = false;
			$this->lastError = 'error not allowed file';
		}
		
		return $return;
	}
	
	public function isPdf($file) {
		$return = true;
		foreach($this->blacklist as $val){
			if(preg_match("/$val/i",strrchr($file["name"],"."))){
				$return = false;
				$this->lastError = 'error not allowed file';
				break;
			}
		}
		$size = $file["size"];
		$type = $file["type"];
		if(($type != "application/pdf")){
			$return = false;
			$this->lastError = 'error not allowed file';
		}
		if($size > 31457280){ //30mb
			$return = false;
			$this->lastError = 'error not allowed file';
		}
		return $return;
	}
	

	public function maxSize($file, $maxSize = 3000000) {
		$return = true;
		$size = $file["size"];
		if($size > $maxSize){
			$this->lastError = 'max size';
			$this->lastErrorParams[] = round($maxSize / 1024 / 1024, 2) . 'MB';
			$return = false;
		}
		return $return;
	}
    
    public function isSecureMusic($file) {
		foreach($this->blacklist as $val){
			if(preg_match("/$val/i",strrchr($file["name"],"."))){
				return false;
			}
		}
		$size = $file["size"];
		$type = $file["type"];
		if(($type != "audio/mpeg") && ($type != "audio/mp3") && ($type != "audio/ogg") ){
			return false;
		}
		if($size > $this->config['params']['max_music_size']){
			return false;
		}
		return true;
	}

	
}


