<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/site/index/cloud-admin.css" >

    <!--table切换页面-->
    <link href="/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">


</head>
<body>
<div class="row" >
    <div class="col-md-12" >
        <!-- BOX -->
        <div class="box border green">
            <div class="box-title" style="height:10px;"    >
                <h5><i class="fa fa-bars"></i> <span class="hidden-inline-mobile">基本信息报表</span></h5>
            </div>
            <div class="box-body">
                <div class="tab-content">
                    <ul class="nav nav-tabs">
                        <li id="tab_1" class="active"><a href="#box_tab1" data-toggle="tab"><i class="fa fa-bar-chart-o"></i> <span class="hidden-inline-mobile">新增激活和账户</span></a></li>
                        <li id="tab_2"><a href="#box_tab2" data-toggle="tab"><i class="fa fa-search-plus"></i> <span class="hidden-inline-mobile">玩家转化</span></a></li>
                    </ul>
                    <div id="container1" style="min-width: 200px;margin: 0 auto"></div>
                    <div id="container2" style="min-width: 200px;width:893px;margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
</div>
                    <!-- PAGE HEADER-->
                    <div class="box border orange">
                        <div class="box-body">

                            <div style="margin-left: 800px;margin-bottom: 2px;"><button class="btn btn-info">excel下载</button></div>
                            <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Rendering engine</th>
                                    <th>Browser</th>
                                    <th class="hidden-xs">Platform(s)</th>
                                    <th>Engine version</th>
                                    <th class="hidden-xs">CSS grade</th>
                                </tr>
                                </thead>
                                <tr class="gradeX">
                                    <td>Misc</td>
                                    <td>Lynx</td>
                                    <td class="hidden-xs">Text only</td>
                                    <td class="center">-</td>
                                    <td class="center hidden-xs">X</td>
                                </tr>
                                <tr class="gradeC">
                                    <td>Misc</td>
                                    <td>IE Mobile</td>
                                    <td class="hidden-xs">Windows Mobile 6</td>
                                    <td class="center">-</td>
                                    <td class="center hidden-xs">C</td>
                                </tr>
                                <tr class="gradeC">
                                    <td>Misc</td>
                                    <td>PSP browser</td>
                                    <td class="hidden-xs">PSP</td>
                                    <td class="center">-</td>
                                    <td class="center hidden-xs">C</td>
                                </tr>
                            </table>
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
<script src="/js/hightcharts/comm_get_datas.js"> </script>



<script type="text/javascript">
    $(function () {
        var all_data = "<?php echo $all_data?>";
        createAllView(all_data)
    })
</script>

<!-- 日期插件-->
<script src="/js/jedate/jquery.jedate.min.js"></script>
<script src="/js/jedate/comm_date.js"></script>
