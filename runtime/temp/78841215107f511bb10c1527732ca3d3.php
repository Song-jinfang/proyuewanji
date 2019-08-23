<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:51:"./template/mobile/rainbow/public/dispatch_jump.html";i:1540260094;s:67:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header.html";i:1540260094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>系统提示--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <link rel="stylesheet" href="/template/mobile/rainbow/static/css/style.css">
    <link rel="stylesheet" type="text/css" href="/template/mobile/rainbow/static/css/iconfont.css"/>
    <script src="/template/mobile/rainbow/static/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <!--<script src="/template/mobile/rainbow/static/js/zepto-1.2.0-min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="/template/mobile/rainbow/static/js/style.js" type="text/javascript" charset="utf-8"></script>
    <script src="/template/mobile/rainbow/static/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/js/global.js"></script>
    <script src="/template/mobile/rainbow/static/js/layer.js"  type="text/javascript" ></script>
    <script src="/template/mobile/rainbow/static/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo (isset($tpshop_config['shop_info_store_ico']) && ($tpshop_config['shop_info_store_ico'] !== '')?$tpshop_config['shop_info_store_ico']:'/public/static/images/logo/storeico_default.png'); ?>" media="screen"/>
</head>
<body class="[body]">

    <div class="classreturn loginsignup">
        <div class="content">
            <div class="ds-in-bl return">
                <a href="javascript:history.back(-1);"><img src="/template/mobile/rainbow/static/images/return.png" alt="返回"></a>
            </div>
            <div class="ds-in-bl search center">
                <span>系统提示</span>
            </div>
            <!--<div class="ds-in-bl menu">
                <a href="javascript:void(0);"><img src="i/template/mobile/rainbow/static/mages/class1.png" alt="菜单"></a>
            </div>-->
        </div>
    </div>

    <div class="successsystem">
        <?php if($code == 1) {?>
            <img src="/template/mobile/rainbow/static/images/icogantanhao.png"></div>
        <?php }else{ ?>
            <img src="/template/mobile/rainbow/static/images/icogantanhao-sb.png"></div>
        <?php }?>
    </div>
    <p class="prompt_s">
        <?php if($code == 1) {?><?php echo(strip_tags($msg)); }else{?>
        <?php echo(strip_tags($msg)); }?> ，等待时间：<b id="wait"><?php echo($wait); ?></b>
    </p>

    <div class="systemprompt">
        <a href="<?php echo($url); ?>" id="href">返回上一页</a>
        <a href="<?php echo U('Index/index'); ?>">返回首页</a>
    </div>

<script src="/template/mobile/rainbow/static/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();

</script>
</body>
</html>
