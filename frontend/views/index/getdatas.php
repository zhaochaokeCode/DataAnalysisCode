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
<div class="row">
    <div class="col-md-12">
        <!-- BOX -->
        <div class="box border green">
            <div class="box-title" style="height:10px;">
                <h5><i class="fa fa-bars"></i> <span class="hidden-inline-mobile">基本信息报表</span></h5>
            </div>
            <div class="box-body">
                <div class="tab-content">
                    <ul class="nav nav-tabs" id="all_tab">
                        <?php
                        global $view_id ;
                            if($view_arr){
                                for($i=0;$i<count($view_arr['tag']);$i++){
                                    $tagName = $view_arr['tag'][$i]['name'] ;
                                    $key = $i+1 ;
                                    $default = $i>0?'':"class=\"active\"" ;
                                    echo "<li id=\"tab_$key\" $default ><a href=\"#box_tab$key\" data-toggle=\"tab\"><i
                                    class=\"fa fa-bar-chart-o\"></i> <span class=\"hidden-inline-mobile\">$tagName</span></a>
                                       </li>" ;
                                    $view_id .=" <div id=\"container$key\" style=\"min-width: 200px;margin: 0 auto\"></div>";

                                }
                            }
                        ?>

<!--                                highgtchart 视图 遍历循环 此处用php动态生成-->
<!--                        <li id="tab_1" class="active"><a href="#box_tab1" data-toggle="tab"><i-->
<!--                                    class="fa fa-bar-chart-o"></i> <span class="hidden-inline-mobile">新增激活和账户</span></a>-->
<!--                        </li>-->
<!--                        <li id="tab_2"><a href="#box_tab2" data-toggle="tab"><i class="fa fa-search-plus"></i> <span-->
<!--                                    class="hidden-inline-mobile">玩家转化</span></a></li>-->
<!--                        <li id="tab_3"><a href="#box_tab2" data-toggle="tab"><i class="fa fa-search-plus"></i> <span-->
<!--                                    class="hidden-inline-mobile">玩家转化</span></a></li>-->
                    </ul>
                    <div id="all_view_id">
                        <!--        tab视图             遍历循环 此处用php动态生成-->
                        <?php echo $view_id ;?>
<!--                        <div id="container1" style="min-width: 200px;margin: 0 auto"></div>-->
<!--                        <div id="container2" style="min-width: 200px;margin: 0 auto"></div>-->
<!--                        <div id="container3" style="min-width: 200px;margin: 0 auto"></div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PAGE HEADER-->
<div class="box border orange">
    <div class="box-body">
        <div style="margin-left: 800px;margin-bottom: 2px;">
            <button class="btn btn-info">excel下载</button>
        </div>
        <div id="tab_all">
            <?php
                if($tab_arr){
                    for($i=1;$i<=count($tab_arr);$i++){
                        echo " <div id=\"tabdata$i\"></div>" ;
                    }
                }

            ?>
<!--            <div id="tabdata1"></div>-->
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
<script src="/js/hightcharts/comm_get_highdatas.js"></script>


<!--分页和ajax动态生成表格-->


<script type="text/javascript">
    $(function () {
        var all_data = <?php echo $view_data?>;
        var tab_data = <?php echo $tab_data?>;
        var page = <?php echo $page?>;
        var allpage = <?php echo $count?>;
//        var url_val = <?php //echo $url?>//;
        initTabData(tab_data,page,allpage);
        initDatas(all_data);


    })
</script>

<script src="/js/SmartPaginator-master/smartpaginator.js"></script>

<!-- 日期插件-->
<script src="/js/jedate/jquery.jedate.min.js"></script>
<script src="/js/jedate/comm_date.js"></script>
