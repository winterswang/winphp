<?php
class anjuke_district extends parseHouseRule {

	public $htmlDom;
	public $items = array();
	
	function htmlDom(){
		if(!$this->htmlDom){
			$simpleDom = new simpleHtmlExt();
			$this->htmlDom = $simpleDom->str_get_html($this->html_data);
		}
		return $this->htmlDom;
	}
	
	function getPhoto(){
		$title = $this->htmlDom()->find('.tit_area', 0)->find('h1', 0)->innertext;
		return strip_tags($title);
	}
	
	function getArea(){
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
	
	function getZone(){
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

}