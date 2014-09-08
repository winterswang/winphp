<?php
class xuequ_district extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}

 		if(isset($where['xuequ__guid']) && $where['xuequ__guid']){
			$whereArr[] = " xuequ__guid = '".$where['xuequ__guid']."'";
		}   

		if(isset($where['xuequ__id'])){
			$whereArr[] = " xuequ_district_id = '".$where['xuequ_district_id']."'";
		}
		
		if(isset($where['district_id'])){
			$whereArr[] = " district_id = '".$where['district_id']."'";
		}
		if(isset($where['district__guid']) && $where['district__guid']){
			$whereArr[] = " district__guid = '".$where['district__guid']."'";
		}   		
		if(isset($where['district_name'])){
			$whereArr[] = " district_name = '".$where['district_name']."'";
		}	
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}

	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM xuequ_district ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM xuequ_district ".$this->buildWhere(array('id' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM xuequ_district ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from xuequ_district". $this->buildWhere($where) . $this->order($orderby) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from xuequ_district". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxXuequ_districtId(){
		$sql = "select max(id) from xuequ_district";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(id)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addXuequ_district($arr){
        
		$this->getDb()->beginTransaction();	

		if(!$this->insert('xuequ_district',$arr)){
			$this->getDb()->rollBack();
			return false;
		}
        
        $this->getDb()->commit();
        return true;
    }

	public function updateXuequ_district($arr,$where)
	{
        return $this->update('xuequ_district',$arr, $where);
	}


}