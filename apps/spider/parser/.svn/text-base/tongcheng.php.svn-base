<?php
class tongcheng extends parseHouseRule implements iHouseRule {

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
	
	function items($label){

		if(empty($this->items)){
			$items_ul = $this->htmlDom()->find('.detail_w ul.attr_info',0)->innertext;
			
			preg_match('/<!-- detail list start -->(.*)<!-- detail list end -->/i', $items_ul, $extmatches);
			preg_match_all('/<li[^>]*?>(.*)<\/li>/iU', $extmatches[1], $lis);

			if(isset($lis[1]) && !empty($lis[1])){
				foreach($lis[1] as $li){
					list($key,$value) = explode('：',$li);
					$this->items[$key] = $value;
				}
			}
		}

		if(isset($this->items[$label])){
			return $this->items[$label];
		}
		
		return false;
	}
	
	function getTitle(){
		$title = $this->htmlDom()->find('.tit_area', 0)->find('h1', 0)->innertext;
		return strip_tags($title);
	}
	
	function getDesc(){
		$ps = $this->htmlDom()->find('.detail_txt p');
		$e = array_pop($ps);

		$text = $e->plaintext;
		$arr = explode("\n",$text);
		
		$desc = '';
		foreach($arr as $v){
			if(($pos = strpos($v,'详细描述')) !== false){
				continue;
			}
			
			if(($pos = strpos($v,'58同城')) !== false){
				continue;
			}
			
			$desc.=$v;
			
		}

		return $desc;
	}
	
	function getRentPrice(){
		$html = $this->items('租金');
		
		$price = 0;
		if($html !== false){
			preg_match('/<strong[^>]*?>(\d+)<\/strong>/i', $html, $extmatches);
			$price = !isset($extmatches[1]) ? 0 : $extmatches[1];
		}
		
		return $price;
	}
	
	function getRoom(){
		$html = $this->items('户型');

		$room = 0;
		if($html !== false){
			$arr = explode('&nbsp;&nbsp;&nbsp;&nbsp;',$html);
			if(0 < preg_match('/(\d+)室.*/i', $arr[0], $extmatches)){
			   $room = $extmatches[1];	
			}
		}
		
		return $room;
	}
	
	function getHall(){
		$html = $this->items('户型');

		$hall = 0;
		if($html !== false){
			$arr = explode('&nbsp;&nbsp;&nbsp;&nbsp;',$html);
			if(0 < preg_match('/.*(\d)厅.*/i', $arr[0], $extmatches)){
			   $hall = $extmatches[1];	
			}
		}
		
		return $hall;
	}	
	
	function getWc(){
		$html = $this->items('户型');

		$wc = 0;
		if($html !== false){
			$arr = explode('&nbsp;&nbsp;&nbsp;&nbsp;',$html);
			if(0 < preg_match('/.*(\d)卫/i', $arr[0], $extmatches)){
			   $wc = $extmatches[1];	
			}
		}
		
		return $wc;
	}
	
	function getFloor(){
		$html = $this->items('类型');
		$floor = '0/0';
		if($html !== false){
			$arr = explode('&nbsp;&nbsp;&nbsp;&nbsp;',$html);
			foreach($arr as $v){
				if(($pos = strpos($v,'层')) !== false){
					$floor = trim($arr[1],'层');
					break;
				}
			}
		}
		
		return $floor;
	}
	
	function getSquare(){
		$html = $this->items('户型');
		
		$square = 0;
		if($html !== false){
			$arr = explode('&nbsp;&nbsp;&nbsp;&nbsp;',$html);
			$square = trim($arr[1],'㎡');
		}
		
		return $square;
	}

	function getProvides(){
		$ps = $this->htmlDom()->find('.detail_txt p');
		if(count($ps) < 2){
			return '';
		}
		
		$provides = '';
		
		$text = $this->htmlDom()->find('.detail_txt p', 0)->plaintext;
		$arr = explode("\n",$text);
		$provides = trim($arr[1]);
		return $provides;
	}
	
	function getPhotos(){
		$photos = array();
		$imgs = $this->htmlDom()->find('.image_area img');
		foreach ($imgs as $e){
			$photos[] = str_replace('tiny', 'big', $e->ref);;
		}
		return $photos;
	}	

	function getArea(){
		$html = $this->items('区域');

		$area = '';
		if($html !== false){
			$area_html = strip_tags($html);
			$area_arr = explode('-',$area_html);
			$area = trim($area_arr[0]);
		}
		return $area;
	}
	
	function getZone(){
		$html = $this->items('区域');
		
		$zone = '';
		if($html !== false){
			$area_html = strip_tags($html);
			$area_arr = explode('-',$area_html);
			if(!isset($area_arr[1])){
				return '';
			}
			$zone = trim($area_arr[1]);
			$zone = preg_replace('/\([\s\S]*\)/i',"",$zone); 
		}
		
		return $zone;
	}
	
	function getDistrict(){
		$html = $this->items('小区');
		
		$district = '';
		if($html !== false){
			$district = trim($html);
			$district = $this->strip_tags_content($district,'<span>');
			$district = preg_replace ('/<[^>]*>/', '', $district); 
			$district = preg_replace('/\([\s\S]*\)/i',"",$district);
		}
		return trim($district);
	}
	
	function getAddress(){
		$html = $this->items('地址');
		
		$address = '';
		if($html !== false){
			$address = trim($html);
			$address = preg_replace('/\([\s\S]*\)/i',"",$address); 
		}

		return $address;
	}
	
	function getMobile(){
		$mobile = 0;
		$html = $this->htmlDom()->find('.attr_info a', 1)->href;
		if($html){
			$mobile = trim($html,'tel:');
		}
		return $mobile;
	}
	
	function getWho(){
		$who = '';
		$html = $this->htmlDom()->find('.attr_info', 1)->find('a',0)->innertext;
		if($html){
			$who = preg_replace('/\([\s\S]*\)/i',"",$html);
		}
		return $who;
	}
	
	function getGender(){
		$gender = 1;
		$html = $this->htmlDom()->find('.attr_info a', 1)->innertext;
		if($html){
			if(($pos = strpos($html,'先生')) !== false){
				$gender = 1;
			}else if(($pos = strpos($html,'小姐')) !== false){
				$gender = 2;
			}else if(($pos = strpos($html,'女士')) !== false){
				$gender = 2;
			}
		}
		return $gender;
	}
	
	function getDateline(){
		return 0;
	}
}