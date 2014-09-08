<?php
class test extends BaseDb{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
 		if(isset($where['name'])){
			$whereArr[] = " name = '".$where['name']."'";
		}  
 		if(isset($where['tel'])){
			$whereArr[] = " tel = '".$where['tel']."'";
		}   

		if(isset($where['mobeltel'])){
			$whereArr[] = " mobeltel = '".$where['mobeltel']."'";
		}
		if(isset($where['company'])){
			$whereArr[] = " company = '".$where['company']."'";
		}
		if(isset($where['website'])){
			$whereArr[] = " website = '".$where['website']."'";
		}
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}

	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM test ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoById($guid)
	{	
		$sql = "SELECT * FROM test ".$this->buildWhere(array('id' =>$guid ));
		return $this->fetch($sql);
	}
	
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM test ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10,$orderby = 'createtime_desc')
	{
        $sql = "select * from test". $this->buildWhere($where) . $this->order($orderby) .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array(),$limit = 0,$orderby = 'createtime_desc')
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from test". $this->buildWhere($where) . $this->order($orderby).$limit_str;
		return $this->fetch_all($sql);
	}

	public function getMaxtestId(){
		$sql = "select max(id) from test";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(id)'] : null;
	}    
    
    public function getHashCode($arr){
    	return  md5($arr);
    }

    public function addTest($arr){

        $this->getDb()->beginTransaction();

		if(!$this->insert('test',$arr)){
			$this->getDb()->rollBack();
		}     

        $this->getDb()->commit();        
   

    }

	public function updateTest($arr,$where)
	{
        return $this->update('test',$arr, $where);
	}


}