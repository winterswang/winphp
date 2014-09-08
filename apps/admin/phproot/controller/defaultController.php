<?php
class defaultController extends AdminController
{
	
    public function actionIndex() {
		$this->render("passport_login");
	}
}
?>