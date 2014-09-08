<?php
class housePhotoOld extends BaseDb
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
 public function buildWhere($where = array()){
 $whereArr = array();
 
 if(isset($where['uid']) && $where['uid']){
 $whereArr[] = " uid = '".$where['uid']."'";
 }
 
 if(isset($where['pid'])){
 $whereArr[] = " pid = '".$where['pid']."'";
 } 
 
 if(isset($where['pids']) && $where['pids']){
 $whereArr[] = " pid IN ('".join("','",$where['pids'])."')";
 } 
        
 if(isset($where['house_guid'])){
 $whereArr[] = " house_guid = '".$where['house_guid']."'";
 }
        
 if(isset($where['position']) && $where['position']){
 $whereArr[] = " position = '".$where['position']."'";
 }
 
 if(isset($where['is_delete'])){
 $whereArr[] = " is_delete = '".$where['is_delete']."'";
 } 
        
 if(isset($where['status']) && $where['status']){
 $whereArr[] = " status = '".$where['status']."'";
 }        
 
 return !empty($whereArr) ? ' WHERE '.join(' AND ',$whereArr ) : '';
 }
    
 public function getCount($where = array()){
 $sql = "SELECT count(pid) as count FROM house_photo_test ".$this->buildWhere($where);
 $row = $this->fetch($sql);
 return $row['count']; 
 }

 public function getInfoByPid($pid)
 { 
 $sql = "SELECT * FROM house_photo_test ".$this->buildWhere(array('pid' =>$pid ));
 return $this->fetch($sql);
 }
 
 public function getTopPhoto($guid){
 $sql = "SELECT * FROM house_photo_test ".$this->buildWhere(array('house_guid' =>$guid )) ." ORDER BY sort_order ASC LIMIT 1";
 return $this->fetch($sql);
 }
    
 public function getList($where = array(),$page_no = 1, $page_size = 12)
 {
        $sql = "select * from house_photo_test". $this->buildWhere($where) . ' ORDER BY sort_order ASC,dataline DESC' .$this->limit($page_no, $page_size);
        file_put_contents('/tmp/sqlError.log', $sql);
 return $this->fetch_all($sql);
 }
 
 public function getAll($where = array())
 {
        $sql = "select * from house_photo_test". $this->buildWhere($where) . ' ORDER BY sort_order ASC,dataline DESC';
 return $this->fetch_all($sql);
 }
    
    public function addPhoto($arr){
        return $this->insert('house_photo_test',$arr,true);
    }

 public function updatePhoto($arr,$where){
 return $this->update('house_photo_test',$arr, $where);
 }
 
 public function deleteImage(){
 
 }
    
}
?>