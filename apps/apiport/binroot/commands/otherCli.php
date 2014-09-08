<?php
class otherCli extends BaseCli{

	function actionIndex($method){
		$data = "目标执行时间：".date("Y-m-d H:i:s")."\r\n";
		file_put_contents('/tmp/cli.log', $data,FILE_APPEND);
		if(method_exists($this,$method)){
			$this->$method();
		}
	}

	function agentImageCut(){

			$info = agent::model()->getInfo(array('id'=>66));
			if(!empty($info['agent_photo'])){
				$arr = pathinfo($info['agent_photo']);
				$new_file = 'tmp/lin.jpg';
				$this->imageCut($info['agent_photo'],$new_file,120,120);
			}

	}

	function houseImageCut(){
		$count = 714406;
		do {
			$info = housePhoto::model()->getInfo(array('id'=>$count));
			if(!empty($info['pic_url'])){
				echo "count:".$count;
				$arr = pathinfo($info['pic_url']);
				$new_file = $arr['dirname'].'/'.$arr['filename'].'_small.'.$arr['extension'];
				$this->imageCut($info['pic_url'],$new_file);
			}
		} while ($count--);
	}		
	


	function importDataByFile(){
		$f='keyvale.txt';
		$file_info=file($f);
		$num = count($file_info);
		while ($num--) {
			$file_array = explode("	",$file_info[$num]);
			//print_r($file_array);
			$key = $file_array[0];
			$value = $file_array[1];
			$type = $file_array[2];
			$info = keyMap::model()->getInfo(array('keyword'=>$key,'value'=>$value,'type'=>$type));
			if($info['value']){
				echo "data is exist\r\n";
			}else{
				$res = keyMap_dev::model()->addKeyMap(array('keyword'=>$key,'value'=>$value,'type'=>$type));
				if($res){
					echo $key."  ".$value."  ".$type."import success\r\n";				
				}
				else{
					echo $key."  ".$value."  ".$type."import false\r\n";	
				}				
			}
		}

	}
	function updateDistrictHouseCount(){
		$maxGuid = district::model()->getMaxDistrictGuid();		
		while ($maxGuid-- && $maxGuid >1000000000) {
			$info = district::model()->getInfo(array('district_guid'=>$maxGuid));
			if($info['district_id']){
				$count = house_new::model()->getCount(array('district_id'=>$info['district_id'],'is_onSell' =>1));

				if(district::model()->updateDistrict(array('house_count'=>$count),array('district_guid'=>$maxGuid)))
				{
					echo $count."update house count success\r\n";
				}
				else
				{
					echo $count."update house count failed\r\n";	
				}
			}			
		}
	}

	function updateXuequHouseCount(){
			$maxId = xuequ::model()->getCount();
			while ($maxId--) {
				$info = xuequ::model()->getInfo(array('id'=>$maxId));
				if(!empty($info['xuequ_id'])){
					$list = xuequ_district::model()->getList(array('xuequ_id'=>$info['xuequ_id']));
					$houseCount = 0;
					foreach ($list as $key) {
						$district = district::model()->getInfo(array('district_id'=>$key['district_id']));
						$houseCount += $district['house_count'];
					}
					if(xuequ::model()->updateXuequ(array('house_count'=>$houseCount),array('id'=>$maxId))){
						echo $houseCount."update house count success\r\n";
					}
					else{
						echo $houseCount."update house count failed\r\n";	
					}
				}
			}			
	}

	function updateDistrictHousePrice(){
		$maxId = district::model()->getCount();
		do {
			$info = district::model()->getInfo(array('id'=>$maxId));
			$price = 0;
			$square = 0;
			if(!empty($info)){
				$houseList = house_new::model()->getList(array('district_id'=>$info['district_id']));
				if(count($houseList)>0){
					foreach ($houseList as $key => $value) 
					{
						if($value['is_onsell'] ==1 && $value['sell_price']>0 && $value['square']>0)
						{
							$price+=$value['sell_price']*10000;//万单位转元
							$square+=$value['square'];								
						}					
					}			
					if($square>0){
						$price = $price/$square;
					}
					//$info['house_price']=$price;			
					if(district::model()->updateDistrict(array('house_price'=>$price),array('id'=>$maxId))){
						echo "update district house price  success district_id:".$info['district_id']."\r\n";
					}
					else{
						echo "update district house price failed district_id:".$info['district_id']."\r\n";
					}					
				}
			}
		} while ($maxId--);
	}
	function updateXuequHousePrice(){

		$maxId = xuequ::model()->getCount();
		while ($maxId--) {
			$info = xuequ::model()->getInfo(array('id'=>$maxId));
			if(!empty($info['xuequ_id'])){
				$list = xuequ_district::model()->getList(array('xuequ_id'=>$info['xuequ_id']));
				$houseCount = 0;
				$housePrice = 0;
				foreach ($list as $key) {
					$district = district::model()->getInfo(array('district_id'=>$key['district_id']));
					if($district['house_count']>0 && $district['house_price']>0){
						$houseCount += $district['house_count'];
						$housePrice += $district['house_price']*$district['house_count'];						
					}
				}
				if($houseCount>0){
					$housePrice = round($housePrice/$houseCount);					
				}
				if(xuequ::model()->updateXuequ(array('house_price'=>$housePrice),array('id'=>$maxId))){
					echo $info['xuequ_id']." update xuequ house mm_price success\r\n";
				}
				else{
					echo $info['xuequ_id']." update xuequ house mm_price failed\r\n";	
				}
			}
		}	
	}

	function mergeDistricts(){
		$targets = array('district_5i5j');
		foreach ($targets as $key => $value) {
			$this->updateDistrictHouseData($value);			
		}		
	}

	function updateXuequDistrictData(){
		$count = xuequ_district::model()->getCount();
		$maxId = xuequ_district::model()->getMaxXuequ_districtId();
		do {
			$info = xuequ_district::model()->getInfo(array('id'=>$maxId));
			if(empty($info['district_guid'])){
				$districtInfo = district::model()->getInfo(array('district_id'=>$info['district_id']));
				if(!empty($districtInfo['district_guid'])){
					if(xuequ_district::model()->updateXuequ_district(array('district_guid'=>$districtInfo['district_guid']),array('id'=>$maxId)))
					{
						echo $info['district_name']."update success\r\n";
					}
				}
			}
		} while ($maxId-- && $count--);
	}
	private function updateDistrictHouseData($target){
		$sameCount = 0;
		$diffCount = 0;
		$targetMaxId  = $target::model()->getCount();
		do {
			$targetInfo = $target::model()->getInfo(array('id'=>$targetMaxId));
			if($targetInfo['district_name']){
				$list = district::model()->getList(array('district_name' =>$targetInfo['district_name']));
				if(count($list)>0){
					foreach ($list as $key => $value) {
						if($this->isSimilar($targetInfo,$value)){
							$sameCount++;
							if($targetInfo['district_id'] && $value['district_guid']){
								house_new::model()->updateHouse(array('district_guid'=>$info['district_guid']),array('district_id'=>$targetInfo['district_id']));
								$target::model()->updateDistrict(array('district_guid'=>$value['district_guid']),array('id'=>$targetMaxId));
								echo "update house and district data success\r\n";
							}						
							break;
						}else{
							//插入关键词表中
							// $diffCount++;
							// echo $diffCount." url: http://bj.5i5j.com/community/".$targetInfo['district_id']." 名称：".$targetInfo['district_name']."\r\n"; // for sure  同名不同地
							// echo $diffCount." url: http://beijing.homelink.com.cn/".$value['district_id']."/ 名称：".$value['district_name']."\r\n";
							// echo "\r\n\n";
						}							
					}
				}
				else{
					// $diffCount++;
					// echo " http://bj.5i5j.com/community/".$targetInfo['district_id']."/ 名称：".$targetInfo['district_name']."\r\n"; // for sure  不同名不同地
				}			
			}
		} while ( $targetMaxId--);
	}

	private function isSimilar($targetInfo,$aimInfo){
		$lng = abs($targetInfo['lng']-$aimInfo['lng']);
		$lat = abs($targetInfo['lat']-$aimInfo['lat']);
		if(round($lng*100)>=3 || round($lat*100)>=3){
			return false;
		}
		else{
			return true;
		}
	}
	private function imageCut($file,$new_file,$new_img_width = 180,$new_img_height = 180)
	{
		$filename = 'http://api.ikuaizu.com/data/attachment/'.$file;
		echo $filename."\r\n"; 
		$im = imagecreatefromjpeg($filename);
		if(!$im){
			echo "image is something wrong\r\n";
			return false;			
		}
		$img=getimagesize($filename);
		$newim = imagecreatetruecolor($new_img_width, $new_img_height); 

		imagecopyresampled($newim, $im, 0, 0, 0, 0, $new_img_width, $new_img_height, $img[0], $img[1]); 

		$to_File = '/data/wwwroot/ikuaizu/apps/apiport/wwwroot/data/attachment/'.$new_file;
		ImageJpeg($newim,$to_File,90); 
		imagedestroy($newim); 	
		imagedestroy($im);

		echo "imageCut success url: http://api.ikuaizu.com/data/attachment/".$new_file."\r\n";	
	}

	public function testAdd()
	{
  		$allList = keyMap::model()->getAll(array('type'=>2));
  		$num =0;
  		$keyword = '';
 		$value = $allList[$num]['value'];
  		do {
  			if($value == $allList[$num]['value']){
 				$keyword.=$allList[$num]['keyword']; 				
  			}else{
  				$data = array('id'=>$allList[$num]['id'],'keyword' =>$keyword,'value'=>$value);
  				$value = $allList[$num]['value'];
  				$keyword =$allList[$num]['keyword'];
  				$document = solrTools::model()->addDocument($data);
		  		$result = solrTools::model()->add($document,false);
  			}
 			$num++; 
  		} while ( $num< keyMap::model()->getCount(array('type'=>2)));  

  		$this->testCommit();	
	}
	public function testQuery()
	{
		$result = solrTools::model()->search('keyword','人大附小');
		//print_r($result['docs'][0]['id']);
		print_r($result);
	}
	public function testCommit(){
		$tools = new solrTools();
		$tools->commit(); 
	}
	public function testDelete(){
		$tools = new solrTools();
		$tools->delete('*','*');
		$tools->commit();
	}
	public function getTransStore($url,$agent_url){
		$tools = new commonTools();
		$simpleDom = new simpleHtmlExt();
		$max_break_num = 5;
		$pages = 1;
		$url = 'http://liyy20.beijing.homelink.com.cn/';//前台提供
		//$url = 'http://bj.5i5j.com/broker/517811/';
		//$url = 'http://esf.soufun.com/a/sf15910285763';
		$agent_url = 'liyy20';//前台提供
		//$agent_url ='517811';
		//$agent_url ='162568918';
		$target = $this->getTransTarget($url);
		$config = Config::getConfig('transStore_config',$target);
		$links = array();
		do {
			if(!$max_break_num){
				break;
			}
			$href = str_replace('{*}',$agent_url,$config['href']);
			$url = $href.$pages;
			echo $url."\r\n";
			$output = $tools->getCurl($url);

			if(empty($output))
			{
				$max_break_num--;
				continue;			
			}
			$htmlDom = $simpleDom->str_get_html($output);
			$list = $htmlDom->find($config['fatherNode']);
			foreach ($list as $key => $value) {
				$links[]=$value->find($config['childrenNode'],0)->href;
			}
			if(count($list) ==0){
				$max_break_num--;
				continue;
			}
			$pages++;			
		} while (1);
		$links = array_unique($links);		
		print_r($links);
		print_r(count($links));
		return $links;
	}
	public function houseSpider()
	{
	
		$page_no = 1;
		$page_size = 10;
		$count = $house_links::model()->getCount(array('status'=>0,'parse_status'=>0));
		do {
			//按页读取house_links表，目标为未解析，未入库的链接
			$list = house_links::model()->getList(array('status'=>0,'parse_status'=>0),$page_no,$page_size);
			$num = 0;
			do {
				//解析数据
				$data = $this->parseLinks($list[$num]);
				//提交到数据库中

				//修改store_links状态
			} while ($num++<count($list));
		} while (($page_no++)*$page_size<=$count);

	}	
	public function transTest(){
		// $url = 'http://liyy20.beijing.homelink.com.cn/';//前台提供
		// //$url = 'http://bj.5i5j.com/broker/517811/';
		// //$url = 'http://esf.soufun.com/a/sf15910285763';
		// $agent_url = 'liyy20';//前台提供
		// //$agent_url ='517811';
		// //$agent_url ='162568918';
//************************************************************//	
		do {
			$info = store_links::model()->getFlush();
			if(empty($info['url'])){
				echo "store_links is empty\r\n";
				sleep(2);
				continue;
			}
			print_r($info);
			$url = $info['url'];
			$agent_url = $info['agent_url'];	
			//根据链接获取店铺的房源链接
			$data = $this->importStoreHouseLinks($url,$agent_url);
			$target = $this->getTransTarget($url);
			//店铺房源链接与本地数据对比
			$this->contrastLinks($data,$target,$agent_url);
		} while (1);

	}
	private function getTransTarget($url){
		if(strpos($url,'homelink')){
			return 'homelink';
		}
		if(strpos($url,'5i5j')){
			return '5i5j';
		}
		if(strpos($url,'soufun')){
			return 'soufun';
		}
	}

	private function importStoreHouseLinks($url,$agent_url)
	{	

		$simpleDom = new simpleHtmlExt();
		$max_break_num = 5;
		$pages = 1;
		$target = $this->getTransTarget($url);
		$config = Config::getConfig('transStore_config',$target);
		$links = array();
		$totalCount =0;	
		store_links::model()->updateStoreLinks(array('analyze_status'=>1),array('agent_url'=>$agent_url));
		do {
			if(!$max_break_num){
				break;
			}
			$href = str_replace('{*}',$agent_url,$config['href']);
			$url = $href.$pages;
			$output = commonTools::model()->getCurl($url);
			if(empty($output))
			{
				$max_break_num--;
				continue;			
			}
			$htmlDom = $simpleDom->str_get_html($output);
			// $html = $htmlDom->find($config['totalCountNode'],0);
			// if($html){
			// 	if(0 < preg_match('/(\d+)/', $html->plaintext, $extmatches)){
			// 		$totalCount =$extmatches[0];
			// 	}
			// }
			$list = $htmlDom->find($config['fatherNode']);
			foreach ($list as $key => $value) 
			{
				$links[]=$value->find($config['childrenNode'],0)->href;
			}
			//////更新store_links数据库一次
			store_links::model()->updateStoreLinks(array('analyze_count'=>count($links)),array('agent_url'=>$agent_url));
			if(count($list) ==0){
				$max_break_num--;
				continue;
			}
			$pages++;
			$htmlDom->clear();						
		} while (1);
		$links = array_unique($links);
		store_links::model()->updateStoreLinks(array('analyze_status'=>2),array('agent_url'=>$agent_url));
		echo "解析该店铺房源量:".count($links)."\r\n";
		return $links;			
	}
	private function contrastLinks($data =array(),$target,$agent_url){
		$count=0;
		$totalCount=count($data);
		foreach ($data as $key => $value) {
			$info = pathinfo($value);
			$houseId = $info['filename'];
			$data =array(
				'target'=>$target,
				'agent_url'=>$agent_url,
				'house_url'=>$value,
				'parse_status'=>0,
				'status'=>0,
				'insert_date'=>TIMESTAMP
				);
			$info = house_new::model()->getInfo(array('house_id'=>$houseId));
			if($info['house_guid']){
				$count++;
				$data['parse_status'] =1;
				$data['status']=1;//该链接对应的房源已在库
			}
			if(house_links::model()->getInfo(array('house_url'=>$value))){
				house_links::model()->updateHouseLinks($data,array('house_url'=>$value));	
			}else{
				house_links::model()->addHouseLinks($data);					
			}

		}
		if($count ==$totalCount){
			
		}
		store_links::model()->updateStoreLinks(array('downloaded_count'=>$count),array('agent_url'=>$agent_url));
		echo "链接对比完成 链接量：".$totalCount." 在库量:".$count."\r\n";
	}
	public function wxApiQRImage(){				
		$token = WxApiTools::model()->getAccessToken();
		$num = 1;
		$data =array(329);
		foreach ($data as $key => $value) {
			$res = WxApiTools::model()->getTicket($token,$value);
			if($res = WxApiTools::model()->getQRImage($res,'qr'.$value)){
				echo "get image success,url is :$res\r\n";
			}
		}
	}
	public function wxApiMenuButton()
	{
		$data = array(
			'button'=>array(
				0=>array(
					'type' =>"click",
					'name' =>"我的经纪人",
					'key'  =>'MYAGENT',
					),
				1=>array(
					'type' =>'view',
					'name' =>'意见反馈',
					'url' => 'http://wx.ikuaizu.com/msg/msgus',
					// 'sub_button'=>array(
					// 	// 0=>array(
					// 	// 	'type'=>"view",
					// 	// 	'name'=>"中关村一小",
					// 	// 	'url' => "http://wx.ikuaizu.com/school/intro?xuequ_guid=MTAwMDAwMDM2Ng==&s=m.zgcyx",
					// 	// 	'sub_button'=>array()
					// 	// 	),
					// 	// 1=>array(
					// 	// 	'type'=>"view",
					// 	// 	'name'=>"中关村二小",
					// 	// 	'url' => "http://wx.ikuaizu.com/school/intro?&xuequ_guid=MTAwMDAwMDM4NA==&s=m.zgcex",
					// 	// 	'sub_button'=>array()
					// 	// 	),
					// 	// 2=>array(
					// 	// 	'type'=>"view",
					// 	// 	'name'=>"中关村三小",
					// 	// 	'url' => "http://wx.ikuaizu.com/school/intro?&xuequ_guid=MTAwMDAwMDIwMQ==&s=m.zgcsx",
					// 	// 	'sub_button'=>array()
					// 	// 	)						
					// 	)
					),
				2=>array(
					'type' =>'view',
					'name' =>'TEST',
					'url' => 'http://wx.ikuaizu.com/agent/myagent'
					)				
				// 2=>array(
				// 	'type' =>'',
				// 	'name' =>'更多',
				// 	'url'  =>'',
				// 	'sub_button'=>array(
				// 		0=>array(
 			// 				"type"=>"view",
    //                     	"name"=>"房源收藏",
    //                     	"url" =>"http://wx.ikuaizu.com/collect/house?s=m.fysc",
    //                     	"sub_button"=>array()
				// 			),
				// 		1=>array(
 			// 				"type"=>"view",
    //                     	"name"=>"店铺收藏",
    //                     	"url" =>"http://wx.ikuaizu.com/collect/house?s=m.fysc",
    //                     	"sub_button"=>array()
				// 			),
				// 		2=>array(
 			// 				"type"=>"view",
    //                     	"name"=>"我的订阅",
    //                     	"url" =>"http://wx.ikuaizu.com/collect/house?s=m.fysc",
    //                     	"sub_button"=>array()
				// 			)
				// 		)					
				// 	)
				)
			);
		//print_r(json_encode($data)); 
		//$appid = 'wxb6a114ecb913db20';$secret='8d04a9e211c9db247e7922fea631861c';//快租
		//$appid = 'wx36681801ab523efa';$secret='33c9ab3719c82bd77fbcb4060932b806';//爱居经纪人
		$appid = 'wxadcb2b0d4be9cb19';$secret='172e1b29a273156cc905da8394145142';  //爱居微搜房
		$token = WxApiTools::model()->getAccessToken($appid,$secret);
		$res = WxApiTools::model()->addMenuButton($data,$token);		
	}
	public function addQRImage(){
		$num =1;
		while ($num<= 1000) {
			qr_image::model()->addQR(array('url'=>'test/201311/11/qr'.$num.'.jpg'));
			$num++;
		}
	}
	public function upLoadImage(){

		$appid = 'wxb6a114ecb913db20';$secret='8d04a9e211c9db247e7922fea631861c';
		$token = WxApiTools::model()->getAccessToken($appid,$secret);
		$data = array('img'=>'@/data/wwwroot/ikuaizu/apps/apiport/wwwroot/data/attachment/test/201311/11/qr2.jpg');
		$res = WxApiTools::model()->upLoadImage($data,$token);
		if($res){
			print($res);
		}
	}
	public function getUserInfo(){
		$openId = 'o-IDjt4YWefD0FYzggoBLhxHfKEQ';

		$systemSetting = Config::getConfig('system');
		$appid = $systemSetting['aijujingjiren']['appid'];
		$secret=$systemSetting['aijujingjiren']['secret'];

		$token = WxApiTools::model()->getAccessToken($appid,$secret);
		$res = json_decode(WxApiTools::model()->getUserInfo($openId,$token));

		if(isset($res->errcode)){
			  print_r($res->errmsg);return $res->errmsg;
		}
		print_r($res);
		return $res;
	}
	public function getOAuthToken(){
		$appid = 'wxadcb2b0d4be9cb19';$secret='172e1b29a273156cc905da8394145142';  //爱居微搜房
		$res = WxApiTools::model()->getOAuthAccessToken($appid,$secret);
		print_r($res);
		//return $res;
	}
	public function getOAuthUserInfo(){
		//$res = $this->getOAuthToken();
		$openId ='oMJ6NjnnUSjsLBOJDIbzgV1rnrgk';
		$token = 'OezXcEiiBSKSxW0eoylIeItY6obBmDS0CVNs2Cj56T80KuU_k2j0uY3sdT6IIaVl3_vQq7rQiorJAmWXqL1Vu6FRneGz7l24Txc7zWaaQurJyAa0w76SBw2xnoWYoJF3dCYkInDeTyvMKbnDB_jAvA';
		$res = WxApiTools::model()->getOAuthUserInfo($openId,$token);
		print_r(json_decode($res));
	}
}