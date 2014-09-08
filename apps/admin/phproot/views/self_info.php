<?php $this->render('common/header'); ?>
<?php $this->render('common/top'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-3 left-menu">
			<?php $this->render('common/left_menu', $_data); ?>
		</div>
		<div class="col-md-9 right-content">
			<div class="rg-list content-fist detail-info">
				<div class="rg-list-nav complete-common">
					<span><img src="/img/images/publish_house_1.png" width="22px" height="22px" /></span>
					<span class="t4">完善信息</span>
				</div>
				<div class="rg-list-1">
					<span class="sp-info">个人信息</span>
				</div>
				<div class="rg-list-2">
					<form class="form-horizontal" role="form">
						<div class="form-group group-common">
						    <label for="inputEmail3" class="col-sm-1 control-label lb-common-left" style="text-align:left;margin-top:20px;">头像</label>
						    <div class="col-sm-2">
						    	<img src="/img/images/avator.png" alt="" width="80px" height="80px" />
						    </div>
						    <div class="upload-avator">
						    	<input type="file" class="form-control upload-file" title="上传头像">
						    </div>
						</div>
						<div class="form-group group-common">
						    <label for="inputEmail3" class="col-sm-1 control-label lb-common-left" style="text-align:left;">电子邮箱</label>
						    <div class="col-sm-4">
						    	<input type="email" class="form-control" id="exampleInputEmail2" placeholder="输入您的常用电子邮箱">
						    </div>
						</div>
						<div class="form-group group-common">
						    <label for="inputEmail3" class="col-sm-1 control-label lb-common-left" style="text-align:left;">微信号</label>
						    <div class="col-sm-4">
						    	<input type="text" class="form-control" id="exampleInputEmail2" placeholder="输入您的微信号">
						    </div>
						</div>
						<div class="form-group group-common" style="margin-bottom:0px;">
						    <label for="inputPassword3" class="col-sm-1 control-label lb-common-left" style="text-align:left;">自我介绍</label>
						    <div class="col-sm-4">
								<textarea class="form-control" rows="6" placeholder="输入您的自我介绍，140字以内。"></textarea>
						    </div>
						</div>
					</form>
				</div>
			</div>
			<div class="rg-list content-second detail-info">
				<div class="rg-list-1">
					<span class="sp-info">公司信息</span>
				</div>
				<div class="rg-list-2">
					<form class="form-horizontal" role="form">
						<div class="form-group group-common">
						    <label for="inputEmail3" class="col-sm-1 control-label lb-common-left" style="text-align:left;">所在城市</label>
						    <div class="col-sm-4">
						    	<button class="btn btn-blue bt-bj">北京</button>
						    </div>
						</div>
						<div class="form-group group-common">
						    <label for="inputEmail3" class="col-sm-1 control-label lb-common-left" style="text-align:left;">中介公司</label>
						    <div class="col-sm-4">
						    	<input type="text" class="form-control" id="exampleInputEmail2" placeholder="输入您的公司名字">
						    </div>
						</div>
						<div class="form-group group-common">
						    <label for="inputEmail3" class="col-sm-1 control-label lb-common-left" style="text-align:left;">门店地址</label>
						    <div class="col-sm-4">
						    	<input type="text" class="form-control" id="exampleInputEmail2" placeholder="输入您的公司地址">
						    </div>
						</div>
						<div class="form-group group-common">
						    <label for="inputEmail3" class="col-sm-1 control-label lb-common-left" style="text-align:left;">名片上传</label>
						    <div class="col-sm-4">
						    	<input type="file" id="exampleInputFile" class="form-control upload-file" title="上传名片">
						    </div>
						</div>
						<div class="form-group group-common">
						    <label for="inputEmail3" class="col-sm-1 control-label lb-common-left" style="text-align:left;">擅长学校</label>
						    <div class="col-sm-4">
						    	<input type="text" class="form-control" id="exampleInputEmail2" placeholder="输入您擅长的学校名称">
						    </div>
						    <button class="btn btn-blue bt-dis" type="submit">确定</button>
						    <button class="btn btn-blue bt-dis" type="submit">添加</button>
						</div>
						<div class="form-group group-common">
						    <label for="inputEmail3" class="col-sm-1 control-label lb-common-left" style="text-align:left;">擅长小区</label>
						    <div class="col-sm-4">
						    	<input type="text" class="form-control" id="exampleInputEmail2" placeholder="输入您擅长的小区名称">
						    </div>
						    <button class="btn btn-blue bt-dis" type="submit">确定</button>
						    <button class="btn btn-blue bt-dis" type="submit">添加</button>
						</div>
					</form>
				</div>
			</div>
			<div class="rg-list content-three">
				<div class="rg-list-publish">
					<button type="button" class="btn btn-blue">发布房源</button>
				</div>
			</div>
		</div>
	</div>
	<div></div>
</div>

<?php $this->render('common/footer'); ?>
