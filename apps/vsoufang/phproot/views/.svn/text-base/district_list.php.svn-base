<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="navbar">
    <a href="/school/intro?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($xuequ_guid)?>" target="_self"><div class="dis dis_detail" title="tab1"><span>学校介绍</span></div></a>
    <a href="/school/house?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($xuequ_guid)?>&house_count=<?=$house_count?>" target="_self"><div class="dis dis_hsource" title="tab2"><span>学区房源</span></div></a>
    <div class="dis dis_answer dis1" title="tab3"><span>对应小区</span></div>
    <div class="clr"></div>
</div>
<div class="main_content">
<?php foreach($link as $district): ?>
<div class="subscribe">
	<a href="/district/detail?uuid=<?=$uuid?>&xuequ_guid=<?=base64_encode($xuequ_guid)?>&district_guid=<?=base64_encode($district['district_guid'])?>"  target="_blank">
    <div class="list_item">
        <table class="msg_table" width="100%">
            <tr>
                <td width="10%">
                    <?php if(!empty($district['photo'])):?>
                        <img class="image_item left_image" src="<?=$path . '/' . $district['photo']?>">
                    <?php else:?>
                        <img class="image_item left_image" src="/img/district/common_pic.png">
                    <?php endif;?>
                </td>
                <td width="70%">
                    <div class="house_summary">
                        <div class="title"><?=$district['district_name']?></div>
                        <div class="house_area">在售房源：<?=$district['house_count']?>套</div>
                        <div class="dis_location"><div><img src="/img/district/pin.svg" class="pin_svg"></div><div class="dis_msg"><?=$district['address']?></div><div style="clear: both"></div></div>
                    </div>
                </td>
                <td width="20%">
                    <div class="house_price"><?=$district['house_price']?>元/平米</div>
                </td>
            </tr>
        </table>
    </div>
    </a>
</div>
<?php endforeach;?>
</div>
</div>
<?php $this->render('common/footer'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.dis1').bind('click', function(){
            window.location.reload();
        })
    })
</script>