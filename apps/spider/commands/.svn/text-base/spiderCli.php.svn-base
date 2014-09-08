<?php
class spiderCli extends backgroundCli{
	
	function actionIndex($target){	
		
		$data = "目标执行时间：".date("Y-m-d H:i:s")."\r\n";
		file_put_contents('/tmp/cli.log', $data,FILE_APPEND);

		$nodes = new spiderNode($target);
		if($target =='homelink_new'){
			$target= 'homelink';
		}		
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
						$urlResouce->updateResouce(array('is_exist' =>0),array('target'=>$target,'is_exist'=>1));
						sleep($sleep);
						//开始新循环，将之前置为2的状态返回到1（代表该链接依然活跃）
						$urlResouce->updateResouce(array('is_exist' =>1),array('target'=>$target,'is_exist'=>2));
						$page = 1;
						$max_break_num =10;
						$data = '时间：'.date("Y-m-d H:i:s").'爬虫类型：'.$target.'链接总量'.$urlCount.' urlQueCount：'.$urlQueCount.' urlResCount:'.$urlResCount."\r\n";
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
					$urlResouce->updateResouce(array('is_exist' =>0),array('target'=>$target,'is_exist'=>1));
					sleep($sleep);
					//开始新循环，将之前置为2的状态返回到1（代表该链接依然活跃）
					$urlResouce->updateResouce(array('is_exist' =>1),array('target'=>$target,'is_exist'=>2));
					$page = 1;
					$max_break_num =10;
					$data = '时间：'.date("Y-m-d H:i:s").'爬虫类型：'.$target.'链接总量'.$urlCount.' urlQueCount：'.$urlQueCount.' urlResCount:'.$urlResCount."\r\n";
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
}