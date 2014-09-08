<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="main_content1 image-intro">
    <div class="whitebox right-bottom1">
        <div class="manage_wrap">
            <div class="manage_image">
                <?php if(empty($link['agent_photo'])):?>
                    <img class="avatar" src="/img/avatar.png">
                <?php else:?>
                    <img class="avatar" src="<?=$path . '/' . $link['agent_photo']?>">
                <?php endif;?>
            </div>
            <span class="lh"><?=$link['agent_name']?></span>
        </div>
        <div class="dis_msg manage_info">
            <div><span><?=$link['agent_tel']?></span></div>
            <div><span><img src='/img/starss_8.png' height="20">&nbsp;<font style="color:#f7941d;font-size:25px;">8</font></span></div>
        </div>
        <img src="/img/district/star.png" width="30" height="30" alt="" class="right-bottom2" id="costore" />
        <div id="col_tip" class='tip' style="display:none;">
            <img src="/img/district/yes.png" width="40px" height="40px" />
            <div>收藏成功</div>
        </div>
        <div style="clear: both"></div>       
    </div>
</div>
<div class="navbar-login nav_manage">
    <a href="/manage/house?uuid=<?=$uuid?>&agent_guid=<?=base64_encode($agent_guid)?>" target="_self"><div class="login manager1" title="ftab1"><span>店铺房源</span></div></a>
    <div class="login store1 lg1" title="ftab2"><span>经纪人详情</span></div>
    <div style="clear: both"></div>
</div>    
<div class="main_content" id="ftab2">
    <div class="subscribe">
        <table class="msg_table" width="100%">
            <tr>
                <td height="25px" width="100%">熟悉学区：西城育民小学&nbsp;西城第一中学</td>
            </tr>
            <tr>
                <td height="25px" width="100%">熟悉小区：<?=$link['agent_district']?></td>
            </tr>
            <tr>
                <td height="25px" width="100%">推荐房源：大河家苑3室1厅急售&nbsp;华鼎世家二期房出售</td>
            </tr>
        </table>
    </div> 
    <!--   
    <div class="subscribe dis_nearly layout">
        <div class="dis_msg">
            <div class="hx dis_msg"><b>自我介绍：</b></div><br/>
            <div class="self-intro"><span>我10年进入链家到现在总共三年的时间，我成交了几十个客户他们对我都非常的认可，我的业绩一直以来都是望京前五名，我能做出这么好的成绩原因有两个第一因为专业所以很多客户都认可我，第二就是.......</span></div>
        </div>
    </div>
    
    <div class="whitebox school_1 layout">
        <div class="hx dis_msg"><b>评价：</b></div><br/>
        <table class="msg_table comment1" width="100%">
            <tr>
                <td width="60%"><b>李哲：</b><span>人不错&nbsp;服务好&nbsp;给推荐了两套好房</span></td>
                <td width="25%"><img src='/img/starss_10.png' height="20"></td>
            </tr>
            <tr>
                <td width="60%"><b>Avril：</b>还可以&nbsp;服务不错&nbsp;小伙加油</td>
                <td width="25%"><img src='/img/starss_10.png' height="20"></td>
            </tr>
            <tr>
                <td width="60%"><b>王二：</b><span>服务一般吧&nbsp;不过还是比较靠谱的&nbsp;继续努力朋友</span></td>
                <td width="25%"><img src='/img/starss_10.png' height="20"></td>
            </tr>
            <tr>
                <td width="60%"><b>Dubiln：</b>我咋觉得一般呢</td>
                <td width="25%"><img src='/img/starss_10.png' height="20"></td>
            </tr>
        </table>
    </div>
    <div class="subscribe district comment2">
        <div class="map2"><div class="disMap3"><button class="button accessment">我来评价</button></div></div>
    </div>
    <div class="subscribe dis_nearly layout">
        <div class="dis_msg">
            <div class="hx dis_msg"><b>问答精华帖：</b></div><br/>
            <div class="tie1"><b>育民小学知多少？</b><span class="time"><font style="font-size:12px;">7-16&nbsp;20:00</font></span></div>
            <div style="clear: both"></div>
            <div class="tie1 self-intro"><span>我10年进入链家到现在总共三年的时间，我成交了几十个客户他们对我都非常的认可，我的业绩一直以来都是望京前五名，我能做出这么好的成绩原因有两个第一因为专业所以很多客户都认可我，第二就是.......</span></div>
        </div>
    </div>
-->
    </div>
    <input type="hidden" name="hidden" id="store_info" value='<?=$store_info?>' />
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var ls = $.localStorage();
        //ls.clear();
        var collect = '<?=$collect?>';
        var agent_guid = '<?=$agent_guid?>';
        function oncollect() {
            // get data
            var store_info = $("#store_info").val();
            var store_data = $.localStorage('store');
            // add store_data
            if (store_data) {
                store_data.items1.push(store_info);
            } else {
                store_data = {items1:[store_info]}
            }
            $.localStorage('store', store_data);
            // unbind collect
            $("#costore").unbind('click', oncollect);
            // bind uncollect
            $("#costore").bind('click', uncollect);
            $("#costore").attr("src","/img/district/star1.png");
            $('#col_tip').html('<img src="/img/district/yes.png" width="40px" height="40px" /><div>收藏成功</div>').show('fast');
            setTimeout(function(){
                $('#col_tip').hide('fast');
            },1500);
            
            z('m.storecollect');
        }
        
        function iscollected(store_data, store_info) {
            if(!store_data  || store_data.items1.length <=0 || !store_info) {
                return -1;
            }
            var exist_index = -1;
            store_info = $.parseJSON(store_info);
            $.each(store_data.items1, function(index, val) {
                val = $.parseJSON(val);
                console.log(store_info.agent_guid);
                console.log(val.agent_guid);
                if (store_info.agent_guid == val.agent_guid) {
                    exist_index = index;
                    return;
                }
            });
            return exist_index;
        }
        //取消收藏
        function uncollect() {
            // get data
            var store_info = $("#store_info").val();
            var store_data = $.localStorage('store');
            // add store_data
            if (store_data && store_info) {
                var index = iscollected(store_data, store_info);
                if (index >= 0) {
                    store_data.items1.splice(index, 1);
                    ls.setItem('store',store_data);
                }
            }
            $("#costore").unbind('click', uncollect);
            // bind uncollect
            $("#costore").bind('click', oncollect);
            $("#costore").attr("src","/img/district/star.png");
            $('#col_tip').html('取消收藏').show('fast');
            setTimeout(function(){
                $('#col_tip').hide('fast');
            },1500);

        }
        
        function initStore() {
            console.log(collect);
            //console.log($.localStorage('store').items1);
            var store_info = $('#store_info').val();
            var store_data = $.localStorage('store');
            //console.log(store_data.items1);
            if (iscollected(store_data, store_info) >= 0) {
                $("#costore").attr("src","/img/district/star1.png");
                $("#costore").bind('click', uncollect);
            } else {
                $("#costore").attr("src","/img/district/star.png");
                $("#costore").bind('click', oncollect);
            }       
        }
        initStore();
    })
</script>
<?php $this->render('common/footer'); ?>