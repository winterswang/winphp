<?php
class hospital extends BaseDb{

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
 		if(isset($where['hospital_guid']) && $where['hospital_guid']){
			$whereArr[] = " hospital_guid = '".$where['hospital_guid']."'";
		}   

		if(isset($where['hospital_type'])){
			$whereArr[] = " hospital_type = '".$where['hospital_type']."'";
		}
		
		if(isset($where['hospital_name'])){
			$whereArr[] = " hospital_name = '".$where['hospital_name']."'";
		}		

		if(isset($where['address'])){
			$whereArr[] = " address = '".$where['address']."'";
		}
		
		if(isset($where['distance'])){
			$whereArr[] = " distance = '".$where['distance']."' ";
		}

		if(isset($where['hashcode'])){
			$whereArr[] = " hashcode = '".$where['hashcode']."' ";
		}

		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}

	public function getCount($where = array()){
		$sql = "SELECT count(hospital_guid) as count FROM house_hospital ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM house_hospital ".$this->buildWhere(array('hospital_guid' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM house_hospital ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from house_hospital". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from house_hospital". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxHospitalId(){
		$sql = "select max(hospital_guid) from house_hospital";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(hospital_guid)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addHospital($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxHospitalId();

		if(!empty($guid)){
			$arr['hospital_guid'] = $guid+1;
		}else{
			$arr['hospital_guid'] = 1000000000;
		}	

		if(!$this->insert('house_hospital',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['hospital_guid'];
    }

	public function updateHospital($arr,$where)
	{
        return $this->update('house_hospital',$arr, $where);
	}
	public function del($where)
	{
		return $this->delete('house_hospital',$where);
	}

}