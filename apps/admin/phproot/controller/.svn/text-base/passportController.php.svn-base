<?php

class passportController extends AdminController
{

    public $defaultAction = 'login';

    public function actionLogin()
	{
        $this -> render('passport_login');
    }

    public function actionLogging()
    {
        $json = array('error'   => 0, 'message' => '');
        $rep = WinBase::app()->getRequest();
        if ($rep->isAjaxRequest()) {
            $username = $rep->getParam('username', '');
            $password = $rep->getParam('password', '');

            if (!$username) {
                $json = array('error'   => 41, 'message' => 'The username cannot be empty');
            }

            if (!$password) {
                $json = array('error'   => 41, 'message' => 'The password cannot be empty');
            }

            $resp = array();
            if (!$json['error']) {
                $user_info = user_info::model()->getInfoByMobile($username);
                if (empty($user_info) || $user_info['passwd'] != $password) {
                    $json = array('error' => 40, 'message'  => '用户名或密码错误');
                } else {
                    $this->session->add('login_user', $user_info);
                    $json = array('error' => 0, 'referer'  => $this->getReferer(), 'message' => '登入成功！');
                }
            }
        }
        
        echo Json::encode($json);
    }
    

    function afterLogin($uid)
    {
    }    

    public function actionLogout()
    {
        $this->session->clear('login_member');
        $this->redirect('/');
    }

    public function actionCngpass()
    {
        
    }

}