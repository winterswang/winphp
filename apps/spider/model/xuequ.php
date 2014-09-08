<?php
class xuequ extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}

 		if(isset($where['xuequ_guid']) && $where['xuequ_guid']){
			$whereArr[] = " xuequ_guid = '".$where['xuequ_guid']."'";
		}   

		if(isset($where['xuequ_id'])){
			$whereArr[] = " xuequ_id = '".$where['xuequ_id']."'";
		}
		
		if(isset($where['house_id'])){
			$whereArr[] = " house_id = '".$where['house_id']."'";
		}		

		if(isset($where['xuequ_name	'])){
			$whereArr[] = " xuequ_name	 = '".$where['xuequ_name	']."'";
		}
		
		if(isset($where['telephone'])){
			$whereArr[] = " telephone = '".$where['telephone']."' ";
		}
		
		if(isset($where['level'])){
			$whereArr[] = " level = '".$where['level']."' ";
		}

		if(isset($where['company'])){
			$whereArr[] = " company = '".$where['company']."' ";
		}

		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}

	public function getCount($where = array()){
		$sql = "SELECT count(xuequ_guid) as count FROM xuequ ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM xuequ ".$this->buildWhere(array('xuequ_guid' =>$guid ));
		return $this->fetch($sql);
	}

	public function getInfoById($xuequ_id)
	{	
		$sql = "SELECT * FROM xuequ ".$this->buildWhere(array('xuequ_id' =>$xuequ_id ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM xuequ ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from xuequ". $this->buildWhere($where) . $this->order($orderby) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from xuequ". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxXuequId(){
		$sql = "select max(xuequ_guid) from xuequ";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(xuequ_guid)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addXuequ($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxxuequId();

		if(!empty($guid)){
			$arr['xuequ_guid'] = $guid+1;
		}else{
			$arr['xuequ_guid'] = 1000000000;
		}	

		if(!$this->insert('xuequ',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['xuequ_guid'];
    }

	public function updateXuequ($arr,$where)
	{
        return $this->update('xuequ',$arr, $where);
	}


}