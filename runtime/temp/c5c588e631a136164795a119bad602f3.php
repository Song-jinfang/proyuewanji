<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:49:"./template/mobile/rainbow/order/order_detail.html";i:1540260094;s:67:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header.html";i:1540260094;s:71:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header_nav.html";i:1540260094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>订单详情--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <a id="[back]" <?php  if(request()->action() == 'userinfo' && $_GET["action"]==""){  ?>  href="<?php echo U('User/index'); ?>" <?php  }else{  ?> href="javascript:history.back(-1)" <?php  }  ?> ><img src="/template/mobile/rainbow/static/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>订单详情</span>
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
<!--订单详情自提s-->
<?php if($order['shop_id'] > 0): ?>
    <div class="details-list-wrap">
        <div class="details-list maleri30 ">
            <div class="details-list-header p">
                <div class="details-list-a list-a-one fl"><a><?php echo $order['order_status_detail']; ?></a></div>
                <div class="details-list-a list-a-two fl"><a href="tel:<?php echo $order['shop']['shop_phone']; ?>">联系自提点</a></div>
                <div class="details-list-img fr">
                    <a class="list-img-a"><img src="/template/mobile/rainbow/static/images/z-tihuoma.png"/></a>
                    <p class="list-img-title">提货码</p>
                </div>
            </div>
            <!--扫货码 弹窗s-->
            <div class="Scavenging-pop-wrap" style="display: none;">
		            <div class="package-pop-bg-opacity" ></div>
		            <div class="Scavenging-pop-head" >
		                <i></i>
		                <h5>查看提货码</h5>
		            </div>
		            <div class="Scavenging-pop" >
		                <div class="Scavenging-pop-header">
		                    自提订单提货凭证
		                </div>
		                <div class="Scavenging-pop-img-one">
		                    <img src="/template/mobile/rainbow/static/images/z-saohuoma.png"/>
		                </div>
		                <p class="Scavenging-pop-img-title">提货码:<?php echo $order['shop_order']['shop_order_id']; ?></p>
		                <div class="Scavenging-pop-img-two">
		                    <img src="/template/mobile/rainbow/static/images/z-gongzonghao.png"/>
		                </div>
		                <div class="Scavenging-pop-cont">
		                    <ul>
		                        <li>
		                            提<b></b> 货<b></b>人：<em><?php echo $order['consignee']; ?></em><i><?php echo $order['mobile']; ?></i>
		                        </li>
		                        <li>
		                            提货地址：<em><?php echo $order['full_address']; ?></em>
		                        </li>
		                        <li>
		                            提货时间：<em><?php echo $order['shop_order']['take_time']; ?></em>
		                        </li>
		                    </ul>
		                </div>
		                <div class="Scavenging-pop-footer">
		                    <ul>
		                        <li>
		                            订单编号：<?php echo $order['order_sn']; ?>
		                        </li>
		                        <li>
		                            实付金额：<?php echo $order['order_amount']; ?>元
		                        </li>
		                    </ul>
		                </div>
		            </div>
		            <div class="Scavenging-pop-close"></div>
             </div>
            <!--扫货码 弹窗e-->
            <!--扫货码 弹窗功能s-->
            <script type="text/javascript">
                $(".details-list-wrap .details-list-img").click(function  () {
                    $(".Scavenging-pop-wrap").show();
                })
                $(".Scavenging-pop-head i,.Scavenging-pop-close").click(function  () {
                    $(this).parents(".Scavenging-pop-wrap").hide();
                })
            </script>
            <!--扫货码 弹窗e-->
            <div class="details-progress">
                <ul class="p">
                    <li class="fl">买家下单</li>
                    <li class="fl">支付成功</li>
                    <li class="fl details-li-color">上门自提</li>
                    <li class="fl details-li-color">交易完成</li>
                </ul>
                <div class="progress-icon-wrap">
                    <dl class="p">
                        <dt class="fl"></dt>
                        <?php if($order['pay_status'] == 1): ?>
                            <dt class="fl"></dt>
                            <?php else: ?>
                            <dd class="fl"></dd>
                        <?php endif; if(($order['shop_id'] == 0 and $order[shipping_time] == 0) or $order[shop_order][is_write_off] == 1): ?>
                            <dt class="fl"></dt>
                            <?php else: ?>
                            <dd class="fl"></dd>
                        <?php endif; if($order[confirm_time] > 0): ?>
                            <dt class="fl"></dt>
                            <?php else: ?>
                            <dd class="fl"></dd>
                        <?php endif; ?>
                    </dl>
                    <div class="details-progress-icon">

                    </div>
                </div>
            </div>
            <div class="invoice list7">
                <div class="myorder p">
                    <div class="content30">
                        <a class="remain" href="javascript:void(0);">
                            <div class="order">
                                <div class="fl">
                                    <span>自提时间</span>
                                </div>
                                <div class="fr">
			                    <span class="invoice_Package" style="margin-top: 0.6rem;">
			                        <input type="text" placeholder="<?php echo $order['shop_order']['take_time']; ?>" id="demo_datetime" />
			                         <em>【<?php echo weekday_by_time_str($order['shop_order']['take_time']); ?>】</em>
			                    </span>
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="invoice list7">
                <div class="myorder  p">
                    <div class="content30">
                        <a class="remain" href="javascript:void(0);">
                            <div class="order">
                                <div class="fl">
                                    <span>自提地点</span>
                                </div>
                                <div class="fr">
                                    <span class="invoice_Package" style="margin-top: 0.6rem;"><?php echo $order['shop']['shop_name']; ?>(<em><?php echo $order['address']; ?></em>)</span>
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="invoice list7">
                <div class="myorder myorder-two p">
                    <div class="content30">
                        <a class="remain" href="javascript:void(0);">
                            <div class="order">
                                <div class="fl">
                                    <span>提货人</span>
                                </div>
                                <div class="fr">
                                    <span class="invoice_Package" style="margin-top: 0.6rem;"><?php echo $order['consignee']; ?>&nbsp;&nbsp;<em><?php echo $order['mobile']; ?></em></span>
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="ttrebu">
            <img src="/template/mobile/rainbow/static/images/tt.png"/>
        </div>
        <div class="Pending-delivery">
            <?php echo $order['order_status_detail']; ?>
        </div>

    </div>
<?php endif; ?>
<!-- 订单详情自提e-->
<!--订单商品列表-s-->
<div class="ord_list p">
    <div class="maleri30">
        <?php if(is_array($order['order_goods']) || $order['order_goods'] instanceof \think\Collection || $order['order_goods'] instanceof \think\Paginator): $i = 0; $__LIST__ = $order['order_goods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?>
            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$good[goods_id])); ?>">
                <div class="shopprice">
                    <div class="img_or fl">
                        <img src="<?php echo goods_thum_images($good[goods_id],100,100); ?>"/>
                    </div>
                    <div class="fon_or fl">
                        <h2 class="similar-product-text"><?php echo $good[goods_name]; ?></h2>
                        <div><span class="bac"><?php echo $good['spec_key_name']; ?></span></div>
                    </div>
                    <div class="price_or fr">
                        <p><span>￥</span><span><?php echo $good['member_goods_price']; ?></span></p>
                        <p>x<?php echo $good['goods_num']; ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<!--订单商品列表-e-->
<div class="qqz">
    <div class="maleri30">
        <!--<a href="tel:<?php echo $tpshop_config['shop_info_phone']; ?>">联系客服</a>-->
        <!--<a href="/mobile/supplier/index/goods_id/<?php echo $order->orderGoods[0]->goods_id; ?>/order_id/<?php echo $order['order_id']; ?>.html" class="kf" txt="沃购要跳为im">
            联系客服
        </a>-->
        <?php if($order['cancel_btn'] == 1): ?>
            <a class="closeorder_butt" >取消订单</a>
        <?php endif; if($order['cancel_info'] == 1): ?>
            <a class="" href="<?php echo U('Order/cancel_order_info',['order_id'=>$order['order_id']]); ?>">取消进度</a>
        <?php endif; ?>
    </div>
</div>
<div class="information_dr ma-to-20">
    <div class="maleri30">
        <div class="tit">
        	<!-- if condition="$order['pay_code'] eq 'cod'"><i class="tits-ions">货到付款</i></if -->
            <h2>基本信息</h2>
        </div>
        <div class="xx-list">
            <p class="p">
                <span class="fl">订单编号</span>
                <span class="fr"><?php echo $order['order_sn']; ?></span>
            </p>
            <p class="p">
                <span class="fl">下单时间</span>
                <span class="fr"><span><?php echo date('Y-m-d  H:i:s', $order['add_time']); ?></span></span>
            </p>
            <p class="p">
                <span class="fl">收货地址</span>
                <span class="fr" style="max-width: 10rem; line-height: 0.80rem;overflow: hidden;"><?php echo $order['full_address']; ?></span>
            </p>
            <p class="p">
                <span class="fl">收货人</span>
                <span class="fr"><span><?php echo $order['consignee']; ?></span><span><?php echo $order['mobile']; ?></span></span>
            </p>
            <p class="p">
                <span class="fl">支付方式</span>
                <span class="fr">
                    <?php if($order[pay_status] == 1 and empty($order['pay_name'])): ?>
                        在线支付
                        <?php else: ?>
                        <?php echo $order['pay_name']; endif; ?>
                </span>
            </p>
            <p class="p">
                <span class="fl">配送方式</span>
                <span class="fr"><?php echo $order['delivery_method']; if($order['shop_id'] == 0): if(is_array($order['delivery_doc']) || $order['delivery_doc'] instanceof \think\Collection || $order['delivery_doc'] instanceof \think\Paginator): if( count($order['delivery_doc'])==0 ) : echo "" ;else: foreach($order['delivery_doc'] as $key=>$v): ?><?php echo $v['shipping_name']; endforeach; endif; else: echo "" ;endif; endif; ?>
                </span>
            </p>
            <p class="p">
                <span class="fl">买家留言</span>
                <span class="fr"><?php echo $order['user_note']; ?></span>
            </p>
            <?php if($order['prom_type'] == 4): if($order['pre_sell']['is_finished'] == 3): ?>
                    <p class="p">
                        <span class="fl">订单关闭</span>
                        <span class="fr">商家取消活动，返还订金</span>
                    </p>
                <?php endif; if($order['pre_sell']['is_finished'] == 2): if(time() > $order['pre_sell']['pay_end_time'] AND $order['pay_status'] != 1): ?>
                        <p class="p">
                            <span class="fl">订单关闭</span>
                            <span class="fr">已过支付尾款时间</span>
                        </p>
                    <?php endif; endif; endif; ?>
        </div>
    </div>
</div>
<div class="information_dr ma-to-20">
    <div class="maleri30">
        <div class="tit">
            <h2>价格信息</h2>
        </div>
        <div class="xx-list">
            <?php if($order['prom_type'] != 4): ?>
                <p class="p">
                    <span class="fl">商品总价</span>
                    <span class="fr"><span>￥</span><span><?php echo $order['goods_price']; ?></span>元</span>
                </p>
                <p class="p">
                    <span class="fl">运费</span>
                    <span class="fr"><span>￥</span><span><?php echo $order['shipping_price']; ?></span>元</span>
                </p>
                <p class="p">
                    <span class="fl">优惠券</span>
                    <span class="fr"><span>-￥</span><span><?php echo $order['coupon_price']; ?></span>元</span>
                </p>
                <p class="p">
                    <span class="fl">活动优惠</span>
                    <span class="fr"><span>-￥</span><span><?php echo $order['order_prom_amount']; ?></span>元</span>
                </p>
                <p class="p">
                    <span class="fl">积分</span>
                    <span class="fr"><span>-￥</span><span><?php echo $order['integral_money']; ?></span>元</span>
                </p>
            <?php endif; ?>
            <p class="p">
                <span class="fl">余额</span>
                <span class="fr"><span>-￥</span><span><?php echo $order['user_money']; ?></span>元</span>
            </p>
            <!-- 预售商品 start -->
            <?php if($order['prom_type'] == 4): if($order['paid_money'] > 0): if($order['pay_status'] == 1): ?>
                        <p class="p">
                            <span class="fl">已付尾款</span>
                            <span class="fr"><span>-￥</span><span><?php echo $order['order_amount']; ?></span>元</span>
                        </p>
                    <?php endif; ?>
                    <p class="p">
                        <span class="fl">已付订金</span>
                        <span class="fr"><span>-￥</span><span><?php echo $order['paid_money']; ?></span>元</span>
                    </p>
                    <p class="p">
                        <span class="fl">发货时间</span>
                        <span class="fr"><span><?php echo $order['pre_sell']['delivery_time_desc']; ?></span></span>
                    </p>
                <?php endif; if($order['pay_status'] == 0 AND $order['pre_sell']['deposit_price'] > 0): ?>
                    <p class="p">
                        <span class="fl">应付订金</span>
                        <span class="fr"><span>-￥</span><span><?php echo $order['order_amount']; ?></span>元</span>
                    </p>
                    <p class="p">
                        <span class="fl">尾款</span>
                        <span class="fr"><span>-￥</span><span><?php echo $order['total_amount'] - $order['order_amount']; ?></span>元</span>
                    </p>
                <?php endif; endif; ?>
            <!-- 预售商品 end -->

            <p class="p">
                <span class="fl">订单总额</span>
                <span class="fr red"><span>￥</span><span><?php echo $order['total_amount']; ?></span>元</span>
            </p>
        </div>
    </div>
</div>

<!--取消订单-s-->
<div class="losepay closeorder" style="display: none;">
    <div class="maleri30">
        <p class="con-lo">取消订单后,存在促销关系的子订单及优惠可能会一并取消。是否继续？</p>
        <div class="qx-rebd">
            <a class="ax">取消</a>
            <?php if($order['pay_status'] == 0): ?>
                <a class="are" onclick="cancel_order(<?php echo $order['order_id']; ?>)">确定</a>
            <?php endif; if($order['pay_status'] == 1): ?>
                <a class="are" href="<?php echo U('Order/refund_order', ['order_id'=>$order['order_id']]); ?>">取消订单</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--取消订单-e-->

<div class="mask-filter-div" style="display: none;"></div>

<!--底部支付栏-s-->
<div class="payit ma-to-20">
    <!--<div class="fl">-->
    <!--<p><span class="pmo">实付金额：</span>-->
    <!--<span>￥</span><span><?php echo $order['order_amount']+$order['shipping_price']; ?></span>-->
    <!--</p>-->
    <!--<p class="lastime"><span>付款剩余时间：</span><span id="lasttime"></span></p>-->
    <!--&lt;!&ndash;<p class="deel"><a href="<?php echo U('Mobile/User/order_del',array('order_id'=>$order['order_id'])); ?>">删除订单</a></p>&ndash;&gt;-->
    <!--</div>-->
    <div class="fr s">
        <?php if($order['pay_btn'] == 1): ?>
            <a href="<?php echo U('Mobile/Cart/cart4',array('order_id'=>$order['order_id'])); ?>">立即付款</a>
        <?php endif; if($order['receive_btn'] == 1): ?>
            <a href="<?php echo U('Mobile/Order/order_confirm',array('id'=>$order['order_id'])); ?>">收货确认</a>
        <?php endif; if($order['shipping_btn'] == 1): ?>
            <a href="<?php echo U('Mobile/Order/express',array('order_id'=>$order['order_id'])); ?>" >查看物流</a>
        <?php endif; if($order['pay_tail_btn'] == 1): ?>
            <a href="<?php echo U('/Mobile/Cart/cart4',array('order_id'=>$order[order_id])); ?>">支付尾款</a>
        <?php endif; ?>
    </div>
</div>
<!--底部支付栏-d-->

<script type="text/javascript">
    //取消订单按钮
    $('.closeorder_butt').click(function(){
        $('.mask-filter-div').show();
        $('.losepay').show();
    })
    //取消取消订单
    $('.qx-rebd .ax').click(function(){
        $('.mask-filter-div').hide();
        $('.losepay').hide();
    })

    //确认取消订单
    function cancel_order(id){
        $.ajax({
            type: 'GET',
            dataType:'JSON',
            url:"/index.php?m=Mobile&c=Order&a=cancel_order&id="+id,
            success:function(data){
                if(data.code == 1){
                    layer.open({content:data.msg,time:2});
                    location.href = "/index.php?m=Mobile&c=Order&a=order_detail&id="+id;
                }else{
                    layer.open({content:data.msg,time:2});
                    location.href = "/index.php?m=Mobile&c=Order&a=order_detail&id="+id;
                    return false;
                }
            },
            error:function(){
                layer.open({content:'网络异常，请稍后重试',time:3});
            },
        });
        $('.mask-filter-div').hide();
        $('.losepay').hide();
    }


    //        $('.loginsingup-input .lsu i').click(function(){
    //            $(this).toggleClass('eye');
    //            if ($(this).hasClass('eye')) {
    //                $(this).siblings('input').attr('type','text')
    //            } else{
    //                $(this).siblings('input').attr('type','password')
    //            }
    //        });
</script>
</body>
</html>
