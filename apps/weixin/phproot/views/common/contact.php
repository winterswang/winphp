<?php

//Detect special conditions devices
$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

//do something with this information
if( $iPod || $iPhone || $iPad){
    $sms = ";";
} else {
	$sms = "?";
}


?>

<div class="contact">
<div class="contact_wrapper">
<div class="contact_detail">
<a href="/manage/intro?uuid=<?=$uuid?>&agent_guid=<?=base64_encode($link['agent_guid'])?>"  target="_blank">
	<?php if(!empty($link['agent_photo'])):?>
		<img src="<?=$path . '/' . $link['agent_photo']?>" class="avatar" />
	<?php else:?>
		<img src="/img/avatar.png" class="avatar_1">
	<?php endif;?>
</a>
<span class="name"><?=$link['agent_name']?></span>
<span class="score_star"><img src="/img/starss_7.png" width="68" height="14"></span>
<span class="score_num">8.7</span>
<a href="tel:<?=$link['agent_tel']?>" class="tel"><img src="/img/tel.png" width="42" height="42"></a>
<a href="sms:<?=$link['agent_tel']?><?=$sms?>body=小区名，户型，面积，总价，请尽快与我联系。来自【微搜房】" class="weixin"><img src="/img/district/sms.png" width="42" height="42"></a>
</div>
</div>
<div class='op_back'></div>
<script type='application/javascript'>
	$('.tel').on('click', function(){z('m.tel');return true;})
	$('.weixin').on('click', function(){z('m.sms');return true;})
</script>
</div>