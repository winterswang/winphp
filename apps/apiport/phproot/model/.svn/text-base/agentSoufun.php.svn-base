<?php
class agentSoufun extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}

 		if(isset($where['soufun_id'])){
			$whereArr[] = " soufun_id = '".$where['soufun_id']."'";
		}   

		if(isset($where['store_id'])){
			$whereArr[] = " store_id = '".$where['store_id']."'";
		}		

		if(isset($where['name'])){
			$whereArr[] = " name = '".$where['name']."'";
		}
		
		if(isset($where['tel'])){
			$whereArr[] = " tel = '".$where['tel']."' ";
		}
		
		if(isset($where['city'])){
			$whereArr[] = " city = '".$where['city']."' ";
		}

		if(isset($where['company'])){
			$whereArr[] = " company = '".$where['company']."' ";
		}

		if(isset($where['image_url'])){
			$whereArr[] = " image_url = '".$where['image_url']."' ";
		}		
		
		if(isset($where['wx_num'])){
			$whereArr[] = " wx_num = '".$where['wx_num']."' ";
		}				

		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	public function isExist($store_id){
		$count = $this->getCount(array('store_id' =>$store_id));
		if($count>0){
			return true;
		}else{
			return false;
		}
	}

	public function getCount($where = array()){
		$sql = "SELECT count(soufun_id) as count FROM agent_soufun ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($soufun_id)
	{	
		$sql = "SELECT * FROM agent_soufun ".$this->buildWhere(array('soufun_id' =>$soufun_id ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM agent_soufun ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from agent_soufun". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0)
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from agent_soufun". $this->buildWhere($where).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxAgentId(){
		$sql = "select max(soufun_id) from agent_soufun";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(soufun_id)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addAgent($arr){
        
		$this->getDb()->beginTransaction();

		if(!$this->insert('agent_soufun',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();

    }

	public function updateAgent($arr,$where)
	{
        return $this->update('agent_soufun',$arr, $where);
	}


}