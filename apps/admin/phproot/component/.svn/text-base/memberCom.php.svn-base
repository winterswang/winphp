<?php
class memberCom
{

    const USER_CHECK_USERNAME_FAILED = -1;
    const USER_USERNAME_BADWORD = -2;
    const USER_USERNAME_EXISTS = -3;
    const USER_EMAIL_FORMAT_ILLEGAL = -4;
    const USER_EMAIL_ACCESS_ILLEGAL = -5;
    const USER_EMAIL_EXISTS = -6;
    
    private $errorCode = 0;

    static function &instance()
    {
        static $object = null;
        if (empty($object)) {
            $object = new memberCom();
        }
        return $object;
    }    
    
    function register($username, $password, $groupid = 0, $nick_name = '', $email = '', $regip = '', $source = '')
    {

        if (($status = $this->_check_username($username)) < 0) {
            return $status;
        }

        if (!empty($email) && ($status = $this->_check_email($email)) < 0) {
            return $status;
        }

        $uid = Member::model()->add_user($username, $password, $groupid, $nick_name, $email, $regip, $source);
        return $uid;
    }

    function signin($username, $password)
    {
        if (($uid =$this->authenticate($username, $password)) === false) {
            return false;
        }
       
        return $uid;
    }
    

    public function authenticate($username, $password)
    {

        $user = member::model()->get_user_by_username($username);

        if (empty($user)) {
            return false;
        }

        if($user['passwd'] != $password) {
            return false;
        }

        return $user['user_id'];
    }

    function _check_username($username)
    {
        if (!$this->check_username($username)) {
            return self::USER_CHECK_USERNAME_FAILED;
        } elseif (!$this->check_usernamecensor($username)) {
            return self::USER_USERNAME_BADWORD;
        } elseif (Member::model()->check_usernameexists($username)) {
            return self::USER_USERNAME_EXISTS;
        }
        return 1;
    }

    function _check_email($email, $username = '')
    {
        if (!$this->check_emailformat($email)) {
            return self::USER_EMAIL_FORMAT_ILLEGAL;
        } elseif (!$this->check_emailaccess($email)) {
            return self::USER_EMAIL_ACCESS_ILLEGAL;
        } elseif (Member::model()->check_emailexists($email, $username)) {
            return self::USER_EMAIL_EXISTS;
        } else {
            return 1;
        }
    }

    function check_username($username)
    {
        return true;
        /*
          $guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
          $len = strlen($username);
          if($len > 15 || $len < 3 || preg_match("/\s+|^c:\\con\\con|[%,\*\"\s\<\>\&]|$guestexp/is", $username)) {
          return FALSE;
          } else {
          return TRUE;
          } */
    }

    function check_usernamecensor($username)
    {
        return true;
    }

    function check_emailformat($email)
    {
        return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
    }

    function check_emailaccess($email)
    {
        return true;
    }

    function getError($code)
    {
        $msg = array(
            self::USER_CHECK_USERNAME_FAILED => 'check username failed',
            self::USER_USERNAME_BADWORD      => 'username badword',
            self::USER_USERNAME_EXISTS       => 'username exists',
            self::USER_EMAIL_FORMAT_ILLEGAL  => 'mail format illegal',
            self::USER_EMAIL_ACCESS_ILLEGAL  => 'email access illegal',
            self::USER_EMAIL_EXISTS          => 'email exists'
        );

        return isset($msg[$code]) ? $msg[$code] : 'undefined reason';
    }

}