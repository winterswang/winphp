
<!DOCTYPE html> 
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="MobileOptimized" content="320"/>
	<meta name="viewport"
	      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="Expires" content="-1"/>
	<!-- iOS Full Screen -->
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<!-- iOS Status Bar Style (default, white, white-translucent) -->
	<meta name="apple-mobile-web-app-status-bar-style" content="white"/>
	<title>一键搬家</title>
	<link rel="stylesheet" type="text/css" href="/css/common.css" />
	<style type="text/css">
	
	.title{
		color:#848484;
		margin: 10px 16px 0 30px;
		font:12px/18px 微软雅黑;
	}
	.form {
		margin: 0 auto 15px;
		padding: 0 0 15px 0;
	}
	.form .line{
		padding-top: 20px;
		height: 34px;
		color:#646464;
		font:13px/34px 微软雅黑;
	}
	.form .line label,.form .line input{
		float: left;
	}
	.form .line label{
		margin: 0 0 0 30px;
		width: 65px;
	}
	.form .line input{
		width: 124px;
		height: 34px;
		border: none;
		padding: 0 0 0 5px;
		margin: 0;
		background: #e3e3e3;
		color:#888888;
		font:12px/30px 微软雅黑;
	}
	.form .line .btn_code{
		background: url("../img/manage/btn_code.png");
		background-size: 100% 100%;
		height: 34px;
		width: 65px;
		display: inline-block;
		float: left;
		margin-left: 5px
	}
	.form .line .btn_right{
		background: url("../img/manage/icon_right.png");
		background-size: 100% 100%;
		height: 24px;
		width: 24px;
		display: inline-block;
		float: left;
		margin: 5px 0 0 20px;
	}
	.confirm{		
		width: 111px;
		height: 35px;
		font:14px/35px 微软雅黑;
		margin: 0 auto 15px;
	}
</style>
</head>

<body>
<div class="title"> 请填写您的个人资料，我们会将您在其他网站上的房源匹配到这里。</div>

<div class="form">
	<div class="line"><label>真实姓名：</label><input id="realname" value="请输入您的真实姓名" /></div>
	<div class="line"><label>手机号码：</label><input id="mobile" value="18623237878" /><a href="javascript:void(0);" class="btn_code"></a></div>
	<div class="line"><label>验证码：</label><input id="code" value="df44" /><span class="btn_right"></span></div>
	<div class="line"><label>微信号：</label><input id="weixin" value="wujian333" /></div>	
	<div class="line"><button class="btn_pink confirm">提交</button></div>
</div>
</body>
</html>