<?php
class daily_life extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}

 		if(isset($where['daily_life_guid']) && $where['daily_life_guid']){
			$whereArr[] = " daily_life_guid = '".$where['daily_life_guid']."'";
		}   

		if(isset($where['daily_life_type'])){
			$whereArr[] = " daily_life_type = '".$where['daily_life_type']."'";
		}
		
		if(isset($where['daily_life_name'])){
			$whereArr[] = " daily_life_name = '".$where['daily_life_name']."'";
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
		$sql = "SELECT count(daily_life_guid) as count FROM house_daily_life ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM house_daily_life ".$this->buildWhere(array('daily_life_guid' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM house_daily_life ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from house_daily_life". $this->buildWhere($where) . $this->order($orderby) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from house_daily_life". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxDaily_lifeId(){
		$sql = "select max(daily_life_guid) from house_daily_life";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(daily_life_guid)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addDaily_life($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxDaily_lifeId();

		if(!empty($guid)){
			$arr['daily_life_guid'] = $guid+1;
		}else{
			$arr['daily_life_guid'] = 1000000000;
		}	

		if(!$this->insert('house_daily_life',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['daily_life_guid'];
    }

	public function updateDaily_life($arr,$where)
	{
        return $this->update('house_daily_life',$arr, $where);
	}


}