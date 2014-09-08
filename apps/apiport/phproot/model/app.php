<?php
class app extends BaseDb
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function generateKey ( $unique = false ) {
    	$key = md5(uniqid(rand(), true));
    	if ($unique)
    	{
    		list($usec,$sec) = explode(' ',microtime());
    		$key .= dechex($usec).dechex($sec);
    	}
    	return $key;
    }
	
	function getClient($client_id){
        $sql = "select * from system_app where client_id = $client_id";
		return $this->getDb()->fetch($sql);
	}
}