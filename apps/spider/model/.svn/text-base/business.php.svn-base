<?php
class business extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}

 		if(isset($where['business_guid']) && $where['business_guid']){
			$whereArr[] = " business_guid = '".$where['business_guid']."'";
		}   

		if(isset($where['business_type'])){
			$whereArr[] = " business_type = '".$where['business_type']."'";
		}
		
		if(isset($where['business_name'])){
			$whereArr[] = " business_name = '".$where['business_name']."'";
		}		

		if(isset($where['address'])){
			$whereArr[] = " address = '".$where['address']."'";
		}
		
		if(isset($where['distance']) && $where['distance'] > 0){
			$whereArr[] = " distance = '".$where['distance']."' ";
		}
		
		if(isset($where['hashcode']) && $where['hashcode'] > 0){
			$whereArr[] = " hashcode = '".$where['hashcode']."' ";
		}

		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}

	public function getCount($where = array()){
		$sql = "SELECT count(business_guid) as count FROM house_business ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM house_business ".$this->buildWhere(array('business_guid' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM house_business ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from house_business". $this->buildWhere($where) . $this->order($orderby) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from house_business". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxBusinessId(){
		$sql = "select max(business_guid) from house_business";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(business_guid)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addBusiness($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxBusinessId();

		if(!empty($guid)){
			$arr['business_guid'] = $guid+1;
		}else{
			$arr['business_guid'] = 1000000000;
		}	

		if(!$this->insert('house_business',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['business_guid'];
    }

	public function updateBusiness($arr,$where)
	{
        return $this->update('house_business',$arr, $where);
	}


}