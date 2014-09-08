<?php
class agentController extends ApiController {

	function actionInfo(){
		$req = WinBase::app()->getRequest();
		$agent_guid  = $req->getParam('agent_guid',0);
		$data = array();
		if($agent_guid >999999999){
			$info = agent::model()->getInfo(array('agent_guid'=>$agent_guid));
			if(!empty($info)){
				$data['top']['agent_name'] = $info['agent_name'];
				$data['top']['agent_guid'] = $info['agent_guid'];
				$data['top']['agent_tel'] = $info['telephone'];
				$data['top']['agent_company'] = $info['company'];
				$data['top']['agent_district'] =$info['agent_district'];
				$data['top']['agent_xuequ'] = $info['agent_xuequ'];
				$data['top']['agent_photo'] = $info['agent_photo'];	
			}
		}
		$this->response($data);
	}
	function actionHouseList(){
		$req = WinBase::app()->getRequest();
		$agent_guid = $req->getParam('agent_guid',0);
        $page_no = $req->getParam('page_no',1);
        $page_size = $req->getParam('page_size',10);
		$data = array('houseList' =>array());
		if($agent_guid >999999999){
			$info = agent::model()->getInfo(array('agent_guid'=>$agent_guid));
			if(!empty($info)){
				$data['top']['agent_name'] = $info['agent_name'];
				$data['top']['agent_guid'] = $info['agent_guid'];
				$data['top']['agent_tel'] = $info['telephone'];
				$data['top']['agent_company'] = $info['company'];
				$data['top']['agent_district'] =$info['agent_district'];
				$data['top']['agent_xuequ'] = $info['agent_xuequ'];
				$data['top']['agent_photo'] = $info['agent_photo'];	
				if($info['company'] == 'homelink'){
					$houseList = house_new::model()->getList(array('onsell_agents'=>$info['agent_url'],'is_onsell'=>1),$page_no,$page_size);
				}else{
					$houseList = house_new::model()->getList(array('agent_url'=>$info['agent_url'],'is_onsell'=>1),$page_no,$page_size);					
				}		
				foreach ($houseList as $key) {
					$photo =  housePhoto::model()->getTopPhoto($key['house_guid']);
					$key['photo'] = $photo['pic_url'];
					$data['houseList'][] =$key;
				}
			}
		}
		$this->response($data);
	}
	function actionImportStoreUrl(){
		$req = WinBase::app()->getRequest();
		$url = $req->getParam('url','');
		$agent_url = $req->getParam('agent_url','');
		if (empty($url)) {
			$this->response(array('result'=>'url is empty'));			
		}
		$target =commonTools::model()->getTransTarget($url);
		$config = Config::getConfig('transStore_config',$target); 
		///////向store_links数据库插入一条记录	
		$data = array(
			'agent_url'=>$agent_url,
			'url' =>$url,
			'analyze_status' =>'1',
			);
	}
	function actionAddAgentWx(){
		$req = WinBase::app()->getRequest();
		$tel = $req->getParam('telephone',0);
		$openId = $req->getParam('openId','');
		if(empty($tel) || empty($openId)){
			$this->response(array('result'=>'miss telephone or openId'));
		}
		if(agentWx::model()->getCount(array('agent_tel'=>$tel)) >0){
			$this->response(array('result'=>'the telephone has already been enrolled'));
		}
		$agentName = $req->getParam('agentName','');
		$agentWxId = $req->getParam('agentWxId','');
		$storeUrl = $req->getParam('storeUrl','');
		$company = $req->getParam('company','');
		$storeName = $req->getParam('storeName','');
		$position = $req->getParam('position','');
		$business = $req->getParam('business','');

		$url = qr_image::model()->getUnDistributedQR($openId);
		if(empty($url)){
			$this->response(array('result'=>'没有可分配的二维码,添加失败'));
		}
		
		$card = $this->getAgentCard($url,array($agentName,$tel,$company." ".$storeName,$position,$agentWxId,$business));
		if(empty($card)){
			$this->response(array('result'=>'make agent card failed'));
		}

		$data =array(
			'open_id'=>$openId,
			'agent_name'=>$agentName,
			'agent_tel'=>$tel,
			'store_url'=>$storeUrl,
			'agent_wx_id'=>$agentWxId,
			'qr_url' =>$url,
			'card_url' =>$card,
			'head_url' =>'',
			'company' =>$company,
			'store_name' =>$storeName,
			'position' =>$position,
			'business' =>$business
			);

		$userInfo = $this->getUserInfo($openId);
		if($userInfo->nickname !=null){
			$data['wx_nickname'] = $userInfo->nickname;
		}
		if($userInfo->headimgurl !=null){
			$data['head_url'] = $userInfo->headimgurl;
		}

		agentWx::model()->addAgent($data);
		$this->response(array('result'=>'ok','card_url' =>$card));
			
	}
	function actionGetAgentWx(){
		$req = WinBase::app()->getRequest();
		$tel = $req->getParam('telephone',0);//电话查询
		$openId = $req->getParam('openId','');//openID查询
		$agentName = $req->getParam('agentName','');//经纪人姓名查询
		$info =agentWx::model()->getInfo(array('agent_tel'=>$tel,'open_id'=>$openId,'agent_name'=>$agentName));
		if(empty($info)){
			$info = '';
		}
		$data =array(
			'data'=>$info
			);
		$this->response($data);
	}
	function actionAddAgentClient(){//添加经纪人的顾客
		$req = WinBase::app()->getRequest();
		$clientOpenId = $req->getParam('openId','');
		$qrNum = $req->getParam('qrnum',0);
		if(empty($clientOpenId) || empty($qrNum)){
			$this->response(array('result'=>'miss openid or qrnum'.$clientOpenId.$qrNum));exit();
		}
		$info= qr_image::model()->getInfoByid($qrNum);
		if(empty($info) || empty($info['agent_open_id'])){
			$this->response(array('result'=>'no agent_open_id find in qr_image'));
		}
		if(agentClient::model()->isExist($clientOpenId,$info['agent_open_id'])){
			$this->response(array('result'=>'ok'));exit();
		}
		$data = array(
			'client_open_id' =>$clientOpenId,
			'agent_open_id' =>$info['agent_open_id'],
			'createtime' =>TIMESTAMP
			);
		agentClient::model()->addAgentClient($data);
		$agent = agentWx::model()->getInfo(array('open_id'=>$info['agent_open_id']));
		$this->response(array('result'=>'ok','url'=>$agent['store_url']));
	}
	function actionGetClientAgent(){
		$req = WinBase::app()->getRequest();
		$clientOpenId = $req->getParam('clientOpenId','');
		if(empty($clientOpenId)){
			$this->response(array('result'=>'miss client_open_id'));
		}
		//经纪人 ==客户  对应表
		$list = agentClient::model()->getList(array('client_open_id'=>$clientOpenId));
		if(empty($list) || count($list) ==0){
			$this->response(array('result'=>'no agent find'));
		}
		$length = agentClient::model()->getCount(array('client_open_id'=>$clientOpenId));
		if($length == null){
			$length = 0;
		}
		$data = array(
			'result' => 'ok',
			'length' =>$length,
			'data' =>array()
			);
		//经纪人的openID 查找经纪人表
		foreach ($list as $key => $value) {
			$data['data'][] = agentWx::model()->getInfo(array('open_id'=>$value['agent_open_id']));
		}
		$this->response($data);
	}
	function actionGetMyStoreUrl(){
		$req = WinBase::app()->getRequest();
		$agentOpenId = $req->getParam('agentOpenId','');
		if(empty($agentOpenId)){
			$this->response(array('result'=>'miss agent_open_id'));
		}
		$agent = agentWx::model()->getInfo(array('open_id'=>$agentOpenId));

		if(empty($agent)){
			$this->response(array('result'=>'ok','store_url'=>'','is_exist'=>0));
		}

		if(empty($agent['store_url'])){
				$this->response(array('result'=>'ok','store_url'=>'','is_exist'=>1));
		}

		$this->response(array('result'=>'ok','store_url'=>$agent['store_url'],'is_exist'=>1));		
	}
	function actionUploadImage(){
		$req = WinBase::app()->getRequest();
		$agentOpenId = $req->getParam('agentOpenId','');
		if(empty($agentOpenId)){
			$this->response(array('result'=>'miss agent_open_id'));
		}
		$agent = agentWx::model()->getInfo(array('open_id'=>$agentOpenId));
		if(empty($agent)){
			$this->response(array('result'=>'can not find agent'));
		}
		$res = $this->uploadImage($agent['card_url']);
		if(!isset($res->errcode)){
			$this->response(array('result'=>'ok','mediaId'=>$res->media_id));
		}else{
			$this->response(array('result'=>$res->errmsg));
		}				
	}
	function actionGetStoreByTel(){
		$req = WinBase::app()->getRequest();
		$tel = $req->getParam('telephone',0);
		if(empty($tel)){
			$this->response(array('result'=>'miss telephone num'));
		}

		$info = agentSpider::model()->getInfo(array('tel'=>$tel));
		if(empty($info) || empty($info['soufun_id'])){
			$this->response(array('result'=>'can not find storeUrl'));
		}

		$this->response(array('result'=>'ok','storeUrl'=>"http://m.soufun.com/shopinfo.d?m=shopinfo&city=bj&agentid=".$info['soufun_id']));	
	} 
	private function uploadImage($card_url){
		$systemSetting = Config::getConfig('system');
		$appid = $systemSetting['aijujingjiren']['appid'];
		$secret=$systemSetting['aijujingjiren']['secret'];
		$token = WxApiTools::model()->getAccessToken($appid,$secret);
		$data = array('img'=>'@/data/wwwroot/ikuaizu/apps/apiport/wwwroot/data/attachment/'.$card_url);
		return WxApiTools::model()->upLoadImage($data,$token);

	}
	private function getAgentCard($url,$markText=array()){
		$agentSetting = Config::getConfig('agentCard');
		$imgSrc = $agentSetting['imgSrc'];
		$fontType = $agentSetting['fontType'];

        $markImg = array('/data/wwwroot/ikuaizu/apps/apiport/wwwroot/data/attachment/'.$url); 
        //$markText = array('林海','13586549458','链家地产 中关村门店','豪宅部经理','微信号：林海小叮当','微搜房认证：中关村学区专家');  //test case
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
        		//echo "is img\r\n";
            if(!file_exists($markImg[0]) || empty($markImg[0])) {
            	//echo "img is empty\r\n";
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
               
            $logow_img = ceil($markImg_w * 0.8);
            $logoh_img = ceil($markImg_h * 0.8);
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
        }
           
        $dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);
           
        imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);   //重点，此处可以make thumb
           
        if(in_array("img", $markType)) {
            imagecopyresampled($dst_img,$markim,100,560,0,0,$logow_img,$logoh_img,$markImg_w,$markImg_h);
            //imagecopy($dst_img, $markim, $x, $y, 0, 0, $logow, $logoh);
            imagedestroy($markim);
        }
       //file_put_contents('/tmp/card_url.log', '');    
        if(in_array("text", $markType)) {
            //$rgb = explode(',', $TextColor);
               
            $color1 = imagecolorallocate($dst_img, 255, 255, 255);
            $color2 = imagecolorallocate($dst_img, 100, 100, 100);
            imagettftext($dst_img, 24, 0, 200, 217, $color1, $fontType,$markText[0]);
            imagettftext($dst_img, 24, 0, 100, 317, $color2, $fontType,$markText[1]);
            imagettftext($dst_img, 14, 0, 100, 392, $color2, $fontType,$markText[2]);
            imagettftext($dst_img, 14, 0, 100, 440, $color2, $fontType,$markText[3]);
            imagettftext($dst_img, 14, 0, 100, 488, $color2, $fontType,$markText[4]);
            imagettftext($dst_img, 14, 0, 100, 538, $color2, $fontType,$markText[5]);
        }
		$attach_url = "/data/wwwroot/ikuaizu/apps/apiport/wwwroot/data/attachment";
        $filename = "/test/agentcard/".date('YmdHis').rand(1000,9999). '.jpg';
        $url = $attach_url.$filename;
        switch ($srcInfo[2]) {
            case 1:
                imagegif($dst_img, $url);
                break;
            case 2:
                imagejpeg($dst_img, $url);
                break;
            case 3:
                imagepng($dst_img, $url);
                break;
            default:
                die("不支持的水印图片文件类型");
                exit;
        }
           
        imagedestroy($dst_img);
        imagedestroy($srcim);
        return $filename;	
	}
	private function getUserInfo($openId)
	{
		$systemSetting = Config::getConfig('system');
		$appid = $systemSetting['aijujingjiren']['appid'];
		$secret=$systemSetting['aijujingjiren']['secret'];

		$token = WxApiTools::model()->getAccessToken($appid,$secret);
		$res = json_decode(WxApiTools::model()->getUserInfo($openId,$token));

		if(isset($res->errcode)){
			  return $res->errmsg;
		}
		return $res;
	}
}