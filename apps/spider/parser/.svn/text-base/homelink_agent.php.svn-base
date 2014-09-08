<?php
class homelink_agent extends parseHouseRule {
	public $htmlDom;
	public $items = array();
	
	function htmlDom(){
		if(!$this->htmlDom){
			$simpleDom = new simpleHtmlExt();
			$this->htmlDom = $simpleDom->str_get_html($this->html_data);
		}
		return $this->htmlDom;
	}
	
	function check404(){
		$d = $this->htmlDom()->find('.top-info h1',0);
		if(!$d){
			return false;
		}
		$title = $d->innertext;
		return empty($title) == true;
	}
	//经纪人姓名
	function getAgentName(){//ok
		$title = '';
		$html = $this->htmlDom()->find('.stome h1', 0);
		if($html){
		$title = $html->plaintext;
		return strip_tags($title);
		}
		return null;
	}
	//经纪人电话
	function getAgentTel(){
		$tel = 0; 
		$html = $this->htmlDom()->find('.shuzhi ol', 0);
		if($html){
			if(0 < preg_match_all('/(\d+)/', $html->plaintext, $extmatches)){
			   $tel = implode("",$extmatches[0]);
			}
		}
		return $tel;
	}
	//经纪人等级
	function getAgentLevel(){
		$level = '';
		$html = $this->htmlDom()->find('.stome ul',0);
		if($html && $html = $html->find('li img',0)){
			$html = $html->getAttribute('src');
			if(0 < preg_match('/grade(\w+)/', $html, $extmatches)){
			   $level = $extmatches[1];	
			}
		}
		return $level;
	}
	//经纪人所属公司
	function getAgentCompany(){
		return 'homlink';
	}
	//熟悉的小区
	function getAgentDistrict(){
		$dis = $this->htmlDom()->find('.business ul',1);
		if($dis && $dis = $dis->find('li',1)){
			$dis = str_replace('&nbsp',' ',$dis->plaintext);
			return $dis;
		}
		return '';
	}
	//擅长业务
	function getAgentBusiness(){
		$business = '';
		$html = $this->htmlDom()->find('.business ul',2);
		if($html && $html = $html->find('li',1)){
			$business = $html->plaintext;
		}
		return $business;
	}
	//熟悉的商圈
	function getAgentArea(){
		$area = $this->htmlDom()->find('.business ul',0);
		if($area && $area = $area->find('li',1)){			
			return str_replace('&nbsp',' ',$area->plaintext);
		}
		return '';
	}
	//所属的实体店名
	function getAgentStore(){
		$store = $this->htmlDom()->find('.dianname dl',0);
		if($store && $store =$store->find('dd label',0)){
			return $store->plaintext;
		}
		return '';
	}
	//获取经纪人网店二级域名标识
	function getAgentUrl(){
		$agentUrl = '';
		$html = $this->htmlDom()->find('.crumbs a',2);
		if($html){
			if(0 < preg_match_all('/(\w+)/', $html->href, $extmatches)){
				$agentUrl = $extmatches[0][1];
			}
		}
		return $agentUrl;
	}

	function getAgentPhoto()
	{
		$agentPhoto = '';
		$html = $this->htmlDom()->find('.dianname dt',0);
		if($html){
			$agentPhoto = $html->find('img',0)->src;
		}
		return $agentPhoto;
	}
}