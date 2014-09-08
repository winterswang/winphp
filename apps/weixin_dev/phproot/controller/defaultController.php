<?php
class defaultController extends WeixinController
{
    
    public function actionIndex($obj){}  

    public function actionImage($obj)
    {
        $res = $this->api('photo_upload_url',$obj->FromUserName,$obj->PicUrl);
        if(isset($res['error'])){
            file_put_contents("/tmp/uploadError.log", implode($res));
            $this->respond_text('图片上传失败，请重试');
        }
        //file_put_contents("/tmp/$obj->FromUserName.log", $obj->PicUrl."\r\n",FILE_APPEND);
        $count = $this->api('photo_getCount',array('house_guid'=>10000,'uid'=>$obj->FromUserName));
        $news[] =  array(
            'title' => "已上传".$count."图片",
            'picurl'=> $obj->PicUrl,
            'url'=> $obj->PicUrl,
        );        
        $system_setting = Config::getConfig('system');
        $news[] =  array(
                'title' => "点击此链接发房或继续发照片",
                'url'=> $system_setting['host_url'].'/house/publish?uuid='.$obj->FromUserName.'&'.http_build_query($arrParams),
        );      
        
        $this->respond_news($news);       
    }

    private function pretreatmentKeyword( $keyword )
    {
        $keyword = strtolower($keyword);
        $keyword_hacks = Config::getConfig('weixin','keywords');
        foreach($keyword_hacks as $target=>$words){
            if(in_array($keyword, $words)){
                return $target;
            }
        }
        
        if(is_numeric($keyword) && strlen($keyword) == 9){
            return 'house';
        }

        return null;
    }
   
    public function actionText($obj){

        $keyword = strtolower($obj->Content);
        
        if(empty($keyword)){
            $this->respond_text($this->getHelp());
        }
        
        $system_setting = Config::getConfig('system');
        
        switch($keyword){
            case'l':
                $houseList = $this->api('house_getList',array('uid'=>$obj->FromUserName));
                foreach ($houseList as $key => $value) {
                    $news[] =  array(
                        'title' => '已发布的房源',
                        'picurl'=>  $system_setting['attach_url'].'/'.$value['photoList'][0]['attachment'],
                        'url'=> $system_setting['host_url']."/house/houseInfo?uuid=".$obj->FromUserName."&house_guid=".$value['house_guid']
                        );
                }
                file_put_contents('/tmp/houseList.log', $news[0]['url']);
                $this->respond_news($news);
                break;
            case 'd':
                $houseList = $this->api('house_getList',array('house_guid'=>1000000039));
                foreach ($houseList as $key => $value) {
                    $news[] =  array(
                        'title' => '房源案例',
                        'picurl'=>  $system_setting['attach_url'].'/test/201311/07/230010jci5auhcap9amjgg.jpg',
                        'url'=> $system_setting['host_url']."/house/houseInfo?uuid=ozEiwjvB7OuYRuk4sSk_YzJ46bG4&house_guid=1000000039"
                        );
                }
                file_put_contents('/tmp/houseList.log', $news[0]['url']);
                $this->respond_news($news);                
                break;
            default:
                break;
        }
    }

    public function actionLink($obj){}
    
    public function actionLocation($obj){
 
        $arrParams = array(
            'searchby' => 'xy',
            'lat' => (float)$obj->Location_X,
            'lng' => (float)$obj->Location_Y,
            'radius' => 1000
        );

        $res = $this->api('search_house', $arrParams, 1,4);

        if(isset($res['error']) || !$res['length']){
            $this->respond_text(Config::getConfig('weixin','locationNotFind'));
        }
        
        $system_setting = Config::getConfig('system');
        
        $news = array();
        foreach($res['data'] as $v){
            $i = array();
            $price = $v['rent_price'];
            if($price == 0){
                $price = '-';
            }
            //价格为0，改为字符'-'
            $i['title'] = $v['house_intro']."\n".$price .' /月 ' .($v['rent_period']==1 ? "整租": $v['rent_period']==2 ? "合租" : "床位");
            //$i['description'] = $v['house_intro'];
            $i['picurl'] = $v['photo_list'][0]['url'];
            $i['url'] = $system_setting['host_url'].'/house/info?uuid='.$obj->FromUserName.'&house_guid='.$v['house_guid'];
            $news[] = $i;
        }
        
        if(count($news > 3)){
            $news[] = array(
                'title' => '查看更多',
                //'picurl'=> $system_setting['static_url'].'/img/list_more.gif',
                'url'=> $system_setting['host_url'].'/search/house?uuid='.$obj->FromUserName.'&'.http_build_query($arrParams),
            );
        }
        
        return $this->respond_news($news);
    }
    
    public function actionEvent($obj){
        
    }

    public function actionNavigation($obj){
        $eventKey = $obj->EventKey;
        
        $system_setting = Config::getConfig('system');
        $navShow = array();
        switch($eventKey){
            case 'KZ001_SEARCH':
                $navShow = array(
                    array(
                          "title"=>Config::getConfig('weixin','findhouse'),
                    ),
                    array(
                          'title'=>"查看找房帮助",
                          "url"=>$system_setting['host_url'].'/system/help?uuid='.$obj->FromUserName."&type=search",
                    )                   
                );
                break;
            case 'KZ001_PUBLISH':
                
                $res = $this->api('system_preload');
                if(isset($res['error'])){
                    $links[] = array(
                        'title' => '返回上一页',
                        'href' => 'javascript:history.go(-1)',
                    );            
                    $this->showMessage($res['msg'],0,$links);
                }
                
                if(!empty($res['user_house']) && count($res['user_house']) >= $res['max_post']){
                    $navShow = array(
                        array(
                              "title"=>"您已经发过房源",
                        ),
                        array(
                              'title'=>"进入我的房源",
                              "url"=>$system_setting['host_url'].'/my/rent?uuid='.$obj->FromUserName,
                        )                   
                    );
                }else{
                    $cache = new CacheFile('upload');
                    $cache_data = $cache->get($obj->FromUserName,'upload_'); 
                    $data_count = count($cache_data);  
                    $news = array();
                    if($data_count > 0 ){
                        foreach($cache_data as $pic){
                        $news[] =  array(
                                'title' => "已上传图片",
                                //'description' => '可以继续发照片,也可以进入第二步',
                                'picurl'=> $pic,
                                'url'=> $pic,
                            );
                        }
                        
                        $system_setting = Config::getConfig('system');
                        $news[] =  array(
                                'title' => "进入第二步或继续发照片",
                                'url'=> $system_setting['host_url'].'/house/publish?uuid='.$obj->FromUserName.'&'.http_build_query($arrParams),
                        );
                        $this->respond_news($news); 

                    }
                    else{
                        $navShow = array(
                        array(
                              "title"=>Config::getConfig('weixin','sendHouse'),
                        ),
                        array(
                              'title'=>"查看发房帮助",
                              "url"=>$system_setting['host_url'].'/system/help?uuid='.$obj->FromUserName."&type=publish",
                        )                   
                        );
                    }
                    
                }

                break;
            case 'KZ001-MYSAVE':
                $navShow = array(
                    array(
                          "title"=>"点击查看收藏和预约房源",
                        ),
                    array(
                          "title"=>"我的收藏",
                          "url"=> $system_setting['host_url'].'/my/collect?uuid='.$obj->FromUserName,
                    ),
                    array(
                          "title"=>"我的预约",
                          "url"=> $system_setting['host_url'].'/my/reserve?uuid='.$obj->FromUserName,
                    )
                );
            
            break;
            case 'KZ001-MYHOUSE':
                $navShow = array(
                    array(
                        "title"=>"点击查看我的房源及预约情况",
                        ),
                    array(
                          "title"=>"我的房源",
                          "url"=> $system_setting['host_url'].'/my/rent?uuid='.$obj->FromUserName,
                    )
                );
                break;
            case 'KZ001-FEEDBACK':
                
                $navShow = array(
                    array(
                        "title"=>"您的反馈，是我前进的动力。",
                    ),
                    array(
                        "title"=>"我来说两句",
                        'url' => $system_setting['host_url'].'/system/feedback?uuid='.$obj->FromUserName
                    )
                );
                break;
            case 'KZ001-HELP':
                
                $navShow = array(
                    array(
                         "title"=>"快租找房秘籍",
                         'picurl'=> "http://wx.ikuaizu.com/img/weixinpinw.jpg",
                         "url"=>"http://wx.ikuaizu.com/img/weixinpinw.jpg",
                    ),
                    array(
                          "title"=>"如何找房 ?",
                          "url"=> $system_setting['host_url'].'/system/help?uuid='.$obj->FromUserName.'&type=search',
                    ),
                    array(
                          "title"=>"如何发房 ?",
                          "url"=> $system_setting['host_url'].'/system/help?uuid='.$obj->FromUserName.'&type=publish',
                    ),
                    array(
                          "title"=>"如何预约看房 ?",
                          "url"=> $system_setting['host_url'].'/system/help?uuid='.$obj->FromUserName.'&type=reserve',
                    ),
                    array(
                        'title' => "快租是否收中介费 ?",
                        'url' => $system_setting['host_url'].'/system/help?uuid='.$obj->FromUserName.'&type=agent',
                    ),
                    array(
                          "title"=>"会泄露我的隐私吗 ?",
                          "url"=> $system_setting['host_url'].'/system/help?uuid='.$obj->FromUserName.'&type=protect',
                    ),
                    array(
                          "title"=>"关于快租",
                          "url"=> $system_setting['host_url'].'/system/help?uuid='.$obj->FromUserName.'&type=aboutus',
                    ),                    
                );
                $this->respond_news($navShow);
                break;            
            default:
                break;
        }
        
        if(is_array($navShow)){
            $arr = array();
            foreach($navShow as $n){
                if(isset($n['url'])){
                   $arr[] = "<a href=\"".$n['url']."\">".$n['title']."</a>";
                }else{
                   $arr[] = $n['title'];
                }
            }
            ///三个回车符，内容是文字+链接的拼接
            $this->respond_text(join("\n\n\n",$arr));
        }else{
            $this->respond_text($navShow);
        }

        
        //$this->respond_news($navShow);
    }

    public function actionSubscribe($obj){

        $respon_text = $this->getWelcome();
        $this->respond_text($respon_text);
    }    
    
    public function actionUnsubscribe($obj){

    }

}