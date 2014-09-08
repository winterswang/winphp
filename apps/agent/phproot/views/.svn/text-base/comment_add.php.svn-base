<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="main_content">
<div class="subscribe">
<div class="comment_title">评论</div>
<div class="comment_sep"></div>
<textarea class="comment_content" name="comment_content" width="100%"></textarea>
<div class="comment_score">
	<span>看房体验评价</span>
	<input type="hidden" id='comment_score' name='comment_score' value='0'>
	<ul>
		<li><img id="star_1" score="1" class="star_item" src='/img/star_gray.png'></li>
		<li><img id="star_2" score="2" class="star_item" src='/img/star_gray.png'></li>
		<li><img id="star_3" score="3" class="star_item" src='/img/star_gray.png'></li>
		<li><img id="star_4" score="4" class="star_item" src='/img/star_gray.png'></li>
		<li><img id="star_5" score="5" class="star_item" src='/img/star_gray.png'></li>
	</ul>
	<div style="clear:both"></div>
</div>
<div style="clear:both"></div>
</div>

</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".star_item").on('click', function(){
			var idx = $(this).attr('score');
			for (i=1; i<=5; i++) {
				if (i>idx) {
					$("#star_"+i).attr('src', '/img/star_gray.png');
				}else {
					$("#star_"+i).attr('src', '/img/star_yellow.png');
				}
			}
			$('#comment_score').val(idx);
		});
	});
</script>
<?php $this->render('common/footer'); ?>