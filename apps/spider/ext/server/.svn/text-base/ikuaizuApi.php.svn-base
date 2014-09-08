<?php

include(dirname(__FILE__).DIRECTORY_SEPARATOR.'httpClient.php');

class ikuaizuApi
{
    private $_auth;
    
    public $version = '1.0';
    
    public $format = 'json';

    function __construct($client_key,$client_secret,$header = array()){
        
        
        $_header = array();
        $_header[] = 'version: '.$this->version;
        $_header[] = 'clientId: '.$client_key;
        $_header[] = 'timeStamp: '.TIMESTAMP;
        $_header[] = 'platform: '. (isset($header['platform']) ? $header['platform'] : 'weixin');
        $_header[] = 'model: '. (isset($header['model']) ? $header['model'] : 'xxx');
        $_header[] = 'osVersion: '. (isset($header['osVersion']) ? $header['osVersion'] : '1.0');
        $_header[] = 'uuid: '. (isset($header['uuid']) ? $header['uuid'] : '');
        $_header[] = 'latlng: 0,0';

        $this->_auth = new httpClient($client_key,$client_secret,$_header);   
    }
    
    function api($script,$data=array(),$mothed = 'get',$multi = false){
		$response = $this->_auth->$mothed($script,$data,$multi);
        if ($this->format === 'json') {
			$json_res = json_decode($response, true);
			
			if(json_last_error() == JSON_ERROR_NONE) {
				return $json_res;
			}
		}
		return $response;
    }
    
    function index(){
        return $this->api('',array());
    }	   
	function spider_import($data){
		return $this->api('spider/import',$data,'post');
	}
    function spider_importHouse($data){
        return $this->api('spider/importHouse',$data,'post');
    }
    function spider_offSellHouse($data){
        return $this->api('spider/offSellHouse',$data,'post');
    }
    function spider_importDistrict($data){
        return $this->api('spider/importDistrict',$data,'post');
    }
	function spider_importAgent($data){
        return $this->api('spider/importAgent',$data,'post');
    }
    function spider_updateAgent($data){
        return $this->api('spider/updateAgent',$data,'post');
    }
    function spider_updateDistrict($data){
        return $this->api('spider/updateDistrict',$data,'post');
    }
    function spider_updateDistrict_5i5j($data){
        return $this->api('spider/updateDistrict_5i5j',$data,'post');
    }

    function spider_importXuequ($data){
        return $this->api('spider/importXuequ',$data,'post');
    }

    function spider_importXuequ_district($data){
        return $this->api('spider/importXuequDistrict',$data,'post');
    }

	function spider_district($data){
		return $this->api('spider/district',$data,'post');
	}
	
	function district_flush(){
		return $this->api('district/flush',array(),'get');
	}
    function spider_importKeyValue($data){
        return $this->api('spider/importKeyValue',$data,'get');
    }
	
    function system_preload(){
        return $this->api('system/preload',array());
    }
    
    function district_publish($data){
        return $this->api('district/publish',$data,'post');
    }
    
    function district_search($keyword){
        $data = array(
            'keyword' => $keyword
        );
        
        return $this->api('district/search',$data,'get');
    }
    
    function house_pubilsh($data){
        return $this->api('house/publish',$data,'post');
    }
    
    function photo_upload($house_guid,$pic){
		$data  = array(
			'house_guid' => 0,
			'filename' => '@'.$pic,
			
		);
        return $this->api('photo/upload',$data,'post',true);
    }
    
	function photo_upload_url($house_guid,$pic)
	{
		$data  = array(
			'house_guid' => $house_guid,
			'url' => $pic,
		);
		return $this->api( 'photo/upload', $data,'post');
	}
    
    function house_renthouse($data = array()){
        return $this->api('house/renthouse',$data,'get');
    }    
    
    function house_info($data){
        return $this->api('house/info',$data,'get');
    }
    function data_houseLinks($data=array()){
        return $this->api('data/getHouseLinks',$data,'post');
    }
    function data_updateHouseLinks($data=array()){
        return $this->api('data/updateHouseLinks',$data,'post');
    }
    function data_updateStoreLinks($data=array()){
        return $this->api('data/updateStoreLinks',$data,'post');
    }    
    ///API测试用例
    function api_test(){
        //$data = array('city'=>'北京市','district'=>'','type'=>'','level'=>'');
        //$data = array('city'=>'北京市','district'=>'通州','type'=>'中学','level'=>'');
        //$data = array('school_name'=>'北京市安慧北里中学','room'=>'5+','min_sell_price'=>400,'max_sell_price'=>1000,'page_no'=>1,'page_size'=>8);
        //$data = array('school_name'=>'北京市海淀区中关村第三小学','page_no'=>13,'page_size'=>10);
        //$data = array('agent_guid'=>'1000000366','page_no'=>1,'page_size'=>7);
        //$data = array('keyword'=>'清华大学','page_no'=>1,'page_size'=>10);
        //$data = array('house_guid' =>1000000766);
        //$data = array('xuequ_guid'=>1000000366,'page_no'=>1,'page_size'=>10);
        //$data = array('district_guid'=>'');//1000006176
        //$data = array('district_id'=>'c-dahezhuangyuan560');
        //$data =array('telephone'=>222222222,'openId'=>'otSWhjmMHrWGUtfxmR8DofpaBtkw','agentName'=>'xxxx','store_url'=>'','agent_wx_id'=>'','wx_nickname'=>'');
        //return $this->api('xuequ/districtList',$data,'post');  
        //return $this->api('xuequ/info',$data,'post'); 
        $data = array('clientOpenId'=>'oMJ6NjnnUSjsLBOJDIbzgV1rnrgk');    
        //return $this->api('district/houseList',$data,'post');               
        //return $this->api('district/info',$data,'post');  
        //return $this->api('district/xuequList',$data,'post');   
        //return $this->api('xuequ/houseList',$data,'post');
        //return $this->api('xuequ/schoolListByKeyword',$data,'post');           
        //return $this->api('house/info',$data,'post');
        //return $this->api('data/addQRImage',$data=array('num'=>$num),'get');
        //return $this->api('agent/addAgentClient',$data ,'post');
        return $this->api('agent/uploadImage',$data ,'post');        
        //return $this->api('house/InfoTest',$data=array('house_guid'=>1000000001),'post');
        //return $this->api('house/list',$data=array('uid'=>'oHd91juHNChysSwppzuae5XKokl0'),'post');
        // return $this->api('data/getHouseLinks',$data=array(),'post');
        // return $this->api('data/getHouseLinks',$data=array(),'post');  
        //return $this->api('xuequ/schoolList',$data,'post'); 
        //return $this->api('search/hotXuequ',$data=array(),'post');     
        //return $this->api('search/xuequ',$data,'post');
        //return $this->api('search/districtTest',$data,'post');
        //return $this->api('agent/houseList',$data,'post');    
    }
    function data_updateHouseSupport($data = array()){
        return $this->api('data/updateHouseSupport',$data,'get');
    }
    function spider_importXueDistrict($data =array()){
        return $this->api('spider/importXueDistrict',$data,'get');
    }  
}