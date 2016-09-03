<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>数据中心 | 登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- STYLESHEETS --><!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
    <link rel="stylesheet" type="text/css" href="css/cloud-admin.css" >

    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" type="text/css" href="js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <!-- UNIFORM -->
    <link rel="stylesheet" type="text/css" href="js/uniform/css/uniform.default.min.css" />
    <!-- ANIMATE -->
    <link rel="stylesheet" type="text/css" href="css/animatecss/animate.min.css" />
    <!-- FONTS -->
    <!--
    <link href='http://fonts.useso.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    -->
</head>
<body class="login">
<!-- PAGE -->
<section id="page">
    <!-- LOGIN -->
    <section id="login" class="visible">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-box-plain">
                        <h3 class="bigintro">登录</h3>
                        <div class="divide-40"></div>
                        <form id="login-form">
                            <input type="hidden" name="csrfToken" value="{Yii::$app->request->getCsrfToken(true)}" />

                            <div class="form-group">
                                <label for="exampleInputEmail1">用户名</label>
                                <i class="fa fa-user"></i>
                                <input type="text" class="form-control" name="username" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">密码</label>
                                <i class="fa fa-lock"></i>
                                <input type="password" class="form-control" name="password" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">验证码</label>
                                <div >
                                    <div class="input-group">
                                        <i class="fa fa-barcode"></i>
                                        <input type="text" class="form-control" name="captcha">
                                        <span class="input-group-btn">
                                            <button onclick="refreshCaptcha(this)" id="captcha" class="btn btn-primary" type="button" style="padding: 0px">
                                                <img src="index.php?r=site/captcha&gen=true">
                                            </button>
                                        </span>
                                    </div>

                                </div>
                            </div>

                            <div class="form-actions">
                                <label class="checkbox"> <input type="checkbox" class="uniform" value=""> Remember me</label>
                                <button type="" onclick="login();return false;" class="btn btn-danger">登录</button>
                            </div>

                        </form>

                        <div class="login-helpers">
                            <a href="#" onclick="return false;">忘记密码？</a>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/LOGIN -->

</section>
<!--/PAGE -->
<!-- JAVASCRIPTS -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- JQUERY -->
<script src="js/jquery/jquery-2.0.3.min.js"></script>
<!-- JQUERY UI-->
<script src="js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- BOOTSTRAP -->
<script src="bootstrap-dist/js/bootstrap.min.js"></script>


<!-- UNIFORM -->
<script type="text/javascript" src="js/uniform/jquery.uniform.min.js"></script>
<!-- CUSTOM SCRIPT -->
<script src="js/script.js"></script>
<script>
    jQuery(document).ready(function() {
        App.setPage("login");  //Set current page
        App.init(); //Initialise plugins and elements
    });
</script>
<script type="text/javascript">
    function login()
    {
        var form = $('#login-form').serializeArray();
        $.post('index.php?r=site/do-login', form, function (data) {
            var result = eval('(' + data + ')');
            if (result.error == 0) {
                console.log('Logged-in OK');
                window.location.href = 'index.php?r=data-center/stations';
            } else {
                console.log(data);
            }
        });
        return false;
    }

    function refreshCaptcha(button)
    {
        // console.log($(button))
        $(button).find('img').attr('src', 'index.php?r=site/captcha&gen=true&f=' + Math.random());
    }

    $(function () {

    })

</script>
<!-- /JAVASCRIPTS -->
</body>
</html>