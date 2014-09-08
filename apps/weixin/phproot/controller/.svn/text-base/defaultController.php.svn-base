<?php
class defaultController extends WeixinController
{
    public function actionIndex($obj){} 
	//微信接收方对象
	
    // public function actionHelp($obj){
    //     $this->respond_text($this->getHelp());
    // }
    public function actionText($obj){

        $keyword = $obj->Content;
        
        if(empty($keyword)){
            $this->respond_text($this->getHelp());
        }
        
        $arrParams = array(
            'searchby' => 'keyword',
            'keyword' => $keyword
        );
	$res = $this->api->query_parse($arrParams);
	$type = $res[0]['type'];
		$top_item = array();
		switch ($res[0]['type']) {
			case 1:
				$arrParams['keyword'] = $res[0]['value'];
				$res = $this->api->search_district($arrParams,1,4);
				$top_item['title'] = $res['top']['district_name'];
				$top_item['picurl'] = 'http://api.ikuaizu.com/data/attachment/'.$res['top']['photo'];
				$top_item['url'] = 'http://wx.ikuaizu.com/district/detail?uuid='.$obj->FromUserName."&district_guid=".base64_encode($res['top']['district_guid']);
				break;
			case 2:
			    $arrParams['school_name'] = $res[0]['value'];
				$res = $this->api->search_xuequ($arrParams,1,4);
				$top_item['title'] = $res['top']['school_name'];
				$top_item['picurl'] = 'http://api.ikuaizu.com/data/attachment/'.$res['top']['school_photo'];
				$top_item['url'] = 'http://wx.ikuaizu.com/school/intro?uuid='.$obj->FromUserName."&xuequ_guid=".base64_encode($res['top']['xuequ_guid']);
				break;
			default:
				$this->respond_text("暂时未找到相应的房源\r\n"); 
				break;
		}
		
		$news = array($top_item);
		foreach ($res['house'] as $key){
			$item = array();
	        $item['title'] = $key['title']."\n".$key['room'].'室 '.$key['hall'].'厅 '.$key['square'].'平米 '.$key['sell_price'].'万 ';
	        if($key['photo']) {
	        	$item['picurl'] = 'http://api.ikuaizu.com/data/attachment/'.$key['photo'];
	        } else {
	        	$item['picurl'] = 'http://wx.ikuaizu.com/img/district/default_pic.png';
	        }
	        
	        $item['url'] = 'http://wx.ikuaizu.com/house/info?uuid='.$obj->FromUserName.'&house_guid='.base64_encode($key['house_guid']).'&house_info='.base64_encode(json_encode($key));
	        $news[] = $item; 
	 	       
			if(count($news) > 3){
	        	switch ($type) {
	        		case 1:
			    		$news[] = array(
			        	'title' => '查看更多',
			        	'picurl'=> 'http://wx.ikuaizu.com/img/more2.png',
			        	'url'=> 'http://wx.ikuaizu.com/district/house?uuid='.$obj->FromUserName."&district_guid=".base64_encode($res['top']['district_guid'])."&house_count=".$res['top']['house_count']
			    		);
			    		break;
			    	case 2:
			    		$news[] = array(
			        	'title' => '查看更多',
			        	'picurl'=> 'http://wx.ikuaizu.com/img/more2.png',
			        	'url'=> 'http://wx.ikuaizu.com/school/house?uuid='.$obj->FromUserName."&xuequ_guid=".base64_encode($res['top']['xuequ_guid'])."&house_count=".$res['top']['house_count']
			    		);
			    		break;
			    	default:
			    		$this->respond_text("暂未找到其它的房源\r\n");
			    		break;
			    }
			    break;		
			}
		}
        $this->respond_news($news);
    }

    public function actionVideo($obj){
    	$mediaId = $obj->MediaId;
    	$thumbMediaId = $obj->ThumbMediaId;
    	$this->respond_video(array('MediaId'=>$mediaId,'ThumbMediaId'=>$thumbMediaId));
    }

    public function actionNavigation($obj){
    	$eventKey = $obj->EventKey;
    	switch($eventKey){
 			case 'MYCARD':
 				$data =array('agentOpenId'=>$obj->FromUserName);
 				$res = $this->api->upload_image($data);
 				if($res['result'] == 'ok'){
 					if($res['mediaId'] !=''){
 						$this->respond_image(array('MediaId'=>$res['mediaId'])); 						
 					}else{
 						$news = "您还没有设定店铺地址，请输入店铺地址\r\n";
 						$this->respond_text($news);
 						//$this->respond_text("MediaId is null");
 					}
 				}
 				else{
 					$this->respond_text($res['result']);
 				}
 				break;
 			case 'MYAGENT':
 				$data =array('clientOpenId'=>$obj->FromUserName); 
 				$res = $this->api->get_client_agent($data);
 				if($res['result'] == 'ok'){
 					if($res['length']>0){
	  					$news = '';
	 					foreach ($res['data'] as $key => $value) {
								$news .="经纪人： ".$value['agent_name']."\n电话：<a href='tel:".$value['agent_tel']."'>".$value['agent_tel']."</a>\n";
								$news .="店铺地址： <a href='".$value['store_url']."'>猛戳我</a>\n";
								$news .="\n";
	 					}
	 					$this->respond_text($news); 						
 					}
					else{
						$news = "你暂时没有关注经纪人，想关注经纪人，请关注爱居经纪人公共帐号";
						$this->respond_text($news); 
					}						
 				}else{
 					$this->respond_text($res['result']);
 				}
 				break;
 			case 'MYHOUSE':
 				$data =array('agentOpenId'=>$obj->FromUserName);
 				$res =  $this->api->get_my_store_url($data);
 				if($res['result']=='ok'){
 					if(!empty($res['store_url'])){
	 					$news = "店铺地址：<a href='".$res['store_url']."'>猛戳我</a>";
	 					$this->respond_text($news); 						
 					}else{
 						if($res['is_exist'] == 0){
	  						$news = "您没有注册，请点击<a href='http://wx.ikuaizu.com/mreg/reg?openId=".$obj->FromUserName."'>链接注册</a>";
	 						$this->respond_text($news); 							
 						}
 						else{
 							$news = "您还没有设定店铺地址，请输入店铺地址\r\n";
 							$this->respond_text($news);
 						}
 					}
 				}else{
 					$this->respond_text($res['result']); 	
 				}
 				break;
 			// case 'MYIMAGE':
 			// 	$data =array('agentOpenId'=>$obj->FromUserName);
 			// 	$res = $this->api->upload_image($data);
 			// 	if($res['result'] == 'ok'){
 			// 		if($res['mediaId'] !=''){
 			// 			$this->respond_image(array('MediaId'=>$res['mediaId'])); 						
 			// 		}else{
 			// 			$this->respond_text("MediaId is null");
 			// 		}
 			// 	}
 			// 	else{
 			// 		$this->respond_text($res['result']);
 			// 	}
 			// 	break;
    	}
    }
    public function actionSubscribe($obj)
    {
    	$this->welcome($obj);
    	$qrNum = substr($obj->EventKey,strlen($obj->EventKey)-1,strlen($obj->EventKey));
    	$data = array('openId'=>$obj->FromUserName,'qrnum'=>$qrNum);
    	$res = $this->api->add_agent_client($data);
		if($res['result'] == 'ok')
		{
    		$this->respond_text("welcome");
    	}else{
    		$this->respond_text($res['result']);
    	}
    }
    public function actionUnsubscribe($obj){
        $this->respond_text("sorry");	
    }

    public function actionScan($obj){
    	$data = array('openId'=>$obj->FromUserName,'qrnum'=>$obj->EventKey);	
    	$res =  $this->api->add_agent_client($data);  
		if($res['result'] == 'ok')
		{
    		$this->respond_text("welcome");
    	}else{
    		$this->respond_text($res['result']);
    	}
    }
    private function addAgentClient($boj){
    	$qrNum = substr($obj->EventKey,strlen($obj->EventKey)-1,strlen($obj->EventKey));
    	$data = array('openId'=>$obj->FromUserName,'qrnum'=>$qrNum);	
    	return  $this->api->add_agent_client($data);  	
    }
    private function welcome($obj){
    	if($obj->EventKey == null && $obj->ToUserName ==Config::getConfig('weixin','vsf')){
    		$this->respond_text($this->getHelp('vsf'));exit();
    	}
    	if($obj->EventKey == null && $obj->ToUserName ==Config::getConfig('weixin','agent')){
    		$this->respond_text($this->getHelp('agent'));exit();
    	}
    	if($obj->EventKey == null && $obj->ToUserName ==Config::getConfig('weixin','test')){
    		$this->respond_text($this->getHelp('test'));exit();
    	}
    }
}