<?php
class queueDb implements iList {
	private $_urlResource =null;
	function init(){
		if(!$this->count()){
			$queue = urlQueue::model();
			$queue->truncate();
		}	
	}
	
	function isExist($where){
		$queue = urlQueue::model();
		if($queue->count($where) > 0){
			return true;
		}
		
		return false;
	}
	function updateUrlQueue($arr,$where){
		$queue = urlQueue::model();
		$queue->updateStatus($arr,$where);
	}
	
	function put($data){
		if(($qid = urlQueue::model()->add($data)) > 0)
			return true;
		
		return false;
	}
	
	function flush(){
		$data = urlQueue::model()->flush();
		if(!empty($data))
			return $data;
		
		return false;
	}

	function flush_new($arr){
		$data = urlQueue::model()->flush_new($arr);
		if(!empty($data))
			return $data;
		
		return false;		
	}
	
	function count(){
		return urlQueue::model()->count();
	}
	
	function remove($pos){
		if(urlQueue::model()->remove(array('qid' => $pos)))
			return true;
		
		return false;
	}
	function getUrlResourceDb(){

		if(!$this->_urlResource){
			$this->_urlResource = urlResouce::model()->buildTable();
		}
		return $this->_urlResource;
	}
}