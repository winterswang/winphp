<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="navbar-login nav_manage">
    <div class="login manager1 lg1" title="ftab1"><span>小区详情</span></div>
    <a href="/district/house?uuid=<?=$uuid?>&district_guid=<?=base64_encode($district_guid)?>&house_count=<?=$link['house_count']?>" target="_self"><div class="login store1" title="ftab2"><span>小区房源</span></div></a>
    <div style="clear: both"></div>
</div>    
<div class="main_content" id="ftab1">
    <!--
    <div class="subscribe image_list">
    <div class="image_list1">
     <div class="swiper-container">
        <div class="swiper-wrapper">
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        <div class="swiper-slide"><img class="image_item" src="/img/test1.png"></div>
        </div>
        <div class="pagination" style="display:none;"></div>
    </div>
    </div>  
    </div>
-->
    <div class="house_title">
        <h1><?=$link['district_name']?></h1>
    </div>
    <div class="subscribe">
        <table class="msg_table hd2" width="100%">
            <tr>
                <td width="50%" height="25px"><b>均价：</b><font color="#f4775a"><span style="font-size:17px;"><?=number_format($link['house_price']/10000,1)?></span>万/平米</font></td>
                <td width="50%"><b>二手房：</b><?=$link['house_count']?>套</td>
            </tr>
            <tr>
                <td width="50%" height="25px"><b>占地面积：</b><?=$link['total_area']?></td>
                <td width="50%"><b>建筑面积：</b><?=$link['build_square']?></td>
            </tr>
            <tr>
                <td width="50%" height="25px"><b>容积率：</b><?=$link['floor_rate']?></td>
                <td width="50%"><b>绿化率：</b><?=$link['green_rate']?></td>
            </tr>
            <tr>
                <td width="50%" height="25px"><b>建筑年代：</b><?=$link['build_time']?></td>
                <td width="50%"><b>地址：</b><?=$link['address']?></td>
            </tr>
            <!--    
            <tr>
                <td height="25px" width="50%" colspan="2"><b style="vertical-align: top;">热门指数：</b><span><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"></span></td>
            </tr>
        -->
        </table>
    </div>
    <!--
    <div class="subscribe">
        <div class="dis_phone">
            <div class="dis_ph1"><b>小区居委会电话：</b>010-85467821</div>
            <div class="dis_ph2"><a href="tel:010-85467821"><img width="42" height="42" src="/img/tel.png"></a></div>
        </div>
    </div>
-->
    <div class="whitebox school layout">
        <div class="hx dis_msg"><b>对应学校：</b></div><br/>
        <table class="msg_table sh_msg" width="100%" id="tb1">
            <!--
            <tr class="sh sh1">
                <td width="100%" colspan="3" class="sh2"><b>对应学校：</b></td>
            </tr>
            <tr class="sh1">
                <td width="60%" height="40px" class="sh2"><b>中国人民大学附属小学</b></td>
                <td width="20%" height="40px">重点</td>
                <td width="60%" height="40px" align="center">一级</td>
                <td width="30%" height="40px"><img width="20" height="20" src="/img/district/btn_right.png"></td>
            </tr>
            <tr class="sh1">
                <td width="60%" height="40px" class="sh2"><b>北京第八十小学</b></td>
                <td width="20%" height="40px">重点</td>
                <td width="60%" height="40px" align="center">一级</td>
                <td width="30%" height="40px"><img width="20" height="20" src="/img/district/btn_right.png"></td>
            </tr>
            <tr class="sh1">
                <td width="60%" height="40px" class="sh2"><b>苏州街第一小学</b></td>
                <td width="20%">市重点</td>
                <td width="60%" align="center">一级</td>
                <td width="30%"><img width="20" height="20" src="/img/district/btn_right.png"></td>
            </tr>
            <tr class="sh1">
                <td width="60%" height="40px" class="sh2"><b>中国人民大学附属中学</b></td>
                <td width="20%">市重点</td>
                <td width="60%" align="center">一级</td>
                <td width="30%"><img width="20" height="20" src="/img/district/btn_right.png"></td>
            </tr>
            <tr class="sh sh1">
                <td width="60%" height="40px" class="sh2"><b>小太阳幼儿园</b></td>
                <td width="20%">重点</td>
                <td width="60%" align="center">一级</td>
                <td width="30%"><img width="20" height="20" src="/img/district/btn_right.png"></td>
            </tr>
            -->
            <?php if(isset($xuequ)){foreach($xuequ as $school){ ?>
            <tr class="sh1 sh3" width="100%" href="/school/intro?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($school['xuequ_guid'])?>">
                <td width="75%" height="40px" class="sh2"><b><?=$school['school_name']?></b></td>
                <td width="40%"><?=$school['school_level']?></td>
                <td width="20%" align="left"><img width="20" height="20" src="/img/district/btn_right.png"></td>
            </tr>
            <?php }}else{?>
            <tr></tr>
            <?php }?>
        </table>
    </div>
    
    <div class="subscribe dis_nearly layout">
        <div class="dis_msg">
            <div class="hx dis_msg"><b>周边：</b></div><br/>
            <div><b>商业：</b><span>工商银行&nbsp;&nbsp;&nbsp;交通银行&nbsp;&nbsp;&nbsp;北京银行</span></div><br/>
            <div>
                <div style="overflow:hidden;"><b>交通：地铁</b><span>（十号线苏州街站A口出左拐直走300米）</span></div>
                <div style="overflow:hidden;"><b><span style="visibility:hidden;">交通：</span>公交</b><span>（运通110&nbsp;118&nbsp;905&nbsp;到北京市地震局站201 403到苏州街站 308 697 到81中学站）</span></div>
            </div><br />
            <div><b>医疗：</b><span>北京第一人民医院&nbsp;同仁堂大药房&nbsp;解放军空军疗养院&nbsp;海淀区人民医院&nbsp;北京精神病院海淀分院</span></div><br />
            <div><b>其它：</b><span>莫泰168酒店&nbsp;假日之星酒店&nbsp;如家连锁酒店&nbsp;金融潭大酒店&nbsp;大振利菜场&nbsp;家乐福超市</span></div>
        </div>
    </div>
    
    <div class="mapView">
        <div class="map1"><img src="http://api.map.baidu.com/staticimage?width=400&height=200&center=<?=$link['district_name']?>&markers=<?=$link['lng']?>,<?=$link['lat']?>&zoom=16&markerStyles=m,A,0xff0000" alt=""></div>
    </div>
    <div class="subscribe district">
        <a href="http://api.map.baidu.com/marker?location=<?=$link['lat']?>,<?=$link['lng']?>&title=<?=$link['district_name']?>&content=<?=$link['district_name']?>&output=html&src=爱居网络|微搜房" target="_self"><div class="map2"><div class="disMap2"><img src="/img/district/pin.svg"></div><div class="disMap2"><?=$link['address']?></div><div class="disMap3"><img width="20" height="20" src="/img/district/btn_right.png"></div></div></a>
    </div>
    <!--
    <div class="whitebox other_dis">
        <div class="dis_msg other"><b>对应学校的其它小区：</b></div>
        <div class="whitebox">
            <div class="list_item">
                <div style="width:30%"><img class="image_item left_image" src="/img/test1.png"></div>
                <div  style="width:72%"class="house_summary">
                    <div class="title">立方庭</div>
                    <div class="house_area"><div class="zs">在售房源：120套</div><div class="pm">47831元/平米</div></div>
                    <div class="dis_location"><div><img src="/img/district/dis_mark.png"></div><div class="dis_msg">北京市海淀区海淀南路233号</div><div style="clear: both"></div></div>
                </div>
                <div style="clear: both"></div>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="whitebox other1">
            <div class="list_item">
                <div style="width:30%"><img class="image_item left_image" src="/img/test1.png"></div>
                <div  style="width:72%"class="house_summary">
                    <div class="title">立方庭</div>
                    <div class="house_area"><div class="zs">在售房源：120套</div><div class="pm">47831元/平米</div></div>
                    <div class="dis_location"><div><img src="/img/district/dis_mark.png"></div><div class="dis_msg">北京市海淀区海淀南路233号</div><div style="clear: both"></div></div>
                </div>
                <div style="clear: both"></div>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="whitebox other1 other2">
            <div class="list_item">
                <div style="width:30%"><img class="image_item left_image" src="/img/test1.png"></div>
                <div  style="width:72%"class="house_summary">
                    <div class="title">立方庭</div>
                    <div class="house_area"><div class="zs">在售房源：120套</div><div class="pm">47831元/平米</div></div>
                    <div class="dis_location"><div><img src="/img/district/dis_mark.png"></div><div class="dis_msg">北京市海淀区海淀南路233号</div><div style="clear: both"></div></div>
                </div>
                <div style="clear: both"></div>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="moreDistrict">
            <div class="dis_msg"><span>查看更多对应小区</span></div>
        </div>
    </div>
-->
</div>
</div>
</div>
<script type="text/javascript">
  var mySwiper = new Swiper('.swiper-container',{
    pagination: '.pagination',
    paginationClickable: true,
    slidesPerView: 'auto',
    loop: false,
  });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        (function() {
            var showDistance = 100;//距离顶端多少距离开始显示go-top
            var $backToTopEle = $('<div class="backToTop"><img src="/img/district/go-top.png" /></div>').appendTo($("body")).click(function() {
                    $("html, body").animate({ scrollTop: 0 }, 120);
            }), $backToTopFun = function() {
                var st = $(document).scrollTop(), winh = $(window).height();
                (st > showDistance)? $backToTopEle.show("fast"): $backToTopEle.hide("fast");    
                //IE6下的定位
                if (!window.XMLHttpRequest) {
                    $backToTopEle.css("top", st + winh - 166);    
                }
            };
            $(window).bind("scroll", $backToTopFun);
            $(function() { $backToTopFun(); });
        })();
        /*
        $(".navbar-login .lg1").bind('mouseover',function(){
            $(this).removeClass('store store1').addClass("manage manager1");
            $(".navbar-login .lg2").removeClass("manager manager1").addClass("store1");
            var ftab = $(this).attr("title");
            $("#" + ftab).show().siblings(".main_content").hide();
        })
		*/
		$('.msg_table .sh3').bind('click',function(){
        window.location = $(this).attr('href');
        return false;
    	});
    	
        /*
        $(".navbar-login .lg2").bind('mouseover',function(){
            $(this).removeClass('store store1').addClass("manage1 manager");
            $(".navbar-login .lg1").removeClass("manager manager1").addClass("store");
            var ftab = $(this).attr("title");
            $("#" + ftab).show().siblings(".main_content").hide();
        })
        */
    })

    window.onload = function(){
        var tbl = document.getElementById("tb1")
        tbl.querySelector("tr:last-child").style.borderBottom = "none";
    }
</script>
<?php $this->render('common/footer'); ?>