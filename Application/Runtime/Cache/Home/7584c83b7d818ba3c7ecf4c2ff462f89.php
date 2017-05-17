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
<link rel="stylesheet" href="/Public/Home/css/ticket.css">
<link rel="stylesheet" href="/Public/Home/css/weipan.css"/>
<link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>
<script id="G--xyscore-load" type="text/javascript" charset="utf-8" async="" src="/Public/Home/js/xyscore_main.js"></script>
<div class="wrap">
  <div class="index new_inde<?php echo ($tpl); ?>" >
    <header class="list-head new_id<?php echo ($tpl); ?>">
      <nav class="list-nav clearfix"> <a href="javascript:history.go(-1)" class="list-back"></a>
        <h3 class="list-title">收支明细</h3>
      </nav>
    </header>
    <ul class="ticket-list2 newid_to<?php echo ($tpl); ?>" style="max-height:100%">
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Detailed/revenueid',array('id'=>$vo['id']));?>" class="clearfix"> 
          <?php if($vo["jtype"] != '建仓'): ?><img src="/Public/Home/images/sz.png" class="t-icon2">
          <?php else: ?>
              <img src="/Public/Home/images/sz2.png" class="t-icon2"><?php endif; ?>
          <div class="t-left2">
              <p class="pc" style="font-size: 1.2rem;"><?php echo ($vo["jtype"]); ?>(<?php echo ($vo["remarks"]); ?> <?php echo ($vo["number"]); ?>手)</p>
              <p class="ye">余额：<?php echo ($vo["balance"]); ?></p>
          </div>
          <div class="t-right2">
             <?php if($vo["jtype"] == '建仓'): ?><p class="jg2">-<?php echo ($vo["jincome"]); ?></p>
            <?php else: ?>
              <p class="jg"><?php echo ($vo["jincome"]); ?></p><?php endif; ?>
            <p class="rq"><?php echo (date('Y-m-d H:i:s',$vo["jtime"])); ?></p>
          </div>
          <div class="clearfix"></div>
         </a>
          </li><?php endforeach; endif; else: echo "" ;endif; ?>  
    </ul>
      <div class="pagelist newid_to<?php echo ($tpl); ?>"><?php echo ($page); ?></div>
  </div>

</div>
<style type="text/css">
  .pagelist{ text-align:center; background:#f1f1f1; padding:7px 0;}
.pagelist a{ margin:0 5px; border:#6185a2 solid 1px; display:inline-block; padding:2px 6px 1px; line-height:16px; background:#fff; color:#6185a2;}
.pagelist span{ margin:0 5px; border:#6185a2 solid 1px; display:inline-block; padding:2px 6px 1px; line-height:16px; color:#6185a2; color:#fff; background:#6185a2;}
</style>
<script src="/Public/Home/js/jquery-2.1.1.min.js"></script>
<script src="/Public/Home/js/script.js"></script>
<script src="/Public/Home/js/getJuan.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Home/js/sea.js" async=""></script>
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

 </div>     
</body>
</html>