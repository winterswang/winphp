<?php
/**
 * 个人信息
 */
class memberController extends AdminController {

	/**
	 *  个人信息首页
	 *  展现个人的基本信息
	 */
	public function actionIndex() {
		$data = array('menu' => 'm_self');
		$this -> render('self_info', $data);
	}

	/**
	 * 个人信息的修改
	 */
	public function actionModify() {

	}

	/**
	 * 完善个人信息
	 */
	public function actionComplete() {
		$data = array('menu' => 'm_self');
		$this -> render('self_info', $data);
	}

	/**
	 * 用户注册
	 */
	public function actionReg() {
		$req = WinBase::app() -> getRequest();
		$res = array();
		if ($req -> isPostRequest()) {
			do {
				$mobile = $req -> getParam('mobile', '');
				if ($mobile == '') {
					$res['error'] = "请输入手机号";
					break;
				}
				if (user_info::model() -> isUserExist($mobile)) {
					$res['error'] = "用户已存在";
					break;
				}
				$passwd = $req -> getParam('passwd', '');
				if ($passwd == '') {
					$res['error'] = "请输入密码";
					break;
				}
				$repasswd = $req -> getParam('repasswd', '');
				if ($passwd != $repasswd) {
					$res['error'] = "两次输入密码不一致";
					break;
				}
				
				$real_name = $req -> getParam('realname', '');
				if ($real_name == '') {
					$res['error'] = "请输入真实姓名";
					break;
				}

				$data = array('mobile' => $mobile, 'passwd' => $passwd, 'realname' => $real_name);
				user_info::model() -> addUser($data);
			} while(0);
		}
		$this -> render('reg', $res);
	}

	/**
	 * 检查用户是否存在
	 */
	public function actionCheckUser() {
		$req = WinBase::app() -> getRequest();
		$mobile = $req -> getParam('mobile', '');
	}

}
