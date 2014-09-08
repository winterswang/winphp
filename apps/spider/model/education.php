<?php
class education extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}

 		if(isset($where['education_guid']) && $where['education_guid']){
			$whereArr[] = " education_guid = '".$where['education_guid']."'";
		}   

		if(isset($where['education_type'])){
			$whereArr[] = " education_type = '".$where['education_type']."'";
		}
		
		if(isset($where['education_name'])){
			$whereArr[] = " education_name = '".$where['education_name']."'";
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
		$sql = "SELECT count(education_guid) as count FROM house_education ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM house_education ".$this->buildWhere(array('education_guid' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM house_education ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from house_education". $this->buildWhere($where) . $this->order($orderby) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from house_education". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxEducationId(){
		$sql = "select max(education_guid) from house_education";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(education_guid)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addEducation($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxEducationId();

		if(!empty($guid)){
			$arr['education_guid'] = $guid+1;
		}else{
			$arr['education_guid'] = 1000000000;
		}	

		if(!$this->insert('house_education',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['education_guid'];
    }

	public function updateEducation($arr,$where)
	{
        return $this->update('house_education',$arr, $where);
	}


}