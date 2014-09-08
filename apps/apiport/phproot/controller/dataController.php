<?php
class dataController extends ApiController {
	//更新小区在售的房源数量
	function actionUpdateDistrictHouseCount(){
		return district::model()->updateHouseCount();
	}


	function actionUpdateHouseSupport(){
		$req = WinBase::app()->getRequest();
		$table = $req->getParam('table','');
		if(!empty($table)){
			if($this->delHouseSupport($table)){
				$this->response(array('result'=>'update houseSupport success'));
			}else{
				$this->response(array('result'=>'update houseSupport failed'));
			}			
		}else{
			$this->response(array('result'=>'table miss'));			
		}
	}
	function actionGetHouseLinks(){
		$req = WinBase::app()->getRequest();
		$info = house_links::model()->getFlush();
		if(empty($info['house_url'])){
			$this->response(array('result'=>'links is empty'));		
		}
		//状态标记为正在抓取
		house_links::model()->updateHouseLinks(array('parse_status'=>1),array('house_url'=>$info['house_url']));
		$this->response($info);
	}
	function actionUpdateHouseLinks(){
		$req = WinBase::app()->getRequest();
		$house_url = $req->getParam('house_url','');
		if(empty($house_url)){
			$this->response(array('result'=>'miss house_url value'));			
		}
		$data =array(
			'house_url'=> $req->getParam('house_url',''),
			'parse_status' =>$req->getParam('parse_status',2),
			'status' =>$req->getParam('status',1),
			'parse_date' =>TIMESTAMP
			);
		if(house_links::model()->updateHouseLinks($data,array('house_url'=>$house_url))){
			$this->response(array('result'=>true));
		}
	}
	function actionUpdateStoreLinks(){
		$req = WinBase::app()->getRequest();
		$agent_url = $req->getParam('agent_url','');
		if(empty($agent_url)){
			$this->response(array('result'=>'miss agent_url value'));				
		}
		$info = store_links::model()->getInfo(array('agent_url'=>$agent_url));
		if(empty($info['url'])){
			$this->response(array('result'=>'can not find the data in store_links database'));	
		}

		$data =array(
			'parse_status' =>$req->getParam('parse_status',2),
			'downloaded_count'=>$info['downloaded_count']+$req->getParam('downloaded_count',0),
			'fail_count'=>$info['fail_count']+$req->getParam('fail_count',0)			
			);
		if(store_links::model()->updateStoreLinks($data,array('agent_url'=>$agent_url))){
			$this->response(array('result'=>true));
		}		
	}
	function actionAddQRImage(){
		$req = WinBase::app()->getRequest();
		$num = $req->getParam('num',0);
		if($num>0){
			$token = WxApiTools::model()->getAccessToken();
			$res = WxApiTools::model()->getTicket($token,$num);
			if($ress = WxApiTools::model()->getQRImage($res,'qr'.$num)){
				$this->response(array('result'=>"get image success,url is :$ress"));
			}			
		}else{
			$this->response(array('result'=>"get image failed,miss num"));
		}

	}
}