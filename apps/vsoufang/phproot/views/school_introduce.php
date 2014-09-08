<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="navbar">
    <div class="dis dis_detail dis1" title="tab1"><span>学校介绍</span></div>
    <a href="/school/house?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($xuequ_guid)?>&house_count=<?=$link['house_count']?>" target="_self"><div class="dis dis_hsource" title="tab2"><span>学区房源</span></div></a>
    <a href="/district/list?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($xuequ_guid)?>&house_count=<?=$link['house_count']?>" target="_self"><div class="dis dis_answer" title="tab3"><span>对应小区</span></div></a>
    <div class="clr"></div>
</div>
<!-- school -->    
<div class="main_content" id="tab1">
    <!--
    <div class="subscribe image_listschool    <div class="image_list1">
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
        <div class="pagination"></div>
    </div>
    </div>  
    </div>
-->
    <div class="house_title">
        <div class="title_name"><h1><?=$link['school_name']?></h1></div>
        <div class="house_labels">
        <div class="label_list">
            <?php if(!empty($link['school_level'])):?>
            <span><?=$link['school_level']?></span>
            <?php else:?>
            &nbsp;
            <?php endif;?>
        </div>
        <div class="star" id="coschool"><img src="/img/district/star.png" width="30" height="30" alt=""></div>
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
                <td width="52%" height="25px"><b>均价：</b><font color="#f4775a"><span style="font-size:17px;"><?=number_format($link['house_price']/10000,1)?></span>万/平米</font></td>
                <td width="48%"><b>在售房源：</b><?=$link['house_count']?>套</td>
            </tr>
            <tr>
                <td width="52%" height="25px"><b>区重点升学率：</b><?=$link['area_studyrate']?></td>
                <td width="48%"><b>市重点升学率：</b><?=$link['city_studyrate']?></td>
            </tr>
            <tr>
                <td width="52%" height="25px"><b>建校时间：</b>—</td>
                <td width="48%" height="25px"><b>落户期限：</b><?=$link['account_year']?></td>
            </tr>
            <tr>
                <td width="100%" colspan="2" height="25px"><b>学区名额：</b><?=$link['xuequ_num']?></td>
            </tr>
            <tr>
                <td width="100%" colspan="2" height="25px"><b>学校特色：</b><?=$link['school_character']?></td>
            </tr>
            <tr>
                <td width="100%" colspan="2" height="25px"><b>落户要求：</b><?=$link['account_req']?></td>
            </tr>
            <tr>
                <td width="100%" colspan="2" height="25px"><b>地址：</b><?=$link['school_address']?></td>
            </tr>
            <!--
            <tr>
                <td width="100%" colspan="2" height="25px"><b>联系电话：</b><?=$link['school_tel']?></td>
            </tr>
            <tr>
                <td width="100%" colspan="2" height="25px"><b style="vertical-align: top;">热门指数：</b><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"><img src='/img/district/fire.png' width="20px" height="20px"></td>
            </tr>
        -->
        </table>
    </div>
    <div class="subscribe dis_nearly layout">
        <div class="dis_msg">
            <div class="hx dis_msg"><b>学校简介：</b></div><br/>
            <div class="self-intro"><div id="selfIntro"><?=$link['school_overview']?></div></div>
        </div>
    </div>
    <div class="subscribe">
        <div class="dis_phone">
            <div class="dis_ph1"><b>学校联系电话：</b><?=$link['school_tel']?></div>
            <div class="dis_ph2"><a href="tel:<?=$link['school_tel']?>"><img width="42" height="42" src="/img/tel.png"></a></div>
        </div>
    </div>
    <!--
    <div class="subscribe">
        <a href="/district/list?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($xuequ_guid)?>"  target="_blank">
        <div class="dis_phone dis_xq">
            <div class="dis_ph1"><b>该学校对应的小区</b></div>
            <div class="dis_ph2"><img width="20" height="20" src="/img/district/btn_right.png"></div>
        </div>
        </a>
    </div>
-->
    <div class="subscribe layout">
        <div class="hx dis_msg"><b>师资力量：</b></div><br/>
        <table class="msg_table" width="100%">
            <tr>
                <td width="28%" height="35px">高级教师：</td>
                <td><div class="number1 bar1"></div><span class="number2"><?=$link['advanced_teacher_num']?>人</span></td>
            </tr>
            <tr>
                <td height="35px">中级教师：</td>
                <td><div class="number1 bar2"></div><span class="number2"><?=$link['inter_teacher_num']?>人</span></td>
            </tr>
            <tr>
                <td height="35px">初级教师：</td>
                <td><div class="number1 bar3"></div><span class="number2"><?=$link['junior_teacher_num']?>人</span></td>
            </tr>     
        </table>
    </div>
    
    <div class="mapView">
        <div class="map1"><img src="http://api.map.baidu.com/staticimage?width=400&height=200&center=<?=$link['school_name']?>&markers=<?=$link['lng']?>,<?=$link['lat']?>&zoom=16&markerStyles=m,A,0xff0000" alt=""></div>
    </div>
    <div class="subscribe district">
        <a href="http://api.map.baidu.com/marker?location=<?=$link['lat']?>,<?=$link['lng']?>&title=<?=$link['school_name']?>&content=<?=$link['school_name']?>&output=html&src=爱居网络|微搜房" target="_self"><div class="map2"><div class="disMap2"><img src="/img/district/pin.svg" /></div><div class="disMap2"><?=$link['school_address']?></div><div class="disMap3"><img width="20" height="20" src="/img/district/btn_right.png"></div></div></a>
    </div>
    </div>
</div>
</div>

<div class="activeframe">
<!--弹出层时背景层DIV-->
    <div id="fade" class="black_overlay">
    </div>
    <div id="MyDiv" class="white_content">
        <div style="text-align: right; cursor: default;padding-right:10px;height:20px">
            <span style="font-size: 26px;" onclick="CloseDiv('MyDiv','fade')">&#215;</span>
        </div>
        <div class="frame">
            <div class="navbar-login">
                <div class="login buyer lg1" title="ftab1"><span>我是购房者</span></div><div class="login manager lg2" title="ftab2"><span>我是经纪人</span></div>
                <div style="clear: both"></div>
            </div>
            <div class="self-info" id="ftab2">
                <table class="self-table" width="100%">
                    <tr>
                        <td width="30%"><span>真实姓名：</span></td>
                        <td width="60%" height="50px"><input type="text" name="realname" class="ipt" value="请输入您的真实姓名"></td>
                    </tr>
                    <tr>
                        <td><span>手机号码：</span></td>
                        <td height="50px"><input type="text" name="phone" class="ipt" value="手机号码"></td>
                    </tr>
                    <tr>
                        <td><span>验证码：</span></td>
                        <td height="50px"><input type="text" name="verify" class="ipt" value="请输入收到的验证码"></td>
                    </tr>     
                </table>
            </div>
            <div class="self-info" style="display:none;" id="ftab1">
                <table class="self-table">
                    <tr>
                        <td><span>昵称：</span></td>
                        <td height="50px"><input type="text" name="realname" class="ipt" value="请输入昵称"></td>
                    </tr>   
                </table>
            </div>
            <div class="btn">
                <div><button class="button cancel">取消</button><button class="button confirm">确定</button></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  var mySwiper = new Swiper('.swiper-container',{
    pagination: '.pagination',
    paginationClickable: true,
    slidesPerView: 'auto',
    loop: true,
  });
</script>
<script type="text/javascript">
    //window.onload = function(){
        //var selfIntro = document.getElementById('selfIntro').innerText;
        //document.getElementById('selfIntro').innerHTML = selfIntro.replace(/(^\s*)/g, "");
    //}
       //弹出隐藏层
    function ShowDiv(show_div,bg_div) {
       document.getElementById(show_div).style.display='block';
       document.getElementById(bg_div).style.display='block' ;
       var bgdiv = document.getElementById(bg_div);
       bgdiv.style.width = document.body.scrollWidth; 
      // bgdiv.style.height = $(document).height();
       $("#"+bg_div).height($(document).height());
    };
    //关闭弹出层
    function CloseDiv(show_div,bg_div) {
        document.getElementById(show_div).style.display='none';
        document.getElementById(bg_div).style.display='none';
    };

    $(function(){
        var selfIntro = $('.self-intro #selfIntro').html();

        $('.self-intro #selfIntro').html(selfIntro.replace(/(^\s*)/g, ""));

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
   
        $('.dis1').bind('click', function(){
            window.location.reload();
        })

        //alert($('.msg_table .number2').html());
        $('.number1').each(function(i){
            var num = $(this).siblings('.number2').html();
            num = parseInt(num.replace(/[^\d]/g,''));
            if(num >= 100) {
                num = num*0.8;
            }
            $(this).css("width",num + "%");
        })
        /*
        $(".navbar-login .lg1").bind('click',function(){
            $(this).removeClass('buyer buyer1').addClass("manage manager1");
            $(".navbar-login .lg2").removeClass("manager manager1").addClass("buy buyer1");
            $(".white_content").css('height', '220px');
            var ftab = $(this).attr("title");
            $("#" + ftab).show().siblings(".self-info").hide();
        })

        $(".navbar-login .lg2").bind('click',function(){
            $(this).removeClass('buyer buyer1').addClass("manage1 manager");
            $(".navbar-login .lg1").removeClass("manager manager1").addClass("buy1 buyer");
            $(".white_content").css('height', '330px');
            var ftab = $(this).attr("title");
            $("#" + ftab).show().siblings(".self-info").hide();
        })
        */
        
        var ls = $.localStorage();
        //ls.clear();
        var xuequ_guid = '<?=$xuequ_guid?>';
        var school_title = $(".title_name h1").html();
        var school_info = JSON.stringify({"school_title":school_title,"xuequ_guid":xuequ_guid});
        //school_info = JSON.stringify(school_info);
        function oncollect() {
            // get data
            console.log(school_info);
            var school_data = $.localStorage('school');
            // add school_data
            if (school_data) {
                school_data.items1.push(school_info);
            } else {
                school_data = {items1:[school_info]}
            }
            $.localStorage('school', school_data);
            // unbind collect
            $("#coschool").unbind('click', oncollect);
            // bind uncollect
            $("#coschool").bind('click', uncollect);
            $("#coschool img").attr("src","/img/district/star1.png");
            $('#col_tip').html('<img src="/img/district/yes.png" width="40px" height="40px" /><div>收藏成功</div>').show('fast');
            setTimeout(function(){
                $('#col_tip').hide('fast');
            },1500);
        }
        
        function iscollected(school_data, school_info) {
            if(!school_data  || school_data.items1.length <=0 || !school_info) {
                return -1;
            }
            var exist_index = -1;
            school_info = $.parseJSON(school_info);
            $.each(school_data.items1, function(index, val) {
                val = $.parseJSON(val);
                console.log(school_info.xuequ_guid);
                console.log(val.xuequ_guid);
                if (school_info.xuequ_guid == val.xuequ_guid) {
                    exist_index = index;
                    return;
                }
            });
            return exist_index;
        }
        //取消收藏
        function uncollect() {
            // get data
            var school_data = $.localStorage('school');
            // add school_data
            if (school_data && school_info) {
                var index = iscollected(school_data, school_info);
                if (index >= 0) {
                    school_data.items1.splice(index, 1);
                    ls.setItem('school',school_data);
                }
            }
            $("#coschool").unbind('click', uncollect);
            // bind uncollect
            $("#coschool").bind('click', oncollect);
            $("#coschool img").attr("src","/img/district/star.png");
            $('#col_tip').html('取消收藏').show('fast');
            setTimeout(function(){
                $('#col_tip').hide('fast');
            },1500);

        }
        
        function initSchool() {
            //console.log(collect);
            //console.log($.localStorage('school').items1);
            var school_data = $.localStorage('school');
            //console.log(school_data.items1);
            if (iscollected(school_data, school_info) >= 0) {
                $("#coschool img").attr("src","/img/district/star1.png");
                $("#coschool").bind('click', uncollect);
            } else {
                $("#coschool img").attr("src","/img/district/star.png");
                $("#coschool").bind('click', oncollect);
            }       
        }
        initSchool();

    })
</script>
<?php $this->render('common/footer'); ?>