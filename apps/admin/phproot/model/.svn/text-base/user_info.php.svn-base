<?php
class user_info extends BaseDb
{
	
    public static function model($className = __CLASS__)
    {
        return parent::model('user_info');
    }
    
    function buildWhere($filter = array())
    {
    }
	
	/**
	 * 根据用户ID查询信息
	 */
	public function getInfoByUid($uid) {
		$sql = "SELECT * FROM user_info WHERE uid =".$uid;
		return $this->fetch($sql);
	}
	
	/**
	 * 根据用户手机号查询信息
	 */
	public function getInfoByMobile($mobile) {
		$sql = "SELECT * FROM user_info WHERE mobile =".$mobile;
		return $this->fetch($sql);
	}
	
	/**
	 * 更新用户信息
	 */
	public function updateUser($arr,$where){
		return $this->update('user_info',$arr, $where);
	}
	
	/**
	 * 添加用户
	 */
	public function addUser($arr,$return_id = false) {
		return $this->insert('user_info',$arr,$return_id);
	}

	/**
	 * 用户登入
	 */
	public function signIn($username, $password) {
		//$password = md5($password);
		$sql = "SELECT * FROM user_info WHERE userName ='" . $username . "' and passwd='" . $password . "'";
        return $this->fetch($sql);
	}
	
	public function isUserExist($mobile) {
		$sql = 'select count(*) cnt from user_info where mobile= "$mobile"';
		$res = $this->fetch($sql);
		return $res['cnt'] > 0;
	}
	
}
?>