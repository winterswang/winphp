<?php
class testController extends ApiController {
	 public function actionIndex(){

	 }
	 //接口测试方法
	 public function actionTest(){

	 	$req = WinBase::app()->getRequest();

	 	$spider = $req->getParam('spider','');

	 	$this->response(array('test'=>$spider));
	 }
}