<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:45:"./template/mobile/rainbow/index/adv_list.html";i:1566456327;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<title>浏览广告页</title>
		<link rel="stylesheet" href="/static/css/banner.css" />
	</head>
	<body>
		<div class="header">
		<img src="images/back.png" class="back">浏览广告
		</div>
		<ul class="lists">
			<?php if(is_array($task_list) || $task_list instanceof \think\Collection || $task_list instanceof \think\Paginator): $i = 0; $__LIST__ = $task_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
				<li>
					<div class="img"></div>
					<p class="headline"><?php echo $v['desc']; ?></p>
					<p class="score">完成任务获得积分:<?php echo $v['price']; ?>个</p>
					<p class="total">总条数：<?php echo $v['total_num']; ?>条</p>
					<p class="surplus">剩余：<font><?php echo $v['num']; ?>条</font></p>
					<p class="time">发布时间:<?php echo $v['add_time']; ?></p>
					<a href="/Mobile/index/adv_details?id=<?php echo $v['id']; ?>" class="link">浏览</a>
				</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</body>
</html>
