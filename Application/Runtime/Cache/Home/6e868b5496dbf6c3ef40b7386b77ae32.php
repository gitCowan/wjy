<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<title><?php echo C('WebName');?></title>
<!-- <style>
.ycdcdDiv ul li{border-bottom:1px solid #fff;}
</style> -->
</head>
<body style="max-width:640px;margin-left:auto;margin-right:auto;background:#202020;">

<div class="main"> 	
       
<link rel="stylesheet" href="/Public/Home/css/global.css">
<link rel="stylesheet" href="/Public/Home/css/index.css">
<link rel="stylesheet" href="/Public/Home/css/weipan.css"/>
<link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>
<link rel="stylesheet" href="/Public/Home/css/trainfo.css"/>
<script id="G--xyscore-load" type="text/javascript" charset="utf-8" async="" src="/Public/Home/js/xyscore_main.js"></script>
<style>
.tarn2 {border-bottom:1px solid #111;}
.new_inde2 p {background:#111; color:#dedede;}
.trs2 {color:#999;}
</style>
<div class="wrap">
  <div class="index new_inde<?php echo ($tpl); ?>" style="min-height: 750px; height: 750px; ">
    <header class="list-head new_id<?php echo ($tpl); ?>">
      <nav class="list-nav clearfix"> <a href="javascript:history.go(-1)" class="list-back"></a>
        <h3 class="list-title">订单详情</h3>
      </nav>
    </header>
    <div class="news-list2 clearfix bf<?php echo ($tpl); ?>" style="color:#999;">
		<div class="trainfo trs<?php echo ($tpl); ?>">
			<div class="trainfo_top<?php echo ($tpl); ?> ">
				<p>订单详情</p>
				<div class="trainfo_cen tarn<?php echo ($tpl); ?>">
					<dl>
						<dt>订单号：</dt>
						<dd><?php echo ($order["orderno"]); ?></dd>
					</dl>
					<dl>
						<dt>产品：</dt>
						<dd><?php echo ($order["ptitle"]); ?></dd>
					</dl>
					<dl>
						<dt>建仓时间：</dt>
						<dd><?php echo (date('Y-m-d H:i:s',$order["buytime"])); ?></dd>
					</dl>
					
				</div>		
				<div class="trainfo_cen tarn<?php echo ($tpl); ?>">
					<div class="trainfo_cen_left">
						<dl>
							<dt class="trainfo_cen_1">方向：</dt>
							<dd class="trainfo_cen_2" style="font-size:18px;">
								<?php if($order["ostyle"] == 1): ?><span class="l_l2">跌</span>
									<?php else: ?>
									<span class="l_l" style="color: #ed0000;">涨</span><?php endif; ?>
							</dd>				
						</dl>
						<dl>
							<dt class="trainfo_cen_1">入仓数量：</dt>
							<dd class="trainfo_cen_2"><?php echo ($order["onumber"]); ?> </dd>
						</dl>	
						<dl>
							<dt class="trainfo_cen_1">违约金：</dt>
							<dd class="trainfo_cen_2" style="color:#cf0000; font-size:20px !important;"><?php echo ($order["fee"]); ?></dd>
						</dl>	
						<dl>
							<dt class="trainfo_cen_1">止盈：</dt>
							<dd class="trainfo_cen_2"><?php if($order['endprofit'] == 1){echo '不设';}else{echo $order['endprofit'].'%';}?></dd>
						</dl>
						
					</div>
					<div class="trainfo_cen_right">
						<dl>
							<dt class="trainfo_cen_1">建仓金额：</dt>
							<dd class="trainfo_cen_2" id="youjia" style="padding:0;"><?php echo ($order['jc']); ?></dd>	
						</dl>
						<dl>
							<dt class="trainfo_cen_1">入仓价格：</dt>
							<dd class="trainfo_cen_2" style="color:#1EBB30"><?php echo ($order['buyprice']); ?></dd>	
						</dl>				
						<dl>
							<dt class="trainfo_cen_1">平仓价格：</dt>
							<dd class="trainfo_cen_2" style="color:#FF7C80"><?php echo ($order["sellprice"]); ?></dd>
						</dl>
						<dl>
							<dt class="trainfo_cen_1">止损：</dt>
							<dd class="trainfo_cen_2"><?php echo ($order["endloss"]); ?>%&nbsp;&nbsp;</dd>
						</dl>
					</div>			
				</div>
				<div class="trainfo_cen tarn<?php echo ($tpl); ?>" style="border:none;">
					<dl>
						<dt>平仓时间：</dt>
						<dd><?php echo (date('Y-m-d H:i:s',$order["selltime"])); ?></dd>
					</dl>
					<dl>
						<dt>汇率浮动：</dt>
						<dd><?php echo (round($order['ykzj'],2)); ?></dd>
					</dl>
					<dl>
						<dt>本单盈余：</dt>
						<dd><?php echo (round($order['bdyy'],2)); ?>(<?php echo (round($order['bfb'],2)); ?>%)</dd>
					</dl>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<style>
.foot1{background:#fff; border-top:1px solid #f1f1f1;}
.foot2{background:#202020; border-top:1px solid #111;}
.foot1 {background:#fff;}
.foot2 {background:#202020;}
.foot3 {background:#fff;}
.foot4 {background:#fff;}
.foot3{background:#fff; border-top:1px solid #f1f1f1;}
.foot4{background:#fff; border-top:1px solid #f1f1f1;}
.max_foot1{background:#fff;}
.max_foot2{background:#202020;}
.max_foot3{background:#fff;}
.max_foot4{background:#fff;}
.ico_foot {width:100%;height:33px;line-height:40px; font-size:25px;}
.fmng1{color:#999 !important;}
.fmng2{color:#fff !important;}
.fmng3{color:#cf0000 !important;}
.fmng4{color:#999;}
.ico_dais3{background:#cf0000;color:#fff;}

</style>
<footer style="max-width:640px;margin:0 auto;" class="max_foot2">
	<div style="height:58px;"></div>
	<div style="max-width:640px;position:fixed;bottom:0;z-index:5;width:100%;height:58px;line-height:58px;" class="foot2">
		<ul>
			<a href="/" style="text-decoration:none;">
			<li style="width:25%;text-align:center;float:left" class="ico_dai2 fmng2">
				<div  class="ico_foot ">
					<i class="icon-home" style="font-size:22px;"></i>
				</div>
				<div style="width:100%;height:25px;line-height:25px;">
					首 页
				</div>
			</li>
			</a>
			<a href="<?php echo U('Home/Index/dtrading');?>" style="text-decoration:none;">
			<li style="width:25%;text-align:center;float:left" class="ico_dai2 fmng2">
				<div  class="ico_foot ">
					<i class="icon-pay"></i>
				</div>
				<div style="width:100%;height:25px;line-height:25px;">
					交 易
				</div>
			</li>
			</a>
			<a href="<?php echo U('Home/News/newslist');?>" style="text-decoration:none;">
			<li style="width:25%;text-align:center;float:left" class="ico_dai2  fmng2">
				<div  class="ico_foot">
					<i class="icon-acunt"></i>
				</div>
				<div style="width:100%;height:25px;line-height:25px;">
					公 告
				</div>
			</li>
			</a>
			<a href="<?php echo U('Home/User/memberinfo');?>" style="text-decoration:none;">
				<li style="width:25%;text-align:center;float:left" class="ico_dai2 fmng2">
					<div  class="ico_foot ">
						<i class="icon-vip"></i>
					</div>
					<div style="width:100%;height:25px;line-height:25px;">
						会 员
					</div>
				</li>
			</a>
			
		</ul>
	</div>
	 
</footer>
<script src="/Public/Home/js/jquery-2.1.1.min.js"></script>
<script src="/Public/Home/js/script.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Home/js/sea.js" async=""></script>

 </div>     
</body>
</html>