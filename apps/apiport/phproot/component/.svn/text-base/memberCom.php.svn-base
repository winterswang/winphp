<?php

class memberCom {
    
    public $uid;
    public $uuid;
    private $_member_data;
    private $_member_preference;

    function __construct($uid = 0)
    {
        $this->uid = intval($uid);//var 转 int
        
        $this->_init_member();
    }
    
    private function _init_member(){
        
        if(!$this->uid){
            
            $member =  $this->register();
            if($member=== false){
                throw new Exception("Cann't build member");
            }
        }else{
            $member =  user::model()->getInfoByUid($this->uid);
        }
      
        foreach($member as $k => $v){
            $this->$k = $v;
        }

        $this->_member_data = $member;
    }   
    
    function get($key)
    {
        return isset($this->_member_data[$key]) ? $this->_member_data[$key] : null;
    }

    function set($key, $value)
    {
        $this->_member_data[$key] = $value;
        $this->$key = $value;
    }  
    
    function getMember()
    {
        return $this->_member_data;
    }

    function register()
    {
        $memberArr = array(
            'realName' => '',
            'userName' => '',
            'gender' => 0,
            'mobile' => 0,
            'verify' => 0,
            'group_id' => 0,

            'createtime' => TIMESTAMP,
            'updatetime' => TIMESTAMP
        );
        
        if(!($uid = user::model()->addUser($memberArr,true))){
            return false;
        }
        /*
        $preference = array(
            'uid' => $uid,
            'searchway' => 'xy',
            'min_rent_price' => 0,
            'max_rent_price' => 0,
            'room' => 0,
            'lat' => 0,
            'lng' => 0,
            'radius' => 1000,
            'zone_id' => '',
            'station_id' => '',
            'rent_type' => 0,
            'subscribe_type' => 0,
            'provides' => '',
            'updatetime' => TIMESTAMP
        );
        userPreference::model()->addPreference($preference);
        
        $this->_member_preference = $preference;
        */
        $memberArr['uid'] = $uid;
        return $memberArr; 
    }

    function updateMember($arr)
    {
        
    }
    
    function getPreference(){
        if(!$this->_member_preference){
            $preference = userPreference::model()->getPreference($this->uid);
            
            if(empty($preference)){
                $preference = array(
                    'searchway' => 'xy',
                    'min_rent_price' => 0,
                    'max_rent_price' => 0,
                    'room' => 0,
                    'lat' => 0,
                    'lng' => 0,
                    'radius' => 1000,
                    'zone_id' => '',
                    'station_id' => '',
                    'rent_type' => 0,
                    'subscribe_type' => 0,
                    'provides' => '',
                );
           }
           
           $this->_member_preference = $preference;
        }

        return $this->_member_preference;
    }
    
    function getSnsInfo(){
        
    }

}