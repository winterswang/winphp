<?php
class buildDistrictCli extends BaseCli{
    
    function actionMoli(){
       // ob_start();
        
        $pid = posix_getpid();
        echo 'Run at pid: '.$pid."\n";
        
        $db = WinBase::app()->getDb();
        
        $count = moli::model()->getCount();
        if(!$count){
            echo "stream $pid has closed : no data found ";
            exit;
        }
        
        $pinyin = WinBase::app()->loadClass(array('class'=>'pinyinExt','filePath'=>ROOT_PRO_PATH.'/ext/pinyin/pinyinExt.php'));

        $i = 0;
        while(1){
            //ob_clean();
 
            $q = moli::model()->shift();
            if(empty($q)){
                echo "stream $pid has closed : no data found ";
                exit;
            }
            
            $i ++;
    
            $sql = "SELECT * FROM common_area where title='".$q['area_name']."' and area_id=0";
            $row = $db->fetch($sql);
            if(empty($row)){
                $area_slug = $pinyin->getPinyin($q['area_name']);
                $area_id = $db->insert('common_area',array('title'=>$q['area_name'],'area_id'=>0,'slug'=>$area_slug),true);
            }else{
                $area_id = $row['id'];
            }
            
            $sql = "SELECT * FROM common_area where title='".$q['zone_name']."' and area_id=".$area_id;
            $row = $db->fetch($sql);
            
            if(empty($row)){
                $zone_slug = $pinyin->getPinyin($q['zone_name']);
                $zone_id = $db->insert('common_area',array('title'=>$q['zone_name'],'area_id'=>$area_id,'slug'=>$zone_slug),true);
            }else{
                $zone_id = $row['id'];
            }

            $district_info = array(
                'district_name' => $q['district_name'],
                'district_address' => '上海,'.$q['area_name'].','.$q['address'],
                'slug' => $pinyin->getPinyin($q['district_name']),
                'city_id' => 1,
                'area_id' => $area_id,
                'zone_id' => $zone_id,
                'lat' => $q['latitude'],
                'lng' => $q['longitude'],
                'createtime' => TIMESTAMP,
                'updatetime' => TIMESTAMP	 	 
            );
            
            if(!($guid = district::model()->addDistrict($district_info))){
                moli::model()->updateMoli(array('status'=>3),array('district_id'=>$q['district_id']));
                continue;
            }
            
            $district_detail = array(
                'district_guid' => $guid, 
                'district_name' => $q['district_name'],
                'district_address' => $district_info['district_address'],
                'area_ratio' => $q['area_ratio'],
                'greening_rate' => $q['greening_rate'],
                'construction_area' => $q['construction_area'],
                'homes_total' => 0,
                'buildings_total' => 0,
                'parking_num' => 0,
                'build_age' => 0,
                'developer' => $q['developer'],
                'management_fee' => 0,
                'management_company' => '',
                'introduction' => ''
            );
            
            district::model()->addDistrictDetail($district_detail);
            
            $around = array();
            if(!empty($q['traffic']) && $q['traffic'] != '-'){
               $around['traffics'] = explode(',',$q['traffic']);
            }

            if(!empty($q['school']) && $q['school'] != '-'){
               $around['schools'] = explode(',',$q['school']);
            }
            
            if(!empty($q['hospital']) && $q['hospital'] != '-'){
               $around['hospitals'] = explode(',',$q['hospital']);
            }
            
            if(!empty($q['supermarket']) && $q['supermarket'] != '-'){
               $around['supermarkets'] = explode(',',$q['supermarket']);
            }
            
            if(!empty($q['bank']) && $q['bank'] != '-'){
               $around['banks'] = explode(',',$q['bank']);
            }
            
            $temp = array(
                'district_guid' => $guid,
                'status' => 0,
                'around' => serialize($around)
            );
            
            district::model()->addDistrictAroundTemp($temp);
            
            echo " has build $i/$count : $guid \n\r";
            usleep(500);
        }
    }
    
    function actionAnjuke(){
                
        $pid = posix_getpid();
        echo 'Run at pid: '.$pid."\n";
        
        $count = anjuke::model()->getCount();
        if(!$count){
            echo "stream $pid has closed : no data found ";
            exit;
        }
        
        $db = WinBase::app()->getDb();
        $pinyin = WinBase::app()->loadClass(array('class'=>'pinyinExt','filePath'=>ROOT_PRO_PATH.'/ext/pinyin/pinyinExt.php'));

        $i = 0;       
        
        while(1){
            //ob_clean();
 
            $q = anjuke::model()->shift();
            if(empty($q)){
                echo "stream $pid has closed : no data found ";
                exit;
            }
            
            $i ++;
            
            if(trim($q['district_name']) == ''){
                anjuke::model()->updateMoli(array('status'=>4),array('district_id'=>$q['district_id']));
                continue;
            }
            
            $sql = "SELECT * FROM common_area where slug='".$q['area_name']."' and area_id=0";
            $area_row = $db->fetch($sql);
            if(empty($area_row)){
                echo $sql;exit;
                anjuke::model()->updateMoli(array('status'=>2),array('district_id'=>$q['district_id']));
                continue;
                //$area_slug = $pinyin->getPinyin($q['area_name']);
                //$area_id = $db->insert('common_area',array('title'=>$q['area_name'],'area_id'=>0,'slug'=>$area_slug),true);
            }
            
            $sql = "SELECT * FROM common_area where slug='".$q['zone_name']."' and area_id=".$area_row['id'];
            $zone_row = $db->fetch($sql);

            if(empty($zone_row)){
                echo $sql;
                exit;
                anjuke::model()->updateMoli(array('status'=>3),array('district_id'=>$q['district_id']));
                continue;                
                //$zone_slug = $pinyin->getPinyin($q['zone_name']);
                //$zone_id = $db->insert('common_area',array('title'=>$q['zone_name'],'area_id'=>$area_id,'slug'=>$zone_slug),true);
            }
            
            $slug = $pinyin->getPinyin($q['district_name']);
            
                if(strpos($q['manage_fee'],'.') !== false  && 0 < preg_match('/([1-9]\d*\.\d*|0\.\d*[1-9]\d*)*/i', $q['manage_fee'], $extmatches)){
                    $management_fee = $extmatches[1];
                }else if(0 < preg_match('/(\d{1,3})*/i', $q['manage_fee'], $extmatches)){
                    //print_r($extmatches);
                    $management_fee = $extmatches[1];
                }else {
                    $management_fee = 0;
                }
                
                if(!$management_fee){
                    $management_fee = 0;
                }
                
                if(!empty($q['complete_time'])){
                    $data = explode('-',$q['complete_time']);
                    $build_age = date('Y') - $data[0];                    
                }else{
                    $build_age = 0;
                }            
            
            
           
            
            $district = district::model()->getInfo(array('slug'=>$slug));

            if(empty($district)){

                $district_info = array(
                    'district_name' => $q['district_name'],
                    'district_address' => '上海,'.$area_row['title'].','.$q['address'],
                    'slug' => $slug,
                    'city_id' => 1,
                    'area_id' => $area_row['id'],
                    'zone_id' => $zone_row['id'],
                    'lat' => $q['latitude'],
                    'lng' => $q['longitude'],
                    'createtime' => TIMESTAMP,
                    'updatetime' => TIMESTAMP	 	 
                );
                
                if(!($guid = district::model()->addDistrict($district_info))){
                    anjuke::model()->updateMoli(array('status'=>4),array('district_id'=>$q['district_id']));
                    continue;
                }
                
                $district_detail = array(
                    'district_guid' => $guid, 
                    'district_name' => $q['district_name'],
                    'district_address' => '上海,'.$area_row['title'].','.$zone_row['title'].','.$q['address'],
                    'area_ratio' => $q['area_ratio'],
                    'greening_rate' => $q['greening_rate'],
                    'construction_area' => $q['construction_area'],
                    'homes_total' => $q['house_num'],
                    'buildings_total' => 0,
                    'parking_num' => $q['park_num'],
                    'build_age' => $build_age,
                    'developer' => $q['developer'],
                    'management_fee' => $management_fee,
                    'management_company' => $q['manage_company'],
                    'introduction' => ''
                );
                
                district::model()->addDistrictDetail($district_detail);

            }else{

                $guid = $district['district_guid'];
                
                $district_detail = array(
                    'area_ratio' => $q['area_ratio'],
                    'greening_rate' => $q['greening_rate'],
                    'construction_area' => $q['construction_area'],
                    'homes_total' => $q['house_num'],
                    'buildings_total' => 0,
                    'parking_num' => $q['park_num'],
                    'build_age' => $build_age,
                    'developer' => $q['developer'],
                    'management_fee' => $management_fee,
                    'management_company' => $q['manage_company'],
                    'introduction' => ''
                );
                
                district::model()->updateDistrictDetail($district_detail,array('district_guid'=>$q['district_guid']));
            }
            

            $db->exec("DELETE FROM anjuke_info WHERE district_id = ". $q['district_id']);
            
            /*
            $around = array();
            if(!empty($q['traffic']) && $q['traffic'] != '-'){
               $around['traffics'] = explode(',',$q['traffic']);
            }

            if(!empty($q['school']) && $q['school'] != '-'){
               $around['schools'] = explode(',',$q['school']);
            }
            
            if(!empty($q['hospital']) && $q['hospital'] != '-'){
               $around['hospitals'] = explode(',',$q['hospital']);
            }
            
            if(!empty($q['supermarket']) && $q['supermarket'] != '-'){
               $around['supermarkets'] = explode(',',$q['supermarket']);
            }
            
            if(!empty($q['bank']) && $q['bank'] != '-'){
               $around['banks'] = explode(',',$q['bank']);
            }
            
            $temp = array(
                'district_guid' => $guid,
                'status' => 0,
                'around' => serialize($around)
            );
            
            district::model()->addDistrictAroundTemp($temp);
            */
            echo " has build $i/$count : $guid \n\r";
            usleep(3000);
        }
    }    
    
    function actionBuildAround(){
        
        $pid = posix_getpid();
        echo 'Run at pid: '.$pid."\n";
        
        $db = WinBase::app()->getDb();
 
		$sql = "SELECT count(id) as count FROM district_around_tmp where status = 0";
		$row = $db->fetch($sql);
		if(!$row['count']){
            echo "stream $pid has closed :no data found ";
            exit(0);
        }
        
        $count = $row['count'];
        
        $pinyin = WinBase::app()->loadClass(array('class'=>'pinyinExt','filePath'=>ROOT_PRO_PATH.'/ext/pinyin/pinyinExt.php'));
        
        $i = 0;
        while(1){
            $db->exec("UPDATE district_around_tmp as a, (SELECT id FROM district_around_tmp WHERE status='0'  ORDER BY id ASC LIMIT 1) tmp SET status='1' WHERE a.id=LAST_INSERT_ID(tmp.id)");
            $lastId = $db->lastInsertId();
            
            $q = $db->fetch("SELECT * FROM district_around_tmp WHERE id=$lastId");
            if(empty($q)){
                echo "stream $pid has closed : no data found ";
                exit;
            }
            
            $i ++;
            
            $around = unserialize($q['around']);
            if(empty($around)){
                echo " skipping $lastId\n\r";
                continue;
            }
            
            foreach($around as $type => $arr){
                
                if($type == 'traffics'){
                    continue;//暂不处理交通数据
                }
                
                foreach($arr as $value){
                    $value = trim($value);
                    if(empty($value) || $value == '-'){
                        continue;
                    }

                    $tables =  $this->getAroundTable($type);
                    $sql = "SELECT * FROM ".$tables['common']." where title='{$value}'";
                    $row = $db->fetch($sql);
                    if(empty($row)){
                        $cid =  $db->insert($tables['common'],array('title'=>$value,'slug'=>$pinyin->getPinyin($value)),true);
                    }else{
                        $cid = $row['id'];
                    }
                    
                    $sql = "SELECT count(*) as count FROM district_around where district_guid=".$q['district_guid']." and id='".$cid."' and type ='".$type."'";
                    $row = $db->fetch($sql);
                    if(!$row['count']){
                        $db->insert('district_around',array('title'=>$value,'id'=>$cid,'type'=>$type,'district_guid'=>$q['district_guid']));
                    }
                }
            }

            echo " has build $i/$count\n\r";
            usleep(3000);    
        }
    }
    
    function getAroundTable($key){
        $tables = array(
            'traffics' => array(
                    'common' =>'common_subway',
                    'around' => 'district_around_subway'
            ),
            'schools' => array(
                    'common' =>'common_school',
                    'around' => 'district_around_school'
            ),
            'hospitals' => array(
                    'common' =>'common_hospital',
                    'around' => 'district_around_hospital'
            ),             
            'supermarkets' => array(
                    'common' =>'common_market',
                    'around' => 'district_around_market'
            ),
            'banks' => array(
                    'common' =>'common_bank',
                    'around' => 'district_around_bank'
            ),             
        );
        
        return $tables[$key];
    }

}
