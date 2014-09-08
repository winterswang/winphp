<?php
class collectController extends AppController
{
    public function actionAdd()
    {
        $this->setMeta('title','添加收藏');
        $this->render("collect_add", array());
    }
	
	public function actionStore() {
		$this -> setMeta('title','店铺收藏');
		$this -> render("collect_store");
	}

	public function actionHouse() {
		$data = array(
			'path' => Config::getConfig('system','attach_url')
		);
		$this -> setMeta('title','房源收藏');
		$this -> render("collect_house", $data);
	}
}
?>