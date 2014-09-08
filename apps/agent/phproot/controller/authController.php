<?php
class AuthController extends AppController
{
	public function actionGetCode(){
		$req = WinBase::app()->getRequest();
		$redirect = $req->getParam('redirect','');
		$code = $req->getParam('code','');
		$res = $this->api->add_user_vsfwx(array('code'=>$code));

		if($res['result'] != 'ok'){
			//error
			print_r($res['result']);
		
		}else{
			$this->openId = $res['data']['open_id'];
			setcookie('openId',$this->openId);
			$this->redirect($redirect);
		}
	}

	public function actionOAuth(){

		$appid = 'wxadcb2b0d4be9cb19';//微搜房
		
		$refer = $this->getReferer();
		
		$redirect_uri = "http://randywx.ikuaizu.com/agent/getCode?redirect=".urlencode($refer);		
		$redirect_uri = urlencode($redirect_uri);
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
		echo "<script>window.location ='".$url."';</script>";
		die;
	}
 
}