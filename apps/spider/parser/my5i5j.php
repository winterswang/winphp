<?php
class my5i5j  extends parseHouseRule {
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

	function getTitle(){
		$html = $this->htmlDom()->find('.title h1', 0);
		if($html){
			$title = $html->plaintext;
			return trim(strip_tags($title));
		}
		return null;
	}
	function getSellPrice(){
		$price = 0;
		$html = $this->htmlDom()->find('.detail li', 0);
		if($html && $html = $html->find('b',0) ){
			return $html->plaintext;
		}
		return $price;
	}
	function getMmPrice(){
		$averagePrice = 0;
		$html = $this->htmlDom()->find('.detail li', 1);
		if($html && $html = $html->find('span',0)){
			if(0 < preg_match('/(\d+)/', $html->find('b',0)->plaintext, $extmatches)){
			   $averagePrice = $extmatches[0];	
			}
		}
		return $averagePrice;
	}

	function getSquare(){//ok		
		$square = 0;
		$html = $this->htmlDom()->find('.detail li', 1);
		if($html && $html = $html->find('span',1)){
			if(0 < preg_match('/(\d+)/',$html->find('b',0)->plaintext, $extmatches)){
				$square = $extmatches[0];	
		 	}
		}
		return $square;
	}

	function getRoom(){
		$html = $this->htmlDom()->find('.detail li', 3);
		$room = 0;
		if($html){
			if(0 < preg_match('/(\d+)室.*/i', $html->plaintext, $extmatches)){
			   $room = $extmatches[1];	
			}
		}
		return $room;
	}

	function getHall(){
		$html = $this->htmlDom()->find('.detail li', 3);
		$hall = 0;
		if($html){
			if(0 < preg_match('/(\d+)厅.*/i', $html->plaintext, $extmatches)){
			   $hall = $extmatches[1];	
			}
		}
		return $hall;
	}
	function getWc(){
		$html = $this->htmlDom()->find('.detail li', 3);
		$wc = 0;
		if($html){
			if(0 < preg_match('/(\d+)卫.*/i', $html->plaintext, $extmatches)){
			   $wc = $extmatches[1];	
			}
		}
		return $wc;
	}
	function getOrientation(){
		$orientation = '';
		$html = $this->htmlDom()->find('.detail li', 4);
		if($html){
			if(0 < preg_match_all('/([\x{4e00}-\x{9fa5}]+)相似朝向/u', $html->plaintext, $extmatches)){
				$orientation = $extmatches[1][0];
			}
		}
		return $orientation;
	}

	function getFloorOn(){
		$floorOn = '';
		$html = $this->htmlDom()->find('.detail li', 5);
		 if($html){
			if(0 < preg_match('/(\d+[\x{4e00}-\x{9fa5}]+)/u', $html->plaintext, $extmatches)){
			   $floorOn = $extmatches[0];	
			}
		}
		return $floorOn;
	}
	function getFloorAll(){//ok
		$floorAll = 0;
		$html = $this->htmlDom()->find('.detail li', 5);
		if($html){
			if(0 < preg_match('/\d+/i', $html->plaintext, $extmatches)){
			   $floorAll = $extmatches[0];	
			}
		}
		return $floorAll;
	}
	function getDistrictName(){
		$districtName = '';
		$html = $this->htmlDom()->find('.detail li', 6);
		if($html){
			if(0 < preg_match_all('/([\x{4e00}-\x{9fa5}]+)本小区/u', $html->plaintext, $extmatches)){
			   $districtName = $extmatches[1][0];	
			}
		}

		return $districtName;
	}
	function getDistrictId(){
		$districtId = '';
		$html = $this->htmlDom()->find('.detail li', 6);
		if($html && $html = $html->find('span a',0)){
			if(0 < preg_match('/(\d+)/i', $html->href, $extmatches)){
			   $districtId = $extmatches[0];	
			}
		}
		return $districtId;
	}
	function getMobile(){//ok
		$mobile = 0;
		$html = $this->htmlDom()->find('.location dd', 1);
		if($html && $html = $html->find('span',0)){
			$mobile = trim($html->plaintext);
		}
		return $mobile;
	}
	function getAgentId(){
		$agentId = '';
		$html = $this->htmlDom()->find('.location dd', 0);
		if($html && $html = $html->find('a',0 )){
			if(0 < preg_match('/(\d+)/', $html->href, $extmatches)){
			   $agentId = $extmatches[0];	
			}
		}
		return $agentId;
	}
	function getAgentName(){//ok
		$who = '';
		$html = $this->htmlDom()->find('.location dd', 0);
		if($html && $html = $html->find('b',0)){
			return $html->plaintext;
		}
		return $who;
	}
	function getFitment(){
		$fitment='';
		$html = $this->htmlDom()->find('.d-txt2', 0);
		if($html && $html = $html->find('li',3)){
			if(0 < preg_match_all('/([\x{4e00}-\x{9fa5}]+)/u', $html->plaintext, $extmatches)){
				if(count($extmatches[0])>1)
			   		$fitment = $extmatches[0][1];	
			}
			return trim($fitment);
		}
		return '';
	}

	function getPhotos(){//ok
		$photos = array();
		$imgs = $this->htmlDom()->find('.pic img');
		if(!empty($imgs))
		{
			foreach ($imgs as $e){
				$photos[] = $e->src;
			}
		}
		return $photos;
	}

	function getOnsellAgent(){
		$agentList = '';
		$html = $this->htmlDom()->find('.groom');
		if($html){
			foreach ($html as $key => $value) {
				$value = $value->find('dt a',0);
				if($value){
					if(0 < preg_match('/(\d+)/i', $value->href, $extmatches)){
						$agentList.= $extmatches[0].',';
					}
				}
			}		
		}
		return trim($agentList,",");
	}	
}