<?php
class spiderNode extends spiderCrawler{
	
	function getLimit(){
		return $this->getConfig('limit');
	}
	
	function getListUrl($page){
		$host = $this->getConfig('host');
		$page_prefix = $this->getConfig('page_prefix');
		$page_rule = $this->getConfig('page_rule');
		return str_replace(array('{host}','{page}'), array($host,$page_prefix.$page), $page_rule);
	}
	
	function getLinks(){
		$host = $this->getConfig('host');
		//$href_rule = $this->getConfig('href_rule');
		$href = $this->getConfig('href_rule');
		//$href = str_replace(array('{host}'), array($host), $href_rule);
		if(strpos($href,'{*}') === false && strpos($href,'{d}') === false){
				return array($href);
		}
		$pattern = preg_quote($href);//避免和正则表达式格式冲突
		$pattern = str_replace('\{\*\}','([^\'\">]*)',$pattern);
		$pattern = str_replace('\{d\}','(\d+)',$pattern);
		
		$htmlresult = $this->getHtmlResult();
		//preg_match_all('~'.$pattern.'~is',$htmlresult,$preg_rs);
		preg_match_all('%'.$pattern.'%',$htmlresult,$preg_rs);
		
		$links = array_unique($preg_rs[0]);
		foreach ($links as $k => $link){
				if (strpos($link, 'http://') === false) {
				$link = str_replace('amp;', '', $link);
				$links[$k] = $host.$link;
			}
		}

		unset($htmlresult);
		
		return $links;
	}

	function autoLink($relative,$referer){

		$pos = strpos($relative,'#');
		if($pos >0)
			$relative = substr($relative,0,$pos);

		if(preg_match('/^http:///i',$relative))
			return $relative;
		
		preg_match("/(http://([^/]*)(.*/))([^/#]*)/i", $referer, $preg_rs);
		$parentdir = $preg_rs[1];
		$petrol = $preg_rs[2].'://';
		$host = $preg_rs[3];
		
		if(preg_match('/^//i',$relative))
			return $petrol.$host.$relative;
		
		return $parentdir.$relative;
	}
}