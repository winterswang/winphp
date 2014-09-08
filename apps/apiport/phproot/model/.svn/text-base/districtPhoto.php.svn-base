<?php
class districtPhoto extends BaseDb
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id'])){
			$whereArr[] = " id = '".$where['id']."'";
		}				
        
		if(isset($where['district_guid']) && $where['district_guid']){
			$whereArr[] = " district_guid = '".$where['district_guid']."'";
		}
		
		if(isset($where['is_delete'])){
			$whereArr[] = " is_delete = '".$where['is_delete']."'";
		}		
        
		if(isset($where['pic_url']) && $where['pic_url']){
			$whereArr[] = " pic_url = '".$where['pic_url']."'";
		}
		if(isset($where['target_url']) && $where['target_url']){
			$whereArr[] = " target_url = '".$where['target_url']."'";
		}		        
		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
    
	public function getCount($where = array()){
		$sql = "SELECT count(pid) as count FROM district_photo ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count']; 
	}
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM district_photo ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
	public function getInfoByPid($pid)
	{	
		$sql = "SELECT * FROM district_photo ".$this->buildWhere(array('pid' =>$pid ));
		return $this->fetch($sql);
	}
	public function getInfoByDistrictGuid($district_guid){
		$sql = "SELECT * FROM district_photo ".$this->buildWhere(array('district_guid' =>$district_guid ));
		return $this->fetch($sql);		
	}	
	public function getTopPhoto($guid){
		$sql = "SELECT pic_url FROM district_photo ".$this->buildWhere(array('district_guid' =>$guid )) ." LIMIT 1";
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from district_photo". $this->buildWhere($where) . ' ORDER BY sort_order ASC,dataline DESC' .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
	
	public function getAll($where = array())
	{
        $sql = "select * from district_photo". $this->buildWhere($where) . ' ORDER BY sort_order ASC,dataline DESC';
		return $this->fetch_all($sql);
	}
    
    public function addPhoto($arr)
    {
        if(!$this->insert('district_photo',$arr)){
			$this->getDb()->rollBack();
			return false;
		}        
        return true;
    }

	public function updatePhoto($arr,$where){
		return $this->update('district_photo',$arr, $where);
	}
	
	public function deleteImage(){
		
	}
    
}
?>