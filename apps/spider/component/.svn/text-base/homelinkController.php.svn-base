<?php
class homelinkController {
    function test($data){
    	echo "hhha".$data['title'];
    }
	
	function importMyHouse($data,$q)
	{
		 $arr = pathinfo($q['url']);
		$inserArr = array(
			'house_id' => $arr['filename'],
			'district_id' => $data['districtId'],
			'district_name' => $data['districtName'],
			'label' => $data['label'],
			'fitment' => $data['fitment'],
			'sell_price' => $data['sellPrice'],
			'mm_price' => $data['mmPrice'],
			'room' => $data['room'],
			'hall' => $data['hall'],
			'agent_id' => $data['agentId'],
			'title' => $data['title'],
			'square' => $data['square'],
			'floor_on' => $data['floorOn'],
			'floor_all' => $data['floorAll'],
			'orientation' =>$data['orientation'],
			'first_payment'=> $data['firstPayment'],
			'month_payment' =>$data['monthPayment'],
			'create_time' => TIMESTAMP,
			'source' => $q['target']
		);
		if(!($guid = house_new::model()->addHouse($inserArr))){
			echo "importMyHouse false!\r\n";
			return false;
		}
		echo "importMyHouse_success\r\n";
		return $guid;
	}

	function importPhotos($house_guid,$data){

		$photo_arr = $data['photos'];
		$setting = WinBase::app()->getSetting('setting');
		$fileUpload = new fileUpload($setting['attach_path']);
		foreach($photo_arr as $url){

			if(!$fileUpload->init($url,true)){
				continue;
			}
			if (!$fileUpload->saveFile('house')){
				continue;
			}

			$photoArr = array(
				'house_guid' => $house_guid,
				'desc' => '',
				'pic_url' => $fileUpload->attach['attachment'],
				'is_delete' => 0
			);
			if(housePhoto::model()->addPhoto($photoArr)){
				echo "importPhotos_success\r\n";
			}else{
			 	echo "importPhotos false!\r\n";
			}
		}	
	}

	function  importTraffic($data){
		$traffic = traffic::model();
		foreach ($data['traffic'] as $key) {
			$inserArr = array(
				'district_id'  => $data['districtId'],
				'traffic_type' => $key['trafficType'],
				'station_name' => $key['stationName'],
				'line_number'  => $key['lineNumber'],
				'distance'     => $key['trafficDistance'],
				'hashcode'     => $traffic->getHashCode($key['trafficType'].$key['stationName'].$key['lineNumber'])
			);
			if(!($guid = $traffic->addTraffic($inserArr))){
				echo "importTraffic false!\r\n";
				print_r($data['traffic'])."\r\n";	
			return false;
			}	
		}
		echo "importTraffic_success\r\n";
		return true;	
	}

	function  importEducation($data){
		$education = education::model();
		foreach ($data['education'] as $key) {
			$inserArr = array(
				'district_id'  => $data['districtId'],
				'education_type' => $key['educationType'],
				'education_name' => $key['educationName'],
				'address'  => $key['educationAddress'],
				'distance'     => $key['educationDistance'],
				'hashcode'     => $education->getHashCode($key['educationType'].$key['educationName'].$key['educationAddress'])
			);
			if(!($guid = $education->addEducation($inserArr))){
				echo "importEducation false!\r\n";
				print_r($data['education'])."\r\n";	
			return false;
			}	
		}
		echo "importEducation_success\r\n";
		return true;
	}

	function importBusiness($data){
		$business = business::model();
		foreach ($data['business'] as $key) {
			$inserArr = array(
				'district_id'  => $data['districtId'],
				'business_type' => $key['businessType'],
				'business_name' => $key['businessName'],
				'address'  => $key['businessAddress'],
				'distance'     => $key['businessDistance'],
				'hashcode'     => $business->getHashCode($key['businessType'].$key['businessName'].$key['businessAddress'])
			);
			if(!($guid = $business->addBusiness($inserArr))){
				print_r($data['business'])."\r\n";		
				return false;
			}	
		}
		echo "importBusiness_success\r\n";
		return true;
	}

	function importHospital($data){
		$hospital = hospital::model();
		foreach ($data['hospital'] as $key) {
			$inserArr = array(
				'district_id'  => $data['districtId'],
				'hospital_type' => $key['hospitalType'],
				'hospital_name' => $key['hospitalName'],
				'address'  => $key['hospitalAddress'],
				'distance'     => $key['hospitalDistance'],
				'hashcode'     => $hospital->getHashCode($key['hospitalType'].$key['hospitalName'].$key['hospitalAddress'])
			);
			if(!($guid = $hospital->addHospital($inserArr))){
				print_r($data['hospital'])."\r\n";		
				return false;
			}	
		}
		echo "importHospital_success\r\n";
		return true;
	}

	function importDailyLife($data){
		$dailyLife = daily_life::model();
		foreach ($data['daily_life'] as $key) {
			$inserArr = array(
				'district_id'  => $data['districtId'],
				'daily_life_type' => $key['daily_lifeType'],
				'daily_life_name' => $key['daily_lifeName'],
				'address'  => $key['daily_lifeAddress'],
				'distance'     => $key['daily_lifeDistance'],
				'hashcode'     => $dailyLife->getHashCode($key['daily_lifeType'].$key['daily_lifeName'].$key['daily_lifeAddress'])
			);
			if(!($guid = $dailyLife->addDaily_life($inserArr))){
				print_r($data['daily_life'])."\r\n";	
				return false;
			}	
		}
		echo "importDailyLife_success";
		return true;
	}

	function importDisgust($data){
		$disgust = disgust::model();
		foreach ($data['disgust'] as $key) {
			$inserArr = array(
				'district_id'  => $data['districtId'],
				'disgust_type' => $key['disgustType'],
				'disgust_name' => $key['disgustName'],
				'address'  => $key['disgustAddress'],
				'distance'     => $key['disgustDistance'],
				'hashcode'     => $disgust->getHashCode($key['disgustType'].$key['disgustName'].$key['disgustAddress'])
			);
			if(!($guid = $disgust->addDisgust($inserArr))){
				print_r($data['disgust'])."\r\n";	
				return false;
			}	
		}
		echo "importDisgust_success\r\n";
		return true;
	}
	function importAgent($data){
		$inserArr = array(
			'agent_url' => $data['agentId'],
			'agent_name' =>$data['agentName'],
			'telephone' =>$data['agentTel'],
			'level' =>$data['agentLevel'],
			'company' =>$data['agentCompany'],
			'agent_area' =>$data['agentArea'],
			'agent_district' =>$data['agentDistrict'],
			'agent_store' =>$data['agentStore'],
			'agent_url' =>$data['agentUrl']
		);
		if(!($guid = agent::model()->addAgent($inserArr))){
			print_r($data);			
			return false;
		}
		echo "agent_guid:".$guid."\r\n";
		return $guid;
	}
	function importXuequ($data){
		$inserArr = array(
			'xuequ_id' => $data['xuequId'],
			'school_name' => $data['schoolName'],
			'school_level' => $data['baseContent']['schoolLevel'],
			'school_category' => $data['baseContent']['schoolCategory'],
			'school_fee' => $data['baseContent']['schoolFee'],
			'school_buildtime'=> $data['baseContent']['schoolBuildtime'],
			'school_address'=> $data['baseContent']['schoolAddress'],
			'school_tel'=> $data['baseContent']['schoolTel'],
			'school_overview' =>$data['schoolOverview'],
			'agent_url'=>$data['agentId'],
			'school_photo' =>$data['schoolPhoto'],
			'recommend' =>$data['recommend'],
			'price_min'=>$data['priceMin'],
			'price_max'=>$data['priceMax'],
			'account_Req'=> $data['baseContent']['accountReq'],
			'account_year'=> $data['baseContent']['accountYear'],
			'xuequ_num'=> ''.$data['baseContent']['xuequNum'],
			'school_character'=> $data['baseContent']['schoolCharacter'],
			'city_studyrate'=> $data['baseContent']['cityStudyrate'],
			'area_studyrate'=> $data['baseContent']['areaStudyrate']
		);
		//print_r($inserArr);
		if(!($guid = xuequ::model()->addXuequ($inserArr))){
			print_r($data);			
			return false;
		}
		echo "xuequ_guid:".$guid."\r\n";
		return $guid;
	}
	function importDistrict($data){
		print_r($data);
		$guid = 100000000;
		$inserArr = array(
			'district_id' => $data['districtId'],
			'district_name' => $data['districtName'],
			'address' => $data['districtAddress'],
			'build_time' => $data['buildTime'],
			'build_company' => $data['buildCompany'],
			'build_square' => $data['buildSquare'],
			'area' => $data['area'],
			'manage_company' => $data['manageCompany'],
			'manage_fee' => $data['manageFee'],
			'green_rate' => $data['greenRate'],
			'floor_rate' => $data['floorRate'],
			'agent_url' => $data['agentUrl'],					
			);
		if($guid = district::model()->addDistrict($inserArr)){
			$this->importDistrictPhotos($guid,$data);
			echo "district_guid:".$guid."\r\n";
			return $guid;
		}
		else{
			print_r($data);			
			return false;
		}			
	}
	function importDistrictPhotos($districtGuid,$data){
		$photo_arr = $data['photos'];
		$setting = WinBase::app()->getSetting('setting');
		$fileUpload = new fileUpload($setting['attach_path']);
		foreach($photo_arr as $url){
			echo "begin\r\n";
			if(!$fileUpload->init($url,true)){
				continue;
			}
			echo "init\r\n";
			if (!$fileUpload->saveFile('district')){
				continue;
			}
			echo "saveFile\r\n";
			$photoArr = array(
				'district_guid' => $districtGuid,
				'desc' => '',
				'pic_url' => $fileUpload->attach['attachment'],
				'is_delete' => 0
			);
			if(districtPhoto::model()->addPhoto($photoArr)){
				echo "importPhotos_success\r\n";
			}else{
			 	echo "importPhotos false!\r\n";
			}
		}		
	}
	//建立房源和售卖中介的关系表，只存储house_guid,agent_guid
	function importHouseAgentIdList($data){
		$house =house_new::model();
		$agent =agent::model();
		$inserArr = array(
			'house_guid' =>$house->getGuidByHouseId($data['houseId']),
			'agent_guid' =>$agent->getGuidByAgentId($data['agentId'])
			);
	}
	//建立学区和小区的对应关系表，只存储xuequ_guid,district_guid
	function importXuequDistrictList($data){
		// $xuequ = xuequ::model();
		// $district = district::model();
		// $xuequ_district = xuequ_district::model();
		// $xuequ_info = $xuequ->getInfoById($data['xuequId']);
		// $xuequGuid = $xuequ_info['xuequ_guid'];

		// foreach ($data as $key ) {
		// 	$district_info = $district->getInfo(array('district_name' =>$key));
		// 	$inserArr = array(
		// 		'xuequ_id' =>$xuequ_info['xuequ_id'],
		// 		'xuequ__guid' => $xuequ_info['xuequ__guid'],
		// 		'district_id' => $district_info['district_id'],
		// 		'district_guid' =>$district_info['district_guid'],
		// 		'district_name' =>$district_info['district_name']
		// 		);
		// 	print_r($inserArr);
		// 	//$xuequ_district->addXuequ_district($inserArr);
		// }
		$test = test::model();
		foreach ($data['xuequNameDistrict'] as $key ) {
				$inserArr = array(
					'xuequ_id' =>$data['xuequId'],
					'district_name' =>$key
					);
				echo "id:".$test->addTest($inserArr)."\r\n";
			}
	}
}
