<?php 
header( 'content-type: text/html; charset=utf-8' );
$this->render('common/header'); ?>

<div id='search_bar' class='search_bar_wrapper' style='display:none;'>
<div class="search_bar">
	<form onsubmit='return school_search();' method="get">
		<div style='position:relative;width:100%'>
			<span class='search_icon'>
				<img style="margin-left:10px;margin-top:10px;" src='/img/search_icon.png' width=20 height=20>
			</span>
			<div style="padding-left:37px;padding-right: 37px;">
				<div class='input_wrapper'>
					<input id='search' type='search' name='keyword' placeholder="搜索">
				</div>
				<div class='clrbtn'>X</div>
			</div>
			<span id='search_close' class='close'><img style="margin-left:10px;margin-top:10px;" src='/img/search_close.png' width=20 height=20></span>
		</div>
	</form>	
</div>
</div>
<div id='filter_bar' class="filter_bar" >
<span>北京</span>
<div class="select_mask" for_data="district_select">辖区<img src="/img/down_arrow.png"></div>
<div class="select_mask" for_data="school_type_select">学校类型<img src="/img/down_arrow.png"></div>
<div class="select_mask" for_data="level_select">等级<img src="/img/down_arrow.png"></div>


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
		<?php } ?>
</select>
<image class='vsplit' src="/img/vsplit.png">

<select id="level_select">
		<?php foreach ($level_filter as $k=>$v) { ?>
			<option value="<?=$k?>"><?=$v?></option>
		<?php } ?>
</select>

</div>
<div class="docbody">
<div class="main_content with_topbar" id="mainContent">
<!--
<div class="subscribe common_list" style="position: relative;z-index:9;">
	<a target="_self" href="/house/info?house_guid=MTAwMDAxMTc3Mw==&amp;house_info=eyJkaXN0cmljdF9pZCI6ImMtZG9uZ25hbnhpYW9xdTE3MDQiLCJob3VzZV9ndWlkIjoiMTAwMDAxMTc3MyIsImRpc3RyaWN0X25hbWUiOiLkuJzljZflsI/ljLoiLCJyb29tIjoiMiIsImhhbGwiOiIxIiwidGl0bGUiOiLkuK3lhbPmnZHkuIDlsI/lrabljLrmiL8g5Lit5YWz5p2R5LiA5bCP5Lic5Y2X5bCP5Yy65aSn5Lik5bGFIOaXoOeojiIsImxhYmVsIjoi5a2m5Yy65oi/Iiwic3F1YXJlIjoiNjkuNCIsInNlbGxfcHJpY2UiOiI1NzAiLCJwaG90byI6ImhvdXNlLzIwMTMwOS8xNy8wNzQwMThvMnN0b291Y3g3c3NudG9uLmpwZyJ9">
		<div class="list_item">
			<table width="100%" class="msg_table">
				<tbody>
					<tr>
						<td width="10%">
							<img src="http://api.ikuaizu.com/data/attachment/house/201309/17/074018o2stooucx7ssnton.jpg" class="image_item left_image">
						</td>
						<td width="90%">
							<div class="house_summary" style="width:100%;">
								<div class="title title-top">北京市海淀区中关村第一小学</div>
								<div class="house_area"><span class="rh-year">入户年限：3年</span><span class="house_price rh-cnt">142套房</span></div>
								<div class="sell-price"><span>在售总价：</span>204万起</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<img src="/img/district/szd.png" class="school_collect" width="50px" height="50px" />
	</a>
</div>
-->
</div>
<div class="moreDistrict dis_msg" id="moreDis" style="display:none;">加载更多学校</div>
</div>


<script type="text/javascript">
	window.onload = function() {
		//var doc = document;
		//doc.documentElement ? doc.documentElement.scrollTop = '100px' : doc.body.scrollTop = '100px';
		window.scrollTo(0,30);
	}
	var page=1;
	var page_size = 10;
	var loading = false;
	var search_by = 'filter';
	function loadSchoolList(){
		var param = {}
		if (search_by == 'keyword') {
			var kw = $('#search').val();
			param = {'searchby':'keyword','keyword':kw, 'page':page, 'page_size':page_size};
		} else {
			var district = $('#district_select').val();
			var school_type = $('#school_type_select').val();
			var level = $('#level_select').val();
			param = {'district':district, 'school_type':school_type, 'level':level, 'page':page, 'page_size':page_size}
		}
		loading = true;
		$.ajax({
			url:'/search/schoollistdata',
			dataType:'json',
			data:param,
			beforeSend:function(){
				$('#moreDis').show();
                $('#moreDis').html(' 正在加载... '); 
			}
		}).done(function(data){
			$.each(data.root, function(i, n){
				//console.log(n);
				//var h  = '<a href="<?=$refer?>?school_name='
				//h += n.school_name;
				//h += '">';
				//h += '<div class="subscribe">';
				//h += n.school_name;
				//h += '<div style="clear:both;"></div></div></a>';
				console.log(n.school_level);
				var lev_image = schoollevel(n.school_level);
				var house_price = n.house_price;
				if(house_price != "0") {
					house_price = (n.house_price/10000).toFixed(1) + '万';
				} else {
					house_price = "——";
				}
				
				var h = '<div class="subscribe common_list" style="position: relative;">';
				h += '<a href="<?=$refer?>?school_name='
				h += n.school_name;
				h += '">';
				h += '<div class="list_item"><table width="100%" class="msg_table"><tbody><tr>';
				h += '<td width="10%">';
				if(n.school_photo) {
					h += '<img src="http://api.ikuaizu.com/data/attachment/' + n.school_photo + '" class="image_item left_image">';
				} else {
					h += '<img src="/img/district/common_pic.png" class="image_item left_image"></td>';
				}
				h += '</td>';
				h += '<td width="90%">';
				h += '<div class="house_summary" style="width:100%;">';
				h += '<div class="title title-top">' + n.school_name + '</div>';
				h += '<div class="house_area">';
				h += '<span class="rh-year">入户年限：——</span>';
				h += '<span class="house_price rh-cnt">' + n.house_count + '套房</span></div>';
				h += '<div class="sell-price"><span>均价：</span>' + house_price + '</div>';
				h += '</div></td></tr></tbody></table></div>';
				h += '<img class="school_collect" width="45px" height="45px" src="' + lev_image + '"/>';
				h += '</a></div>';
				$('#mainContent').append(h);
			});
			if (page == 1 && data.root.length == 0) {
				 $('#moreDis').html('暂时无相关学校！');
			} else	if (data.root.length < page_size) {
				 $('#moreDis').html(' 加载完毕！');
			}
			page+=1;
			loading = false;
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
            	break;

            case '一级一类':
            	lev_image = '/img/district/yjy.png';
                break;
            
            case '一级二类':
                lev_image = '/img/district/yje.png';
                break;

            case '二级一类':
            	lev_image = '/img/district/ejy.png';
            	break;

            case '二级二类':
            	lev_image = '/img/district/eje.png';
            	break;
        }
        return lev_image;
	}
	
	function autoLoad() {
 		var totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
        if($(document).height() <= totalheight) {     //滚动条已到达底部
		 	if (loading == false) {
		 		loadSchoolList();
		 	}
		}
	}
	
	$(document).ready(function(){
		window.scrollTo(0,30);
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
				mask_ele.html(txt + '<img src="/img/down_arrow.png">');
				$('#mainContent div').remove();
				page = 1;
				loadSchoolList();
			});
		});
		//$("html,body").animate({scrollTop: $("#box").offset().top}, 1000); 
		//$("html,body").scrollTop("1000");
		loadSchoolList();
		
		$(window).bind('scroll', autoLoad);		
	});

</script>
<script type='application/javascript'>
	$(document).ready(function(){
		var cb = $('.clrbtn');
		var s = $('#search');
		cb.on('click', function(){
			s.val('');
			$(this).hide();
		});
		s.on('input', function(){
			if (s.val() == '') {
				cb.hide();
			} else {
				cb.show();
			}
		});
		$('#search_close').on('click', function() {
			$('#search_bar').slideUp();
			$('#filter_bar').slideDown();
			search_by = 'filter';
			$('#mainContent div').remove();
			page = 1;
			loadSchoolList();
		});
		
		var touchstart = 0;
		document.addEventListener('touchstart', function(e){
			touchstart = e.changedTouches[0].pageY;
		},false);

		document.addEventListener('touchmove', function(e){
			var touchend = e.changedTouches[0].pageY;
			if ((touchend - touchstart > 20) && ($(window).scrollTop() == 0)) {
				$('#filter_bar').hide();
			    $('#search_bar').show();
			} else if (touchstart - touchend > 10) {
				$('#search_bar').hide();
				$('#filter_bar').show();
			}
		},false);
		
	});
</script>

<script type="application/javascript">
	function school_search() {
		var kw = $('#search').val();
		if (kw == '') {
			return false;
		}
		$('#search').blur();
		search_by = 'keyword';
		$('#mainContent div').remove();
		page = 1;
		loadSchoolList();
		return false;
	}
</script>
<?php $this->render('common/footer'); ?>
