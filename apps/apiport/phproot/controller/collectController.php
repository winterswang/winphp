<?php
class collectController extends ApiController
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
	
	public function actionFavoritelist(){
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
		foreach($res as $k=>$house){
			$house['photo_list'] = array();
			$photos = housePhoto::model()->getAll(array('house_guid'=>$house['house_guid'],'is_delete' => 0));
			foreach($photos as $p){
				$house['photo_list'][] =  urlAssign::getUrl($p['attachment'],208);
			}
			
			$res[$k] = $house;
		}
		
		$data['length'] = $count;
		$data['data'] = $res;
		$this->response($data);
	}
	
	public function actionReserve(){
		$req = WinBase::app()->getRequest();
		
		$house_guids = $req->getParam('house_guid',0);		
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
			$checkReserved = houseReserve::model()->checktReserved($res['house_guid'],$uid);
			if($checkReserved){
				$this->showError('9016','House has be reserved');	
			}
			
			$favArr = array(
				'uid'=> $this->member->uid,
				'house_guid'=> $res['house_guid'],
				'district_guid'=> $res['district_guid'],
				'room'=> $res['room'],
				'wc'=> $res['wc'],
				'floor'=> $res['floor'],
				'square'=> $res['square'],
				'rent_type'=> $res['rent_type'],
				'rent_period'=> $res['rent_period'],
				'provides'=> $res['provides'],
				'subscribe_type'=> $res['subscribe_type'],
				'title'=> $res['title'],
				'description'=> $res['description'],
				'rent_price'=> $res['rent_price'],
				'house_uid'=> $res['uid'],
				'status'=> 0,
				'is_delete'=> 0,
				'createtime' => TIMESTAMP,
				'updatetime' => TIMESTAMP
			);
			
			houseReserve::model()->addReserve($favArr);
			house::model()->incHouseSubscribe($house_guid);
		}
		$this->response();
	}	
	
	//房源上下架
	public function actionState(){
		
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);
		$state = (int)$req->getParam('state');
		
		if(!in_array($state,array(1,2))){
			$this->showError('9016','Invail state');
		}
		
		$res = house::model()->getInfoByGuid($house_guid);
		if(empty($res)){
			$this->showError('9016','No House Found');
		}
		
		if($res['status'] == 0){
			//$this->showError('9015','No House Found');
		}
		
		if(!house::model()->updateHouse(array('status'=>$state) ,array('house_guid'=>$house_guid))){
			$this->showError('9999','SQL ERROR');	
		}
		
		$this->response();
	}
	
	//删除我的房源
	public function actionDelete(){
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);
		
		$res = house::model()->getInfoByGuid($house_guid);
		if(empty($res)){
			$this->showError('9016','No House Found');	
		}
		
		if(!house::model()->updateHouse(array('is_delete'=>1) ,array('house_guid'=>$house_guid))){
			$this->showError('9999','SQL ERROR');	
		}
		
		$this->response();
	}
}
?>