<?php
class authValidate {

	public $authType = 'MD5';
	public $version = '1.0.0';
	public $max_timestamp_skew = 5;			
			
	private $_error_code = 0;
	private $_error_info = '';
	
	private $_params = array();
	
	function setError($code,$info = ''){
		$this->_error_code = $code;
		$this->_error_info = $info;
	}
	
	function getError(){
		return array('code'=>$this->_error_code,'info'=>$this->_error_info);
	}
	
	function base64decode($str) {
		return base64_decode(strtr($str.str_repeat('=', (4 - strlen($str) % 4)), '-_', '+/'));
	}	
	
	public function validate(){
		$headers = WinBase::app()->getRequest()->getHeaders();
		
		//check oauth_version
		//$this->getParam('version') != 1.0
		
		$clientId = isset($headers['clientid']) ? $headers['clientid'] : null;
		if(($secret = $this->_validate_Client($clientId)) == false){
			return false;
		}
		
		if(!$this->_validate_Signature($secret)){
			return false;
		}
		
		$timeStamp = isset($headers['timestamp']) ? $headers['timestamp'] : null;
		/*if(!$this->_validate_timestamp($timeStamp)){
			return false;
		}*/

		$required = array('uuid','osversion','platform','model','latlng');

		foreach ($required as $req) {
			if (!isset($headers[$req])) {
				$this->setError('9005','Can\'t verify request, missing parameter "'.$req.'"');
				return false;
			}
		}
		
		return true;
	}
	
	private function _validate_Client($client_id){
		if(!$client_id){
			$this->setError('9008');
			return false;
		}
		
        if ($client = app::model()->getClient($client_id)) {
            return $client['client_secret'];
        }
		
		$this->setError('9009');
		return false;
	}
	
	private function _validate_timestamp($timestamp) {
		if( ! $timestamp ){
			$this->setError('9010');
			return false;
		}
	
		$now = time();
		if (abs($now - $timestamp) > $this->max_timestamp_skew) {
			$this->setError('9011');
			return false;
		}
		return true;
	}
	
	private function _validate_Version($version){
		//$version != 1.0
		return true;
	}
	
	private function _validate_Signature($secret){
		return true;
		$sign = WinBase::app()->getRequest()->getParam('sign');
		if(!$sign){
			$this->setError('9004');
			return false;
		}

		if($this->authType == 'MD5'){
			$request = WinBase::app()->getRequest()->getParams();
			unset($request['sign']);
			ksort($request); //uksort($request, 'strcmp');   
			$sign_str = ""; 
			foreach($request as $k=>$v){
				$sign_str .="$k$v";
			}
			$sign_str .= $secret;
			
			if(md5($sign_str) == $sign){
				return true;
			}
		}
		
		$this->setError('9005');
		
		return false;
	}
	
}
