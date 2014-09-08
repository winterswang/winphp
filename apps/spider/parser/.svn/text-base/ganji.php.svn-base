<?php
class ganji extends parseHouseRule implements iHouseRule {

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
	
	function items($label){//ok
		if(empty($this->items)){
			$items_p = $this->htmlDom()->find('.mid-info',0)->innertext;
				
			//preg_match('/<!-- detail list start -->(.*)<!-- detail list end -->/i', $items_ul, $extmatches);
			preg_match_all('/<p[^>]*?>(.*)<\/p>/iU', $items_p, $lis);
	
			if(isset($lis[1]) && !empty($lis[1])){
				foreach($lis[1] as $li){
					$li = str_replace('<span>', '', $li);
					$li = str_replace('</span>', '', $li);
					list($key,$value) = explode(':',$li);
					$this->items[$key] = $value;
				}
			}
		}
	
		if(isset($this->items[$label])){
			return $this->items[$label];
		}
	
		return false;
	}
	
	function getTitle(){//ok
		$title = $this->htmlDom()->find('.top-info h1', 0)->innertext;
		return strip_tags($title);
	}
	
	function getDesc(){//ok
		$ps = $this->htmlDom()->find('.detail-info p');
		$e = array_pop($ps);

		$text = $e->plaintext;
		$arr = explode("\n",$text);
		
		$desc = '';
		foreach($arr as $v){
			$desc.=$v;
		}

		return $desc;
	}
	
	function getRentPrice(){//ok
		$html = $this->items('价格');
		if (!$html) {
			$html = $this->items('租金');
		}
		
		$price = 0;
		if($html !== false){
			preg_match('/(\d+)/i', $html, $extmatches);
			$price = !isset($extmatches[1]) ? 0 : $extmatches[1];
		}
		
		return $price;
	}
	
	function getRoom(){//ok,室
		$html = $this->items('房型');

		$room = 0;
		if($html !== false){
			if(0 < preg_match('/(\d+)室.*/i', $html, $extmatches)){
			   $room = $extmatches[1];	
			}
		}
		
		return $room;
	}
	
	function getHall(){//ok,室
		$html = $this->items('房型');

		$room = 0;
		if($html !== false){
			if(0 < preg_match('/.*(\d+)厅.*/i', $html, $extmatches)){
			   $room = $extmatches[1];	
			}
		}
		
		return $room;
	}	
	
	function getWc(){//ok,卫
		$html = $this->items('房型');

		$wc = 0;
		if($html !== false){
			if(0 < preg_match('/.*(\d)卫/i', $html, $extmatches)){
			   $wc = $extmatches[1];	
			}
		}
		
		return $wc;
	}
	
	function getFloor(){//ok
		$html = $this->items('楼层');
		$floor = '0/0';
		if($html !== false){
			$arr = explode('/',$html);
			foreach($arr as $k => $v){
				if(($pos = strpos($v,'层')) !== false){
					$arr[$k] = trim($arr[$k],'层');
				}
			}
			if (isset($arr[1])) {
				return $arr[0].'/'.$arr[1];
			}elseif (isset($arr[0])){
				return $arr[0].'/0';
			}
		}
		return $floor;
	}
	
	function getSquare(){//ok
		$html = $this->items('房屋情况');
		
		$square = 0;
		if($html !== false){
			$arr = explode('/',$html);
			$square = trim($arr[0],'㎡');
		}
		
		return $square;
	}

	function getProvides(){//ok
		$html = $this->items('配置');
		
		$provides = '';
		if ($html !== false) {
			$html = trim($html);
			$provides = str_replace('  ',',',$html);
		}
		return $provides;
	}
	
	function getPhotos(){//ok
		$photos = array();
		$imgs = $this->htmlDom()->find('.J_imgContainer img');
		foreach ($imgs as $e){
			$photos[] = $e->bigsrc;
		}
		return $photos;
	}	

	function getArea(){//ok
		$html = $this->items('区域');

		$area = '';
		if($html !== false){
			$area_html = strip_tags($html);
			$area_arr = explode('-',$area_html);
			$area = trim($area_arr[0]);
		}
		return $area;
	}
	
	function getZone(){//ok
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
	
	function getDistrict(){//ok
		$html = $this->items('小区');
		
		$district = '';
		if($html !== false){
			$district = trim($html);
			$district = preg_replace('/\([\s\S]*\)/i',"",$district); 
		}
		return $district;
	}
	
	function getAddress(){//ok
		$html = $this->items('地址');
		
		$address = '';
		if($html !== false){
			$address = trim($html);
			$address = preg_replace('/\([\s\S]*\)/i',"",$address); 
		}

		return $address;
	}
	
	function getMobile(){//ok
		$mobile = 0;
		$html = $this->htmlDom()->find('.gj-detail-ntip a', 0)->href;
		if($html){
			$mobile = trim($html,'tel:');
		}
		return $mobile;
	}
	
	function getWho(){//ok
		$who = '';
		$html = $this->htmlDom()->find('.gj-detail-ntip p', 0)->plaintext;
		if($html){
			$arr = explode(':', $html);
			$who = preg_replace('/\([\s\S]*\)/i',"",$arr[1]);
		}
		return $who;
	}
	
	function getGender(){//ok
		$gender = 1;
		$html = $this->getWho();
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
		$dateline = 0;
		
		$html = $this->htmlDom()->find('.top-info p', 0)->innertext;
		if($html){
			$arr = explode('&nbsp;', $html);
			if(preg_match('/(\d{2})-(\d{2})\s+(\d{2}):(\d{2})/', $arr[0], $matches)){
				return mktime($matches[3], $matches[4],'01', $matches[2], $matches[1], date('Y'));
			}
		}
		return $dateline;
	}	
}