<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>中联百文 | 登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- STYLESHEETS --><!--[if lt IE 9]><script src="/js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
    <link rel="stylesheet" type="text/css" href="/css/cloud-admin.css" >
    <link href="/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" type="text/css" href="/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <!-- UNIFORM -->
    <link rel="stylesheet" type="text/css" href="/js/uniform/css/uniform.default.min.css" />
    <!-- ANIMATE -->
    <link rel="stylesheet" type="text/css" href="/css/animatecss/animate.min.css" />
</head>
<body class="login">
<!-- PAGE -->
<section id="page">
    <!-- HEADER -->
    <header>
       <!-- NAV-BAR -->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-4 col-md-offset-4">-->
<!--                    <div id="logo">-->
<!--                        <a href="index.html"><img src="img/logo/logo-alt.png" height="40" alt="logo name" /></a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
       <!--/NAV-BAR -->
    </header>
    <!--/HEADER -->
    <!-- LOGIN -->
    <section id="login" class="visible">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-box-plain">
                        <h6>中联百文数据分析后台</h6>
                        <h2 class="bigintro">登录</h2>
                        <div class="divide-40"></div>
                        <form role="form" id="login_form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">用户名</label>
                                <i class="fa fa-envelope"></i>
                                <input type="name" class="form-control" name="name" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">密码</label>
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1" >
                            </div>
                            <div class="form-actions">
<!--                                <label class="checkbox"> <input type="checkbox" class="uniform" value=""></label>-->
                                <button type="submit" class="btn btn-danger" onclick=" submitBut('login_form') ;return false">登录</button>
                            </div>
                        </form>
                        <!-- SOCIAL LOGIN -->
                        <div class="divide-20"></div>

                        <!-- /SOCIAL LOGIN -->
                        <div class="login-helpers">
                            <a href="#" onclick="swapScreen('forgot');return false;">忘记密码?</a>
                            没有帐号? <a href="#" onclick="swapScreen('register');return false;">注册</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/LOGIN -->
    <!-- REGISTER -->
    <section id="register">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-box-plain">
                        <h2 class="bigintro">注册</h2>
                        <div class="divide-40"></div>
                        <form role="form" id="regist">

                            <div class="form-group">
                                <label for="exampleInputUsername">用户名</label>
                                <i class="fa fa-user"></i>
                                <input type="text" class="form-control" id="exampleInputUsername" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">邮箱</label>
                                <i class="fa fa-envelope"></i>
                                <input type="email" class="form-control" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">密码</label>
                                <i class="fa fa-lock"></i>
                                <input type="password" class="form-control" id="exampleInputPassword1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">重复密码</label>
                                <i class="fa fa-check-square-o"></i>
                                <input type="password" class="form-control" id="exampleInputPassword2" >
                            </div>
                            <div class="form-actions">
<!--                                <label class="checkbox"> <input type="checkbox" class="uniform" value=""> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>-->
                                <button type="submit" class="btn btn-success">Sign Up</button>
                            </div>
                        </form>
                        <!-- SOCIAL REGISTER -->
                        <div class="divide-20"></div>
                        <div class="center">
                            <strong>Or register using your social account</strong>
                        </div>
                        <div class="divide-20"></div>
                        <div class="social-login center">
                            <a class="btn btn-primary btn-lg">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a class="btn btn-info btn-lg">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a class="btn btn-danger btn-lg">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                        <!-- /SOCIAL REGISTER -->
                        <div class="login-helpers">
                            <a href="#" onclick="swapScreen('login');return false;"> Back to Login</a> <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/REGISTER -->
    <!-- FORGOT PASSWORD -->
    <section id="forgot">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-box-plain">
                        <h2 class="bigintro">Reset Password</h2>
                        <div class="divide-40"></div>
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Enter your Email address</label>
                                <i class="fa fa-envelope"></i>
                                <input type="email" class="form-control" id="exampleInputEmail1" >
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-info">Send Me Reset Instructions</button>
                            </div>
                        </form>
                        <div class="login-helpers">
                            <a href="#" onclick="swapScreen('login');return false;">Back to Login</a> <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="disapp"></div>
    </section>
    <!-- FORGOT PASSWORD -->
</section>
<!--/PAGE -->
<!-- JAVASCRIPTS -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- JQUERY -->
<script src="/js/jquery/jquery-2.0.3.min.js"></script>
<script src="/js/controller-js/login.js"></script>
<!--<script src="/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>-->
<!--<script src="/bootstrap-dist/js/bootstrap.min.js"></script>-->
<!--<script type="text/javascript" src="/js/uniform/jquery.uniform.min.js"></script>-->
<!-- CUSTOM SCRIPT-->
<!--<script>-->
<!--    jQuery(document).ready(function() {-->
<!--        App.setPage("login");  //Set current page-->
<!--        App.init(); //Initialise plugins and elements-->
<!--    });-->
<script type="text/javascript">
//    function swapScreen(id) {
//        jQuery('.visible').removeClass('visible animated fadeInUp');
//        jQuery('#'+id).addClass('visible animated fadeInUp');
//    }
</script>
<style type="text/css">
    .alertWindowContent h1,p{text-align: center;font-size: 18px;font-weight: bolder;}
    .alertWindowContent input{width: 100px; height: 50px;cursor: pointer;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;}
</style>
<!-- /JAVASCRIPTS-->
</body>
</html>
<?php die;?>