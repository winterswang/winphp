<?php
session_start();
class districtController extends AppController {
    public function actionDetail() {
    	$req = WinBase::app()->getRequest();
        $district_guid = htmlspecialchars(base64_decode($req->getParam('district_guid')));   
        $res = $this-> api ->district_info($district_guid);
        $res1 = $this -> api -> district_xuequ($district_guid);
        //echo "<pre>";
        //print_r($res1);exit;
        $data = array();
        if(is_array($res)) {
            if(isset($res['error'])){
                $this->showMessage($res['msg']);
            }
            $data = array(
                'link'        => $res,
            	'uuid'        => $this -> uuid, 
                'district_guid' => $district_guid
            );

            if(count($res1)) {
                $data['xuequ'] = $res1['xuequ'];
            }
        }
        $this->setMeta('title','小区详情');
        $this->render("district_detail",$data);
    }

    public function actionHouse() {
        $req = WinBase::app()->getRequest();
        $district_guid = htmlspecialchars(base64_decode($req->getParam('district_guid'))); 
        $house_count = htmlspecialchars($req->getParam('house_count')); 
        $data = array(
            'uuid'         => $this -> uuid,
            'district_guid'=> $district_guid,
            'house_count'  => $house_count
        );
        $this -> setMeta('title', '小区房源');
        $this -> render('district_house', $data);
    }

    public function actionMoreHouse() {
        $req = WinBase::app()->getRequest();
        if ($req->isAjaxRequest()) {
            $page = $req->getParam('page_no',1);
            $pageSize = $req->getParam('page_size',7);
            $data = array();
            $district_guid = $req->getParam("district_guid",'');
            //学区名
            $data['district_guid'] = $district_guid;
            $res = $this -> api -> house_list($data, $page, $pageSize);
            //echo "<pre>";
            //print_r($res);exit;
            echo json_encode(array('list'=>$res));
            exit;
        }
    }

    public function actionList() {
        $req = WinBase::app()->getRequest();
        $xuequ_guid = htmlspecialchars(base64_decode($req->getParam("xuequ_guid")));
        $house_count = htmlspecialchars($req->getParam("house_count"));
        $xqArr = array('xuequ_guid' => $xuequ_guid);
        $res = $this->api->district_list($xqArr, $page = 1, $pageSize = 6);
        //echo "<pre>";
        //print_r($res);exit;
        if(is_array($res)) {
            if(isset($res['error'])){
                $this->showMessage($res['msg']);
            }
            $data = array(
                'link'          => $res,
                'uuid'          => $this -> uuid,
                'path'          => Config::getConfig('system','attach_url'),
                'xuequ_guid'    => $xuequ_guid,
                'house_count'   => $house_count
            );
        }
        $this->setMeta('title','对应小区');
        $this->render('district_list', $data);

    }

}
?>