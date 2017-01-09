/**
 * 初始化数据
 * @param all_data
 */
function initDatas(all_data) {
    creAllData(all_data);//生成hightcharts 图表
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
        // 传递给相应的数组结构
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
    })

    //---展示点击的----
    id = $(this).attr("id").split('_')[1];
    id_text = "#container" + id;
    id_tab = "#datatable" + id;
    $(id_text).show();
    $(id_tab).show();

})





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