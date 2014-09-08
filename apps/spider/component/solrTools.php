<?php
require_once(dirname(__FILE__) . '/../libraries/SolrPhpClient/Apache/Solr/Service.php');
class solrTools extends commonTools{
	public $solr;
	public function __construct($host = 'localhost', $port = 8983, $path = '/solr/', $httpTransport = false)
	{
		$this->solr = new Apache_Solr_Service($host, $port, $path, $httpTransport);

	}
	public function add($documents,$is_commit =false)
	{
		if(count($documents) >1){
  			$this->solr->addDocuments($documents,$is_commit); 			
		}
		else{
			$this->solr->addDocument($documents,$is_commit); 
		}

	}
	public function search($column,$value)
	{
		$result = $this->solr->search("keyword:测试", 0, 10, null);
		$json_res = json_decode($result->getRawResponse(), true);
		print_r($json_res['response']);
	}
	public function delete($column,$value){
		$this->solr->deleteByQuery($column.':'.$value);
	}
	public function commit(){
		$this->solr->commit();
	}
	public function addDocuments($data =array()){
		$docs = array();	
		foreach ($data as $key => $value) {
			$doc = new Apache_Solr_Document();
			$doc = $this->addDocument($value);	
			$docs[]=$doc;		
		}
		return  $docs;
	}
	public function addDocument($data = array()){
		$doc = new Apache_Solr_Document();
		foreach ($data as $key => $value) {
			$doc->addField($key,$value);
		}
		return $doc;
	}
}