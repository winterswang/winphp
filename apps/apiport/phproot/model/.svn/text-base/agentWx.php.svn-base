<?php
class agentWx extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){

		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
 		if(isset($where['open_id']) && !empty($where['open_id'])){
			$whereArr[] = " open_id = '".$where['open_id']."'";
		}   
		if(isset($where['agent_name']) && !empty($where['agent_name'])){
			$whereArr[] = " agent_name	 = '".$where['agent_name']."'";
		}		
		if(isset($where['agent_tel']) && !empty($where['agent_tel'])){
			$whereArr[] = " agent_tel = '".$where['agent_tel']."' ";
		}		
		if(isset($where['store_url'])){
			$whereArr[] = " store_url = '".$where['store_url']."' ";
		}
		if(isset($where['agent_wx_id'])){
			$whereArr[] = " agent_wx_id = '".$where['agent_wx_id']."' ";
		}
		if(isset($where['wx_nickname'])){
			$whereArr[] = "wx_nickname = '".$where['wx_nickname']."' ";
		}		
		if(isset($where['qr_url'])){
			$whereArr[] = "qr_url = '".$where['qr_url']."' ";
		}
		if(isset($where['head_url'])){
			$whereArr[] = "head_url = '".$where['head_url']."' ";
		}
		if(isset($where['company'])){
			$whereArr[] = "company = '".$where['company']."' ";
		}
		if(isset($where['store_name'])){
			$whereArr[] = "store_name = '".$where['store_name']."' ";
		}
		if(isset($where['position'])){
			$whereArr[] = "position = '".$where['position']."' ";
		}		
		if(isset($where['business'])){
			$whereArr[] = "business = '".$where['business']."' ";
		}	
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	public function isExist($agent_tel){
		$count = $this->getCount(array('agent_tel' =>$agent_tel));
		if($count>0){
			return true;
		}else{
			return false;
		}
	}

	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM agent_wx ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByid($id)
	{	
		$sql = "SELECT * FROM agent_wx ".$this->buildWhere(array('id' =>$id ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM agent_wx ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from agent_wx". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0)
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from agent_wx". $this->buildWhere($where) .$limit_str;
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

    public function addAgent($arr){
        
		$this->getDb()->beginTransaction();	

		if(!$this->insert('agent_wx',$arr)){
			$this->getDb()->rollBack();
		}
        
        return $this->getDb()->commit();
    }

	public function updateAgent($arr,$where)
	{
        return $this->update('agent_wx',$arr, $where);
	}


}