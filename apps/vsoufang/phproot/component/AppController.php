<?php
require_once (dirname(__FILE__)."/../ext/IKuaiZuApi.php");
class AppController extends BaseController{
	public $uuid;
	public $openId = '';
	public $meta = array('title' => '');
	public $api;
	public $user_info;
	//public $_cache;
	
	public function init(){
		$req = WinBase::app()->getRequest();
		$uuid = $req->getParam("uuid",'oMJ6NjnnUSjsLBOJDIbzgV1rnrgk');//////正式上线需要验证
		if(!$uuid){
			die('Invalid Visit');
		}
		$openId = $req->getParam('openId','');
		if(!empty($openId)){
			$this ->openId = $openId;			
		}else{
			/////验证身份
		}		
		$this ->api = new IKuaiZuApi(array('uuid'=>$uuid));
	}	
	
	public function getWeixinInfo() {
		if(isset($_COOKIE["openId"]) && $_COOKIE["openId"] !=''){
			$this->openId = $_COOKIE["openId"];
			$res = $this->api->get_user_vsfwx(array('openId'=>$this->openId));
			if ($res['result'] == 'ok') {
				$this->user_info = $res['data'];
			} else {
				//TODO error
			}
		} else { //auth

			$this->redirect('/auth/oauth');
		}
	}

	public function redirect($url){
		header('Location: '.$url);
		exit();
	}
	
    function getReferer($referer = ''){

        if (empty($referer)) {
            $referer = WinBase::app()->getRequest()->getParam('referer');
            $referer = !empty($referer) ? $referer : WinBase::app()->getUri()->getUri();
		}

        $referer = htmlspecialchars($referer);
        $referer = str_replace('&amp;', '&', $referer);
        $reurl = parse_url($referer);

        if (!isset($reurl['host'])) {
            $referer = '/'.ltrim($referer, '/');
        }
        return strip_tags($referer);
    }	
	
	public function setMeta($key,$value){
		$this->meta[$key]=$value;
	}
	
    public function showMessage($message, $msg_type = 0, $links = array()){
		$this->render('/common/message', array(
			'message'       => $message,
			'links'         => $links,
			'msg_type'      => $msg_type
		));
		exit();
    }

}