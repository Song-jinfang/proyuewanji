<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:48:"./template/mobile/rainbow/index/adv_details.html";i:1566470836;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<title></title>
		<link rel="stylesheet" href="/static/css/details.css" />
		<script src="/static/js/layer.js"  type="text/javascript" ></script>
		<script src="/static/js/jquery-3.2.1.min.js"  type="text/javascript" ></script>
		<link rel="stylesheet" href="/static/js/layer.css" />
	</head>
	<body>
	<div class="header">
	   <img src="images/back.png" class="back">详情
	</div>
	<p class="pageTitle"><?php echo $task_info['desc']; ?></p>
	<input type="hidden" id="task_id" name="task_id" value="<?php echo $task_info['id']; ?>"/>
	<input type="hidden" id="order_id" name="order_id" value="<?php echo $_GET['id'] ?>"/>
	<input type="hidden" id="time_len" name="time_len" value="<?php echo $task_info['time_len']; ?>"/>
	<div class="detailsList">
		<div class="list">
			<p class="title">广告详情</p>
			<div class="text"><?php echo $task_info['content']; ?><a href="https://feixiaojie.com/">https://feixiaojie.com/</a></div>
		    <p class="title">广告详情</p>
		    <div class="text">
		    	<img src="<?php echo $task_info['thumb_img']; ?>">
		    </div>
		</div>
	</div>
	<div class="cricleDiv">
		<canvas id="canvas"></canvas>
	</div>
	</body>
	<script type="text/javascript" src="/static/js/circle.js" ></script>
	<script>
	var s=0;
	var task_id = $("#task_id").val();
		$.post('is_show',{'task_id':task_id},function(data){
			if(data.status == 1){
				s = 1;//给全局变量赋值
				var speed_time = $("#time_len").val() * 1000;
				var r=new Draws("canvas",{
				      lineW:5,
				      bgColor:"#dcd0b3",
				      lineColor:"#fbab16",
				      speed:speed_time
				    },callback);
				
			}else{
				s = 2;//给全局变量赋值
				var speed_time = 100;
				var r=new Draws("canvas",{
				      lineW:5,
				      bgColor:"#dcd0b3",
				      lineColor:"#fbab16",
				      speed:speed_time
				    },callback);
				
			}
		},'json');
	
	
	    function callback(){
	    	if(s == 1){
	    		$.post('get_integral',{'task_id':task_id},function(data){
					layer.open({'content':data.msg});
				},'json');
	    	}
	    }
	</script>
</html>
