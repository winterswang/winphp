<?php

include(dirname(__FILE__).DIRECTORY_SEPARATOR.'Image.php');

class imageExt
{
    public $driver;

    public $params = array();
    
    public $errorCode = null;
    public $errorInfo = null;
    
    public function __construct($driver = 'GD',$params = array()){
        $this->driver = $driver;
        $this->params = $params;
    }
    
    public function load($image)
    {
        $config = array(
            'driver'=>$this->driver,
            'params'=>$this->params,
        );
        
        try{
            return new Image($image, $config);
        }catch(Exception $e){
            $this->errorCode = $e->getCode();
            $this->errorInfo = $e->getMessage();
        }
        
        return false;
    }
    
    function thumb($filepath, $width, $height, $savetype = 0)
    {

        if (!is_readable($filepath)) {
            $this->setError(1,'image not readable'); 
            return false;
        }
        
        $pathinfo = pathinfo($filepath);
        list($targetpath, $basename, $ext, $filename) = array_values($pathinfo);

        if (!is_writable($targetpath)) {
            $this->setError(1,'image not writable'); 
            return false;
        }
    
        if ($savetype == 1) {
            $targetpath = $targetpath . '/' . $width . 'x' . $height;
            if (!is_dir($targetpath)) {
                $res = @mkdir($targetpath, 0777);
                @touch($targetpath . '/index.html');
            }
    
            $targetfile = $targetpath . '/' . $filename . '.' . $ext;
        } else {
            $targetfile = $targetpath . '/' . $filename . '_' . $width . '.' . $ext;
        }
        
        $image = $this->load($filepath);
        if($image == false){
           $this->setError(1,'image is null'); 
           return false; 
        }
 
        try{
            $image->resize($width, $height); //->rotate(-45)->quality(75)->sharpen(20);
            
            $image->save($targetfile);
        
            clearstatcache();
            unset($image);
            return $targetfile;
        
        }catch(Exception $e){
            $this->setError($e->getCode(),$e->getMessage());  
        }
        
        clearstatcache();
        unset($image);
        return false;
    }
    
    // Imagemagick
    function mark($srcImg, $markImg){
    	if (!is_readable($srcImg)) {
    		$this->setError(1,'image not readable');
    		return false;
    	}
    		 
    	$pathinfo = pathinfo($srcImg);
    	list($targetpath, $basename, $ext, $filename) = array_values($pathinfo);
    		 
    	if (!is_writable($targetpath)) {
    		$this->setError(1,'image not writable');
    		return false;
    	}
    		
    	$cmd_crop = "convert ".$srcImg." -gravity southeast -crop 38%x30%+0+0 ".$targetpath."/crop.png";

    	$cmd_blur = "convert -blur 6x6 ".$targetpath."/crop.png ".$targetpath."/blur.png";
    	exec($cmd_blur);
    	
    	$cmd_merge_blur = "composite -gravity southeast ".$targetpath."/blur.png ".$srcImg." ".$srcImg;
    	exec($cmd_merge_blur);
    	
    	//get proper mark
    	list($srcImg_w, $srcImg_h) = @getimagesize($srcImg);
    	list($markImg_w, $markImg_h) = @getimagesize($markImg);
    	if ($srcImg_w < 208) {
    	    $ratio = 208/604;
    	}else{
    		$ratio = $srcImg_w/604;
    	}
        
    	$markImg_w_new = $ratio * $markImg_w;
    	$markImg_h_new = $ratio * $markImg_h;
    	$cmd_scale = "convert -sample ".$markImg_w_new." ".$markImg_h_new." ".$markImg." ".$targetpath."/newmark.png";
    	exec($cmd_scale);
    	
    	$start_y = $srcImg_h*0.7;
    	$cmd_merge_mark = "composite -gravity northeast -geometry 100%x100%+0+".$start_y." ".$targetpath."/newmark.png ".$srcImg." ".$srcImg;
    	exec($cmd_merge_mark);
    }

    function setError($code,$msg){
        $this->errorCode = $code;
        $this->errorInfo = $msg;  
    }
    
    public function getErrorCode(){
        return $this->errorCode;
    }
    
    public function getErrorMsg(){
        return $this->errorInfo;
    }    
}
?>
