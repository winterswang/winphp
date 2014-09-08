<?php
class bookController extends AppController {
   public function actionMine() {
        $this->setMeta('title','我的订阅');
        $this->render("book_mine", array());
		//file_put_contents("/tmp/cookie.txt", json_encode($_COOKIE));
    }
   
   public function actionAdd() {
   		$req = WinBase::app()->getRequest();
   	 	$school_name = $req->getParam("school_name",'学校');
   		$data = Config::getConfig("house");
		$data["school_name"] = $school_name;
		$this->setMeta('title','添加订阅');
        $this->render("book_add", $data);
   }
}
?>