<?php
class dead_links extends BaseDb
{
	
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
	
	function tablename(){
		return 'dead_links';
	}
	
	function prevtable(){
		return 'dead_links';
	}	
	
	function buildTable(){
		$table = $this->tablename();
		$sql = "
			CREATE TABLE IF NOT EXISTS `{$table}` (
			  `id` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
			  `url` varchar(255) NOT NULL,
			  `target` varchar(20) NOT NULL,
			  `filepath` varchar(255) NOT NULL,
			  `download` tinyint(1) unsigned NOT NULL DEFAULT '0',
			  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
			  `house_guid` int(10) unsigned NOT NULL DEFAULT '0',
			  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE= MYISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		";
		return $this->query($sql);
	}
	
	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['id'])){
			$whereArr[] = " id = '".$where['id']."' ";
		}
		
		if(isset($where['url'])){
			$whereArr[] = " url = '".$where['url']."' ";
		}	
		
		if(isset($where['download'])){
			$whereArr[] = " download = '".$where['download']."' ";
		}		
		
		if(isset($where['target'])){
			$whereArr[] = " target = '".$where['target']."' ";
		}
		
		if(isset($where['status'])){
			$whereArr[] = " status = '".$where['status']."' ";
		}
		if(isset($where['is_exist'])){
			$whereArr[] = " is_exist = '".$where['is_exist']."' ";
		}
		if(isset($where['dead_num'])){
			$whereArr[] = " dead_num > '".$where['dead_num']."' ";
		}		
		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	
	public function count($where = array())
	{	
		$sql = "SELECT count(id) as count FROM ".$this->tablename().$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}
	
	public function hasExist($where = array())
	{
		
		$sql = "SELECT count(id) as count FROM ".$this->tablename().$this->buildWhere($where);
		$row = $this->fetch($sql);
			
		if(!$row['count'] && date('j') < 7){
			$sql = "SELECT count(id) as count FROM ".$this->prevtable().$this->buildWhere($where);
			$row = $this->fetch($sql);			
		}

		return $row['count'];
	}	

	public function getInfo($where = array())
	{	
		$sql = "SELECT * FROM ".$this->tablename().$this->buildWhere($where);
		return $this->fetch($sql);
	}	
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select * from ". $this->tablename(). $this->buildWhere($where).$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    	
	public function addResouce($arr){
		return $this->insert($this->tablename(),$arr,true);
	}

	public function updateResouce($arr,$where){
		return $this->update($this->tablename(),$arr,$where);
	}

	public function deleteResouce($where){
		return $this->delete($this->tablename(),$where);
	}

	public function getMaxId($where = array()){
		$sql = "SELECT max(id) FROM ".$this->tablename().$this->buildWhere($where);
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(id)'] : null;
	}
	public function flush_new($target){

		$lastId = $this->getMaxId(array('status' =>0,'download'=>0,'target'=>$target));
		if($lastId){
			$sql = "SELECT * FROM ".$this->tablename() .$this->buildWhere(array('id' => $lastId));
			$res = $this->fetch($sql);	
			return $res;			
		}
		return null;
	}
	public function flush($where){

		$lastId = $this->getMaxId($where);
		if($lastId){
			$sql = "SELECT * FROM ".$this->tablename() .$this->buildWhere(array('id' => $lastId));
			$res = $this->fetch($sql);	
			return $res;			
		}
		return null;
	}
}
?>