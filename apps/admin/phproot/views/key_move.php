<?php $this->render('common/header'); ?>
<?php $this->render('common/top'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-3 left-menu">
			<?php $this->render('common/left_menu', $_data); ?>
		</div>
		<div class="col-md-9 key-move">
			<span>我们已经检测到您在安居客上有多套房源，您可以一键搬家到这来管理</span>
			<div class="col-sm-14">
				<form class="form-horizontal" role="form" onsubmit="return keymove();">
					<div class="form-group">
					    <div class="col-sm-offset-2 col-sm-6">
					    	<input type="text" class="form-control input-lg" id="urlAddress" placeholder="输入您在安居客上的店铺网址">
					    </div>
					    <button class="btn btn-lg btn-move" type="submit">
							一键搬家
						</button>
					</div>
				</form>
			</div>
			<div class="alert alert-danger warning" id="warning" style="display:none;">地址不合法!</div>
			<div class="alert alert-success warning" id="success" style="display:none;">提交成功!</div>
		</div>
	</div>
</div>
<script>
	function keymove() {
		var url = $('#urlAddress').val();

		if(!checkUrl(url)) {
			$('#success').hide();
			$('#warning').show();
			return false;
		} else {
			var urlArr = parseURL(url).segments;
			var agent_url = urlArr[0];
			console.log(agent_url);
			$.ajax({
				url: '/house/keymove',
				data: {'store_link':url, 'agent_url':agent_url},
				dataType: 'JSON',
				type: 'post'
			}).done(function(data){
				if(data.msg == 'ok') {
					$('#warning').hide();
					$('#success').show();
					window.location.href="/house/movehouse?store_url=" + url;
				} else if(data.analyze_status == 0 || data.analyze_status == 1) {
					$('#warning').hide();
					$('#success').html('搬家正在进行中.....').show();
					setTimeout(function() {
						window.location.href="/house/movehouse?store_url=" + url;
					}, 2000);
				} else if(data.analyze_status == 2) {
					$('#warning').hide();
					$('#success').html('您已经搬过家！').show();
					setTimeout(function() {
						window.location.href="/house/minestore";
					}, 2000);
				}
			});
			return false;
		}
		
	}

	function checkUrl(str_url) {    // 验证url
	    var urlreg=/^((https|http|ftp|rtsp|mms)?:\/\/)+[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/;
	    if (!urlreg.test(str_url)) {   
	        $('#urlAddress')[0].focus();  
	        return false;  
	    } else {   
	        return true;  
	    }  
	}

	//parse url
	function parseURL(url) {
		var a = document.createElement('a');
		a.href = url;
		return {
			source: url,
			protocol: a.protocol.replace(':',''),
			host: a.hostname,
			port: a.port,
			query: a.search,
			params: (function(){
				var ret = {},
				seg = a.search.replace(/^\?/,'').split('&'),
				len = seg.length, i = 0, s;
				for (;i<len;i++) {
				if (!seg[i]) { continue; }
				s = seg[i].split('=');
				ret[s[0]] = s[1];
				}
				return ret;
				})(),
			file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1],
			hash: a.hash.replace('#',''),
			path: a.pathname.replace(/^([^\/])/,'/$1'),
			relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1],
			segments: a.hostname.replace(/^\//,'').split('.')
		};
	} 
	/*
	var myURL = parseURL('http://yum11.beijing.homelink.com.cn/'); 
	console.log(myURL.file); 
	console.log(myURL.hash); 
	console.log(myURL.host); 
	console.log(myURL.query); 
	console.log(myURL.params); 
	console.log(myURL.path); 
	console.log(myURL.segments); 
	console.log(myURL.port); 
	console.log(myURL.protocol); 
	console.log(myURL.source); 
	*/
	
</script>
<?php $this->render('common/footer'); ?>
