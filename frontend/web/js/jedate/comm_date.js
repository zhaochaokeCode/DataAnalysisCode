var start = {
    skinCell:"jedategreen",
    //format: 'YYYY-MM-DD hh:mm:ss',
    ishmsVal:true,
    format: 'YYYY-MM-DD',
    minDate: '2014-06-16 23:59:59', //设定最小日期为当前日期
    //isinitVal:true,
    maxDate: $.nowDate(0), //最大日期
    choosefun: function(elem,datas){
        end.minDate = datas; //开始日选好后，重置结束日的最小日期
    }
};
var end = {
    skinCell:"jedategreen",
    format: 'YYYY-MM-DD',
    minDate: $.nowDate(0), //设定最小日期为当前日期
//        festival:true,
    //isinitVal:true,
    maxDate: '2099-06-16 23:59:59', //最大日期
    ishmsVal:true,
    choosefun: function(elem,datas){
        start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
    }
};
$("#inpstart").jeDate(start);
$("#inpend").jeDate(end);