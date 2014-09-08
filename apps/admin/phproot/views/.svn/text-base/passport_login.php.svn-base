<?php $this->render('common/header'); ?>
<?php $this->render('common/top'); ?>

<div class='login-form container panel'>
	<div class="login-nav">
		<span>
			<img src="/img/images/login.png">
		</span>
		<span class="dr">登陆</span>
	</div>
	<form class="form-horizontal" role="form">
		<div class="form-group log-common1">
			<label for="inputEmail3" class="col-sm-2 control-label gray" style="text-align:left;">用户名</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" id="inputEmail3" name="username" placeholder="输入真实姓名或电话号码">
			</div>
		</div>
		<div class="form-group log-common2">
			<label for="inputPassword3" class="col-sm-2 control-label gray" style="text-align:left;">密码</label>
			<div class="col-sm-6">
				<input type="password" class="form-control" id="inputPassword3" name="password" placeholder="请输入密码">
			</div>
		</div>
		<div class="form-group log-common3">
			<div class="col-sm-5">
				<button type="submit" class="btn btn-blue">
					登陆
				</button>
			</div>
			<label class="col-sm-3 control-label no-login"><a href="#">无法登陆账户？</a></label>
		</div>
		<div class="form-group log-common4">
			<div class="col-sm-10">
				<a href="/member/reg" class="btn btn-red" target="_blank">
					注册
				</a>
			</div>
		</div>
	</form>
</div>
<script>
$('.btn-blue').on('click',function(){
    $.ajax({
        'type':'POST',
        'dataType':'json',
        'success':function(data) {
            if(data.error > 0){
                alert(data.message);
             return false;
            }
            setTimeout('window.location.href ="/house/add";', 1000);
        },
        'error':function(){
            return false;
        },
        'url':'/passport/logging',
        'cache':false,
        'data':$(this).parents("form").serialize()
    });
    return false;
});

</script>
<?php $this->render('common/footer'); ?>
