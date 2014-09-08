<?php
class houseAlter extends BaseDb
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['uid']) && $where['uid']){
			$whereArr[] = " uid = '".$where['uid']."'";
		}
        
		if(isset($where['house_guid']) && $where['house_guid']){
			$whereArr[] = " house_guid = '".$where['house_guid']."'";
		}
		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
    
	public function getCount($where = array()){
		$sql = "SELECT count(pid) as count FROM house_alter ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count']; 
	}

	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from house_alter". $this->buildWhere($where) . ' ORDER BY dateline DESC' .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
	
	public function getAll($where = array())
	{
        $sql = "select * from house_alter". $this->buildWhere($where) . ' ORDER BY dateline DESC';
		return $this->fetch_all($sql);
	}
    
    public function addAlter($arr){
        return $this->insert('house_alter',$arr,true);
    }

}
?>