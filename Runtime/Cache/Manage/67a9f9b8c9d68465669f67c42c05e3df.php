<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
    <meta charset="utf-8">

    <title>内容管理后台</title>
    <meta name="author" content="Justering">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Justeirng CMS">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

    <!-- Stylesheets -->
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" type="text/css" href="/Public/Static/bootstrap/css/bootstrap3.1.1.min.css" />
    <!-- Related styles of various icon packs and plugins -->
    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/magnific-popup.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/plugins.css" />

    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/main.css" />

    <!-- <link id="theme-link" rel="stylesheet" href="/Public/Static/proui/css/themes/flatie.css"> -->

    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/themes.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Static/proui/css/css3-cheat.css" />

    <link rel="stylesheet" type="text/css" href="/Public/Manage/css/style.css" />

    <script type="text/javascript" src="/Public/Static/proui/js/modernizr-2.7.1-respond-1.4.2.min.js"></script>

    <script type="text/javascript" src="/Public/Static/jquery-2.0.3.min.js"></script>    
    <script type="text/javascript" src="/Public/Static/bootstrap/js/bootstrap3.1.1.min.js"></script>
    <script type="text/javascript" src="/Public/Static/proui/js/plugins.js"></script>
    <script type="text/javascript" src="/Public/Static/proui/js/slim-scroll.min.js"></script>

    <script type="text/javascript" src="/Public/Static/ueditor1_4_3/ueditor.config.js"></script>
    <script type="text/javascript" src="/Public/Static/ueditor1_4_3/ueditor.all.js"></script>

    <script type="text/javascript" src="/Public/Static/jssrc/map.js"></script>
    <script type="text/javascript" src="/Public/Static/jssrc/application.js"></script>
    <script type="text/javascript" src="/Public/Static/jssrc/customize.js"></script>

    <script type="text/javascript" src="/Public/Static/jquery.datepicker/datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Static/jquery.datepicker/datepicker.css" />

    <script type="text/javascript" src="/Public/Static/jquery.tokeninput/jquery.tokeninput.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Static/jquery.tokeninput/token-input.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Static/jquery.tokeninput/token-input-facebook.css" />

    <script type="text/javascript" src="/Public/Static/jquery.typeahead.js"></script>

    <script type="text/javascript" src="/Public/Static/uploadify/jquery.uploadify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Static/uploadify/uploadify.css" />

    <script type="text/javascript" src="/Public/Static/dragsort/jquery.dragsort-0.5.1.js"></script>

    <script type="text/javascript" src="/Public/Static/colortip/colortip-1.0-jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Static/colortip/colortip-1.0-jquery.css" />

<!--notify start-->
<script type="text/javascript" src="/Public/Static/noty/packaged/jquery.noty.packaged.js"></script>
<script type="text/javascript">
    function display_noty(text, type) {
        if(!type) {
            type = 'error';
        }
        var n = noty({
            text        : text,
            type        : type,
            dismissQueue: true,
            layout      : 'topCenter',
            theme       : 'defaultTheme',
            timeout     : 4000,
        });
    }

    $(document).ready(function() {
        var session_success_msg = '<?php echo session("success", NULL);?>';
        if(session_success_msg) {
            display_noty(session_success_msg, 'success');
        }

        var session_error_msg = '<?php echo session("error", NULL);?>';
        if(session_error_msg) {
            display_noty(session_error_msg, 'error'); 
        }
    });
</script>
<!--notify end-->
<script type="text/javascript" src="/Public/Manage/js/common.js"></script>    
 
</head>
<body>

<script>
    //ie浏览器低版本判断提醒
    var b_version=navigator.appVersion
    var version=b_version.split(";")+'';
    if(version.indexOf('MSIE 6.0') !=-1 || version.indexOf('MSIE 7.0') !=-1 || version.indexOf('MSIE 8.0') !=-1)
    {
        alert('你的浏览器版本过低，请使用ie9及以上，或者谷歌、火狐等浏览器，否则可能导致某些后台功能用不到');
    } 
</script>
<div id="login-container" class="animation-fadeIn">
    <div class="login-title text-center">
        <h1>登录网站后台</h1>
    </div>

    <div class="block remove-margin">
        <form action="<?php echo U('login');?>" method="post" id="form-login" class="form-horizontal form-bordered post_ajax_form">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-user"></i></span>
                        <input type="text" id="username" name="username" class="form-control input-lg" placeholder="用户名">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                        <input type="password" id="password" name="password" class="form-control input-lg" placeholder="密码">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-lock"></i></span>
                        <input type="text" id="captcha" name="captcha" class="form-control input-lg" placeholder="验证码" style="width:280px">
                        <img id="captcha_img" title="点击刷新验证码" src="<?php echo U('Public/captcha');?>" 
                            onclick="jQuery('#captcha_img').attr('src','<?php echo U('Public/captcha');?>?'+ Math.random())"  style="cursor: pointer;height:45px;">
                    </div>
                </div>
            </div>

            <div class="form-group form-actions">
                <div class="col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary" data-loading-text="登录中..."><i class="fa fa-angle-right"></i> 登录</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="/Public/Static/js/form_post.js"></script>