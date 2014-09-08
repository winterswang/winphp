<?php
class xuequHot extends BaseDb{

	public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function buildWhere($where = array()){
		$whereArr = array();
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
		if(isset($where['xuequ_id']) && $where['xuequ_id']){
			$whereArr[] = " xuequ_id = '".$where['xuequ_id']."'";
		}
		if(isset($where['xuequ_guid']) && $where['xuequ_guid']){
			$whereArr[] = " xuequ_guid = '".$where['xuequ_guid']."'";
		}
		if(isset($where['school_name']) && $where['school_name']){
			$whereArr[] = " school_name = '".$where['school_name']."'";
		}				
	}
	public function getCount($where = array()){
		$sql = "SELECT count(xuequ_guid) as count FROM xuequ_hot ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM xuequ_hot ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from xuequ_hot". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
	public function getMaxXuequId()
	{
		$sql = "select max(xuequ_guid) from xuequ_hot";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(xuequ_guid)'] : null;
	}

    public function addXuequHot($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxxuequId();

		if(!empty($guid)){
			$arr['xuequ_guid'] = $guid+1;
		}else{
			$arr['xuequ_guid'] = 1000000000;
		}	

		if(!$this->insert('xuequ_hot',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['xuequ_guid'];
    }

	public function updateXuequHot($arr,$where)
	{
        if($this->update('xuequ_hot',$arr, $where)){
        	return $arr['xuequ_guid'];
        }
        return false;
	}
}