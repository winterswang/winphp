<?php

include(dirname(__FILE__).DIRECTORY_SEPARATOR.'MobileDetect.php');

class detectExt {
    
    public $detect = null;
    
    function isMobile(){
        if(!$this->detect){
            $this->detect = new MobileDetect();
        }
        
        return $this->detect->isMobile();
    }
}
?>