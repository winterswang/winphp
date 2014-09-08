<?php 
header( 'content-type: text/html; charset=utf-8' );
$this->render('common/header'); ?>
<div class="filter_bar">
<a id="school_select" href="/search/SchoolSelect">学校</a>
<div class="select_mask" for_data="room_select">房型<img src="/img/down_arrow.png"></div>
<div class="select_mask" for_data="area_select">面积<img src="/img/down_arrow.png"></div>
<div class="select_mask" for_data="price_select">价格<img src="/img/down_arrow.png"></div>


<image class='vsplit' src="/img/vsplit.png">
<select id='room_select'>
		<?php foreach ($room_filter as $k=>$v) { ?>
			 <option value="<?=$k?>"><?=$v?></option> 
		<?php } ?>
</select>
<image class='vsplit' src="/img/vsplit.png">
<select id="area_select">
		<?php foreach ($area_filter as $k=>$v) { ?>
			 <option value="<?=$k?>"><?=$v?></option> 
		<?php }?>
</select>
<image class='vsplit' src="/img/vsplit.png">

<select id="price_select">
		<?php foreach ($price_filter as $k=>$v) { ?>
			 <option value="<?=$k?>"><?=$v?></option> 
		<?php }?>
</select>
</div>
<div class="docbody">
<div class="main_content with_topbar" id="mainContent">
<span style="display:block;color:#727272;margin-bottom: 5px;" id="house_count"></span>
<input type="hidden" value="<?=$search_name?>" id="search_name" />
</div>
<div class="moreDistrict dis_msg" id="moreDis" style="display:none;">加载更多房源</div>
</div>
<script src="/js/baseCode.js"></script>
<script type="text/javascript">

$(function() {
    var page_no = 1;
    var page_size = 7;
    var totalheight = '';//页面可视区域高度
    var search_name = $('#search_name').val();
    var loading = false;
    
	function init() {
		var room = '<?=$room?>';
		var price ='<?=$price?>';
		var square = '<?=$square?>';
		if (room != '') {
			$("#room_select").val(room).change();
		}
		if (price != '') {
			$("#price_select").val(price).change();
		}
		if (square != '') {
			$("#area_select").val(square).change();
		} 
	}
    function ajaxMore() {
        if (!search_name || search_name =='') {
            return;
        }
        var room = $('#room_select').val();
        var square = $('#area_select').val();
        var price = $('#price_select').val();
        loading = true;    
        $.ajax({   
            type:"get",
            url:"/search/morexuequ",
            data:{'school_name':search_name,'room':room,'square':square,'price':price,'page_no':page_no,'page_size':page_size,'time':Math.random()},
            dataType:"json",
            beforeSend:function(){
                $('#moreDis').show();
                $('#moreDis').html(' 正在加载... ');  
            },            
            success:function(res){
                console.log(res);
                $("#house_count").html('共有' + res.top.house_count + '套房源');
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

    function display_search(res) {
        var l = '';
        $.each(res.list,function(i, n) {
            console.log(res.length);
            console.log(n.title.replace(/[^\x00-\xff]/ig,"**").length);
            var title = n.title;
            //if((title.replace(/[^\x00-\xff]/g,"**").length) >= 50) {
                //var title = title.substring(0,22) + '....';
            //}
            title = cutstr(title, 40);
            var l = '<div class="subscribe common_list">';
            l += '<a href="/house/info?house_guid=' + urls.base64_encode(n.house_guid) + '&house_info=' + urls.base64_encode(JSON.stringify(n)) +'" target="_self">';
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
          return  str; 
        } 
    }  

    $('.select_mask').each(function() {
        var for_id = $(this).attr('for_data')
        var my_offset = $('#'+for_id).offset();
        var h = $('#'+for_id).css('height');
        var w = $('#'+for_id).css('width');
        var style = 'left:'+my_offset.left + "px; top:"+my_offset.top+"px; height:" +h + ";width:"+w+";";
        $(this).attr('style', style);
        
        var mask_ele = $(this);
        $('#'+for_id).on('change', function() {
            var txt = $(this).find('option:selected').html();
            mask_ele.html(txt + '<img src="/img/down_arrow.png">');
            $('#mainContent div').remove();
            page_no = 1;
            ajaxMore();
        });
    });
    init();
    ajaxMore();
    $(window).bind('scroll',autoLoad);
});
</script>
<?php $this->render('common/footer'); ?>
