<?php 

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class Media {

    public $config;
    public $validator;

    public function __construct($config = [], $validator = null){
        $this->config = $config;
        $this->validator = $validator;
    }
	
    public function upload($file, $module, $alias, $replace = false){
        
        if($file['error'] == 0){
            $ext = strrchr($file["name"], '.');
            if(!$alias) {
                $name = $this->translit(strstr($file["name"], '.', true));
            }
            else {
                $name = $this->translit($alias);
            }

            if(empty($name)) {
                $name = 'file';
            }
            $name = $name . $ext;

            $dirUpload = BASEPATH . '/uploads/' . $module . '/';
            if(!is_dir($dirUpload)) {
                mkdir($dirUpload, 0755, true);
            }
            if(!$replace){
                $name = $this->getUniqueName($dirUpload, $name, 1);
            }
            
            
            $uploadStatus = move_uploaded_file($file["tmp_name"], $dirUpload . $name);
            if($uploadStatus) return $module . '/' . $name;
        }
        return false;
    }

    public function delete($path, $cacheIcons = []) {
        $return = true;
        $uploadsPath = BASEPATH . '/uploads/';
        $file = $uploadsPath . $path;
        if(file_exists($file)){
            $return = unlink($file);
        }
        if($cacheIcons){
            foreach($cacheIcons as $value){
                $file = $uploadsPath . 'cache/' . $value . '/' . $path;
                if(file_exists($file)){
                    unlink($file);
                }
            }
        }
        return $return;
    }
    
    public function uploadImage($path, $file, $alias = ''){
        $result = array();
        $result['success'] = false;
        $result['errors'] = array();
        
        list($width, $height) = getimagesize($file['tmp_name']);
        
        if(!$this->validator->isSecure($file)){
            $result['errors'][] = "Такой файл запрещен для загрузки";
        }
        
        $fileType = $file["type"];
        if(($fileType != "image/jpeg") && ($fileType != "image/jpg") && ($fileType != "image/gif") && ($fileType != "image/png") ) {
            $result['errors'][] = "Только jpg, png, gif файлы";
        }
        
        $fileSize = $file["size"];
        if($fileSize > $this->config['params']['max_image_size']){
            $result['errors'][] = "Максимальный размер файла: " . $this->config['params']['max_image_size'] / 1024 / 1024 . "МБ";
        }

        if($width > $this->config['params']['max_image_width'] || $height > $this->config['params']['max_image_height']){
            $result['errors'][] = "Максимальное расширение изображения: " . $this->config['params']['max_image_width'] . "x" . $this->config['params']['max_image_height'];
        }

        if(!$result['errors']){
            
            $ext = strrchr($file["name"],".");
            
            if(!$alias) $name = $this->validator->translit(substr($file["name"], 0, -4));
            else $name = $this->validator->translit($alias, 0, -4);
            if(empty($name)) $name = 'image';
            $name = $name . $ext;

            //file_put_contents("log_images1.txt", $this->validator->translit("комби"));
            //file_put_contents("log_images2.txt", $name);
            
            $dir_upload = BASEPATH . '/uploads/' . $path . '/';
            $name = $this->getUniqueName($dir_upload, $name, 1);

            //file_put_contents("log_images.txt",$name);
            
            $upload_status = move_uploaded_file($file["tmp_name"], $dir_upload.$name);
            if($upload_status) {
                $result['width'] = $width;
                $result['height'] = $height;
                $result['success'] = true;
                $result['content'] = $path . '/' . $name;
            }
        }
        
        return $result;
    }
    
    
    public function moveUploaded($path, $file, $alias = ''){
        
        $ext = strrchr($file, ".");
        
        if(!$alias) $name = $file;
        else $name = $this->validator->translit($alias, 0, -4);
        if(empty($name)) $name = 'file';
        $name = $name . $ext;
        
        $dir_upload = BASEPATH . '/uploads/' . $path . '/';
        $file_path = BASEPATH . '/' . Config::DIR_UPLOADS . '/' . $file;
        $name = $this->getUniqueName($dir_upload, $name, 1);
        
        
        $upload_status = move_uploaded_file($file_path, $dir_upload . $name);
        if($upload_status) return $path . '/' . $name;
        return false;
    }
    
    public function resize($icon, $width, $height, $crop = false, $forceResize = false, $forceSaveToUploads = false){
        $uploadsDir = 'uploads';
        if(isset($this->config['synchronized']) && $this->config['synchronized'] && $forceSaveToUploads == false){
            $uploadsDir = 'uploads-synchro';
        }
        $width = (int)$width;
        $height = (int)$height;
        if(!$icon) $icon = 'no-image.jpg';
        $original_file = BASEPATH . '/' . $uploadsDir . '/' . $icon;
        if(!file_exists($original_file)) {
            $original_file = BASEPATH . '/uploads/no-image.jpg';
            $icon = 'no-image.jpg';
        }
                
        $resized_icon = 'cache/' . $width . 'x' . $height . '/' . $icon;
        $iconDir = explode('/', $icon);
        $filename = array_pop($iconDir);
        $resized_dir = BASEPATH . '/' . $uploadsDir . '/cache/' . $width . 'x' . $height . '/' . implode('/', $iconDir);
        $resized_file = $resized_dir . '/' . $filename;

        if(!is_dir($resized_dir)) {
            mkdir($resized_dir, 0755, true);
        }
        
        if(file_exists($resized_file) && !$forceResize) {
            return $resized_icon;
        }
        
        $imgsize = getimagesize($original_file);
        if($imgsize[1] <= 0){
            $imgsize[1] = 1;
        }
        $situation = "pt";
        $img_ratio = $imgsize[0] / $imgsize[1];
        if($height == 0){
            $width = 1;
            $height = 1;
        }
        $thumb_ratio = $width / $height;
        if($img_ratio >= 1){
            if($thumb_ratio >= 1 ){
                if($img_ratio >= $thumb_ratio) $situation = "pt";
                elseif($img_ratio < $thumb_ratio) $situation = "pl";
            }
            elseif($thumb_ratio < 1 ){
                $situation = "pt";
            }
        }
        elseif($img_ratio < 1){
            if($thumb_ratio >= 1 ){
                $situation = "pl";
            }
            elseif($thumb_ratio < 1 ){
                if($img_ratio >= $thumb_ratio) $situation = "pt";
                elseif($img_ratio < $thumb_ratio) $situation = "pl";
            }
        }
        

        /*source*/
        if(($imgsize['mime'] == "image/jpeg") || ($imgsize['mime'] == "image/jpg")){
            $source = imagecreatefromjpeg($original_file);
            $imgtype = 1;
        }
        elseif($imgsize['mime'] == "image/png"){
            $source = imagecreatefrompng($original_file);
            $imgtype = 2;
        }
        elseif($imgsize['mime'] == "image/gif"){
            $source = imagecreatefromgif($original_file);
            $imgtype = 3;
        }
        else {
            return false;
        }
        
        $thumb = imagecreatetruecolor($width, $height);
        $logText = '';
        $logText .= 'situation: ' . $situation . '\n';
        
        if($crop){
            if($situation == "pl"){
                $src_w = $imgsize[0];
                $src_h = ceil($src_w * $height / $width);
                $src_x = 0;
                $src_y = ceil(($imgsize[1] - $src_h) / 2);
            }
            else{ //$situation == "pt"
                $src_h = $imgsize[1];
                $src_w = ceil($src_h * $width / $height);
                $src_y = 0;
                $src_x = ceil(($imgsize[0] - $src_w) / 2);
            }
            imagecopyresampled($thumb, $source, 0, 0, $src_x, $src_y, $width, $height, $src_w, $src_h);
        }
        else{

            if($situation == "pt"){
                $dst_w = $width;
                $dst_h = floor($dst_w / $imgsize[0] * $imgsize[1]);
                $dst_x = 0;
                $dst_y = floor(($height - $dst_h) / 2);
            }
            else{ //$situation == "pl"
                $dst_h = $height;
                $dst_w = floor($dst_h / $imgsize[1] * $imgsize[0]);
                $dst_y = 0;
                $dst_x = floor(($width - $dst_w) / 2);
            }
            
            $w_color = imagecolorallocate($thumb, 255, 255, 255);
            imagefilledrectangle($thumb, 0, 0, $width, $height, $w_color);
            
            imagecopyresampled($thumb, $source, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $imgsize[0], $imgsize[1]);
            
        }
        //file_put_contents('log-resize.txt', $logText);
        
        if(defined("THUMBS_QUALITY")) $quality = (int)THUMBS_QUALITY;
        else $quality = 85;
        
        if($imgtype == 1){
            $result = imagejpeg($thumb, $resized_file, $quality);
        }
        elseif($imgtype == 2){
            $compress_level = floor( (100 - $quality) / 10 );
            if($compress_level == 10) $compress_level = 9;
            $result = imagepng($thumb, $resized_file, $compress_level);
        }
        elseif($imgtype == 3){
            $result = imagegif($thumb, $resized_file);
        }
        
        imagedestroy($source);
        imagedestroy($thumb);
        
        if($result) return $resized_icon;
        return false;
        
    }

    public function crop($image, $x, $y, $width, $height){
        $uploadsDir = (isset($this->config['synchronized']) && $this->config['synchronized']) ? 'uploads-synchro' : 'uploads';
        $result = array();
        $result['success'] = false;
        $result['errors'] = array();

        $original_file = BASEPATH . '/' . $uploadsDir . '/' . $image;
        if(!file_exists($original_file)) return false;

        $imgsize = getimagesize($original_file);

        /*source*/
        if(($imgsize['mime'] == "image/jpeg") || ($imgsize['mime'] == "image/jpg")){
            $source = imagecreatefromjpeg($original_file);
            $imgtype = 1;
        }
        elseif($imgsize['mime'] == "image/png"){
            $source = imagecreatefrompng($original_file);
            $imgtype = 2;
        }
        elseif($imgsize['mime'] == "image/gif"){
            $source = imagecreatefromgif($original_file);
            $imgtype = 3;
        }
        else {
            $result['errors'][] = "Ошибка {$imgsize['mime']}";
            return $result;
        }

        $thumb = imagecreatetruecolor($width, $height);

        imagecopyresampled($thumb, $source, 0, 0, $x, $y, $width, $height, $width, $height);


        if(defined("THUMBS_QUALITY")) $quality = (int)THUMBS_QUALITY;
        else $quality = 85;

        if($imgtype == 1){
            $result_save = imagejpeg($thumb, $original_file, $quality);
        }
        elseif($imgtype == 2){
            $compress_level = floor( (100 - $quality) / 10 );
            if($compress_level == 10) $compress_level = 9;
            $result_save = imagepng($thumb, $original_file, $compress_level);
        }
        elseif($imgtype == 3){
            $result_save = imagegif($thumb, $original_file);
        }

        imagedestroy($source);
        imagedestroy($thumb);

        if($result_save) {
            $result['success'] = true;
            $result['content'] = $image;
        }

        return $result;
    }
    
    public function getUniqueName($dirUpload, $name, $i = 1){
        

        if(!is_dir($dirUpload)) {
            mkdir($dirUpload, 0755, true);
        }
        $i = (int)$i;
        $i_string = (string)$i;
        
        if(!file_exists($dirUpload . $name)) {
            return $name;
        }
        else{
            $length = 0;
            $pos = strrpos($name, ".");
            if($i > 1){
                $i_string_check = (string)($i - 1);
                $getPos = strrpos($name, $i_string_check);
                if($getPos !== false){
                    $pos = $getPos;
                    $length = strlen($i_string_check);
                }
            }
            $name = substr_replace($name, $i_string, $pos, $length);
            return $this->getUniqueName($dirUpload, $name, $i + 1);
        }
    }
    
    public function grab_image($url, $saveto){
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $raw=curl_exec($ch);
        curl_close ($ch);
        if(file_exists($saveto)){
            unlink($saveto);
        }
        $fp = fopen($saveto,'x');
        fwrite($fp, $raw);
        fclose($fp);
    }
    
    
    
	public function uploadMp3($path, $file, $alias = ''){
		$result = array();
        $result['success'] = false;
        $result['errors'] = array();
        
        if(!$this->validator->isSecure($file)){
            $result['errors'][] = "Такой файл запрещен для загрузки";
        }
        
        $fileType = $file["type"];
		if(($fileType != "audio/mpeg") && ($fileType != "audio/mp3") ) {
			$result['errors'][] = "Только mp3 файлы";
		}
        
        $fileSize = $file["size"];
		if($fileSize > Config::MAX_MUSIC_SIZE){
			$result['errors'][] = "Превышен максимальный размер файла: " . Config::MAX_MUSIC_SIZE / 1024 / 1024 . "МБ";
		}
        if(!$result['errors']){
            $ext = strrchr($file["name"],".");
            
            if(!$alias) $name = substr(preg_replace('/[^a-zA-Z0-9-]/', '', substr($file["name"], 0, -4)), 0, 64);
            else $name = substr(preg_replace('/[^a-zA-Z0-9-]/', '', $alias), 0, 64);
            if(!$name) $name = "1";
			$name .= $ext;
			
            $dir_upload = BASEPATH . '/' . Config::DIR_MEDIA . '/' . $path . '/';
            $name = $this->getUniqueName($dir_upload, $name, 1);
            //file_put_contents("log_images.txt",$name);
            
    		$upload_status = move_uploaded_file($file["tmp_name"], $dir_upload.$name);
            if($upload_status) {
                $result['success'] = true;
                $result['content'] = $path . '/' . $name;
            }
        }
        
        return $result;
	}

    public function translit($st, $coder = 'utf-8') {
        $st = mb_strtolower($st, $coder);
        $st = str_replace(array(
                '?','!','.',',',':',';','*','(',')','{','}','[',']','%','#','№','@','$','^','-','+','/','\\','=','|','"','\'',  
                'а','б','в','г','д','е','ё','з','и','й','к',  
                'л','м','н','о','п','р','с','т','у','ф','х',  
                'ъ','ы','э',' ','ж','ц','ч','ш','щ','ь','ю','я'  
            ), array(
                '_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_',  
                'a','b','v','g','d','e','e','z','i','y','k',  
                'l','m','n','o','p','r','s','t','u','f','h',  
                'j','i','e','_','zh','ts','ch','sh','shch','','yu','ya'  
            ), $st);
        $st = preg_replace('#[^a-z0-9_]#', '', $st);
        $st = trim($st, '_');
        $st = preg_replace('#_{2,}#', '_', $st);
        return $st;
    }
}

