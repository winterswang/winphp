<?php
class traffic extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}

 		if(isset($where['traffic_guid']) && $where['traffic_guid']){
			$whereArr[] = " traffic_guid = '".$where['traffic_guid']."'";
		}   

		if(isset($where['traffic_type'])){
			$whereArr[] = " traffic_type = '".$where['traffic_type']."'";
		}
		
		if(isset($where['station_name'])){
			$whereArr[] = " station_name = '".$where['station_name']."'";
		}		

		if(isset($where['line_number'])){
			$whereArr[] = " line_number = '".$where['line_number']."'";
		}
		
		if(isset($where['distance']) && $where['distance'] > 0){
			$whereArr[] = " distance = '".$where['distance']."' ";
		}

		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}

	public function getCount($where = array()){
		$sql = "SELECT count(traffic_guid) as count FROM house_traffic ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM house_traffic ".$this->buildWhere(array('traffic_guid' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM house_traffic ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from house_traffic". $this->buildWhere($where) . $this->order($orderby) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from house_traffic". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxTrafficId(){
		$sql = "select max(traffic_guid) from house_traffic";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(traffic_guid)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addTraffic($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxTrafficId();

		if(!empty($guid)){
			$arr['traffic_guid'] = $guid+1;
		}else{
			$arr['traffic_guid'] = 1000000000;
		}	

		if(!$this->insert('house_traffic',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['traffic_guid'];
    }

	public function updateTraffic($arr,$where)
	{
        return $this->update('house_traffic',$arr, $where);
	}


}