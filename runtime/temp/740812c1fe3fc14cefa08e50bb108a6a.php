<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:47:"./template/mobile/rainbow/order/order_list.html";i:1540260094;s:67:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header.html";i:1540260094;s:71:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header_nav.html";i:1540260094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>我的订单--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
<body class="g4">

<div class="classreturn loginsignup ">
    <div class="content">
        <div class="ds-in-bl return">
            <a id="[back]" <?php  if(request()->action() == 'userinfo' && $_GET["action"]==""){  ?>  href="<?php echo U('User/index'); ?>" <?php  }else{  ?> href="<?php echo U('/Mobile/User/index'); ?>" <?php  }  ?> ><img src="/template/mobile/rainbow/static/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>我的订单</span>
        </div>
        <div class="ds-in-bl menu">
            <a href="javascript:void(0);"><img src="/template/mobile/rainbow/static/images/class1.png" alt="菜单"></a>
        </div>
    </div>
</div>
<div class="flool up-tpnavf-wrap tpnavf [top-header]">
    <div class="footer up-tpnavf-head">
    	<div class="up-tpnavf-i"> </div>
        <ul>
            <li>
                <a class="yello" href="<?php echo U('Index/index'); ?>">
                    <div class="icon">
                        <i class="icon-shouye iconfont"></i>
                        <p>首页</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Goods/categoryList'); ?>">
                    <div class="icon">
                        <i class="icon-fenlei iconfont"></i>
                        <p>分类</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Cart/index'); ?>">
                    <div class="icon">
                        <i class="icon-gouwuche iconfont"></i>
                        <p>购物车</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
	
$(function(){	
	$(window).scroll(function() {		
		if($(window).scrollTop() >= 1){ 
			$('.tpnavf').hide()
		}
	})
})
</script>
<div class="tit-flash-sale p mytit_flash">
    <div class="maleri30">
        <ul class="">
            <li <?php if(\think\Request::instance()->param('type') == ''): ?>class="red"<?php endif; ?>>
                <a href="<?php echo U('/Mobile/Order/order_list'); ?>" class="tab_head">全部订单</a>
            </li>
            <li id="WAITPAY" <?php if(\think\Request::instance()->param('type') == 'WAITPAY'): ?>class="red"<?php endif; ?>">
                <a href="<?php echo U('/Mobile/Order/order_list',array('type'=>'WAITPAY')); ?>" class="tab_head" >待付款</a>
            </li>
            <li id="WAITSEND" <?php if(\think\Request::instance()->param('type') == 'WAITSEND'): ?>class="red"<?php endif; ?>>
                <a href="<?php echo U('/Mobile/Order/order_list',array('type'=>'WAITSEND')); ?>"  class="tab_head">待发货</a>
            </li>
            <!--<li id="WAITRECEIVE"><a href="<?php echo U('/Mobile/User/order_list',array('type'=>'WAITRECEIVE')); ?>"  class="tab_head <?php if(\think\Request::instance()->param('type') == 'WAITRECEIVE'): ?>on<?php endif; ?>">待收货</a></li>-->
            <li id="WAITCCOMMENT"  <?php if(\think\Request::instance()->param('type') == 'FINISH'): ?>class="red"<?php endif; ?>>
                <a href="<?php echo U('/Mobile/Order/order_list',array('type'=>'FINISH')); ?>" class="tab_head">已完成</a>
            </li>
        </ul>
    </div>
</div>

    <!--订单列表-s-->
    <div class="ajax_return">
        <?php if(count($order_list) == 0): ?>
            <!--没有内容时-s--->
            <div class="comment_con p">
                <div class="none">
                    <img src="/template/mobile/rainbow/static/images/none2.png">
                    <br><br>
                    抱歉未查到数据！
                    <div class="paiton">
                        <div class="maleri30">
                            <a class="soon" href="/"><span>去逛逛</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--没有内容时-e--->
        <?php endif; if(is_array($order_list) || $order_list instanceof \think\Collection || $order_list instanceof \think\Paginator): $i = 0; $__LIST__ = $order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?>
            <div class="mypackeg ma-to-20 getmore">
                <div class="packeg p">
                    <div class="maleri30">
                        <div class="fl">
                            <h1><span></span><span class="bgnum"></span></h1>
                            <p class="bgnum"><span>订单编号:</span><span><?php echo $order['order_sn']; ?></span></p>
                        </div>
                        <div class="fr">
                            <span><?php echo $order['order_status_detail']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="shop-mfive p">
                    <div class="maleri30">
                        <?php if(is_array($order['order_goods']) || $order['order_goods'] instanceof \think\Collection || $order['order_goods'] instanceof \think\Paginator): $i = 0; $__LIST__ = $order['order_goods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?>
                            <div class="sc_list se_sclist paycloseto">
                                <a href="<?php echo U('/Mobile/Order/order_detail',array('id'=>$order['order_id'])); ?>">
                                <div class="shopimg fl">
                                    <img src="<?php echo goods_thum_images($goods[goods_id],200,200); ?>">
                                </div>
                                <div class="deleshow fr">
                                    <div class="deletes">
                                        <span class="similar-product-text"><?php echo getSubstr($goods[goods_name],0,20); ?></span>
                                    </div>
                                    <div class="deletes">
                                        <span class="similar-product-text"><?php echo $goods['spec_key_name']; ?></span>
                                    </div>
                                    <div class="prices  wiconfine">
                                        <p class="sc_pri"><span>￥</span><span><?php echo $goods[member_goods_price]; ?></span></p>
                                    </div>
                                    <div class="qxatten  wiconfine">
                                        <p class="weight"><span>数量</span>&nbsp;<span><?php echo $goods[goods_num]; ?></span></p>
                                       
                                    </div>
                                    <div class="buttondde">
                                        <?php if(!(empty($goods['return_goods']) || (($goods['return_goods'] instanceof \think\Collection || $goods['return_goods'] instanceof \think\Paginator ) && $goods['return_goods']->isEmpty()))): ?>
                                            <a class="applyafts">已申请售后</a>
                                            <?php else: if(($order['return_btn'] == 1)): ?>
                                                <a href="<?php echo U('Mobile/Order/return_goods',['rec_id'=>$goods['rec_id']]); ?>">申请售后</a>
                                            <?php endif; endif; ?>
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="shop-rebuy-price p">
                    <div class="maleri30">
                <span class="price-alln">
                    <!--<span class="red">￥<?php echo $list['order_amount']; ?></span><span class="threel">共<?php echo count($list['goods_list']); ?>件</span>-->
                    <span class="red">￥<?php echo $order['total_amount']; ?></span><span class="threel" id="goodsnum">共<?php echo $order['count_goods_num']; ?>件</span>
                    <!--if condition="$list['pay_code'] eq 'cod'"><i class="tits-ions qxatten-ions">货到付款</i></if -->
                </span>
                        <?php if($order['pay_btn'] == 1): ?>
                            <a class="shop-rebuy paysoon" href="<?php echo U('Mobile/Cart/cart4',array('order_id'=>$order['order_id'])); ?>">立即付款</a>
                        <?php endif; if($order['cancel_btn'] == 1): if($order['pay_status'] == 0): ?>
                                <a class="shop-rebuy " onClick="cancel_order(<?php echo $order['order_id']; ?>)">取消订单</a>
                            <?php endif; if($order['pay_status'] == 1): ?>
                                <a class="shop-rebuy" href="<?php echo U('Order/refund_order', ['order_id'=>$order['order_id']]); ?>">取消订单</a>
                            <?php endif; endif; if($order['receive_btn'] == 1 && order.pay_status == 1): ?>
                            <a class="shop-rebuy paysoon" onclick="orderConfirm(<?php echo $order['order_id']; ?>)">确认收货</a>
                        <?php endif; if($order['comment_btn'] == 1): ?>
                            <a class="shop-rebuy" href="<?php echo U('/Mobile/Order/comment'); ?>">评价</a>
                        <?php endif; if($order['shipping_btn'] == 1 && $order['shipping_name'] != ''): ?>
                            <a class="shop-rebuy" href="<?php echo U('Mobile/Order/express',array('order_id'=>$order['order_id'])); ?>">查看物流</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <!--订单列表-e-->
<script type="text/javascript" src="/template/mobile/rainbow/static/js/sourch_submit.js"></script>
<script type="text/javascript">
    /**
     * 取消订单
     */
    function cancel_order(id){
        if(!confirm("确定取消订单?"))
            return false;
        $.ajax({
            type: 'GET',
            dataType:'JSON',
            url:"/index.php?m=Mobile&c=Order&a=cancel_order&id="+id,
            success:function(data){
                if(data.code == 1){
                    layer.open({content:data.msg,time:1});
                    location.href = "/index.php?m=Mobile&c=Order&a=order_list";
                }else{
                    layer.open({content:data.msg,time:2});
                    location.href = "/index.php?m=Mobile&c=Order&a=order_list";
                    return false;
                }
            },
            error:function(){
                layer.open({content:'网络异常，请稍后重试',time:3});
            },
        });
    }

    /**
     * 确定收货
     */
    function orderConfirm(id){
        if(!confirm("确定收到该订单商品吗?"))
            return false;
        location.href = "/index.php?m=Mobile&c=Order&a=order_confirm&id="+id;
    }

    var  page = 1;
    /**
     *加载更多
     */
    function ajax_sourch_submit()
    {
        page += 1;
        $.ajax({
            type : "GET",
            url:"/index.php?m=Mobile&c=Order&a=order_list&type=<?php echo \think\Request::instance()->param('type'); ?>&is_ajax=1&p="+page,//+tab,
            success: function(data)
            {
                if(data == '')
                    $('#getmore').hide();
                else
                {
                    $(".ajax_return").append(data);
                    $(".m_loading").hide();
                }
            }
        });
    }
</script>
</body>
</html>
