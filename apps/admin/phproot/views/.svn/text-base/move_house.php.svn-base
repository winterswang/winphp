<?php $this->render('common/header'); ?>
<?php $this->render('common/top'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-3 left-menu">
			<?php $this->render('common/left_menu', $_data); ?>
		</div>
		<div class="col-md-9 move-house">
            <div class="bs-example h-fill-animation">
                <div class="progress">
                    <div id= 'pbar' class="progress-bar progress-bar-danger six-sec-ease-in-out"></div>
                </div>
                <div class="load-image">
                	<span>一键搬家中</span>
                	<span><image src="/img/images/self_info.png"></span>
                </div>
            </div>
            <div class="house-list">
				<div class="hs-list">
					<div class="hs1"><img src="/img/images/common_pic.png" width="100px" height="100px"></div>
					<div class="hs2">
						<div class="house-name">稀缺超奥阿萨上岛咖啡唱大声</div>
						<div class="house-detail">大河庄园&nbsp;三室一厅&nbsp;130平</div>
					</div>
					<div class='hs3'>320万</div>
				</div>            	
            </div>
            <div class="house-list">
				<div class="hs-list">
					<div class="hs1"><img src="/img/images/common_pic.png" width="100px" height="100px"></div>
					<div class="hs2">
						<div class="house-name">稀缺超奥阿萨上岛咖啡唱大声中国人民好样的</div>
						<div class="house-detail">大河庄园&nbsp;三室一厅&nbsp;130平</div>
					</div>
					<div class='hs3'>320万</div>
				</div>            	
            </div>
            <div class="house-list">
				<div class="hs-list">
					<div class="hs1"><img src="/img/images/common_pic.png" width="100px" height="100px"></div>
					<div class="hs2">
						<div class="house-name">稀缺超奥阿萨上岛咖啡唱大声</div>
						<div class="house-detail">大河庄园&nbsp;三室一厅&nbsp;130平</div>
					</div>
					<div class='hs3'>320万</div>
				</div>            	
            </div>
            <div class="house-list">
				<div class="hs-list">
					<div class="hs1"><img src="/img/images/common_pic.png" width="100px" height="100px"></div>
					<div class="hs2">
						<div class="house-name">稀缺超奥阿萨上岛咖啡唱大声</div>
						<div class="house-detail">大河庄园&nbsp;三室一厅&nbsp;130平</div>
					</div>
					<div class='hs3'>320万</div>
				</div>            	
            </div>
            <div class="house-list">
				<div class="hs-list">
					<div class="hs1"><img src="/img/images/common_pic.png" width="100px" height="100px"></div>
					<div class="hs2">
						<div class="house-name">稀缺超奥阿萨上岛咖啡唱大声</div>
						<div class="house-detail">大河庄园&nbsp;三室一厅&nbsp;130平</div>
					</div>
					<div class='hs3'>320万</div>
				</div>            	
            </div>
		</div>
	</div>
</div>
<script type='application/javascript'>

	$(document).ready(function(){
		var timer = setInterval(updateStatus, 2000);

		function updateStatus() {
			var url = '<?=$store_url?>';
			$.ajax({
				url:'/house/movehouse',
				data:{'url':url},
				dataType:'json',
				type:'post'
			}).done(function(d){
				console.log(d.analyze_count);
				$('#pbar').attr('aria-valuetransitiongoal', d.analyze_count);
				if(d.analyze_status == 2) {
					clearInterval(timer);
				}
			});
		}
	})
</script>
<?php $this->render('common/footer'); ?>
