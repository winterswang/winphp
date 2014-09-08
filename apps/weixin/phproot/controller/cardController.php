<?php
class cardController extends AppController {

	public function actionMine() {
        $this->setMeta('title','我的名片');
        $this->render("my_card");
    }

    public function actionEdit() {
        $this->setMeta('title','名片修改');
        $this->render("card_edit");
    }

    public function actionHouse() {
        $this->setMeta('title','发布房源');
        $this->render("house_publish");
    }

    public function actionRemove() {
        $this->setMeta('title','一键搬家');
        $this->render("remove_house");
    }
}
?>