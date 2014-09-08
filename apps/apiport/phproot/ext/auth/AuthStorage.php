<?php

class AuthStorage
{

    private $_session_id;
    private $_sess_data = array();

    function __construct($session_id = null)
    {
        $this->_session_id = $session_id;

        if (!empty($this->_session_id)) {
            $this->_sess_data = AuthTokenSession::model()->getInfo($this->_session_id);
        }
    }

    function get($key)
    {
        return isset($this->_sess_data[$key]) ? $this->_sess_data[$key] : null;
    }

    function set($key, $value)
    {
        $this->_sess_data[$key] = $value;
    }

    function updateSession()
    {
        //AuthTokenSession::model()->updateSession($this->_session_id,$this->_sess_data);
    }

    public function newSession($session_id, $uid, $type, $token, $expires_in, $refresh_token = '')
    {
        //make sure
        $this->clear($session_id);
        AuthTokenSession::model()->destroyToken(array('uid'=>$uid, 'type'=>$type));

        $newsession = array(
            'access_token'  => $token,
            'refresh_token' => $refresh_token,
            'expires_in'    => $expires_in
        );

        $token = AuthTokenSession::model()->newTokenSession($session_id, $uid, $type, $newsession);

        return $token;
    }

    public function clear($session_id = null)
    {
        $sid = $session_id ? $session_id : $this->_session_id;
        AuthTokenSession::model()->destroyToken(array('session_id'=>$sid));
    }

    function __destruct()
    {
        if (!empty($this->_sess_data) && !empty($this->_session_id)) {
            //$this->updateSession();
        }
    }

}