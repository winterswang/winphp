<?php
class districtCli extends backgroundCli{
	
	function actionIndex($target){
		$kuaizuApi = new serverExt('ikuaizu_spider');
		$nodes = new spiderDoc($target);
		
		while(1){
			
			if($this->isStop()){
				break;
			}		
		
			$res = $kuaizuApi->api()->district_flush();
			if(!isset($res) || empty($res['data']) || $res['data'] == null){
				echo "No district";
				break;
			}

			$district= $res['data'];	
			//$keywaord = urlencode($district['district_name']);
			$url = 'http://shanghai.anjuke.com/community/W0QQkwZ'.$district['district_name'];
			
			//$url = 'http://shanghai.anjuke.com/community/W0QQkwZ宝钢九村';
			
			if($nodes->spider($url)){
				$html = $nodes->getHtmlResult(true);

				if($html != ''){
					$simpleDom = new simpleHtmlExt();
					$htmlDom = $simpleDom->str_get_html($html);
					$img_src = $htmlDom->find('img.thumbnail',0)->src;
					
					$photo = '';
					if(!preg_match('/nopic/i', $img_src)){
						$photo = str_replace('150x113','820x615',$img_src);
						$photo = str_replace('150x115','820x615',$photo);
						$photo = str_replace('display','display/anjuke',$photo);
					}
					//http://pic1.ajkimg.com/display/anjuke/a3ca4645489eeba56805cdd8dfae12ee/820x615.jpg
					$address_html = $htmlDom->find('address span',0)->innertext;
					$address_html = strip_tags($address_html);
					//[静安&nbsp;曹家渡]<em>康</em>定路1033号
					preg_match('/\[(.*)\](.*)/i', $address_html, $extmatches);
					
					$area_zone = $extmatches[1];
					$address = $extmatches[2];
					
					list($area,$zone) = explode("&nbsp;",$area_zone);
					
					$data  = array(
						'district_guid' => $district['district_guid'],
						//'district_guid' => 100002249,
						'area' => $area,
						'zone' => $zone,
						'address' => $address,
						'photo' => $photo
					);

					$resp = $kuaizuApi->api()->spider_district($data);
					
					if(isset($resp['status']) && $resp['status'] == '0000'){
						echo $resp['data']."\r\n";
						if(preg_match('/done/i', $resp['data'])){
							$nodes->setSuccess();
						}
					}else{
						print_r($resp);
						//echo "skip {$district['district_name']}\r\n";
					}
					$htmlDom->clear();
				}

			}else{
				echo "skip {$district['district_name']}\r\n";
			}

			usleep(2000);
		}
	}
}