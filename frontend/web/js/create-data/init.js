$(function() {

    $("[id^=tab_]").click( function () {
        var id=$(this).attr("id").split("tab_")[1];
        var url = "/index/getdatas?action="+id ;
        $('#ifrm').attr("src",url);
        //document.getElementById('ifrm').contentWindow.location.reload(true);
    });




});