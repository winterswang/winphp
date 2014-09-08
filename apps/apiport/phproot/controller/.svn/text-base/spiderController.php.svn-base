<?php
class spiderController extends ApiController
{
	public function actionImport()
	{
		//$this->response(array('result' => $this->importXuequ()));
		//$this->response(array('result' => $this->importAgent()));
		//$this->response(array('result' => $this->importDistrict()));
	}
	
	function checkHash($hash){
		return house::model()->getInfo(array('house_hash' => $hash));
	}

	function actionImportKeyValue(){
		$req = WinBase::app()->getRequest();
		$rule = $req->getParam('rule','');
		$type = $req->getParam('type',2);
		//$maxId = keyMap::model()->getMaxId();
		$list = keyMap::model()->getKeyList($rule,$type);
		foreach ($list as $key ) {
			$kw = strstr($key['keyword'], $rule);
			$kw = substr($kw,3,strlen($key['keyword']));				
			$arr = array(
				'keyword' =>$kw,
				'value' =>$key['value'],
				'type' =>3
				);
			if(keyMap::model()->addKeyMap($arr))
				{
					//$this->response(array('result' => $arr));			
				}										
		}
	}

	function actionImportXuequ(){
		$req = WinBase::app()->getRequest();
		$data = array();
		$data['xuequ_id'] =  $req->getParam('xuequ_id','');
		$data['school_name'] = $req->getParam('school_name','');
		$data['school_level'] = $req->getParam('school_level','');
		$data['school_category'] = $req->getParam('school_category','');
		$data['school_fee'] = $req->getParam('school_fee','');
		$data['school_buildtime'] = $req->getParam('school_buildtime','');
		$data['school_address'] = $req->getParam('school_address','');
		$data['school_tel'] = $req->getParam('school_tel','');
		$data['school_overview'] =$req->getParam('school_overview','');
		$data['agent_url'] = $req->getParam('agent_id','');
		$data['recommend'] = $req->getParam('recommend','');
		$data['price_min'] = $req->getParam('price_min',0);
		$data['price_max'] = $req->getParam('price_max',0);
		$data['account_Req'] = $req->getParam('account_Req','');
		$data['xuequ_num'] = $req->getParam('xuequ_num','');
		$data['school_character'] = $req->getParam('school_character','');
		$data['city_studyrate'] = $req->getParam('city_studyrate','');
		$data['area_studyrate'] = $req->getParam('area_studyrate','');
		$data['photo_url'] = $req->getParam('school_photo','');
		$data['school_photo'] =$this->getPhotoUrl($req->getParam('school_photo',''),'xuequ');
		$data['advanced_teacher_num']=$req->getParam('advanced_teacher_num','');
		$data['inter_teacher_num']=$req->getParam('inter_teacher_num','');
		$data['junior_teacher_num']=$req->getParam('junior_teacher_num','');
		$data['lng'] =$req->getParam('lng',0.0);	
		$data['lat'] =$req->getParam('lat',0.0);	
		if($info = xuequ::model()->getInfo(array('xuequ_id'=>$data['xuequ_id']))){
			$data['xuequ_guid'] = $info['xuequ_guid'];
			if(!($guid = xuequ::model()->updateXuequ($data,array('xuequ_id'=>$data['xuequ_id'])))){
				$this->response(array('result' => 'updateXuequ failed'));
			}						
		}else{
			if(!($guid = xuequ::model()->addXuequ($data))){
				$this->response(array('result' => 'importXuequ failed'));
			}			
		}
		$this->response(array('result' => $guid));
	}

	function actionUpdateAgent(){
		$req = WinBase::app()->getRequest();
		$inserArr = array(
			'agent_url' => $req->getParam('agent_url',''),
			'agent_name' => $req->getParam('agent_name',''),
			'telephone' => $req->getParam('telephone',''),
			'level' => $req->getParam('level',''),
			'company' => $req->getParam('company',''),
			'agent_area' => $req->getParam('agent_area',''),
			'agent_district' => $req->getParam('agent_district',''),
			'agent_store' => $req->getParam('agent_store',''),
			'agent_business' => $req->getParam('agent_business',''),
			'agent_photo' =>  $this->getPhotoUrl($req->getParam('agent_photo',''),'agent')
		);
		if(agent::model()->isExist($inserArr['agent_url'])){//更新或添加
			if(agent::model()->updateAgent($inserArr,array('agent_url' =>$inserArr['agent_url']))){
					$this->response(array('result' => 'agent update success'));		
					
				}else{
					$this->response(array('result' => 'importAgent failed'));
				}						
		}else{
			if($guid = agent::model()->addAgent($inserArr)){
				$this->response(array('result' => $guid));		
				
			}else{
				$this->response(array('result' => 'importAgent failed'));
			}			
		}
	}
	function getPhotoUrl($photo,$target){
		$setting = WinBase::app()->getSetting('setting');
		$fileUpload = new fileUpload($setting['attach_path']);

			if(!$fileUpload->init($photo,true)){
				return '';
			}
			if (!$fileUpload->saveFile($target)){
				return '';
			}
			if($url = $fileUpload->attach['attachment']){
				return $url;					
			}else{
				return '';
			}

	}
	function actionUpdateDistrict_5i5j(){
		$req = WinBase::app()->getRequest();
		$inserArr = array(
			'district_id' => $req->getParam('district_id',''),
			'district_name' => $req->getParam('district_name',''),
			'address' => $req->getParam('address',''),
			'build_time' =>$req->getParam('build_time',''),
			'build_company' => $req->getParam('build_company',''),
			'build_square' => $req->getParam('build_square',''),
			'total_area' => $req->getParam('area',''),
			'manage_company' => $req->getParam('manage_company',''),
			'manage_fee' => $req->getParam('manage_fee',''),
			'green_rate' => $req->getParam('green_rate',''),
			'floor_rate' => $req->getParam('floor_rate',''),
			'agent_url' => $req->getParam('agent_url',''),
			'lng' =>$req->getParam('lng',0.0),
			'lat' =>$req->getParam('lat',0.0)
			);
		if(district_5i5j::model()->isExist($inserArr['district_id'])){
			if(district::model()->updateDistrict($inserArr,array('district_id' =>$inserArr['district_id']))){
					$this->response(array('result' => 'district update success'));		
					
				}else{
					$this->response(array('result' => 'updateDistrict failed'));
				}			
		}else{
			if($guid = district_5i5j::model()->addDistrict($inserArr)){
			 	$this->importDistrictPhotos($guid);
			 	$this->response(array('result' => 'importDistrict success'));
			}
			else{		
				$this->response(array('result' => 'importDistrict failed'));
			}			
		}		
	}
	function actionUpdateDistrict(){
		$req = WinBase::app()->getRequest();
		$guid = 100000000;
		$inserArr = array(
			'district_id' => $req->getParam('district_id',''),
			'district_name' => $req->getParam('district_name',''),
			'address' => $req->getParam('address',''),
			'build_time' =>$req->getParam('build_time',''),
			'build_company' => $req->getParam('build_company',''),
			'build_square' => $req->getParam('build_square',''),
			'total_area' => $req->getParam('area',''),
			'manage_company' => $req->getParam('manage_company',''),
			'manage_fee' => $req->getParam('manage_fee',''),
			'green_rate' => $req->getParam('green_rate',''),
			'floor_rate' => $req->getParam('floor_rate',''),
			'agent_url' => $req->getParam('agent_url',''),
			'lng' =>$req->getParam('lng',0.0),
			'lat' =>$req->getParam('lat',0.0)
			);
		$target = $req->getParam('target','');
		if(district::model()->isExist($inserArr['district_id'])){
			// if(district::model()->updateDistrict($inserArr,array('district_id' =>$inserArr['district_id']))){
			// 		$this->response(array('result' => 'district update success'));		
					
			// 	}else{
			// 		$this->response(array('result' => 'updateDistrict failed'));
			// 	}			
		}else{
			if($guid = district::model()->addDistrict($inserArr)){
			 	$this->importDistrictPhotos($guid);
			 	$this->response(array('result' => 'importDistrict success'));
			}
			else{		
				$this->response(array('result' => 'importDistrict failed'));
			}			
		}		
	}
	function actionImportHouse(){
		 if($guid=$this->importMyHouse()){

		 	$this->importHousePhotos($guid);

				$this->importBusiness();

				$this->importHospital();

				$this->importEducation();

			 	$this->importTraffic();

				$this->importDisgust();

				$this->importDailyLife();		 		

		 	$this->response(array('result' => 'importHouse success'));	
	   }
	}

	function isDistrictExistInHouse($district_id){
		$count = house_new::model()->getCount(array('district_id' =>$district_id));
		if($count >0){
			return true;
		}
		return false;
	}
	function actionOffSellHouse(){
		$req = WinBase::app()->getRequest();
		$house_id = $req->getParam('house_id','');
		if(house_new::model()->OffSellHouse(array('is_onsell' =>0),array('house_id' =>$house_id))){
			$this->response(array('result' => 'off success '));	
		}else{
			$this->response(array('result' => 'off failed'));
		}
	}
	function importMyHouse(){
		$req = WinBase::app()->getRequest();
		$guid = 1000000000;
		$inserArr = array(
			'house_id' => $req->getParam('house_id',''),
			'district_id' =>$req->getParam('district_id',''),
			'district_name' => $req->getParam('district_name',''),
			'label' =>$req->getParam('label',''),
			'fitment' => $req->getParam('fitment',''),
			'sell_price' => $req->getParam('sell_price',0),
			'mm_price' => $req->getParam('mm_price',0),
			'room' => $req->getParam('room',0),
			'hall' => $req->getParam('hall',0),
			'wc' => $req->getParam('wc',0),
			'agent_url' => $req->getParam('agent_url',''),
			'title' => $req->getParam('title',''),
			'square' => $req->getParam('square',''),
			'floor_on' => $req->getParam('floor_on',''),
			'floor_all' => $req->getParam('floor_all',''),
			'orientation' =>$req->getParam('orientation',''),
			'first_payment'=> $req->getParam('first_payment',0),
			'month_payment' =>$req->getParam('month_payment',0),
			'is_onsell' => 1,
			'create_time' => $req->getParam('create_time',0),
			'onsell_agents' => $req->getParam('onsell_agents',''),
			'source' => $req->getParam('source','')
		);
		$pos = strpos($inserArr['label'], '学区房');
		if($pos !==false){
			$inserArr['is_xuequ'] = 1;
		}
		if($info = house_new::model()->getInfoByHouseId($inserArr['house_id']))//判断是否重复
		{
			$inserArr['update_time'] = TIMESTAMP;
			if(!house_new::model()->updateHouse($inserArr,array('house_guid'=>$info['house_guid']))){
				return false;
			}

			return $info['house_guid'];
		}
		else{
			if(!($guid = house_new::model()->addHouse($inserArr))){
				return false;
			}
			return $guid;			
		}

	}
	function  importTraffic(){
		$req = WinBase::app()->getRequest();
		$districtId = $req->getParam('district_id','');
		$data = unserialize($req->getParam('traffic',''));
		$traffic = traffic::model();
		if(!empty($data)){
			foreach ($data as $key) {
				$inserArr = array(
					'district_id'  => $districtId,
					'traffic_type' => $key['trafficType'],
					'station_name' => $key['stationName'],
					'line_number'  => $key['lineNumber'],
					'distance'     => $key['trafficDistance'],
					'hashcode'     => $traffic->getHashCode($key['trafficType'].$key['stationName'].$key['lineNumber'])
				);
				$info = $traffic->getInfo(array('district_id'=>$inserArr['district_id'],'hashcode'=>$inserArr['hashcode']));
				if(!empty($info)){
					continue;
				}
				if(!($guid = $traffic->addTraffic($inserArr))){
					$this->response(array('result' => 'importTraffic false'));	
				}	
			}
		}
		return true;
	}

	function  importEducation(){
		$req = WinBase::app()->getRequest();
		$districtId = $req->getParam('district_id','');
		$data = unserialize($req->getParam('education',''));		
		$education = education::model();
		if(!empty($data)){
			foreach ($data as $key) {
				$inserArr = array(
					'district_id'  => $districtId,
					'education_type' => $key['educationType'],
					'education_name' => $key['educationName'],
					'address'  		=> $key['educationAddress'],
					'distance'     => $key['educationDistance'],
					'hashcode'     => $education->getHashCode($key['educationType'].$key['educationName'].$key['educationAddress'])
				);
				$info = $education->getInfo(array('district_id'=>$inserArr['district_id'],'hashcode'=>$inserArr['hashcode']));
				if(!empty($info)){
					continue;
				}
				if(!($guid = $education->addEducation($inserArr))){
					$this->response(array('result' => 'importEducation failed'));	
				}	
			}
		}
		return true;
	}

	function importBusiness(){
		$req = WinBase::app()->getRequest();
		$districtId = $req->getParam('district_id','');	
		$data = unserialize($req->getParam('business',''));		
		$business = business::model();
		if(!empty($data)){
			foreach ($data as $key) {
				$inserArr = array(
					'district_id'  => $districtId,
					'business_type' => $key['businessType'],
					'business_name' => $key['businessName'],
					'address'  => $key['businessAddress'],
					'distance'     => $key['businessDistance'],
					'hashcode'     => $business->getHashCode($key['businessType'].$key['businessName'].$key['businessAddress'])
				);
				$info = $business->getInfo(array('district_id'=>$inserArr['district_id'],'hashcode'=>$inserArr['hashcode']));
				if(!empty($info)){
					continue;
				}
				if(!($guid = $business->addBusiness($inserArr))){
					$this->response(array('result' => 'importBusiness failed'));					
				}	
			}			
		}
		return true;
	}

	function importHospital(){
		$req = WinBase::app()->getRequest();
		$districtId = $req->getParam('district_id','');	
		$data = unserialize($req->getParam('hospital',''));	
		$hospital = hospital::model();
		if(!empty($data)){		
			foreach ($data as $key) {
				$inserArr = array(
					'district_id'  => $districtId,
					'hospital_type' => $key['hospitalType'],
					'hospital_name' => $key['hospitalName'],
					'address'  		=> $key['hospitalAddress'],
					'distance'     => $key['hospitalDistance'],
					'hashcode'     => $hospital->getHashCode($key['hospitalType'].$key['hospitalName'].$key['hospitalAddress'])
				);
				$info = $hospital->getInfo(array('district_id'=>$inserArr['district_id'],'hashcode'=>$inserArr['hashcode']));
				if(!empty($info)){
					continue;
				}
				if(!($guid = $hospital->addHospital($inserArr))){
					$this->response(array('result' => 'importHospital failed'));
				}	
			}
		}
		return true;
	}

	function importDailyLife(){
		$req = WinBase::app()->getRequest();
		$districtId = $req->getParam('district_id','');	
		$data = unserialize($req->getParam('daily_life',''));
		$dailyLife = daily_life::model();
		if(!empty($data)){
			foreach ($data as $key) {
				$inserArr = array(
					'district_id'  => $districtId,
					'daily_life_type' => $key['daily_lifeType'],
					'daily_life_name' => $key['daily_lifeName'],
					'address'  => $key['daily_lifeAddress'],
					'distance'     => $key['daily_lifeDistance'],
					'hashcode'     => $dailyLife->getHashCode($key['daily_lifeType'].$key['daily_lifeName'].$key['daily_lifeAddress'])
				);
				$info = $dailyLife->getInfo(array('district_id'=>$inserArr['district_id'],'hashcode'=>$inserArr['hashcode']));
				if(!empty($info)){
					continue;
				}
				if(!($guid = $dailyLife->addDaily_life($inserArr))){
					$this->response(array('result' => 'importDailyLife failed'));
				}	
			}
		}
		return true;
	}

	function importDisgust(){
		$req = WinBase::app()->getRequest();
		$districtId = $req->getParam('district_id','');	
		$data = unserialize($req->getParam('disgust',''));
		$disgust = disgust::model();
		if(!empty($data)){		
			foreach ($data as $key) {
				$inserArr = array(
					'district_id'  => $districtId,
					'disgust_type' => $key['disgustType'],
					'disgust_name' => $key['disgustName'],
					'address'  => $key['disgustAddress'],
					'distance'     => $key['disgustDistance'],
					'hashcode'     => $disgust->getHashCode($key['disgustType'].$key['disgustName'].$key['disgustAddress'])
				);
				$info = $disgust->getInfo(array('district_id'=>$inserArr['district_id'],'hashcode'=>$inserArr['hashcode']));
				if(!empty($info)){
					continue;
				}
				if(!($guid = $disgust->addDisgust($inserArr))){
					$this->response(array('result' => 'importDisgust failed'));
				}	
			}
		}
		return true;
	}
	function importHousePhotos($guid){

			$req = WinBase::app()->getRequest();
			$photo_arr =unserialize($req->getParam('photos'));
			$setting = WinBase::app()->getSetting('setting');
			$fileUpload = new fileUpload($setting['attach_path']);
			foreach($photo_arr as $url){

				if(housePhoto::model()->getInfo(array('house_guid'=>$guid,'target_url'=>$url))){
					continue;				
				}
				if(!$fileUpload->init($url,true)){
					continue;
				}
				if (!$fileUpload->saveFile('house')){
					continue;
				}

				$photoArr = array(
					'house_guid' => $guid,
					'desc' => '',
					'pic_url' => $fileUpload->attach['attachment'],
					'target_url'=>$url,
					'is_delete' => 0
				);

				if(!housePhoto::model()->addPhoto($photoArr)){
					$this->response(array('result' => 'importPhotos false'));	
				}
				$arr = pathinfo($photoArr['pic_url']);
				$new_file = $arr['dirname'].'/'.$arr['filename'].'_small.'.$arr['extension'];
				$this->imageCut($photoArr['pic_url'],$new_file);
				file_put_contents('/data/wwwlogs/imageCut.log', $new_file);					
			}
			return true;	
		
	}

	function importDistrictPhotos($guid){

		$req = WinBase::app()->getRequest();
		$photos = $req->getParam('photos','');
		if(empty($photos)){
			return false;
		}
		$photo_arr =unserialize($photos);
		$setting = WinBase::app()->getSetting('setting');
		$fileUpload = new fileUpload($setting['attach_path']);

		foreach($photo_arr as $url){

			if(!$fileUpload->init($url,true)){
				continue;
			}
			if (!$fileUpload->saveFile('district')){
				continue;
			}

			$photoArr = array(
				'district_guid' => $guid,
				'desc' => '',
				'pic_url' => $fileUpload->attach['attachment'],
				'is_delete' => 0,
				'target_url' =>$url
			);
			if(districtPhoto::model()->getInfoByDistrictGuid($photoArr['district_guid'])){
				if(!districtPhoto::model()->updatePhoto($photoArr,array('district_guid'=>$photoArr['district_guid']))){
					$this->response(array('result' => 'updatePhotos false'));	
				}				
			}
			if(!districtPhoto::model()->addPhoto($photoArr)){
				$this->response(array('result' => 'importPhotos false'));	
			}
		}
		return true;			
	}

	function actionImportXueDistrict(){
		
		$req = WinBase::app()->getRequest();
		$data = array();
		$data['xuequ_id'] = $req->getParam('xuequ_id','');
		$house_id = $req->getParam('house_id','');
		$info_house = house_new::model()->getInfo(array('house_id'=>$house_id));
		$info_xuequ = xuequ::model()->getInfo(array('xuequ_id'=>$data['xuequ_id']));

		if(!empty($info_house['district_id']))
		{
			$data['district_id'] = $info_house['district_id'];
			$data['district_name'] = $info_house['district_name'];
			$data['district_guid'] = $info_house['district_guid'];
			$data['xuequ_guid'] = $info_xuequ['xuequ_guid'];
			$info = xuequ_district::model()->getInfo(array('xuequ_guid'=>$data['xuequ_guid'],'district_id'=>$data['district_id']));
			if(empty($info['xuequ_guid'])){
				if(!(xuequ_district::model()->addXuequ_district($data))){
						$this->response(array('result' => 'importXuequ failed'));							
				}else{
						$this->response(array('result' => 'importXuequ success'));		
				}				
			}
			if(xuequ_district::model()->updateXuequ_district($data,array('xuequ_guid'=>$data['xuequ_guid'],'district_id'=>$data['district_id']))){
				$this->response(array('result' => 'importXuequ success'));	
			}
		}
						
	}
	private function imageCut($file,$new_file,$new_img_width = 180,$new_img_height = 180)
	{
		$filename = 'http://api.ikuaizu.com/data/attachment/'.$file;
		$im = imagecreatefromjpeg($filename);
		if(!$im){
			return false;			
		}
		$img=getimagesize($filename);
		$newim = imagecreatetruecolor($new_img_width, $new_img_height); 
		imagecopyresampled($newim, $im, 0, 0, 0, 0, $new_img_width, $new_img_height, $img[0], $img[1]); 
		$to_File = '/data/wwwroot/ikuaizu/apps/apiport/wwwroot/data/attachment/'.$new_file;
		ImageJpeg($newim,$to_File,90); 
		imagedestroy($newim); 	
		imagedestroy($im);

	}
}
?>