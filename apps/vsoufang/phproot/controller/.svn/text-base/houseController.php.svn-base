<?php
session_start();
class houseController extends AppController
{
    public function actionInfo(){
        header( 'content-type: text/html; charset=utf-8' );
        $req = WinBase::app()->getRequest();
        $collect = $req -> getParam("collect","");
        $house_guid = htmlspecialchars(base64_decode($req->getParam("house_guid"))); 
        $house_info = htmlspecialchars(base64_decode(str_replace(' ','+',$req->getParam("house_info"))));
        //var_dump($house_info);exit;   
        $res = $this->api->house_info($house_guid);
        //echo "<pre>";
        //print_r($res);exit;
        if(is_array($res)) {
            if(isset($res['error'])){
                $this->showMessage($res['msg']);
            }
            if(count($res['housePhoto'])) {
                $houseImage = array_shift($res['housePhoto']);    //get house type images
                if(count($res['housePhoto'])) {
                    foreach ($res['housePhoto'] as $k => $v) {
                        $image_nav[] = preg_replace("/.jpg$/", "_small.jpg", $v['pic_url']);
                    }
                } else {
                    $image_nav  = array();
                }
            } else {
                $houseImage = array();
                $image_nav  = array();
            }
            
            $labelArr = explode(',', $res['label']);
            $data = array(
                'image_list' => $image_nav,
                'houseImage' => $houseImage,
                'house_info' => $house_info,
                'xuequ'      => $res['xuequ'],
                'link'       => $res,
                'collect'    => $collect,
            	'uuid'		 => $this -> uuid,
                'label'      => $labelArr,
            	'house_guid' => $house_guid,
                'path'       => Config::getConfig('system','attach_url')
            );
        }
        $this->setMeta('title','房源详情');
        $this->render("house_info",$data);
        //$this->render('common/contact',$data);
    }
}
?>