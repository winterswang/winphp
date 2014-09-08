<?php
class disgust extends BaseDb{

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
 		if(isset($where['disgust_guid']) && $where['disgust_guid']){
			$whereArr[] = " disgust_guid = '".$where['disgust_guid']."'";
		}   

		if(isset($where['disgust_type'])){
			$whereArr[] = " disgust_type = '".$where['disgust_type']."'";
		}
		
		if(isset($where['disgust_name'])){
			$whereArr[] = " disgust_name = '".$where['disgust_name']."'";
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
		$sql = "SELECT count(disgust_guid) as count FROM house_disgust ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM house_disgust ".$this->buildWhere(array('disgust_guid' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM house_disgust ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from house_disgust". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from house_disgust". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxDisgustId(){
		$sql = "select max(disgust_guid) from house_disgust";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(disgust_guid)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addDisgust($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxDisgustId();

		if(!empty($guid)){
			$arr['disgust_guid'] = $guid+1;
		}else{
			$arr['disgust_guid'] = 1000000000;
		}	

		if(!$this->insert('house_disgust',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['disgust_guid'];
    }

	public function updateDisgust($arr,$where)
	{
        return $this->update('house_disgust',$arr, $where);
	}

	public function del($where)
	{
		return $this->delete('house_disgust',$where);
	}
}