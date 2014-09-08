<?php
class tongcheng extends parseHouseRule implements iHouseRule {

	public $htmlDom;
	public $items;
	
	function htmlDom(){
		if(!$this->htmlDom){
			$simpleDom = new simpleHtmlExt();
			$this->htmlDom = $simpleDom->str_get_html($this->html_data);
		}
		return $this->htmlDom;
	}
	
	function items($label){
		static $items = array();
		if(empty($items)){
			$items_html = $this->htmlDom()->find('div.sumary ul',0)->children();
			foreach($items_html as $e){
				$key = $e->find('.su_tit',0)->innertext;
				$items[$key] = $e;
			}
		}

		foreach($items as $key => $dom){
			if(preg_match('/'.$label.'/', $key)){
				return $dom;
			}
		}
		
		return false;
	}
	
	function getTitle(){
		$title = $this->htmlDom()->find('.mainTitle', 0)->find('h1', 0)->innertext;
		return trim($title);
	}
	
	function getDesc(){
		$description = $this->htmlDom()->find('.description_con', 0)->plaintext;
		$description = str_replace("联系我时，请说是在58同城上看到的，谢谢！", "", $description);
		return trim($description);
	}
	
	function getRentPrice(){
		$e = $this->items('租金价格');

		$price = 0;
		if($e !== false){
			$price = $e->find('.bigpri', 0)->innertext;
		}
		
		return $price;
	}
	
	function getRoom(){
		$e = $this->items('房屋户型');

		$room = 0;
		if($e !== false){
			$text = $e->find('.su_con', 0)->innertext;

			$arr = explode(' ',trim($text));
			foreach($arr as $v){
				$v = trim($v);
				if(0 < preg_match('/(\d+)室/i', $v, $extmatches)){
				   $room = $extmatches[1];	
				}
			}
		}
		
		return $room;
	}
	
	function getWc(){
		$e = $this->items('房屋户型');

		$wc = 0;
		if($e !== false){
			$text = $e->find('.su_con', 0)->innertext;

			$arr = explode(' ',trim($text));
			foreach($arr as $v){
				$v = trim($v);
				if(0 < preg_match('/(\d+)卫/i', $v, $extmatches)){
				   $wc = $extmatches[1];	
				}
			}
		}
		
		return $wc;
	}
	
	function getFloor(){
		$e = $this->items('所属楼层');
		$floor = '';
		if($e !== false){
			$text = $e->find('.su_con', 0)->innertext;
			$floor = str_replace('层','',$text);
		}
		
		return $floor;
	}
	
	function getSquare(){
		$e = $this->items('房屋户型');
		
		$square = 0;
		if($e !== false){
			$text = $e->find('.su_con', 0)->innertext;
			
			$arr = explode(' ',trim($text));
			foreach($arr as $v){
				$v = trim($v);
				if(0 < preg_match('/(\d+)㎡/i', $v, $extmatches)){
				   $square = $extmatches[1];	
				}
			}
		}
		
		return $square;
	}
	
	function getDistrict(){
		$e = $this->items('所在区域');
		
		$district = '';
		if($e !== false){
			$text = $e->find('a', 2)->innertext;
			$district = trim($text);
		}
		return $district;
	}
	
	function getAddress(){
		$e = $this->items('所在地址');
		
		$address = '';
		if($e !== false){
			$text = $e->find('.su_con', 0)->innertext;
			$address = preg_replace('#<span[^>]*?>.*?</span>#is', '', $text);
			$address = trim($address);
		}

		return $address;
	}
	
	function getProvides(){
		$provides = '';
		if(($node = $this->htmlDom()->find('.peizhi', 0)) != null){
			$text = $node->find('span', 0)->innertext;
			if (preg_match('/var tmp = \'(.*)\';/', $text, $reg)) {
				$provides = preg_replace('#\d+[,]?#is', '', $reg[1]);
			}
		}

		return $provides;
	}
	
	function getPhotos(){
		$photos = array();
		$imgs = $this->htmlDom()->find('.descriptionImg', 0)->find('img');
		foreach ($imgs as $e){
			$photos[] = $e->src;
		}
		return $photos;
	}
}