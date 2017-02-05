$(function(){

    $("[id^=tab_]").click( function () {

        var urlArr = $(this).attr("id").split("_") ;

        //其它的比较复杂的控制器视图
        if(urlArr[1]=='sec'){
            var url = "/" + urlArr[2];
        }else {//通用控制器视图
            var url = "/index/getdatas?action=" + urlArr[1];
        }
        $('#ifrm').attr("src", url);
        $("#hide_action").attr('name', id);
        //document.getElementById('ifrm').contentWindow.location.reload(true);
    });


    $("#sear").click(function(){
        start = $("#inpstart").val() ;
        end   = $("#inpend").val() ;

        str = "&starttime="+start+"&endtime="+end ;
        action = $("#hide_action").attr('name');


        var url = "/index/getdatas?action="+action+str ;
        $('#ifrm').attr("src",url);

    })



})