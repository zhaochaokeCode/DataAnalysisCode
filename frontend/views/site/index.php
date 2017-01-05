<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Cloud Admin | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="/css/site/index/cloud-admin.css" >
    <link rel="stylesheet" type="text/css"  href="/css/themes/default.css" id="skin-switcher" >
    <link rel="stylesheet" type="text/css"  href="/css/site/index/responsive.css" >
    <!-- STYLESHEETS --><!--[if lt IE 9]><script src="/js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
    <link href="/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- ANIMATE -->
    <link rel="stylesheet" type="text/css" href="/css/animatecss/animate.min.css" />
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" type="text/css" href="/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <!-- TODO -->
    <link rel="stylesheet" type="text/css" href="/js/jquery-todo/css/styles.css" />
    <!-- FULL CALENDAR -->
    <link rel="stylesheet" type="text/css" href="/js/fullcalendar/fullcalendar.min.css" />
    <!-- GRITTER -->
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <!-- FONTS -->
    <link rel="stylesheet" type="text/css" href="/js/datatables/media/assets/css/datatables.min.css" />

    <!--日期时间样式-->
    <link type="text/css" rel="stylesheet" href="/js/jedate/skin/jedate.css">

    <style>
    #page{
    margin-left:auto;
    margin-right:auto;
    border:1px solid #cdd2d2;
    width:1200px;
    height: auto;
    text-align:left
    }
    </style>
</head>
<body>



<!-- HEADER -->
<header class="navbar clearfix" id="header">
    <div class="container">
        <div class="navbar-brand">
            <!-- COMPANY LOGO -->
            <a href="index.html">
                <img src="img/logo/logo.png" alt="Cloud Admin Logo" class="img-responsive" height="30" width="120">
            </a>
            <!-- /COMPANY LOGO -->
            <!-- TEAM STATUS FOR MOBILE -->
            <div class="visible-xs">
                <a href="#" class="team-status-toggle switcher btn dropdown-toggle">
                    <i class="fa fa-users"></i>
                </a>
            </div>
            <!-- /TEAM STATUS FOR MOBILE -->
            <!-- SIDEBAR COLLAPSE -->
            <div id="sidebar-collapse" class="sidebar-collapse btn">
                <i class="fa fa-bars"
                   data-icon1="fa fa-bars"
                   data-icon2="fa fa-bars" ></i>
            </div>
            <!-- /SIDEBAR COLLAPSE -->
        </div>
        <!-- NAVBAR LEFT -->
        <ul class="nav navbar-nav pull-left hidden-xs" id="navbar-left">
            <li class="dropdown">
                <a href="#" class="team-status-toggle dropdown-toggle tip-bottom" data-toggle="tooltip" title="Toggle Team View">
                    <i class="fa fa-users"></i>
                    <span class="name">Team Status</span>
                    <i class="fa fa-angle-down"></i>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-cog"></i>
                    <span class="name">Skins</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu skins">
                    <li class="dropdown-title">
                        <span><i class="fa fa-leaf"></i> Theme Skins</span>
                    </li>
                    <li><a href="#" data-skin="default">Subtle (default)</a></li>
                    <li><a href="#" data-skin="night">Night</a></li>
                    <li><a href="#" data-skin="earth">Earth</a></li>
                    <li><a href="#" data-skin="utopia">Utopia</a></li>
                    <li><a href="#" data-skin="nature">Nature</a></li>
                    <li><a href="#" data-skin="graphite">Graphite</a></li>
                </ul>
            </li>
        </ul>
        <!-- /NAVBAR LEFT -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">
            <!-- BEGIN NOTIFICATION DROPDOWN -->
            <li class="dropdown" id="header-notification">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="badge">7</span>
                </a>
                <ul class="dropdown-menu notification">
                    <li class="dropdown-title">
                        <span><i class="fa fa-bell"></i> 7 Notifications</span>
                    </li>
                    <li>
                        <a href="#">
                            <span class="label label-success"><i class="fa fa-user"></i></span>
									<span class="body">
										<span class="message">5 users online. </span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>Just now</span>
										</span>
									</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="label label-primary"><i class="fa fa-comment"></i></span>
									<span class="body">
										<span class="message">Martin commented.</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>19 mins</span>
										</span>
									</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="label label-warning"><i class="fa fa-lock"></i></span>
									<span class="body">
										<span class="message">DW1 server locked.</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>32 mins</span>
										</span>
									</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="label label-info"><i class="fa fa-twitter"></i></span>
									<span class="body">
										<span class="message">Twitter connected.</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>55 mins</span>
										</span>
									</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="label label-danger"><i class="fa fa-heart"></i></span>
									<span class="body">
										<span class="message">Jane liked. </span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>2 hrs</span>
										</span>
									</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="label label-warning"><i class="fa fa-exclamation-triangle"></i></span>
									<span class="body">
										<span class="message">Database overload.</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>6 hrs</span>
										</span>
									</span>
                        </a>
                    </li>
                    <li class="footer">
                        <a href="#">See all notifications <i class="fa fa-arrow-circle-right"></i></a>
                    </li>
                </ul>
            </li>
            <!-- END NOTIFICATION DROPDOWN -->
            <!-- BEGIN INBOX DROPDOWN -->
            <li class="dropdown" id="header-message">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope"></i>
                    <span class="badge">3</span>
                </a>
                <ul class="dropdown-menu inbox">
                    <li class="dropdown-title">
                        <span><i class="fa fa-envelope-o"></i> 3 Messages</span>
                        <span class="compose pull-right tip-right" title="Compose message"><i class="fa fa-pencil-square-o"></i></span>
                    </li>
                    <li>
                        <a href="#">
                            <img src="img/avatars/avatar2.jpg" alt="" />
									<span class="body">
										<span class="from">Jane Doe</span>
										<span class="message">
										Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse mole ...
										</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>Just Now</span>
										</span>
									</span>

                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="img/avatars/avatar1.jpg" alt="" />
									<span class="body">
										<span class="from">Vince Pelt</span>
										<span class="message">
										Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse mole ...
										</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>15 min ago</span>
										</span>
									</span>

                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="img/avatars/avatar8.jpg" alt="" />
									<span class="body">
										<span class="from">Debby Doe</span>
										<span class="message">
										Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse mole ...
										</span>
										<span class="time">
											<i class="fa fa-clock-o"></i>
											<span>2 hours ago</span>
										</span>
									</span>

                        </a>
                    </li>
                    <li class="footer">
                        <a href="#">See all messages <i class="fa fa-arrow-circle-right"></i></a>
                    </li>
                </ul>
            </li>
            <!-- END INBOX DROPDOWN -->
            <!-- BEGIN TODO DROPDOWN -->
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>
</header>

<!--/HEADER -->
<!-- PAGE -->
<section id="page">
    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar">
        <div class="sidebar-menu nav-collapse">
            <div class="divide-20"></div>
            <!-- SEARCH BAR -->
<!--            <div id="search-bar">-->
<!--                <input class="search" type="text" placeholder="Search"><i class="fa fa-search search-icon"></i>-->
<!--            </div>-->
            <!-- SIDEBAR MENU -->
            <ul>
                <li class="has-subhas-sub">
                    <a href="javascript:;" class="">
                        <i class="fa fa-bookmark-o fa-fw"></i> <span class="menu-text">数据报表1</span>
                        <span class="arrow"></span>
                    </a>
                </li>
                <li class="has-sub">
                    <a href="javascript:;" class="">
                        <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">数据报表2<span class="badge pull-right">1</span></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="search_results.html"><span class="sub-menu-text">Search Results</span></a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;" class="">
                        <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">数据报表3<span class="badge pull-right">1</span></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="search_results.html"><span class="sub-menu-text">Search Results</span></a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;" class="">
                        <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">数据报表4<span class="badge pull-right">1</span></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="search_results.html"><span class="sub-menu-text">Search Results</span></a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;" class="">
                        <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">数据报表5<span class="badge pull-right">1</span></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="search_results.html"><span class="sub-menu-text">Search Results</span></a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;" class="">
                        <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">数据报表6<span class="badge pull-right">1</span></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="search_results.html"><span class="sub-menu-text">Search Results</span></a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;" class="">
                        <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">Other Pages <span class="badge pull-right">1</span></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="search_results.html"><span class="sub-menu-text">Search Results</span></a></li>
                    </ul>
                </li>
            </ul>
            <!-- /SIDEBAR MENU -->
        </div>
    </div>
    <!-- /SIDEBAR -->
    <div id="main-content">
        <!-- SAMPLE BOX CONFIGURATION MODAL FORM-->
        <div class="modal fade" id="box-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Box Settings</h4>
                    </div>
                    <div class="modal-body">
                        Here goes box setting content.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /SAMPLE BOX CONFIGURATION MODAL FORM-->
        <div class="container">
            <div class="row">
                <div id="content" class="col-lg-12">
                    <!-- PAGE HEADER-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-header">
                                <!-- BREADCRUMBS -->
                                <ul class="breadcrumb">
                                    <li>
                                        <i class="fa fa-home"></i>
                                        <a href="/site/index">首页</a>
                                    </li>
                                    <li>基本信息展示</li>
                                </ul>
                                <!-- /BREADCRUMBS -->
                                <div class="clearfix">
                                    <h3 class="content-title pull-left">数据分析后台</h3>


                                    <!-- DATE RANGE PICKER -->
										<span class="date-range pull-right">
											<div class="btn-group">
                                                <a class="js_update btn btn-default" href="#">Today</a>
                                                <a class="js_update btn btn-default" href="#">Last 7 Days</a>
                                                <a class="js_update btn btn-default hidden-xs" href="#">Last month</a>
                                                <a id="reportrange" class="btn reportrange">
                                                    <i class="fa fa-calendar"></i>
                                                    <span></span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                            </div>
										</span>
                                    <!-- /DATE RANGE PICKER -->
                                </div>
                                <div class="description"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BOX -->
                            <div class="box border green">
                                <div class="box-title" style="height: 10px;"    >
                                    <h5><i class="fa fa-bars"></i> <span class="hidden-inline-mobile">基本信息报表</span></h5>
                                </div>
                                <div class="box-body">
<!--                                        <ul class="nav nav-tabs">-->
<!--                                            <li><a href="#box_tab2" data-toggle="tab"><i class="fa fa-search-plus"></i> <span class="hidden-inline-mobile">Select & Zoom Sales Chart</span></a></li>-->
<!--                                            <li class="active"><a href="#box_tab1" data-toggle="tab"><i class="fa fa-bar-chart-o"></i> <span class="hidden-inline-mobile">Traffic Statistics</span></a></li>-->
<!--                                        </ul>-->
                                        <div class="tab-content">

<!--                                            <div class="tab-pane fade" id="box_tab2">-->
                                            <div id="container" style="min-width: 200px;margin: 0 auto"></div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box border orange">

                            <div class="box-body">
                                <li class="datep"><input class="datainp wicon" id="inpstart" type="text" placeholder="开始日期" value=""  readonly></li>
                                <li class="datep"><input class="datainp wicon" id="inpend" type="text" placeholder="结束日期"   readonly></li>
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

                    </div>





                </div>
            </div>
        </div>
    </div>
  </section>                          <!-- /BOX -->




<script src="/js/jquery/jquery-2.0.3.min.js"></script>
<!--<script src="/js/script.js"></script>-->
<script src="/js/index-js/My_script.js"></script>
                                            <script type="text/javascript">
                                                $(function () {
                                                    $('#container').highcharts({
                                                        chart: {
                                                            type: 'line',
                                                        },
                                                        title: {
                                                            text: 'Monthly Average Temperature',
                                                            x: -20 //center
                                                        },
                                                        subtitle: {
                                                            text: 'Source: WorldClimate.com',
                                                            x: -20
                                                        },
                                                        xAxis: {
                                                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                                                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                                                        },
                                                        yAxis: {
                                                            title: {
                                                                text: 'Temperature (°C)'
                                                            },
                                                            plotLines: [{
                                                                value: 0,
                                                                width: 1,
                                                                color: '#808080'
                                                            }]
                                                        },
                                                        tooltip: {
                                                            valueSuffix: '°C'
                                                        },
                                                        legend: {
                                                            layout: 'vertical',
                                                            align: 'right',
                                                            verticalAlign: 'middle',
                                                            borderWidth: 0
                                                        },
                                                        series: [{
                                                            name: 'Tokyo',
                                                            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                                                        }, {
                                                            name: 'New York',
                                                            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
                                                        }, {
                                                            name: 'Berlin',
                                                            data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
                                                        }, {
                                                            name: 'London',
                                                            data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                                                        }]
                                                    });
                                                });
                                            </script>
                                            <script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
                                            <script src="http://cdn.hcharts.cn/highcharts/modules/exporting.js"></script>
<!-- 新 Bootstrap 核心 CSS 文件 -->
<!--<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">-->
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="/js/jedate/jquery.jedate.min.js"></script>
<script type="text/javascript">
    var start = {
        skinCell:"jedategreen",
        format: 'YYYY-MM-DD hh:mm:ss',
        minDate: '2014-06-16 23:59:59', //设定最小日期为当前日期
        //isinitVal:true,
        maxDate: $.nowDate(0), //最大日期
        choosefun: function(elem,datas){
            end.minDate = datas; //开始日选好后，重置结束日的最小日期
        }
    };
    var end = {
        format: 'YYYY-MM-DD hh:mm:ss',
        minDate: $.nowDate(0), //设定最小日期为当前日期
//        festival:true,
        //isinitVal:true,
        maxDate: '2099-06-16 23:59:59', //最大日期
        choosefun: function(elem,datas){
            start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
        }
    };
    $("#inpstart").jeDate(start);
    $("#inpend").jeDate(end);
</script>
</body>
</html>