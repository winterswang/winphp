<?php

class authTokenSession extends BaseDb
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function token_create()
    {
        return sha1(time() . uniqid());
    }
    
    function getInfoBySid($session_id){
        $sql = "SELECT * FROM auth_token_session WHERE session_id=".$session_id;
        $this->fetch($sql);
    }

    function newTokenSession($session_id, $uid, $type, $token)
    {

        $session_arr = array(
            'session_id'    => $session_id,
            'uid'           => $uid,
            'type'          => $type,
            'access_token'  => $token['access_token'],
            'refresh_token' => $token['refresh_token'],
            'expires_in'    => $token['expires_in'],
            'expires_at'    => time() + $token['expires_in'],
            'dateline'      => time()
        );

        if ($this->insert('auth_token_session', $session_arr)) {
            return $token;
        }

        return null;
    }

    function destroyToken($where)
    {
        return $this->delete('auth_token_session',$where);
    }

}