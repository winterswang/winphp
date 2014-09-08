<?php
class weiboController extends AuthController
{

    public $defaultAction = 'loginurl';
    public $auth_type = 'weibo';

    public function validate()
    {
        return array(
            'sns_auth' => array('postfeed'),
            'api' => array('method', 'params'),
        );
    }

    public function actionLoginurl()
    {
        $authorizeurl = $this->auth()->login_url(array('display' => Yii::app()->request->getQuery('display', 'default')));
        $this->response($authorizeurl, 200);
    }

    public function actionLogin()
    {
        $req = WinBase::app()->getRequest();
        $code = $req->getParam('code','');

        try {
            $token = (array) $this->auth()->login($code);
        } catch (Exception $e) {
            $this->showError($e->getCode(),$e->getMessage());
        }

        $userinfo = $this->auth()->getUserInfo($token['uid']);
        if (isset($userinfo['code'])) {
            $this->showError($userinfo['code'],$userinfo['msg']);
        }
        
        $sns_info = array(
            'uid' => $userinfo['id'],
            'username' => $userinfo['screen_name']
        );

        try {
            $this->sitelogin($sns_info,$token['token']);
        } catch (Exception $e) {
            $this->showError($e->getCode(),$e->getMessage());
        }

        $this->response($sns_info);
    }

    function actionApi()
    {
		$req = WinBase::app()->getRequest();
		$api = $req->getParam('api',null);
		$params = $req->getParam('params',array());
        $method = $req->getParam('method', 'GET');
		if(!$api){
			$this->showError('9016','api is required');
		}
        
        if (!is_array($params)) {
            $params = array($params);
        }

        $res = $this->auth()->api($api, $params, $method);
        $this->response($res);
    }

}