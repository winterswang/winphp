<?php $this->render('common/header'); ?>
<?php $this->render('common/top'); ?>

<div class='reg-form container panel'>
	<form class="form-horizontal" id='regform' onsubmit='return check();' role="form" method='post'>
		<div class="form-group">
			<label for="mobile" class="col-sm-3 control-label gray">手机号码</label>
			<div class="col-sm-7">
				<input type="tel" name='mobile' class="form-control" id="mobile" placeholder="请输入您的手机号码">
			</div>
		</div>
		<div class="form-group">
			<label for="passwd" class="col-sm-3 control-label gray">密码</label>
			<div class="col-sm-7">
				<input type="password" name='passwd' class="form-control" id="passwd" placeholder="请输入密码">
			</div>
		</div>
		<div class="form-group">
			<label for="repasswd" class="col-sm-3 control-label gray">密码确认</label>
			<div class="col-sm-7">
				<input type="password" name='repasswd' class="form-control" id="repasswd" placeholder="请再次输入密码">
			</div>
		</div>
		<div class="form-group">
			<label for="realname" class="col-sm-3 control-label gray">真实姓名</label>
			<div class="col-sm-7">
				<input type="text" name='realname' class="form-control" id="realname" placeholder="真实姓名">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox">
						我已阅读并同意《微搜房经纪人使用协议》 </label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-red">
					提交注册
				</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<a href="/passport/login">已有账号？</a>
			</div>
		</div>
		<?php if (isset($error)) { ?>
			<div class="alert alert-danger" id='alert'>
         	<?=$error?>
        <?php } else { ?>
        	<div class="alert alert-danger" id='alert' style="display:none;">
        <?php }?>
        </div>
	</form>
</div>
<script type='application/javascript'>
	function validate() {
		if($('#mobile').val() == '') {
			return '请输入手机号';
		}
		if($('#passwd').val() == '') {
			return '请输入密码';
		}
		if($('#repasswd').val() == '') {
			return '请再次输入密码';
		}
		if($('#repasswd').val() != $('#passwd').val()) {
			return '请确保两次输入的密码相同';
		}
		if($('#realname').val() == '') {
			return '请输入真实姓名';
		}
		return '';
	}
	
	function check() {
		var msg = validate();
		$('#alert').hide();
		if (msg != '') {
			$('#alert').html(msg).show();
			return false;
		}
		return true;
	}
	
	$(document).ready(function(){
		$('input').each(function (i, n) {
			$(this).blur(function(){
				$('#alert').hide();
				msg = validate();
				if (msg != '') {
					$('#alert').html(msg).show();
				}
			});
	});
	});
</script>
<?php $this->render('common/footer'); ?>
