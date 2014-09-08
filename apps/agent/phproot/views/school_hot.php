<?php 
header( 'content-type: text/html; charset=utf-8' );
$this->render('common/header'); ?>
<div class="filter_bar">
<span>北京</span>
<div class="select_mask" for_data="district_select">辖区<img src="/img/down_arrow.png"></div>
<div class="select_mask" for_data="school_type_select">学校类型<img src="/img/down_arrow.png"></div>
<div class="select_mask" for_data="level_select">级别<img src="/img/down_arrow.png"></div>

<image class='vsplit' src="/img/vsplit.png">
<select id='district_select'>
		<?php foreach ($district_filter as $k=>$v) { ?>
			 <option value="<?=$k?>"><?=$v?></option>
		<?php } ?>
</select>
<image class='vsplit' src="/img/vsplit.png">
<select id="school_type_select">
		<?php foreach ($school_type_filter as $k=>$v) { ?>
			 <option value="<?=$k?>"><?=$v?></option> 
		<?php }?>
</select>
<image class='vsplit' src="/img/vsplit.png">

<select id="level_select">
		<?php foreach ($level_filter as $k=>$v) { ?>
			 <option value="<?=$k?>"><?=$v?></option> 
		<?php }?>
</select>

</div>
<div class="docbody">
<div class="main_content with_topbar" id="mainContent">
<!--
<div class="subscribe common_list">
	<a target="_self" href="/house/info?house_guid=MTAwMDAxMTc3Mw==&amp;house_info=eyJkaXN0cmljdF9pZCI6ImMtZG9uZ25hbnhpYW9xdTE3MDQiLCJob3VzZV9ndWlkIjoiMTAwMDAxMTc3MyIsImRpc3RyaWN0X25hbWUiOiLkuJzljZflsI/ljLoiLCJyb29tIjoiMiIsImhhbGwiOiIxIiwidGl0bGUiOiLkuK3lhbPmnZHkuIDlsI/lrabljLrmiL8g5Lit5YWz5p2R5LiA5bCP5Lic5Y2X5bCP5Yy65aSn5Lik5bGFIOaXoOeojiIsImxhYmVsIjoi5a2m5Yy65oi/Iiwic3F1YXJlIjoiNjkuNCIsInNlbGxfcHJpY2UiOiI1NzAiLCJwaG90byI6ImhvdXNlLzIwMTMwOS8xNy8wNzQwMThvMnN0b291Y3g3c3NudG9uLmpwZyJ9">
		<div class="list_item">
			<table width="100%" class="msg_table">
				<tbody>
					<tr>
						<td width="10%">
							<img src="http://api.ikuaizu.com/data/attachment/house/201309/17/074018o2stooucx7ssnton.jpg" class="image_item left_image school-image">
						</td>
						<td width="90%" height="70px;">
							<div class="house_summary hot-school">
								<div class="title hot-school-nav">
									<span class="by-school">北京市八一中学</span>
									<span class="zd-hot">重点</span>
									<div class="recommend"><span class="reason">推荐理由：</span>学校本着一人学校本着一人学校本着一人学校本着一人学校本着一人学校本着一人学校本着一人学校本着一人学校本着一人</div>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</a>
</div>
-->
</div>
<div class="moreDistrict dis_msg" id="moreDis" style="display:none;">加载更多学校</div>
</div>

<script src="/js/baseCode.js"></script>
<script type="text/javascript">
/*
	var page=1;
	var page_size = 10;
	var loading = false;
	var ls = $.localStorage();
	//ls.clear();
    function init() {
        var school_data = ls.getItem('school');
        if (school_data == null ) return; 
        $.each(school_data.items1, function(i, hh){

            var hh = $.parseJSON(hh);
            console.log(hh.school_title);
            var i  = JSON.stringify(i);
            //console.log(hh.school_guid);
            var h  = '<a href="/school/intro?&xuequ_guid='
			h += urls.base64_encode(hh.xuequ_guid);
			h += '">';
			h += '<div class="subscribe right-bottom4">';
			h += hh.school_title;
			h += '<div style="clear:both;"></div>';
			h += '<img src="/img/district/school_hot.png" class="school_collect" width="35px" height="35px" />';
			h += '</div></a>';
            document.getElementById('mainContent').innerHTML += h;
        });
    }
    
    function del(i) {
        var school_data = ls.getItem('school');
        school_data.items1.splice(i,1);
        ls.setItem('school', school_data);
    }
    */

	function loadSchoolList(){
		var district = $('#district_select').val();
		var school_type = $('#school_type_select').val();
		var level = $('#level_select').val();
		loading = true;
		$.ajax({
			url:'/school/schoolhotdata',
			dataType:'json',
			data:{'district':district, 'school_type':school_type, 'level':level},
			beforeSend:function(){
			}
		}).done(function(data){
			$.each(data.root, function(i, n){
				console.log(n.recommend);
				var recommend = n.recommend;
				//console.log(typeof recommend);
				recommend = cutstr(recommend,50);
				var lev_image = schoollevel(n.school_level);
				var h = '<div class="subscribe common_list" style="position: relative;z-index:9;">';
				h += '<a target="_self" href="/school/intro?&xuequ_guid=';
				h += urls.base64_encode(n.xuequ_guid);
				h += '">';
				h += '<div class="list_item">';
				h += '<table width="100%" class="msg_table">';
				h += '<tbody><tr><td width="10%">';
				if(n.school_photo) {
					h += '<img src="http://api.ikuaizu.com/data/attachment/' + n.school_photo + '" class="image_item left_image school-image"></td>';
				} else {
					h += '<img src="/img/district/common_pic.png" class="image_item left_image school-image"></td>';
				}
				h += '<td width="90%" height="70px;">';
				h += '<div class="house_summary hot-school">';
				h += '<div class="title hot-school-nav">';
				h += '<span class="by-school">' + n.school_name + '</span>';
				h += '<div class="recommend"><span class="reason">推荐理由：</span>' + recommend + '</div>';
				h += '</div></div></td></tr></tbody></table></div>';
				h += '<img class="school_collect" width="50px" height="50px" src="' + lev_image + '"/>';
				h += '</a></div>';
				$('#mainContent').append(h);
			});
			if (data.root.length == 0) {
				$("#moreDis").show();
				$('#moreDis').html('暂时无相关学校！');
			} 
		});
	}

	function schoollevel(sch_lev) {
		var lev_image = '';
		if (sch_lev == "") {
			return false;
		};
		switch (sch_lev) {
            case '市重点':
            	lev_image = '/img/district/szd.png';
                break;
            
            case '区重点':
                lev_image = '/img/district/zd.png';
                break;

            case '普通':
            	lev_image = '/img/district/pt.png';
            	break
        }
        return lev_image;
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
	
	/*
	function autoLoad() {
 		var totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
        if($(document).height() <= totalheight) {     //滚动条已到达底部
		 	if (loading == false) {
		 		loadSchoolList();
		 	}
		}
	}
	*/
	
	$(document).ready(function(){
		$('.select_mask').each(function(){
			var for_id = $(this).attr('for_data')
			var my_offset = $('#'+for_id).offset();
			var h = $('#'+for_id).css('height');
			var w = $('#'+for_id).css('width');
			var style = 'left:'+my_offset.left + "px; top:"+my_offset.top+"px; height:" +h + ";width:"+w+";";
			$(this).attr('style', style);
			
			var mask_ele = $(this);
			$('#'+for_id).on('change', function(){
				var txt = $(this).find('option:selected').html();
				mask_ele.html(txt);
				$('#mainContent div').remove();
				//page = 1;
				loadSchoolList();
			});
		});
		//init();
		loadSchoolList();
		//$(window).bind('scroll', autoLoad);

		
	    
	});
</script>
<?php $this->render('common/footer'); ?>
