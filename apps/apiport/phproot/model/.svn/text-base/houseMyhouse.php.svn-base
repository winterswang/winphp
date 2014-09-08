<?php
class houseMyhouse extends BaseDb
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
	public function createView(){
		$sql = "create view house_user_myhouse AS
SELECT r.uid as uid ,h.house_guid,h.district_guid,h.district_name,h.house_intro,h.room,h.wc,h.floor_on,h.floor_all,h.square,h.rent_type,h.rent_period,h.provides,h.subscribe_type,h.title,h.description,h.rent_price,h.uid as house_uid ,h.proved,1 as type , r.reserve_id,r.mobile,r.updatetime as dateline FROM reserve_house as h JOIN reserve_info as r ON h.reserve_id = r.reserve_id  WHERE r.is_delete=0
UNION 
SELECT  f.uid as uid ,h.house_guid,h.district_guid,h.district_name,h.house_intro,h.room,h.wc,h.floor_on,h.floor_all,h.square,h.rent_type,h.rent_period,h.provides,h.subscribe_type,h.title,h.description,h.rent_price,h.uid as house_uid ,h.proved,0 as type ,0 as reserve_id,0 as mobile,f.dateline  FROM  house_user_favorite as f inner join house_info as h on f.house_guid=h.house_guid where h.is_delete = 0
";
		return $this->query($sql);
	}
	
	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['uid']) && $where['uid']){
			$whereArr[] = " uid = '".$where['uid']."'";
		}
        
		if(isset($where['house_guid']) && $where['house_guid']){
			$whereArr[] = " house_guid = '".$where['house_guid']."'";
		}
        
		if(isset($where['type']) && $where['type']){
			$whereArr[] = " type = '".$where['type']."'";
		}
		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
    
	public function getCount($where = array()){
		$sql = "SELECT count(*) as count FROM house_user_myhouse ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count']; 
	}

	public function getInfo($where = array())
	{	
		$sql = "SELECT * FROM house_user_myhouse ".$this->buildWhere($where);
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select DISTINCT * from house_user_myhouse". $this->buildWhere($where) . ' ORDER BY type DESC,dateline DESC' .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
}
?>