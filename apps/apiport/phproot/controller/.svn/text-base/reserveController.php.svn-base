<?php
class reserveController extends ApiController
{
	
	public function validate(){
		return array(
			'post' => array('publish'),
			//'auth' => array('publish'),
			'publish' => array()
		);
	}
	
	public function actionCreate(){
		$req = WinBase::app()->getRequest();
		$house_guids = $req->getParam('house_guid',0);

		if(!$this->member->verify){
			$this->showError('9015','No Logging');
		}

		$house_guids_arr = explode(',',$house_guids);
		$guids = array();
		foreach($house_guids_arr as $house_guid){
			if(preg_match("/^\d*$/",$house_guid))
				$guids[] = (int)$house_guid;
		}
		
		if(empty($guids)){
			$this->showError('9016','Invalid parameter');
		}
		
		$reslist = house::model()->getAll(array('house_guids'=>$guids));
		if(empty($reslist)){
			$this->showError('9016','No House Found');
		}
		
		$uid = $this->member->uid;
		if(!$uid){
			$this->showError('9016','No User Found');
		}
		
		$need_key = array('house_guid','district_guid','district_name','house_intro','room','hall','wc','floor_on','floor_all','square','rent_type','rent_period','provides','subscribe_type','title','description','rent_price','uid','proved');		
		
		$reserve_codes = array();
		
		foreach($reslist as $res){
			
			if($res['uid'] == $uid){
				continue;
			}
			
			$reserved = reserve::model()->getInfo(array('house_guid' => $res['house_guid'],'uid' => $uid,'status' => 0,'is_delete'=>0));
			if(!empty($reserved)){
				continue;
			}
			
			$reserve_code = $this->getOrderNumber($uid);
			
			$resArr = array(
				'reserve_code' => $reserve_code,
				'house_guid'=> $res['house_guid'],
				'house_uid'=> $res['uid'],
				'uid'=> $uid,
				'username'=> $this->member->userName,
				'gender'=> $this->member->gender,
				'mobile' => $this->member->mobile,
				'status'=> 0,
				'is_delete'=> 0,
				'createtime' => TIMESTAMP,
				'updatetime' => TIMESTAMP					
			);
			
			if($res_id = reserve::model()->addReserve($resArr,true)){
				
				$houseArr = array();
				foreach($need_key as $key){
					if(isset($res[$key])){
						$houseArr[$key] = $res[$key];
					}
				}

				$houseArr['reserve_id'] = $res_id;
				$houseArr['dateline'] = TIMESTAMP;
				
				reserveHouse::model()->addHouse($houseArr);
				
				$reserve_codes[] = $reserve_code;
			}
			
			house::model()->incHouseSubscribe($res['house_guid']);
		}
		/*	
		foreach($guids as $id){
			houseFavorite::model()->deleteFavorite(array('house_guid'=>$id,'uid'=>$this->member->uid));
		}*/
		
		$this->response(array('reserve_code' => join(',',$reserve_codes)));
	}
	
	public function actionList(){
		$req = WinBase::app()->getRequest();
		$page_no = $req->getParam('page_no',1);
		$page_size = $req->getParam('page_size',10);
		$for_user = $req->getParam('for_user',-1);
		
		$data = array(
			'length' => 0,
			'data' => array()
		);
		
		$where = array(
			'uid' => $this->member->uid,
			'is_delete' => 0,
		);
		
		if($for_user > -1){
			$where['for_user'] = $for_user; 
		}
		
		$count = reserve::model()->getCount($where);
		if(!$count){
			$this->response($data);
		}
		
		$reserve_list = $house_list = array();
		$reserve_rows = reserve::model()->getAll($where);
		foreach($reserve_rows as $row){
			$house_user = user::model()->getInfoByUid($row['house_uid']);
			$row['house_username'] = $house_user['userName'];
			$row['house_gender'] = $house_user['gender'];
			$row['mobile'] = $house_user['mobile'];
			$reserve_list[$row['reserve_id']] = $row;
		}
		
		$reserve_ids = array_keys($reserve_list);
		$house_rows = reserveHouse::model()->getList(array('reserve_ids' => $reserve_ids),$page_no,$page_size);
		
		foreach($house_rows as $row){
			$house = $row;
			
			$house_intro_arr = array();
			$district_info = district::model()->getInfo(array('district_guid' =>$row['district_guid']));
			$area_row = zone::model()->getInfo($district_info['area_id']);
			if(!empty($area_row)){
				$house_intro_arr[] = $area_row['title'];
			}			
			$house_intro_arr[] = $row['district_name'];
			$house_intro_arr[] = $row['room'] .'室'. $row['hall'] . '厅'. $row['wc'] . '卫';
			$house['house_intro'] = join(', ',$house_intro_arr);
			
			$house['photo_list'] = array();
			$photo_rows = housePhoto::model()->getAll(array('house_guid'=>$row['house_guid'],'is_delete' => 0));
			if(!empty($photo_rows)){
				foreach($photo_rows as $r){
					$photo = array();
					$photo['pid'] = $r['pid'];
					$photo['url'] = urlAssign::getUrl($r['attachment'],120);
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
			
			$house['reserve_info'] = array();
			$house['reserve_info'] = $reserve_list[$row['reserve_id']];
			$house_list[] = $house;
		}
		
		$data['length'] = $count;
		$data['data'] = $house_list;
		$this->response($data);
	}
	
	public function actionSubscribe(){
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);
		$page_no = $req->getParam('page_no',1);
		$page_size = $req->getParam('page_size',10);
		
		$data = array(
			'length' => 0,
			'data' => array()
		);
		
		$where = array(
			'house_uid' => $this->member->uid,
			'is_delete' => 0,
			'for_house' => 1,
			'house_guid' => $house_guid
		);
		
		$count = reserve::model()->getCount($where);
		if(!$count){
			$this->response($data);
		}
		
		$reserve_list =  array();
		$reserve_rows = reserve::model()->getAll($where);
		foreach($reserve_rows as $row){
			$house_user = user::model()->getInfoByUid($row['house_uid']);
			$row['house_username'] = $house_user['userName'];
			$row['house_gender'] = $house_user['gender'];
			$row['mobile'] = $house_user['mobile'];
			$reserve_list[] = $row;
		}
		
		$data['length'] = $count;
		$data['data'] = $reserve_list;
		$this->response($data);		
	}
	
	public function actionInfo(){
		$req = WinBase::app()->getRequest();
		
		$reserve_code = $req->getParam('reserve_code','');
		$reserve_info = reserve::model()->getInfo(array('reserve_code' => $reserve_code));
		
		if(empty($reserve_info)){
			$this->showError('9016','No Reserve Found');	
		}

		if($reserve_info['uid'] != $this->member->uid){
			$this->showError('9015','it isn\'t yours');
		}

		$reserve_house = reserveHouse::model()->getInfo(array('reserve_id' => $reserve_info['reserve_id']));

		unset($reserve_house['res_house_id']);
		
		$reserve_house['fav_id'] = 0;
		$fav = houseFavorite::model()->getInfo(array('house_guid' => $reserve_house['house_guid'],'uid'=>$this->member->uid));
		if(!empty($fav)){
			$reserve_house['fav_id'] = $fav['fav_id'];
		}
		
		$reserve_house['collect_num'] = 0;
		$collect_num = houseFavorite::model()->getCount(array('house_guid' => $reserve_house['house_guid']));
		if(!empty($collect_num)){
			$reserve_house['collect_num'] = $collect_num;
		}		
		
		$house_user = user::model()->getInfoByUid($reserve_house['uid']);

		$reserve_house['reserve_info'] = array(
			'reserve_id' => 	$reserve_info['reserve_id'],
			'reserve_code' => 	$reserve_info['reserve_code'],
			'uid' => 	$house_user['uid'],
			'username' => $house_user['userName'],
			'gender' => $house_user['gender'],
			'mobile' => $house_user['mobile'],
			'dateline' => $reserve_info['updatetime']
		);
		
		$reserve_house['action_list'] = array();

		$actions = houseAlter::model()->getList(array('house_guid' => $reserve_house['house_guid']),1,3);
		foreach($actions as $a){
			$alter = array(
				'updatetime' => date('m月d日',$a['dateline']),				   
				'form' => $a['before'],
				'to' => $a['after']
			);
			$reserve_house['action_list'][] = $alter;
		}
		
		$reserve_house['photo_list'] = array();
		$photo_rows = housePhoto::model()->getAll(array('house_guid' => $reserve_house['house_guid'],'is_delete' => 0));
		if(!empty($photo_rows)){
			foreach($photo_rows as $r){
				$photo = array();
				$photo['pid'] = $r['pid'];
				$photo['url'] = urlAssign::getUrl($r['attachment'],600);
				$photo['position'] = $r['position'];
				$photo['description'] = $r['description'];
				$reserve_house['photo_list'][] = $photo;
			}
		}else{
			$photo_row = districtPhoto::model()->getInfoByGuid($reserve_house['district_guid']);
			if(!empty($photo_row)){
				$reserve_house['photo_list'][] = array(
					'pid' => 0,
					'url' => urlAssign::getUrl($photo_row['attachment'],208),
					'description' => ''
				);
			}else{				
				$reserve_house['photo_list'][] = array(
					'pid' => 0,
					'url' => Config::getConfig('system','default_photo'),
					'description' => ''
				);
			}
		}		
		
		$reserve_house['district_info'] = array();
		$district = district::model()->getInfoByGuid($reserve_house['district_guid']);
		if(!empty($district)){
			$reserve_house['district_info']['district_name'] = $district['district_name'];
			$reserve_house['district_info']['district_address'] = $district['district_address'];
			$reserve_house['district_info']['lat'] = $district['lat'];
			$reserve_house['district_info']['lng'] = $district['lng'];
		}
		
		$reports = systemReport::model()->getAll(array('target'=>$reserve_house['house_guid'],'uid'=>$this->member->uid,'type'=>'house'));
		$reserve_house['reports'] = empty($reports) ? array() : $reports;
		
		$this->response($reserve_house);
	}
	
	function actionDelete(){
		$req = WinBase::app()->getRequest();
		$reserve_ids = $req->getParam('reserve_code','');
		$reserve_id_arr = explode(',',$reserve_ids);

		$ids = array();
		foreach($reserve_id_arr as $id){
			if(preg_match("/^\d*$/",$id))
				$ids[] = (int)$id;
		}
	
		if(empty($ids)){
			$this->showError('9016','Invalid parameter');
		}
		
		$uid = $this->member->uid;
		
		$myreserve = reserve::model()->getAll(array('reserve_codes' => $ids));
		$r_ids = $house_ids = array();
		foreach($myreserve as $r){
			$r_ids[] =  $r['reserve_id'];
			$house_ids[] =  $r['house_guid'];
			
			$where = array();
			
			if($r['status'] > 0){
				$where = array('is_delete' => 1);
			}else{
				$status = $r['house_uid'] == $uid ? 2 : 1; // 1  user  2 huid
				$where = array('status' => $status);
			}
			
			reserve::model()->updateReserve($where,array('reserve_id'=>$r['reserve_id']));		
		}
		
		//houseFavorite::model()->deleteFavorite(array('house_guids' => $house_ids,'uid' => $this->member->uid));
	
		$this->response();
	}
	
	 //18位
	function getOrderNumber($uid){
		 
		$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, 10); // num 10 ,str 35
		$seed = str_replace('0', '', $seed) . '012340567890';

		$code_pex = date('ymd').str_pad($uid, 9, 0, STR_PAD_LEFT);
		$length = 3;
		
		do{
			$hash = '';
			$max = strlen($seed) - 1;
			for ($i = 0; $i < $length; $i++) {
				$hash .= $seed{mt_rand(0, $max)};
			}
			$code = $code_pex . $hash;

		}while(reserve::model()->checkCodeExist($code));

		return $code;
	}
}
?>