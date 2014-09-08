<?php
require_once(dirname(__FILE__) . '/../libraries/SolrPhpClient/Apache/Solr/Service.php');
class otherCli extends backgroundCli{
	function actionIndex($method){
		$data = "目标执行时间：".date("Y-m-d H:i:s")."\r\n";
		file_put_contents('/tmp/cli.log', $data,FILE_APPEND);		
		if(method_exists($this,$method)){
			$this->$method();
		}
	}
	function importUrl(){//学区对应小区的链接
		$xuequ = xuequ::model();
		$queue = urlQueue::model();
		$count = $xuequ->getMaxXuequId();
		$num = $xuequ->getCount();
		 do{
			$url = $xuequ->getInfoByGuid($count);	
			$insertArr = array(
				'url' =>'http://beijing.homelink.com.cn/school/esfy/'.$url['xuequ_id'].'.shtml',
				'target' => 'homelink_xuequ_district',
				'status' => 0,
				'dateline' =>TIMESTAMP
				);	
			print_r($insertArr);
			if($this->queue()->isExist(array('url'=>$insertArr['url'],'target'=>$insertArr['target']))){
				echo "isExist1\r\n";
				continue 1;
			}			
			if(urlResouce::model()->hasExist(array('url'=>$insertArr['url'],'target'=>$insertArr['target']))){
				echo "isExist2\r\n";
				continue 1;
			}
			if($queue->add($insertArr)){
				echo "success\r\n";
			}else{
				echo "false\r\n";
			}
			sleep(2);
		}while($count-- && --$num);

	}
	function importKeyValue(){
		$rule = '区';
		$type = 3;
		$data = array('rule'=>$rule,'type'=>$type);
		$kuaizuApi = new serverExt('ikuaizu_spider');
		$res = $kuaizuApi->api()->spider_importKeyValue($data);
		print_r($res);		
	}
	function apiTest(){
		$kuaizuApi = new serverExt('ikuaizu_spider');

           	try{
				$res = $kuaizuApi->api()->api_test();
				print_r($res);
			}
			catch(Exception $e){
				echo 'Message: ' .$e->getMessage();
			}

		
	}

	function getHomelinkNew(){
		$target = 'homelink';
		$nodes = new spiderNode('homelink_new');
		
		$sleep = $nodes->getConfig('sleep');
		
		if(!$sleep){
			$sleep = 2;
		}		
		
		$page = 1;
		$max_break_num =10;
		$this->queue()->init();		
		$urlResouce = urlResouce::model();
		$urlResouce->buildTable();
		$urlCount = 0;//总链接量
		$urlQueCount = 0;//已存在于未抓取链接库的链接数
		$urlResCount = 0;//已存在于已抓取链接库的链接数
		do{						
			$url = $nodes->getListUrl($page);
			echo "flash page $page : ".$url."\r\n";//输出真实url
			if($nodes->clawler($url)){
				
				$links = $nodes->getLinks();

				if(empty($links)){
					echo "no links found\r\n";
					if($max_break_num--){
						continue;
					}else{
						//将未验证过的链接置为0，表示此轮对比链接，该链接失效
						//$urlResouce->updateResouce(array('is_exist' =>0),array('target'=>$target,'is_exist'=>1));
						sleep($sleep);
						//开始新循环，将之前置为2的状态返回到1（代表该链接依然活跃）
						//$urlResouce->updateResouce(array('is_exist' =>1),array('target'=>$target,'is_exist'=>2));
						$page = 1;
						$max_break_num =10;
						$data = '时间：'.date("Y-m-d H:i:s").'爬虫类型：homelink_new'.'链接总量'.$urlCount.' urlQueCount：'.$urlQueCount.' urlResCount:'.$urlResCount."\r\n";
						file_put_contents('/tmp/spiderCount',$data,FILE_APPEND);
						$urlCount = 0;
						$urlQueCount = 0;//已存在于未抓取链接库的链接数
						$urlResCount = 0;//已存在于已抓取链接库的链接数
						continue;
					}
				}

				foreach($links as $url){
					$urlCount++;
				    echo "links: ".$url."\r\n";					
					if($this->queue()->isExist(array('url'=>$url,'target'=>$target))){
						$urlQueCount++;
						echo "isExist in queue\r\n";
						continue 1;
					}
					if($urlResouce->hasExist(array('url'=>$url,'target'=>$target))){
						$urlResouce->updateResouce(array('is_exist' =>2),array('url'=>$url,'target'=>$target));
						$urlResCount++;
						echo "isExist in resource\r\n";
						continue 1;
					}
		
					$data = array(
						'target' => $target,
						'url' => $url,
						'status' => 0,
						'dateline' => TIMESTAMP
					);
					$this->queue()->put($data);
				}
			}
			else {				
				if($max_break_num--){
					continue;
				}else{
					//将未验证过的链接置为0，表示此轮对比链接，该链接失效
					//$urlResouce->updateResouce(array('is_exist' =>0),array('target'=>$target,'is_exist'=>1));
					sleep($sleep);
					//开始新循环，将之前置为2的状态返回到1（代表该链接依然活跃）
					//$urlResouce->updateResouce(array('is_exist' =>1),array('target'=>$target,'is_exist'=>2));
					$page = 1;
					$max_break_num =10;
					$data = '时间：'.date("Y-m-d H:i:s").'爬虫类型：homelink_new'.'链接总量'.$urlCount.' urlQueCount：'.$urlQueCount.' urlResCount:'.$urlResCount."\r\n";
					file_put_contents('/tmp/spiderCount',$data,FILE_APPEND);
					$urlCount = 0;
					$urlQueCount = 0;//已存在于未抓取链接库的链接数
					$urlResCount = 0;//已存在于已抓取链接库的链接数
					continue;
				}
			}
			
			$page++;
			
			sleep($sleep);
			
		}while(1);
		echo "totalCount:".$urlCount."\r\n";		
	}
	function getDistrictUrl(){
		$pages= 1;
		$max_break_num =10;
		$queue = urlQueue::model();
		$urlCount =0;
		$urlQueCount = 0;//已存在于未抓取链接库的链接数
		$urlResCount = 0;//已存在于已抓取链接库的链接数	
		$tools = new commonTools();
		do {
			$url = 'http://beijing.homelink.com.cn/xiaoqu/pg'.$pages.'/';
			echo $url."\r\n";
			$output = $tools->getCurl($url);
			$pattern = '/(c-([\w+]|[\d+]){1,})/';
			if(empty($output)){				
				$max_break_num--;
				if($max_break_num ==0){
					$pages =1;
					$urlCount =0;
					$urlQueCount = 0;//已存在于未抓取链接库的链接数
					$urlResCount = 0;//已存在于已抓取链接库的链接数	
					$max_break_num = 10;
					continue;
				}
			}
			preg_match_all($pattern,$output,$preg_rs);
			
			$links = array_unique($preg_rs[0]);	
			if(count($links)>0){
				foreach ($links as $key => $value) {
					$insertArr = array(
						'url' =>'http://beijing.homelink.com.cn/'.$value.'/',
						'target' => 'homelink_district',
						'status' => 0,
						'dateline' =>TIMESTAMP
						);
					print_r($insertArr);	
					$urlCount++;	
					if($this->queue()->isExist(array('url'=>$insertArr['url'],'target'=>$insertArr['target']))){
						$urlQueCount++;
						echo "isExist in queue\r\n";
						continue 1;
					}
					
					if(urlResouce::model()->hasExist(array('url'=>$insertArr['url'],'target'=>$insertArr['target']))){
						urlResouce::model()->updateResouce(array('is_exist' =>2),array('url'=>$insertArr['url'],'target'=>$insertArr['target']));
						$urlResCount++;
						echo "isExist in resource\r\n";
						continue 1;
					}
					if($queue->add($insertArr)){
						echo "success\r\n";
					}					
				}
			}
			else{
				$max_break_num--;
				if($max_break_num ==0){
					$pages =1;
					$urlCount =0;
					$urlQueCount = 0;//已存在于未抓取链接库的链接数
					$urlResCount = 0;//已存在于已抓取链接库的链接数	
					$max_break_num = 10;
					continue;
				}				
			}
			echo "pages:".$pages." totalCount:".$urlCount." 未解析链接量：".$urlQueCount." 解析库连接量：".$urlResCount;
			urlResouce::model()->deleteResouce(array('url'=>$url));
			$pages++;
		} while (1);	
	}
	function checkMy5i5jHouseUrl(){
		$this->checkUrl('my5i5j','.title h1');
	}
	function checkHomelinkHouseUrl(){
		$this->checkUrl('homelink','.xtitle h1');
	}
	private function checkUrl($target,$dom){
		$tools = new commonTools();
		$simpleDom = new simpleHtmlExt();
		while (1) {
			$maxId = urlResouce::model()->getMaxId(array('target'=>$target,'is_exist'=>0));
			$count = 0;
			$totalCount = 0;
			do {
				$info = urlResouce::model()->getInfo(array('id' =>$maxId,'target'=>$target,'is_exist'=>0));
				if(!empty($info)){
					$output = $tools->getCurl($info['url']);
					$totalCount++;
					if(!empty($output)){	
						$htmlDom = $simpleDom->str_get_html($output);
						if(empty($htmlDom)){
							$dead_num = $info['dead_num']+1;
							urlResouce::model()->updateResouce(array('dead_num'=>$dead_num),array('id'=>$maxId));
							echo $maxId.$info['url']."  find the url is dead \r\n";
							continue;
						}
						$result = $htmlDom->find($dom, 0);
						if($result && $result = $result->plaintext){
							if(!empty($result)){
								if(urlResouce::model()->updateResouce(array('is_exist'=>2,'dead_num'=>0),array('id'=>$maxId))){
									$count++;
									echo $maxId.$info['url']."  find the url is alive \r\n";
								}						
							}
							$htmlDom->clear();						
						}
						else{
								$dead_num = $info['dead_num']+1;
								urlResouce::model()->updateResouce(array('dead_num'=>$dead_num),array('id'=>$maxId));
								echo $maxId.$info['url']."  find the url is dead \r\n";
						}
					}
					else{
							$dead_num = $info['dead_num']+1;
							urlResouce::model()->updateResouce(array('dead_num'=>$dead_num),array('id'=>$maxId));
							echo $maxId.$info['url']."  find the url is dead \r\n";
					}				
				}
				//sleep(1);
			}
			 while ( $maxId--);
			 echo $target.date("Y-m-d H:i:s")."  have checked a circle \r\n";
		}		
	}
	//建立学区<=>小区ID的对应关系
	public function importXuequHouse(){
		$tools = new commonTools();
		$host = 'http://beijing.homelink.com.cn';
		do {
			$href = $tools->getVisitUrl(array('target'=>'xuequ_house','status' =>0));
			if($href){
				$url = $host.$href;
				$arr = pathinfo($url);
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
			}else{
				break;
			}			
		} while (1);

	}

	public function getHouseOffSell(){
		while (1) {
			$count = urlResouce::model()->count(array('is_exist'=>0,'dead_num'=>4));
			$page_no = 1;
			$page_size = 30;
			do {
				$list = urlResouce::model()->getList(array('is_exist'=>0,'dead_num'=>4),$page_no,$page_size);
				foreach ($list as $key => $value) {
					commonTools::model()->getHouse_downSell($value);
					urlResouce::model()->deleteResouce(array('url'=>$value['url']));
					echo "delete from urlResouce\r\n";
					if(dead_links::model()->hasExist(array('url'=>$value['url']))){
						continue;
					}
					dead_links::model()->addResouce($value);
					echo "add in dead_links";
				}
				$page_no++;
			} while ($count>=$page_size*($page_no-1));
			sleep(60);	
		}
	
	}
	public function getali()
	{
		$tools = new commonTools();
		$simpleDom = new simpleHtmlExt();
		$pages = 1;
		do 
		{
         	$url = 'http://www.alibaba.com/Building-Material-Making-Machinery-Parts_pid4315_'.$pages;
			echo $url."\r\n";
			$output = $tools->getCurl($url);
			$pattern = '%(\w+).en.alibaba.com/contactinfo.html%';

			if(empty($output))
			{
				$max_break_num--;
				continue;			
			}
			preg_match_all($pattern,$output,$preg_rs);		
			$links = array_unique($preg_rs[0]);
			if(count($links) ==0){
				$max_break_num--;
				continue;
			}
			print_r($links);	
			foreach ($links as $key => $value){
				$data = array(
					'name'=>'',
					'tel'=>'',
					'mobeltel' =>'',
					'company' =>'',
					'website' =>''
					);
				$output = $tools->getCurl($value);
				if(!empty($output)){
					$htmlDom = $simpleDom->str_get_html($output);
					if($htmlDom){
						$html = $htmlDom->find('.contact-info h1', 0);
						if(!empty($html)){
							$data['name']=trim($html->plaintext);
						}
						$html = $htmlDom->find('.dl-horizontal', 1);
						if(!empty($html)){
							if( $html = $html->find('dd',0))
								$data['tel'] = $html->plaintext;
						}
						$html = $htmlDom->find('.dl-horizontal', 1);
						if(!empty($html)){
							$mobeltel = '';
							if( $html = $html->find('dd',1))
								if(0 < preg_match('/(\d+[-]?\d+[-]?\d+)/', $html->plaintext, $extmatches)){
								   $mobeltel = $extmatches[0];	
								}								
								$data['mobeltel'] =$mobeltel;		
						}
						$html = $htmlDom->find('.company-info-data tr', 0);				
						if(!empty($html)&& $html = $html->find('td',1)){
							$data['company'] =trim($html->plaintext);
						}
						$html = $htmlDom->find('.company-info-data tr', 2);
						if(!empty($html) && $html = $html->find('a',0))
							$data['website'] =trim($html->href); 
					}
					test::model()->addTest($data);
					$data[]=$value;
					print_r($data);
				}
			}
		} while ($pages++ <=248);
	}
	public function linksTest(){
		$kuaizuApi = new serverExt('ikuaizu_spider');
		do {
			$res = $kuaizuApi->api()->data_houseLinks();
			$info = $res['data'];
			if(empty($info) || empty($info['house_url'])){			
				print_r($info) ;
				sleep(2);
				continue;
			}
			$config = Config::getConfig('transStore_config',$info['target']);
			$data = commonTools::model()->getParseResult(null,null,$info['house_url'],$info['target'],$config['items']);
			if(empty($data)){
				$data = array(
					'house_url'=>$info['house_url'],
					'status'=>0,
					'parse_status'=>3
					);
				$req = $kuaizuApi->api()->data_updateHouseLinks($data);//更新house_links解析状态（已抓取---抓取失败）
				print_r($req);
				$data = array(
					'agent_url'=>$info['agent_url'],
					'fail_count'=>1,
					'parse_status'=>2
					);
				$req = $kuaizuApi->api()->data_updateStoreLinks($data);//更新store_links解析状态（已抓取---抓取失败量）
				print_r($req);
			}
			else{
			$arr = pathinfo($info['house_url']);
			$inserArr = array(
				'education' =>!empty($data['education']) ? serialize($data['education']) : '',
				'business' =>!empty($data['business']) ? serialize($data['business']) : '',
				'hospital' =>!empty($data['hospital']) ? serialize($data['hospital']) : '',
				'traffic' =>!empty($data['traffic']) ? serialize($data['traffic']) : '',
				'daily_life' =>!empty($data['daily_life']) ? serialize($data['daily_life']) : '',
				'disgust' =>!empty($data['disgust']) ? serialize($data['disgust']) : '',
				'photos' =>	!empty($data['photos']) ? serialize($data['photos']) : '',
				'house_id' => $arr['filename'],
				'district_id' => $data['districtId'],
				'district_name' => $data['districtName'],
				'label' => !empty($data['label']) ? $data['label'] : '',
				'fitment' => !empty($data['fitment']) ? $data['fitment'] : '',
				'sell_price' => !empty($data['sellPrice']) ? $data['sellPrice'] : 0,
				'mm_price' => $data['mmPrice'],
				'room' => $data['room'],
				'hall' => $data['hall'],
				'agent_url' => $data['agentId'],
				'title' => $data['title'],
				'square' => $data['square'],
				'floor_on' => !empty($data['floorOn']) ? $data['floorOn'] : 0,
				'floor_all' =>  !empty($data['floorAll']) ? $data['floorAll'] : 0,
				'orientation' =>$data['orientation'],
				'first_payment'=> !empty($data['firstPayment']) ? $data['firstPayment'] : 0,
				'month_payment' =>!empty($data['monthPayment']) ? $data['monthPayment'] : 0,
				'create_time' => TIMESTAMP,
				'onsell_agents' =>$data['onsellAgent'],
				'source' => $info['target']
			);
			print_r($inserArr);
			$req = $kuaizuApi->api()->spider_importHouse($inserArr);//插入该房源
			print_r($req);
			file_put_contents('/tmp/test.log', $info);
			$req = $kuaizuApi->api()->data_updateStoreLinks(array('agent_url'=>$info['agent_url'],'downloaded_count'=>1,'download'=>1));//更新store_links表字段 //parse_count+1	
		}
		} while (1);
	}


	public function faceTest(){
		$api_key = "80794efcf1c350268dc976b8fedd5617";
		$api_secret = "E2GkxairkHBryPMvFQ35uRwnEpNembgR";
		// initialize client object
		$api = new FacePPClientDemo($api_key, $api_secret);
	}
	public function wxApiTest(){
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxadcb2b0d4be9cb19&secret=172e1b29a273156cc905da8394145142';
		$res = commonTools::model()->getCurl($url);
		$access_token = json_decode($res);
		$url= "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token->access_token."&media_id=8gBMVbfRq98lSQS63xfJOkpfPok-suvjd1LleL76LpVKpLElSyyxu92XA1DN50uF";
		print_r($url);
		$res = commonTools::model()->getCurl($url);
		file_put_contents('/tmp/wx_media.mp4', $res);
		//print_r($res);
	}
}