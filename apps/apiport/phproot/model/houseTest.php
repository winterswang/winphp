<?php
class houseTest extends BaseDb
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
		if(isset($where['uid']) && $where['uid']){
			$whereArr[] = " uid = '".$where['uid']."'";
		}        
		if(isset($where['house_guid']) && $where['house_guid']){
			$whereArr[] = " house_guid = '".$where['house_guid']."'";
		}
        
		if(isset($where['content']) && $where['content']){
			$whereArr[] = " content = '".$where['content']."'";
		}
        
		if(isset($where['createtime']) && $where['createtime']){
			$whereArr[] = " createtime = '".$where['createtime']."'";
		}

		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
    
	public function getCount($where = array()){
		$sql = "SELECT count(*) as count FROM house_test ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count']; 
	}

	public function getInfo($where = array())
	{	
		$sql = "SELECT * FROM house_test ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from house_test". $this->buildWhere($where).' ORDER BY createtime DESC'.$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
	public function getMaxHouseGuid(){
		$sql = "select max(house_guid) from house_test";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(house_guid)'] : null;
	}    
    
    public function addHouse($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxHouseGuid();
		$arr['house_guid'] = 1000000000;
		if(!empty($guid)){
			$arr['house_guid'] = $guid+1;
		}	
		
		if(!$this->insert('house_test',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['house_guid'];
    }

	public function updateHouse($arr,$where)
	{
        return $this->update('house_test',$arr, $where);
	}    
}
?>