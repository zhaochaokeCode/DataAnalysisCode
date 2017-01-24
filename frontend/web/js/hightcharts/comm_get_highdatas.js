


/**
 * 初始化 js函数
 * 生成各种图表结构
 */
function initViewDatas(series,categories,tab_key) {
    var num = tab_key+1;
    id_text = "#container"+String(num);
    createLineView(id_text, series,categories);
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

function initTabData(tab_data, pages, allpage,key) {
    pagesAjax(pages, allpage);
    //生成tab
    createTable(tab_data,key);
    //分页

}
function createTable(tab_data, key) {
    var table = $("<table border=\"1\"    class=\"datatable table table-striped table-bordered table-hover\">");
    var div_key = key + 1;

    div_name = "#tabdata" + div_key.toString();
    table.appendTo($(div_name));

    $.each(tab_data, function (i1, n1) {
        var tr = $("<tr></tr>");
        if (i1 == 0) {
            var tr = $("<thead><tr></tr></thead>");
        }
        tr.appendTo(table);
        $.each(n1, function (i2, n2) {
            var td = $("<td>" + n2 + "</td>");
            if (i1 == 0) {
                var td = $("<th style='height:38px'>" + n2 + "</th>");
            }
            td.appendTo(tr);
        })
    })
    $("</table>").appendTo($("div_name"));
    if (key != 0) {
        $(div_name).hide();
    }

}
function pagesAjax(page, allpage) {
    var current_page = 5;

    $('#smart-paginator').smartpaginator({
        totalrecords: allpage,
        recordsperpage: page,
        next: '下一页',
        prev: '上一页',
        first: '首页',
        last: '末页',
        go: '前往',
        theme: 'docloud-pagi',
        initval: current_page,
        onchange: onPageChange

    });



    function onPageChange(newPageValue) {
        current_page = newPageValue;
        //根据新的页码做一些改变，比如说页面更新操作
        getPageList(newPageValue);
    }
    //分页更改
    function getPageList(newPageValue){
            var args=new Object();
            var query=location.search.substring(1);//获取查询串
            var pairs=query.split("&");//在逗号处断开

            data_url = window.location.pathname ;
            for(var i=0;i<pairs.length;i++)
            {
                var pos=pairs[i].indexOf('=');//查找name=value
                if(pos==-1) continue;//如果没有找到就跳过
                var argname=pairs[i].substring(0,pos);//提取name
                var value=pairs[i].substring(pos+1);//提取value
                if(value){
                    args[argname]=unescape(value);//存为属性
                    if(argname=='page'){
                        args[argname]=newPageValue ;
                    }
                }

            }
            i=0;
            if(args) {
                $.each(args, function (n, value) {
                    if(i==0){
                        data_url+="?"+n+"="+value ;
                        i++;
                    }else{
                        data_url+="&"+n+"="+value ;
                    }
                })
            }
        alert(data_url) ;
        window.location.href=data_url;
            //data_url = winw.location.pathname+"?action="+args['action']+"&page="+newPageValue;



            //txt = $("#serach",parent.document).serialize();
            //alert(txt) ;


        //$.ajax({
        //    type: "post",
        //    url: "",
        //    dataType: "json",
        //    success: function (data) {
        //        $("input#showTime").val(data[0].demoData);
        //    },
        //    error: function (XMLHttpRequest, textStatus, errorThrown) {
        //        alert(errorThrown);
        //    }
        //});
    }

}
//----------------tableEND------------------


/**
 * 生成直线图js
 * @param tab_id
 * @param all_data
 */
function createLineView(tab_id,series,categories) {


    $(tab_id).highcharts({

        chart: {
            type: 'line',
        },
        title: {
            text: '',
            x: -20 //center
        },
        xAxis: {
            categories:categories
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
        series:series

    });
}