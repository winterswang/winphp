<?php
class spiderCrawler {
	
	public $target;
	public $config;
	public $charset = 'utf-8';
	public $htmlresult = null;
	public $curl_info = array();
	
	function __construct($target){
		$config = Config::getConfig('node',$target);
		if(empty($config)){
			throw new Exception('no target found');
		}
		
		$this->setCharset($config['charset']);
		
		$this->config = $config;
		$this->target = $target;
	}
	
	function getConfig($key){
		return isset($this->config[$key]) ? $this->config[$key] : null;
	}
	
	function getCurl($url){
		return new Curl($url);
	}
	
	function setCharset($charset){
		$this->charset = $charset;
	}
	
	function clawler($url,$method = 'get'){
		$this->clear();
		
		$curl = $this->getCurl($url);
		$res = $curl->$method();
		$this->curl_info = $curl->getHttpInfo();
		
		if(!$res){
			return false;
		}
		if($this->charset !== 'utf-8'){
			$res = iconv($this->charset,'utf-8',$res);
		}		
		$this->setHtmlResult($res);
		unset($res);
		return true;
	}

	function setHtmlResult($data){
		$this->htmlresult = $data;
	}
	
	function getHtmlResult($cut = false){
		$htmlresult = $this->htmlresult;
	
		if($cut && isset($this->config['html_area'])){
			echo "is this work?";
			$pattern = preg_quote($this->config['html_area']);
			$pattern = str_replace('\{\*\}','(.*)',$pattern);
			preg_match('~'.$pattern.'~is',$htmlresult,$preg_rs);
			$htmlresult = isset($preg_rs[1]) ? $preg_rs[1] : '';
		}
		return $htmlresult;
	}
	
	function clear(){
		$this->htmlresult = null;
	}
	
}