<!DOCTYPE html>  
<html>  
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />
<meta name="format-detection" content="email=no" />
<meta name="format-detection" content="address=no;">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />  
<title><?=$this->meta['title']?></title>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css" />  
<script src="/js/jquery-1.9.1.min.js"></script> 
<script src="/js/jquery.mobile-1.3.2.min.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>  
<style>
 label.error {
    color: red;
    padding-top: .5em;
    vertical-align: top;
    font-weight:bold;
    float: none;
}
 
@media screen and (orientation: portrait){
label.error { margin-left: 0; display: block; }
}
 
@media screen and (orientation: landscape){
label.error { display: inline-block; margin-left: 22%; }
}
 
em { color: red; font-weight: bold; padding-right: .25em; }
 
</style>
</head>  
  
<body>  
<form action="/mreg/info" method="post" data-transition="pop" data-ajax="false" id="frmLogin">  
<div data-role="page" id="one">  
  
    <div data-role="header">  
        <h1>经纪人注册</h1>  
    </div>  
      
    <div data-role="content" data-theme="d">  
          
          
              
            <div data-role="fieldcontain">
                <label for="agentName">真实姓名:</label>
                <input type="text" name="agentName" id="agentName" placeholder="请输入真实姓名" value="" class="required" />
            </div>      
      
            <div data-role="fieldcontain">  
                <label for="telephone">手机号:</label>  
                <input type="text" name="telephone" id="telephone" placeholder="请输入手机号" value="" class="required" />  
            </div>

             <div data-role="fieldcontain">  
                <label for="agentWxId">微信号:</label>  
                <input type="text" name="agentWxId" id="agentWxId" placeholder="请输入微信号" value="" class="required" />  
            </div>
            <!--
             <div data-role="fieldcontain">  
                <label for="address">店铺地址:</label>  
                <input type="text" name="address" id="address" placeholder="请输入店铺地址" value="" class="required url" />
            </div>
            --> 
            <a href="javascript:void(0);" data-role="button" data-theme="e" class="checkLogin_two">下一步</a>
            
  
  
    </div>  
  
</div> 

<div data-role="page" id="two">  
  
    <div data-role="header">  
        <h1>经纪人注册</h1>  
    </div>  
      
    <div data-role="content" data-theme="d">  
          

              
            <div data-role="fieldcontain">
                <label for="company">公司名称:</label>
                <input type="text" name="company" id="company" placeholder="请输入公司名称" value="" class="required" />
            </div>      
      
            <div data-role="fieldcontain">  
                <label for="storeName">店铺名称:</label>  
                <input type="text" name="storeName" id="storeName" placeholder="请输入门店名称" value="" class="required" />  
            </div>

            <div data-role="fieldcontain">  
                <label for="position">职位:</label>  
                <input type="text" name="position" id="position" placeholder="请输入您的职位" value="" class="required" />  
            </div>
            <div data-role="fieldcontain">  
                <label for="business">擅长业务:</label>  
                <input type="text" name="business" id="business" placeholder="请输入您擅长的业务" value="" class="required" />
            </div>
            <a href="javascript:void(0);" data-role="button" data-theme="e" id="checkAddress" class="checkLogin_three">下一步</a>

  
    </div>  
  
</div> 

<div data-role="page" id="three">  
  
    <div data-role="header">  
        <h1>经纪人注册</h1>  
    </div>  
      
    <div data-role="content" data-theme="d">  
           
              
            <div data-role="fieldcontain" class="storeUrl">  
                <label for="storeUrl">店铺链接:</label>  
                <input type="text" name="storeUrl" id="storeUrl" placeholder="请输入店铺链接" value="" class="required url" />
            </div>
            <input value="<?=$openId?>" type="hidden" name="openId" />
            <input value="完成" type="submit" data-theme="e" class="checkLogin" />
             
  
    </div>  
  
</div> 
</form>

<script>
$(function(){
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
        var mobile = /^0{0,1}(13[0-9]|15[0-9])[0-9]{8}$/;   
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

})
</script>
  
</body>  
</html> 