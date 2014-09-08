<?php
class picController extends AppController
{
	public function actionHouse() {
		$req = WinBase::app()->getRequest();
        $house_guid = htmlspecialchars(base64_decode($req->getParam("house_guid")));        
        $start_index = $req->getParam('start_index', 0);
        $res = $this->api->house_info($house_guid);

        if(isset($res['error'])){
            $this->showMessage($res['msg']);
        }
        $houseImage = array_shift($res['housePhoto']);    //get house type images
        $data = array(
            'image_list'  => $res['housePhoto'],
            'start_index' => $start_index,
            'path'        => Config::getConfig('system','attach_url')
        );
		$this->render('pic_show', $data);
	}
	
	public function actionShowUrl() {
		$req = WinBase::app()->getRequest();
		$pic = htmlspecialchars(base64_decode($req->getParam("pic")));
		//echo $pic;die;
		$data = array(
            'image_list'  => array(array('pic_url'=>$pic)),
            'start_index' => 0,
            'path'        => Config::getConfig('system','attach_url')
        );
		$this->render('pic_show', $data);  
	}
}
?>