<?php
class house extends BaseDb
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
	public function buildWhere($where = array()){
		$whereArr = array();
		
		if(isset($where['uid']) && $where['uid']){
			$whereArr[] = " h.uid = '".$where['uid']."'";
		}

		if(isset($where['district_guid']) && $where['district_guid']){
			$whereArr[] = " h.district_guid = '".$where['district_guid']."'";
		}

		if(isset($where['district_guids']) && !empty($where['district_guids'])){
			$whereArr[] = " h.district_guid IN ('".join("','",$where['district_guids'])."')";
		}
        
		if(isset($where['house_guid'])){
			$whereArr[] = " h.house_guid = '".$where['house_guid']."'";
		}
        
		if(isset($where['house_guids']) and !empty($where['house_guids'])){
			$whereArr[] = " h.house_guid IN ('".join(',',$where['house_guids'])."')";
		}              
        
		if(isset($where['status'])){
			$whereArr[] = " h.status = '".$where['status']."'";
		}

		if(isset($where['rent_type'])){
			$whereArr[] = " h.rent_type = '".$where['rent_type']."'";
		}
		
		if(isset($where['proved'])){
			$whereArr[] = " h.proved = '".$where['proved']."'";
		}
		
		if(isset($where['checked'])){
			$whereArr[] = " h.checked = '".$where['checked']."'";
		}		
		
		if(isset($where['is_delete'])){
			$whereArr[] = " h.is_delete = '".$where['is_delete']."'";
		}	
		
		if(isset($where['rent_price'])){
			if ($where['rent_price'] == 1) {
				$whereArr[] = " h.rent_price <= 500";
			}elseif ($where['rent_price'] == 2){
				$whereArr[] = " h.rent_price <= 1000 AND h.rent_price > 500";
			}elseif ($where['rent_price'] == 3){
				$whereArr[] = " h.rent_price <= 1500 AND h.rent_price > 1000";
			}elseif ($where['rent_price'] == 4){
				$whereArr[] = " h.rent_price <= 3000 AND h.rent_price > 1500";
			}elseif ($where['rent_price'] == 5){
				$whereArr[] = " h.rent_price <= 4000 AND h.rent_price > 3000";
			}elseif ($where['rent_price'] == 6){
				$whereArr[] = " h.rent_price >= 4000";
			}
		}
		
		if(isset($where['subscribe_type']) && $where['subscribe_type']){
			$whereArr[] = " h.subscribe_type = '".$where['subscribe_type']."'";
		}
		
		if(isset($where['keyword']) && $where['keyword']){
			$whereArr[] = " h.title LIKE '"."%".$where['keyword']."%'";
		}

		if(isset($where['source']) && $where['source']){
			$whereArr[] = " h.source = '".$where['source']."'";
		}		
		
		if (isset($where['createtime']) && !empty($where['createtime'])) {
			$whereArr[] = " (h.createtime>=".$where['createtime']." AND h.createtime<".$where['createtime']."+24*60*60) ";
		}
		
		return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
	}
    
	public function getCount($where = array()){
		$sql = "SELECT count(house_id) as count FROM house_info as h ".$this->buildWhere($where);
		$row = $this->fetch($sql);
		return $row['count'];
	}

	public function getInfoByGuid($guid)
	{	
		$sql = "select h.*,d.district_name from house_info as h LEFT JOIN district_info as d ON d.district_guid = h.district_guid ".$this->buildWhere(array('house_guid' =>$guid ));
		return $this->fetch($sql);
	}
    
	public function getList($where = array(),$page_no = 1, $page_size = 10)
	{
        $sql = "select h.*,d.district_name from house_info as h LEFT JOIN district_info as d ON d.district_guid = h.district_guid ". $this->buildWhere($where) . ' ORDER BY h.house_id DESC' .$this->limit($page_no, $page_size);
		return $this->fetch_all($sql);
	}
    
	public function getAll($where = array())
	{
        $sql = "select h.*,d.district_name from house_info as h LEFT JOIN district_info as d ON d.district_guid = h.district_guid ". $this->buildWhere($where) . ' ORDER BY h.house_id DESC';
		return $this->fetch_all($sql);
	}    
    
    public function addHouse($arr){
        $guid = IDGenerator::factory('house_info')->getNextID();
        if(!$guid){
            return false;
        }
        
		$this->getDb()->beginTransaction();
		
		$arr['house_guid'] = $guid;
		
		if(!$this->insert('house_info',$arr)){
			$this->getDb()->rollBack();
		}
        
        $this->getDb()->commit();
        
        return $guid;
    }

	public function updateHouse($arr,$where)
	{
        return $this->update('house_info', $arr, $where);
	}
	
	public function deleteHouse($where)
	{
		return $this->update('house_info', array('is_delete'=>'1'), $where);
	}
    
    public function incHouseCollect($house_guid){
        $sql = "update house_info set collect_num=collect_num+1 where house_guid = ".$house_guid;
        return $this->query($sql);
    }
    
    public function incHouseSubscribe($house_guid){
        $sql = "update house_info set subscribe_num=subscribe_num+1 where house_guid = ".$house_guid;
        return $this->query($sql);
    }
    
    public function incHouseView($house_guid){
        $sql = "update house_info set view_num=view_num+1 where house_guid = ".$house_guid;
        return $this->query($sql);
    }    
    
}
?>