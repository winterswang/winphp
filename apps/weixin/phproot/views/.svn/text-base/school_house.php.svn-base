<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="navbar">
    <a href="/school/intro?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($xuequ_guid)?>" target="_self"><div class="dis dis_detail" title="tab1"><span>学校介绍</span></div></a>
    <div class="dis dis_hsource dis1" title="tab2"><span>学区房源</span></div>
    <a href="/district/list?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($xuequ_guid)?>&house_count=<?=$house_count?>" target="_self"><div class="dis dis_answer" title="tab3"><span>对应小区</span></div></a>
    <div class="clr"></div>
</div>
<div class="main_content" id="mainContent">
    <span style="display:block;color:#727272;margin-bottom: 5px;" id="house_count"></span>
</div>
<div class="moreDistrict dis_msg" id="moreDis" style="display:none;">加载更多房源</div>
</div>
<input type="hidden" value="<?=$xuequ_guid?>" id="xuequ_guid" />
<script src="/js/baseCode.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.dis1').bind('click', function(){
            window.location.reload();
        });

        var page_no = 1;
        var page_size = 7;
        var totalheight = '';//页面可视区域高度
        var xuequ_guid = $('#xuequ_guid').val();
        var loading = false;
        var uuid = '<?=$uuid?>';
        var house_count = '<?=$house_count?>';
        
        function ajaxMore() {
            if (!xuequ_guid || xuequ_guid =='') {
                return;
            }
            loading = true;    
            $.ajax({   
                type:"get",
                url:"/school/morehouse",
                data:{'xuequ_guid':xuequ_guid,'page_no':page_no,'page_size':page_size,'time':Math.random()},
                dataType:"json",
                beforeSend:function(){
                    $('#moreDis').show();
                    $('#moreDis').html(' 正在加载... ');  
                },            
                success:function(res){
                    display_search(res); 
                    $("#house_count").html('共有' + house_count + '套房源');
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
                $('#mainContent').append(l);
            });   
        }
        ajaxMore();
        $(window).bind('scroll',autoLoad);
    })
</script>
<?php $this->render('common/footer'); ?>