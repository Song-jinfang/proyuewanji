<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:47:"./template/mobile/rainbow/user/points_list.html";i:1540260096;s:67:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header.html";i:1540260094;s:71:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header_nav.html";i:1540260094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>积分明细记录--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <a id="[back]" <?php  if(request()->action() == 'userinfo' && $_GET["action"]==""){  ?>  href="<?php echo U('User/index'); ?>" <?php  }else{  ?> href="javascript:history.back(-1)" <?php  }  ?> ><img src="/template/mobile/rainbow/static/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>积分明细记录</span>
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
<div class="allaccounted">
    <div class="maleri30">
        <div class="head_acc ma-to-20">
            <ul>
                <li <?php if($type == 'all'): ?>class="red"<?php endif; ?>">
                    <a href="<?php echo U('User/points_list',array('type'=>'all')); ?>"  data-list="1">全部</a>
                </li>
                <li <?php if($type == 'plus'): ?>class="red"<?php endif; ?>>
                    <a href="<?php echo U('User/points_list',array('type'=>'plus')); ?>"   data-list="2">赚取</a>
                </li>
                <li  <?php if($type == 'minus'): ?>class="red"<?php endif; ?>>
                    <a href="<?php echo U('User/points_list',array('type'=>'minus')); ?>"  data-list="3">消费</a>
                </li>
            </ul>
        </div>
        <div class="allpion">
	         <div class="fll_acc fll_acc-h">
	         	<ul><li class="orderid-h">订单</li><li class="price-h">积分</li><li class="time-h">时间</li></ul>
	         </div>
             <?php if(is_array($account_log) || $account_log instanceof \think\Collection || $account_log instanceof \think\Paginator): if( count($account_log)==0 ) : echo "" ;else: foreach($account_log as $key=>$v): ?>
                 <div class="fll_acc">
                     <ul>
                         <li class="orderid-h"><?php echo (isset($v[order_sn]) && ($v[order_sn] !== '')?$v[order_sn]:'无'); ?></li>
                         <li class="price-h"><?php echo $v[pay_points]; ?></li>
                         <li class="time-h"><?php echo date('Y-m-d H:i:s',$v[change_time]); ?></li>
                     </ul>
                     <div class="des-h">描述:<?php echo $v[desc]; ?></div>
                 </div>
             <?php endforeach; endif; else: echo "" ;endif; ?>
         </div>
        <div id="getmore"  style="font-size:.32rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both;display: none">
            <a >已显示完所有记录</a>
        </div>
    </div>
</div>

<script type="text/javascript" src="/template/mobile/rainbow/static/js/sourch_submit.js"></script>
<script type="text/javascript">
    //加载更多记录
    var page = 1;
    var before_request = 1
    function ajax_sourch_submit()
    {
        if(before_request == 0) return false;
        before_request = 0
        page ++;
        $.ajax({
            type : "GET",
            url:"/index.php?m=mobile&c=User&a=points_list&is_ajax=1&type=<?php echo $type; ?>&p="+page,//+tab,
            success: function(data)
            {
                before_request = 1
                if($.trim(data) == '') {
                    $('#getmore').show();
                    return false;
                }else{
                    $(".allpion").append(data);
                }
            }
        });
    }
</script>
</body>
</html>