<?php
class commentController extends AppController
{
    public function actionAdd(){
    	/*
        $req = WinBase::app()->getRequest();
        $house_guid = $req->getParam("house_guid");        
        $res = $this->api->house_info($house_guid);
        if(isset($res['error'])){
            $this->showMessage($res['msg']);
        }
		 */
        $this->render("comment_add");
    }
	
	public function actionDetail() {
		$this->render('comment_detail');
	}
}
?>