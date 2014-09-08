<?php

include(dirname(__FILE__).DIRECTORY_SEPARATOR.'ikuaizuApi.php');

define( "IKUAIZU_AKEY" , '1003' );
define( "IKUAIZU_SKEY" , 'ceb8424d0b358ff461ed6be61c4ef8e1' );

class serverExt
{
    private $_api;
    
    public $version = '1.0';

    function __construct($uuid){
        
        $header = array(
			'osVersion' => $this->version,
			'uuid' => $uuid
		);
        
		$this->_api = new ikuaizuApi(IKUAIZU_AKEY,IKUAIZU_SKEY,$header);
    }
    
    public function api(){
        return $this->_api;
    }
}