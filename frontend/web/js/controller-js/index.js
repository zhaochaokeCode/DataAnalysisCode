$(function(){

    $("[id^=tab_]").click( function () {
        var id=$(this).attr("id").split("tab_")[1];
        var url = "/index/getdatas?action="+id ;
        $('#ifrm').attr("src",url);
        $("#hide_action").attr('name',id) ;

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