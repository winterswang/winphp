<?php
class device extends BaseDb
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
	
	function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['uuid']) && $where['uuid']){
			$whereArr[] = " uuid = '".$where['uuid']."'";
		}
		
		if(isset($where['uid']) && $where['uid']){
			$whereArr[] = " uid = '".$where['uid']."'";
		}
		
		if(isset($where['device_id']) && $where['device_id']){
			$whereArr[] = " device_id = '".$where['device_id']."'";
		}
		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}	
	
	public function getInfoByUid($uid){
        $sql = "select * from user_device ".$this->buildWhere(array('uid'=>$uid));
		return $this->fetch($sql);
	}
	
	public function getInfoByUUid($uuid){
		$sql = "select * from user_device ".$this->buildWhere(array('uuid'=>$uuid));
		return $this->fetch($sql);
	}
	
	public function updateDevice($arr,$where){
		return $this->update('user_device',$arr,$where);
	}
	
	public function regDevice($device){
		return $this->insert('user_device',$device,true);
	}

}
?>