<?php
class qr_image extends BaseDb
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
	public function buildWhere($where = array(),$prefix = ''){
		$whereArr = array();
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
		if(isset($where['url']) && $where['url']){
			$whereArr[] = " url = '".$where['url']."'";
		} 
		if(isset($where['is_distributed']) && $where['is_distributed']){
			$whereArr[] = " is_distributed = '".$where['is_distributed']."'";
		} 
		if(isset($where['agent_open_id']) && $where['agent_open_id']){
			$whereArr[] = " agent_open_id = '".$where['agent_open_id']."'";
		}  
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';   
	}

	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM qr_image ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}
	public function getInfoByid($id)
	{	
		$sql = "SELECT * FROM qr_image ".$this->buildWhere(array('id' =>$id ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM qr_image ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from qr_image". $this->buildWhere($where) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0)
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from qr_image". $this->buildWhere($where) .$limit_str;
		return $this->fetch_all($sql);
	}
	public function getMinUnDistributedID(){
		$sql = "select min(id) from qr_image where is_distributed = 0";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['min(id)'] : null;
	}
	public function getUnDistributedQR($openId){
		$id = $this->getMinUnDistributedID();
		if(empty($id)){
			return null;
		}
		$info = $this->getInfoByid($id);
		if($this->updateQR(array('is_distributed'=>1,'agent_open_id'=>$openId),array('id'=>$id))){
			return $info['url'];
		}else{
			return null;
		}
	}
    public function addQR($arr){
        
		$this->getDb()->beginTransaction();	

		if(!$this->insert('qr_image',$arr)){
			$this->getDb()->rollBack();
		}
        
        return $this->getDb()->commit();
    }

	public function updateQR($arr,$where)
	{
        return $this->update('qr_image',$arr, $where);
	}

}
?>