<?php

include(dirname(__FILE__)."/../libraries/".'HttpClient.php');

class IKuaiZuApi
{
    private $_http;
    
    public $version = '1.0';
    
    public $format = 'json';

    function __construct( $header = array(), $client_key = '1002', $client_secret = 'f9436a7ffec39ddd32f85fcf177274a9'){
        
        $_header = array();
        $_header[] = 'version: '.$this->version;
        $_header[] = 'clientId: '.$client_key;
        $_header[] = 'timeStamp: '.TIMESTAMP;
        $_header[] = 'platform: '. (isset($header['platform']) ? $header['platform'] : 'weixin');
        $_header[] = 'model: '. (isset($header['model']) ? $header['model'] : 'xxx');
        $_header[] = 'osVersion: '. (isset($header['osVersion']) ? $header['osVersion'] : '1.0');
        $_header[] = 'uuid: '. (isset($header['uuid']) ? $header['uuid'] : '');
        $_header[] = 'latlng: 0,0';

        $this->_http = new httpClient($client_key,$client_secret,$_header);
    }
    
    function request($script,$data=array(),$mothed = 'get',$multi = false){
		$response = $this->_http->$mothed($script,$data,$multi);
        if ($this->format === 'json') {
			$res = json_decode($response, true);
			if(json_last_error() != JSON_ERROR_NONE) {				
				return array('error' => 9999,'msg'=>'server error');
			}
		}
		if(!isset($res['status']) || $res['status'] != '0000'){
			return array('error' => $res['status'],'msg'=>$res['info']);
		}
		return $res['data'];
    }	
    
    function index(){
        return $this->request('',array());
    }

    /**
	 * 获取房屋信息
	 * 输入: 房屋的guid,
	 * 输出: json格式
	 * 
	 */    
    function house_info($house_guid){
        return $this->request('house/info',array('house_guid'=>$house_guid),'get');
    }

    function house_list($data = array(),$page =1,$pageSize = 7){
        $data = array_merge($data, array('page_no' => $page,'page_size'=>$pageSize));
        return $this->request('district/houseList',$data,'get');
    }
	
    function search_district($data = array(),$page =1,$pageSize = 20){
        $data = array_merge($data, array('page_no' => $page,'page_size'=>$pageSize));
        return $this->request('search/district',$data,'get');
    }
	
	function search_xuequ($data = array(),$page =1,$pageSize = 20){
		$data = array_merge($data, array('page_no' => $page,'page_size'=>$pageSize));
		return $this->request('search/xuequ',$data,'get');
	}
	
	function district_xuequ($district_guid){
        return $this -> request('district/xuequList',array('district_guid'=>$district_guid),'get');
    }

    function search_house($data = array(),$page =1,$pageSize = 20){
        $data = array_merge($data, array('page_no' => $page,'page_size'=>$pageSize));
        return $this->request('search/house',$data,'get');
    }

    function xuequ_info($xuequ_guid){
        return $this -> request('xuequ/info',array('xuequ_guid'=>$xuequ_guid),'get');
    }

    function xuequ_house($data = array(),$page =1,$pageSize = 7){
        $data = array_merge($data, array('page_no' => $page,'page_size'=>$pageSize));
        return $this -> request('xuequ/houseList',$data,'get');
    }

    function district_info($district_guid){
        return $this -> request('district/info',array('district_guid'=>$district_guid),'get');
    }

    function district_list($data = array(),$page =1,$pageSize = 20){
        $data = array_merge($data, array('page_no' => $page,'page_size'=>$pageSize));
        return $this->request('xuequ/districtList',$data,'get');
    }
	
    function agent_info($agent_guid){
        return $this -> request('agent/info',array('agent_guid'=>$agent_guid),'get');
    }

    function agent_house($data = array(),$page =1,$pageSize = 20){
        $data = array_merge($data, array('page_no' => $page,'page_size'=>$pageSize));
        return $this -> request('agent/houseList',$data,'get');
    }
	
	function school_list($data) {
		return $this -> request('xuequ/schoollist', $data);
	}

    function hot_school($data) {
        return $this -> request('search/hotXuequ', $data);
    }
	
	function school_search($data) {
		$res = $this -> request('xuequ/SchoolListByKeyword', $data);
		return $res;
	}
	/**
	 * 判断用户输入Query的类型
	 */
	function query_parse($data = array()) {
		return $this->request('search/keyvalue', $data, 'get');
	}
    function house_media($data=array()){
        return $this->request('house/media',$data,'get');
    }
    function get_agent_wx($data=array()){
        return $this->request('agent/getAgentWx',$data,'get');
    }
    function add_agent_wx($data=array()){
        return $this->request('agent/addAgentWx',$data,'post');
    }
    function add_agent_client($data=array()){
        return $this->request('agent/addAgentClient',$data,'post');
    }
    function get_client_agent($data=array()){
        return $this->request('agent/getClientAgent',$data,'post');
    }
    function get_my_store_url($data=array()){
        return $this->request('agent/getMyStoreUrl',$data,'post');
    }    
    function upload_image($data=array()){
        return $this->request('agent/uploadImage',$data,'post');
    }
    function add_user_vsfwx($data=array()){
        return $this->request('user/addUserVsfWx',$data ,'post');
    }
    function get_user_vsfwx($data=array()){
        return $this->request('user/getUserVsfWx',$data ,'post');
    }   
}