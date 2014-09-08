<?php
class userController extends ApiController
{
	function actionSendMsg(){
		$req = WinBase::app()->getRequest(); 
		$userName = $req->getParam('userName','');
		$content = $req->getParam('content','');
		$target = $req->getParam('agent_guid','');
		$user_id = $req->getParam('userID','');
		if(empty($user_id) || empty($content)){
			$this->response(array('result'=>'miss data to add'));
		}
		else{
			if(user_message::model()->addUserMessage(array())){
				$this->response(array('result'=>'true'));
			}
			else{
				$this->response(array('result'=>'false'));
			}
		}
	}
	function actionGetMsgList(){
		$req = WinBase::app()->getRequest(); 
		$user_id = $req->getParam('userID','');
		if (empty($user_id)) {
			$this->response(array('result'=>'userID is empty'));
		}else{
			$list = user_message::model()->getList(array('user_id'=>$user_id));
			$this->response($list);
		}
	}
	function actionAddUserVsfWx(){
		$req = WinBase::app()->getRequest();
		////获取code
		$code = $req->getParam('code','');
		if(empty($code)){
			$this->response(array('result'=>'miss openId'));
		}	
		////拿code去获取token
		$res = $this->getOAuthToken($code);
		if(isset($res->errcode)){
			$this->response(array('result'=>$res->errmsg));
		}
		$openId = $res->openid;
		////拿token获取个人信息
		$res = WxApiTools::model()->getOAuthUserInfo($openId,$res->access_token);
		if(isset($res->errcode)){
			$this->response(array('result'=>$res->errmsg));
		}
		$data = array(
			'open_id'   =>$openId,
			'nickname'  =>$res->nickname,
			'sex'       =>$res->sex,
			'province'  =>$res->province,
			'city'      =>$res->city,
			'headimgurl'=>$res->headimgurl,
			'createtime'=>time(),
			);
		////存入数据库
		if(!userVsfWx::model()->isExist($openId)){
			userVsfWx::model()->addUser($data);
		}			
		$this->response(array('result'=>'ok','data'=>$data));
	}
	function actionGetUserVsfWx(){
		$req = WinBase::app()->getRequest();
		$openId = $req->getParam('openId','');

		if(empty($openId)){
			$this->response(array('result'=>'miss openId'));
		}
		$data = userVsfWx::model()->getInfo(array('open_id'=>$openId));

		if(empty($data) || empty($data['open_id'])){
			$this->response(array('result'=>'ok','data'=>array()));
		}

		$this->response(array('result'=>'ok','data'=>$data));		
	}
	private function getOAuthToken($code){
		$systemSetting = Config::getConfig('system');
		$appid = $systemSetting['vsoufun']['appid'];
		$secret=$systemSetting['vsoufun']['secret'];		
		$res = WxApiTools::model()->getOAuthAccessToken($appid,$secret,$code);
		return $res;
	}
}
