<?php $this->render('common/header'); ?>

<div class="docbody">
<div class="main_content">
<a href="/search/schoolselect?refer=/book/add">
<div class="subscribe book_top">
	
    <div class="dis_phone dis_xq" id="school_select">
            <div class="dis_ph1"><b id="school_tag"><?=$school_name?></b></div>
            <div class="dis_ph2"><img width="20" height="20" src="/img/district/btn_right.png"></div>
    </div>
   
	<div style="clear: both"></div>
</div>
</a>
<div class="subscribe relative select_book">
	<div class="dis_phone dis_xq">
            <div class="dis_ph1"><b id="room_tag">房型</b></div>
            <div class="dis_ph2"><img width="20" height="20" src="/img/district/btn_right.png"></div>
    </div>
    <select class='back_select big_select' for_data='room_tag' id="room_select">
    	<option value="" disabled selected>选择...</option>
		<?php foreach ($room_filter as $k=>$v) { ?>
			 <option value="<?=$k?>"><?=$v?></option>
		<?php } ?>
	</select>
	<div style="clear: both"></div>
</div>

<div class="subscribe relative select_book">
	<div class="dis_phone dis_xq">
            <div class="dis_ph1"><b id="price_tag">价格</b></div>
            <div class="dis_ph2"><img width="20" height="20" src="/img/district/btn_right.png"></div>
    </div>
    <select class='back_select big_select' for_data='price_tag' id="price_select">
    	<option value="" disabled selected>选择...</option>
		<?php foreach ($price_filter as $k=>$v) { ?>
			 <option value="<?=$k?>"><?=$v?></option>
		<?php } ?>
	</select>
	<div style="clear: both"></div>
</div>

<div class="subscribe relative select_book">
	<div class="dis_phone dis_xq">
       <div class="dis_ph1"><b id="area_tag">面积</b></div>
       <div class="dis_ph2"><img width="20" height="20" src="/img/district/btn_right.png"></div>
    </div>
    <select class='back_select big_select' for_data='area_tag' id="area_select">
    	<option value="" disabled selected>选择...</option>
		<?php foreach ($area_filter as $k=>$v) { ?>
			 <option value="<?=$k?>"><?=$v?></option>
		<?php } ?>
	</select>
	<div style="clear: both"></div>
</div>

</div>
<div class="align_center add_book_1"><button class="button search_button" onclick="addBook();"><b>保存<b></button></div>

</div>

<script type="text/javascript" >
$(document).ready(function(){
	$('.back_select').each(function(){
		//$(this).find('option').attr("selected", false);
		var for_id = $(this).attr('for_data');
		$(this).on('change',function(){
			var txt = $(this).find('option:selected').html();
			$('#'+for_id).html(txt);
		});
	});
});

function addBook() {
	var school_key = $('#school_tag').html();
	var room_key = $('#room_select').val();
	var room_txt = $("#room_tag").html();
	var price_key = $('#price_select').val();
	var price_txt = $("#price_tag").html();
	var area_key = $('#area_select').val();
	var area_txt = $("#area_tag").html();
	var book_item  = {
		school_name:school_key,
		room:{key:room_key,value:room_txt},
		area:{key:area_key,value:area_txt},
		price:{key:price_key,value:price_txt}
	}
	var book_data = $.localStorage('book');
	if (book_data) {
		book_data.items.push(book_item);
	} else {
		book_data = {items:[book_item]}
	}
	$.localStorage('book', book_data);
	window.location.href = "/book/mine"
}

</script>

<?php $this->render('common/footer'); ?>
