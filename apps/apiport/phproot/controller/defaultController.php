<?php
class defaultController extends ApiController
{

	public function actionIndex()
	{
		$news = array(
			array('id'=>1,'title'=>'new one'),
			array('id'=>2,'title'=>'new two'),
			array('id'=>3,'title'=>'new three'),
		);
		
		$data = array(
			'list' => $news,
			'length' => count($news)
		);
		$this->render('index',$data);
	}
	
}
?>