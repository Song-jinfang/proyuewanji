<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:46:"./template/mobile/rainbow/goods/goodsInfo.html";i:1566350258;s:67:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header.html";i:1540260094;s:68:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/top_nav.html";i:1540260094;s:69:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/wx_share.html";i:1540260094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>商品详情--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
<body class="">

<style>
    .plusshopcar-buy .buy_bt_disable{
        background: #ebebeb;
        color: #999;
        cursor: not-allowed;
        pointer-events:none;
    }
    .layermbox0 .layermchild{min-width: .375rem !important;}
</style>
<div class="he_sustain">
    <div class="classreturn loginsignup detail">
        <div class="content">
            <div class="ds-in-bl return">
                <a href="javascript:history.back(-1)"><img src="/template/mobile/rainbow/static/images/return.png" alt="返回"></a>
            </div>
            <div class="ds-in-bl search center" id="topcenter">
                <span class="sxp">商品</span>
                <span>详情</span>
                <span>评论</span>
            </div>
            <div class="ds-in-bl menu">
                <a href="javascript:void(0);"><img src="/template/mobile/rainbow/static/images/class1.png" alt="菜单"></a>
            </div>
        </div>
    </div>
</div>

<!--顶部隐藏菜单-s-->
<div class="flool up-tpnavf-wrap tpnavf top-header-m">
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
<!--顶部隐藏菜单-e-->
<!--商品抢购 start-->
<!--商品s-->
<div class="xq_details">
    <div class="banner ban1 detailban">
        <div class="mslide" id="slideTpshop">
            <ul>
                <!--图片-s-->
                <?php if(is_array($goods['goods_images']) || $goods['goods_images'] instanceof \think\Collection || $goods['goods_images'] instanceof \think\Paginator): if( count($goods['goods_images'])==0 ) : echo "" ;else: foreach($goods['goods_images'] as $key=>$pic): ?>
                    <li><a href="javascript:void(0)"><img src="<?php echo $pic[image_url]; ?>" alt=""></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <!--图片-e-->
            </ul>
        </div>
    </div>
    <div class="de_font p">
        <div class="thirty">
            <div class="fl">
                <span class="similar-product-text"><?php echo $goods['goods_name']; ?></span>
                <span class="similar-product-text" style="color: #f03435;margin-top: -.5rem"><?php echo $goods['goods_remark']; ?></span>
            </div>
            <div class="keep fr">
                <a href="javascript:collect_goods(<?php echo $goods['goods_id']; ?>);" id="favorite_add">
                    <i class=" <?php if($collect > 0): ?>red<?php endif; ?>"></i>
                    <span>收藏</span>
                </a>
            </div>
            <div class="scunde p">
                <span class="red" id="price">￥<?php echo $goods['shop_price']; ?></span>
                <span id="market_price_title">市场价：</span><span class="linethr" id="market_price"><?php echo $goods['market_price']; ?></span>
                <p class="inlist">
                    <?php if($goods['prom_type'] != 2): ?><span style="float:left;">销量：<?php echo $goods['sales_sum']+$goods['virtual_sales_sum']; ?></span><?php endif; ?>
                    <!--<span >当前库存：<span class="spec_store_count"><?php echo $goods['store_count']; ?></span></span>-->
                    <span>运费：<i id="shipping_freight"></i></span>
                    <span style="text-align:right; float:right;">广东深圳</span>
                </p>
                <div class="timeafter presale-time" style="display: none">
                    <p class="confinetime" id="activity_type"></p>
                    <p class="confinetime" id="overTime"></p>
                </div>
                <div class="timeafter team-pies" style="display: none">
                    <div class="confinetime">该商品参与拼团中</div>
                    <a class="team_button" href="">点击前往</a>
                </div>
            </div>
        </div>
    </div>
    
    
    <!--领取优惠券&促销活动 start------------------------------------------------------------------------------------>
    <div class="floor list7 detailsfloo">
        <div class="myorder p " id="zYHJ-POP">
            <div class="content30">
                <a href="javascript:void(0)">
                    <div class="order">
                        <div class="fl">
                            <span class="firde">领券</span>
                            <span class="deta-coupon"></span>
                        </div>
                        <div class="fr">
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="myorder p" style="display: none">
            <div class="content30">
                <a href="javascript:void(0)">
                    <div class="order">
                        <div class="fl">
                            <span class="firde">促销</span>
                            <span class="desal-proinfo">
                            	<b><i>换购</i>购买一件可换购更优惠商品</b>
                                <b><i>组合购</i>加价可购买更优惠的xx商品</b>
                                <b><i>加价购</i>优惠套餐更加实惠，总体打8折</b>
                            </span>
                        </div>
                        <div class="fr">
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!--领取优惠券&促销活动 end ------------------------------------------------------------------------------------------> 
     
    <div class="floor list7 detailsfloo">
        <div class="myorder p">
            <div class="content30">
                <a href="javascript:void(0)" onclick="locationaddress(this);">
                    <script type="text/javascript">
                        function locationaddress(e){
                            $('.container').animate({width: '14.4rem', opacity: 'show'}, 'normal',function(){
                                $('.container').show();
                            });
                            if(!$('.container').is(":hidden")){
                                $('body').css('overflow','hidden')
                                cover();
                                $('.mask-filter-div').css('z-index','9999');
                            }
                        }
                        function closelocation(){
                            var province_div = $('.province-list');
                            var city_div = $('.city-list');
                            var area_div = $('.area-list');
                            if(area_div.is(":hidden") == false){
                                area_div.hide();
                                city_div.show();
                                province_div.hide();
                                return;
                            }
                            if(city_div.is(":hidden") == false){
                                area_div.hide();
                                city_div.hide();
                                province_div.show();
                                return;
                            }
                            if(province_div.is(":hidden") == false){
                                area_div.hide();
                                city_div.hide();
                                $('.container').animate({width: '0', opacity: 'show'}, 'normal',function(){
                                    $('.container').hide();
                                });
                                undercover();
                                $('.mask-filter-div').css('z-index','inherit');
                                return;
                            }
                        }
                    </script>
                    <div class="order">
                        <div class="fl">
                            <span class="firde">地址</span>
                            <span id="address"></span>
                        </div>
                        <div class="fr">
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

            <!--配送至-s-->
            <div class="container" >
            <div class="city">
                <div class="screen_wi_loc">
                    <div class="classreturn loginsignup">
                        <div class="content">
                            <div class="ds-in-bl return seac_retu">
                                <a href="javascript:void(0);" onclick="closelocation();"><img src="/template/mobile/rainbow/static/images/return.png" alt="返回"></a>
                            </div>
                            <div class="ds-in-bl search center">
                                <span class="sx_jsxz">配送至</span>
                            </div>
                            <div class="ds-in-bl suce_ok">
                                <a href="javascript:void(0);">&nbsp;</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="province-list"></div>
                <div class="city-list" style="display:none"></div>
                <div class="area-list" style="display:none"></div>
            </div>
        </div>
        <!--配送至-e-->

        <!--运费-s-->
        
<!--        <?php if($goods['is_virtual'] != 1): ?>
            <div class="myorder p" id="dispatching_desc">
                <div class="content30">
                    <a class="remain" href="javascript:void(0);">
                        <div class="order">
                            <div class="fl">
                                <span class="firde">运费信息</span>
                                <span id="shipping_freight"></span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <div id="balance" class="chidno"></div>-->
        
        <!--运费-s-->
        <div class="myorder p  choise_num_s">
            <div class="content30">
                <a href="javascript:void(0)">
                    <div class="order">
                        <div class="fl">
                            <span class="firde">规格</span>
                            <span class="sel"></span>
                        </div>
                        <div class="fr">
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="myorder p">
            <div class="content30">
                <a href="javascript:void(0)">
                    <div class="order">
                        <div class="fl">
                            <span class="firde">服务</span>
                            <span>由商城自营发货并提供售后服务</span>
                        </div>
                        <!--<div class="fr">-->
                            <!--<i class="Mright gt"></i>-->
                        <!--</div>-->
                    </div>
                </a>
            </div>
        </div>
<!--        <div class="myhearders myorder">
            <div class="scgz descgz">
                <ul>
                    <?php if($goods['is_virtual'] != 1): ?>
                        <li>
                            <a href="javascript:void(0);">
                                <img src="/template/mobile/rainbow/static/images/hdfk.png">
                                <p>货到付款</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <img src="/template/mobile/rainbow/static/images/ksd.png">
                                <p>极速达</p>
                            </a>
                        </li>
                    <?php endif; if($goods['is_virtual'] != 1): ?>
	                    <li>
	                        <a href="javascript:void(0);">
	                            <i><em><?php echo $tpshop_config['shopping_auto_service_date']; ?></em></i>
	                            <p><?php echo $tpshop_config['shopping_auto_service_date']; ?>天退款</p>
	                        </a>
	                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>-->
        <div class="myorder p tbv">
            <div class="content30">
                <a href="javascript:void(0)">
                    <div class="order">
                        <div class="fl">
                            <span class="firde">用户评价</span>
                            <span class="deta_eva">好评率&nbsp;<i><?php echo $goods['comment_statistics']['high_rate']; ?>%</i></span>
                        </div>
                        <div class="fr">
                            <span><i><?php echo $goods['comment_statistics']['high_sum']; ?></i>人好评</span>
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!--搭配套餐 s-->
    <div class="Combination-wrap" id="Combination-list-ul">

    </div>
    <script type="text/javascript">
    	$(".Combination-list ul").css("width",$(".Combination-list ul li").length*10.5+"rem");
    </script>
     <!--搭配套餐 e-->
    <!--为你推荐 s-->
    <?php if(!empty($recommend_goods)): ?>
    <div class="recommed p" >
        <h2>为您推荐</h2>
        <div class="floor guesslike">
            <div class="likeshop">
                <ul>
                    <!--商品推荐-->
                    <?php if(is_array($recommend_goods) || $recommend_goods instanceof \think\Collection || $recommend_goods instanceof \think\Paginator): $i = 0; $__LIST__ = $recommend_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <li>
                            <a href="<?php echo U('Goods/goodsInfo',array('id'=>$v[goods_id])); ?>">
                                <div class="similer-product">
                                    <img src="<?php echo goods_thum_images($v['goods_id'],400,400); ?>">
                                    <span class="similar-product-text"><?php echo $v[goods_name]; ?></span>
                                    <span class="similar-product-price">
                                        ¥<span class="big-price"><?php echo $v[shop_price]; ?></span>
                                    </span>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!--添加购物车JS-->
    <script src="/public/js/mobile_common.js" type="text/javascript" charset="utf-8"></script>
</div>
<!--商品-e-->

<!--详情-s-->
<div class="xq_details">
    <div class="spxq-ggcs">
        <ul>
            <li class="red">商品详情</li>
            <li>规格参数</li>
        </ul>
    </div>
    <div class="sg">
        <div class="spxq p">
            <?php echo htmlspecialchars_decode($goods['goods_content']); ?>
        </div>
    </div>
    <div class="sg" style="display: none;">
        <div class="spxq p">
            <table class="de_table" border="1" bordercolor="#cbcbcb" style="border-collapse:collapse;">
                <tr>
                    <th colspan="2">主体</th>
                </tr>
                <?php $goods_attr_show_list = $goods->goodsAttr()->where('attr_index',1)->select(); if(is_array($goods_attr_show_list) || $goods_attr_show_list instanceof \think\Collection || $goods_attr_show_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_attr_show_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_attr): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo $goods_attr['goods_attribute']['attr_name']; ?></td>
                        <td><?php echo $goods_attr['attr_value']; ?></td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </table>
        </div>
    </div>
</div>
<!--详情-e-->

<!--评论列表-s-->
<div class="xq_details" >
    <div class="spxq-ggcs comment_de p"  style="display:none;">
        <ul>
            <!--1 全部 2好评 3 中评 4差评-->
            <li class="red">全部评价 <br /><span ctype="1"><?php echo $goods['comment_statistics']['total_sum']; ?></span></li>
            <li>好评 <br /><span ctype="2"><?php echo $goods['comment_statistics']['high_sum']; ?></span></li>
            <li>中评 <br /><span ctype="3"><?php echo $goods['comment_statistics']['center_sum']; ?></span></li>
            <li>差评 <br /><span ctype="4"><?php echo $goods['comment_statistics']['low_sum']; ?></span></li>
            <li>有图 <br /><span ctype="5"><?php echo $goods['comment_statistics']['img_sum']; ?></span></li>
        </ul>
    </div>
    <!--评论列表-->
    <div class="tab-con-wrapper my_comment_list" > </div>
</div>
<!-- <div class="comment_con p" id="seedetail">
    <div class="score enkecor" onclick="seedeadei(this)">查看图文详情</div>
</div> -->
<!--评论列表-e-->

<!--底部按钮-s-->
<div class="podee">
    <div class="cart-concert-btm p">
        <div class="fl">
            <ul>
                <li>
                    <?php if((!empty($tpshop_config['basic_im_choose'])) && ($tpshop_config['basic_im_choose'] == 1)): ?>
                        <!--im客服-->
                        <a class="kf" href="<?php echo U('supplier/index',array('goods_id'=>$goods['goods_id'])); ?>">
                            <i></i>
                            <p>客服</p>
                        </a>
                        <?php elseif((!empty($tpshop_config['basic_im_choose'])) && ($tpshop_config['basic_im_choose'] == 2)): ?>
                        <!--小能客服-->
                        <a href="javascript:;">
                            <i></i>
                            <p>客服</p>
                        </a>
                        <?php else: ?>
                        <!--早先客服-->
                        <!--<a href="tel:<?php echo $tpshop_config['shop_info_phone']; ?>">tencent://message/?uin=<?php echo $tpshop_config['shop_info_qq']; ?>&Site=TPshop商城&Menu=yes-->
                        <a href="mqqwpa://im/chat?chat_type=wpa&uin=<?php echo $tpshop_config['shop_info_qq']; ?>&version=1&src_type=web&web_src=">
                            <i></i>
                            <p>客服</p>
                        </a>
                    <?php endif; ?>
                </li>
                <li>
                    <a href="<?php echo U('Mobile/Cart/index'); ?>" >
                        <span id="tp_cart_info"></span>
                        <i class="gwc"></i>
                        <p>购物车</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="fr">
            <ul>
                <li class="o" id="join_cart_li" style="display: none;">
                    <a class="pb_plusshopcar buy_button choise_num" href="javascript:void(0);"> 加入购物车</a>
                </li>
                <li class="r" id="buy_now_li" style="display: none;">
                    <a class="choise_num" style="display:block;" href="javascript:void(0);">立即购买</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--底部按钮-e-->

<!--点赞弹窗-s-->
<div class="alert">
    <img src="/template/mobile/rainbow/static/images/hh.png"/>
    <p>您已经赞过了！</p>
</div>
<!--点赞弹窗-e-->


<!--促销活动弹窗 start--------------------------------------------------------------------------------->
<div class="salpro_aready p">
	<div class="salpro-tit">
    	<b>促销信息</b>
        <div class="price_or fr"><i class="xxgro"></i></div>
    </div>
    <div class="salpro-con">
        <div class="salpro-list">
        	<span><i>换购</i>购买一件可换购更优惠商品</span>
            <div class="fr"><i class="Mright"></i></div>
        </div>
        <div class="salpro-list">
        	<span><i>组合购</i>加价可购买更优惠的xx商品</span>
            <div class="fr"><i class="Mright"></i></div>
        </div>
        <div class="salpro-list">
        	<span><i>加价购</i>优惠套餐更加实惠，总体打8折</span>
            <div class="fr"><i class="Mright"></i></div>
        </div>
	</div>
</div>
<!--促销活动弹窗 end--------------------------------------------------------------------------------->

<!--领取优惠券弹窗 start--------------------------------------------------------------------------------->
<div class="recive_aready p" id="recive_aready_pop">
	<div class="salpro-tit">
    	<b>优惠券列表</b>
        <div class="price_or fr"><i class="xxgro"></i></div>
    </div>
    <div class="deta-coucon">

    </div>
</div>
<!--领取优惠券弹窗 end--------------------------------------------------------------------------------->



<!--选择属性的弹窗-s-->
<form name="buy_goods_form" method="post" id="buy_goods_form">
    <input type="hidden" name="goods_id" value="<?php echo $goods['goods_id']; ?>"><!-- 商品id -->
    <input type="hidden" name="spec_goods_price" value='<?php echo json_encode($goods['spec_goods_price'],true); ?>'>
    <input type="hidden" name="activity_is_on" value=""><!-- 活动是否进行中 -->
    <input type="hidden" name="goods_prom_type" value="<?php echo $goods['prom_type']; ?>"/><!-- 活动类型 -->
    <input type="hidden" name="shop_price" value="<?php echo $goods['shop_price']; ?>"/><!-- 活动价格 -->
    <input type="hidden" name="store_count" value="<?php echo $goods['store_count']; ?>"/><!-- 活动库存 -->
    <input type="hidden" name="market_price" value="￥<?php echo $goods['market_price']; ?>"/><!-- 商品原价 -->
    <input type="hidden" name="start_time" value=""/><!-- 活动开始时间 -->
    <input type="hidden" name="end_time" value=""/><!-- 活动结束时间 -->
    <input type="hidden" name="activity_title" value=""/><!-- 活动标题 -->
    <input type="hidden" name="item_id" value="<?php echo \think\Request::instance()->param('item_id'); ?>"/><!-- 商品规格id -->
    <input type="hidden" name="prom_id" value="<?php echo $goods['prom_id']; ?>"/><!-- 活动ID -->
    <input type="hidden" name="exchange_integral" value="<?php echo $goods['exchange_integral']; ?>"/><!-- 积分 -->
    <input type="hidden" name="point_rate" value="<?php echo $tpshop_config['integral_point_rate']; ?>"/><!-- 积分兑换比 -->
    <input type="hidden" name="is_virtual" value="<?php echo $goods['is_virtual']; ?>"/><!-- 是否是虚拟商品 -->
    <input type="hidden" name="virtual_limit" id="virtual_limit" value="<?php echo (isset($goods['virtual_limit']) && ($goods['virtual_limit'] !== '')?$goods['virtual_limit']:0); ?>"/>
    <input type="hidden" name="deposit_price" value=""/><!-- 订金 -->
    <input type="hidden" name="balance_price" value=""/><!-- 尾款 -->
    <input type="hidden" name="ing_amount" value=""/><!-- 已预订了多少 -->
    <div class="choose_shop_aready p">
        <!--商品信息-s-->
        <div class="shop-top-under p">
            <div class="maleri30">
                <div class="shopprice">
                    <div class="img_or fl"><img id="zoomimg" src="<?php echo $goods['original_img']; ?>"></div>
                    <div class="fon_or fl">
                        <h2 class="similar-product-text"><?php echo $goods['goods_name']; ?></h2>
                        <input type="hidden" id="goods_name" name="goods_id" value="<?php echo $goods['goods_id']; ?>">
                        <div class="price_or" id="goods_price"><span>￥</span><span><?php echo $goods['shop_price']; ?></span></div>
                        <div class="dqkc_or"><span>剩余库存：</span><span id="spec_store_count"><?php echo $goods['store_count']; ?></span></div>
                        <div class="dqkc_or buy_limit" style="display: none"><span>限购：</span><span id="buy_limit"><?php echo $goods['virtual_limit']; ?></span></div>
                        <div class="price_or team-pies p" style="display: none"><span class="confinetime">该商品拼团中</span><a class="pb_buy team_button">点击前往</a></div>
                    </div>
                    <div class="price_or fr">
                        <i class="xxgro"></i>
                    </div>
                </div>
            </div>
        </div>
        <!--商品信息-e-->
        <div class="shop-top-under p">
            <div class="maleri30">
                <div class="shulges p">
                    <p>数量</p>
                    <!--选择数量-->
                    <div class="plus">
                        <span class="mp_minous" onclick="altergoodsnum(-1);">-</span>
                                <span class="mp_mp">
                        <input type="tel" class="num buyNum" id="number" residuenum="<?php echo $goods['store_count']; ?>" name="goods_num" value="1" min="1" max="<?php echo $goods['store_count']; ?>" onblur="altergoodsnum(0)">
                                </span>
                        <span class="mp_plus" onclick="altergoodsnum(1);">+</span>
                    </div>
                </div>
                <?php if(is_array($goods['spec']) || $goods['spec'] instanceof \think\Collection || $goods['spec'] instanceof \think\Paginator): $i = 0; $__LIST__ = $goods['spec'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$spec): $mod = ($i % 2 );++$i;?>
                    <div class="shulges p choicsel" >
                        <p><?php echo $spec['name']; ?></p>
                        <!-------商品属性值-s------->
                        <?php if(is_array($spec['spec_item']) || $spec['spec_item'] instanceof \think\Collection || $spec['spec_item'] instanceof \think\Paginator): $i = 0; $__LIST__ = $spec['spec_item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$spec_item): $mod = ($i % 2 );++$i;?>
                            <div class="plus choic-sel">
                                <a id="goods_spec_a_<?php echo $spec_item['id']; ?>" title="<?php echo $spec_item['item']; ?>" class="spec_item"
                                <?php if(is_array($goods['spec_image']) || $goods['spec_image'] instanceof \think\Collection || $goods['spec_image'] instanceof \think\Paginator): $i = 0; $__LIST__ = $goods['spec_image'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$spec_image): $mod = ($i % 2 );++$i;if($spec_image['spec_image_id'] == $spec_item['id']): ?>
                                        data-img-src="<?php echo $spec_image['src']; ?>"
                                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                >
                                    <input id="goods_spec_<?php echo $spec_item['id']; ?>" style="display: none" type="radio" name="goods_spec[<?php echo $spec['name']; ?>]" value="<?php echo $spec_item['id']; ?>"/><?php echo $spec_item['item']; ?>
                                </a>
                             </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <!-------商品属性值-e-------->
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
    </div>
    <div class="btns-fixed-wrap">
        <div class="plusshopcar-buy p btns-fixed-w100">
            <a id="join_cart" class="pb_buy buy_button" href="javascript:void(0);" >加入购物车</a>
            <a id="buy_now" class="pb_buy buy_button" href="javascript:void(0);" >立即购买 </a>
        </div>
    </div>
    </div>
</form>
<!--选择属性的弹窗-e-->
<a onclick="$('html,body').animate({'scrollTop':0},600)" style="display: block;width: 1.5rem;height:1.5rem;position: fixed; bottom: 3rem;right:0.4rem; background-color: rgba(243,241,241,0.5);border: 1px solid #CCC;-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;" id="topup">
    <img src="/template/mobile/rainbow/static/images/topup.png" style="display: block;width: 1.45rem;height:1.45rem;">
</a>
<div class="mask-filter-div" style="display: none;"></div>
<script type="text/javascript" src="/template/mobile/rainbow/static/js/mobile-location.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
 //如果微信分销配置正常, 商品详情分享内容中的"图标"不显示, 则检查域名否配置了https, 如果配置了https,分享图片地址也要https开头
 var httpPrefix = "http://<?php echo \think\Request::instance()->server('SERVER_NAME'); ?>";
<?php if(ACTION_NAME == 'goodsInfo'): ?>
var ShareLink = httpPrefix+"/index.php?m=Mobile&c=Goods&a=goodsInfo&id=<?php echo $goods[goods_id]; ?>"; //默认分享链接
	var ShareImgUrl = httpPrefix+"<?php echo goods_thum_images($goods[goods_id],100,100); ?>"; // 分享图标
	var ShareTitle = "<?php echo (isset($goods['goods_name']) && ($goods['goods_name'] !== '')?$goods['goods_name']:$tpshop_config['shop_info_store_title']); ?>"; // 分享标题
	var ShareDesc = "<?php echo (isset($goods['goods_remark']) && ($goods['goods_remark'] !== '')?$goods['goods_remark']:$tpshop_config['shop_info_store_desc']); ?>"; // 分享描述
<?php elseif(ACTION_NAME == 'info'): ?>
	var ShareLink = "<?php echo $team['bd_url']; ?>"; //默认分享链接
	var ShareImgUrl = "<?php echo $team['bd_pic']; ?>"; //分享图标
	var ShareTitle = "<?php echo $team[share_title]; ?>"; //分享标题
	var ShareDesc = "<?php echo $team[share_desc]; ?>"; //分享描述
<?php elseif(ACTION_NAME == 'found'): ?>
var ShareLink = httpPrefix+"/index.php?m=Mobile&c=Team&a=found&id=<?php echo $teamFound[found_id]; ?>"; //默认分享链接
	var ShareImgUrl = "<?php echo $team[bd_pic]; ?>"; //分享图标
	var ShareTitle = "<?php echo $team[share_title]; ?>"; //分享标题
	var ShareDesc = "<?php echo $team[share_desc]; ?>"; //分享描述
<?php elseif(ACTION_NAME == 'my_store'): ?>
	var ShareLink = httpPrefix+"/index.php?m=Mobile&c=Distribut&a=my_store"; 
	var ShareImgUrl = httpPrefix+"<?php echo $tpshop_config['shop_info_store_logo']; ?>"; 
	var ShareTitle = "<?php echo $share_title; ?>"; 
	var ShareDesc = httpPrefix+"/index.php?m=Mobile&c=Distribut&a=my_store}"; 
<?php else: ?>
	var ShareLink = httpPrefix+"/index.php?m=Mobile&c=Index&a=index"; //默认分享链接
	var ShareImgUrl = httpPrefix+"<?php echo $tpshop_config['shop_info_wap_home_logo']; ?>"; //分享图标
	var ShareTitle = "<?php echo $tpshop_config['shop_info_store_title']; ?>"; //分享标题
	var ShareDesc = "<?php echo $tpshop_config['shop_info_store_desc']; ?>"; //分享描述
<?php endif; ?>

var is_distribut = getCookie('is_distribut'); // 是否分销代理
var user_id = getCookie('user_id'); // 当前用户id
// 如果已经登录了, 并且是分销商
if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
{									
	ShareLink = ShareLink + "&first_leader="+user_id;									
}

$(function() {
	if(isWeiXin() && parseInt(user_id)>0){
		$.ajax({
			type : "POST",
			url:"/index.php?m=Mobile&c=Index&a=ajaxGetWxConfig&t="+Math.random(),
			data:{'askUrl':encodeURIComponent(location.href.split('#')[0])},		
			dataType:'JSON',
			success: function(res)
			{
				//微信配置
				wx.config({
				    debug: false, 
				    appId: res.appId,
				    timestamp: res.timestamp, 
				    nonceStr: res.nonceStr, 
				    signature: res.signature,
				    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','hideOptionMenu'] // 功能列表，我们要使用JS-SDK的什么功能
				});
			},
			error:function(res){
				console.log("wx.config error:");
				console.log(res);
				return false;
			}
		}); 

		// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在 页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready 函数中。
		wx.ready(function(){
		    // 获取"分享到朋友圈"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareTimeline({
		        title: ShareTitle, // 分享标题
		        link:ShareLink,
		        desc: ShareDesc,
		        imgUrl:ShareImgUrl // 分享图标
		    });

		    // 获取"分享给朋友"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareAppMessage({
		        title: ShareTitle, // 分享标题
		        desc: ShareDesc, // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
		    });
			// 分享到QQ
			wx.onMenuShareQQ({
		        title: ShareTitle, // 分享标题
		        desc: ShareDesc, // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});	
			// 分享到QQ空间
			wx.onMenuShareQZone({
		        title: ShareTitle, // 分享标题
		        desc: ShareDesc, // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});

		   <?php if(CONTROLLER_NAME == 'User'): ?> 
				wx.hideOptionMenu();  // 用户中心 隐藏微信菜单
		   <?php endif; ?>	
		});
	}
});

function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}
</script>
<!--微信关注提醒 start-->
<?php if(\think\Session::get('subscribe') == 0): ?>
<button class="guide" style="display:none;" onclick="follow_wx()">关注公众号</button>
<style type="text/css">
.guide{width:0.627rem;height:2.83rem;text-align: center;border-radius: 8px ;font-size:0.512rem;padding:8px 0;border:1px solid #adadab;color:#000000;background-color: #fff;position: fixed;right: 6px;bottom: 200px;z-index: 99;}
#cover{display:none;position:absolute;left:0;top:0;z-index:18888;background-color:#000000;opacity:0.7;}
#guide{display:none;position:absolute;top:5px;z-index:19999;}
#guide img{width: 70%;height: auto;display: block;margin: 0 auto;margin-top: 10px;}
div.layui-m-layerchild h3{font-size:0.64rem;height:1.24rem;line-height:1.24rem;}
.layui-m-layercont img{height:8.96rem;width:8.96rem;}
</style>
<script type="text/javascript">
  //关注微信公众号二维码	 
function follow_wx()
{
	layer.open({
		type : 1,  
		title: '关注公众号',
		content: '<img src="<?php echo $wechat_config['qr']; ?>">',
		style: ''
	});
}
  
$(function(){
	if(isWeiXin()){
		var subscribe = getCookie('subscribe'); // 是否已经关注了微信公众号		
		if(subscribe == 0)
			$('.guide').show();
	}else{
		$('.guide').hide();
	}
})
 
</script>
<?php endif; ?>
<!--微信关注提醒  end-->
<!--优惠卷弹窗打开和关闭-->
<script type="text/javascript">
	$(document).on("click","#zYHJ-POP",function  () {
		$("#recive_aready_pop").show();
	})
	$(document).on("click","#recive_aready_pop .xxgro",function  () {
		$("#recive_aready_pop").hide();
	})
	
</script>
<script type="text/javascript">
    $(function(){
        if(isWeiXin()){
            $('.contact').attr('href',"tel:<?php echo $tpshop_config['shop_info_phone']; ?>");
        }else{
            $('.contact').attr('href',"mqqwpa://im/chat?chat_type=wpa&uin=<?php echo $tpshop_config['shop_info_qq']; ?>&version=1&src_type=web&web_src=www.chinesestack.com");
        }
    })
    var commentType = 1;// 默认评论类型
    var spec_goods_price = $.parseJSON($('#buy_goods_form').find("input[name='spec_goods_price']").val());//规格库存价格
    var ajax_return_stauts = 1;//规格库存价格
    //页面加载后执行
    $(document).ready(function () {
        ajax_header_cart();
        couponList();//领取优惠券
        ajaxComment(commentType, 1);// ajax 加载评价列表
        initSpec();
        sel(); //在已选栏中显示默认选择属性，数量
        initGoodsPrice();
    });
    var buy_now = $('#buy_now');
    var join_cart = $('#join_cart');
    var buy_now_li = $('#buy_now_li');
    var join_cart_li = $('#join_cart_li');
    function buy_button(){

        var is_virtual = $("input[name='is_virtual']").val();//是否是虚拟商品
        var exchange_integral = $("input[name='exchange_integral']").val();//是否是为积分商品
        var goods_prom_type = $('input[name="goods_prom_type"]').attr('value');//活动商品
        var activity_is_on = $('input[name="activity_is_on"]').attr('value'); //活动是否进行中
        buy_now.hide();
        buy_now_li.hide();
        join_cart.hide();
        join_cart_li.hide();

        if(is_virtual == 1){
            buy_now_li.find('.choise_num').html('立即购买');
            buy_now_li.width('100%').show();
            buy_now.html('立即购买').show();
            return;
        }
        if(exchange_integral > 0){
            buy_now_li.find('.choise_num').html('立即兑换');
            buy_now_li.width('100%').show();
            buy_now.html('立即兑换').show();
            return;
        }
        if(goods_prom_type == 4 && activity_is_on == 1){
            buy_now_li.find('.choise_num').html('立即预订');
            buy_now_li.width('100%').show();
            buy_now.html('立即预订').show();
            return;
        }


        //判断是点了购物车还是立即购买
        if($('#buy_now').attr('data-id')==1){
            buy_now.html('确定').show();
            buy_now.width('100%').show();
            join_cart.hide();
        }else if($('#join_cart').attr('data-id')==1){
            buy_now.hide();
            join_cart.show();
            join_cart.width('100%').show();
        }else{
            buy_now.html('立即购买').show();
            join_cart.show();
            // join_cart.width('50%').show();
        }
        buy_now_li.find('.choise_num').html('立即购买');
        buy_now_li.width('50%').show();
        join_cart_li.show();

    }

    //购买按钮
    $(function () {
        //立即购买
        $(document).on('click', '#buy_now', function () {
            if ($(this).hasClass('buy_bt_disable')) {
                return;
            }
            if (getCookie('user_id') == '') {
                window.location.href = "<?php echo U('Mobile/User/login'); ?>";
                return;
            }
            var is_virtual = $("input[name='is_virtual']").val();//是否是虚拟商品
            var exchange_integral = $("input[name='exchange_integral']").val();//是否是积分兑换商品
            var goods_id = $("input[name='goods_id']").val();
            var store_count = $("input[name='store_count']").attr('value');// 商品原始库存
            var goods_num = parseInt($("input[name='goods_num']").val());
            var goods_prom_type = $('input[name="goods_prom_type"]').attr('value');//活动商品
            var activity_is_on = $('input[name="activity_is_on"]').attr('value'); //活动是否进行中
            var form = $('#buy_goods_form');
            if (is_virtual == 1) {
                var virtual_limit = parseInt($('#virtual_limit').val());
                if ((goods_num <= store_count && goods_num <= virtual_limit) || (goods_num < store_count && virtual_limit == 0)) {
                    form.attr('action', "<?php echo U('mobile/Cart/cart2',['action'=>'buy_now']); ?>").submit();
                } else {
                    layer.open({icon: 2, content: "购买数量超过此商品购买上限", time: 2});
                }
                return;
            }
            if (exchange_integral > 0) {
                buyIntegralGoods(goods_id, 1);
                return;
            }
            if(goods_prom_type == 4 && activity_is_on == 1){
                form.attr('action', "<?php echo U('mobile/Cart/pre_sell'); ?>").submit();
                return;
            }
            //普通流程
            if (goods_num <= store_count) {
                form.attr('action', "<?php echo U('mobile/Cart/cart2',['action'=>'buy_now']); ?>").submit();
            } else {
                layer.open({icon: 2, content: "购买数量超过此商品购买上限", time: 2});
            }
        })
        //加入购物车
        $(document).on('click', '#join_cart', function () {
            if ($(this).hasClass('buy_bt_disable')) {
                return;
            }
            var goods_id = $("input[name='goods_id']").val();
            AjaxAddCart(goods_id, 1);

        })
    })
    //有规格id的时候，解析规格id选中规格
    function initSpec() {
        var item_id = $("input[name='item_id']").val();
        if (item_id > 0 && !$.isEmptyObject(spec_goods_price)) {
            var item_arr = [];
            $.each(spec_goods_price, function (i, o) {
                item_arr.push(o.item_id);
            })
            //规格id不存在商品里
            if ($.inArray(parseInt(item_id), item_arr) < 0) {
                initFirstSpec();
            } else {
                $.each(spec_goods_price, function (i, o) {
                    if (o.item_id == item_id) {
                        var spec_key_arr = o.key.split("_");
                        $.each(spec_key_arr, function (index, item) {
                            var spec_radio = $("#goods_spec_" + item);
                            var goods_spec_a = $("#goods_spec_a_" + item);
                            spec_radio.attr("checked", "checked");
                            goods_spec_a.addClass('red');
                        })
                    }
                })
            }
        } else {
            initFirstSpec();
        }
    }
    function initFirstSpec(){
        $('.choicsel').each(function (i, o) {
            var firstSpecRadio = $(this).find("input[type='radio']").eq(0);
            firstSpecRadio.attr('checked','checked');
            firstSpecRadio.parents('.choic-sel').find('a').eq(0).addClass('red');
        })
    }
    //初始化商品价格库存
    function initGoodsPrice() {
        var goods_id = $('input[name="goods_id"]').val();
        var goods_num = parseInt($('#number').val());
        if (!$.isEmptyObject(spec_goods_price)) {
            var goods_spec_arr = [];
            $("input[name^='goods_spec']").each(function () {
                if($(this).attr('checked') == 'checked'){
                    goods_spec_arr.push($(this).val());
                }
            });
            var spec_key = goods_spec_arr.sort(sortNumber).join('_');  //排序后组合成 key
            var spec_goods_price_item = search_spec_goods_price(spec_key);
            var spec_goods_price_arr = Object.keys(spec_goods_price_item);
            if (spec_goods_price_arr.length > 0){
                var item_id = spec_goods_price_item['item_id'];
                $('input[name=item_id]').val(item_id);
            }else{
                $(".goods_price").html(0); //变动价格显示
                $('.spec_store_count').html(0);
                $("#goods_price").html(0); //变动价格显示
                $("#price").html(0); //变动价格显示
                $('#spec_store_count').html(0);
                $('.buy_button').addClass('buy_bt_disable');
                return false;
            }
        }
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {goods_id: goods_id, item_id: item_id, goods_num : goods_num},
            url: "<?php echo U('Mobile/Goods/activity'); ?>",
            success: function (data) {
                if (data.status == 1) {
                    $('input[name="goods_prom_type"]').attr('value', data.result.goods.prom_type);//商品活动类型
                    $('input[name="shop_price"]').attr('value', data.result.goods.shop_price);//商品价格
                    $('input[name="store_count"]').attr('value', data.result.goods.store_count);//商品库存
                    $('input[name="market_price"]').attr('value', data.result.goods.market_price);//商品原价
                    $('input[name="start_time"]').attr('value', data.result.goods.start_time);//活动开始时间
                    $('input[name="end_time"]').attr('value', data.result.goods.end_time);//活动结束时间
                    $('input[name="activity_title"]').attr('value', data.result.goods.activity_title);//活动标题
                    $('input[name="prom_detail"]').attr('value', data.result.goods.prom_detail);//促销详情
                    $('input[name="buy_limit"]').attr('value', data.result.goods.buy_limit);//促销详情
                    $('input[name="activity_is_on"]').attr('value', data.result.goods.activity_is_on);//活动是否正在进行中
                    $('input[name="prom_id"]').attr('value', data.result.goods.prom_id);//活动Id
                    $('input[name="deposit_price"]').attr('value', data.result.goods.deposit_price);//订金
                    $('input[name="balance_price"]').attr('value', data.result.goods.balance_price);//尾款
                    $('input[name="ing_amount"]').attr('value', data.result.goods.ing_amount);//已预订了多少个
                    $('#market_price').html(data.result.goods.market_price);
                    if(data.result.goods.is_virtual){
                        $('.buy_limit').show();
                    }else{
                        $('.buy_limit').hide();
                    }
                    goods_activity_theme();
                    buy_button();
                }
            }
        });
    }
    //点击收藏商品
    function collect_goods(goods_id){
        $.ajax({
            type : "GET",
            dataType: "json",
            url:"/index.php?m=mobile&c=goods&a=collect_goods",//+tab,
            data: {goods_id:goods_id},
            success: function(data){
                layer.open({content:data.msg, time:2});
                if(data.status == 1){
                    //收藏点亮
                    $('.de_font .keep').find('i').addClass('red');
                }
            }
        });
    }
    //将选择的属性添加到已选
    function sel() {
        var residuenum = parseInt($('.buyNum').attr('residuenum'));
        var title = '';
        $('.choicsel').find('a').each(function (i, o) {   //获取已选择的属性，规格
            if ($(o).hasClass('red')) {
                title += $(o).attr('title') + '&nbsp;&nbsp;';
            }
        })
        var num = $('.buyNum').val();
        if (num > residuenum) {
            num = residuenum;
        }
        var sel = title + '&nbsp;&nbsp;' + num + '件';
        $('.sel').html(sel);
    }

    $(function () {
        // 内部导航随鼠标滑动显示隐藏
        var h1 = $('.detail').height();
        var h2 = $('.detail').height() + $('.spxq-ggcs').height();
        var ss = $(document).scrollTop();//上一次滚轮的高度
        $(window).scroll(function(){
            var s = $(document).scrollTop();////本次滚轮的高度
            if(s< h1){
                $('.spxq-ggcs').removeClass('po-fi');
            }if(s > h1){
                $('.spxq-ggcs').addClass('po-fi');
            }if(s > h2){
                $('.spxq-ggcs').addClass('gizle');
                if(s > ss){
                    $('.spxq-ggcs').removeClass('sabit');
                }else{
                    $('.spxq-ggcs').addClass('sabit');
                }
                ss = s;
            }
        });
    })
    //ajax请求购物车列表
    function ajax_header_cart(){
        var cart_cn = getCookie('cn');
        if (cart_cn == '') {
            $.ajax({
                type: "GET",
                url: "/index.php?m=Home&c=Cart&a=header_cart_list",//+tab,
                success: function (data) {
                    cart_cn = getCookie('cn');
                }
            });
        }
        $('#tp_cart_info').html(cart_cn);
    }
    //评论
    $('.tbv').click(function(){
        $('.xq_details').eq(0).hide();
        $('.xq_details').eq(2).show();
        $('html,body').animate({'scrollTop':0},600)
        $('.detail').find('.center').find('span').eq(2).addClass('sxp');
        $('.detail').find('.center').find('span').eq(0).removeClass('sxp');
        $('.gizle').show();
    })


    /**
     * 点规格
     */
    $('.choise_num_s').click(function () {
        console.log(12)
        var id = $(this).parent().attr('id');
        //设置是点了购物车还是立即购买
        $('#join_cart').removeClass('pb_buy ');
        $('#join_cart').addClass('pb_plusshopcar');
        $('#buy_now').show();
        $('#join_cart').show();
        $('#buy_now').attr('data-id',3);
        $('#join_cart').attr('data-id',3);
        $('#buy_now').css('width','');
        $('#join_cart').css('width','');
        $('#join_cart').text('加入购物车');
        $('#buy_now').text('立即购买');
        cover();
        $('.choose_shop_aready').show();
        $('.podee').hide();
        initGoodsPrice();//初始化，避免不可用的规格显示可用
        buy_button();
    })


    /**
     * 已选
     */
    $('.choise_num').click(function () {
       var id = $(this).parent().attr('id');
        //设置是点了购物车还是立即购买
        if(id == 'buy_now_li'){
            $('#buy_now').text('确定');
            $('#buy_now').width('100%').show();
            $('#buy_now').attr('data-id',1);
            $('#join_cart').attr('data-id',0);
            $('#join_cart').hide();
        }else if(id == 'join_cart_li'){
            $('#join_cart').text('确定');
            $('#join_cart').width('100%').show();
            $('#buy_now').hide();
            $('#buy_now').attr('data-id',0);
            $('#join_cart').attr('data-id',1);
            $('#join_cart').removeClass('pb_plusshopcar ');
            $('#join_cart').addClass('pb_buy');

        }
        cover();
        $('.choose_shop_aready').show();
        $('.podee').hide();
        initGoodsPrice() //初始化，避免不可用的规格显示可用
    })

    //关闭属性选择
    $('.xxgro').click(function () {
        undercover();
        $('.choose_shop_aready').hide();
        $('.podee').show();
        sel();
    })
    /**
     * 顶部导航切换
     */
    $(document).on('click','.detail .search span',function(){
        $(this).addClass('sxp').siblings().removeClass('sxp');
        var a = $('.detail .search span').index(this);
        $('.xq_details').eq(a).show().siblings('.xq_details').hide();
        $('.xq_details').eq(2).show();
        if($('.detail .search span').eq(2).hasClass('sxp')){
            $('.comment_de').show();
        }else{
            $('.comment_de').hide();
        }
        if($('.detail .search span').eq(1).hasClass('sxp')){
            $('.tab-con-wrapper').hide();
            $('.comment_con').hide();
        }else{
            $('.tab-con-wrapper').show();
            $('.comment_con').show();
        }
    });
    /**
     * 内部导航切换
     */
    $('.spxq-ggcs ul li').click(function(){
        $(this).addClass('red').siblings().removeClass('red');
        var sg = $('.spxq-ggcs ul li').index(this);
        $('.sg').eq(sg).show().siblings('.sg').hide();
        var $commentType= $(this).children('span').attr('ctype');
        //切换到评论按钮才加载评论列表
        if($('.detail .search span').eq(2).hasClass('sxp')){
            ajaxComment($commentType,1);// ajax 加载评价列表
        }
    });
/*     //查看商品详情
    function seedeadei(obj){
        $('.xq_details').eq(1).show(); //显示详情
        $('.xq_details').eq(0).hide();
        $('.xq_details').eq(2).hide();
        $(obj).parent('div').hide();
        $('body').animate({'scrollTop': 0}, 0);
        $('#topcenter').html('<span>图文详情</span>');
        $('.detail').find('.center').find('span').eq(1).addClass('sxp');
        $('.detail').find('.center').find('span').eq(0).removeClass('sxp');
        $('#topup').attr('onclick',"topup()");
    }*/

    //详情下的返回按钮
    function topup(){
        $('.xq_details').eq(0).show(); //显示详情
        $('.xq_details').eq(1).hide();
        $('.xq_details').eq(2).show();
        $('#seedetail').show();
        $('html,body').animate({'scrollTop':0},600)
        $('#topcenter').html('<span class="sxp">商品</span><span>详情</span><span>评论</span>');
        $('#topup').attr('onclick',"$('html,body').animate({'scrollTop':0},600)");
    }
    /**
     * 加载更多评论
     */
    function ajaxComment(commentType,page){
        $.ajax({
            type : "GET",
            url:"/index.php?m=Mobile&c=goods&a=ajaxComment&goods_id=<?php echo $goods['goods_id']; ?>&commentType="+commentType+"&p="+page,//+tab,
            success: function(data){
                $(".my_comment_list").empty().append(data);
            }
        });
    }

    //点击切换规格
    $(document).on('click', '.spec_item', function () {
        $(this).addClass('red').parent().siblings().find('a').removeClass('red');
        $(this).siblings().removeClass('hover');
        $(this).addClass('hover');
        $(this).parent().parent().find('input').removeAttr('checked');
        $(this).children('input').attr('checked', 'checked');
        var spec_item_img_src = $(this).data('img-src');
        if (spec_item_img_src != '') {
            $('#zoomimg').attr('src', spec_item_img_src);
        }
        $('.team-pies').hide();
        //商品价格库存显示
        initGoodsPrice();
        //获取搭配购
        getCombination();
    })

    //商品价格库存显示
    function goods_activity_theme(){
        ajaxDispatching();
        var goods_prom_type = parseInt($('input[name="goods_prom_type"]').attr('value'));
        var activity_is_on = $('input[name="activity_is_on"]').attr('value');
        if(activity_is_on == 0){
            setNormalGoodsPrice();
        }else {
            switch (goods_prom_type) {
                case 1:
                    //抢购
                    setFlashSaleGoodsPrice();
                    break;
                case 2:
                    //团购
                    setGroupByGoodsPrice();
                    break;
                case 3:
                    //优惠促销
                    setPromGoodsPrice();
                    break;
                case 4:
                    //预售
                    setPreSellGoodsPrice();
                    break;
                case 6:
                    $('.team-pies').show();
                    var prom_id = $('input[name="prom_id"]').attr('value');
                    var goods_id = $('input[name="goods_id"]').attr('value');
                    $('.team_button').attr('href',"/index.php?m=Mobile&c=Team&a=info&team_id="+prom_id+"&goods_id="+goods_id);
                    setNormalGoodsPrice();
                    break;
                default:
                    //普通商品
                    setNormalGoodsPrice();
                    break;
            }
        }
        var buy_num  = parseInt($('#number').val());//购买数
        var store = $('#spec_store_count').html();//实际库存数量
        $('#number').attr('residuenum',store);
        // if(store<=0){
        //     $('.buy_button').addClass('buy_bt_disable');
        // }else{
        //     $('.buy_button').removeClass('buy_bt_disable');
        //     // $('.buy_button').addClass('buy_bt_disable');
        // }
        if(buy_num > store){
            $('.buyNum').val(store);
        }
    }
    //普通商品库存和价格
    function setNormalGoodsPrice() {
        var goods_price = $("input[name='shop_price']").attr('value');// 商品本店价
        var market_price =  $("input[name='market_price']").attr('value');// 商品市场价
        var store_count = $("input[name='store_count']").attr('value');// 商品库存
        var exchange_integral = $("input[name='exchange_integral']").attr('value');// 兑换积分
        var point_rate = $("input[name='point_rate']").attr('value')==""?10:$("input[name='point_rate']").attr('value');// 积分金额比
        // 如果有属性选择项
        if (!$.isEmptyObject(spec_goods_price) && spec_goods_price != '') {
            var goods_spec_arr = [];
            $("input[name^='goods_spec']").each(function () {
                if($(this).attr('checked') == 'checked'){
                    goods_spec_arr.push($(this).val());
                }
            });
            var spec_key = goods_spec_arr.sort(sortNumber).join('_');  //排序后组合成 key
            var spec_goods_price_item = search_spec_goods_price(spec_key);
            goods_price = spec_goods_price_item['price']; // 找到对应规格的价格
            store_count = spec_goods_price_item['store_count']; // 找到对应规格的库存
        }
        var goods_num = parseInt($("input[name='goods_num']").attr('value'));
        if (goods_num > store_count) {
            goods_num = store_count;
            $("#goods_num").val(goods_num);
        }
        var integral = round(goods_price - (exchange_integral / point_rate),2);
        if(exchange_integral > 0){
            $("#goods_price").html(integral + '+' +exchange_integral + '积分'); //变动价格显示
            $("#price").html("<em>￥</em>" + integral + '+' +exchange_integral + '积分'); //积分显示
        }else{
            $("#goods_price").html(goods_price); //变动价格显示
            $("#price").html("<em>￥</em>" + goods_price); //变动价格显示
        }
        $('#market_price_title').html('市场价：');
        $('#spec_store_count').html(store_count);
        $('#number').attr('max', store_count);
        $('.spec_store_count').html(store_count);
        $('.presale-time').hide();
    }
    //预售商品库存和价格
    function setPreSellGoodsPrice(){
        var pre_sale_price = $("input[name='shop_price']").attr('value');//预售价
        var pre_sale_count = $("input[name='store_count']").attr('value');//预售库存
        var goods_num = parseInt($("input[name='goods_num']").attr('value'));
        var deposit_price = $("input[name='deposit_price']").attr('value');
        var balance_price = $("input[name='balance_price']").attr('value');
        var market_price = $("input[name='market_price']").attr('value');
        if (goods_num > pre_sale_count) {
            goods_num = pre_sale_count;
            $("#goods_num").val(goods_num);
        }
        $('#number').attr('max', pre_sale_count);
        $("#goods_price").html(pre_sale_price); //变动价格显示
        $("#price").html("预售价￥" + pre_sale_price); //变动价格显示
        $('#market_price_title').html('原价：');
        $('#activity_type').html('预售');
        $('#spec_store_count').html(pre_sale_count);
        $('.spec_store_count').html(pre_sale_count);
        $('.presale-time').show();
        $('#deposit_price').html('￥'+deposit_price);
        $('#balance_price').html('￥'+balance_price);
        $('#market_price').empty().html(market_price);
        setInterval(activityTime, 1000);
    }
    //团购商品库存和价格
    function setFlashSaleGoodsPrice() {
        var flash_sale_price = $("input[name='shop_price']").attr('value');
        var flash_sale_count = $("input[name='store_count']").attr('value');
        var goods_num = parseInt($("input[name='goods_num']").attr('value'));
        var buy_limit = parseInt($("input[name='buy_limit']").attr('value'));
        if (goods_num > flash_sale_count) {
            goods_num = flash_sale_count;
//            layer.open({content:'库存仅剩 ' + flash_sale_count + ' 件',time: 2});
            $("#goods_num").val(goods_num);
        }
        $('#number').attr('max', flash_sale_count);
        $("#goods_price").html(flash_sale_price); //变动价格显示
        $("#price").html("抢购价￥" + flash_sale_price); //变动价格显示
        $('#market_price_title').html('原价：');
        $('#activity_type').html('限时抢购');
        $('#spec_store_count').html(flash_sale_count);
        $('.spec_store_count').html(flash_sale_count);
        $('#buy_limit').html(buy_limit).show();
        $('.presale-time').show();
        setInterval(activityTime, 1000);
    }
    //秒杀商品库存和价格
    function setGroupByGoodsPrice() {
        var group_by_price = $("input[name='shop_price']").attr('value');
        var group_by_count = $("input[name='store_count']").attr('value');
        var goods_num = parseInt($("input[name='goods_num']").attr('value'));
        if (goods_num > group_by_count) {
            goods_num = group_by_count;
//            layer.open({content:'库存仅剩 ' + group_by_count + ' 件',time: 2});
            $("#goods_num").val(goods_num);
        }
        $('#number').attr('max', group_by_count);
        $("#goods_price").html(group_by_price); //变动价格显示
        $("#price").html("团购价￥" + group_by_price); //变动价格显示
        $('#market_price_title').html('原价：');
        $('#activity_type').html('限时团购');
        $('#spec_store_count').html(group_by_count);
        $('.spec_store_count').html(group_by_count);
        $('.presale-time').show();
        setInterval(activityTime, 1000);
    }
    //秒杀商品库存和价格
    function setPromGoodsPrice() {
        var prom_goods_price = $("input[name='shop_price']").attr('value');
        var prom_goods_count = $("input[name='store_count']").attr('value');
        var goods_num = parseInt($("input[name='goods_num']").attr('value'));
        if (goods_num > prom_goods_count) {
            goods_num = prom_goods_count;
//            layer.open({content:'库存仅剩 ' + prom_goods_count + ' 件',time: 2});
            $("#goods_num").val(goods_num);
        }

        //检查优惠促销类型
        $.ajax({
            type: "GET",
            data:{
                goods_id:$('input[name=goods_id]').val(),
                item_id:$('input[name=item_id]').val()
            },
            url: "/index.php?m=Mobile&c=Goods&a=checkGoodsPromotionType",//+tab,
            success: function (data) {
                if(data.status == 1 && data.result == 3){
                    $("#price").html("￥" + prom_goods_price); //变动价格显示
                    $('#market_price_title').html('市场价：');
                    $('#activity_type').html('促销活动赠送优惠券');
                }else{
                    $("#price").html("促销价￥" + prom_goods_price); //变动价格显示
                    $('#market_price_title').html('原价：');
                    $('#activity_type').html('促销');
                }
            }
        });
        $('#number').attr('max', prom_goods_count);
        $("#goods_price").html(prom_goods_price); //变动价格显示
        $('#spec_store_count').html(prom_goods_count);
        $('.spec_store_count').html(prom_goods_count);
        $('.presale-time').show();
        setInterval(activityTime, 1000);
    }
    // 倒计时
    function activityTime() {
        var end_time = parseInt($("input[name='end_time']").attr('value'));
        var timestamp = Date.parse(new Date());
        var now = timestamp/1000;
        var end_time_date = formatDate(end_time*1000);
        var text = GetRTime(end_time_date);
        //活动时间到了就刷新页面重新载入
        if(now > end_time){
            layer.open({content:'该商品活动已结束',time: 2});
            location.reload();
        }
        $("#overTime").text(text);
    }
    //时间戳转换
    function add0(m){return m<10?'0'+m:m }
    function  formatDate(now)   {
        var time = new Date(now);
        var y = time.getFullYear();
        var m = time.getMonth()+1;
        var d = time.getDate();
        var h = time.getHours();
        var mm = time.getMinutes();
        var s = time.getSeconds();
        return y+'/'+add0(m)+'/'+add0(d)+' '+add0(h)+':'+add0(mm)+':'+add0(s);
    }

    function sortNumber(a,b)
    {
        return a - b;
    }
    //运费
    $(function(){
        $('.remain').click(function(){
            $('#balance').toggle(300);
        })
        $('#balance').on('click','a',function(){
            $('#shipping_freight').text($(this).find('span').text());
            $('#balance').toggle(300);
        })
    })
    /**
     * 点赞ajax
     * dyr
     * @param obj
     */
    function zan(obj) {
        if(ajax_return_stauts = 0){
            return false;
        }
        ajax_return_stauts = 0;
        var user_id = getCookie('user_id');
        if (user_id == '') {
            ajax_return_stauts = 1
            layer.open({content:'请先登录',time:2});
            return ;
        }
        var comment_id = $(obj).attr('data-comment-id');
        var zan_num = parseInt($("#span_zan_" + comment_id).text());
        $.ajax({
            type: "POST",
            data: {comment_id: comment_id},
            dataType: 'json',
            url: "/index.php?m=Mobile&c=Order&a=ajaxZan",
            success: function (data) {
                ajax_return_stauts = 1
                if (data.status==1) {
                    layer.open({content:data.msg,time:2});
                    $("#span_zan_" + comment_id).text(zan_num + 1);
                    $('#'+comment_id).find('.like').addClass('like_ani'); //显示点赞效果
                    $('#'+comment_id).find('.btn-like-icon').addClass('like-red');
                } else {
                    $('.alert').show(200);
                    $('.alert').animate({opacity:"1"},600,hde());
                }
            },
            error : function(data) {
                ajax_return_stauts = 1
                if( data.status == "200"){ // 兼容调试时301/302重定向导致触发error的问题
                    layer.open({content:'请先登录!',time:2})
                    return;
                }
                layer.open({content:'请求失败!',time:2})
                return;
            }
        });
    }


    /**
     * 获取搭配购商品
     */

    $(document).ready(function () {
        getCombination();
    });
    function getCombination() {
        var goods_id = parseInt($("input[name='goods_id']").val());
        var item_id = $("input[name='item_id']").val();
        var url = "/index.php?m=Home&c=Goods&a=combination";
        $.ajax({
            type: "Post",
            url: url,
            data: {goods_id: goods_id, item_id: item_id},
            dataType: "json",
            success: function (data) {
                if (data.status == 1) {
                    var str = combinationHtml(data.result)
                    if(data.result.length>0){
                        $('#Combination-list-ul').html(str);

                    }else{
                        $('#Combination-list-ul').children().remove();

                    }
                    $(".Combination-list ul").css("width",$(".Combination-list ul li").length*10.5+"rem");
                }

            }
        });
    }

function combinationHtml(result) {
    var item_id = $("input[name='item_id']").val()?$("input[name='item_id']").val():0;
    var goods_id = $("input[name='goods_id']").val();
    var html = '<div class="Combination-heads">' +
        '<h3>热门搭配</h3>' +
        '</div><div class="Combination-list"><ul class="p" id="Combination-list-ul">';
    $.each(result, function (i, o) {
        var price = (o.combination_goods[0]["original_price"] - o.combination_goods[0]["price"]).toFixed(2);
        var count_price = (o.count_price).toFixed(2);
        var img = o.combination_goods[0]["original_img"]?o.combination_goods[0]["original_img"]:"/public/images/icon_goods_thumb_empty_300.png";
        var url = '?id='+o.combination_goods[0]["goods_id"]+'&item='+o.combination_goods[0]["item_id"]+'&combination='+o.combination_id;
        // var goods_id= o.combination_goods[0]["goods_id"];
        // var item_id= o.combination_goods[0]["item_id"];
        var combination= o.combination_id;
        html += '<li class="fl"><a onclick="combinationCurl('+goods_id+','+item_id+','+combination+')" class="p">' +
            '<div class="Combination-right-i"></div><div class="Combination-left-img fl">' +
            '<img src="'+img+'" style="width: 100%" /></div><div class="fr Combination-rigth"><div class="Combination-names">'+o.combination_goods[0]["goods_name"]+'</div>' +
            '<div class="Combination-prices">￥：<span>'+o.combination_goods[0]["price"]+'</span></div>' +
            '<div class="Combination-dev">省￥：<span>'+count_price+'</span></div></div></a></li>';
    })

    html +='</ul></div>';
    return html;
}

function combinationCurl(goods_id,item,combination_id) {
    var url = '?id='+goods_id+'&item='+item+'&combination='+combination_id+'&district_id='+getCookieByName('district_id');
    location.href = "<?php echo U('Goods/combination_details'); ?>"+url;
    return false;
}

    //领取优惠券
    function couponList() {
        var goods_id = parseInt($("input[name='goods_id']").val());
        var item_id = $("input[name='item_id']").val();
        var url = "/index.php?m=Mobile&c=Goods&a=couponList";
        $.ajax({
            type: "Post",
            url: url,
            data: {goods_id: goods_id, item_id: item_id},
            dataType: "json",
            success: function (data) {
                console.log(data);
                var html = '';
                $.each(data.result, function (i, o) {
                    if(i <=3){
                        var h = '<em>满'+parseInt(o.condition)+'-'+parseInt(o.money)+'</em>';
                        $('.deta-coupon').append(h);
                    }
                    html += '<div class="deta-coulist"><div class="fl">' +
                        '        <span>￥<b>'+o.money+'</b></span>' +
                        '    <em>满'+o.condition+'元可用</em>'
                    if(o.isget==1){
                        html +=   '<i>已领取</i>'
                    }
                    html +=   '   </div><div class="fr"><p>'+o.name+'</p>' +
                        '        <span><i>'+o.use_start_time+'-'+o.use_end_time+'</i>'
                    if(o.isget==1){
                        html  +='<a href="javascript:void(0)"class="couapply-pro">适用商品</a></span>'
                    }else{
                        html  +='<a href="javascript:void(0)" data-coupon-id="'+o.id+'"  onclick="getCoupon(this)">点击领取</a></span>'
                    }
                    html  +=   '</div></div>';
                });
                $('.deta-coucon').append(html);

            }
        });
    }

    // 领取
    function getCoupon(obj){
        $.ajax({
            type: "POST",
            url: "<?php echo U('Mobile/Activity/getCoupon'); ?>",
            data: {coupon_id: $(obj).data('coupon-id')},
            dataType: "json",
            error: function () {
                layer.alert("服务器繁忙, 请联系管理员!");
            },
            success: function (data) {
                if (data.status == 1) {
                    layer.open({content: data.msg,skin: 'msg',time: 2});
                    $(obj).parents('.deta-coulist').find('.fl').append('<i>已领取</i>');
                    $(obj).addClass('couapply-pro');
                    $(obj).attr('onclick','');
                    $(obj).text('适用商品');
                } else {
                    layer.open({content: data.msg,skin: 'msg',time: 2});
                }
            }
        });
    }

</script>

<script src="/public/js/jqueryUrlGet.js"></script><!--获取get参数插件-->
<script> set_first_leader(); //设置推荐人 </script>
</body>
</html>
