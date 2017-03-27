<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/site/index/cloud-admin.css">

    <!--table切换页面-->
    <link href="/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="/js/SmartPaginator-master/smartpaginator.css">

</head>
<body>

    <!-- PAGE HEADER-->
    <div class="box border orange">
        <div class="box-body">

            <div style="margin-left: 800px;margin-bottom: 2px;">
                <button class="btn btn-info">excel下载</button>
            </div>
            <div id="tab_all">
                <div id="tabdata1">
                    <table border="1"    class="datatable table table-striped table-bordered table-hover">
                    <?php
                        echo "  <thead><tr>" ;
                        foreach($all_colu as $v){
                            echo "<th style='height:38px; align:center'> $v</th>" ;
                        }
                        echo "</tr></thead>" ;

                    foreach ( $all_data as $item) {
                        echo "<tr>" ;
                        foreach($item as $v){
                            echo "<td>$v</td>";
                        }
                        echo "</tr>" ;
                    }
                    ?>
                    </table>
                </div>
                <div id="smart-paginator" style="width: 800px" > </div>
            </div>
        </div>
    </div>
</body>
</html>

<script src="/js/jquery/jquery-2.0.3.min.js"></script>

<!-- 新 Bootstrap 核心 CSS 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

<!-- 网站原有的js文件-->
<script src="/js/index-js/My_script.js"></script>

<!-- highcharts相关文件 -->
<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
<script src="http://cdn.hcharts.cn/highcharts/modules/exporting.js"></script>
<!-- highcharts的ajax获取数据文件-->
<!--<script src="/js/hightcharts/comm_get_highdatas.js"></script>-->


<!--分页和ajax动态生成表格-->


<script type="text/javascript">
    $(function () {
        var allpage =   <?php echo $count?> ; //总共多少页
        pagesAjax(allpage);

    })
</script>

<script src="/js/SmartPaginator-master/smartpaginator.js"></script>

<!-- 日期插件-->
<script src="/js/jedate/jquery.jedate.min.js"></script>
<script src="/js/jedate/comm_date.js"></script>

<script>



    function pagesAjax(page) {

        $('#smart-paginator').smartpaginator({
            totalrecords:page ,//总的分页数
            recordsperpage:10,
            next: '下一页',
            prev: '上一页',
            first: '首页',
            last: '末页',
            go: '前往',
            theme: 'docloud-pagi',
            initval: 1,
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
            k=0;
            if(args) {
                $.each(args, function (n, value) {
                    if(k==0){
                        data_url+="?"+n+"="+value ;
                        k++;
                    }else{
                        data_url+="&"+n+"="+value ;
                    }
                })
            }

        }

    }
</script>
