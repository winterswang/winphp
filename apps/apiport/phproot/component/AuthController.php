<?php

class AuthController extends ApiController
{

    public $auth_type = '';
    public $type = '';
    public $sns_user = array('uid' => 0,'user_name' => '','bind_uid' => 0,'token' => '','expires_at' => 0);

    public function init()
    {
        parent::init();

        if (!$this->auth_type) {
            throw new Exception("Unknown Auth Type.");
        }

        $this->_init_sns();
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->validate_auth($action);
            return true;
        } else {
            return false;
        }
    }

    public function validate_auth($action)
    {
        $rules = $this->validate();

        if (isset($rules['sns_auth']) && in_array($action->id, $rules['sns_auth'])) {

            if (!$this->islogin() || empty($this->sns_user['token'])) {
                $this->showError('9015','sns session invalid');
            }

            if (time() > $this->sns_user['expires_at']) {
                $this->showError('9015','sns session expire');
            }
        }
    }

    public function auth()
    {
        static $_auth = null;

        if (!$_auth) {
            $uid = $this->member->uid;
            $config = WinBase::app()->config['auth'];
            $adapter = new AuthAdapter();
            $_auth = $adapter->setup($this->auth_type, $config, array('uid'=> $uid)); 
        }
        return $_auth;
    }

    function _init_sns()
    {

        $uid = $this->member->uid;
        $bindInfo = userSnsbind::model()->bindInfoByUid($uid, $this->auth_type);

        if (!empty($bindInfo)) {
            $this->sns_user['uid'] = $bindInfo['sns_uid'];
            $this->sns_user['user_name'] = $bindInfo['sns_username'];
            $this->sns_user['bind_uid'] = $bindInfo['uid'];
        }

        $token = $this->auth()->token();

        $this->sns_user['token'] = $token['access_token'];
        $this->sns_user['expires_at'] = $token['expires_at'];
    }
    
    function siteLogin($sns_info,$token)
    {

        $site_uid = $this->member->uid;

        if (!$this->isBind()) {
            userSnsbind::model()->addbind($site_uid, $this->auth_type, $sns_info['uid'], $sns_info['username']);
        }
        
        $this->auth()->newTokenSession($site_uid, $token);
    }

    function isBind()
    {
        return $this->sns_user['bind_uid'] == $this->member->uid;
    }

    function islogin()
    {
        if (!$this->sns_user['uid'] || (time() > (int) $this->sns_user['expires_at'])) {
            return false;
        }

        return true;
    }

}