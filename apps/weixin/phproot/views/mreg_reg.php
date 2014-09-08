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
    <title><?=$this->meta['title']?></title>
    <link rel="stylesheet" type="text/css" href="/css/common.css" />
    <script src="/js/jquery-1.9.1.min.js"></script> 
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>  
    <style type="text/css">
    
    label.error {
        display: block;
        color: red;
        padding-left: 37px;
        clear:both;
        font-weight:bold;
        float:none;
    }

   .photo{
        height: 83px;
        background: #5addf0;
        box-shadow: 1px 0px 2px rgba(6,0,1,0.38);
        margin:55px 30px 0;
        position: relative;
    }
    .photo img{
        border-radius: 45px;
        border:5px solid #fff;
        position: absolute;
        top:-40px;
        left:50%;
        margin-left: -45px
    }
    .photo .name{
        display: block;
        background: #fff;
        text-align: center;
        width: 58px;
        height: 25px;
        color:#888888;
        border-radius: 1px;
        position: absolute;
        left:50%;
        margin-left: -29px;
        bottom:4px;
        font:13px/25px 微软雅黑;
    }
    .form {
        margin:0 30px 15px;
        background: #fff;
        padding: 0 0 15px 0;
    }
    .form .line{
        padding-top: 15px;
        height:auto !important;
        height:30px; /*假定最低高度是200px*/
        min-height:30px; 
        color:#646464;
        font:13px/30px 微软雅黑;
    }
    .form .line span,.form .line input{
        float: left;
    }
    .form .line span{
        margin: 0 0 0 37px;
        width: 65px;
    }
    .form input{
        width: 140px;
        height: 30px;
        border: none;
        padding: 0 0 0 5px;
        margin: 0;
        background: #eee;
        color:#888888;
        font:13px/30px 微软雅黑;
    }
    .confirm{       
        width: 80px;
        height: 30px;
        font:14px/30px 微软雅黑;
        margin: 0 auto;
    }
</style>
</head>

<body>
<div class="photo">
        <img height="80px" width="80px" src="http://tp2.sinaimg.cn/1900412485/180/5651481866/0">
        <span class="name">海天</span>
</div>
<div class="form">
    <form action="/mreg/info" method="post" id="frmLogin">
        <div class="line"><span>手机号：</span><input type="text" name="telephone" id="telephone" placeholder="请输入手机号" value="" class="required" /></div>
        <div class="line"><span>微信号：</span><input type="text" name="agentWxId" id="agentWxId" placeholder="请输入微信号" value="" class="required" /></div>
        <div class="line"><span>公司：</span><input type="text" name="company" id="company" placeholder="请输入公司名称" value="" class="required" /></div>
        <div class="line"><span>门店：</span><input type="text" name="storeName" id="storeName" placeholder="请输入门店名称" value="" class="required" /></div>
        <div class="line"><span>头衔：</span><input type="text" name="position" id="position" placeholder="请输入您的职位" value="" class="required" /></div>
        <div class="line"><span>擅长业务：</span><input type="text" name="business" id="business" placeholder="请输入您擅长的业务" value="" class="required" /></div>
        <input value="<?=$openId?>" type="hidden" name="openId" />
        <div class="line"><button class="confirm btn_pink">确定</button></div>
    </form>
</div>

<script>
$(function(){

    $(".confirm").bind("click", function() {
        if($("#frmLogin").valid()) {
            $("#frmLogin").submit();
        }
    })
    /*
    $(".checkLogin_two").click(function() {
        if($("#frmLogin").valid()) {
            //$("#frmLogin").submit();
            $(this).attr("href","#two");
        }
    });

    $(".checkLogin_three").click(function() {
        if($("#frmLogin").valid()) {
            //$("#frmLogin").submit();
            $(this).attr("href","#three");
        }
    });
    //$("#frmLogin").validate({
        //onfocusout: false
    //});
    //
    jQuery.validator.addMethod("byteRangeLength", function(value, element, param) {
        var length = value.length;
        for (var i = 0; i < value.length; i++) {
            if (value.charCodeAt(i) > 127) {
                length++;
            }
        }
        return this.optional(element) || (length >= param[0] && length <= param[1]);
    }, "输入的值必须在3-30个字符之间(一个中文字算2个字符)");

    jQuery.validator.addMethod("isMobile", function(value, element) {       
        var length = value.length;   
        var mobile = /^0{0,1}(13[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;   
        return this.optional(element) || (length == 11 && mobile.test(value));       
    }, "请正确填写您的手机号码"); 

    $("#frmLogin").validate({
        rules:{
            agentName:{
                required:true,
                byteRangeLength:[3,30] 
            },
            telephone:{
                required:true,
                isMobile:true
            },
            agentWxId:{
                required:true,
                byteRangeLength:[2,50]
            },
            company:{
                required:true,
                byteRangeLength:[2,100]
            },
            storeName:{
                required:true,
                byteRangeLength:[2,100]
            },
            position:{
                required:true,
                byteRangeLength:[2,100]
            },
            business:{
                required:true,
                byteRangeLength:[2,100]
            },
            storeUrl:{
                required:true,
                url:true,
                byteRangeLength:[2,100]
            }
        },
        messages:{
            agentName:{
                required:'真实姓名为必填项',
                byteRangeLength:"姓名必须在3-30个字符之间(一个中文字算2个字符)"
            },
            telephone:{
                required:'手机号为必填项',
                isMobile:'请正确填写您的手机号码'
            },
            agentWxId:{
                required:'微信号为必填项',
                byteRangeLength:"微信号必须在2-50个字符之间(一个中文字算2个字符)"
            },
            company:{
                required:'公司名为必填项',
                byteRangeLength:'公司名必须在2-100个字符之间(一个中文字算2个字符)'
            },
            storeName:{
                required:'店铺名为必填项',
                byteRangeLength:'店铺名必须在2-100个字符之间(一个中文字算2个字符)'
            },
            position:{
                required:'职位名为必填项',
                byteRangeLength:'职位名必须在2-100个字符之间(一个中文字算2个字符)'
            },
            business:{
                required:'擅长业务为必填项',
                byteRangeLength:'擅长业务必须在2-100个字符之间(一个中文字算2个字符)'
            },
            storeUrl:{
                required:'店铺地址为必填项',
                byteRangeLength:'地址必须在2-100个字符之间(一个中文字算2个字符)'
            }
        }
    }); 

    $('.checkLogin_three').bind('click', function() {
        checkAddress();
    })
    
    function checkAddress() {
        var telephone = $('#telephone').val();
        $.ajax({   
            type:"post",
            url:"/manage/checkaddress",
            data:{'telephone':telephone},
            dataType:"json",          
            success:function(res){
                console.log(res); 
                //TODO   
                if(res.result == 'ok') {
                    var d = '<div style="font-size:16px;font-weight:bold;">您的店铺地址链接是:</div>';
                    d += '<span style="color: red;font-weight:bold;">' + res.storeUrl + '</span>';
                    d += '<input type="hidden" value="' + res.storeUrl + '" name="storeUrl" />';
                    $('.storeUrl div').remove();
                    $('.storeUrl').html(d);
                }
            }, 
            error:function(){
                console.log('fail');
            }           
        })
    }
    checkAddress();
*/
})
</script>
  
</body>  
</html> 