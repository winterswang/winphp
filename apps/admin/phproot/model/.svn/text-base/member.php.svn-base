<?php

class member extends BaseDb
{

    public $user_password_confirm;
    public $initial_password;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function buildWhere($filter = array())
    {
        $whereArr = array();
        if (isset($filter['keyword']) && !empty($filter['keyword'])) {
            $whereArr[] = " user_name like '%" . $filter['keyword'] . "%'";
        }

        if (isset($filter['group_id']) && !empty($filter['group_id'])) {
            $whereArr[] = " group_id = '" . $filter['group_id'] . "'";
        }

        if (isset($filter['user_name']) && !empty($filter['user_name'])) {
            $whereArr[] = " user_name = '" . $filter['user_name'] . "'";
        }

        if (isset($filter['user_email']) && !empty($filter['user_email'])) {
            $whereArr[] = " user_email = '" . $filter['user_email'] . "'";
        }

        if (isset($filter['user_id']) && !empty($filter['user_id'])) {
            $whereArr[] = " user_id = '" . $filter['user_id'] . "'";
        }

        if (isset($filter['status']) && !empty($filter['status'])) {
            $whereArr[] = " status = '" . $filter['status'] . "'";
        }

        return !empty($whereArr) ? ' WHERE ' . join(' AND ', $whereArr) : '';
    }    
    
    function getList($filter = array(), $pageNo = 1, $pageSize = 20)
    {

        $sql = "select * from system_admin ";
        $sql .= $this->buildWhere($filter);
		$sql .= $this->limit($pageNo, $pageSize);
		return $this->fetch_all($sql);
    }

    function getCount($filter = array())
    {
        $sql = "select count(1) as count from system_admin ";
        $sql .= $this->buildWhere($filter);
        $row = $this->fetch($sql);
        return $row['count'];
    }

    function get_user_by_uid($uid)
    {
        $sql = "select * from system_admin " . $this->buildWhere(array('user_id' => $uid));
        return $this->fetch($sql);
    }

    function get_user_by_username($username)
    {
        $sql = "select * from user_info " . $this->buildWhere(array('user_name' => $username));
        return $this->fetch($sql);
    }

    function get_user_by_email($email)
    {
        
    }

    function check_usernameexists($username)
    {
        $sql = "select count(1) as count from system_admin ". $this->buildWhere(array('user_name' => $username));
        $row = $this->fetch($sql);
        return $row['count'];
    }

    function check_emailexists($email, $username = '')
    {
        $sqladd = $username !== '' ? " AND user_name<>'$username'" : '';
        $sql = "SELECT user_email FROM system_admin " . $this->buildWhere(array('user_email' => $email)) . $sqladd;
        $row = $this->fetch($sql);
        return $row['count'];
    }

    function addUser($userinfo = array(), $groupid = 1)
    {
        $salt = $this->getSalt();
		
        $userArr = array(
            'user_name'     => $userinfo['user_name'],
        	'nick_name'		=> $userinfo['nick_name'],
            'user_email'    => $userinfo['user_email'],
            'salt'          => $salt,
            'user_password' => $this->encryptPass($userinfo['user_password'], $salt),
            'group_id'       => $groupid,
            'status'        => 0,
            'regdate'       => TIMESTAMP,
			'lastlogintime' => TIMESTAMP
        );

        if (($uid = $this->insert('system_admin', $userArr,true)) > 0) {
            return $uid;
        }

        return 0;
    }
    
    function deleteUser($where)
    {
    	if (($rows_affected = $this->delete('system_admin', $where)) > 0) {
    		return $rows_affected;
    	}
    	
    	return 0;
    }
    
    public function updateUser($arr,$where)
    {
    	$userArr = array();
    	
    	if (isset($arr['user_name'])) {
    		$userArr['user_name'] = $arr['user_name'];
    	}
    	
    	if (isset($arr['nick_name'])) {
    		$userArr['nick_name'] = $arr['nick_name'];
    	}
    	
    	if (isset($arr['user_email'])) {
    		$userArr['user_email'] = $arr['user_email'];
    	}
    	
    	if (isset($arr['user_password'])) {
    		$salt = $this->getSalt();
    		$userArr['salt'] = $salt;
    		$userArr['user_password'] = $this->encryptPass($arr['user_password'], $salt);
    	}
		
    	if (isset($arr['group_id'])) {
    		$userArr['group_id'] = $arr['group_id'];
    	}		
    	
    	if (isset($arr['lastlogintime'])) {
    		$userArr['lastlogintime'] = $arr['lastlogintime'];
    	}
    	
    	return $this->update('system_admin', $userArr, $where);
    }

    function getSalt()
    {
        return substr(uniqid(rand()), -6);
    }

    function encryptPass($pass, $salt = '')
    {
        return md5(md5($pass) . $salt);
    }    

}