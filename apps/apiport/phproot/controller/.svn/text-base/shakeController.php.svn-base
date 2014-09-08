<?php
class shakeController extends ApiController {
    
	public function actionPush(){
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);		
		$lat = $req->getParam('lat',0);
		$lng = $req->getParam('lng',0);
		
		$lat = !$lat ? $this->session->get('lat',0) : $lat;
		$lng = !$lng ? $this->session->get('lng',0) : $lng;
		
		if(empty($lat) || empty($lng)){
			$this->showError('9016','latlng should not be empty');
		}		
		
		$house = house::model()->getInfoByGuid($house_guid);
		if(empty($house)){
			$this->showError('9016','No House Found');
		}
		
		$district = district::model()->getInfoByGuid($house['district_guid']);
		if(empty($district)){
			$this->showError('9016','No District Found');
		}
		
		$distance = $this->getDistance($lat,$lng,$district['lat'],$district['lng']);
		$last_shake = $this->session->get('last_shake',0);
		$weight = $this->getWeight($distance,$last_shake);
		
		$userAll = session::model()->getAllNear($district['lat'],$district['lng'],2000);		
		
		foreach($userAll as $user){
			
			//$house_distance = $this->getDistance($user['lat'],$user['lng'],$district['lat'],$district['lng']);
			
			$arr = array(
				'uid'=> $user['uid'],
				'house_guid'=>$house_guid,
				'lat' => $lat,
				'lng' => $lng,
				'weight' => $weight,
				'dateline' => TIMESTAMP
			);
			$house = shakePush::model()->addHouse($arr);
		}
		
		$this->session->set('last_shake',TIMESTAMP);
		
		$data = array(
			'push_users' => count($userAll)		  
		);
		$this->response($data);
	}
	
    public function actionHouse(){
		$req = WinBase::app()->getRequest();
		$lat = $req->getParam('lat',0);
		$lng = $req->getParam('lng',0);
		$radius = $req->getParam('radius',2000);
        
		$lat = !$lat ? $this->session->get('lat',0) : $lat;
		$lng = !$lng ? $this->session->get('lng',0) : $lng;
		
		if(empty($lat) || empty($lng)){
			$this->showError('9016','latlng should not be empty');
		}
        
		$data = array(
			'length' => 0,
        	'data' => array()
		);
		
		$uid =  $this->member->uid;
		
		$preference = $this->member->getPreference();
		$weight = $this->getWeight('',''); //to do
		
		$last_shake = $this->session->get('last_shake',0);
		
		/*
		$where = array(
					   
		);
		$house = shakePush::model()->getAll($arr);
		*/
		/*
		$cached_shakes = array();
		if((TIMESTAMP - $last_shake) > 120){
			shakeHouse::model()->clear(array('uid'=>$uid));
		}else{
			$cached_shakes = shakeHouse::model()->getAll(array('uid'=>$uid));
		}*/
		
		//$neartime = TIMESTAMP - 60 * 60 * 5;
		//$push_houses = shakePush::model()->getAll(array('uid'=>$uid,'neartime' => $neartime));
		
		$districts = district::model()->getAllByLocation($lat,$lng,$radius);
		foreach($districts as $v){
			$district_list[$v['district_guid']] = $v;
		}
        
        if(empty($district_list)){
            $this->response($data);
        }
        
        $where = array(
            'district_guids' => array_keys($district_list),
			'weight' => $weight
        );
        
        $count = house::model()->getCount($where);
        if(!$count){
            $this->response($data);
        }

		$house_rows = house::model()->getAll($where,4);
		$house_list = $house_shakes = array();
		foreach($house_rows as $row){

			$house = array();
			$house['house_guid'] = $row['house_guid'];
			$house['house_intro'] = $row['house_intro'];
			$house['rent_type'] = $row['rent_type'];
			$house['subscribe_type'] = $row['subscribe_type'];
			$house['house_intro'] = $row['house_intro'];
			$house['rent_price'] = $row['rent_price'];
			$house['title'] = $row['title'];
			$house['collect_num'] = $row['collect_num'];
			$house['photo_list'] = array();
			$photos = housePhoto::model()->getAll(array('house_guid'=>$row['house_guid'],'is_delete' => 0));
			if(!empty($photo_rows)){
				foreach($photo_rows as $r){
					$photo = array();
					$photo['pid'] = $r['pid'];
					$photo['url'] = urlAssign::getUrl($r['attachment'],208);
					$photo['position'] = $r['position'];
					$photo['description'] = $r['description'];
					$house['photo_list'][] = $photo;
				}
			}else{
 				$photo_row = districtPhoto::model()->getInfo($row['district_guid']);
				if(!empty($photo_row)){
					$house['photo_list'][] = array(
						'pid' => 0,
						'url' => urlAssign::getUrl($photo_row['attachment'],208),
						'description' => ''
					);
				}else{			
					$house['photo_list'][] = array(
						'pid' => 0,
						'url' => Config::getConfig('system','default_photo'),
						'description' => ''
					);
				}
			}
			
			$house_list[] = $house;
			
			
			$house_shakes[] = array(
				'house_guid' => $row['house_guid'],
				'house_uid' => $row['uid'],
				'house_distance' => $district_list[$row['district_guid']]['distance'],
				'weight' => 0,
				'uid' => $uid,
				'dateline' => TIMESTAMP
			);
		}
		/*
		foreach($house_shakes as $house){
			shakeHouse::model()->addHouse($house);
		}*/
		
		$this->session->set('last_shake',TIMESTAMP);
		
		$data = array(
			'length' => $count,
			'data' => $house_list
		);

        $this->response($data);
    }
	
	public function getDistance($lat1,$lon1,$lat2, $lon2){
		$radLat1 = $lat1 * Math.PI / 180;
		$radLat2 = $lat2 * Math.PI / 180;
		$a = $radLat1 - $radLat2;
		$b = $lon1 * Math.PI / 180 - $lon2 * Math.PI / 180;
		$s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin($a / 2), 2)
		+ Math.cos($radLat1) * Math.cos($radLat2)
		* Math.pow(Math.sin($b / 2), 2)));
		$s = $s * 6378137.0;// 取WGS84标准参考椭球中的地球长半径(单位:m)
		$s = Math.round($s * 10000) / 10000;
		
		return $s;
	}
	
	public function getWeight($distance,$last_shake){
		return 0;
	}
}