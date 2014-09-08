<?php
class xuequController extends ApiController
{
    public function actionInfo(){
    	$req = WinBase::app()->getRequest();
    	$xuequ_guid = $req->getParam('xuequ_guid',999999999);
    	if(!empty($xuequ_guid)){
			$xuequ_guid = str_replace(array('?','!','(',')',':','`','`','"','"','.'),'',$xuequ_guid);
			$xuequ_guid = preg_replace('/\s+/',' ',$xuequ_guid);    	    		
    	}
    	$xuequ =xuequ::model();

    	$data = array();    	
    	$xuequInfo= $xuequ->getInfo(array('xuequ_guid' => $xuequ_guid));
    	$data['data'] = $xuequInfo;
    	$data['length'] = 1;
    	$this->response($data);
    }


    public function actionDistrictList(){
        $req = WinBase::app()->getRequest();
        $xuequ_guid = $req->getParam('xuequ_guid',0);
        $page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',10);
        $xuequ = xuequ::model()->getInfo(array('xuequ_guid' => $xuequ_guid));
        $list =xuequ_district::model()->getList(array('xuequ_id'=>$xuequ['xuequ_id']),$page_no,$page_size);
        $data = array();
        foreach ($list as $key) {
             $district = district::model()->getInfo(array('district_guid' =>$key['district_guid']));
             if(!empty($district)){
                    $photo = districtPhoto::model()->getTopPhoto($district['district_guid']);
                    if(!empty($photo)){
                         $district['photo'] =$photo['pic_url'];            
                    }
                    $data[] = $district;                 
                }
            }    
        $this->response($data);     
    }

    public function actionHouseList(){
        $req = WinBase::app()->getRequest();
        $xuequ_guid = $req->getParam('xuequ_guid',0);
        $page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',7);
        $xuequ = xuequ::model()->getInfo(array('xuequ_guid' => $xuequ_guid));
        $districtList = xuequ_district::model()->getList(array('xuequ_id' =>$xuequ['xuequ_id']));
        $data = array(); 
        $startNum = ($page_no-1)*$page_size;
        foreach ($districtList as $key ) {
            $houseList = house_new::model()->getSimpleList(array('district_guid' =>$key['district_guid'])); 
             foreach ($houseList as $key ){
                if($startNum-->0){
                    continue;
                }
                $photo =housePhoto::model()->getTopPhoto($key['house_guid']);
                $key['photo'] = $photo['pic_url'];
                $data['house'][] =$key;
                if(1>=$page_size--){
                    break 2;
                } 
            }           
        } 
        $this->response($data);                                  
    }

    public function actionSchoolList(){
        $req = WinBase::app()->getRequest();
        $city = $req->getParam('city','北京市');
        $district = $req->getParam('district','');//可能为空
        if(!empty($district)){
            $num = strrpos($district,'区');
            if(!$num){
                $district=$district.'区';               
            }
        }
        $type = $req->getParam('type','');
        $level = $req->getParam('level','');
        $is_hot = $req->getParam('is_hot',0);
        $page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',10); 
        $queryArray = array('school_city'=>$city,'xuequ_region'=>$district,'school_level'=>$level,'school_type'=>$type,'is_hot'=>$is_hot);
        $schoolList = xuequ::model()->getSchoolList($queryArray,$page_no,$page_size);
        $this->response($schoolList);               
    }
    public function actionSchoolListByKeyword(){
        $req = WinBase::app()->getRequest();
        $keyword = $req->getParam('keyword','');
        $page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',10);
        file_put_contents('/data/wwwlogs/userSearch.log', $keyword."  ".date("Y-m-d H:i:s")."\r\n",FILE_APPEND);
        $data = array();
        if(!empty($keyword)){
             $result =  solrTools::model()->search('keyword',$keyword,($page_no-1)*$page_size,$page_no*$page_size,null);
             if($result['numFound']>0){

                foreach ($result['docs'] as $key => $value) {
                    $xuequInfo = xuequ::model()->getInfo(array('school_name'=>$value['value']));
                    $info = array();
                    $info['school_name'] = $xuequInfo['school_name'];
                    $info['xuequ_guid'] = $xuequInfo['xuequ_guid'];
                    $info['house_count'] = $xuequInfo['house_count'];
                    $info['house_price'] = $xuequInfo['house_price'];
                    $info['school_level'] =  $xuequInfo['school_level'];
                    $info['school_photo'] =$xuequInfo['school_photo'];
                    $data[]=$info;
                }
             }
         }
         $this->response($data);             
    }
}