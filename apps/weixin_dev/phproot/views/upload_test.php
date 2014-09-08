<?php $this->render('common/header'); ?>
<div class="fi_bar"> 
	发布房源
</div>
<div class="docbody">
<div class="main_content fi">

<span>内容</span>
<textarea id="qa" placeholder="请输入您的想法" ></textarea>

<span>照片</span>
<div class="subscribe image_list" style="padding-bottom:3px;padding-top:8px;">
	<div class="image_list1 image_test">
		<?php foreach($data as $house): ?>
		<img class="image-cn" src = "<?=$house['url']?>" width="60px" height="60px" />
		<?php endforeach;?>
	</div>
</div>

<div class='align_center'>
	<button id= "submit_btn" class="button search_button btn_test"><b>发布</b></button>
</div>
</div>
<script type="text/javascript">
/*
var small_swipper = new Swiper('.swiper-container',{
    slidesPerView: 'auto',
    onSlideClick: function(){
        location.href= "/house/pic?uuid=<?=$this->uuid?>&start_index="+small_swipper.clickedSlideIndex;
    },
})
*/
$(document).ready(function() {
    function bigImage(id) {
        $('.'+id).each(function(i){
            $(this).bind('click', function(){
                window.location.href= "/house/pic?uuid=<?=$this->uuid?>&start_index=" + i;            
            });
        });
    }

    bigImage("image-cn");
})
</script>

<script type="text/javascript">
    $('#submit_btn').bind('click',function(){
   		var wx_uuid = '<?=$this->uuid?>';
    	var content = document.getElementById('qa').value;
	    $.ajax({   
	        type:"get",
	        url:"/house/saveHouse",
	        data:{'content':content,'uuid':wx_uuid},
	        dataType:"json",
	        success:function(res){   
	            if(res.error > 0){ 
	                return;
	                console.log(res.msg);
	            }
	         window.location.href="/house/houseInfo?house_guid="+res.msg+"&uuid="+wx_uuid;    
	        }, 
	        error:function(){	        
	        }
	    });
	});
</script>

<script type="text/javascript">
// $('#submit_btn').bind('click',function(){
//     var wx_uuid = '<?=$this->uuid?>';
//     var content = document.getElementById('qa').value;
//     //window.location.href="/house/saveHouse?content="+content+"&uuid="+wx_uuid;
// });
</script>
