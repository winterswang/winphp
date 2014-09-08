<?php $this->render('common/header'); ?>

<div class="mask"></div>

<div class="big-image-list">
	 <div class="big-swiper-container" >
	 	<div class="swiper-wrapper">
        <?php foreach($image_list as $image): ?>    
		<div class="big-swiper-slide"><img class="big-image-item" width="320" height="240" src="<?=$path . '/' . $image['pic_url']?>"></div>
        <?php endforeach; ?>
		</div>
		<div class="pagination"></div>
	</div>
</div>
<div style="clear: both"></div>

<script type="text/javascript">
     	
    	var big_swipper = new Swiper('.big-swiper-container',{
    		slidesPerView: 1,
    		centeredSlides:true,
    		slideClass:'big-swiper-slide',
    		pagination: '.pagination',
            paginationClickable: true,
    		onSlideClick: function(){
    			history.back();
    		},
  		})
  		big_swipper.swipeTo( <?=$start_index ?>);
  		
  		function pos() {
        	var mh = (document.documentElement.clientHeight - 240)/2;
        	//the top bar
        	if (mh > 44) {
        		mh = mh - 44;
        	}
        	var mw = (document.documentElement.clientWidth - 320)/2;
        	$(".big-image-list").attr('style',"top:"+ mh + "px;left:"+mw+"px;");
  		}
  		pos();
  		$(window).bind( 'orientationchange', function(e){
    		pos();
		});
</script>

</div>
</body>
</html>