/**
 * 初始化数据
 * @param all_data
 */
function initDatas(all_data) {
    creAllData(all_data);//生成hightcharts 图表
    pagesAjax();
}


/**
 * 初始化 js函数
 * 生成各种图表结构
 */
function creAllData(all_data) {
    var num = 0;
    $("#all_view_id div").each(function () {
        id_text = "#" + this.id;
        //if(id_text.indexOf("container") > -1){
        //// 传递给相应的数组结构
        //$.each(all_data['tag_all'], function(i, n){
        //    alert(i+':'+n)
        //})
        createLineView(id_text, all_data[num]);

        //其它的隐藏掉
        if (num != 0) {
            $(id_text).hide();
        }
        num++;
    })

}



//tab页面切换
$("#all_tab li").click(function () {

    //隐藏所有的
    $("#all_view_id div").each(function () {
        id_text = "#" + this.id;

        if (id_text.indexOf("container") > -1) {
            $(id_text).hide();
            id_tab = "#datatable" + String(this.id.split('container')[1]);
            $(id_tab).hide();
        }
    });

    $("#tab_all div").each(function () {
        id_text = "#" + this.id;
        $(id_text).hide();
    });

    //---展示点击的----
    id = $(this).attr("id").split('_')[1];
    id_text = "#container" + id;
    id_tab = "#tabdata" + id;
    $(id_text).show();
    $(id_tab).show();

})

//----------生成table数据 TABLE START------------

function initTabData(tab_data) {
    //生成tab
    $.each(tab_data, function(i, n){
        createTable(i, n) ;
    })
    //分页

}
function createTable(i, n){
    var table = $("<table border=\"1\"    class=\"datatable table table-striped table-bordered table-hover\">");
    var div_key = i+1 ;

    div_name = "#tabdata"+div_key.toString() ;

    table.appendTo($(div_name));

    $.each(n, function(i1, n1){
        var tr = $("<tr></tr>");
        if(i1==0){
            var tr = $("<thead><tr></tr></thead>");
        }
        tr.appendTo(table);
        $.each(n1, function(i2, n2) {
            var td = $("<td>" + n2+ "</td>");
            if(i1==0){
                var td = $("<th style='height:38px'>" + n2+ "</th>");
            }
            td.appendTo(tr);
        })
    })
    $("</table>").appendTo($("div_name"));
    if(i!=1){
        $(div_name).hide() ;
    }

}
function pagesAjax(){
    var options = {
        bootstrapMajorVersion: 2, //版本
        currentPage: 10, //当前页数
        totalPages: 10, //总页数
        alignment:"andright",
        itemTexts: function (type, page, current) {
            switch (type) {
                case "first":
                    return "首页";
                case "prev":
                    return "上一页";
                case "next":
                    return "下一页";
                case "last":
                    return "末页";
                case "page":
                    return page;
            }

        }

    }
    $('#example').bootstrapPaginator(options);
}
//----------------tableEND------------------









/**
 * 生成直线图js
 * @param tab_id
 * @param all_data
 */
function createLineView(tab_id, all_data) {


    $(tab_id).highcharts({

        chart: {
            type: 'line',
        },
        title: {
            text: '',
            x: -20 //center
        },
        xAxis: {
            categories: all_data.categories
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series:all_data.series

    });
}