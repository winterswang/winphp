<?php $this->render('common/header'); ?>
<div class="docbody">
<div class="main_content" id="content1">
    <div class="nohouse"><img src="/img/district/house.png" width="80px" height="80px" /></div>
    <div class="self_book">正在加载...</div>
</div>
<div id="dialog-confirm" title="Select Yes or No" style="display:none;">
    <p>是否删除收藏的此房源？</p>
</div>
</div>
<script src="/js/baseCode.js"></script>
<script type="text/javascript">
/*
    window.onload = function() {
        if(('localStorage' in window) && window['localStorage'] !== null) {
            if(localStorage) {
                //localStorage.removeItem('cnt1');
                //localStorage.clear();
                var len = localStorage.length - 1;
                for(var i = 0; i < len; i++) {
                    var key = localStorage.key(i);
                    //alert(typeof(localStorage.getItem(key)));
                    var hh = JSON.parse(localStorage.getItem(key));
                    if(hh.agent_guid) {
                        continue;
                    }
                    //console.log(hh);
                    var l = '<div class="subscribe">';
                    l += '<a href="/house/info?house_guid=' + urls.base64_encode(hh.house_guid) + '&house_info=' + urls.base64_encode(localStorage[key]) +'" target="_self">';
                    l += '<div class="list_item">';
                    l += '<table class="msg_table" width="100%">';
                    l += '<tr>';
                    if(hh.photo) {
                        l += '<td width="10%"><img class="image_item left_image" src="http://api.ikuaizu.com/data/attachment/' + hh.photo + '">';
                    } else {
                        l += '<td width="10%"><img class="image_item left_image" src="/img/district/common_pic.png">';
                    }
                    l += '</td>';
                    l += '<td width="70%">';
                    l += '<div class="house_summary">';
                    l += '<div class="title">' + hh.title + '</div>';
                    l += '<div class="house_area">' + hh.room + '室' + hh.hall + '厅&nbsp;' + hh.square + '平</div>';
                    l += '</div></td>';
                    l += '<td width="20%">';
                    l += '<div class="house_price">' + hh.sell_price + '万</div>';
                    l += '</td></tr></table></div></a></div>'; 
                    document.getElementById('content1').innerHTML += l;
                }
                
            } else {
                alert('你目前没有房源收藏！');
            } 
        } else {
            alert("Your browser does not support HTML5 localStorage. Try upgrading.");
        }     
    }
*/

    var ls = $.localStorage();
    //ls.clear();
    function init() {
        var house_data = ls.getItem('house');
        if (house_data == null ) return; 
        if (house_data.items1.length > 0) {
            $('.main_content div').remove();

        } else if(house_data.items1.length == 0) {
            $('.main_content .self_book').html('您现在还没有收藏的房源');
        }
        $.each(house_data.items1, function(i, hh){
            var hh = JSON.parse(hh);
            var i  = JSON.stringify(i);
            //console.log(hh.house_guid);
            var title = hh.title;
            if((title.replace(/[^\x00-\xff]/g,"**").length) >= 50) {
                var title = title.substring(0,22) + '....';
            }
            var dd = 'collected';
            var l = '<div class="subscribe right-bottom3 common_list">';
            l += '<a href="/house/info?collect=' + dd + '&house_guid=' + urls.base64_encode(hh.house_guid) + '&house_info=' + urls.base64_encode(JSON.stringify(hh)) +'" target="_self">';
            l += '<div class="list_item">';
            l += '<table class="msg_table" width="100%">';
            l += '<tr>';
            if(hh.photo) {
                l += '<td width="10%"><img class="image_item left_image" src="http://api.ikuaizu.com/data/attachment/' + hh.photo + '">';
            } else {
                l += '<td width="10%"><img class="image_item left_image" src="/img/district/common_pic.png">';
            }
            l += '</td>';
            l += '<td width="70%">';
            l += '<div class="house_summary">';
            l += '<div class="title">' + title + '</div>';
            l += '<div class="house_area">' + hh.room + '室' + hh.hall + '厅&nbsp;' + hh.square + '平</div>';
            l += '</div></td>';
            l += '<td width="20%">';
            l += '<div class="house_price">' + hh.sell_price + '万</div>';
            l += '</td></tr></table></div></a>';
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
                if(window.confirm("是否删除收藏的此房源？")) {
                    del(i);
                    window.location.reload();
                }
            })
        });
    }
    
    function del(i) {
        var house_data = ls.getItem('house');
        house_data.items1.splice(i,1);
        ls.setItem('house', house_data);
    }
    $(document).ready(init);
    
    /*
    //test
    var storage = window.localStorage;
    if(storage) {
        for(var i=0;i<storage.length;i++){
            //key(i)获得相应的键，再用getItem()方法获得对应的值
            document.write(storage.key(i)+ " : " + storage.getItem(storage.key(i)) + "<br>");
        }
        storage["a"] = "sfsf"; //设置a为"sfsf"，覆盖上面的值
        storage.setItem("b","isaac");  //设置b为"isaac"  
        for(var i=0;i<storage.length;i++){
            //key(i)获得相应的键，再用getItem()方法获得对应的值
            document.write(storage.key(i)+ " : " + storage.getItem(storage.key(i)) + "<br>");
        }
        //storage.clear();
    }
    */
</script>
<?php $this->render('common/footer'); ?>