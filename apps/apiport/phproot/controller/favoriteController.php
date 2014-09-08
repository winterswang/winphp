<?php
class favoriteController extends ApiController
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
		
		$house_guids = $req->getParam('house_guid','');	
		
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
	
		foreach($reslist as $res){
		
			$checkFavorited = houseFavorite::model()->checktFavorited($res['house_guid'],$uid);
			if($checkFavorited){
				continue;
				//$this->showError('9016','has be favorited');	
			}
			
			$favArr = array(
				'house_uid' => $res['uid'],
				'house_guid' => $res['house_guid'],
				'uid' => $uid,
				'dateline' => TIMESTAMP
			);
			
			houseFavorite::model()->addFavorite($favArr);
			house::model()->incHouseCollect($house_guid);
		}
		$this->response();
	}
	
	public function actionDelete(){
		$req = WinBase::app()->getRequest();
		$house_guids = $req->getParam('house_guid','');
		
		$house_guid_arr = explode(',',$house_guids);

		$ids = array();
		foreach($house_guid_arr as $id){
			if(preg_match("/^\d*$/",$id))
				$ids[] = (int)$id;
		}
	
		if(empty($ids)){
			$this->showError('9016','Invalid parameter');
		}
		
		houseFavorite::model()->deleteFavorite(array('uid'=>$this->member->uid,'house_guids'=>$ids));
		
		$this->response();
	}
	
	public function actionlist(){
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

			$house_intro_arr = array();
			$district_info = district::model()->getInfo(array('district_guid' =>$row['district_guid']));
			$area_row = zone::model()->getInfo($district_info['area_id']);
			if(!empty($area_row)){
				$house_intro_arr[] = $area_row['title'];
			}			
			$house_intro_arr[] = $row['district_name'];
			$house_intro_arr[] = $row['room'] .'室'.$row['hall'] . '厅' . $row['wc'] . '卫';
			$house['house_intro'] = join(', ',$house_intro_arr);

			$house['rent_type'] = $row['rent_type'];
			$house['subscribe_type'] = $row['subscribe_type'];
			$house['rent_price'] = $row['rent_price'];
			$house['rent_period'] = $row['rent_period'];
			$house['title'] = $row['title'];
			$house['collect_num'] = $row['collect_num'];				
			$house['proved'] = $row['proved'];
			
			$house['favorite_info'] = array();
			$house['favorite_info'] = $favorite_list[$row['house_guid']];

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
			
			$res[$k] = $house;
		}
		
		$data['length'] = $count;
		$data['data'] = $res;
		$this->response($data);
	}
	
}
?>