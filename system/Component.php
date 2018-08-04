<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Component {
	
	protected $config;
    protected $qb;
    protected $validator;
    protected $media;

    protected static $lang;
    protected static $options;
    protected static $translations;
	
	public function __construct($config = []) {
		
		if(!$config){
			$config = include(BASEPATH . '/config/config.php');
		}
		if(!$config){
            exit('Set configuration file Component');
        }
        $this->config = $config;
        

        //$this->db = \system\DataBase::getInstance($this->config['db']);
        $this->qb = new QueryBuilder($this->config['db']);

        $this->validator = new \system\Validator($this->config, $this->qb);
        $this->media = new \system\Media($this->config, $this->validator);

        if(self::$lang === null){
            $getLang = $this->qb->where('status', '1')->get('??lang');
            
            if($getLang->rowCount() > 0){
                $lang = $getLang->fetchAll();
                foreach($lang as $value){
                    self::$lang[$value['id']] = $value['lang_prefix'];
                }
            }
        }
        if(self::$options === null){
            $getOptions = $this->qb->get('??option');
            
            if($getOptions->rowCount() > 0){
                $options = $getOptions->fetchAll();
                foreach($options as $value){
                    self::$options[$value['name']] = $value['content'];
                }
            }
        }
        if(self::$translations === null){
            $getTranslations = $this->qb->get('??translation');
            $translations = [];
            if($getTranslations->rowCount() > 0){
                $rawTranslations = $getTranslations->fetchAll();
                foreach($rawTranslations as $value){
                    $translations[$value['side']][$value['lang']][$value['name']] = $value['content'];
                }
            }
            self::$translations = $translations;
        }
	}

	protected function getOption($name) {
		$option = (isset(self::$options[$name])) ? self::$options[$name] : $name;
        return $option;
	}
	
	
    protected function translation($name, $side = 'front', $lang = LANG_ID) {
        $translation = $name;
        if(isset(self::$translations[$side][$lang][$name])){
            $translation = self::$translations[$side][$lang][$name];
        }
        else{
            $checkWord = $this->qb->where([['name', '?'], ['lang', '?'], ['side', '?']])->get('??translation', [$name, $lang, $side])->fetch();

            if(!$checkWord){
                $insertWord = [
                    'lang' => $lang,
                    'name' => $name,
                    'content' => $name,
                    'side' => $side
                ];
                $this->qb->insert('??translation', $insertWord);
            }
        }
        return $translation;
    }

    protected function t($name, $side = 'front', $lang = LANG_ID) {
        return $this->translation($name, $side, $lang);
    }
    protected function getTranslation($name, $side = 'back', $lang = LANG_ID) {
        return $this->translation($name, $side, $lang);
    }

	protected function lang() {
		return self::$lang;
	}
	protected function hashPassword($password) {
		return md5($this->config['params']['salt'] . $password);
	}
	protected function langDecode($arraySth = [], $langDecode = [], $multi = true, $curLang = false){
        if($multi){
            foreach($arraySth as $key => $value){
                foreach($langDecode as $valueDecode){
                    $arraySth[$key][$valueDecode] = json_decode($value[$valueDecode], true);
                    if($curLang){
                        $arraySth[$key][$valueDecode] = $arraySth[$key][$valueDecode][LANG_ID];
                    }
                }
            }
        }
        else{
            foreach($langDecode as $valueDecode){
                $arraySth[$valueDecode] = json_decode($arraySth[$valueDecode], true);
                if($curLang){
                    $arraySth[$valueDecode] = $arraySth[$valueDecode][LANG_ID];
                }
            }
        }
        
        return $arraySth;
    }
	
	protected function showSize($f, $format = true) {
        if(!file_exists($f)){
			return 0;
		}
		if($format) {
			$size = $this->showSize($f, false);
			if($size <= 1024) return $size . ' bytes';
			else if($size <= 1024 * 1024) return round($size / (1024), 2) . ' Kb';
			else if($size <= 1024 * 1024 * 1024) return round($size / (1024 * 1024), 2) . ' Mb';
			else if($size <= 1024 * 1024 * 1024 * 1024) return round($size / (1024 * 1024 * 1024), 2) . ' Gb';
			else if($size <= 1024 * 1024 * 1024 * 1024 * 1024) return round($size / (1024 * 1024 * 1024 * 1024), 2) . ' Tb'; //:)))
			else return round($size / (1024 * 1024 * 1024 * 1024 * 1024), 2) . ' Pb'; // ;-)
        }
		else {
			if(is_file($f)) return filesize($f);
			$size = 0;
			$dh = opendir($f);
			while(($file = readdir($dh)) !== false){
				if($file == '.' || $file == '..') continue;
				if(is_file($f . '/' . $file)) $size += filesize($f . '/' . $file);
				else $size += $this->showSize($f . '/' . $file, false);
			}
			closedir($dh);
			return $size + filesize($f); // +filesize($f) for *nix directories
        }
	}
	
	/*
	protected function removeDirectory($dir) {
        if(!is_dir($dir)){
            return false;
        }
        if ($objs = glob($dir . "/*")) {
           foreach($objs as $obj) {
             is_dir($obj) ? $this->removeDirectory($obj) : unlink($obj);
           }
        }
        return rmdir($dir);
    }
	*/

	public function ppp($var, $exit = false, $mode = 1) {
		echo '<pre>';
		if($mode == 1){
			var_dump($var);
		}
		elseif($mode == 2){
			print_r($var);
		}
		echo '</pre>';
		if($exit){
			exit;
		}
	}

    protected function formatPrice($price){
        $decimals = 2;
        if(null !== $this->getOption('price_decimals')){
            $decimals = (int)$this->getOption('price_decimals');
        }

        $decimalSep = '.';
        if(null !== $this->getOption('price_decimal_separator') && 'NULL' != $this->getOption('price_decimal_separator')){
            $decimalSep = (string)$this->getOption('price_decimal_separator');
        }

        $thousandSep = '';
        if(null !== $this->getOption('price_thousand_separator') && 'NULL' != $this->getOption('price_thousand_separator') && 'price_thousand_separator' != $this->getOption('price_thousand_separator')){
            $thousandSep = (string)$this->getOption('price_thousand_separator');
        }


        return number_format($price, $decimals, $decimalSep, $thousandSep) . '&nbsp;' . $this->translation($this->getOption('currency'));
    }


	
}
