<?php
class keyMap extends BaseDb{
	public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function buildWhere($where = array()){
		$whereArr = array();
 		if(isset($where['id']) && $where['id']){
			$whereArr[] = " id = '".$where['id']."'";
		}
 		if(isset($where['keyword']) && $where['keyword']){
			$whereArr[] = " keyword = '".$where['keyword']."'";
		}
 		if(isset($where['value']) && $where['value']){
			$whereArr[] = " value = '".$where['value']."'";
		}
 		if(isset($where['type']) && $where['type']){
			$whereArr[] = " type = '".$where['type']."'";
		}
 		if(isset($where['rule']) && $where['rule']){
			$whereArr[] = " rule = '".$where['rule']."'";
		}		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';				   	
    }

	public function getCount($where = array()){
		$sql = "SELECT count(id) as count FROM keymap ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}
	public function getMaxId(){
		$sql = "SELECT max(id) from keymap";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(id)'] : null;
	}
	public function getInfoById($id)
	{	
		$sql = "SELECT * FROM keymap ".$this->buildWhere(array('id' =>$id ));
		return $this->fetch($sql);
	}
	public function getInfo($where)
	{	
		$sql = "SELECT * FROM keymap ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
	public function getKeyList($rule,$type = 2){
		$sql = "SELECT * from keymap where type = ".$type." AND keyword like '%".$rule."%'";
		return $this->fetch_all($sql);		
	}
	public function getList($where = array())
	{
        $sql = "select * from keymap". $this->buildWhere($where);
		return $this->fetch_all($sql);
	}
	public function getAll($where = array(),$limit = 0)
	{
		$limit_str = '';
		if($limit > 0){
			$limit_str = ' LIMIT '.$limit;
		}
        $sql = "select * from keymap". $this->buildWhere($where).'ORDER BY value ';
		return $this->fetch_all($sql);
	}
 
    public function addKeyMap($arr){
        
		$this->getDb()->beginTransaction();

		if(!$this->insert('keymap',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return true;
    }
	public function updateKeyMap($arr,$where)
	{
        return $this->update('keymap',$arr, $where);
	}

}