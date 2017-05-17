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
<link rel="stylesheet" href="/Public/Home/css/history.css">
<link rel="stylesheet" href="/Public/Home/css/weipan.css"/>
<link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>
<script id="G--xyscore-load" type="text/javascript" charset="utf-8" async="" src="/Public/Home/js/xyscore_main.js"></script>

<div class="wrap">
  <div class="index new_inde<?php echo ($tpl); ?>" style="max-height:100%;">
    <header class="list-head new_id<?php echo ($tpl); ?>">
      <nav class="list-nav clearfix"> <a href="javascript:history.go(-1)" class="list-back"></a>
        <h3 class="list-title">交易明细</h3>
      </nav>
    </header>
    <div class="history-con">
		<ul class="sum clearfix sum_is<?php echo ($tpl); ?>">
			<li>
				<?php if($trading["money"] > 0): ?><em style="color:#66CC00">+<?php echo (round($trading["money"],2)); ?></em><i>总盈亏</i><?php else: ?>
					<em style="color:#66CC00"><?php echo (round($trading["money"],2)); ?></em><i>总盈亏</i><?php endif; ?>
			</li>
			<li> <em><?php echo ($trading["count"]); ?></em> <i>总单数</i> </li>
			<li> <em><?php if($trading["onumber"] == ''): ?>0<?php else: echo ($trading["onumber"]); endif; ?></em> <i>总手数</i> </li>
		</ul>
	  
    <div class="date-list clearfix ">
		<a href="<?php echo U('Detailed/dtrading',array('today'=>$trading['time'],'no'=>1));?>" class="arrow left"></a>
        <p class="date-time"><?php echo ($trading["time"]); ?>月</p>
        <a href="<?php echo U('Detailed/dtrading',array('today'=>$trading['time'],'no'=>2));?>" class="arrow right"></a>
	</div>
	<ul class="detail newid_to<?php echo ($tpl); ?>" style="max-height:100%;">
	    <li class="clearfix">
			<div class="detail-l newid_top_le<?php echo ($tpl); ?>" style="width:20%">
				<span style="font-size:1.1rem">日期</span>
			</div>
			<div class="detail-l newid_top_le<?php echo ($tpl); ?>" style="width:20%">
				<span style="font-size:1.1rem;color:#ed0000">涨</span>/<span style="font-size:1.1rem;color:#02c32f">跌</span>
			</div>
			<div class="detail-l newid_top_le<?php echo ($tpl); ?>" style="width:20%">
				<span style="font-size:1.1rem">手数</span>
			</div>
			<div class="detail-l newid_top_le<?php echo ($tpl); ?>" style="width:20%">
				<span style="font-size:1.1rem">汇率浮动</span>
			</div>
			<div class="detail-l newid_top_le<?php echo ($tpl); ?>" style="width:20%">
				<span style="font-size:1.1rem">违约金</span>
			</div>
		</li>
    </ul>
    <ul class="detail newid_to<?php echo ($tpl); ?>" style="max-height:100%;min-height:650px;">
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="clearfix">
				<div class="detail-l newid_top_le<?php echo ($tpl); ?>" style=" width: 20%;">
					<span style="font-size:1.1rem"><?php echo (date('d',$vo["selltime"])); ?></span>
				</div>
				<div class="detail-r clearfix newid_top_le<?php echo ($tpl); ?>">
					<a href="<?php echo U('Detailed/tradingid',array('oid'=>$vo['oid']));?>">
						<?php if($vo["ostyle"] == 1): ?><p  style="font-size:1.1rem" class="num drop ostyle">跌</p>
							<?php else: ?>
							<p  style="font-size:1.1rem" class="num rise ostyle">涨</p><?php endif; ?>
					 <p  style="font-size:1.1rem" class="goods-type"><?php echo ($vo["ptitle"]); ?>/<?php echo ($vo["onumber"]); ?><span>手</span></p>
					<?php if($vo['ploss'] > 0): ?><p  style="font-size:1.1rem" class="num rise ploss">+<?php echo ($vo['ploss']); ?></p>
						<?php else: ?>
						<p  style="font-size:1.1rem" class="num drop ploss"><?php echo ($vo['ploss']); ?></p><?php endif; ?>
						<p  style="font-size:1.1rem;color:#fff" class="num drop ploss"><?php echo ($vo['fee']); ?></p>
					</a>
				</div>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="newid_to<?php echo ($tpl); ?> pagelist "><?php echo ($page); ?></div>
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

<script type="text/javascript" charset="utf-8" src="/Public/Home/js/sea.js" async=""></script>
<style type="text/css">
  .pagelist{ text-align:center; background:#f1f1f1; padding:7px 0;}
.pagelist a{ margin:0 5px; border:#6185a2 solid 1px; display:inline-block; padding:2px 6px 1px; line-height:16px; background:#fff; color:#6185a2;}
.pagelist span{ margin:0 5px; border:#6185a2 solid 1px; display:inline-block; padding:2px 6px 1px; line-height:16px; color:#6185a2; color:#fff; background:#6185a2;}
</style>

 </div>     
</body>
</html>