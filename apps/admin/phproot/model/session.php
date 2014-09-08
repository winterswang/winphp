<?php
class session extends BaseDb
{
	
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
	
	public function getSession($where = array())
	{
		$whereString = '';
		if (empty($where)) {
			$whereString = ' WHERE '.$this->import($where, ' AND ');
		}
		
		$sql = "SELECT * FROM user_session ".$whereString;
		return $this->fetch($sql);
	}
	
	public function updateSession($arr,$where){
		return $this->update('user_session',$arr, $where);
	}	
	
	public function insertSession($arr){
		return $this->insert('user_session',$arr);
	}
	
	public function deleteSession($arr){
		return $this->delete('user_session',$arr);
	}
}
?>