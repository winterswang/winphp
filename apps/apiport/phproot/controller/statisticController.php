<?php
class statisticController extends ApiController
{
	
	public function validate(){
		return array(
			'post' => array('publish'),
			//'auth' => array('publish'),
			'publish' => array()
		);
	}
	
	public function actionView(){
		
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);
		
		$where = array(
			'starttime' => strtotime("-7 day"),
			'endtime' => strtotime("-1 day"),
			'objtype' => 'house',
			'objid' => $house_guid
		);
		
		$logs = statistic::model()->getStatView($where);
		
		$datagroup = array();
		for($i = 7; $i > 0; $i--){
			$data = date('m月d日',strtotime("-$i day"));
			$datagroup[$data] = 0;
		}
		
		foreach($logs as $l){
			$data = date('m月d日',$l['dateline']);
			$datagroup[$data] = $l['counting'];
		}

		$res = array(
			"data" => array(
				array(
					"data" => array_values( $datagroup),
					"title" =>  "sevn days" 
				),
			),
			"x_labels" => array_keys($datagroup)
		);
		
		$this->response($res);		
	}	

	public function actionFavorite(){
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);
		
		$where = array(
			'starttime' => strtotime("-7 day"),
			'endtime' => strtotime("-1 day"),
			'objtype' => 'house',
			'objid' => $house_guid
		);
		
		$logs = statistic::model()->getStatFavorite($where);
		
		$datagroup = array();
		for($i = 7; $i > 0; $i--){
			$data = date('m月d日',strtotime("-$i day"));
			$datagroup[$data] = 0;
		}
		
		foreach($logs as $l){
			$data = date('m月d日',$l['dateline']);
			$datagroup[$data] = $l['counting'];
		}

		$res = array(
			"data" => array(
				array(
					"data" => array_values( $datagroup),
					"title" =>  "sevn days" 
				),
			),
			"x_labels" => array_keys($datagroup)
		);
		
		$this->response($res);
	}
	
	public function actionMarket(){
	/*
		$req = WinBase::app()->getRequest();
		$house_guid = $req->getParam('house_guid',0);
		
		$where = array(
			'starttime' => strtotime("-7 day"),
			'endtime' => strtotime("-1 day"),
			'objtype' => 'house',
			'objid' => $house_guid
		);
		
		$res = house::model()->getInfoByGuid($house_guid);
		
		$logs = statistic::model()->getStatFavorite($where);
		
		$datagroup = array();
		for($i = 7; $i > 0; $i--){
			$data = date('m月d日',strtotime("-$i day"));
			$datagroup[$data] = 0;
		}
		
		foreach($logs as $l){
			$data = date('m月d日',$l['dateline']);
			$datagroup[$data] = $l['counting'];
		}

		$res = array(
			"data" => array(
				array(
					"data" => array_values( $datagroup),
					"title" =>  "sevn days" 
				),
			),
			"x_labels" => array_keys($datagroup)
		);	
	*/
		$this->response($res);
	}
	
	public function actionPeriod(){
	
		$this->response($data);
	}
}
?>