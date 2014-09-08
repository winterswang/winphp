<?php
class homelink_xuequ extends parseHouseRule {
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
	//学区名称
	function getSchoolName(){
		$schoolName = '';
		if($html = $this->htmlDom()->find('.details_page h2',0)){
			$schoolName = $html->plaintext;
		}
		return $schoolName;
	}
	//学校的等级
	function getSchoolLevel(){
		$level = '';
		$html = $this->htmlDom()->find('.bdr tbody',0)->find('tr',1);
		if($html && $html = $html->find('td',0)){
			$level = $html->plaintext;
		}
		return $level;
	}
	//学校类别
	function getSchoolCategory(){
		$category = '';
		$html = $this->htmlDom()->find('.bdr tbody',0)->find('tr',0);
		if($html && $html = $html->find('td',0)){
			$category = $html->plaintext;
		}
		return $category;
	}
	//学校学费
	function getSchoolFee(){
		$fee = 0;
		$html = $this->htmlDom()->find('.bdr tbody',0)->find('tr',2);
		if($html && $html = $html->find('td',0)){
			if(0 < preg_match('/(\d+)/', $html, $extmatches)){
			   $fee = $extmatches[0];	
			}
		}
		return $fee;
	}
	//学校建校时间
	function getSchoolBuildTime(){
		$time = '';
		$html = $this->htmlDom()->find('.infor table');
		foreach ($html as $key ) {
			if($key->getAttribute('summary') =='学校地址'){
			 	$time = $key->find('tbody tr',0)->find('td',0)->plaintext;
			 }
		}
		return $time;
	}
	//学校地址
	function getSchoolAddress(){
		$address = '';
		$html = $this->htmlDom()->find('.infor table');
		foreach ($html as $key ) {
			if($key->getAttribute('summary') =='学校地址'){
			 	$address = $key->find('tbody tr',1)->find('td',0)->plaintext;
			 }
		}
		return $address;
	}
	//学校联系电话
	function getSchoolTel(){
		$tel = '';
		$html = $this->htmlDom()->find('.infor table');
		foreach ($html as $key ) {
			if($key->getAttribute('summary') =='学校地址'){
			 	$tel = $key->find('tbody tr',2)->find('td',1)->plaintext;
			 }
		}
		return $tel;		
	}
	//学校概况
	function getSchoolOverview(){
		$overview = '';
		$html = $this->htmlDom()->find('.intro',0);
		if($html){
			$overview = $html->find('p',1)->plaintext;
		}
		return $overview;
	}
	//经纪人ID
	function getAgentId(){
		$agentId = '';
		$html = $this->htmlDom()->find('.week_star a',0);
		if($html){
			if(0 < preg_match('/(h-\d+)/', $html->href, $extmatches)){
			   $agentId = $extmatches[0];	
			}
		}
		return $agentId;
	}
	//价格区间最低值
	function getPriceMin(){
		$priceMin = 0;
		$html = $this->htmlDom()->find('.price span',0);
		if($html && $html = $html->find('big',0)){
			if(0 < preg_match_all('/(\d+)/', $html->plaintext, $extmatches)){
			   $priceMin = $extmatches[0][0];	
			}			
		}
		return $priceMin;
	}
	//价格区间最高值
	function getPriceMax(){
		$priceMax = 0;
		$html = $this->htmlDom()->find('.price span',0);
		if($html && $html = $html->find('big',0)){
			if(0 < preg_match_all('/(\d+)/', $html->plaintext, $extmatches)){
			   $priceMax = $extmatches[0][1];	
			}			
		}
		return $priceMax;
	}
	//学区对应的小区名
	function getDistrictName(){
		$districtName =array();
		$html = $this->htmlDom()->find('.tbody tr');
		foreach ($html as $key) {
			if($key){
				$districtName[]=$key->find('td',0)->plaintext;
			}
		}
		return $districtName;
	}
	//获取学区的照片
	function getSchoolPhoto(){
		$photo = '';
		$html = $this->htmlDom()->find('.schintro img',0);
		if($html){
			$photo = $html->src;
		}
		return $photo;
	}
	//推荐理由
	function getRecommend(){
		$recommend = '';
		$html = $this->htmlDom()->find('.tjBox p',0);
		if($html){
			$recommend = $html->plaintext;
		}
		return $recommend;
	}
	function getTeachers(){
		$teachers = array('advanced'=>0,'intermediate'=>0,'junior'=>0);
		$html = $this->htmlDom()->find('.progressBar',0);
		//print_r($html->find('label',0)->plaintext);
		if($html && $html = $html->find('label',0)){
			if(0 < preg_match('/(\d+)/', $html->plaintext, $extmatches)){
			   $teachers['advanced'] = $extmatches[0];	
			}		
		}
		$html = $this->htmlDom()->find('.progressBar',1);
		if($html && $html = $html->find('label',0)){
			if(0 < preg_match('/(\d+)/', $html->plaintext, $extmatches)){
			   $teachers['intermediate'] = $extmatches[0];	
			}
		}
		$html = $this->htmlDom()->find('.progressBar',2);
		if($html && $html = $html->find('label',0)){
			if(0 < preg_match('/(\d+)/', $html->plaintext, $extmatches)){
			   $teachers['junior'] = $extmatches[0];	
			}
		}
		return $teachers;
	}
	//学区对应的小区名
	function getXuequNameDistrict(){
		$districtNameList = array('name'=>array(),'url'=>array());
		$html = $this->htmlDom()->find('.search_criteria dl',0)->find('div',1);
		//print_r($html);
		if($html && $html = $html->find('dd')){			
			foreach ($html as $key ) {
				 $districtNameList['name'][] = $key->find('a',0)->plaintext;
				 $districtNameList['url'][] = $key->find('a',0)->href;
			}
		}
		return $districtNameList;
	}
	function getXuequHouse(){
		$houseId = '';
		$html = $this->htmlDom()->find('.showlst li',0);
		if($html){
			
		}		
	}
	//学校基础信息
	function getBaseContent(){
		$baseContent = array(
			'schoolLevel' =>'',
			'cityStudyrate' =>'',
			'areaStudyrate' =>'',
			'schoolBuildtime' =>'',
			'schoolAddress' => '',
			'schoolTel' => '',
			'schoolCharacter' =>'',
			'schoolCategory' => '',
			'schoolLevel' => '',
			'schoolFee' => '',
			'accountReq' => '',
			'accountYear' => '',
			'xuequNum' => ''
			); 
		$html = $this->htmlDom()->find('.bdr table',0);
		$html_school = $this->htmlDom()->find('.infor table');
		if($html && $content = $html->getAttribute('summary')){
			if($content == '中学信息'){
				$baseContent['schoolLevel'] =  $html->find('tbody tr',0)->find('td',0)->plaintext ;
				$baseContent['cityStudyrate'] = $html->find('tbody tr',1)->find('td',0)->plaintext ;
				$baseContent['areaStudyrate'] = $html->find('tbody tr',2)->find('td',0)->plaintext ;				
					foreach ($html_school as $key ) {
					if($key->getAttribute('summary') =='学校地址'){
			 			$baseContent['schoolBuildTime'] = $key->find('tbody tr',0)->find('td',0)->plaintext;
			 			$baseContent['schoolAddress'] = $key->find('tbody tr',1)->find('td',0)->plaintext;
			 			$baseContent['schoolTel'] = $key->find('tbody tr',2)->find('td',0)->plaintext;
			 			}
					}
			}
			if($content == '小学信息'){
				$baseContent['accountReq'] = $html->find('tbody tr',0)->find('td',0)->plaintext;//落户要求
				$baseContent['accountYear'] = $html->find('tbody tr',1)->find('td',0)->plaintext;//落户年限
				$baseContent['xuequNum'] = $html->find('tbody tr',2)->find('td',0)->plaintext;//学区名额
				if(0 < preg_match_all('/([\x{4e00}-\x{9fa5}]{2,})/u', $this->htmlDom()->find('.intro_xq li',0)->plaintext, $extmatches)){
				   $baseContent['schoolLevel'] =  $extmatches[0][1];	
				}				
				foreach ($html_school as $key ) {
					if($key->getAttribute('summary') =='学校地址'){
			 			$baseContent['schoolAddress'] = $key->find('tbody tr',0)->find('td',0)->plaintext;
			 			$baseContent['schoolTel'] = $key->find('tbody tr',1)->find('td',0)->plaintext;
			 			$baseContent['schoolCharacter'] = $key->find('tbody tr',2)->find('td',0)->plaintext;
			 			}
					}					
			}
			if($content == '幼儿园信息'){
				$baseContent['schoolCategory'] = $html->find('tbody tr',0)->find('td',0)->plaintext;
				$baseContent['schoolLevel'] = $html->find('tbody tr',1)->find('td',0)->plaintext;
				$baseContent['schoolFee'] = $html->find('tbody tr',2)->find('td',0)->plaintext;
					foreach ($html_school as $key ) {
					if($key->getAttribute('summary') =='学校地址'){
			 			$baseContent['schoolBuildTime'] = $key->find('tbody tr',0)->find('td',0)->plaintext;
			 			$baseContent['schoolAddress'] = $key->find('tbody tr',1)->find('td',0)->plaintext;
			 			$baseContent['schoolTel'] = $key->find('tbody tr',2)->find('td',0)->plaintext;
			 			}
					}				
			}
		}
		return $baseContent;
	}
}