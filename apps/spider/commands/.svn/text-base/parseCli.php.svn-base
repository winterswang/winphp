<?php
class parseCli extends backgroundCli{
	function actionIndex($target){
		$data = "目标执行时间：".date("Y-m-d H:i:s")."\r\n";
		file_put_contents('/tmp/cli.log', $data,FILE_APPEND);
		
		$kuaizuApi = new serverExt('ikuaizu_spider');
		while(1){
			urlResouce::model()->buildTable();
			
			if($this->isStop()){
				break;
			}
			//特定解析链家经纪人的URL
			$q = $this->queue()->flush_new($target);//解析未抓取的URL
			if(empty($q)){
				echo "未抓取的链接库已空，开始解析已抓取的链接\r\n";
				$q = urlResouce::model()->flush_new($target);//解析已抓取的URL
				if(empty($q)){
					echo "已抓取的链接库解析已完，开始重新解析已抓取的链接\r\n";
					urlResouce::model()->updateResouce(array('status' =>0,'download' =>0),array('target'=>$target));//已抓取的URL已解析完则重置状态位重新解析
					continue;
				}
			}
			$doc = new spiderDoc($q['target']);
			if($doc->spider($q['url'],$q['dateline']))
			{
			 	$this->$target($doc,$q,$kuaizuApi);
			 	urlResouce::model()->updateResouce(array('status' =>1),array('url'=>$q['url'],'target'=>$target,'download' =>1));//解析后修改状态位，不再解析
			}
			else{
				echo "未知错误\r\n";
			}
			sleep(3);
		}
	}

	function homelink($doc,$q,$kuaizuApi){

		$item = array('education','business','hospital','traffic','daily_life','disgust',
					  'title','districtName','districtId','label','photos',
					  'sellPrice','room','hall','fitment','mmPrice','agentId',
					  'square','floorOn','floorAll','orientation','firstPayment','monthPayment','onsellAgent'
			);
		$data = $doc->getItems($item);
		$data['url'] = $q['url'];
		$arr = pathinfo($q['url']);
		$inserArr = array(
			'education' =>serialize($data['education']),
			'business' =>serialize($data['business']),
			'hospital' =>serialize($data['hospital']),
			'traffic' =>serialize($data['traffic']),
			'daily_life' =>serialize($data['daily_life']),
			'disgust' =>serialize($data['disgust']),
			'photos' =>	serialize($data['photos']),
			'house_id' => $arr['filename'],
			'district_id' => $data['districtId'],
			'district_name' => $data['districtName'],
			'label' => $data['label'],
			'fitment' => $data['fitment'],
			'sell_price' => $data['sellPrice'],
			'mm_price' => $data['mmPrice'],
			'room' => $data['room'],
			'hall' => $data['hall'],
			'agent_url' => $data['agentId'],
			'title' => $data['title'],
			'square' => $data['square'],
			'floor_on' => $data['floorOn'],
			'floor_all' => $data['floorAll'],
			'orientation' =>$data['orientation'],
			'first_payment'=> $data['firstPayment'],
			'month_payment' =>$data['monthPayment'],
			'create_time' => TIMESTAMP,
			'onsell_agents' =>$data['onsellAgent'],
			'source' => $q['target']
		);
		if(empty($inserArr['title']) || empty($inserArr['district_name'])){
			$data = '时间：'.date("Y-m-d H:i:s").' 解析目标：homelink  url：'.$q['url']."\r\n";
			file_put_contents('/tmp/homelink.log', $data,FILE_APPEND);
			urlResouce::model()->updateResouce(array('is_exist' =>0),array('url'=>$q['url'],'target'=>'homelink'));

		}else{
			$req = $kuaizuApi->api()->spider_importHouse($inserArr);
			print_r($req);			
		}
	}
	//所有的经纪人信息
	function homelink_agent($doc,$q,$kuaizuApi){

		$item = array('agentTel','agentName','agentLevel','agentCompany','agentDistrict','agentArea','agentStore','agentUrl','agentBusiness','agentPhoto');
		$data = $doc->getItems($item);
		//$arr = pathinfo($q['url']);
		$inserArr = array(
			'agent_name' =>$data['agentName'],
			'telephone' =>$data['agentTel'],
			'level' =>$data['agentLevel'],
			'company' =>$data['agentCompany'],
			'agent_area' =>$data['agentArea'],
			'agent_district' =>$data['agentDistrict'],
			'agent_store' =>$data['agentStore'],
			'agent_business' =>$data['agentBusiness'],
			'agent_url' =>$data['agentUrl'],
			'agent_photo' =>$data['agentPhoto']
		);
		if(empty($inserArr['agent_name'])){
			$data = '时间：'.date("Y-m-d H:i:s").' 解析目标：homelink_agent  url：'.$q['url']."\r\n";
			file_put_contents('/tmp/homelinkLog', $data,FILE_APPEND);
			urlResouce::model()->updateResouce(array('is_exist' =>0),array('url'=>$q['url'],'target'=>'homelink_agent'));
		}else{
			$req = $kuaizuApi->api()->spider_updateAgent($inserArr);
			print_r($req);	
			echo $q['url']."\r\n";		
		}

	}
	//所有的小区信息
	function homelink_district($doc,$q,$kuaizuApi){
		$item = array('districtName','districtAddress','buildTime','photos',
					  'buildCompany','area','manageCompany','manageFee','greenRate','floorRate','agentUrl');

		$data = $doc->getItems($item);
		$arr = pathinfo($q['url']);
		$data['districtId'] = $arr['filename'];
		//$data['url'] = $q['url'];

		$inserArr = array(
			'district_id' => $data['districtId'],
			'district_name' => $data['districtName'],
			'address' => $data['districtAddress'],
			'build_time' => $data['buildTime'],
			'build_company' => $data['buildCompany'],
			'build_square' => 0,
			'area' => 0,
			'target' =>'homelink',
			'manage_company' => $data['manageCompany'],
			'manage_fee' => $data['manageFee'],
			'green_rate' => $data['greenRate'],
			'floor_rate' => $data['floorRate'],
			'photos' => serialize($data['photos']),
			'agent_url' => $data['agentUrl'],
			);
		if(!empty($data['districtAddress'])){
				$res = $this->getLatlng($data['districtAddress']);
				$json_arr = json_decode($res,true);
				if(isset($json_arr['status']) && $json_arr['status'] == 0){
					$lng = isset($json_arr['result']['location']['lng']) ? $json_arr['result']['location']['lng'] : 0;
					$lat = isset($json_arr['result']['location']['lat']) ? $json_arr['result']['location']['lat'] : 0;
					$inserArr['lng'] =$lng;
					$inserArr['lat'] =$lat;
				}

		}
		if(empty($inserArr['district_name'])){
			$data = '时间：'.date("Y-m-d H:i:s").' 解析目标：homelink_district  url：'.$q['url']."\r\n";
			file_put_contents('/tmp/homelinkLog', $data,FILE_APPEND);
			urlResouce::model()->updateResouce(array('is_exist' =>0),array('url'=>$q['url'],'target'=>'homelink_district'));
		}else{
		 	$req = $kuaizuApi->api()->spider_updateDistrict($inserArr);
		 	print_r($req);
		}

	}
	//所有的学区信息
	function homelink_xuequ($doc,$q,$kuaizuApi){
		$item = array('schoolName','schoolPhoto','priceMin','schoolOverview',
					  'priceMax','agentId','recommend','baseContent','teachers');		
		$data = $doc->getItems($item);
		$arr = pathinfo($q['url']);
		$data['xuequId'] = $arr['filename'];
		$data['url'] = $q['url'];

		$inserArr = array(
			'xuequ_id' => $data['xuequId'],
			'school_name' => $data['schoolName'],
			'school_level' => $data['baseContent']['schoolLevel'],
			'school_category' => $data['baseContent']['schoolCategory'],
			'school_fee' => $data['baseContent']['schoolFee'],
			'school_buildtime'=> $data['baseContent']['schoolBuildtime'],
			'school_address'=> $data['baseContent']['schoolAddress'],
			'school_tel'=> $data['baseContent']['schoolTel'],
			'school_overview' =>$data['schoolOverview'],
			'agent_id'=>$data['agentId'],
			'school_photo' =>$data['schoolPhoto'],
			'recommend' =>$data['recommend'],
			'price_min'=>$data['priceMin'],
			'price_max'=>$data['priceMax'],
			'account_Req'=> $data['baseContent']['accountReq'],
			'account_year'=> $data['baseContent']['accountYear'],
			'xuequ_num'=> ''.$data['baseContent']['xuequNum'],
			'school_character'=> $data['baseContent']['schoolCharacter'],
			'city_studyrate'=> $data['baseContent']['cityStudyrate'],
			'area_studyrate'=> $data['baseContent']['areaStudyrate'],
			'advanced_teacher_num' => $data['teachers']['advanced'],
			'inter_teacher_num' => $data['teachers']['intermediate'],
			'junior_teacher_num' => $data['teachers']['junior']
		);
		if(!empty($inserArr['school_address'])){
			$res = $this->getLatlng($inserArr['school_address']);
			$json_arr = json_decode($res,true);
			if(isset($json_arr['status']) && $json_arr['status'] == 0){
				$lng = isset($json_arr['result']['location']['lng']) ? $json_arr['result']['location']['lng'] : 0;
				$lat = isset($json_arr['result']['location']['lat']) ? $json_arr['result']['location']['lat'] : 0;
				$inserArr['lng'] =$lng;
				$inserArr['lat'] =$lat;
			}
		}
		//print_r($inserArr);
		$req['url'] = $q['url'];
		if(empty($inserArr['school_name'])){
			$data = '时间：'.date("Y-m-d H:i:s").' 解析目标：homelink_xuequ  url：'.$q['url']."\r\n";
			file_put_contents('/tmp/homelinkLog', $data,FILE_APPEND);			
			urlResouce::model()->updateResouce(array('is_exist' =>0),array('url'=>$q['url'],'target'=>'homelink_xuequ'));			
		}else{
			$req = $kuaizuApi->api()->spider_importXuequ($inserArr);	
			print_r($req);		
		}
	}
	//建立学区和小区的关系表，只存储 xuequ_guid,district_guid
	function homelink_xuequ_district($doc,$q,$kuaizuApi){
		$tools = new commonTools();
		$host = 'http://beijing.homelink.com.cn';
		$arr = pathinfo($q['url']);
		$item = array('xuequNameDistrict','xuequHouseUrl');
		$data = $doc->getItems($item);

	    if(count($data['xuequNameDistrict']['url'])>0)
	    {
	    	foreach ($data['xuequNameDistrict']['url'] as $key => $value) 
	    	{
	    		$url = $host.$value;	
				$output = $tools->getCurl($url);
				$rules = '/ershoufang/{*}.shtml';
				$result = $tools->getParseResult($rules,$output);
				if(count($result)>0){
					$result = pathinfo($result[0]);
					$data = array(
						'xuequ_id' => $arr['filename'],
						'house_id' => $result['filename']
						);
					$kuaizuApi = new serverExt('ikuaizu_spider');
					$res =$kuaizuApi->api()->spider_importXueDistrict($data);
					$data['result'] = $res;	
					print_r($data);	
				}else{
					echo "result is none\r\n";
				}
	    	}
	    }

	}

	function getLatlng($address){
	
		$arr = array(
			'ak'=>'02E230F9f983704a5735749b9fcf98c3',
			'output'=>'json',
			'address'=>$address,
			'city'=>'北京市'
		);

		$url = 'http://api.map.baidu.com/geocoder/v2/?'.http_build_query($arr);
		$ci = curl_init();
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ci, CURLOPT_TIMEOUT, 30);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_ENCODING, "");
		curl_setopt($ci, CURLOPT_HEADER, FALSE);
		curl_setopt($ci, CURLOPT_URL, $url );
		return curl_exec($ci);

	}
	function my5i5j($doc,$q,$kuaizuApi){
		$item =array('title','sellPrice','mmPrice','square','room',
						 'hall','wc','orientation','districtId','districtName',
						 'floorOn','floorAll','agentName','agentId','mobile','fitment','photos','onsellAgent');
		$data = $doc->getItems($item);
		$data['url'] = $q['url'];
		$arr = pathinfo($q['url']);
		$inserArr = array(
			'photos' =>	serialize($data['photos']),
			'house_id' => $arr['filename'],
			'district_id' => $data['districtId'],
			'district_name' => $data['districtName'],
			'label' => '',
			'fitment' => $data['fitment'],
			'sell_price' => $data['sellPrice'],
			'mm_price' => $data['mmPrice'],
			'room' => $data['room'],
			'hall' => $data['hall'],
			'wc' => $data['wc'],
			'agent_url' => $data['agentId'],
			'title' => $data['title'],
			'square' => $data['square'],
			'floor_on' => $data['floorOn'],
			'floor_all' => $data['floorAll'],
			'orientation' =>$data['orientation'],
			'first_payment'=> 0,
			'month_payment' =>0,
			'create_time' => TIMESTAMP,
			'onsell_agents' =>$data['onsellAgent'],
			'source' => '5i5j'
		);
		print_r($q);
		if(empty($inserArr['title']) || empty($inserArr['district_name'])){
			$data = '时间：'.date("Y-m-d H:i:s").' 解析目标：5i5j  url：'.$q['url']."\r\n";
			file_put_contents('/tmp/my5i5j.log', $data,FILE_APPEND);
			urlResouce::model()->updateResouce(array('is_exist' =>0),array('url'=>$q['url'],'target'=>'my5i5j'));

		}else{
			$req = $kuaizuApi->api()->spider_importHouse($inserArr);
			print_r($req);			
		}
	}
	function my5i5j_agent($doc,$q,$kuaizuApi){
			$item = array('agentTel','agentName','agentCompany','agentPhoto','agentArea','agentBusiness','agentDistrict');
			$data = $doc->getItems($item);
			$arr = pathinfo($q['url']);
			$data['agent_url'] = $arr['filename'];
			$data['url'] = $q['url'];
			$inserArr = array(
				'agent_name' =>$data['agentName'],
				'telephone' =>$data['agentTel'],
				'level' =>'',
				'company' =>$data['agentCompany'],
				'agent_area' =>$data['agentArea'],
				'agent_district' =>$data['agentDistrict'],
				'agent_store' => '',
				'agent_business' =>$data['agentBusiness'],
				'agent_url' =>$data['agent_url'],
				'agent_photo' =>$data['agentPhoto']
			);
			if(empty($inserArr['agent_name'])){
				$data = '时间：'.date("Y-m-d H:i:s").' 解析目标：my5i5j_agent  url：'.$q['url']."\r\n";
				file_put_contents('/tmp/my5i5j.log', $data,FILE_APPEND);
				urlResouce::model()->updateResouce(array('is_exist' =>0),array('url'=>$q['url'],'target'=>'my5i5j_agent'));
			}else{
				$req = $kuaizuApi->api()->spider_updateAgent($inserArr);
				print_r($req);	
				echo $q['url']."\r\n";		
			}			
	}
	function my5i5j_district($doc,$q,$kuaizuApi){
			$item = array('districtName','districtAddress','manageType','manageCompany','photos','overView',
							'parkingSpace','area','floorRate','buildSquare','buildTime','manageFee','buildCompany','greenRate');
			$data = $doc->getItems($item);
			$data['url'] = $q['url'];
			$arr = pathinfo($q['url']);
			$data['districtId'] = $arr['filename'];

			$inserArr = array(
			'district_id' => $data['districtId'],
			'district_name' => $data['districtName'],
			'address' => $data['districtAddress'],
			'build_time' => $data['buildTime'],
			'build_company' => $data['buildCompany'],
			'build_square' => $data['buildSquare'],
			'area' => $data['area'],
			'manage_company' => $data['manageCompany'],
			'manage_fee' => $data['manageFee'],
			'green_rate' => $data['greenRate'],
			'floor_rate' => $data['floorRate'],
			'photos' => '',
			'target' =>'5i5j',
			'agent_url' => '',
			);
		if(!empty($data['districtAddress'])){
				$res = $this->getLatlng($data['districtAddress']);
				$json_arr = json_decode($res,true);
				if(isset($json_arr['status']) && $json_arr['status'] == 0){
					$lng = isset($json_arr['result']['location']['lng']) ? $json_arr['result']['location']['lng'] : 0;
					$lat = isset($json_arr['result']['location']['lat']) ? $json_arr['result']['location']['lat'] : 0;
					$inserArr['lng'] =$lng;
					$inserArr['lat'] =$lat;
				}
		}
		if(empty($inserArr['district_name'])){
			$data = '时间：'.date("Y-m-d H:i:s").' 解析目标：my5i5j_district  url：'.$q['url']."\r\n";
			file_put_contents('/tmp/my5i5j.log', $data,FILE_APPEND);
			urlResouce::model()->updateResouce(array('is_exist' =>0),array('url'=>$q['url'],'target'=>'my5i5j_district'));
		}else{
		 	$req = $kuaizuApi->api()->spider_updateDistrict_5i5j($inserArr);
		 	print_r($req);
		}	
	}
}