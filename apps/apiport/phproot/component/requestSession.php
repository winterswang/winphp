<?php
class requestSession {
    
    public $uuid;
    public $client_id;
    
    public $timeout = 86400;//???超时???
    
    private $_sess_data = array('client_id'=>'','uuid'=>'','uid'=>0,'lat'=>0,'lng'=>0,'expires_in'=>0,'expires_at'=>'','first_requested'=>0,'last_activity'=>0);
 	 	 	 	 
    function __construct($uuid = '',$client_id = 0)
    {
        $this->uuid = $uuid;
        $this->client_id = $client_id;

        if($uuid && $client_id){
            $this->_init_sess();
        }
    }
    
    private function _init_sess(){

        $sess =  session::model()->getSession(array('uuid'=> $this->uuid, 'client_id' => $this->client_id));

        if(empty($sess) || $sess['client_id'] != $this->client_id || $sess['uuid'] != $this->uuid){
           $sess = $this->newSession();
        }
        $this->_sess_data = $sess;
    }

    function get($key,$default = null)
    {
        return isset($this->_sess_data[$key]) ? $this->_sess_data[$key] : $default;
    }

    function set($key, $value)
    {
        $this->_sess_data[$key] = $value;
    }
    
    private function _token_create()
    {
        return sha1(time() . uniqid());
    }    
    
    function getSession()
    {
        return $this->_sess_data;
    }

    function newSession()
    {
        $this->_destroySession();

        //$token = $this->_token_create();
        $sessArr = array(
            'uuid' => $this->uuid,
            'client_id' => $this->client_id,
            'first_requested' => TIMESTAMP,
            'last_activity' => TIMESTAMP,
			'lat' => 0,
			'lng' => 0,
			'last_shake' => 0,
            'uid' => 0,
            'expires_in' => $this->timeout,
            'expires_at' => TIMESTAMP + $this->timeout
        );
        
        if(!session::model()->insertSession($sessArr)){
            return $sessArr;
        }
        return $sessArr; 
    }

    function updateSession()
    {
        $updateArr = array(
            'last_activity' => TIMESTAMP,
            'uid' => $this->get('uid',0),
			'lat' => $this->get('lat',0),
			'lng' => $this->get('lng',0),
        );
		
        session::model()->updateSession($updateArr,array('uuid'=>$this->uuid,'client_id' => $this->client_id));
    }
    
    function validateToken($token)
    {
        $sess = session::model()->getSession(array('token'=> $token));
        if(!empty($sess)){
            return true;
        }
        return false;
    }

    private function _destroySession()
    {
        session::model()->deleteSession(array('uuid' => $this->uuid, 'client_id'=>$this->client_id));
    }
    
    function __destruct()
    {
        if (!empty($this->_sess_data)) {
            $this->updateSession();
        }
    }    
}
