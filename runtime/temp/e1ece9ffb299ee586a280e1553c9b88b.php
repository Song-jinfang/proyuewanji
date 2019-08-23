<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:46:"./template/mobile/rainbow/payment/success.html";i:1540260094;s:67:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header.html";i:1540260094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>支付成功--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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

<div class="completionpay">
    <div class="maleri30">
        <div class="llog"><img src="<?php echo $tpshop_config['shop_info_store_logo']; ?>"/></div>
        <div class="heses">
            <div class="zbzim"><img src="/template/mobile/rainbow/static/images/sbzf.png"/></div>
            <p class="success"><span>
            			<?php if($order['pay_code'] == 'cod'): ?>订单提交成功<?php else: ?>订单支付成功<?php endif; ?>，我们将在第一时间给你发货！</span></p>
            <p class="ddnum"><span>订单号：</span><span><?php echo $order['order_sn']; ?></span></p>
            <p class="ddnum"><span>
            			<?php if($order['pay_code'] == 'cod'): ?>您需要支付金额<?php else: ?>付款金额<?php endif; ?>：</span><span class="red"><?php echo $order['order_amount']; ?></span><span>元</span></p>
            <p class="ddnum"><span>请你保持手机畅通，等待收货。</span></p>
            <div class="ddxq-succ"><a href="<?php echo U('/Mobile/Order/order_detail',array('id'=>$order['order_id'])); ?>">订单详情</a></div>
        </div>
    </div>
</div>
</body>
</html>

