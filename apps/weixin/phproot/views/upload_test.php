<?php $this->render('common/header'); ?>
<div class="fi_bar"> 
	发布房源
</div>
<div class="docbody">
<div class="main_content fi">

<span>内容</span>
<textarea id='qa' placeholder="请输入您的想法" ></textarea>

<span>照片</span>
<div class="subscribe image_list" style="padding-bottom:3px;padding-top:8px;">
	<div class="image_list1 image_test">
        <div class="swiper-container">
            <div class="swiper-wrapper" style="padding:0px;width:100%;">
        		<?php foreach($data as $house): ?>
        		<div class="swiper-slide"><img src = "<?=$house['url']?>" width="60px" height="60px" /></div>
        		<?php endforeach;?>
            </div>
        </div>
	</div>
</div>

<div class='align_center'>
	<button id= "submit_btn" class="button search_button btn_test"><b>发布</b></button>
</div>
</div>
<script type="text/javascript">
var small_swipper = new Swiper('.swiper-container',{
    slidesPerView: 'auto',
    onSlideClick: function(){
        location.href= "/pic/house?house_guid=<?=base64_encode($house_guid)?>&start_index="+small_swipper.clickedSlideIndex;
    },
})
</script>
<script type="text/javascript">
$('#submit_btn').bind('click',function(){
var wx_uuid = '<?=$this->uuid?>';
var content = $('#qa').val();
    $.ajax({   
        type:"get",
        url:"/house/saveHouse",
        data:{'content':content,'uuid':wx_uuid},
        dataType:"json",
        success:function(res){   
            if(res.error > 0 || !res.length){
                $('.align_center').html('<p>'+res.msg+'</p>');
                return;
            }
            alert('发布成功');
        }, 
        error:function(){
        
        }
    })

});
</script>
<?php $this->render('common/footer'); ?>