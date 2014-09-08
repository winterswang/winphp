<?php
class housePhoto extends BaseDb
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
        
		if(isset($where['house_guid']) && $where['house_guid']){
			$whereArr[] = " house_guid = '".$where['house_guid']."'";
		}
		
		if(isset($where['is_delete'])){
			$whereArr[] = " is_delete = '".$where['is_delete']."'";
		}		
        
		if(isset($where['status']) && $where['status']){
			$whereArr[] = " status = '".$where['status']."'";
		}        
		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
    
	public function getCount($where = array()){
		$sql = "SELECT count(pid) as count FROM house_photo ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count']; 
	}

	public function getInfoByPid($pid)
	{	
		$sql = "SELECT * FROM house_photo ".$this->buildWhere(array('pid' =>$pid ));
		return $this->fetch($sql);
	}
	
	public function getTopPhoto($guid){
		$sql = "SELECT * FROM house_photo ".$this->buildWhere(array('house_guid' =>$guid )) ." LIMIT 1";
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from house_photo". $this->buildWhere($where) . ' ORDER BY sort_order ASC,dataline DESC' .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
	
	public function getAll($where = array())
	{
        $sql = "select * from house_photo". $this->buildWhere($where) . ' ORDER BY sort_order ASC,dataline DESC';
		return $this->fetch_all($sql);
	}
    
    public function addPhoto($arr)
    {
        if(!$this->insert('house_photo',$arr)){
			$this->getDb()->rollBack();
			return false;
		}        
        return true;
    }

	public function updatePhoto($arr,$where){
		return $this->update('house_photo',$arr, $where);
	}
	
	public function deleteImage(){
		
	}
    
}
?>