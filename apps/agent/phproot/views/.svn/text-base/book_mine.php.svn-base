<?php $this->render('common/header'); ?>

<div class="docbody">
<div class="main_content" id="main_content">
	<div class="nobook">您现在还没有订阅个性推荐</div>
</div>
<div class="align_center"><button class="button search_button" onclick="add();"><b>添加订阅</b></button></div>
</div>

<script type="text/javascript">
	var ls = $.localStorage();
	//ls.clear();
	function init() {
		var book_data = ls.getItem('book');
		if (book_data == null ) return; 
		if (book_data.items.length > 0) {
			$('#main_content div').remove();
		}
		$.each(book_data.items, function(i, n){
			var html = "<div class='right-bottom3'>";
			html += "<a href='/search/xuequ?school_name=";
			html += n.school_name + "&room=" + n.room.key;
			html += "&square="+n.area.key;
			html += "&price="+n.price.key;
			html += "'>";
			html += "<div class='subscribe select_book_2'>";
			html += n.school_name + "+";
			html += n.room.value + "+";
			html += n.area.value + "+";
			html += n.price.value;
			html += "</div>";
			html += "</a>";
			html += '<div class="recover"><img src="/img/district/recover.png" width="20px" height="20px" /></div>';
			html += "</div>"
			$('#main_content').append(html);
			$(".recover").bind('click',function(i){
                if(window.confirm("是否删除订阅的此房源!")) {
                    del(i);
                    window.location.reload();
                }
            })
		});
	}
	
	function del(i) {
		var book_data = ls.getItem('book');
		book_data.items.splice(i,1);
		ls.setItem('book', book_data);
	}
	function add() {
		window.location.href = "/book/add";
	}
	$(document).ready(init);
</script>

<?php $this->render('common/footer'); ?>