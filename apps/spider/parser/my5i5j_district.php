<?php
class my5i5j_district  extends parseHouseRule {
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
		$d = $this->htmlDom()->find('.c-info h1',0);
		if(!$d){
			return false;
		}
		$title = $d->innertext;
		return empty($title) == true;
	}
	function getDistrictName(){
		$districtName = '';
		$html = $this->htmlDom()->find('.c-info h1',0);
		if($html){
			$districtName = $html->plaintext;
		}
		return $districtName;
	}
	function getDistrictAddress(){   
		$address = '';
		$html = $this->htmlDom()->find('.detail li',2);
		if($html){
			$address = strip_tags($html->plaintext);
			if(0 < preg_match_all('/([\x{4e00}-\x{9fa5}].\w+)/u', $address, $extmatches)){
				$address = $extmatches[0][1];
			}
		}
		return $address;
	}
	function getPhotos(){//ok
		$photos = array();
		$imgs = $this->htmlDom()->find('.flashbox img');
		if($imgs)
		{
			foreach ($imgs as $e){
				$photos[] = $e->src;
			}
		}
		return $photos;
	}
	//小区对应的区县
	// function getDistrictRegion(){
	// 	$districtRegin = '';
	// 	$html = $this->htmlDom()->find('.xtitle samp',0);
	// 	if($html && $html = $html->find('a',0)){
	// 		$districtRegin = strip_tags($html->plaintext);
	// 	}
	// 	return $districtRegin;		
	// }
	//小区对应的板块
	// function getDistrictArea(){
	// 	$districtArea = '';
	// 	$html = $this->htmlDom()->find('.xtitle samp',0);
	// 	if($html && $html = $html->find('a',1)){
	// 		$districtArea = strip_tags($html->plaintext);
	// 	}
	// 	return $districtArea;
	// }

	//物业类型
	function getManageType(){
		$manageType = '';
		$html = $this->htmlDom()->find('.detail li',3);
		if($html){
			if(0 < preg_match_all('/([\x{4e00}-\x{9fa5}].\w+)/u', $html->plaintext, $extmatches)){
				$manageType = $extmatches[0][1];
			}
		}
		return $manageType;
	}
	//占地面积
	function getArea(){
		$area = '';
		$html = $this->htmlDom()->find('.d-txt',2);
		if($html && $html = $html->find('li',1)){
			if(0 < preg_match('/(\d.*)|(\.+\d+)/', $html->plaintext, $extmatches)){
				$area = $extmatches[0];
			}
		}
		return $area;
	}
	//停车位
	function getParkingSpace(){
		$parkingSpace = '';
		$html = $this->htmlDom()->find('.d-txt',2);
		if($html && $html = $html->find('li',2)){
			if(0 < preg_match('/(\d.*)|(\.+\d+)/', $html->plaintext, $extmatches)){

				$parkingSpace = $extmatches[0];
			}
		}
		return $parkingSpace;
	}
	//物业公司
	function getManageCompany(){
		$manageCompany = '';
		$html = $this->htmlDom()->find('.d-txt',1);
		if($html && $html = $html->find('li',4)){
			if(0 < preg_match_all('/([\x{4e00}-\x{9fa5}]{2,})/u', $html->plaintext, $extmatches))
			{
				if(count($extmatches[0])>1)
					$manageCompany = $extmatches[0][1];
			}
		}
		return $manageCompany;
	}
	//容积率
	function getFloorRate(){
		$floorRate = '';
		$html = $this->htmlDom()->find('.d-txt',1);
		if($html && $html = $html->find('li',3)){
			if(0 < preg_match('/(\d.*)|(\.+\d+)/', $html->plaintext, $extmatches)){
				$floorRate = $extmatches[0];					
			}			
		}
		return $floorRate;
	}
	// //建筑面积
	function getBuildSquare(){
		$buildSquare = '';
		$html = $this->htmlDom()->find('.d-txt',1);
		if($html && $html = $html->find('li',1)){
			if(0 < preg_match('/(\d.*)|(\.+\d+)/', $html->plaintext, $extmatches)){
				$buildSquare = $extmatches[0];					
			}
		}
		return $buildSquare;
	}
	//建筑时间
	function getBuildTime(){
		$buildTime = '';
		$html = $this->htmlDom()->find('.d-txt',1);
		if($html && $html = $html->find('li',0)){
			if(0 < preg_match('/\d+[\x{4e00}-\x{9fa5}]+\d+[\x{4e00}-\x{9fa5}]/u', $html->plaintext, $extmatches)){
				$buildTime = $extmatches[0];
			}				
		}
		return $buildTime;
	}
	//物业费
	function getManageFee(){
		$manageFee = '';
		$html = $this->htmlDom()->find('.d-txt',2);
		if($html && $html = $html->find('li',0)){
			if(0 < preg_match('/(\d.*)|(\.+\d+)/', $html->plaintext, $extmatches)){
				$manageFee = $extmatches[0];
			}				
		}
		return $manageFee;
	}
	//开发商
	function getBuildCompany(){
		$buildCompany = '';
		$html = $this->htmlDom()->find('.d-txt',0);
		if($html && $html = $html->find('li',0)){
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]+/u', $html->plaintext, $extmatches)){
				if(count($extmatches[0])>1)
				$manageFee = $extmatches[0][1];
			}
		}
		return $buildCompany;
	}
	function getGreenRate(){
		$greenRate = '';
		$html = $this->htmlDom()->find('.d-txt',2);
		if($html && $html = $html->find('li',3)){
			if(0 < preg_match('/(\d.*)|(\.+\d+)/', $html->plaintext, $extmatches)){
				$greenRate = $extmatches[0].'%';					
			}			
		}
		return $greenRate;
	}
	// function getAgentUrl(){
	// 	$agentUrl = '';
	// 	$html = $this->htmlDom()->find('.broker_name',0);
	// 	if($html && $html = $html->find('a',0)){
	// 		if(0 < preg_match_all('/(\w+)/', $html->href, $extmatches)){
	// 			print_r($extmatches);
	// 			$agentUrl = $extmatches[0][1];
	// 		}
			
	// 	}
	// 	return $agentUrl;
	// }
	function getOverView(){
		$overView = '';
		$html = $this->htmlDom()->find('.intro span',1);
		if($html){
			$overView = $html->plaintext;
		}
		return $overView;
	}

	function getDistrictId(){
		$districtId = array();
		$html = $this->htmlDom()->find('.indetail');
		if($html){
			foreach ($html as $key) {
				if($key = $key->find('.homeimg a',0)){
					if(0 < preg_match('/\w{2,}/', $key->href, $extmatches)){
						$districtId[] = 'c-'.$extmatches[0];					
					}
				}
			}
		}
		return $districtId;
	}	
}