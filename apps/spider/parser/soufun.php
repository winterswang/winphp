<?php
class soufun extends parseHouseRule implements iHouseRule {

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
		return preg_match('/您找的信息不存在了/i',$this->html_data);
	}
	
	
	function getTitle(){//ok
		$title = '';
		$html = $this->htmlDom()->find('.title', 0);
		if((!empty($html)) && $html = $html->find('h1', 0)){
		$title = $html->plaintext;
		}
		return strip_tags($title);//
	}

	function getLabel(){
		$label = array();
		$html = $this->htmlDom()->find('.note', 0);
		if($html && $html =$html->find('span')){
			foreach ($html as $key ) {
				$label[] = $html->plaintext;
			}
		}
		return implode(",", $label);
	}

	function getSellPrice(){
		$sellPrice = 0;
		$html = $this->htmlDom()->find('.base_info dl',0);
		if(!empty($html) && $html = $html->find('dt',0)){
			$sellPrice = $html->find('span',1)->plaintext;
		}
		return $sellPrice;
	}

	function getFirstPayment(){
		$firstPayment = 0;
		$html = $this->htmlDom()->find('.base_info dl',0);
		if(!empty($html) && $html = $html->find('dd',0)){
			$firstPayment = $html->find('span',0)->plaintext;
		}
		return $firstPayment;
	}

	function getMonthPayment(){
		$monthPayment = 0;
		$html = $this->htmlDom()->find('.YG',0);
		if(!empty($html) && $html = $html->find('span',0)){
			$monthPayment = $html->plaintext;
		}
		return $monthPayment;
	}
	function getHall(){
		$hall = 0;
		$html = $this->htmlDom()->find('.base_info dl',0);
		if(!empty($html) && $html = $html->find('dd',2)){
			if(0 < preg_match('/(\d+)厅/', $html->plaintext, $extmatches)){
			   $hall = $extmatches[1];	
			}
		}		
		return $hall;
	}
	function getRoom(){//ok
		$room = 0;
		$html = $this->htmlDom()->find('.base_info dl',0);
		if(!empty($html) && $html = $html->find('dd',2)){
			if(0 < preg_match('/(\d+)室/', $html->plaintext, $extmatches)){
			   $room = $extmatches[1];	
			}
		}		
		return $room;
	}
	
	function getWc(){//ok
		$wc = 0;
		$html = $this->htmlDom()->find('.base_info dl',0);
		if(!empty($html) && $html = $html->find('dd',2)){
			if(0 < preg_match('/(\d+)卫/', $html->plaintext, $extmatches)){
			   $wc = $extmatches[1];	
			}
		}
		
		return $wc;
	}

	function getSquare(){//ok	
		$square = 0;
		$html = $this->htmlDom()->find('.base_info dl',0);
		if(!empty($html) && $html = $html->find('dd',3)){
			if(0 < preg_match('/(\d+)/', $html->find('span',0)->plaintext, $extmatches)){
			   $square = $extmatches[1];	
			}
		}
		
		return $square;
	}	

	function getOrientation(){
		$orientation = '';
		$html = $this->htmlDom()->find('.base_info dl',1);
		if(!empty($html) && $html = $html->find('dd',1)){
			$orientation = $html->plaintext;
		}
		return $orientation;
	}

	function getFloorOn(){//ok
		$floorOn = '';
		$html = $this->htmlDom()->find('.base_info dl',1);		
		if(!empty($html) && $html = $html->find('dd',2)){
			if(0 < preg_match_all('/(\d+)/', $html->plaintext, $extmatches)){	
				$floorOn = $extmatches[0][1];
			}	
		}
		return $floorOn;
	}

	function getFloorAll(){//ok
		$floorAll = '';
		$html = $this->htmlDom()->find('.base_info dl',1);		
		if(!empty($html) && $html = $html->find('dd',2)){
			if(0 < preg_match_all('/(\d+)/', $html->plaintext, $extmatches)){	
				$floorAll = $extmatches[0][2];
			}	
		}
		return $floorAll;
	}

	function getFitment(){
		$fitment = '';
		$html = $this->htmlDom()->find('.base_info dl',1);	
		if(!empty($html) && $html = $html->find('dd',3)){			
			$fitment = $html->plaintext;
		}
		return $fitment;		
	}
	function getDistrictId(){
		$districtId = '';
		$html = $this->htmlDom()->find('.base_info dl',1);
		if(!empty($html) && $html = $html->find('dt',0)){
			if(0 < preg_match('%/(\w+)%', $html->find('a',0)->href, $extmatches)){
			   $districtId = $extmatches[1];	
			}			
		}
		return $districtId;					
	}	
	function getDistrictName(){
		$districtName = '';
		$html = $this->htmlDom()->find('.base_info dl',1);
		if(!empty($html) && $html = $html->find('dt',0)){
			$districtName = $html->find('a',0)->plaintext;			
		}
		return $districtName;	
	}
	
	function getPhotos(){
		$photos = array();
		$html = $this->htmlDom()->find('#esfbjxq_117 a',0)->find('img',0);
		$photos[] = $html->src;
		$imgs = $this->htmlDom()->find('#esfbjxq_116 a');
		foreach ($imgs as $e){
				$photos[] = $e->href;			
		}
		return $photos;
	}		
	
	function getMobile(){//ok
		$mobile = 0;
		$html = $this->htmlDom()->find('.phone_top',0);
		if(!empty($html) && $html = $html->find('span',0)){
			preg_match('/(\d+)/i', $html->plaintext, $extmatches);
			$mobile = !isset($extmatches[1]) ? 0 : $extmatches[1];
		}
		return $mobile;
	}
	
	function getAgentUrl(){//ok,xx
		$agentUrl = '';
		$html = $this->htmlDom()->find('.rzlogo04',0);	
		if(!empty($html) && $html = $html->find('a',0)){
			if(0 < preg_match_all('%/(\w+)%', $html->href, $extmatches)){
			   $agentUrl = $extmatches[0][2];	
			}			
		}	
		return $agentUrl;
	}

}