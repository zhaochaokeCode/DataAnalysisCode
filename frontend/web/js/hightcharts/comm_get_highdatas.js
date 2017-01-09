
/**
 * 初始化数据
 * @param all_data
 */
function initDatas(all_data){
    creAllData(all_data) ;//生成hightcharts 图表
}



/**
 * 初始化 js函数
 * 生成各种图表结构
 */
function  creAllData(all_data){
    var num=1 ;
    $("#all_view_id div").each(function(){
        id_text ="#"+this.id ;
        //if(id_text.indexOf("container") > -1){
        //生成页面所有数据
        createLineView(id_text) ;

        //其它的隐藏掉
        if(num!=1){
            $(id_text).hide();
        }
        num++ ;
        //return false;
        //}
    })

}

//tab页面切换
$("#all_tab li").click( function () {
    //隐藏所有的
    $("#all_view_id div").each(function(){
        id_text ="#"+this.id ;

        if(id_text.indexOf("container") > -1){
            $(id_text).hide();
            id_tab  = "#datatable"+String(this.id.split('container')[1]) ;
            $(id_tab).hide();
        }
    })

    //---展示点击的----
    id=$(this).attr("id").split('_')[1] ;
    id_text = "#container"+id ;
    id_tab  = "#datatable"+id ;
    $(id_text).show();
    $(id_tab).show();

})








/**
 * 生成直线图js
 * @param tab_id
 * @param all_data
 */
function createLineView(tab_id,all_data){

    $(tab_id).highcharts({

        chart: {
            type: 'line',
        },
        title: {
            text: '',
            x: -20 //center
        },
        //subtitle: {
        //    text: 'Source: WorldClimate.com',
        //    x: -20
        //},
        xAxis: {
            categories: ['一月', '二月', '三月', '四月', '五月', '六月',
                '七月', '八月', '九月', '十月', '十一月', '十二月']
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
        series: [{
            name: '设备激活',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        }, {
            name: '新增玩家',
            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
        }
        ]
    });
}