$(function(){

    $("[id^=tab_]").click( function () {

        var urlArr = $(this).attr("id").split("tab_") ;
        var action =urlArr[1]  ;
        //其它的比较复杂的控制器视图r
        if(action.indexOf("url")!=-1){
            var tmp = action.split("url") ;
            var url ="/"+tmp[1];
        }else {//通用控制器视图
            var url = "/index/getdatas?action=" + action;
        }
        $('#ifrm').attr("src", url);
        $("#hide_action").attr('name', id);
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