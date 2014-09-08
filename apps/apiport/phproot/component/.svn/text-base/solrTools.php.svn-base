<?php
require_once(dirname(__FILE__) . '/../libraries/SolrPhpClient/Apache/Solr/Service.php');
class solrTools{
	public $solr;
	private static $_models = array();
	public static function model($className=__CLASS__)
	{
		if(isset(self::$_models[$className]))
			return self::$_models[$className];
		else
		{
			$model=self::$_models[$className]=new $className($host = 'localhost', $port = 8983, $path = '/solr/', $httpTransport = false);
			return $model;
		}
	}
	public function __construct($host = 'localhost', $port = 8983, $path = '/solr/', $httpTransport = false)
	{
		if(empty($this->solr)){
			$this->solr = new Apache_Solr_Service($host, $port, $path, $httpTransport);			
		}
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
	public function search($column,$value,$page_no =0,$page_size=10)
	{
		$result = $this->solr->search($column.':'.$value,$page_no, $page_size, null);
		$json_res = json_decode($result->getRawResponse(), true);
		return $json_res['response'];
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