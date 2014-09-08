<?php $this->render('common/header'); ?>
<div class="fi_bar"> 
	<a href="javascript:history.back();">
		<img src='/img/district/btn_back.png' width='30' height="30">
	</a>
	说点什么吧
</div>
<div class="docbody">
<div class="main_content fi">

<span>内容</span>
<textarea id='qa' placeholder="请输入您的问题" ></textarea>

<span>称呼</span>
<input id='name' placeholder="请输入您的称呼"></input>

<span>联系方式</span>
<input id='tel' placeholder="请输入您的电话或微信号"></input>

<div class='align_center'>
	<button onclick="add();" class="button search_button"><b>发送</b></button>
</div>
</div>
<script type="application/javascript">
	function add() {
		var q = $('#qa').val();
		var n = $('#name').val();
		var tel = $('#tel').val();
        $.ajax({   
            type:"post",
            url:"/msg/msgus",
            data:{'q':q,'n':n,'tel':tel},
            dataType:"json",
            success:function(res){
				alert(res.msg);
            }, 
            error:function(){
                console.log('error');
            }
        })
	}
</script>
<?php $this->render('common/footer'); ?>