<?php
class urlQueue extends BaseDb
{
	
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
	
	function buildTable(){
		$table = $this->tablename();
		$sql = "
			CREATE TABLE IF NOT EXISTS `{$table}` (
			  `qid` bigint(30) unsigned NOT NULL AUTO_INCREMENT,
			  `url` varchar(255) NOT NULL,
			  `target` varchar(10) NOT NULL,
			  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
			  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
			  PRIMARY KEY (`qid`)
			) ENGINE= MYISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		";
		return $this->query($sql);
	}
	
	function truncate(){
		$this->query('TRUNCATE TABLE url_queue');
	}
	
	function tablename(){
		return 'url_queue';
	}
	
	function prev_table(){
		return 'url_queue_'.date("y_m",strtotime("-1 month"));
	}
	
	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['qid'])){
			$whereArr[] = " qid = '".$where['qid']."' ";
		}
		
		if(isset($where['url'])){
			$whereArr[] = " url = '".$where['url']."' ";
		}		
		
		if(isset($where['target'])){
			$whereArr[] = " target = '".$where['target']."' ";
		}	
		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
	
	public function count($where = array())
	{	
		$sql = "SELECT count(qid) as count FROM ".$this->tablename().$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}
	public function getInfo($where){

		$sql = "SELECT * FROM ".$this->tablename().$this->buildWhere($where);
		return $this->fetch($sql);		
	}

	public function add($arr){
		return $this->insert($this->tablename(),$arr,true,true);
	}

	public function remove($where){
		return $this->delete($this->tablename(),$where);
	}
	public function getMaxId($target){
		$sql = "SELECT max(qid) FROM ".$this->tablename()." WHERE status='0' AND target = '".$target."'";
		//echo "sql:".$sql."\r\n";
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(qid)'] : null;
	}
	public function getMaxId_new($where)
	{
		$sql = "SELECT max(qid) FROM ".$this->tablename().$this->buildWhere($where);
		$data = $this->fetch($sql);
		return !empty($data) ? $data['max(qid)'] : null;
	}
	public function flush_new($target){
		//$this->tranStart();
		//$this->query("UPDATE ".$this->tablename()." as a, (SELECT qid FROM ".$this->tablename()." WHERE status='0' AND target =".$target."  ORDER BY qid ASC LIMIT 1  for update) tmp SET status='1' WHERE a.qid=LAST_INSERT_ID(tmp.qid)");
		$lastId = $this->getMaxId($target);
		//$this->commit();
		//$this->tranEnd();
		if($lastId){
			$sql = "SELECT * FROM ".$this->tablename() .$this->buildWhere(array('qid' => $lastId));
			$res = $this->fetch($sql);	
			!empty($res) && $this->delete($this->tablename(),array('qid' => $lastId));
			return $res;			
		}
		return null;
	}
	public function flush($where)
	{
		$lastId = $this->getMaxId_new($where);
		if($lastId){
			$sql = "SELECT * FROM ".$this->tablename() .$this->buildWhere(array('qid' => $lastId));
			$res = $this->fetch($sql);	
			!empty($res) && $this->delete($this->tablename(),array('qid' => $lastId));
			return $res;			
		}
		return null;
	}	
	public function updateStatus($arr,$where){
		return $this->update($this->tablename(),$arr,$where);
	}
}
?>