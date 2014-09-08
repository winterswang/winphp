<?php
class district extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}

 		if(isset($where['district_id']) && $where['district_id']){
			$whereArr[] = " district_id = '".$where['district_id']."'";
		}   

		if(isset($where['district_guid'])){
			$whereArr[] = " district_guid = '".$where['district_guid']."'";
		}
		if(isset($where['district_name'])){
			$whereArr[] = " district_name = '".$where['district_name']."'";
		}
		if(isset($where['address']) && $where['address']){
			$whereArr[] = " address = '".$where['address']."'";
		}

 		if(isset($where['build_time']) && $where['build_time']){
			$whereArr[] = " build_time = '".$where['build_time']."'";
		}   

		if(isset($where['build_company'])){
			$whereArr[] = " build_company = '".$where['build_company']."'";
		}
		if(isset($where['build_square'])){
			$whereArr[] = " build_square = '".$where['build_square']."'";
		}
		if(isset($where['area']) && $where['area']){
			$whereArr[] = " area = '".$where['area']."'";
		}

 		if(isset($where['manage_company']) && $where['manage_company']){
			$whereArr[] = " manage_company = '".$where['manage_company']."'";
		}   

		if(isset($where['manage_fee'])){
			$whereArr[] = " manage_fee = '".$where['manage_fee']."'";
		}
		if(isset($where['green_rate'])){
			$whereArr[] = " green_rate = '".$where['green_rate']."'";
		}
		if(isset($where['floor_rate']) && $where['floor_rate']){
			$whereArr[] = " floor_rate = '".$where['floor_rate']."'";
		}

 		if(isset($where['agent_url']) && $where['agent_url']){
			$whereArr[] = " agent_url = '".$where['agent_url']."'";
		}   

		if(isset($where['overview'])){
			$whereArr[] = " overview = '".$where['overview']."'";
		}
		if(isset($where['parking_space'])){
			$whereArr[] = " parking_space = '".$where['parking_space']."'";
		}
		if(isset($where['house_count'])){
			$whereArr[] = " house_count = '".$where['house_count']."' ";
		}
		if(isset($where['house_price'])){
			$whereArr[] = " house_price = '".$where['house_price']."' ";
		}
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}

	public function getCount($where = array()){
		$sql = "SELECT count(district_id) as count FROM district ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}
	public function isExist($district_id){
		$count = $this->getCount(array('district_id' =>$district_id));
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
	public function updateHouseCount(){
		$sql = "update district as d,(select district_id,count(house_guid) as cn from house group by district_id) as t set d.house_count = t.cn where d.district_id = t.district_id ";
		return $this->fetch($sql);
	}
	public function getInfoById($guid)
	{	
		$sql = "SELECT * FROM district ".$this->buildWhere(array('id' =>$guid ));
		return $this->fetch($sql);
	}

	public function getSimpleInfo($where = array())
	{
		$sql = "SELECT * FROM district ".$this->buildWhere($where);
		return $this->fetch($sql);
	}

	public function getInfo($where)
	{	
		$sql = "SELECT * FROM district ".$this->buildWhere($where);
		return $this->fetch($sql);
	}

    public function getDistrictId($where = array(),$page_no = 1, $page_size = 10){
		$sql = "SELECT district_id FROM district ".$this->buildWhere($where).'ORDER BY district_id ASC';
		$sql .= $this->limit($page_no,$page_size);
		return $this->fetch_all($sql);
	}
	
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from district". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from district". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxDistrictGuid(){
		$sql = "select max(district_guid) from district";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(district_guid)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addDistrict($arr){

        $this->getDb()->beginTransaction();
		$guid = $this->getMaxDistrictGuid();
		
		if(!empty($guid)){
			$arr['district_guid'] = $guid+1;
		}else{
			$arr['district_guid'] = 1000000000;
		}	

		if(!$this->insert('district',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['district_guid'];

    }

	public function updateDistrict($arr,$where)
	{
        return $this->update('district',$arr, $where);
	}


}