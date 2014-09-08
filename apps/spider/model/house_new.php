<?php
class house_new extends BaseDb
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
        
		if(isset($where['house_id'])){
			$whereArr[] = " house_id = '".$where['house_id']."'";
		}
		if(isset($where['house_guid'])){
			$whereArr[] = " house_guid = '".$where['house_guid']."'";
		}		
		if(isset($where['district_id'])){
			$whereArr[] = " district_id = '".$where['district_id']."'";
		}		

		if(isset($where['district_name'])){
			$whereArr[] = " district_name = '".$where['district_name']."'";
		}
		
		if(isset($where['fitment']) && $where['fitment'] > 0){
			$whereArr[] = " fitment = '".$where['fitment']."' ";
		}
		
		if(isset($where['sell_price']) && $where['sell_price'] > 0){
			$whereArr[] = " sell_price = '".$where['sell_price']."' ";
		}

		if(isset($where['room'])){
			$whereArr[] = " room = '".$where['room']."'";
		}
		
		if(isset($where['average_price'])){
			$whereArr[] = " average_price = '".$where['average_price']."'";
		}
        
		if(isset($where['agent_id'])){
			$whereArr[] = " agent_id = '".$where['agent_id']."'";
		}
		
		if(isset($where['label'])){
			$whereArr[] = " label = '".$where['label']."'";
		}
		
		if(isset($where['source'])){
			$whereArr[] = " source = '".$where['source']."'";
		}		
		
		if(isset($where['is_onsell'])){
			$whereArr[] = " is_sell = '".$where['is_onsell']."'";
		}

		if(isset($where['create_time'])){
			$whereArr[] = " create_time = '".$where['create_time']."'";
		}

		if(isset($where['update_time'])){
			$whereArr[] = " update_time = '".$where['update_time']."'";
		}
		if(isset($where['district_id'])){
			$whereArr[] = " district_id = '".$where['district_id']."'";
		}
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	
	public function getCount($where = array()){
		$sql = "SELECT count(house_id) as count FROM house ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM house ".$this->buildWhere(array('house_id' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM house ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
  	public function getSimpleListNew($where = array())
	{

        $sql = "select district_id,house_guid,district_name,room,hall,title,label,square,sell_price from house". $this->buildWhere($where) ;
        file_put_contents('/tmp/ttt.log', $sql);
		return $this->fetch_all($sql);
	}	
  	public function getSimpleList($where = array(),$page_no=0, $page_size=0)
	{

        $sql = "select district_id,house_guid,district_name,room,hall,title,label,square,sell_price from house". $this->buildWhere($where) ;

        if($page_no>0 && $page_size>0){
        	$sql = $sql.$this->limit($page_no, $page_size);
        }
        file_put_contents('/tmp/ttt.log', $sql);
		return $this->fetch_all($sql);
	}  
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from house". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from house". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxHouseGuid(){
		$sql = "select max(house_guid) from house";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(house_guid)'] : null;
	}    
    
    public function addHouse($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxHouseGuid();
		$arr['house_guid'] = 1000000000;
		if(!empty($guid)){
			$arr['house_guid'] = $guid+1;
		}	
		
		if(!$this->insert('house',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['house_guid'];
    }

	public function updateHouse($arr,$where)
	{
        return $this->update('house',$arr, $where);
	}

	public function OffSellHouse($arr,$where){
		
		return $this->update('house',$arr, $where);
	}
    
}
?>