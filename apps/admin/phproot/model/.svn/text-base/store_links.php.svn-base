<?php
class store_links extends BaseDb{
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
		if(isset($where['url']) && $where['url']){
			$whereArr[] = " url = '".$where['url']."'";
		}
		if(isset($where['analyze_status']) && $where['analyze_status']){
			$whereArr[] = " analyze_status = '".$where['analyze_status']."'";
		}
		if(isset($where['house_count']) && $where['house_count']){
			$whereArr[] = " house_count = '".$where['house_count']."'";
		}
		if(isset($where['analyze_count']) && $where['analyze_count']){
			$whereArr[] = " analyze_count = '".$where['analyze_count']."'";
		}
		if(isset($where['downloaded_count']) && $where['downloaded_count']){
			$whereArr[] = " downloaded_count = '".$where['downloaded_count']."'";
		}
		if(isset($where['fail_count']) && $where['fail_count']){
			$whereArr[] = " fail_count = '".$where['fail_count']."'";
		}
		if(isset($where['createtime']) && $where['createtime']){
			$whereArr[] = " createtime = '".$where['createtime']."'";
		}
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';			
	}

	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM store_links ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoById($xuequ_id)
	{	
		$sql = "SELECT * FROM store_links ".$this->buildWhere(array('xuequ_id' =>$xuequ_id ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM store_links ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_ASC')
	{
        $sql = "select * from store_links". $this->buildWhere($where).$this->order($orderby).$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_ASC')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from store_links". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	// public function getMaxXuequId(){
	// 	$sql = "select max(xuequ_guid) from store_links";
	// 	$data = $this->fetch($sql);
	// 	return !empty($data) ? $data['max(xuequ_guid)'] : null;
	// }      

    public function addStoreLinks($arr){
        
		$this->getDb()->beginTransaction();
		//$guid = $this->getMaxxuequId();	

		if(!$this->insert('store_links',$arr)){
			$this->getDb()->rollBack();
		}
        
        return $this->getDb()->commit();
    }

	public function updateStoreLinks($arr,$where)
	{
        if($this->update('store_links',$arr, $where)){
        	return true;
        }
        return false;
	}
}