function submitBut(id_var){
    var cont = $("#"+id_var).serialize() ;
    $.ajax({
        url:"/login",
        type: 'POST',
        async:false ,
        data: cont,
        success: function(data2) {
            if(data2==1){
            location.href = "http://"+ window.location.host ;
            //    alert("http://"+ window.location.host) ;
            }else{
                alert('用户名或者密码错误,请重新输入') ;
                return false ;
            }
        }

    });
    return false;
}
function  test(){

}