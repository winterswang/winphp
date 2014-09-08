<?php $this->render('common/header'); ?>
<div class="docbody">
<!--    
<div class="whitebox tophead">	
	<div class="bk">
	    <div class="dis_msg tophead"><a onclick="javascript:history.back();"><div class="im"><img src="/img/district/btn_back.png" width="45" heigh="45"></div></a><div class="xq"><span><?=$link['title']?>...</span></div></div>
	</div>
</div>
-->		
<div class="main_content">
    <?php if(!empty($image_list)):?>
	<div class="subscribe image_list">
	<div class="image_list1">
	<div class="swiper-container">
	 	<div class="swiper-wrapper" style="padding:0px;width:100%;">
        <?php foreach($image_list as $image): ?>    
		<div class="swiper-slide"><img class="image_item" width="90px" height="90px" src="<?=$path . '/' . $image?>"></div>
        <?php endforeach; ?>
		</div>
	</div>
	</div>
	</div>
    <?php else:?>
    <?php endif;?>
	<div class="house_title">
		<div class="title_name"><h1><?=$link['title']?></h1></div>
		<div class="house_labels">
        <?php if(is_array($label)){ foreach($label as $v){?>
		<div class="label_list">
            <span><?=$v?></span>
		</div>
        <?php }}else{?>
        &nbsp;
        <?php }?>
        <!--
		<div class="collect" id="cohouse">收藏房源</div>
    -->
        <div class="star" id="cohouse"><img src="/img/district/star.png" width="30" height="30" alt=""></div>
        <div id="col_tip" class='tip' style="display:none;">
            <img src="/img/district/yes.png" width="40px" height="40px" />
            <div>收藏成功</div>
        </div>
        <div style="clear: both"></div>
		</div>
	</div>
	<div class="subscribe">
		<table class="msg_table hd2" width="100%">
			<tr>
				<td width="50%" height="25px"><b>总价：<font color="#f4775a"><span style="font-size:17px;"><?=$link['sell_price']?></span></font></b>万</td>
				<td width="60%">
                    <b>单价：<span style="font-size:17px;"><?=number_format($link['mm_price']/10000,1)?></span></b>万/平米</td>
			</tr>
			<tr>
				<td width="50%" height="25px">
                    <b>首付：</b><?=$link['first_payment']?>万</td>
				<td width="60%">
                    <b>月供：</b><?=number_format($link['month_payment']/10000,1)?>万</td>
			</tr>
			<tr>
				<td width="50%" height="25px">
                    <b>面积：</b><?=$link['square']?>平米</td>
				<td width="60%">
                    <b>户型：</b><?=$link['room']?>室<?=$link['hall']?>厅</td>
			</tr>
			<tr>
				<td width="50%" height="25px">
                    <b>楼层：</b><?=$link['floor_all']?>层</td>
				<td width="60%">
                    <b>朝向：</b><?=$link['orientation']?></td>
			</tr>
			<tr>
				<td width="100%" colspan="2" height="25px"><b>小区</b>：</b><?=$link['district_name']?></td>
			</tr>
            <!--	
            <tr>
                <td width="100%" colspan="2" height="25px"><b style="vertical-align: top;">热门指数：</b><span><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"></span></td>
            </tr>
        -->
		</table>
	</div>
    <!--
	<div class="subscribe">
	<div class="detail_msg text_des">
	<p><span>1.产权情况：满五唯一有房本，业主不在北京，看好房可交定金，业主回来签约</span></p>
	<p><span>2.房屋特色：正规4居室，两卧客厅朝南，两次卧朝北，厨房朝北，送一保姆间，豪华装修，可以拎包入住，客厅宽阔45平左右，进深小，给您和家人充足的阳光和健康</span></p>
	</div>
	</div>
    -->
    <?php if(!empty($houseImage)):?>
	<div class="subscribe layout">
		<div class="hx dis_msg"><b>户型图：</b></div>
		<div class="hxt"><a href='javascript:location.href="/pic/showurl?pic=<?=base64_encode($houseImage['pic_url'])?>"'> <img src="<?=$path . '/' . $houseImage['pic_url']?>"></a></div>
	</div>
    <?php else:?>
    <?php endif;?>
	<div class="whitebox school layout">
        <div class="hx dis_msg"><b>对应学校：</b></div><br/>
        <table class="msg_table sh_msg" width="100%" id="tb1">
            <!--
            <tr class="sh sh1">
                <td colspan="3" class="sh2"><b>对应学校：</b></td>
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
            -->
            <?php foreach($xuequ as $school): ?>
            <tr class="sh1 sh3" href="/school/intro?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($school['xuequ_guid'])?>">
                <td width="75%" height="40px" class="sh2"><b><?=$school['school_name']?></b></td>
                <td width="40%"><?=$school['school_level']?></td>
                <td width="20%" align="left"><img width="20" height="20" src="/img/district/btn_right.png"></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
	<div class="mapView">
        <div class="map1"><img src="http://api.map.baidu.com/staticimage?width=400&height=200&center=<?=$link['district_name']?>&markers=<?=$link['district_lng']?>,<?=$link['district_lat']?>&zoom=16&markerStyles=m,A,0xff0000" alt=""></div>
    </div>
    <div class="subscribe district">
        <a href="http://api.map.baidu.com/marker?location=<?=$link['district_lat']?>,<?=$link['district_lng']?>&title=<?=$link['district_name']?>&content=<?=$link['district_name']?>&output=html&src=爱居网络|微搜房" target="_self"><div class="map2"><div class="disMap2">
            <img src="/img/district/pin.svg" /></div><div class="disMap2"><?=$link['district_address']?></div><div class="disMap3"><img width="20" height="20" src="/img/district/btn_right.png"></div></div></a>
    </div>
	<div class="subscribe">
        <a href="/district/detail?uuid=<?=$uuid?>&district_guid=<?=base64_encode($link['district_guid'])?>"  target="_blank">
        <div class="dis_phone dis_xq">
            <div class="dis_ph1"><b>查看小区详情</b></div>
            <div class="dis_ph2"><img width="20" height="20" src="/img/district/btn_right.png"></div>
        </div>
        </a>
    </div>
    <!--
	<div class="whitebox school_1">
        <table class="msg_table comment1" width="100%">
            <tr>
                <td width="100%" colspan="2"><b>评价：</b></td>
            </tr>
            <tr>
                <td width="65%"><b>李哲：</b><span>人不错&nbsp;服务好&nbsp;给推荐了两套好房</span></td>
                <td width="40%"><img src='/img/starss_10.png' height="17"></td>
            </tr>
            <tr>
                <td width="65%"><b>Avril：</b>还可以&nbsp;服务不错&nbsp;小伙加油</td>
                <td width="40%"><img src='/img/starss_10.png' height="17"></td>
            </tr>
            <tr>
                <td width="65%"><b>王二：</b><span>服务一般吧&nbsp;不过还是比较靠谱的&nbsp;继续努力朋友</span></td>
                <td width="40%"><img src='/img/starss_10.png' height="17"></td>
            </tr>
            <tr>
                <td width="65%"><b>Dubiln：</b>我咋觉得一般呢</td>
                <td width="40%"><img src='/img/starss_10.png' height="17"></td>
            </tr>
        </table>
    </div>
    <div class="subscribe district comment2">
        <div class="map2"><div class="disMap3"><button class="button accessment">评论</button></div></div>
    </div>
-->
    <input type="hidden" name="hidden" id="house_info" value='<?=$house_info?>' />
</div>
</div>

<script type="text/javascript">
var small_swipper = new Swiper('.swiper-container',{
    slidesPerView: 'auto',
    onSlideClick: function(){
  		location.href= "/pic/house?house_guid=<?=base64_encode($house_guid)?>&start_index="+small_swipper.clickedSlideIndex;
    },
  })
</script>
<script type="text/javascript">
	function tip() {
		
	}
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
        
        $('.msg_table .sh3').bind('click',function(){
            window.location = $(this).attr('href');
            return false;
        });
        //window.onload = localData.initHouse();
        var ls = $.localStorage();
        //ls.clear();
        var collect = '<?=$collect?>';
        var house_guid = '<?=$house_guid?>';
        
        function oncollect() {
            // get data
            var house_info = $("#house_info").val();
            var house_data = $.localStorage('house');
            // add house_data
            if (house_data) {
                house_data.items1.push(house_info);
            } else {
                house_data = {items1:[house_info]}
            }
            $.localStorage('house', house_data);
            // unbind collect
            $("#cohouse").unbind('click', oncollect);
            // bind uncollect
            $("#cohouse").bind('click', uncollect);
            $("#cohouse img").attr("src","/img/district/star1.png");
        	$('#col_tip').html('<img src="/img/district/yes.png" width="40px" height="40px" /><div>收藏成功</div>').show('fast');
        	setTimeout(function(){
        		$('#col_tip').hide('fast');
        	},1500);
        	
        	z('m.collect');
        }
        
        function iscollected(house_data, house_info) {
            if(!house_data  || house_data.items1.length <=0 || !house_info) {
                return -1;
            }
            var exist_index = -1;
            house_info = $.parseJSON(house_info);
            $.each(house_data.items1, function(index, val) {
                val = $.parseJSON(val);
                //console.log(house_info.house_guid);
                //console.log(val.house_guid);
                if (house_info.house_guid == val.house_guid) {
                    exist_index = index;
                    return;
                }
            });
            return exist_index;
        }
        //取消收藏
        function uncollect() {
            // get data
            var house_info = $("#house_info").val();
            var house_data = $.localStorage('house');
            // add house_data
            if (house_data && house_info) {
                var index = iscollected(house_data, house_info);
                if (index >= 0) {
                    house_data.items1.splice(index, 1);
                    ls.setItem('house',house_data);
                }
            }
            $("#cohouse").unbind('click', uncollect);
            // bind uncollect
            $("#cohouse").bind('click', oncollect);
            $("#cohouse img").attr("src","/img/district/star.png");
            
            $('#col_tip').html('取消收藏').show('fast');
        	setTimeout(function(){
        		$('#col_tip').hide('fast');
        	},1500);
			
			z('m.uncollect');
        }
        
        function initHouse() {
            console.log(collect);
            $("#tb1 tr:last").css('borderBottom','none');
            //console.log($.localStorage('house').items1);
            var house_info = $('#house_info').val();
            var house_data = $.localStorage('house');
            //console.log(house_data.items1);
            if (iscollected(house_data, house_info) >= 0) {
                $("#cohouse img").attr("src","/img/district/star1.png");
                $("#cohouse").bind('click', uncollect);
            } else {
                $("#cohouse img").attr("src","/img/district/star.png");
                $("#cohouse").bind('click', oncollect);
            }
        }
        initHouse();
    })
</script>
<?php $this->render('common/contact', $_data);?>
<?php $this->render('common/footer'); ?>