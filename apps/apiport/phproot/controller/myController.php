<?php
class myController extends ApiController
{
	
	public function actionFavorite(){
		$req = WinBase::app()->getRequest();
		$page_no = $req->getParam('page_no',1);
		$page_size = $req->getParam('page_size',10);
		
		$data = array(
			'length' => 0,
			'data' => array()
		);
		
		$where = array(
			'uid' => $this->member->uid
		);

		$count = houseFavorite::model()->getCount($where);
		if(!$count){
			$this->response($data);
		}
		
		$res = houseFavorite::model()->getList($where,$page_no,$page_size);
		$favorite_list = array();
		foreach($res as $row){
			$favorite_list[$row['house_guid']] = $row;
		}
		
		$ids = array_keys($favorite_list);
		$hoouse_rows = house::model()->getAll(array('house_guids'=>$ids));
		foreach($hoouse_rows as $k=>$row){
			$house = array();
			$house['house_guid'] = $row['house_guid'];
			$house['rent_type'] = $row['rent_type'];
			$house['rent_price'] = $row['rent_price'];
			$house['title'] = $row['title'];			
			$house['proved'] = $row['proved'];
			$house['dateline'] = $row['updatetime'];
			$house['room_wc'] = $row['room'] .'室'.$row['hall'] .'厅'. $row['wc'] . '卫';
	
			$house_intro_arr = array();
			$district_info = district::model()->getInfo(array('district_guid' =>$row['district_guid']));
			$area_row = zone::model()->getInfo($district_info['area_id']);
			if(!empty($area_row)){
				$house_intro_arr[] = $area_row['title'];
			}			
			$house_intro_arr[] = $row['district_name'];
			$house_intro_arr[] = $row['room'] .'室'.$row['hall'] .'厅'. $row['wc'] . '卫';
			$house['house_intro'] = join(', ',$house_intro_arr);
			
			$house['photo_list'] = array();
			$photo_rows = housePhoto::model()->getTopPhoto($house['house_guid']);
			if(!empty($photo_rows)){
				$house['photo_list'][] = array(
					'url' => urlAssign::getUrl($photo_rows['attachment'],120),
				);
			}else{
				$photo_row = districtPhoto::model()->getTopPhoto($row['district_guid']);
				if(!empty($photo_row)){
					$house['photo_list'][] = array(
						'url' => urlAssign::getUrl($photo_row['attachment'],208),
					);
				}else{
					$house['photo_list'][] = array(
						'url' => Config::getConfig('system','default_photo'),
					);
				}
			}
			
			$res[$k] = $house;
		}
		
		$data['length'] = $count;
		$data['data'] = $res;
		$this->response($data);
	}
	
	public function actionReserve(){
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
			$reserve = array();
			$reserve['reserve_code'] = $row['reserve_code'];
			$reserve['username'] = $house_user['userName'];
			$reserve['gender'] = $house_user['gender'];
			$reserve['mobile'] = $house_user['mobile'];
			$reserve['dateline'] = $row['createtime'];
			$reserve_list[$row['reserve_id']] = $reserve;
		}
		
		$reserve_ids = array_keys($reserve_list);
		$house_rows = reserveHouse::model()->getList(array('reserve_ids' => $reserve_ids),$page_no,$page_size);
		
		foreach($house_rows as $row){
			$house = array();
			$house['house_guid'] = $row['house_guid'];
			$house['rent_type'] = $row['rent_type'];
			$house['rent_price'] = $row['rent_price'];
			$house['title'] = $row['title'];			
			$house['proved'] = $row['proved'];
			$house['dateline'] = $row['dateline'];

			$house_intro_arr = array();
			$district_info = district::model()->getInfo(array('district_guid' =>$row['district_guid']));
			$area_row = zone::model()->getInfo($district_info['area_id']);
			if(!empty($area_row)){
				$house_intro_arr[] = $area_row['title'];
			}			
			$house_intro_arr[] = $row['district_name'];
			$house_intro_arr[] = $row['room'] .'室'.$row['hall'] .'厅'. $row['wc'] . '卫';
			$house['house_intro'] = join(', ',$house_intro_arr);
			
			$house['photo_list'] = array();
			$photo_rows = housePhoto::model()->getTopPhoto($house['house_guid']);
			if(!empty($photo_rows)){
				$house['photo_list'][] = array(
					'url' => urlAssign::getUrl($photo_rows['attachment'],120),
				);
			}else{
				$photo_row = districtPhoto::model()->getTopPhoto($row['district_guid']);
				if(!empty($photo_row)){
					$house['photo_list'][] = array(
						'url' => urlAssign::getUrl($photo_row['attachment'],208),
					);
				}else{
					$house['photo_list'][] = array(
						'url' => Config::getConfig('system','default_photo'),
					);
				}
			}
			
			$house['reserve_info'] = array();
			$house['reserve_info'] = $reserve_list[$row['reserve_id']];
			$house_list[] = $house;
		}
		
		$data['length'] = count($house_list);
		$data['data'] = $house_list;
		$this->response($data);
	}
	
	//房源详情
	public function actionHouse(){
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);
		$row = house::model()->getInfo(array('house_guid'=>$house_guid,'uid'=>$this->member->uid));
		
		if(empty($row)){
			$this->showError('9016','No House Found');	
		}
		
		$house = array();
		$house['house_guid'] = $row['house_guid'];
		$house['title'] = $row['title'];
		$house['rent_type'] = $row['rent_type'];
		//$house['subscribe_type'] = $row['subscribe_type'];
		$house['rent_price'] = $row['rent_price'];			
		$house['room'] = $row['room'];
		$house['hall'] = $row['hall'];
		$house['wc'] = $row['wc'];
		
		$house_intro_arr = array();
		$district_info = district::model()->getInfo(array('district_guid' =>$row['district_guid']));
		$area_row = zone::model()->getInfo($district_info['area_id']);
		if(!empty($area_row)){
			$house_intro_arr[] = $area_row['title'];
		}
		$house_intro_arr[] = $row['district_name'];
		$house_intro_arr[] = $row['room'] .'室'.$row['hall'] .'厅'. $row['wc'] . '卫';
		$house['house_intro'] = join(', ',$house_intro_arr);
		
		$house['status'] = $row['status'];
		$house['proved'] = $row['proved'];	
		
		$house['dateline'] = $row['updatetime'];
		//$house['score'] = $row['score'];
		$house['subscribe_num'] = $row['subscribe_num'];
		$house['view_num'] = $row['view_num'];
		$house['collect_num'] = $row['collect_num'];
		
		//$house['around_price'] = $around_price;
		//$house['vacancy_day'] = $vacancy_day;		
				
		$house['photo_list'] = array();
		$photo_rows = housePhoto::model()->getTopPhoto($house['house_guid']);
		if(!empty($photo_rows)){
			$house['photo_list'][] = array(
				'url' => urlAssign::getUrl($photo_rows['attachment'],120),
			);
		}else{
			$photo_row = districtPhoto::model()->getTopPhoto($row['district_guid']);
			if(!empty($photo_row)){
				$house['photo_list'][] = array(
					'url' => urlAssign::getUrl($photo_row['attachment'],208),
				);
			}else{
				$house['photo_list'][] = array(
					'url' => Config::getConfig('system','default_photo'),
				);
			}
		}
		
		$house['subscribe_list'] = array();
		if($row['subscribe_num'] > 0){
			$where = array(
				'house_guid' => $house['house_guid'],
				'is_delete' => 0,
				'for_house' => 1 
			);
			
			$subscribe_row = reserve::model()->getAll($where);
			foreach($subscribe_row as $v){
				$subscribe = array();
				$subscribe['reserve_id'] = $v['reserve_id'];
				$subscribe['reserve_code'] = $v['reserve_code'];
				$subscribe['uid'] = $v['uid'];
				$subscribe['username'] = $v['username'];
				$subscribe['gender'] = $v['gender'];
				$subscribe['mobile'] = $v['mobile'];
				$subscribe['dateline'] = $v['updatetime'];
				$house['subscribe_list'][] = $subscribe;
			}
		}			

		$this->response($house);
	}	
	
	//房东的房源列表
	public function actionRent(){
		$req = WinBase::app()->getRequest();
		
		$page_no = $req->getParam('page_no',1);
		$page_size = $req->getParam('page_size',10);
		
		$data = array(
			'length' => 0,
			'data' => array()
		);
		
		$where = array(
			'uid' => $this->member->uid,
			'is_delete' => 0
		);
		
		$count = house::model()->getCount($where);
		if(!$count){
			$this->response($data);
		}
		
		$house_list = array();
		$house_rows = house::model()->getList($where,$page_no,$page_size);
		
		foreach($house_rows as $k=>$row){
			$house = array();
			$house['house_guid'] = $row['house_guid'];
			$house['title'] = $row['title'];
			$house['rent_type'] = $row['rent_type'];
			//$house['subscribe_type'] = $row['subscribe_type'];
			$house['rent_price'] = $row['rent_price'];
			$house['proved'] = $row['proved'];
			
			$house_intro_arr = array();
			$district_info = district::model()->getInfo(array('district_guid' =>$row['district_guid']));
			$area_row = zone::model()->getInfo($district_info['area_id']);
			if(!empty($area_row)){
				$house_intro_arr[] = $area_row['title'];
			}
			$house_intro_arr[] = $row['district_name'];
			$house_intro_arr[] = $row['room'] .'室'.$row['hall'] .'厅'. $row['wc'] . '卫';
			$house['house_intro'] = join(', ',$house_intro_arr);
			
			$house['status'] = $row['status'];
			$house['proved'] = $row['proved'];	
			
			$house['dateline'] = $row['updatetime'];
			//$house['score'] = $row['score'];
			//$house['subscribe_num'] = $row['subscribe_num'];
			//$house['view_num'] = $row['view_num'];
			//$house['collect_num'] = $row['collect_num'];
			
			//$house['around_price'] = $around_price;
			//$house['vacancy_day'] = $vacancy_day;		
					
			$house['photo_list'] = array();
			$photo_rows = housePhoto::model()->getTopPhoto($house['house_guid']);
			if(!empty($photo_rows)){
				$house['photo_list'][] = array(
					'url' => urlAssign::getUrl($photo_rows['attachment'],120),
				);
			}else{
				$photo_row = districtPhoto::model()->getTopPhoto($row['district_guid']);
				if(!empty($photo_row)){
					$house['photo_list'][] = array(
						'url' => urlAssign::getUrl($photo_row['attachment'],208),
					);
				}else{
					$house['photo_list'][] = array(
						'url' => Config::getConfig('system','default_photo'),
					);
				}
			}		

			$house_list[$k] = $house;
		}
		
		$data['length'] = $count;
		$data['data'] = $house_list;
		$this->response($data);
	}
}
?>