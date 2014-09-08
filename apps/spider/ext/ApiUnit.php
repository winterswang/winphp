<?php
class apiUnit extends PHPUnit_Framework_TestCase{
	$kuaizuApi = new serverExt('ikuaizu_spider');
	public function testData_updateStoreLinks(){
		$data = array(
			'agent_url'=>'liyy20',
			'fail_count'=>1,
			'parse_status'=>2
			);
		$result = $kuaizuApi->api()->data_updateStoreLinks($data);
		print_r($result);
		$this->assertEquals('true',$result['result']);
	}
} 