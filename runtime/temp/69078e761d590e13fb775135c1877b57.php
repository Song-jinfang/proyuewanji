<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:44:"./template/mobile/rainbow/user/earnings.html";i:1566439575;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<title></title>
		<link rel="stylesheet" href="/static/css/earnings.css" />
	</head>
	<body>
	<div class="header">
	    <a id="[back]" <?php  if(request()->action() == 'earnings'){  ?>  href="<?php echo U('User/index'); ?>" <?php  }else{  ?> href="[href]" <?php  }  ?> ><img src="/static/img/back.png" class="back" ></a>详情
	</div>
		<div class="tab">
			<a href="###" class="curr">
				<p>267<font>(元)</font></p>
			    <p>商品返现</p>
			</a>
			<span></span>
			<a href="###">
				<p>267<font>(元)</font></p>
			    <p>任务收益</p>
			</a>
			<span></span>
			<a href="###">
				<p>267<font>(元)</font></p>
			    <p>豆豆交易收益</p>
			</a>
		</div>
		<div class="list">
		<?php if(is_array($orderList) || $orderList instanceof \think\Collection || $orderList instanceof \think\Paginator): $i = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
			<div class="orderLists">
				<p class="orderTitle">①订单号：<?php echo $v['order_sn']; ?> <font>订单日期<?php echo $v['add_time']; ?></font></p>
				<div class="form">
					<div class="dayBox">
						<div class="div">
							<font>第1天</font>
							<span class="btn btnGreen"><?php echo $v['add_time']; ?></span>
						</div>
						<div class="div">
							<font>第7天</font>
							<?php if($v['seven_status'] == 1): ?>
								<span class="btn btnBlack">领取</span>
							<?php else: ?>
								<span class="btn btnGray"><?php echo $v['seven_days']; ?></span>
							<?php endif; ?>
						</div>
						<div class="div">
							<font>第14天</font>
							<?php if($v['fourteen_days'] == 1): ?>
								<span class="btn btnBlack">领取</span>
							<?php else: ?>
								<span class="btn btnGray"><?php echo $v['fourteen_days']; ?></span>
							<?php endif; ?>
						</div>
						<div class="div">
							<font>第21天</font>
							<?php if($v['twenty_one_days'] == 1): ?>
								<span class="btn btnBlack">领取</span>
							<?php else: ?>
								<span class="btn btnGray"><?php echo $v['twenty_one_days']; ?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="scoreDiv">
						<p class="scoreTitle">做任务送积分</p>
						<div class="dayBox1">
							<div class="div1">
								<font>第14天</font>
								<span class="btn1">已赚13个积分</span>
							</div>
							<div class="div1">
								<font></font>
							    <span class="btn btnGreen">去做任务</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>

			
		</div>
		<div class="text">
			<p>释:商品返现规则：从下单日期开始，第七天可返商品消费价格的50% 第14天可返20%第21天可通过任务返余下的20%</p>
			<p>做任务送积分是送您当前订单金额的1%，积分可当现金抵用卷使用 规则：订单生成那天起 1—28天 当日做了任务才有当日积分 积分是累计到第28天12个小时以内才能提用</p>
		</div>
	</body>
</html>
