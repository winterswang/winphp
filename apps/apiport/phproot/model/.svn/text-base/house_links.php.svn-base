<?php
class house_links extends BaseDb{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
	public function buildWhere($where = array())
	{
		$whereArr = array();
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
		if(isset($where['agent_url']) && $where['agent_url']){
			$whereArr[] = " agent_url = '".$where['agent_url']."'";
		}
		if(isset($where['house_url']) && $where['house_url']){
			$whereArr[] = " house_url = '".$where['house_url']."'";
		}
		if(isset($where['parse_status'])){
			$whereArr[] = " parse_status = '".$where['parse_status']."'";
		}
		if(isset($where['status'])){
			$whereArr[] = " status = '".$where['status']."'";
		}
		if(isset($where['insert_date'])){
			$whereArr[] = " insert_date = '".$where['insert_date']."'";
		}
		if(isset($where['parse_date'])){
			$whereArr[] = " parse_date = '".$where['parse_date']."'";
		}
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';			
	}

	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM house_links ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoById($xuequ_id)
	{	
		$sql = "SELECT * FROM house_links ".$this->buildWhere(array('xuequ_id' =>$xuequ_id ));
		return $this->fetch($sql);
	}
	public function getFlush(){
		$minId = $this->getMinId(array('parse_status'=>0,'status'=>0));
		if(empty($minId)){
			return null;
		}
		return  $this->getInfo(array('id'=>$minId));
	}	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM house_links ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from house_links". $this->buildWhere($where). $this->order($orderby).$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from house_links". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMinId($where =array()){
		$sql = "select min(id) from house_links". $this->buildWhere($where);
		$data = $this->fetch($sql);
		return !empty($data) ? $data['min(id)'] : null;
	}      

    public function addHouseLinks($arr){
        
		$this->getDb()->beginTransaction();

		if(!$this->insert('house_links',$arr)){
			$this->getDb()->rollBack();
		}
        
        return $this->getDb()->commit();
    }

	public function updateHouseLinks($arr,$where)
	{
        if($this->update('house_links',$arr, $where)){
        	return true;
        }
        return false;
	}
}