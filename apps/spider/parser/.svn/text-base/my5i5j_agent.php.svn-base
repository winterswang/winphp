<?php
class my5i5j_agent extends parseHouseRule {
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
		$html = $this->htmlDom()->find('.broker_basicInfor_txt h3', 0);
		if($html){
		$title = $html->plaintext;
		return strip_tags($title);
		}
		return null;
	}
	//经纪人电话
	function getAgentTel(){
		$tel = 0; 
		$html = $this->htmlDom()->find('.broker_basicInfor_content1', 1);
		if($html && $html = $html->find('.fsize',0)){
			if(0 < preg_match_all('/(\d+)/', $html->plaintext, $extmatches)){
			   $tel = implode("",$extmatches[0]);
			}
		}
		return $tel;
	}
	function getAgentCompany(){
		return '5i5j';
	}
	//熟悉的小区
	function getAgentDistrict(){
		$districtList = '';
		$html = $this->htmlDom()->find('.broker_basicInfor_content1',0);
		if($html && $html = $html->find('.mr5')){
			foreach ($html as $key) {
					$key->plaintext.",";		
			}						
		}
		return trim($districtList,",");
	}
	//擅长业务
	function getAgentBusiness(){
		$business = '';
		$html = $this->htmlDom()->find('.broker_basicInfor_txt p',2);
		if($html && $html = $html->find('span')){
			foreach ($html as $key) {
					$business = $business.$key->plaintext.",";		
			}
		}
		return trim($business,",");
	}
	//熟悉的商圈
	function getAgentArea(){
		$area = $this->htmlDom()->find('.broker_basicInfor_content1',0);
		if($area && $area = $area->find('p',0)){			
			return trim($area->find('span',0)->plaintext);
		}
		return '';
	}

	function getAgentPhoto()
	{
		$agentPhoto = '';
		$html = $this->htmlDom()->find('.broker_basicInfor_img img',0);
		if($html){
			$agentPhoto = $html->src;
		}
		return $agentPhoto;
	}	

}