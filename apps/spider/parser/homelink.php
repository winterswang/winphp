<?php
class homelink extends parseHouseRule implements iHouseRule {
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
	function getTitle(){//ok
		$html = $this->htmlDom()->find('.xtitle h1', 0);
		if($html){
		$title = $html->plaintext;
		return strip_tags($title);
		}
		return null;
	}
	function getBaseMessage(){
		//房源基本信息
		$bmData = array();
		$item = array('sellPrice','mmPrice','room','hall','fitment','onSell','doneSell','districtName','districtId','floorOn','square','floorAll');
	 	$bmData = $this->getParseData($item);
	 	return $bmData;
	}
	function getSellPrice(){
		$price = 0;
		$html = $this->htmlDom()->find('.shoujia span', 0);
		if($html){
			return $html->plaintext;
		}
		return $price;
	}
	function getMmPrice(){
		$averagePrice = 0;
		$html = $this->htmlDom()->find('.shoujia ol', 0)->plaintext;
		if($html !== false){
			if(0 < preg_match('/\d+/', $html, $extmatches)){
			   $averagePrice = $extmatches[0];	
			}
		}
		return $averagePrice;
	}
	function getFitment(){
		$fitment='';
		$html = $this->htmlDom()->find('.jiashou li', 0)->plaintext;
		if($html !== false){
			if(0 < preg_match('/\/(.*)/', $html, $extmatches)){
			   $fitment = $extmatches[0];	
			}
			return trim($fitment,'/');
		}
		return '';
	}
	function getOnSell(){
		$onSell = 0;
		$html = $this->htmlDom()->find('.jiashou ol', 0);
		$html = $html->find('li',3)->plaintext;
		if($html !==false){
			if(0 < preg_match('/(\d+)套/', $html, $extmatches)){
			   $onSell = $extmatches[0];	
			}
		}
		return trim($onSell,'套');
	}
	function getDoneSell(){
		$doneSell = 0;
		$html = $this->htmlDom()->find('.jiashou ul', 0)->plaintext;
		if($html !==false){
			if(0 < preg_match('/\d+/', $html, $extmatches)){
			   $doneSell = $extmatches[0];	
			}		
		}
		return  $doneSell;
	}
	function getLabel(){
		$label = array();
		$html = $this->htmlDom()->find('.xtitle ol', 0);
		if(!empty($html) && $html = $html->find('label')){
			foreach ($html as $key ) {
					$label[] = $key->plaintext;
			}
		}
		return implode(",", $label);
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
	function getRoom(){//ok,室
		$html = $this->htmlDom()->find('.jiashou li', 0)->plaintext;
		$room = 0;
		if($html !== false){
			if(0 < preg_match('/(\d+)室.*/i', $html, $extmatches)){
			   $room = $extmatches[1];	
			}
		}
		return $room;
	}
	
	function getHall(){//ok,室
		$html = $this->htmlDom()->find('.jiashou li', 0)->plaintext;
		$hall = 0;
		if($html !== false){
			if(0 < preg_match('/.*(\d+)厅.*/i', $html, $extmatches)){
			   $hall = $extmatches[1];	
			}
		}
		
		return $hall;
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

	function getFloorOn(){
		$floorOn = '';
		$html = $this->htmlDom()->find('.jiashou ol', 0);
		 if($html && $html = $html->find('li',2)){
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{3}/u', $html->plaintext, $extmatches)){
			   $floorOn = $extmatches[0];	
			}
		}
		return $floorOn;
	}
	
	function getFloorAll(){//ok
		$floorAll = 0;
		$html = $this->htmlDom()->find('.jiashou ol', 0);
		if($html && $html = $html->find('li',2)){
			if(0 < preg_match('/\d+/i', $html->plaintext, $extmatches)){
			   $floorAll = $extmatches[0];	
			}
		}
		return $floorAll;
	}
	
	function getSquare(){//ok		
		$square = 0;
		$html = $this->htmlDom()->find('.shoujia ul', 0);
		if($html && $html = $html->find('li',3)){
			if(0 < preg_match('/\d+[.]?\d+/', $html->plaintext, $extmatches)){
				$square = $extmatches[0];	
		 	}
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
		$imgs = $this->htmlDom()->find('#zyclazy img');
		if($imgs !==false)
		{
			foreach ($imgs as $e){
				$photos[] = $e->getAttribute('data-original');
			}
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
	function getdistrictId(){
		$districtId = '';
		$html = $this->htmlDom()->find('.jiashou ol', 0);
		if($html && $html = $html->find('li',3)->find('a',0)->href){
			   $districtId = trim($html,'/');	
		}
		return $districtId;
	}
	
	function getDistrictName(){
		$districtName = '';
		$html = $this->htmlDom()->find('.jiashou ol', 0);
		if($html && $html = $html->find('li',3)){
			$districtName = $html->find('a',0)->innertext;
		}

		return $districtName;
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
	function getAgentId(){
		$agentId = '';
		$html = $this->htmlDom()->find('.jiageman a', 0);
		if($html){
			if(0 < preg_match_all('/(\w+)/', $html->href, $extmatches)){
			   $agentId = $extmatches[0][1];	
			}
		}
		return $agentId;
	}
	function getAgentName(){//ok
		$who = '';
		$html = $this->htmlDom()->find('.jiageman a span', 0);
		if($html){
			return $html->plaintext;
		}
		return $who;
	}
	function getOnsellAgent(){
		$agentList  = '';
		$html = $this->htmlDom()->find('.broker_name');
		if($html){
			foreach ($html as $key) {
				if($Key = $key->find('a',0)){
					if(0 < preg_match_all('/(\w+)/', $Key->href, $extmatches)){
					  	 $agentList.= $extmatches[0][1].',';	
					}					
				}
			}		
		}
		return trim($agentList,",");
	}
	function getOrientation(){
		$orientation = '';
		$html = $this->htmlDom()->find('.jiashou ol',0);
		if($html && $html =$html->find('li',1)){
			if(0 < preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $html->plaintext, $extmatches)){
				$orientation = $extmatches[0][1];
			}
		}
		return $orientation;
	}
	function getFirstPayment(){
		$first_payment = 0;
		$html = $this->htmlDom()->find('.shoujia ol',0);
		if($html && $html = $html->find('li',1)){
			if(0 < preg_match('/\d+/i', $html->plaintext, $extmatches)){
			   $first_payment = $extmatches[0];	
			}
		}
		return $first_payment;
	}
	function getMonthPayment(){
		$monthPayment = 0;
		$html = $this->htmlDom()->find('.shoujia ol',0);
		if($html && $html = $html->find('li',2)){
			if(0 < preg_match('/\d+/i', $html->plaintext, $extmatches)){
			   $monthPayment = $extmatches[0];	
			}
		}
		return $monthPayment;
	}


	function getTraffic(){
		$traffic = array();
		$html = $this->htmlDom()->find('#traffic table',0);
		if($html && $html = $html->find('tr')){
			$num = 0;
			foreach ($html as $e){
				if($num == 0){
					$num++;
					continue;
				}
				$traffic[] =array(
					'trafficType' => $this->getTrafficType($e),
					'stationName' => $this->getStationName($e),
					'lineNumber' => $this->getLineNumber($e),
					'trafficDistance' => $this->getTrafficDistance($e)
					);
				$num++;
			}
		}
		return $traffic;  
	}

	function getTrafficType($e){
		$trafficType = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{2,}/u', $html, $extmatches)){
			$trafficType = $extmatches[0];	
			}
		}
		//echo "trafficType".$trafficType."\r\n";
		return $trafficType;
	}

	function getStationName($e){
		$stationName = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{3,}/u', $html, $extmatches)){
			$stationName = $extmatches[0];	
			}
		}
		//echo "stationName".$stationName."\r\n";
		return $stationName;
	}

	function getLineNumber($e){
		$lineNumber = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match_all('/([\d]?[\x{4e00}-\x{9fa5}]{2,})/u', $html, $extmatches)){
				if(count($extmatches[0]) >2){
					$lineNumber = $extmatches[0][2];						
				}	
			}
		}
		//echo "lineNumber".$lineNumber."\r\n";
		return $lineNumber;
	}

	function getTrafficDistance($e){
		$distance = '';
		if($e && $e->find('td',1)){
			$distance = $e->find('td',1)->plaintext;
		}
		//echo "distance".$distance."\r\n";		
		return $distance;
	}

////////////////////EDUCATION//////////////////////////////////////
	function getEducation(){
		$education = array();
		//待修改
		$html = $this->htmlDom()->find('#teach table',0);
		if($html && $html = $html->find('tr')){
			$num = 0;
			foreach ($html as $e){
				if($num == 0){
					$num++;
					continue;
				}
				$education[] =array(
					'educationType' => $this->getEducationType($e),
					'educationName' => $this->getEducationName($e),
					'educationAddress' => $this->getEducationAddress($e),
					'educationDistance' => $this->getEducationDistance($e)
					);
				$num++;
			}
		}
		return $education;  
	}


	function getEducationType($e){
		$educationType = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{2,}/u', $html, $extmatches)){
			$educationType = $extmatches[0];	
			}
		}
		//echo "educationType".$educationType."\r\n";
		return $educationType;
	}

	function getEducationName($e){
		$educationName = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{4,}/u', $html, $extmatches)){
			$educationName = $extmatches[0];	
			}
		}
		//echo "educationName".$educationName."\r\n";
		return $educationName;
	}

	function getEducationAddress($e){
		$educationAddress = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match_all('/([\x{4e00}-\x{9fa5}]{2,})/u', $html, $extmatches)){
			//print_r($extmatches);
				if(count($extmatches[0]) >2){
					$educationAddress = $extmatches[0][2];						
				}

			}
		}
		//echo "educationAddress".$educationAddress."\r\n";
		return $educationAddress;
	}

	function getEducationDistance($e){
		$distance = '';
		if($e!=false && $e->find('td',1) !=false){
			$distance = $e->find('td',1)->plaintext;
		}
		//echo "distance".$distance."\r\n";		
		return $distance;
	}

////////////////////HOSPITAL//////////////////////////////////////
	function getHospital(){
		$hospital = array();
		$html = $this->htmlDom()->find('#medical table',0);
		if($html && $html = $html->find('tr')){
			$num = 0;
			foreach ($html as $e){
				if($num == 0){
					$num++;
					continue;
				}
				$hospital[] =array(
					'hospitalType' => $this->getHospitalType($e),
					'hospitalName' => $this->getHospitalName($e),
					'hospitalAddress' => '',
					'hospitalDistance' => $this->getHospitalDistance($e)
					);
				$num++;
			}
		}
		return $hospital;  
	}


	function getHospitalType($e){
		$hospitalType = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{2,}/u', $html, $extmatches)){
			$hospitalType = $extmatches[0];	
			}
		}
		//echo "hospitalType".$hospitalType."\r\n";
		return $hospitalType;
	}

	function getHospitalName($e){
		$hospitalName = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{4,}/u', $html, $extmatches)){
			$hospitalName = $extmatches[0];	
			}
		}
		//echo "hospitalName".$hospitalName."\r\n";
		return $hospitalName;
	}

	function getHospitalAddress($e){
		$hospitalAddress = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match_all('/([\x{4e00}-\x{9fa5}]{2,})/u', $html, $extmatches)){
			//print_r($extmatches);
				if(count($extmatches[0]) >2){
					$hospitalAddress = $extmatches[0][2];						
				}	
			}
		}
		//echo "hospitalAddress".$hospitalAddress."\r\n";
		return $hospitalAddress;
	}

	function getHospitalDistance($e){
		$distance = '';
		if($e && $e->find('td',1)){
			$distance = $e->find('td',1)->plaintext;
		}
		//echo "distance".$distance."\r\n";		
		return $distance;
	}

////////////////////DISGUST/////////////////////////////////////////
	function getDisgust(){
		$disgust = array();
		$html = $this->htmlDom()->find('#disgust table',0);
		if($html && $html = $html->find('tr')){
			$num = 0;
			foreach ($html as $e){
				if($num == 0){
					$num++;
					continue;
				}
				$disgust[] =array(
					'disgustType' => $this->getDisgustType($e),
					'disgustName' => $this->getDisgustName($e),
					'disgustAddress' => '',
					'disgustDistance' => $this->getDisgustDistance($e)
					);
				$num++;
			}
		}
		return $disgust;  
	}

	function getDisgustType($e){
		$disgustType = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{2,}/u', $html, $extmatches)){
			$disgustType = $extmatches[0];	
			}
		}
		//echo "disgustType".$disgustType."\r\n";
		return $disgustType;
	}

	function getDisgustName($e){
		$disgustName = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{4,}/u', $html, $extmatches)){
			$disgustName = $extmatches[0];	
			}
		}
		//echo "disgustName".$disgustName."\r\n";
		return $disgustName;
	}

	function getDisgustDistance($e){
		$distance = '';
		if($e && $e->find('td',1)){
			$distance = $e->find('td',1)->plaintext;
		}
		//echo "distance".$distance."\r\n";		
		return $distance;
	}	

////////////////////DAILY_LIFE//////////////////////////////////////
	function getDaily_life(){
		$daily_life = array();
		///food
		$html = $this->htmlDom()->find('#food table',0);
		if($html && $html = $html->find('tr')){
			$daily_life = $this->combineDaily_life($html,$daily_life);
		}
		///scenery
		$html = $this->htmlDom()->find('#scenery table',0);
		if($html && $html = $html->find('tr')){
			$daily_life = $this->combineDaily_life($html,$daily_life);
		}


		return $daily_life;  
	}

	function combineDaily_life($html,$daily_life){
		if($html){
			$num = 0;
			foreach ($html as $e){
				if($num == 0){
					$num++;
					continue;
				}
				$daily_life[] =array(
					'daily_lifeType' => $this->getDaily_lifeType($e),
					'daily_lifeName' => $this->getDaily_lifeName($e),
					'daily_lifeAddress' => $this->getDaily_lifeAddress($e),
					'daily_lifeDistance' => $this->getDaily_lifeDistance($e)
					);
				$num++;
			}
		}
		return $daily_life;  
	} 

	function getDaily_lifeType($e){
		$daily_lifeType = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{2,}/u', $html, $extmatches)){
			$daily_lifeType = $extmatches[0];	
			}
		}
		//echo "daily_lifeType".$daily_lifeType."\r\n";
		return $daily_lifeType;
	}

	function getDaily_lifeName($e){
		$daily_lifeName = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{4,}/u', $html, $extmatches)){
			$daily_lifeName = $extmatches[0];	
			}
		}
		//echo "daily_lifeName".$daily_lifeName."\r\n";
		return $daily_lifeName;
	}

	function getDaily_lifeAddress($e){
		$daily_lifeAddress = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{2,}\d.*/u', $html, $extmatches)){
			$daily_lifeAddress = $extmatches[0];	
			}
		}
		//echo "daily_lifeAddress".$daily_lifeAddress."\r\n";
		return $daily_lifeAddress;
	}

	function getDaily_lifeDistance($e){
		$distance = '';
		if($e && $distance =$e->find('td',1)){
			$distance = $distance->plaintext;
		}
		//echo "distance".$distance."\r\n";		
		return $distance;
	}

////////////////////BUSINESS//////////////////////////////////////
	function getBusiness(){
		$business = array();
		$html = $this->htmlDom()->find('#supermarket table',0);
		if($html && $html = $html->find('tr')){
			$num = 0;
			foreach ($html as $e){
				if($num == 0){
					$num++;
					continue;
				}
				$business[] =array(
					'businessType' => $this->getBusinessType($e),
					'businessName' => $this->getBusinessName($e),
					'businessAddress' => $this->getBusinessAddress($e),
					'businessDistance' => $this->getBusinessDistance($e)
					);
				$num++;
			}
		}
		return $business;  
	}


	function getBusinessType($e){
		$businessType = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{2,}/u', $html, $extmatches)){
			$businessType = $extmatches[0];	
			}
		}
		//echo "businessType".$businessType."\r\n";
		return $businessType;
	}

	function getBusinessName($e){
		$businessName = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{4,}/u', $html, $extmatches)){
			$businessName = $extmatches[0];	
			}
		}
		//echo "businessName".$businessName."\r\n";
		return $businessName;
	}

	function getBusinessAddress($e){
		$businessAddress = '';
		if($e){
			$html = $e->find('td',0)->plaintext;
			if(0 < preg_match('/[\x{4e00}-\x{9fa5}]{2,}\d.*/u', $html, $extmatches)){
			//print_r($extmatches);
			$businessAddress = $extmatches[0];	
			}
		}
		//echo "businessAddress".$businessAddress."\r\n";
		return $businessAddress;
	}

	function getBusinessDistance($e){
		$distance = '';
		if($e && $e->find('td',1)){
			$distance = $e->find('td',1)->plaintext;
		}
		//echo "distance".$distance."\r\n";		
		return $distance;
	}
	//房源对应的经纪人列表，包括首发的和代售的
	function getAgentIdList(){
		$idList = array();
		$html = $this->htmlDom()->find('#listData');
		if($html){
			foreach ($html as $key) {
				$key->find('.broker_name a ',0)->href;
				if($key){
					if(0 < preg_match('/h-\d+/i', $key, $extmatches)){
						$idList[] = $extmatches[0];
					}
				}
			}			
		}
		return $idList;
	}
}
