<?php
class agentClient extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){

		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
 		if(isset($where['client_open_id']) && !empty($where['client_open_id'])){
			$whereArr[] = " client_open_id = '".$where['client_open_id']."'";
		}   
		if(isset($where['agent_open_id']) && !empty($where['agent_open_id'])){
			$whereArr[] = " agent_open_id	 = '".$where['agent_open_id']."'";
		}		
		if(isset($where['createtime']) && !empty($where['agent_tel'])){
			$whereArr[] = " agent_tel = '".$where['agent_tel']."' ";
		}		

		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	public function isExist($client_open_id,$agent_open_id){
		$count = $this->getCount(array('client_open_id' =>$client_open_id,'agent_open_id'=>$agent_open_id));
		if($count>0){
			return true;
		}else{
			return false;
		}
	}

	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM agent_client ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByid($id)
	{	
		$sql = "SELECT * FROM agent_client ".$this->buildWhere(array('id' =>$id ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM agent_client ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from agent_client". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0)
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from agent_client". $this->buildWhere($where) .$limit_str;
		return $this->fetch_all($sql);
	}

	// public function getMaxStoreNum(){
	// 	$sql = "select max(qr_image_id) from agent_wx";
	// 	$data = $this->fetch($sql);
	// 	return !empty($data) ? $data['max(store_num)'] : 0;
	// }    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addAgentClient($arr){
        
		$this->getDb()->beginTransaction();	

		if(!$this->insert('agent_client',$arr)){
			$this->getDb()->rollBack();
		}
        
        return $this->getDb()->commit();
    }

	public function updateAgentClient($arr,$where)
	{
        return $this->update('agent_client',$arr, $where);
	}


}