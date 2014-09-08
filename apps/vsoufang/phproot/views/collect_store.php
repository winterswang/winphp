<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="main_content" id="content1">
    <div class="nohouse"><img src="/img/district/collect_store.png" width="80px" height="80px" /></div>
    <div class="self_book">正在加载...</div>
</div>
<div id="dialog-confirm" title="Select Yes or No" style="display:none;">
    <p>是否删除收藏的此店铺？</p>
</div>
</div>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/blitzer/jquery-ui.css" type="text/css" />
<script src="/js/jquery.easy-confirm-dialog.js"></script>
<script src="/js/baseCode.js"></script>
<script type="text/javascript">
    var ls = $.localStorage();
    //ls.clear();
    function init() {
        var store_data = ls.getItem('store');
        if (store_data == null ) return; 
        if (store_data.items1.length > 0) {
            $('.main_content div').remove();
        } else if(store_data.items1.length == 0) {
            $('.main_content .self_book').html('您现在还没有收藏的经纪人店铺');
        }
        $.each(store_data.items1, function(i, hh){
            var hh = JSON.parse(hh);
            //console.log(hh.house_guid);
            var dd = 'collected'
            var l = '<div class="subscribe store_item right-bottom3">';
            l += '<a href="/manage/intro?collect=' + dd + '&agent_guid=' + urls.base64_encode(hh.agent_guid) +'" target="_self">';
            l += '<div class="store_left">';
            if(hh.agent_photo) {
                l += '<img class="head" src="http://api.ikuaizu.com/data/attachment/' + hh.agent_photo + '">';
            } else {
                l += '<img class="head" src="/img/avatar.png">';
            }
            l += '<div class="name">' + hh.agent_name + '&nbsp;' + hh.agent_company + '</div>';
            l += '<div class="score">';
            l += '<div><img src="/img/starss_8.png"><span>8</span></div>';
            l += '</div></div></a>';
            l += '<div class="store_desc">';
            l += '<table class="dis_msg">';
            l += '<tr><td><b>熟悉学区：</b>' + hh.agent_district + '</td></tr>';
            l += '<tr><td><b>最新房源：</b>中关村附小好房出售</td></tr>';
            l += '<tr><td>阳光家园 三室一厅 120平米</td></tr>'; 
            l += '<tr><td><b>360万</b></td></tr>'; 
            l += '</table></div>';
            l += '<div style="clear: both"></div>';
            l += '<div class="recover"><img src="/img/district/recover.png" width="20px" height="20px" /></div>';
            l += '</div>'; 
            document.getElementById('content1').innerHTML += l;

            /*
            $(".recover").click(function(){
                $('#dialog-confirm').dialog({
                    height:140,
                    width:250,
                    modal:true,
                    resizable:true,
                    draggable:false,
                    buttons:{
                        "Ok":function() {
                            $(this).dialog("close");
                            del(i);
                            window.location.reload();
                        },
                        "No":function() {
                            $(this).dialog("close");
                        }
                    }
                });
            });
            */
           
            $(".recover").click(function() {
                if(window.confirm("是否删除收藏的此店铺？")) {
                    del(i);
                    window.location.reload();
                }
            })

        });
    }
    
    function del(i) {
        var store_data = ls.getItem('store');
        store_data.items1.splice(i,1);
        ls.setItem('store', store_data);
    }
    $(document).ready(init);
</script>
<?php $this->render('common/footer'); ?>