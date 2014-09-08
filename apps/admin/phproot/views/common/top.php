<div class="topbar-wrapper">
<div class="container">
<div class="row topbar">
  <div class="col-md-8"><img src='/img/admin_logo.png'></div>
  <div class="col-md-4">
  	<div class='row topbar-content'>
  	<?php if(!$this->is_guest()) { ?>
  	<div class='col-md-4'>
  		您好，<?php echo $this->_G['member']['realName']; ?>
  	</div>
  	<div class='col-md-4'>
  		<a href='/msg' class='msg'>
  			<img src='/img/msg.png'>
  			<span class='msg-tip'>6</span>
  			消息
  		</a>
  	</div>
  	<div class='col-md-4'>
  		<a href='/help'>帮助</a> | <a href='/passport/logout'>退出</a>
  	</div>
  	<?php }  else { ?>
  	<div class='col-md-4'>
  		<a href='/help'>帮助</a> | <a href='/passport/login'>登录</a>
  	</div>	
  	<?php } ?>
  	</div>
  </div>
</div>
</div>
</div>