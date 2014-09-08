<?php
class fixCli extends backgroundCli{
    
	function actionHouse(){
		$kuaizuApi = new serverExt('ikuaizu_spider');
		
		$db = WinBase::app()->getDb();
        
		$sql = "SELECT count(id) as count FROM url_resouce_13_06 where q = 0";
		$row = $db->fetch($sql);
		if(!$row['count']){
            echo "stream $pid has closed :no data found ";
            exit(0);
		}
        
        $i = 0;
        while(1){
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
			$db->beginTransaction();
            $db->exec("UPDATE url_resouce_13_06 as a, (SELECT id FROM url_resouce_13_06 WHERE  q = 0  ORDER BY id ASC LIMIT 1) tmp SET q='1' WHERE a.id=LAST_INSERT_ID(tmp.id)");
            $lastId = $db->lastInsertId();
            $db->commit();
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT, true);            
            
            $q = $db->fetch("SELECT * FROM url_resouce_13_06 WHERE id=$lastId");
            if(empty($q)){
                echo "stream $pid has closed : no data found ";
                exit;
            }
            
			$i ++;
			
			if(!$q['house_guid']){
				continue;
			}
			
			$target_arr = explode('_',$q['target']);
			
			$source =  $target_arr[0];
			
			if($target_arr[1] == 'zhengzu'){
				$rent_type =  1;
			}else if($target_arr[1] == 'hezu'){
				$rent_type = $target_arr[2] == 'dj' ? 2 : 3;
			}
			
			$data  = array(
				'house_guid' => $q['house_guid'],
				'rent_type' => $rent_type,
				'source' => $source,
				'dateline' => $q['dateline']
			);
			
			$resp = $kuaizuApi->api()->house_fix($data);
			
			if(isset($resp['status']) && $resp['status'] == '0000'){
				echo "done ".$resp['data']['house_guid']."\r\n";
			}else{
				print_r($resp);
				
				//echo "skip {$district['district_name']}\r\n";
			}
			
			usleep(1000);			
        }		
	}
    
	function actionOldhouse(){
		$kuaizuApi = new serverExt('ikuaizu_spider');
		
		$db = WinBase::app()->getDb();
		
        
		$sql = "SELECT count(id) as count FROM url_resouce_13_05 where q = 0 and target !='anjuke_qu'";
		$row = $db->fetch($sql);
		if(!$row['count']){
            echo "stream $pid has closed :no data found ";
            exit(0);
		}
        
        $i = 0;
        while(1){
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
			$db->beginTransaction();
            $db->exec("UPDATE url_resouce_13_05 as a, (SELECT id FROM url_resouce_13_05 WHERE  q = 0  and target !='anjuke_qu' ORDER BY id ASC LIMIT 1) tmp SET q='1' WHERE a.id=LAST_INSERT_ID(tmp.id)");
            $lastId = $db->lastInsertId();
            $db->commit();
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT, true);            
            
            $q = $db->fetch("SELECT * FROM url_resouce_13_05 WHERE id=$lastId");
            if(empty($q)){
                echo "stream $pid has closed : no data found ";
                exit;
            }
            
			$i ++;
			
			$target_arr = explode('_',$q['target']);
			
			$doc = new spiderDoc($q['target']);		
			$doc->resouce = $q;
			
			if(!$q['download']){
				echo "no download ".$q['id']." \r\n";
			}

			if(!is_file(ROOT_PRO_PATH.'runtime'.DIRECTORY_SEPARATOR."html/".$q['filepath'])){
				echo "no file ".$q['id']." \r\n";
			}
		
			$html = file_get_contents(ROOT_PRO_PATH.'runtime'.DIRECTORY_SEPARATOR."html/".$q['filepath']);
			$doc->setHtmlResult($html);
			$html = null;
			
			$item = array('room','wc','floor','square','mobile','district');
			$data = $doc->getItems($item);
			
			if(empty($data)){
				echo "void ".$q['id']."\r\n";
			}else{
			
				$data['source'] =  $target_arr[0];
				
				if($target_arr[1] == 'zhengzu'){
					$data['rent_type'] =  1;
				}else if($target_arr[1] == 'hezu'){
					$data['rent_type'] = $target_arr[2] == 'dj' ? 2 : 3;
				}
				
				list($data['floor_on'],$data['floor_all']) = explode('/',$data['floor']);
				
				$data['dateline'] =  $q['dateline'];

				$res = $kuaizuApi->api()->house_fixold($data);
			
				if(isset($res['status']) && $res['status'] == '0000'){
					echo "[{$i}/{$row['count']}] parsed ".$doc->resouce['id']." ".$res['data']['house_guid']. "\r\n";
					$db->exec("UPDATE url_resouce_13_05 SET house_guid='".$res['data']['house_guid']."' WHERE id='".$q['id']."'");
				}elseif(isset($res['status']) && in_array($res['status'],array('111','222','333','444'))){
					
					if($res['status'] == '111'){
						echo "[{$i}/{$row['count']}] error ".$res['info']." ".$data['district']."\r\n";
					}else{
						echo "[{$i}/{$row['count']}] error ".$res['info']."\r\n";
					}
					
				}else{
					print_r($res);
					exit;
				}
			}
		
			$doc->clear();
			
			
			usleep(1000);			
        }		
	}	
}