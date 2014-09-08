<?php

include(dirname(__FILE__).DIRECTORY_SEPARATOR.'httpClient.php');

class smsExt
{
    private $_http;
    
	public $host = "http://221.179.180.158:9001/";
	
    public $version = '1.0';
    
    public $format = 'xml';
	
	public $public_data = array();

    function __construct($user,$pass){
		$this->public_data = array(
			'OperID' => $user,
			'OperPass' => $pass
		);

        $this->_http = new httpClient($this->host);   
    }
	
	function getError($code){
		$message_arr = array(
			'00' => '批量短信提交成功 (批量短信待审批)',
			'01' => '批量短信提交成功 (批量短信跳过审批环节)',
			'02' => 'IP限制',
			'03' => '单条短信提交成功',
			'04' => '用户名错误',
			'05' => '密码错误',
			'06' => '剩余条数不足',
			'07' => '信息内容中含有限制词(违禁词)',
			'08' => '信息内容为黑内容',
			'09' => '该用户的该内容 受同天内，内容不能重复发 限制',
			'10' => '批量下限不足',
			'97' => '短信参数有误',
			'98' => '防火墙无法处理这种短信',
			'99' => '短信参数无法解析'
		);


	}
    
    function api($script,$data=array(),$mothed = 'get',$multi = false){
		$response = $this->_http->$mothed($script,$data,$multi); 
        if ($this->format === 'json') {
			return json_decode($response, true);
		}else if($this->format === 'xml'){
			return simplexml_load_string($response);
		}
		return $response;
    }
    
    function post_msg($content,$to,$type = 8,$sendtime = 0,$keeptime = 0){
		
		//$content = urlencode($content);
		$content = iconv('UTF-8','GBK', $content);
		
		if(is_array($to)){
			$to = implode(',',$to);
		}
		
		$data = array(
			'Content' => $content,
			'ContentType' => $type,
			'DesMobile' => $to,
			'SendTime' => '',
			'ValidTime' => ''
		);
		
		if($sendtime > 0){
			$data['SendTime'] = date('YmdHis',$sendtime);
		}
		
		if($keeptime > 0){
			$data['SendTime'] = date('YmdHis',$keeptime);
		}
		
		$data = array_merge($this->public_data,$data);
        return $this->api('QxtSms/QxtFirewall',$data,'post');
    }
    
    function check_balance(){
		$data = $this->public_data;
        return $this->api('QxtSms/surplus',$data,'get');
    }

}