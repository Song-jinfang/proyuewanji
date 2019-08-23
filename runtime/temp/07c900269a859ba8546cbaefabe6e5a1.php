<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:46:"./template/mobile/rainbow/payment/payment.html";i:1540260094;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>支付-<?php echo $tpshop_config['shop_info_store_title']; ?></title>
<meta name="keywords" content="<?php echo $tpshop_config['shop_info_store_keyword']; ?>" />
<meta name="description" content="<?php echo $tpshop_config['shop_info_store_desc']; ?>" />
<script src="/template/mobile/rainbow/static/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css">
*{ margin:0; padding:0}
.wihe-ee{ background:#FFF; padding:25px; color:#666; font-family:song,arial; font-size:14px; margin:0 auto; text-align:center}
.wihe-ee p{text-align:center}
.fail-I-success{margin-top:30px;border-bottom:1px solid #d8d8d8; padding-bottom:30px}
.co999{color:#999}
.fo-si-18{font-size:18px}
.fail-fasu{ text-align:center; border-bottom:1px solid #d8d8d8; padding-bottom:30px}
.success-fasu{margin-top:30px;  text-align:center}
.fail-fasu a:hover{ background-color:#ee9775}
.fail-fasu a{padding:8px 24px; background-color:#f8a584; display:table; margin:0 auto; color:#fff; text-decoration:none; margin-top:10px}
.re-qtzfgg a,.success-fasu a{padding:8px 24px; background-color:#eee; display:table; margin:0 auto; color:#999; text-decoration:none; margin-top:10px}
.re-qtzfgg a:hover,.success-fasu a:hover{background-color:#ddd;}
</style>
</head>
<body style=" max-width:640px; min-width:320px; margin:0 auto">
	<div class="tac-sd">
    	<div class="wihe-ee">
        	<p>
            	<span class="fo-si-18">请您在新打开的页面上完成付款!</span>
                <br>
                <span class="co999">付款完成前请不要关闭此窗口。完成付款后请根据您的情况点击下面的按钮。</span>
            </p>
            <br>
            <br>
           
            	<div class="fail-fasu">
                	<img src="/template/mobile/rainbow/static/images/suc_cg.png"/>
                	<p>支付完成</p>
                    <br>
                    <a href="<?php echo U('Mobile/order/order_detail',array('id'=>$order_id)); ?>">支付成功</a>
                </div>
                <div class="fail-I-success" >
                	<!--<img src="/template/mobile/rainbow/static/images/qrcode_vmall_app01.png" width="110" height="110"/>-->
                    <?php echo $code_str; ?>
                </div>
            	<div class="success-fasu">
                	<img src="/template/mobile/rainbow/static/images/suc_sb.png"/>
                	<p>支付遇到问题</p>
                    <br>
                    <a href="<?php echo U('Mobile/Cart/cart4',array('order_id'=>$order_id)); ?>">支付失败</a>
                </div>
           
            <div class="re-qtzfgg">
            	<a href="<?php echo U('Mobile/Cart/cart4',array('order_id'=>$order_id)); ?>">返回选择其他支付方式</a>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            setTimeout(function () {
                deeplinkCall();
            }, 200);
        });
        function deeplinkCall() {
            var deeplink = "<?php echo (isset($deeplink) && ($deeplink !== '')?$deeplink:''); ?>";
            var deeplink_flag = "<?php echo (isset($deeplink_flag) && ($deeplink_flag !== '')?$deeplink_flag:''); ?>";
            if (deeplink && deeplink_flag) {
                location.href = deeplink;
            }
        }
        /**
         * 检查订单状态
         */
        function ajax_check_pay_status() {
            $.ajax({
                type: "post",
                url: "<?php echo U('Home/Api/check_order_pay_status'); ?>",
                data: {order_id: "<?php echo $order_id; ?>"},
                dataType: 'json',
                success: function (data) {
                    if (data.status == 1) {
                        clearInterval(interval);
                        location.href = "<?php echo U('Mobile/Payment/pay_success',['order_id'=>$order_id]); ?>";
                       //location.href = "<?php echo U('Home/Cart/cart4',array('order_id'=>$order_id,'master_order_sn'=>$master_order_sn)); ?>";
                    }
                }
            });
        }
        var interval = setInterval(ajax_check_pay_status, 5000);

    </script>
</body>
</html>
