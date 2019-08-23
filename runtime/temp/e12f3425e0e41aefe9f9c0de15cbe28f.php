<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:42:"./template/mobile/rainbow/index/index.html";i:1566445258;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="stylesheet" href="/static/css/swiper.min.css" />
		<title></title>
	</head>
<body>
	<div class="header">
		<div class="searchDiv">
			<img src="/static/img/search.png" class="searchIcon">
			<input type="text"  class="searchInput"/>
		</div>
	</div>
	<div style="width: 100%;height: 1rem;"></div>
	<div class="bannerDiv">
		<div class="bannerbox">
			<div class="swiper-container swiper-containerA">
		        <div class="swiper-wrapper">
		             <?php $pid =9;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1566442800 and end_time > 1566442800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("5")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 5- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
			            <div class="swiper-slide">
			             	<a href="<?php echo $v['ad_link']; ?>">
			            		<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>" >
			            	 </a>
			            </div>
		             <?php endforeach; ?>
		        </div>
		        <!-- Add Pagination -->
		        <div class="swiper-pagination swiper-paginationA"></div>
		    </div>
		</div>
	</div>
	
	<div class="iconBox">
		<div class="swiper-container swiper-containerB">
	        <div class="swiper-wrapper">
	            <div class="swiper-slide">
	            	<a href="/mobile/index/adv_list">
	            		<img src="/static/img/1.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/2.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/3.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/4.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/5.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/6.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/7.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/8.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/9.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/10.png">
	            		<span>每日新品</span>
	            	</a>
	            </div>
	            <div class="swiper-slide">
	            	<a href="###">
	            		<img src="/static/img/11.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/12.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/13.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/14.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/15.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/16.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/17.png">
	            		<span>每日新品</span>
	            	</a>
	            	<a href="###">
	            		<img src="/static/img/18.png">
	            		<span>每日新品</span>
	            	</a>
	            </div>
	        </div>
	        <!-- Add Pagination -->
	        <div class="swiper-pagination swiper-paginationB"></div>
		</div>		
	</div>
	
	<div class="link1">
		<a href="###">立即抢购   》</a>
	</div>
	<div class="linkBox">
		
		
		
		
		<div  class="div a1">
		 	<?php $pid =2;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1566442800 and end_time > 1566442800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 1- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
				<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>">
				<a href="<?php echo $v[ad_link]; ?>" class="linkBtn1">立即投放</a>
			<?php endforeach; ?>
		</div>
		<div  class="div a2">
			<?php $pid =537;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1566442800 and end_time > 1566442800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 1- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
				<img  src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>">
				<a href="<?php echo $v[ad_link]; ?>" class="linkBtn2">GO 开聊吧</a>
			<?php endforeach; ?>
		</div>
		<div class="div a3">
			<?php $pid =538;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1566442800 and end_time > 1566442800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 1- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
				<img  src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>">
				<a href="<?php echo $v[ad_link]; ?>" class="linkBtn3">了解一下</a>
			<?php endforeach; ?>
		</div>
		<?php $pid =541;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1566442800 and end_time > 1566442800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 1- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
			<a href="<?php echo $v[ad_link]; ?>" class="a4">
				<img src="<?php echo $v[ad_code]; ?>">
			</a>
		<?php endforeach; ?>
		
		<div class="linkList">
			<?php if(is_array($favourite_goods) || $favourite_goods instanceof \think\Collection || $favourite_goods instanceof \think\Paginator): $i = 0; $__LIST__ = $favourite_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
				<a href="/Mobile/Goods/goodsInfo/id/<?php echo $v[goods_id]; ?>">
					<img src="<?php echo $v['original_img']; ?>">
				</a>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
    <div class="link2">
    	<?php $pid =539;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1566442800 and end_time > 1566442800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("4")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 4- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
	    	<a href="<?php echo $v['ad_link']; ?>" class="a9">
	    		<img src="<?php echo $v[ad_code]; ?>">
	    	</a>
    	<?php endforeach; ?>
    </div>
    <?php $pid =540;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1566442800 and end_time > 1566442800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 1- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
	    <a href="<?php echo $v['ad_link']; ?>" class="link3">
	    	<img src="<?php echo $v[ad_code]; ?>">
	    </a>
    <?php endforeach; ?>
    <div class="lists">
        <div class="swiper-container swiper-containerC">
	        <div class="swiper-wrapper">
	            <?php if(is_array($hot_goods) || $hot_goods instanceof \think\Collection || $hot_goods instanceof \think\Paginator): $i = 0; $__LIST__ = $hot_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
		            <div class="swiper-slide">
		            	<a href="/Mobile/Goods/goodsInfo/id/<?php echo $v['goods_id']; ?>" style="width:120px;">
		            		<img style="width:120px;height:115px;" src="<?php echo $v['original_img']; ?>">
		            		<p class="proName"><?php echo $v['goods_name']; ?></p>
		            		<p class="proPrice">¥<?php echo $v['shop_price']; ?></p>
		            	</a>
		            </div>
	            <?php endforeach; endif; else: echo "" ;endif; ?>
	        </div>
	        <!-- Add Pagination -->
	        <div class="swiper-pagination swiper-paginationC"></div>
	    </div>
    </div>
    <div class="titles">
    	<img src="/static/img/title.png">
    </div>
    <div class="list1">
    	<?php if(is_array($new_goods) || $new_goods instanceof \think\Collection || $new_goods instanceof \think\Paginator): $i = 0; $__LIST__ = $new_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
		    	<div class="proList">
		    		<img src="<?php echo $v['original_img']; ?>" class="pros">
		    		<p class="proName1"><?php echo $v['goods_name']; ?></p>
		    		<div class="prices">
		    			<img src="/static/img/d.png">
		    			<span class="price1">¥<?php echo $v['shop_price']; ?></span>
		    			<span class="price2">¥<?php echo $v['market_price']; ?></span>
		    		</div>
		    		<div class="lineBox">
		    		   <div class="line">
		    		   	 <div class="line1"></div>
		    		   </div>
		    		   <span class="bf"><?php echo $v['sales_sum']; ?>件</span>
		    		</div>
		    		<a href="###" class="buy">
		    			<img src="/static/img/buy.png">
		    		</a>
		    	</div>
    	<?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div style="width: 100%;height: 1.8rem;"></div>
    <a href="###" class="link4">
    	<img src="/static/img/banner10.png">
    </a>
    <div class="footer">
    	<a href="###">
    		<img src="/static/img/a1.png">
    		<span>首页</span>
    	</a>
    	<a href="###">
    		<img src="/static/img/a2.png">
    		<span>赚钱</span>
    	</a>
    	<a href="###">
    		<img src="/static/img/a3.png">
    		<span>购物车</span>
    	</a>
    	<a href="###">
    		<img src="/static/img/a4.png">
    		<span>我的</span>
    	</a>
    </div>
</body>
<script type="text/javascript" src="js/jquery-3.2.1.min.js" ></script>
<script type="text/javascript" src="/static/img/swiper.min.js" ></script>
<script>
    var swiperA = new Swiper('.swiper-containerA', {
        pagination: '.swiper-paginationA',
        paginationClickable: true
    });
    var swiperB = new Swiper('.swiper-containerB', {
        pagination: '.swiper-paginationB',
        paginationClickable: true
    });
    var swiperC = new Swiper('.swiper-containerC', {
        pagination: '.swiper-paginationC',
        slidesPerView: 3,
        spaceBetween: 10     
    });
</script>
</html>
