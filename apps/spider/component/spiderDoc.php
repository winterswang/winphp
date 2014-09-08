<?php
class spiderDoc extends spiderCrawler{
	
	public $parser;
	public $resouce;
	
	function parser(){

		$classname = $this->getConfig('parser');
		if(!is_file(ROOT_PRO_PATH.DIRECTORY_SEPARATOR.'parser'.DIRECTORY_SEPARATOR.$classname.'.php')){
			throw new Exception('no parser found');	
		}
		
		include_once(ROOT_PRO_PATH.DIRECTORY_SEPARATOR.'parser'.DIRECTORY_SEPARATOR.$classname.'.php');
		$this->parser = new $classname();
		$this->parser->loadData($this->getHtmlResult());
		
		return $this->parser;
	}
	
	function getItems($keys){
		
		$items = array();
		
		if(!$this->parser()->check404()){
			$items = $this->parser()->getParseData($keys);//根据设定好的需求信息，循环获取，存入数组返回
		}

		return $items;
	}
	
	function spider($url,$time = ''){
		$this->resouce = array();
		urlResouce::model()->buildTable();
		$resouceInfo = urlResouce::model()->getInfo(array('url'=>$url));

		if(empty($resouceInfo)){
			$resouceInfo = array(
				'target' => $this->target,
				'url' => $url,
				'filepath' => '',
				'download' => 0,
				'status' => 0,
				'is_exist' =>1,
				'dateline' => $time ? $time : time()
			);
			
			$doc_id = urlResouce::model()->addResouce($resouceInfo);
			$resouceInfo['id'] = $doc_id;
		}
		
		if(!$resouceInfo['download']){//download = 0
			if($this->clawler($url) == false ){
				return false;
			}
			
			$attachment = $this->saveUrl($url);
			urlResouce::model()->updateResouce(array('download'=>1,'filepath'=>$attachment),array('id' =>$resouceInfo['id'] ));
		}else{

			if(!is_file(ROOT_PRO_PATH.'runtime'.DIRECTORY_SEPARATOR."html/".$resouceInfo['filepath'])){
				return false;
			}
	
			$data = file_get_contents(ROOT_PRO_PATH.'runtime'.DIRECTORY_SEPARATOR."html/".$resouceInfo['filepath']);
			$this->setHtmlResult($data);
		}

		$this->resouce = $resouceInfo;
		return true;
	}
	
	function saveUrl($url){
		$arr = pathinfo($url);
		
		$file = new FileManage('html');
		return $file->saveFile($this->target,$arr['filename'].'.html',$this->getHtmlResult());
	}
	
	function setSuccess($house_guid){
		urlResouce::model()->updateResouce(array('status' => 1,'house_guid'=>$house_guid),array('id' => $this->resouce['id']));
	}
	
	function setVoid(){
		urlResouce::model()->updateResouce(array('status' => 2),array('id' => $this->resouce['id']));
	}
	
	function clear(){
		$this->parser && $this->parser()->clear();
		$this->resouce = null;
	}

	function downLoadHtml($url){
		urlResouce::model()->buildTable();
		$resouceInfo = urlResouce::model()->getInfo(array('url'=>$url));

		if(empty($resouceInfo)){
			$resouceInfo = array(
				'target' => $this->target,
				'url' => $url,
				'filepath' => '',
				'download' => 0,
				'status' => 0,
				'dateline' => $time ? $time : time()
			);
			
			$doc_id = urlResouce::model()->addResouce($resouceInfo);
			$resouceInfo['id'] = $doc_id;
		}
		
		if(!$resouceInfo['download']){//download = 0
			if($this->clawler($url) == false ){
				return false;
			}
						
			$attachment = $this->saveUrl($url);
			urlResouce::model()->updateResouce(array('download'=>1,'filepath'=>$attachment),array('id' =>$resouceInfo['id'] ));
		}
		return $attachment;		
	}
}