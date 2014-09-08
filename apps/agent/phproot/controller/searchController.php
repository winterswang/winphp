<?php

class searchController extends AppController { 
    

    public function actionMoreXuequ() {
        $req = WinBase::app()->getRequest();
        if ($req->isAjaxRequest()) {
        	$page = $req->getParam('page_no',1);
            $pageSize = $req->getParam('page_size',7);
	        $data = array();
	        $school_name = $req->getParam("school_name",'北京市海淀区中关村第一小学');
	        //学区名
	        $data['school_name'] = $school_name;
	        //房型
	        $room = $req -> getParam('room','');
	        if ($room > 0 && $room <= 5) {
				$data['room'] = $room;
	        } else if($room > 5) {
	        	$data['room'] = '5+';
	        }
	        //面积
	        $square = $req -> getParam('square','');
	        if($square > 0 && $square < 200) {
				$area_filter = explode('-', $square);
				$data['min_square'] = $area_filter[0];
				$data['max_square'] = $area_filter[1];
			} elseif($square == '0-50') {
				$data['min_square'] = '0';
				$data['max_square'] = '50';
			} elseif($square == 200) {
				$data['min_square'] = $square;
			}
			//价格 
	        $price = $req -> getparam('price','');
	        if ($price > 0 && $price < 1000) {
				$price_filter = explode('-', $price);
				$data['min_sell_price'] = $price_filter[0];
				$data['max_sell_price'] = $price_filter[1];
			} elseif($price == '0-100') {
				$data['min_sell_price'] = '0';
				$data['max_sell_price'] = '100';
			} elseif($price == 1000) {
				$data['min_sell_price'] = $price;
			}
	        $res = $this -> api -> search_xuequ($data, $page, $pageSize);
	        //echo "<pre>";
	        //print_r($res);exit;
            echo json_encode(array('list'=>$res['house'], 'top'=>$res['top']));
            exit;
   		}
    }

    public function actionXuequ() {
    	$req = WinBase::app()->getRequest();
        $school_name = $req->getParam("school_name",'北京市海淀区中关村第一小学');
        $room = $req->getParam("room", '');
        $square = $req->getParam("square",'');
		$price = $req->getParam("price",'');
		
        $data = array(
	        'search_name' => $school_name,
	        'path' => Config::getConfig('system','attach_url'),
	        'room' => $room,
	        'square' => $square,
	        'price' => $price
        );
        $data = array_merge($data,Config::getConfig('house'));
		
        $this -> setMeta('title', $school_name);
        $this -> render("house_list",$data);
    }
	
	/**
	 * 学区找房
	 */
	public function actionSchoolSelect() {
		$req = WinBase::app()->getRequest();
		$data = Config::getConfig('house');
		$data['refer'] = $req->getParam("refer",'/search/xuequ');
		//$data['district_default'] = 3;
		//$data['school_type_default'] = 2;
		//$data['level_default'] = 1;
		$this -> setMeta('title', '学区找房');
		$this->render("school_list", $data);
	}
	
	/**
	 * 通过过滤条件加载学校
	 */
	private function getSchoolListByFilter($req) {
		$configHouse = Config::getConfig('house');
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
		
		$page_no = (int)$req->getParam('page', 1);
		$data['page_no'] = $page_no;
		return $this->api->school_list($data);		
	}
	
	/**
	 * 通过关键词搜索学校
	 */
	private function searchSchoolByKeyword($req) {
		$data = array();
		$keyword = $req->getParam('keyword', '');
		$data['keyword'] = $keyword;
		$page_no = (int)$req->getParam('page', 1);
		$data['page_no'] = $page_no;
		return $this->api->school_search($data);
	}
	
	/*
	 * 学区找房更多列表
	 */
	public function actionSchoolListData() {
		$configHouse = Config::getConfig('house');
		$req = WinBase::app()->getRequest();
		if ($req->isAjaxRequest()) {
			$search_by = $req->getParam('searchby','');
			if ($search_by == 'keyword') {
				$res = $this->searchSchoolByKeyword($req);
			} else {
				$res = $this->getSchoolListByFilter($req);
			}
			//echo "<pre>";
			//print_r($res);exit;
			echo json_encode(array('root'=>$res));
		}
	}
	
	
    //加载更多房源
    public function actionMore() {
        header("Content-type: text/html; charset=utf-8");
        $req = WinBase::app()->getRequest();
        if($req->isAjaxRequest()){
            $district_name = $req->getParam('district_name','');
            $page = $req->getParam('page_no',1);
            $pageSize = $req->getParam('page_size',7);
            $search = array(
                'keyword'=>$district_name
            );
            $res = $this->api->search_house($search,$page,$pageSize);
            if(isset($res['error']) || !$res['length']) {
            echo json_encode(array('error'=>1,'msg'=>'没有找到更多符合"'.$district_name.'" 的小区的房源'));
            exit;
            }
            echo json_encode(array('list'=>$res['data'],'length'=>$res['length']));
            exit; 
        }
    }
	

}