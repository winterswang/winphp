<?php
class houseController extends ApiController
{
	
	public function validate(){
		return array(
			'post' => array('publish'),
			//'auth' => array('publish'),
			'publish' => array()
		);
	}

	
	public function actionList(){
		$req = WinBase::app()->getRequest();
		$uid = $req->getParam('uid','');
		if(empty($uid)){
			$this->response(array('result'=>'missing data '));
		}
		$data = houseTest::model()->getList(array('uid'=>$uid));
		
		foreach ($data as $key => $value) {
			$data[$key]['photoList'] = housePhotoOld::model()->getList(array('house_guid'=>$value['house_guid']));
		}
		//file_put_contents('/tmp/houseList.log', serialize($data));
		$this->response($data);				
	}
	
	//房源详情
	public function actionInfo(){
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);
		$res = array();
		if($house_guid>0){
			$res = house_new::model()->getInfoByGuid($house_guid);
			
			if(empty($res)){
				$this->showError('9016','No House Found');
			}
			$agent = agent::model()->getInfo(array('agent_url'=>$res['agent_url']));//经纪人
			$housePhoto =housePhoto::model()->getList(array('house_guid'=>$house_guid));//房源图片列表
			$district = district::model()->getInfo(array('district_id'=>$res['district_id']));
			$xuequList = xuequ_district::model()->getList(array('district_name'=>$res['district_name']));//学区对应关系表
			$xuequ = array();
			if($xuequList){
				foreach ($xuequList as $key ) {
					$xuequ[] = xuequ::model()->getInfo(array('xuequ_id'=>$key['xuequ_id']));
				}			
			}
			$res['district_guid'] = $district['district_guid'];
			$res['agent_name'] = $agent['agent_name'];
			$res['agent_tel'] = $agent['telephone'];
			$res['agent_guid'] = $agent['agent_guid'];
			$res['agent_photo'] = $agent['agent_photo'];
			$res['district_lng'] = $district['lng'];
			$res['district_lat'] = $district['lat'];
			$res['district_address'] = $district['address'];
			$res['xuequ'] = $xuequ;
			$res['housePhoto'] =$housePhoto;
		}		
		$this->response($res);
	}
	public function actionPublish(){
		$req = WinBase::app()->getRequest();
		$uid = $req->getParam('uid','');
		$content = $req->getParam('content','');
		if(empty($uid) || empty($content)){
			$this->response(array('result'=>'missing data '));
		}
		file_put_contents('/tmp/house.log', $content);
		$data = array(
			'uid'=>$uid,
			'content'=>$content,
			'createtime'=>TIMESTAMP
			);
		$houseGuid = houseTest::model()->addHouse($data);

		if(housePhotoOld::model()->updatePhoto(array('house_guid'=>$houseGuid),array('uid'=>$uid,'house_guid'=>10000)))
		{
			$this->response(array($houseGuid));
			// $data['photoList'] =array();
			// $list = housePhotoOld::model()->getList(array('uid'=>$uid,'house_guid'=>$houseGuid));
			// foreach ($list as $key => $value) {
			// 	$data['photoList'][] = $value;
			// }
			// $this->response(array('data'=>$data));			
		}
	    $this->response(array('result'=>'save house failed'));		
	}
	public function actionInfoTest(){
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);
		$info = houseTest::model()->getInfo(array('house_guid'=>$house_guid));
		$info['photoList'] = housePhotoOld::model()->getList(array('house_guid'=>$house_guid));
		$this->response(array('data'=>$info));		
	}

	public function actionMedia(){
		$req = WinBase::app()->getRequest();
		$mediaId = $req->getParam('mediaId','');
		$thumbMediaId = $req->getParam('thumbMediaId','');
		$access_token = $req->getParam('access_token','');
		if(empty($mediaId) || empty($thumbMediaId) || empty($access_token)){
			$this->response(array('result'=>'media data is empty'));exit();
		}
				
	}
}
?>