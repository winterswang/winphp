<?php
session_start();
class SchoolController extends AppController
{
    public function actionHot() {
        $req = WinBase::app()->getRequest();
        $data = Config::getConfig('house');
        $data['refer'] = $req->getParam("refer",'/search/xuequ');
        $this -> setMeta('title','热门学校');
        $this->render("school_hot", $data);
    }

    public function actionSchoolHotData() {
        $configHouse = Config::getConfig('house');
        $req = WinBase::app()->getRequest();
        if ($req->isAjaxRequest()) {
            $data = array();
            $district = (int)$req->getParam('district', 0);
            if ($district > 0 && $district <= 16) {
                $district_filter = $configHouse['district_filter'];
                $data['district'] = $district_filter[$district];
            }  
            
            $school_type = (int)$req->getParam('school_type', 0);
            if ($school_type > 0 && $school_type <= 3) {
                $school_filter = $configHouse['school_type_filter'];
                $data['type'] = $school_filter[$school_type];
            } 
            $level = $req->getParam('level', 0);
            if ($level > 0 && $level <= 3) {
                $level_filter = $configHouse['level_filter'];
                $data['level'] = $level_filter[$level];
            } 
            $data['is_hot'] = 1;
            
            //$page_no = (int)$req->getParam('page', 1);
            //$data['page_no'] = $page_no;
            //$page_size = $req-> getParam('page_size', '10');
            $res = $this->api->school_list($data);
            //echo "<pre>";
            //print_r($res);exit;
            echo json_encode(array('root'=>$res));
        }
        
    }
	
	public function actionIntro() {
        //if($this -> _cache -> check()) {
            //$this -> _cache -> read_cache();  
        //} else {
            $req = WinBase::app()->getRequest();
            $xuequ_guid = htmlspecialchars(base64_decode($req->getParam("xuequ_guid")));
            $res = $this->api->xuequ_info($xuequ_guid);
            //echo "<pre>";
            //print_r($res);exit;
            if(is_array($res)) {
                if(isset($res['error'])){
                    $this->showMessage($res['msg']);
                }
                $data = array(
                    'link'          => $res['data'],
                    'uuid'          => $this -> uuid,
                    'xuequ_guid'    => $xuequ_guid 
                );
            }
            $this->setMeta('title',$res['data']['school_name']);
            $this->render('school_introduce',$data);
            //$this -> _cache -> create_cache();
        //}
    }

    
    public function actionHouse() {
        $req = WinBase::app()->getRequest();
        $xuequ_guid = htmlspecialchars(base64_decode($req->getParam("xuequ_guid")));
        $house_count = htmlspecialchars($req->getParam("house_count"));
        $data = array(
            'xuequ_guid'    => $xuequ_guid,
            'uuid'          => $this -> uuid,
            'house_count'   => $house_count
        );
        $this -> setMeta('title', '学区房源');
        $this -> render('school_house', $data);
    }
    

    public function actionMoreHouse() {
        $req = WinBase::app()->getRequest();
        if ($req->isAjaxRequest()) {
            $page = $req->getParam('page_no',1);
            $pageSize = $req->getParam('page_size',7);
            $data = array();
            $xuequ_guid = $req->getParam("xuequ_guid",'');
            //学区名
            $data['xuequ_guid'] = $xuequ_guid;
            $res = $this -> api -> xuequ_house($data, $page, $pageSize);
            //echo "<pre>";
            //print_r($res);exit;
            if(!empty($res)) {
                if($res['house']) {
                    echo json_encode(array('list'=>$res['house']));
                    exit;
                } 
            } else {
                echo json_encode(array('list'=>$res));
                exit;
            }

        }
    }

    public function actionQa() {
        $req = WinBase::app()->getRequest();
        $xuequ_guid = htmlspecialchars(base64_decode($req->getParam("xuequ_guid")));
        $data = array(
            'uuid'          => $this -> uuid,
            'xuequ_guid'    => $xuequ_guid
        );
        $this -> setMeta('title', '学校问答');
        $this -> render('school_qa',$data);
    }
}
?>