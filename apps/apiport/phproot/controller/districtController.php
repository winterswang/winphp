<?php
class districtController extends ApiController {
    
    public function actionInfo(){
        $req = WinBase::app()->getRequest();
		$district_guid = $req->getParam('district_guid','');
		$page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',10);
		$res = district::model()->getInfo(array('district_guid'=>$district_guid));		
		if(empty($res)){
			$this->showError('9016','No district Found');
		}	
		//$res['house'] = $this->getHouseList($district_id,'district_id',$page_no,$page_size);
		$this->response($res);
    }
    private function getHouseList($keyword,$keyType,$page_no,$page_size){
    	$list = house_new::model()->getList(array($keyType=>$keyword),$page_no,$page_size);
    	$houseList = array();
    	foreach ($list as $key ) {
    			$photo = housePhoto::model()->getTopPhoto($key['house_guid']);
    			$i['title'] = $key['title'];
    			$i['house_guid'] = $key['house_guid'];
    			$i['sell_price'] = $key['sell_price'];
    			$i['title'] = $key['title'];
	            $i['room'] = $key['room'];
	            $i['hall'] = $key['hall'];
	            $i['square'] = $key['square'];  
	            $i['photo']= $photo['pic_url'];
	            $houseList[] =$i;
    		}
    	return $houseList;	
    }
    public function actionHouseList(){
        $req = WinBase::app()->getRequest();
		$district_guid = $req->getParam('district_guid',99999999);
		$page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',10);
        $district = district::model()->getInfo(array('district_guid'=>$district_guid));	
		$res = $this->getHouseList($district['district_guid'],'district_guid',$page_no,$page_size);
		if(empty($res)){
			$this->showError('9016','No House Found');
		}
		$this->response($res);		   	
    }
    public function actionXuequList(){
        $req = WinBase::app()->getRequest();
		$district_guid = $req->getParam('district_guid',999999999);    
		$page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',10);
		$res = district::model()->getInfo(array('district_guid'=>$district_guid));
		$xuequList = array();
		if(!empty($res)){
	        $list = xuequ_district::model()->getList(array('district_guid' =>$res['district_guid']));
	        foreach ($list as $key) {
	        	$xuequList['xuequ'][] = xuequ::model()->getInfo(array('xuequ_id'=>$key['xuequ_id']));
	        }			
		}
        $this->response($xuequList);
    }
}