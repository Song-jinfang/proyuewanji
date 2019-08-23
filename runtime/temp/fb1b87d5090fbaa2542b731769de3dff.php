<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:41:"./template/mobile/rainbow/cart/index.html";i:1540260094;s:67:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header.html";i:1540260094;s:71:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header_nav.html";i:1540260094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>购物车--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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

<div class="classreturn loginsignup ">
    <div class="content">
        <div class="ds-in-bl return">
            <a id="[back]" <?php  if(request()->action() == 'userinfo' && $_GET["action"]==""){  ?>  href="<?php echo U('User/index'); ?>" <?php  }else{  ?> href="javascript:history.back(-1);" <?php  }  ?> ><img src="/template/mobile/rainbow/static/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>购物车</span>
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
<style>
    .get_mp span.disable {
        cursor: default;
        color: #e9e9e9;
    }
</style>
<?php if(empty($user['user_id'])): ?>
    <!--###用户未登录###-->
    <div class="loginlater">
        <img src="/template/mobile/rainbow/static/images/small_car.png"/>
        <span>登录后可同步电脑和手机购物车</span>
        <a href="<?php echo U('Mobile/User/loagin'); ?>">登录</a>
    </div>
<?php endif; ?>
    <div class="cart_list">
        <!--购物车没有商品-s-->
        <div class="nonenothing" <?php if(!(empty($cartList) || (($cartList instanceof \think\Collection || $cartList instanceof \think\Paginator ) && $cartList->isEmpty()))): ?>style="display: none"<?php endif; ?>>
            <img src="/template/mobile/rainbow/static/images/nothing.png"/>
            <p>购物车暂无商品</p>
            <a href="<?php echo U('Mobile/Index/index'); ?>">去逛逛</a>
        </div>
        <!--购物车没有商品-e-->

            <?php if(is_array($cartList) || $cartList instanceof \think\Collection || $cartList instanceof \think\Paginator): $i = 0; $__LIST__ = $cartList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cart): $mod = ($i % 2 );++$i;if(!$cart['combination_cart']): ?>

                <div class="z_cart_wrap">
                    <div class="orderlistshpop p" id="cart_list_<?php echo $cart['id']; ?>" date-type="<?php echo $cart['prom_type']; ?>">
                        <div class="maleri30">
                            <!--商品列表-s-->
                            <div class="sc_list">
                                <div class="radio fl ">
                                    <!--商品勾选按钮-->
                                    <span onClick="checkGoods(this)" <?php if($cart[selected] == 1): ?>class="che check_t"<?php else: ?>class="che"<?php endif; ?>>
                                     <i>
                                         <input name="checkItem" type="checkbox" style="display:none;" value="<?php echo $cart['id']; ?>" <?php if($cart[selected] == 1): ?>checked="checked"<?php endif; ?>>
                                     </i>
                                     </span>
                                </div>
                                <div class="shopimg fl">
                                    <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$cart[goods_id])); ?>">
                                        <!--商品图片-->
                                        <img src="<?php echo goods_thum_images($cart['goods_id'],400,400,$cart[item_id]); ?>">
                                    </a>
                                </div>
                                <div class="deleshow fr">
                                    <div class="deletes">
                                        <!--商品名-->
                                        <span class="similar-product-text fl">
                                            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$cart[goods_id])); ?>"><?php echo $cart[goods_name]; ?></a>
                                        </span>
                                        <!--删除按钮-->
                                        <a href="javascript:void(0);" class="delescj deleteGoods" data-cart-id="<?php echo $cart['id']; ?>"><img src="/template/mobile/rainbow/static/images/dele.png"/></a>
                                    </div>
                                    <!--商品属性，规格-->
                                    <p class="weight"><?php echo $cart[spec_key_name]; ?></p>
                                    <div class="prices">
                                        <p class="sc_pri fl">
                                            <!--商品单价-->
                                            <span id="cart_<?php echo $cart['id']; ?>_member_goods_price">￥<?php echo $cart['member_goods_price']; ?></span>
                                        </p>
                                        <!--加减数量-->
                                        <div class="plus fr get_mp">
                                            <span class="mp_minous">-</span>
                                            <span class="mp_mp">
                                                <input name="changeQuantity_<?php echo $cart['id']; ?>" type="text" id="changeQuantity_<?php echo $cart['id']; ?>" value="<?php echo $cart['goods_num']; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="input-num"/>
                                            </span>
                                            <span class="mp_plus">+</span>
                                        </div>
                                        <p class="sc_pri fr" style="display: none">库存不足
                                            <input  type="hidden" name="goods_num[<?php echo $cart['id']; ?>]"  value="0"  class="input-num" />
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--商品列表-e-->
                        </div>
                    </div>
                </div>
                <!--购物车没有商品-e-->

                    <?php else: ?>
                    <!--搭配套餐 e-->
                    <!--购物车没有商品-e-->
                    <div class="Set-meal-wrap ">
                        <div class="orderlistshpop-titles p">
                            <!--<div class="radio fl dpg-radios">-->
                                <!--&lt;!&ndash;商品勾选按钮&ndash;&gt;-->
                                <!--<span onClick="checkGoods(this)" <?php if($cart[selected] == 1): ?>class="che check_t"<?php else: ?>class="che"<?php endif; ?>>-->
                                <!--<i>-->
                                    <!--<input name="checkItem" type="checkbox" style="display:none;" value="<?php echo $cart['id']; ?>" <?php if($cart[selected] == 1): ?>checked="checked"<?php endif; ?>>-->
                                <!--</i>-->
                                <!--</span>-->
                            <!--</div>-->
                            <span class="meal-wap-icon fl"></span>
                            <p class="fl"><?php echo $cart['combination']['title']; ?></p>
                            <span class="fr" style="line-height: 2.0266rem;color: #f23030;font-size: .61rem;margin-top: 0.32rem;display: block;" >共优惠：￥<em id="countDiscount_<?php echo $cart['id']; ?>"><?php echo $cart['cut_fee']; ?></em> </span>

                        </div>
                        <!--输出主商品-->
                        <div class="orderlistshpop p" id="cart_list_<?php echo $cart['id']; ?>" data-type="<?php echo $cart['prom_type']; ?>"
                             data-goods-id="<?php echo $cart['goods_id']; ?>"  data-goods-item="<?php echo $cart['combination_goods'][0]['item_id']; ?>"  >
                            <div class="sc_list_icn"></div>
                            <div class="maleri30">
                                <!--商品列表-s-->
                                <div class="sc_list">
                                    <div class="radio fl  dpg-radios-class">
                                        <!--商品勾选按钮-->
                                        <!--<input name="checkItem" type="checkbox" style="display:none;" value="<?php echo $cart['id']; ?>" <?php if($cart[selected] == 1): ?>checked="checked"<?php endif; ?>>-->
                                        <!--<span class="<?php if($cart[selected] == 1): ?>check_t<?php endif; ?>">-->
                                        <span onClick="checkGoods(this)" <?php if($cart[selected] == 1): ?>class="che check_t"<?php else: ?>class="che"<?php endif; ?>>
                                        <i class="dapei_icon_s">
                                        <input name="checkItem" type="checkbox" style="display:none;" value="<?php echo $cart['id']; ?>" <?php if($cart[selected] == 1): ?>checked="checked"<?php endif; ?>>
                                        </i>
                                        </span>
                             <!--<i>-->
                             <!--</i>-->
                             <!--</span>-->
                                    </div>
                                    <div class="shopimg fl">
                                        <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$cart[goods_id])); ?>">
                                            <!--商品图片-->
                                            <img src="<?php echo goods_thum_images($cart['goods_id'],400,400,$cart[item_id]); ?>">
                                        </a>
                                    </div>
                                    <div class="deleshow fr">
                                        <div class="deletes">
                                            <!--商品名-->
                                            <span class="similar-product-text fl">
                                    <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$cart[goods_id])); ?>"><?php echo $cart[goods_name]; ?></a>
                                </span>
                                            <!--删除按钮-->
                                            <a href="javascript:void(0);" class="delescj deleteGoods" data-cart-id="<?php echo $cart['id']; ?>"><img src="/template/mobile/rainbow/static/images/dele.png"/></a>
                                        </div>
                                        <!--商品属性，规格-->
                                        <p class="weight"><?php echo $cart[spec_key_name]; ?></p>
                                        <div class="prices">
                                            <p class="sc_pri fl">
                                                <!--商品单价-->
                                                <span id="cart_<?php echo $cart['id']; ?>_member_goods_price">￥ <?php echo $cart['member_goods_price']; ?></span>
                                            </p>
                                            <!--加减数量-->
                                            <div class="plus fr get_mp">
                                                <span class="mp_minous">-</span>
                                                <span class="mp_mp">
                                        <input name="changeQuantity_<?php echo $cart['id']; ?>" type="text" id="changeQuantity_<?php echo $cart['id']; ?>" value="<?php echo $cart['goods_num']; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="input-num"/>
                                    </span>
                                                <span class="mp_plus">+</span>
                                            </div>
                                            <p class="sc_pri fr" style="display: none">库存不足
                                                <input  type="hidden" name="goods_num[<?php echo $cart['id']; ?>]" value="0"  class="input-num" />
                                            </p>
                                        </div>
                                        <div class="price-foots">
                                        <?php if($cart['goods_price']-$cart['member_goods_price'] !=0): ?>
                                            <p class="price-foot-two">共省：<i>￥</i> <em id="cart_<?php echo $cart['id']; ?>_save_price"><?php echo $cart['cut_fee']; ?></em></p>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!--商品列表-e-->
                            </div>
                        </div>
                        <!--输出主商品结束-->
                         <!--输出副商品-->
                        <?php if(is_array($cart['combination_cart']) || $cart['combination_cart'] instanceof \think\Collection || $cart['combination_cart'] instanceof \think\Paginator): $i = 0; $__LIST__ = $cart['combination_cart'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cart_r): $mod = ($i % 2 );++$i;?>
                            <div class="orderlistshpop p" id="cart_list_<?php echo $cart_r['id']; ?>">
                                <div class="sc_list_icn"></div>
                                <div class="maleri30">
                                    <!--商品列表-s-->
                                    <div class="sc_list">
                                        <div class="radio fl  dpg-radios-class">
                                            <!--商品勾选按钮-->
                                            <span class="<?php if($cart[selected] == 1): ?>check_t<?php endif; ?>">
					                             <i class="dapei_icon_b">
					                             </i>
					                        </span>
                                        </div>
                                        <div class="shopimg fl">
                                            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$cart_r[goods_id])); ?>">
                                                <!--商品图片-->
                                                <img src="<?php echo goods_thum_images($cart_r['goods_id'],400,400,$cart_r[item_id]); ?>">
                                            </a>
                                        </div>
                                        <div class="deleshow fr">
                                            <div class="deletes">
                                                <!--商品名-->
                                                <span class="similar-product-text fl">
                                    <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$cart_r[goods_id])); ?>"><?php echo $cart_r[goods_name]; ?></a>
                                </span>
                                                <!--删除按钮-->
                                                <a href="javascript:void(0);" class="delescj deleteGoods" data-cart-id="<?php echo $cart_r['id']; ?>"><img src="/template/mobile/rainbow/static/images/dele.png"/></a>
                                            </div>
                                            <!--商品属性，规格-->
                                            <p class="weight"><?php echo $cart_r[spec_key_name]; ?></p>
                                            <div class="prices">
                                                <p class="sc_pri fl">
                                                    <!--商品单价-->
                                                    <span id="cart_<?php echo $cart_r['id']; ?>_member_goods_price">￥<?php echo $cart_r['member_goods_price']; ?></span>
                                                </p>
                                                <!--加减数量-->

                                                <div class="plus fr get_mp mun-two p" style="margin-right: .6rem;">
                                                <i class="fl mp_price_i">x</i> <span class="mp_mp">

                                                <input name="changeQuantity_<?php echo $cart_r['id']; ?>" disabled class="mp_price_input" type="text" id="changeQuantity_<?php echo $cart_r['id']; ?>" value="<?php echo $cart_r['goods_num']; ?>"  class="input-num"/>
                                                </span>
                                                </div>
                                                <p class="sc_pri fr" style="display: none">库存不足
                                                    <input  type="hidden" name="goods_num[<?php echo $cart_r['id']; ?>]" value="0"  class="input-num" />
                                                </p>
                                            </div>
                                            <div class="price-foots">
                                                <?php if($cart_r['goods_price']-$cart_r['member_goods_price'] !=0): ?>
                                                    <p class="price-foot-two">共省：<i>￥</i> <em id="cart_<?php echo $cart_r['id']; ?>_save_price"><?php echo $cart_r['cut_fee']; ?></em></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!--商品列表-e-->
                                </div>
                            </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <!--输出副商品结束-->
                    <!--</div>-->
        <!--搭配套餐 e-->
                <?php endif; ?>
                    <!--</div>-->
                    <!--商品列表-e-->
                <!--</div>-->
            </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <!--提交栏-s-->
        <?php if(!(empty($cartList) || (($cartList instanceof \think\Collection || $cartList instanceof \think\Paginator ) && $cartList->isEmpty()))): ?>
            <div class="foohi foohiext">
                <div class="payit ma-to-20 payallb">
                    <div class="fl alllef">
                        <div class="radio fl">
                                <span class="che alltoggle checkFull" onClick="checkGoods(this)">
                                    <i></i>
                                </span>
                            <span class="all">全选</span>
                        </div>
                        <div class="youbia">
                            <p><span class="pmo">总计：</span><span>￥</span><span id="total_fee">0.00</span></p>
                            <p class="lastime"><span id="goods_fee">节省：￥0.00</span></p>
                        </div>
                    </div>
                    <div class="fr">
                        <a href="javascript:void(0);" onclick="cart_submit();">去结算</a>
                    </div>
                </div>
            </div>
            <!--提交栏-e-->
            <script type="text/javascript">
                $(document).ready(function(){
                    initDecrement();
                    initCheckBox();
                });
            </script>
         <?php endif; ?>
    </div>
<!--看看热卖-start-->
<div class="hotshop seehotsho">
    <div class="thirdlogin">
        <h4>看看热卖</h4>
    </div>
</div>
<div class="floor guesslike">
    <div class="likeshop">
        <ul>
            <?php if(is_array($hot_goods) || $hot_goods instanceof \think\Collection || $hot_goods instanceof \think\Paginator): if( count($hot_goods)==0 ) : echo "" ;else: foreach($hot_goods as $key=>$good): ?>
                <li>
                    <a href="<?php echo U('Mobile/goods/goodsInfo',array('id'=>$good[goods_id])); ?>">
                        <div class="similer-product">
                            <img src="<?php echo goods_thum_images($good[goods_id],400,400); ?>"/>
                            <span class="similar-product-text"><?php echo getsubstr($good[goods_name],0,20); ?></span>
                                <span class="similar-product-price">
                                    ¥<span class="big-price"><?php echo $good[shop_price]; ?></span>
                                    <!--<span class="small-price">.00</span>-->
                                </span>
                        </div>
                    </a>
                </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="add">热卖商品实时更新，常回来看看哟~</div>
</div>
<!--看看热卖-end-->
<script type="text/javascript">
    $(document).ready(function(){
        AsyncUpdateCart();
    });
    $(function () {
        priceShow()

    })
    //初始化金额
    function priceShow(){
        var data = $('.price-foot-two').find('em');
        $.each(data,function (i,o) {
            var price = Number($(this).text()).toFixed(2);
            $(this).text(price);
        })
    }



    //点击结算
    function cart_submit() {
        //获取选中的商品个数
        var j = 0;
        $('input[name^="checkItem"]:checked').each(function () {
            j++;
        });
        //选择数大于0
        if (j > 0) {
            //跳转订单页面
            window.location.href = "<?php echo U('Mobile/Cart/cart2'); ?>"
        } else {
            layer.open({content: '请选择要结算的商品！', time: 2});
            return false;
        }
    }
    //购物车对象
    function CartItem(id, goods_num,selected) {
        this.id = id;
        this.goods_num = goods_num;
        this.selected = selected;
    }
    //初始化计算订单价格
    function AsyncUpdateCart(){
        var cart = new Array();
        var inputCheckItem = $("input[name^='checkItem']");
        inputCheckItem.each(function(i,o){
            var id = $(this).attr("value");
            var goods_num = $(this).parents('.sc_list').find("input[id^='changeQuantity']").attr('value');
            if ($(this).attr("checked") == 'checked') {
                var cartItemCheck = new CartItem(id,goods_num,1);
                cart.push(cartItemCheck);
            }else{
                var cartItemNoCheck = new CartItem(id,goods_num,0);
                cart.push(cartItemNoCheck);
            }
        })
        $.ajax({
            type : "POST",
            url:"<?php echo U('Mobile/Cart/AsyncUpdateCart'); ?>",//,
            dataType:'json',
            data: {cart: cart},
            success: function(data){
                if(data.status == 1){
                    $('#goods_num').empty().html(data.result.cart_price_info.goods_num);
                    $('#total_fee').empty().html(data.result.cart_price_info.total_fee.toFixed(2));
                    $('#goods_fee').empty().html('节省：￥'+data.result.cart_price_info.goods_fee.toFixed(2));
                    if(data.result.cart_list.length > 0){
                        set_cart_list_price(data.result.cart_list);
                    }else{
                        $('.total_price').empty();
                        $('.cut_price').empty();
                    }
                }
            }
        });
    }

    //更新价格
    function set_cart_list_price(cart_list)
    {
        for(var i = 0; i < cart_list.length; i++){
            $('#cart_'+cart_list[i].id+'_goods_price').empty().html('￥'+Number(cart_list[i]['goods_price']).toFixed(2));
            $('#cart_'+cart_list[i].id+'_total_price').empty().html('￥'+cart_list[i].total_fee.toFixed(2));
            $('#cart_'+cart_list[i].id+'_market_price').empty().html('￥'+cart_list[i].member_goods_price*cart_list[i].goods_num.toFixed(2)); //活动价格
            $('#cart_'+cart_list[i].id+'_save_price').empty().html(cart_list[i].cut_fee.toFixed(2));
            $('#changeQuantity_'+cart_list[i].id).val(cart_list[i].goods_num); //数量
            if (cart_list[i].hasOwnProperty("combination_cart") && cart_list[i].combination_cart.length > 0) {
                set_cart_list_price(cart_list[i].combination_cart);
            }
            //共省多少钱
            countDiscount();
        }
    }

    $(function(){
        countDiscount();
    })
    //遍历每个套餐共省多少钱
    function countDiscount(){
        $('.Set-meal-wrap ').each(function(i,o){
            var s =$(this).find('.orderlistshpop');
            // console.log(s);
            var countPrice = 0;
            s.each(function () {
                countPrice += parseFloat($(this).find('.price-foot-two em').text());
            })

            $(this).find('.orderlistshpop-titles em').text(countPrice.toFixed(2))
        })
    }
    //商品数量加减
    $(function(){
        //加数量
        $('.mp_minous').click(function(){
            if(!$(this).hasClass('disable')){
                var inputs = $(this).siblings('.mp_mp').find('input');
                var val = inputs.val();
                if(val>0){
                    val--;
                }
                inputs.val(val);
                inputs.attr('value',val);
                initDecrement();
                conCheckBox();
                changeNum(this);
            }
        })
        //减数量
        $('.mp_plus').click(function(){
            var inputs = $(this).siblings('.mp_mp').find('input');
            var val = inputs.val();
            val++;
            if(val > 200){
                val = 200;
                layer.open({content: "购买商品数量不能大于200",time:2});
            }
            inputs.val(val);
            inputs.attr('value',val);
            initDecrement();
            changeNum(this);
            conCheckBox();
        })
        $(document).on("blur", '.get_mp input', function (e) {
            var changeQuantityNum = parseInt($(this).val());
            if(changeQuantityNum <= 0){
                layer.open({
                    content: '商品数量必须大于0'
                    ,btn: ['确定']
                });
                $(this).val($(this).attr('value'));
            }else{
                $(this).attr('value', changeQuantityNum);
            }
            initDecrement();
            changeNum(this);
            conCheckBox();
        })
    })
    
    //勾选商品
    function checkGoods(obj){
    	
        if($(obj).hasClass('check_t')){
            //改变颜色
            $(obj).removeClass('check_t');
//          搭配购改变颜色
            $(obj).parents(".Set-meal-wrap").find(".dpg-radios-class").children("span").removeClass("check_t");
                 $(obj).parents(".Set-meal-wrap").find(".sc_list_icn").addClass("sc_list-none");
            //取消选中
            $(obj).find('input').attr('checked',false);
        }else {
            //改变颜色
            $(obj).addClass('check_t');
            //勾选选中
             $(obj).find('input').attr('checked',true);
           //          搭配购改变颜色
     		 $(obj).parents(".Set-meal-wrap").find(".dpg-radios-class").children("span").addClass("check_t");
       		  $(obj).parents(".Set-meal-wrap").find(".sc_list_icn").removeClass("sc_list-none");

        }

        //选中全选多选框
        if($(obj).hasClass('checkFull')){
            if($(obj).hasClass('check_t')){
                $(".che").each(function(i,o){
                    $(this).addClass('check_t');
                     $(this).parents(".Set-meal-wrap").find(".dpg-radios-class").children("span").addClass("check_t");
       		 		  $(this).parents(".Set-meal-wrap").find(".sc_list_icn").removeClass("sc_list-none");
                    $(this).find('input').attr('checked',true);
                })
            }else{
                $(".che").each(function(i,o){
                    $(this).removeClass('check_t');
                     $(this).parents(".Set-meal-wrap").find(".dpg-radios-class").children("span").removeClass("check_t");
                		  $(this).parents(".Set-meal-wrap").find(".sc_list_icn").addClass("sc_list-none");
                    $(this).find('input').attr('checked',false);
                })
            }
        }
    }
//  默认选中虚线
    $(".Set-meal-wrap").find(".sc_list_icn").addClass("sc_list-none");
    //更改购买数量对减购买数量按钮的操作
    function initDecrement(){
        $("input[id^='changeQuantity']").each(function(i,o){
            if($(o).val() == 1){
                $(o).parents('.get_mp').find('.mp_minous').addClass('disable');
            }
            if($(o).val() > 1){
                $(o).parents('.get_mp').find('.mp_minous').removeClass('disable');
            }
        })
    }
    //多选框点击事件
    $(function () {
        $(document).on("click", '.che', function (e) {
            checkGoods($(this));
            initCheckBox();
            AsyncUpdateCart();
        })
    })
    //更改购物车请求事件
    function changeNum(obj){
        // var checkall = $(obj).parents('.orderlistshpop').find('.che');
        var checkall = $(obj).parents('.sc_list').find('.radio span');

        if(!checkall.hasClass('check_t')){
            checkGoods(checkall);
            initCheckBox();

        }
        var input = $(obj).parents('.get_mp').find('input');
        var cart_id = input.attr('id').replace('changeQuantity_','');
        var goods_num = input.attr('value');
        var cart = new CartItem(cart_id, goods_num, 1);
        var type = $(obj).parents('.orderlistshpop').attr('data-type');
        if(type == 7){
            var v = $(obj).parents('.orderlistshpop').next().find('.mp_price_input').val();
        }
        $.ajax({
            type: "POST",
            url: "<?php echo U('Mobile/Cart/changeNum'); ?>",//+tab,
            dataType: 'json',
            data: {cart: cart},
            success: function (data) {
                if(data.status == 1){
                    AsyncUpdateCart();
                }else{
                    input.val(v);
                    input.attr('value',v);
                    layer.open({
                        content: data.msg
                        ,btn: ['确定']
                    });
                    initDecrement();
                }
            }
        });
    }
    //删除购物车商品
    $(function () {
        //删除购物车商品事件
        $(document).on("click", '.deleteGoods', function (e) {
            var cart_ids = new Array();
            cart_ids.push($(this).attr('data-cart-id'));
            layer.open({
                content: '确定要删除此商品吗'
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    layer.close(index);
                    $.ajax({
                        type : "POST",
                        url:"<?php echo U('Mobile/Cart/delete'); ?>",
                        dataType:'json',
                        data: {cart_ids: cart_ids},
                        success: function(data){
                            if(data.status == 1){
                                for (var i = 0; i < cart_ids.length; i++) {
                                    var that = $('#cart_list_' + cart_ids[i]);
                                    var type = that.parent().find('.orderlistshpop').eq(0).attr('data-type');
                                    var goods_id = that.parent().find('.orderlistshpop').eq(0).attr('data-goods-id');
                                    var item_id = that.parent().find('.orderlistshpop').eq(0).attr('data-goods-item');
                                    var cart_id = that.parent().find('.orderlistshpop').eq(0).find('.deleteGoods').attr('data-cart-id');//主商品cart_id
                                    //如果主商品和被删除的商品相等，则全部删除
                                    if(cart_id == cart_ids[i]){
                                        that.parent().remove();
                                        cartEmpty();
                                    }else {
                                        if(that.parent().find('.orderlistshpop').length <= 2){
                                            that.parent().remove();
                                            if(type==7){
                                                //搭配购删除剩下主商品的时候，恢复原价
                                                recoveryGoods(goods_id,item_id)
                                            }else{
                                                cartEmpty();
                                            }
                                        }else{
                                            that.remove();
                                            cartEmpty();
                                        }
                                    }

                                }

                            }else{
                                layer.open({content: data.msg,time:2});
                            }
                            AsyncUpdateCart();
                        }
                    });
                }
            });
        })
    })

    /**
     * 检测购物车是否为空
     */
    function cartEmpty() {
        var store_div = $('.orderlistshpop');
        if(store_div.length == 0){
            location.reload();
        }
    }


    /**
     * 检测选项框
     */
    function initCheckBox(){
        var checkBoxsFlag = true;
        $("input[name^='checkItem']").each(function(i,o){
            if ($(this).attr("checked") != 'checked') {
                checkBoxsFlag = false;
            }
        })
        if(checkBoxsFlag == false){
            $('.checkFull').removeClass('check_t');
        }else{
            $('.checkFull').addClass('check_t');
        }
        conCheckBox()
    }

    /**
     * 搭配购删除回复普通商品原价
     */
    function recoveryGoods(id,item) {
        $.ajax({
            type: "POST",
            url: "<?php echo U('Home/Cart/add'); ?>",
            data: {goods_id: id,goods_num: 1,item_id: item},//+tab,
            dataType: 'json',
            success: function (data) {
                console.log(data)
                if (data.status == 1) {
                    window.location.reload();
                } else {
                    layer.msg('操作失败', {icon: 2});
                }
            }
        });
    }
    /**
     * 检测搭配购选项框
     */
    function conCheckBox(){
        $('.Set-meal-wrap ').each(function(i,o){
            var s =$(this).find('.orderlistshpop').eq(0).find('.radio span');
                if(s.hasClass('check_t')){
                    $(this).find('.orderlistshpop-titles').find('.radio span').addClass('check_t')
                    $(this).find('.orderlistshpop-titles').find('.radio input').attr('checked','checked')
                }
        })
    }

</script>
</body>
</html>



