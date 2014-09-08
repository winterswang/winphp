<?php
class urlAssign {
    
    public static $urls = array();
 	 	 	 	 
    public static function loadUrls()
    {
		if(empty(self::$urls)){
			$setting = Config::getConfig('system');
			if(is_array($setting['attach_url'])){
				self::$urls = $setting['attach_url'];
			}else{
				self::$urls = array($setting['attach_url']);
			}
		}
		
		return self::$urls;
    }
    
    public static function getUrl($attachment,$size=0){
		$urls = self::loadUrls();
		$l = array_rand($urls);
		
		if($size > 0){
			$setting = WinBase::app()->getSetting('setting');

			$path_arr = pathinfo($attachment);
			
			$attachment = $path_arr['dirname']."/".$path_arr['filename']."_".$size.".".$path_arr['extension'];
			if(!is_file($setting['attach_path']."/".$attachment)){
				
				if($size == 120){
					$attachment = $path_arr['dirname']."/".$path_arr['filename']."_208.".$path_arr['extension'];
				}else if($size == 600){
					$attachment = $path_arr['dirname']."/".$path_arr['filename']."_604.".$path_arr['extension'];
				}
			}
			
			if(!is_file($setting['attach_path']."/".$attachment)){
				return Config::getConfig('system','default_photo');
			}
		}
		return self::$urls[$l] .'/'. $attachment;
    }

}
