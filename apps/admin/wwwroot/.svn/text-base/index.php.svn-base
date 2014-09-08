<?php

	if (!defined( "APP_NAME" )) {
		define( "APP_NAME", 'admin');
	}

	define('IS_DEBUG',1);
	
	$winbase = dirname(__FILE__)."/../../../classpath.php";
	require_once($winbase);

	if(IS_DEBUG){
		error_reporting(E_ALL);
	}
	
	define( "ROOT_APP_PATH", ROOT_TOP_PATH. "/apps/" . APP_NAME);
	define( "ROOT_PRO_PATH", ROOT_APP_PATH . "/phproot");
	define( "ROOT_STATIC_PATH", ROOT_APP_PATH . "/wwwroot");	

	$config = require(ROOT_PRO_PATH."/config/config.php");
	
	winBase::createApp($config)->process();
?>