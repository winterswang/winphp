<?php
class agent extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}

 		if(isset($where['agent_guid'])){
			$whereArr[] = " agent_guid = '".$where['agent_guid']."'";
		}   

		if(isset($where['agent_url'])){
			$whereArr[] = " agent_url = '".$where['agent_url']."'";
		}
		
		if(isset($where['house_id'])){
			$whereArr[] = " house_id = '".$where['house_id']."'";
		}		

		if(isset($where['agent_name	'])){
			$whereArr[] = " agent_name	 = '".$where['agent_name	']."'";
		}
		
		if(isset($where['telephone'])){
			$whereArr[] = " telephone = '".$where['telephone']."' ";
		}
		
		if(isset($where['level'])){
			$whereArr[] = " level = '".$where['level']."' ";
		}

		if(isset($where['company'])){
			$whereArr[] = " company = '".$where['company']."' ";
		}
		

		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	public function isExist($agent_url){
		$count = $this->getCount(array('agent_url' =>$agent_url));
		if($count>0){
			return true;
		}else{
			return false;
		}
	}

	public function getCount($where = array()){
		$sql = "SELECT count(agent_guid) as count FROM agent ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "SELECT * FROM agent ".$this->buildWhere(array('agent_guid' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM agent ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from agent". $this->buildWhere($where) . $this->order($orderby) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from agent". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxAgentId(){
		$sql = "select max(agent_guid) from agent";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(agent_guid)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addAgent($arr){
        
		$this->getDb()->beginTransaction();
		$guid = $this->getMaxagentId();

		if(!empty($guid)){
			$arr['agent_guid'] = $guid+1;
		}else{
			$arr['agent_guid'] = 1000000000;
		}	

		if(!$this->insert('agent',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $arr['agent_guid'];
    }

	public function updateAgent($arr,$where)
	{
        return $this->update('agent',$arr, $where);
	}


}