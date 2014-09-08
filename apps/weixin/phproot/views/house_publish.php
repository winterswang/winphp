
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
	<title>发布房源</title>
	<link rel="stylesheet" type="text/css" href="/css/common.css" />

	<style type="text/css">
	
	.title{
		color:#626262;
		width: 286px;
		margin: 10px 0 0 25px;
		font:13px/30px 微软雅黑;
		text-align: 2px;
	}
	.txt{		
		margin: 0 16px 0;		
	}
	.txt textarea{
		background: #fff;
		width: 100%;
		border:none;
		padding: 6px 0;
		text-indent: 6px;
		height: 101px;
		display: block;
		border-radius: 1px;
		color:#8e8e8e;
		font:12px/20px 微软雅黑;
	}
	ul.imgs {
		padding: 0;
		margin: 0;
	}
	ul.imgs li{
		list-style: none outside none;
		float: left;
		padding: 0;
		margin: 0 0 15px 15px;
	}
	ul.imgs li img{
		border: 2px solid #fff;
		box-shadow: 1px 0px 2px rgba(6,0,1,0.38)
	}
	.btnPublish{		
		width: 116px;
		height: 34px;		
		font:14px/34px 微软雅黑;
		margin:10px auto 28px;
	}
</style>
</head>

<body>
<div class="title">内容</div>

<div class="txt"><textarea id="txt" >请输入房源的整体描述</textarea></div>
<div class="title">照片</div>
<ul class="imgs clearfix">
	<li><img src="http://tp2.sinaimg.cn/1900412485/180/5651481866/0" height="83px" width="83px"></li>
	<li><img src="http://tp2.sinaimg.cn/1900412485/180/5651481866/0" height="83px" width="83px"></li>
	<li><img src="http://tp2.sinaimg.cn/1900412485/180/5651481866/0" height="83px" width="83px"></li>
	<li><img src="http://tp2.sinaimg.cn/1900412485/180/5651481866/0" height="83px" width="83px"></li>
	<li><img src="http://tp2.sinaimg.cn/1900412485/180/5651481866/0" height="83px" width="83px"></li>
	<li><img src="http://tp2.sinaimg.cn/1900412485/180/5651481866/0" height="83px" width="83px"></li>
</ul>
<a href="javascript:void(0);" id="btnPublish" class="btnPublish btn_pink">发布</a>
</body>
</html>
