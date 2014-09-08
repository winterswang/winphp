<?php
class manageController extends AppController {
    public function actionIntro() {
        $req = WinBase::app()->getRequest();
        $collect = $req -> getParam('collect','');
        $agent_guid = htmlspecialchars(base64_decode($req->getParam("agent_guid")));  
        $res = $this->api->agent_info($agent_guid);
        //echo "<pre>";
        //print_r($res);exit;
        if(is_array($res)) {
            if(isset($res['error'])){
                $this->showMessage($res['msg']);
            }
            $data = array(
                'link'       => $res['top'],
                'path'       => Config::getConfig('system','attach_url'),
                'uuid'		 => $this -> uuid,
            	'agent_guid' => $agent_guid,
                'collect'    => $collect,
            	'store_info' => json_encode($res['top'])
            );
            $this->setMeta('title','经纪人详情');
        	$this->render("manager_introduce",$data);
        }
    }

    public function actionHouse() {
    	$req = WinBase::app()->getRequest();
        $collect = $req -> getParam('collect','');
        $agent_guid = htmlspecialchars(base64_decode($req->getParam("agent_guid")));  
        $res = $this->api->agent_info($agent_guid);
        //echo "<pre>";
        //print_r($res);exit;
        if(is_array($res)) {
            if(isset($res['error'])){
                $this->showMessage($res['msg']);
            }
            $data = array(
                'link'       => $res['top'],
                'path'       => Config::getConfig('system','attach_url'),
                'uuid'		 => $this -> uuid,
            	'agent_guid' => $agent_guid,
            	'store_info' => json_encode($res['top'])
            );
            $this->setMeta('title','店铺房源');
        	$this->render("manage_house",$data);
        } 
    }

    /*
    public function actionHouse() {
        $req = WinBase::app()->getRequest();
        $agent_guid = htmlspecialchars(base64_decode($req->getParam("agent_guid")));
        $data = array(
            'agent_guid'    => $agent_guid,
            'uuid'          => $this -> uuid
        );
        $this -> setMeta('title', '店铺房源');
        $this -> render('manage_house', $data);
    }
    */    

    public function actionMoreHouse() {
        $req = WinBase::app()->getRequest();
        if ($req->isAjaxRequest()) {
            $page = $req->getParam('page_no',1);
            $pageSize = $req->getParam('page_size',7);
            $data = array();
            $agent_guid = $req->getParam("agent_guid",'');
            //学区名
            $data['agent_guid'] = $agent_guid;
            $res = $this -> api -> agent_house($data, $page, $pageSize);
            //echo "<pre>";
            //print_r($res);exit;
            echo json_encode(array('list'=>$res['houseList']));
            exit;
        }
    }

    public function actionReg() {
        $this->setMeta('title','注册');
        $this->render("manage_reg");
    }

    public function actionBscard() {
        $imgSrc = './img/test.jpg';
        $markImg = array('./img/qr4.jpg');
        $markText = array('林海','13586549458','链家地产 中关村门店','豪宅部经理','微信号：林海小叮当','微搜房认证：中关村学区专家');  //test case
        $fontType = './img/msyhbd.ttf';
        $markType = array('text','img');
        $srcInfo = @getimagesize($imgSrc);
        $srcImg_w    = $srcInfo[0];
        $srcImg_h    = $srcInfo[1];
           
        switch ($srcInfo[2]) {
            case 1:
                $srcim =imagecreatefromgif($imgSrc);
                break;
            case 2:
                $srcim =imagecreatefromjpeg($imgSrc);
                break;
            case 3:
                $srcim =imagecreatefrompng($imgSrc);
                break;
            default:
                die("不支持的图片文件类型");
                exit;
        }
           
        if(in_array("img", $markType)) {
            if(!file_exists($markImg[0]) || empty($markImg[0])) {
                return;
            }
               
            $markImgInfo = @getimagesize($markImg[0]);
            $markImg_w    = $markImgInfo[0];
            $markImg_h    = $markImgInfo[1];
               
            if($srcImg_w < $markImg_w || $srcImg_h < $markImg_h) {
                return;
            }
               
            switch ($markImgInfo[2]) {
                case 1:
                    $markim =imagecreatefromgif($markImg[0]);
                    break;
                case 2:
                    $markim =imagecreatefromjpeg($markImg[0]);
                    break;
                case 3:
                    $markim =imagecreatefrompng($markImg[0]);
                    break;
                default:
                    die("不支持的水印图片文件类型");
                    exit;
            }
               
            $logow_img = ceil($markImg_w * 0.61);
            $logoh_img = ceil($markImg_h * 0.61);
        }
           
        if(in_array("text", $markType)) {
            //$fontSize = $fontsize;
            if(!empty($markText)) {
                if(!file_exists($fontType)) {
                    return;
                }
            } else {
                return;
            }
               
            //$box = @imagettfbbox($fontSize, 0, $fontType,$markText);
            //$logow_text = max($box[2], $box[4]) - min($box[0], $box[6]);
            //$logoh_text = max($box[1], $box[3]) - min($box[5], $box[7]);
        }
           
        $dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);
           
        imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);   //重点，此处可以make thumb
           
        if(in_array("img", $markType)) {
            imagecopyresampled($dst_img,$markim,140,575,0,0,$logow_img,$logoh_img,$markImg_w,$markImg_h);
            //imagecopy($dst_img, $markim, $x, $y, 0, 0, $logow, $logoh);
            imagedestroy($markim);
        }
           
        if(in_array("text", $markType)) {
            //$rgb = explode(',', $TextColor);
               
            $color1 = imagecolorallocate($dst_img, 255, 255, 255);
            $color2 = imagecolorallocate($dst_img, 100, 100, 100);
            imagettftext($dst_img, 24, 0, 235, 217, $color1, $fontType,$markText[0]);
            imagettftext($dst_img, 24, 0, 100, 317, $color2, $fontType,$markText[1]);
            imagettftext($dst_img, 14, 0, 100, 392, $color2, $fontType,$markText[2]);
            imagettftext($dst_img, 14, 0, 100, 440, $color2, $fontType,$markText[3]);
            imagettftext($dst_img, 14, 0, 100, 488, $color2, $fontType,$markText[4]);
            imagettftext($dst_img, 14, 0, 100, 538, $color2, $fontType,$markText[5]);
        }

        $filename = date('YmdHis').rand(1000,9999). '.jpg';
        
        switch ($srcInfo[2]) {
            case 1:
                imagegif($dst_img, $filename);
                break;
            case 2:
                imagejpeg($dst_img, $filename);
                break;
            case 3:
                imagepng($dst_img, $filename);
                break;
            default:
                die("不支持的水印图片文件类型");
                exit;
        }
           
        imagedestroy($dst_img);
        imagedestroy($srcim);
    }


    public function actionCheckaddress() {
        $req = WinBase::app()->getRequest();
        if ($req->isAjaxRequest()) {
            $telephone = $req->getParam('telephone', '');
            $data = array('telephone' => $telephone);
            $res = $this -> api -> getStoreUrl($data);
            //echo "<pre>";
            //print_r($res);exit;
            echo json_encode($res);
            exit;
        }
    }

}
?>