<?php
require_once(dirname(__FILE__)."/../ext/IKuaiZuApi.php");
class WeixinController extends BaseController{
	
	private $_wx = null;
	public $api;
	
	public function init(){
		echo "test in WeixinController";
		if(!$this->checkSignature()){
			//die("Invalid signature");
		}

		if(!$this->wxRep()->listening()){
			throw new Exception($this->wxRep()->error());
		}
		
		$type = $this->wxRep()->MsgType;
		//echo $type;exit;
		if(!$type){
			throw new Exception($this->wxRep()->error());
		}
		$uuid = $this->wxRep()->FromUserName;
        $this->api = new IKuaiZuApi(array('uuid'=>$uuid));
		$this->routing($type);
	}
	
	public function wxRep(){
		if(!$this->_wx){
			$this->_wx = new weixinResponse();
		}
		
		return $this->_wx;
	}
	
    private function checkSignature()
    {
		
        $req = WinBase::app()->getRequest();
        $signature = $req->getParam("signature");
        $timestamp = $req->getParam("timestamp");
        $nonce = $req->getParam("nonce");    
        
        $token = WinBase::app()->getSetting('weixin.token');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
	
	function routing($msgtype){

		$action = '';
		if($msgtype == 'event'){
			$event = $this->wxRep()->Event;
			//echo $event;exit;
			if($event == "CLICK"){
				$action = 'navigation';
			}else{
					$action = $event;
			}				
		}else{
			$action = $msgtype;
		}
		
		$classname = 'action'.ucfirst($action);
		if(!method_exists($this,$classname)){
			die('no method found');
		}
		//echo $classname;exit;
		$obj = $this->wxRep();
		$this->$classname($obj);
	}
	
	public function getHelp($project){
		return Config::getConfig('weixin',$project."_help");
	}	
	
	public function respond_text($content,$to = '',$FuncFlag = 0){
	
		$data = array(
			'ToUserName' => '<![CDATA['.$this->wxRep()->FromUserName.']]>',
			'FromUserName' => '<![CDATA['.$this->wxRep()->ToUserName.']]>',
			'CreateTime' => TIMESTAMP,
			'MsgType' => '<![CDATA[text]]>',
			'Content' => '<![CDATA['.$content.']]>',
			'FuncFlag' => $FuncFlag
		);

		$this->_output($data);
	}
	
	public function respond_news($news=array(),$FuncFlag = 0){
		
		$articles = array();
		
		foreach($news as $v){
			$item = array();
			$item['Title'] = '<![CDATA['.$v['title'].']]>';
			$item['Description'] = isset($v['description']) ? '<![CDATA['.$v['description'].']]>' : '<![CDATA[]]>';
			$item['PicUrl'] = isset($v['picurl']) ? '<![CDATA['.$v['picurl'].']]>' : '<![CDATA[]]>';
			$item['Url'] = isset($v['url']) ? '<![CDATA['.$v['url'].']]>' : '<![CDATA[]]>';
			$articles[] = array('item' => $item);
		}
		
		$data = array(
			'ToUserName' => '<![CDATA['.$this->wxRep()->FromUserName.']]>',
			'FromUserName' => '<![CDATA['.$this->wxRep()->ToUserName.']]>',
			'CreateTime' => TIMESTAMP,
			'MsgType' => '<![CDATA[news]]>',
			'ArticleCount' => count($articles), 
			'Articles' => $articles,
			'FuncFlag' => $FuncFlag
		);

		$this->_output($data);
	}
	public function respond_video($video=array(),$FuncFlag = 0){
		$articles = array(
			'MediaId'=>'<![CDATA['.$video['MediaId'].']]>',
			'ThumbMediaId'=>'<![CDATA['.$video['ThumbMediaId'].']]>'
			);

		$data = array(
			'ToUserName' => '<![CDATA['.$this->wxRep()->FromUserName.']]>',
			'FromUserName' => '<![CDATA['.$this->wxRep()->ToUserName.']]>',
			'CreateTime' => TIMESTAMP,
			'MsgType' => '<![CDATA[video]]>',
			'Video' => $articles,
			'FuncFlag' => $FuncFlag
		);
		$this->_output($data);
	}
	public function respond_image($image=array(),$FuncFlag = 0){
		$articles = array(
			'MediaId'=>'<![CDATA['.$image['MediaId'].']]>',
			);
		$data = array(
			'ToUserName' => '<![CDATA['.$this->wxRep()->FromUserName.']]>',
			'FromUserName' => '<![CDATA['.$this->wxRep()->ToUserName.']]>',
			'CreateTime' => TIMESTAMP,
			'MsgType' => '<![CDATA[image]]>',
			'Image' =>$articles,
			'FuncFlag' => $FuncFlag			
			);
		//$this->respond_text(implode($data));
		$this->_output($data);
	}
	private function _output($data){
		ob_start();
		ob_implicit_flush(false);
		$xml = XmlParse::Array2XML(array('xml'=>$data));
		file_put_contents('/tmp/wx_out.log', $xml);
		ob_get_clean();		
		echo $xml;
		exit();
	}
}