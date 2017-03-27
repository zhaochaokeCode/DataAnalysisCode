<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>中联百文 | 游戏数据分析后台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="/css/site/index/cloud-admin.css">
    <link rel="stylesheet" type="text/css" href="/css/themes/default.css" id="skin-switcher">
    <link rel="stylesheet" type="text/css" href="/css/site/index/responsive.css">
    <!-- STYLESHEETS --><!--[if lt IE 9]>
    <script src="/js/flot/excanvas.min.js"></script>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
    <link href="/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- ANIMATE -->
    <link rel="stylesheet" type="text/css" href="/css/animatecss/animate.min.css"/>
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" type="text/css" href="/js/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
    <!-- TODO -->
    <link rel="stylesheet" type="text/css" href="/js/jquery-todo/css/styles.css"/>
    <!-- FULL CALENDAR -->
    <link rel="stylesheet" type="text/css" href="/js/fullcalendar/fullcalendar.min.css"/>
    <!-- GRITTER -->
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css"/>
    <!-- FONTS -->
    <link rel="stylesheet" type="text/css" href="/js/datatables/media/assets/css/datatables.min.css"/>

    <!--日期时间样式-->
    <link type="text/css" rel="stylesheet" href="/js/jedate/skin/jedate.css">

    <style>
        #page {
            margin-left: auto;
            margin-right: auto;
            border: 1px solid #cdd2d2;
            width: 1230px;
            height: auto;
            t cext-align: left
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
                <!--                <img src="img/logo/logo.png" alt="Cloud Admin Logo" class="img-responsive" height="30" width="120">-->

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
                   data-icon2="fa fa-bars"></i>
            </div>
            <!-- /SIDEBAR COLLAPSE -->
        </div>
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
<!--                <li class="has-subhas-sub">-->
<!--                    <a href="javascript:;" class="">-->
<!--                        <i class="fa fa-bookmark-o fa-fw"></i> <span class="menu-text">游戏概况</span>-->
<!--                        <span class="arrow"></span>-->
<!--                    </a>-->
<!--                </li>-->
                <li class="has-sub">
                    <a href="javascript:;" class="">
                        <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">游戏概况<span
                                class="badge pull-right">9</span></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub" id="player">
                        <li><a id="tab_general_daily" href="#"><span class="sub-menu-text">游戏基本数据</span></a></li>
                        <li><a id="tab_actuser_daily" href="#"><span class="sub-menu-text">用户活跃</span></a></li>
                        <li><a id="tab_newuser_remain_daily" href="#"><span class="sub-menu-text">新用户流失</span></a></li>
                        <li><a id="tab_consumption_daily" href="#"><span class="sub-menu-text">商城统计</span></a></li>
                        <li><a id="tab_skill_up" href="#"><span class="sub-menu-text">技能功法消耗经验</span></a></li>
                        <li><a id="tab_jingjie_up" href="#"><span class="sub-menu-text">境界升级消耗经验</span></a></li>
                        <li><a id="tab_killboss" href="#"><span class="sub-menu-text">每日击杀boss数量</span></a></li>

                        <li><a id="tab_yuanbao" href="#"><span class="sub-menu-text">每日获得元宝数量</span></a></li>
<!--                        <li><a id="tab_killboss" href="#"><span class="sub-menu-text">每日击杀boss数量</span></a></li>-->

                    </ul>
                </li>
                <!--        <li class="has-sub">
                           <a href="javascript:;" class="">
                               <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">登录和留存<span
                                       class="badge pull-right">1</span></span>
                               <span class="arrow"></span>
                           </a>
                           <ul class="sub">
                               <li><a id="tab_login" href="#"><span class="sub-menu-text">每日登录用户</span></a>
                               <li><a id="tab_urlretention?type=1" href="#"><span class="sub-menu-text">用户留存</span></a>
                               <li><a id="tab_urlretention" href="#"><span class="sub-menu-text">用户留失</span></a>
                               </li>
                           </ul>
                       </li>
                       <li class="has-sub">
                           <a href="javascript:;" class="">
                               <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">用户充值<span
                                       class="badge pull-right">1</span></span>
                               <span class="arrow"></span>
                           </a>
                           <ul class="sub">
                               <li><a id="tab_urlcount/recharge" href="#"><span class="sub-menu-text">用户充值</span></a>
                               </li>
                           </ul>
                       </li>
                       <li class="has-sub">
                           <a href="javascript:;" class="">
                               <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">数据报表5<span
                                       class="badge pull-right">1</span></span>
                               <span class="arrow"></span>
                           </a>
                           <ul class="sub">
                               <li><a class="" href="search_results.html"><span class="sub-menu-text">Search Results</span></a>
                               </li>
                           </ul>
                       </li>
                       <li class="has-sub">
                           <a href="javascript:;" class="">
                               <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">数据报表6<span
                                       class="badge pull-right">1</span></span>
                               <span class="arrow"></span>
                           </a>
                           <ul class="sub">
                               <li><a class="" href="search_results.html"><span class="sub-menu-text">Search Results</span></a>
                               </li>
                           </ul>
                       </li>
                       <li class="has-sub">
                           <a href="javascript:;" class="">
                               <i class="fa fa-briefcase fa-fw"></i> <span class="menu-text">Other Pages <span
                                       class="badge pull-right">1</span></span>
                               <span class="arrow"></span>
                           </a>
                           <ul class="sub">
                               <li><a class="" href="search_results.html"><span class="sub-menu-text">Search Results</span></a>
                               </li>
                           </ul>
                       </li>
                   </ul>
                   --!>
                   <!-- /SIDEBAR MENU -->
        </div>
    </div>
    <!-- /SIDEBAR -->
    <div id="main-content">
        <!-- SAMPLE BOX CONFIGURATION MODAL FORM-->
        <div class="modal fade" id="box-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
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
                                    <div><h3 class="content-title pull-left" style="margin-left:20px;">查询条件</h3></div>
                                    <form id="serach">
                                        <div style="width:950px;height:70px ">
                                            <div style="margin-right:100px;margin-top:-25px;float:right;">
                                                开始日期:<input class="datainp wicon" id="inpstart" name='start' type="text"
                                                            value="">
                                                平台:<input class="datainp wicon" id="inpstart1" type="text" value=>
                                                角色id:<input class="" id="" type="text">
                                            </div>
                                            <div style="margin-right:100px;margin-top:10px;float:right;">
                                                结束日期:<input class="datainp wicon" id="inpend" name="end" type="text" >
                                                结束:<input class="datainp wicon" id="inpend2" type="text">
                                                结束:<input class="datainp wicon" id="inpend3" type="text">
                                            </div>
                                            <div id="hide_action" name="<?php echo $action?>" ></div>
                                        </div>
                                    </form>


                                </div>
                                <div style="margin-right:400px;margin-top:-25px;margin-bottom:5px;">
                                    <button id="sear" class="btn  btn-info " style="height:30px;width: 80px;float: right;margin-bottom:5px;margin-right:-300px">查询</button>
                                </div>
                                <div class="description"></div>

                            </div>
                        </div>
                    </div>


                    <iframe frameborder=0 src="/index/getdatas?action=<?php echo $action?>&page=1" name="ifrm" id="ifrm"
                            style="width:950px;height:1500px; margin-top: -10px;"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>            <!-- /BOX -->

<script src="/js/jquery/jquery-2.0.3.min.js"></script>
<!-- 新 Bootstrap 核心 CSS 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

<!-- 网站原有的js文件-->
<script src="/js/index-js/My_script.js"></script>

<!-- highcharts相关文件 -->
<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
<script src="http://cdn.hcharts.cn/highcharts/modules/exporting.js"></script>

<!-- 日期插件-->
<script src="/js/jedate/jquery.jedate.min.js"></script>
<script src="/js/jedate/comm_date.js"></script>

<!--搜索条件的js-->
<script src="/js/controller-js/index.js"></script>
<script type="text/javascript">

</script>

</body>
</html>