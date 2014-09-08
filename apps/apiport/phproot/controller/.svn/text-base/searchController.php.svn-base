<?php
class searchController extends ApiController {
    
    public function actionIndex(){

    }

    public function actionKeyValue(){
        $req = WinBase::app()->getRequest(); 
        $keyword = $req->getParam('keyword','');
        if(!empty($keyword)){
            $keyword = str_replace(array('?','!','(',')',':','`','`','"','"','.'),'',$keyword);
            $keyword = preg_replace('/\s+/',' ',$keyword);                  
        }
        $list =keyMap::model()->getList(array('keyword'=>$keyword));
        $data = array();
        foreach ($list as $key) {
            $info = array();
            $info['value'] = $key['value'];
            $info['type'] = $key['type']; 
            $data[] = $info; 
        }
        $data['length'] = count($list);
        $this->response($data);        
    }

    public function actionDistrict(){
        $req = WinBase::app()->getRequest();
        $page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',10);
        $keyword = $req->getParam('keyword','');
        if(!empty($keyword)){
            $keyword = str_replace(array('?','!','(',')',':','`','`','"','"','.'),'',$keyword);
            $keyword = preg_replace('/\s+/',' ',$keyword);                  
        }   
        $district = district::model()->getSimpleInfo(array('district_name'=>$keyword));
        $data = array();
        if($district['district_guid']){
            $data = $this->getHouseList(array('district_guid'=>$district['district_guid']),$page_no,$page_size);//房源数据
            $photo = districtPhoto::model()->getTopPhoto($district['district_guid']);
            $data['length'] =count($data['house']);
            $district['photo'] =$photo['pic_url'];
        }
        $data['top'] =$district;

        $this->response($data); 
    } 

    public function actionXuequ(){
        $req = WinBase::app()->getRequest();
        $page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',10);
        $keywords = array(
           'school_name'  =>$req->getParam('school_name',''),
           'room' => $req->getParam('room',0),
           'min_sell_price' => $req->getParam('min_sell_price',''),
           'max_sell_price' => $req->getParam('max_sell_price',''),          
           'min_square' => $req->getParam('min_square',''),
           'max_square' => $req->getParam('max_square',''),          
            );
        if(!empty($keywords)){
            foreach ($keywords as $key=>$words) {
                $words = str_replace(array('?','!','(',')',':','`','`','"','"','.'),'',$words);
                $keywords[$key] = preg_replace('/\s+/',' ',$words);   
            }              
        }
        $count = 0;
        $xuequ = xuequ::model()->getSimpleInfo(array('school_name'=>$keywords['school_name']));
        $districtList = xuequ_district::model()->getList(array('xuequ_id' =>$xuequ['xuequ_id']));
        $data = array('house'=>array());
        $startNum = ($page_no-1)*$page_size;
        foreach ($districtList as $key ) {

            $keywords['district_guid'] = $key['district_guid'];
            $houseList = house_new::model()->getSimpleList($keywords);
            $count += count($houseList);
             foreach ($houseList as $key)
             {
                if($startNum-->0){
                    continue;
                }
                $photo = housePhoto::model()->getTopPhoto($key['house_guid']);
                $key['photo'] = $photo['pic_url'];
                $data['house'][] =$key; 
                if(1>=$page_size--){
                    break 2;
                }
            }             
        }
        $data['length'] = $count; 
        $data['top'] =$xuequ;
        $this->response($data);
    } 
    function actionHotXuequ(){
       $hotList =  xuequHot::model()->getList();
       $this->response($hotList);
    }
    private function getHouseList($keywords=array(),$page_no,$page_size){
        $data = array();
        $houseList = house_new::model()->getSimpleList($keywords,$page_no,$page_size);
        $count = house_new::model()->getCount($keywords);
        foreach ($houseList as $key ) {
            $i['house_guid'] = $key['house_guid'];
            $i['title'] = $key['title'];
            $i['room'] = $key['room'];
            $i['hall'] = $key['hall'];
            $i['square'] = $key['square'];  
            $i['sell_price'] = $key['sell_price'];              
            $photo = housePhoto::model()->getTopPhoto($key['house_guid']);
            $i['photo'] = $photo['pic_url'];
            $data['house'][]=$i;
        }
        return $data;       
    }

}