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
    <div class="login manager1 lg1" title="ftab1"><span>店铺房源</span></div>
    <a href="/manage/intro?uuid=<?=$uuid?>&agent_guid=<?=base64_encode($agent_guid)?>" target="_self"><div class="login store1" title="ftab2"><span>经纪人详情</span></div></a>
    <div style="clear: both"></div>
</div> 
<div class="main_content" id="ftab1">
</div>
<div class="moreDistrict dis_msg" id="moreDis" style="display:none;">加载更多房源</div>
</div>
<input type="hidden" name="hidden" id="store_info" value='<?=$store_info?>' />
</div>
<script src="/js/baseCode.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var ls = $.localStorage();
        //ls.clear();
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
            //console.log(collect);
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

        //more house
        var page_no = 1;
        var page_size = 7;
        var totalheight = '';//页面可视区域高度
        var loading = false;
        var uuid = '<?=$uuid?>';
        
        function ajaxMore() {
            if (!agent_guid || agent_guid =='') {
                return;
            }
            loading = true;    
            $.ajax({   
                type:"get",
                url:"/manage/morehouse",
                data:{'agent_guid':agent_guid,'page_no':page_no,'page_size':page_size,'time':Math.random()},
                dataType:"json",
                beforeSend:function(){
                    $('#moreDis').show();
                    $('#moreDis').html(' 正在加载... ');  
                },            
                success:function(res){
                    display_search(res); 
                    if(( page_no == 1 && res.list.length > 0 && res.list.length < page_size ) || ( page_no > 1 && res.list.length < page_size )) {
                        $('#moreDis').html(' 所有房源加载完毕！ ');
                        $(window).unbind('scroll',autoLoad);
                    } else if(page_no == 1 && res.list.length == 0) {
                        $('#moreDis').html('暂时无相关房源！');  
                    } else {
                        page_no += 1;
                        $('#moreDis').show();
                        $('#moreDis').html(' 加载更多房源 ');
                    } 
                    loading = false;  
                }, 
                error:function(){
                    console.log('加载失败');
                }           
            })
        }

        function autoLoad() {
            totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
            if($(document).height() <= totalheight) {     //滚动条已到达底部
                if (loading == false){
                    ajaxMore();
                }
            }
        }

        /**
         * 截取字符串(中英混合)
         */
        function cutstr(str,len) { 
            var str_length = 0; 
            var str_len = 0; 
            str_cut = new String(); 
            str_len = str.length; 
            for(var i = 0; i < str_len; i++) { 
                a = str.charAt(i); 
                str_length++; 
                if(escape(a).length > 4) { 
                    //中文字符的长度经编码之后大于4 
                    str_length++; 
                } 
                str_cut = str_cut.concat(a); 
                if(str_length>=len) { 
                    str_cut = str_cut.concat("..."); 
                    return str_cut; 
                } 
            } 
            //如果给定字符串小于指定长度，则返回源字符串； 
            if(str_length < len) { 
                return str; 
            } 
        }  

        function display_search(res) {
            var l = '';
            $.each(res.list,function(i, n) {
                console.log(res.length);
                var title = n.title;
                title = cutstr(title, 40);
                var l = '<div class="subscribe common_list">';
                l += '<a href="/house/info?uuid=' + uuid + '&house_guid=' + urls.base64_encode(n.house_guid) + '&house_info=' + urls.base64_encode(JSON.stringify(n)) +'" target="_self">';
                l += '<div class="list_item"><table class="msg_table" width="100%"><tr>';
                l += '<td width="10%">';
                if(n.photo) {
                    l += '<img class="image_item left_image" src="http://api.ikuaizu.com/data/attachment/' + n.photo + '">';
                } else {
                    l += '<img class="image_item left_image" src="/img/district/common_pic.png">';
                };
                l += '</td>';
                l += '<td width="70%"><div class="house_summary">';
                l += '<div class="title">' + title + '</div>';
                l += '<div class="house_area">' + n.room + '室' + n.hall + '厅&nbsp;' + n.square + '平</div>';
                l += '</div></td>';
                l += '<td width="20%"><div class="house_price">' + n.sell_price + '万</div></td>';
                l += '</tr></table></div></a></div>';
                $('.main_content').append(l);
            });   
        }
        ajaxMore();
        $(window).bind('scroll',autoLoad);
    })
</script>
<?php $this->render('common/footer'); ?>