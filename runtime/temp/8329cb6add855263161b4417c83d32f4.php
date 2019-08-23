<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:41:"./template/mobile/rainbow/user/login.html";i:1540260096;s:67:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header.html";i:1540260094;s:71:"/www/wwwroot/proyuewanji/template/mobile/rainbow/public/header_nav.html";i:1540260094;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>登录--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <span>登录</span>
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
<div class="logo-wrap-bg">
    <a class="login-logo-wrap" href="#">
        <img src="<?php echo (isset($tpshop_config['shop_info_store_user_logo']) && ($tpshop_config['shop_info_store_user_logo'] !== '')?$tpshop_config['shop_info_store_user_logo']:'/public/static/images/logo/pc_home_user_logo_default.png'); ?>" alt="LOGO"/>
    </a>
</div>

<div class="loginsingup-input">
    <!--登录表单-s-->
    <form  id="loginform" method="post"  >
        <input type="hidden" name="referurl" id="referurl" value="<?php echo $referurl; ?>">
        <div class="lsu">
            <span class="ico ico-username"></span>
            <input type="text" name="username" id="username" value=""  placeholder="请输入用户名"/>
        </div>
        <div class="lsu">
            <span class="ico ico-password"></span>
            <input type="password" name="password" id="password" value="" placeholder="请输入密码"/>
        </div>
        <?php if(!(empty($first_login) || (($first_login instanceof \think\Collection || $first_login instanceof \think\Paginator ) && $first_login->isEmpty()))): ?>
        <div class="lsu">
            <span class="ico ico-v-code"></span>
            <input class="v-code-input" type="text" name="verify_code" id="verify_code" value="" placeholder="请输入验证码"/>
            <img class="v-code-pic"  id="verify_code_img" src="<?php echo U('Mobile/User/verify'); ?>" onClick="verify()"/>
        </div>
        <?php endif; ?>
        <div class="lsu-submit">
            <input type="button"  value="登 录"  onclick="submitverify()" class="btn_big1"  />
        </div>
    </form>
    <div class="signup-find p">
        <a class="note fl" href="<?php echo U('User/reg'); ?>">快速注册</a>
        <a class="note fr" href="<?php echo U('User/forget_pwd'); ?>">忘记密码？</a>
    </div>
<!--登录表单-e-->
    <!--第三方登陆-s-->
    <div class="thirdlogin">
        <h4>第三方登陆</h4>
        <div class="third-login-list">
        <?php
                                   
                                $md5_key = md5("select * from __PREFIX__plugin where type='login' AND status = 1");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("select * from __PREFIX__plugin where type='login' AND status = 1"); 
                                    S("sql_".$md5_key,$sql_result_v,1);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>
            <!--<?php if($v['code'] == 'weixin' AND is_weixin() != 1): ?>
                <a class="item-ico ico-wechat-login" href="<?php echo U('LoginApi/login',array('oauth'=>'weixin')); ?>" target="_blank" title="weixin"></a>
       <?php endif; ?>-->
            <?php if($v['code'] == 'qqq' AND is_qq() != 1): ?>
                <a class="item-ico ico-qq-login" href="<?php echo U('LoginApi/login',array('oauth'=>'qq')); ?>" target="_blank" title="QQ"></a>
            <?php endif; if($v['code'] == 'alipay' AND is_alipay() != 1 AND is_weixin() != 1): ?>
            <a class="item-ico ico-alipay-login" href="<?php echo U('LoginApi/login',array('oauth'=>'alipay')); ?>"></a>
            <?php endif; if($v['code'] == 'alipaynew' AND is_alipay() != 1 AND is_weixin() != 1): ?>
                <a class="item-ico ico-alipay-login" href="alipays://platformapi/startapp?appId=20000067&url=<?php echo $alipay_url; ?>"></a>
            <?php endif; endforeach; ?>
        </div>
    </div>
     <!--第三方登陆-e-->
</div>


<script type="text/javascript">
    function verify(){
        $('#verify_code_img').attr('src','/index.php?m=Mobile&c=User&a=verify&r='+Math.random());
    }

    //复选框状态
    function remember(obj){
         var che= $(obj).attr("class");
        if(che == 'che check_t'){
            $("#autologin").prop('checked',false);
        }else{
            $("#autologin").prop('checked',true);
        }
    }
    function submitverify()
    {
        var username = $.trim($('#username').val());
        var password = $.trim($('#password').val());
        var remember = $('#remember').val();
        var referurl = $('#referurl').val();
        var verify_code = $.trim($('#verify_code').val());
        if(username == ''){
            showErrorMsg('用户名不能为空!');
            return false;
        }
        if(!checkMobile(username) && !checkEmail(username)){
            showErrorMsg('账号格式不匹配!');
            return false;
        }
        if(password == ''){
            showErrorMsg('密码不能为空!');
            return false;
        }
        var codeExist = $('#verify_code').length;
        if (codeExist && verify_code == ''){
            showErrorMsg('验证码不能为空!');
            return false;
        }

        var data = {username:username,password:password,referurl:encodeURIComponent(referurl)};
        if (codeExist) {
            data.verify_code = verify_code;
        }
        $.ajax({
            type : 'post',
            url : '/index.php?m=Mobile&c=User&a=do_login&t='+Math.random(),
            data : data,
            dataType : 'json',
            success : function(data){
                if(data.status == 1){
                    var url = decodeURIComponent(data.url);
                    if (url.indexOf('user') >= 0 && url.indexOf('login') >= 0 || url == '') {
                        window.location.href = '/index.php/mobile';
                    }else{
                        window.location.href = url;
                    }
                }else{
                    layer.open({content: data.msg,time:2,end:function () {
                        if (codeExist) {
                            verify();
                        } else {
                            location.reload();
                        }
                    }});
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                showErrorMsg('网络异常，请稍后重试');
            }
        })
    }
    </script>
</body>
</html>
