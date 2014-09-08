<?php
class session extends BaseDb
{
	
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
	
	public function buildWhere($where){
		$whereArr = array();
		
		if(isset($where['uuid']) && $where['uuid']){
			$whereArr[] = " uuid = '".$where['uuid']."'";
		}
		
		if(isset($where['client_id']) && $where['client_id']){
			$whereArr[] = " client_id = '".$where['client_id']."'";
		}		
		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	
	public function getSession($where = array())
	{
		$sql = "SELECT * FROM user_session ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
	
	public function getAllNear($lat,$lng,$radius)
	{
		$sql = "SELECT uid,GETDISTANCE(lat,lng,".$lat.",".$lng.") AS distance FROM  user_session where 1 HAVING distance < ".$radius;
		return $this->fetch_all($sql);
	}
	
	public function updateSession($arr,$where){
		return $this->update('user_session',$arr, $where);
	}	
	
	public function insertSession($arr){
		return $this->insert('user_session',$arr,false,true);
	}
	
	public function deleteSession($arr){
		return $this->delete('user_session',$arr);
	}
}
?>