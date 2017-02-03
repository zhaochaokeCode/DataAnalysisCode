function submitBut(id_var){
    var cont = $("#"+id_var).serialize() ;
    $.ajax({
        url:"/login",
        type: 'POST',
        async:false ,
        data: cont,
        success: function(data2) {
            if(data2==1){
            location.href = "http://172.16.67.180" ;
            }else{
                alert('验证失败') ;
                return false ;
            }
        }

    });
    return false;
}
function  test(){

}