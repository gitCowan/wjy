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
<link rel="stylesheet" href="/Public/Home/css/account.css">
<link rel="stylesheet" href="/Public/Home/css/icon_per.css">
<link rel="stylesheet" href="/Public/Home/css/weipan.css"/>
<link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>
<script id="G--xyscore-load" type="text/javascript" charset="utf-8" async="" src="/Public/Home/js/xyscore_main.js"></script>
<style>

.herd_top_1 {text-align:center;width:100%; height:80px;}
.herd_top_1 img {width:70px;height:70px;margin:20px 0 10px 0;border-radius:100%;}
.herd_top_2 {font-size:13px;color:#fff; height:30px;}
.herd_top_3 {width:80%; margin:0 10%;}
.herd_top_3 a {width:29%; float:left;}
.ico_vip {font-size:24px; line-height:40px;padding-left:8px; color:#fff;}
.ico_1 {color:#fff; font-size:20px; padding-left:9px;}
.ico_2 {color:#fff; font-size:20px; padding-left:9px;}
.ico_3 {color:#fff; font-size:26px;}
.ico_4 {color:#fff;}
.ico_5 {color:#fff;}
.herd_top1{
    background: -webkit-linear-gradient (top , #f7f4ed, #5DDC9C);
    background: -ms-linear-gradient(top, #f7f4ed, #5DDC9C);
    background: -moz-linear-gradient(top,#f7f4ed,##5DDC9C);
    background: -webkit-gradient(linear, 0% 0%, 0% 100%,from(#f7f4ed), to(#5DDC9C));
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f7f4ed), to(#5DDC9C));
    background: -webkit-linear-gradient(top,#f7f4ed, #5DDC9C);
    background: -o-linear-gradient(top, #f7f4ed, #5DDC9C);
    border-bottom: 1px solid #eee;
}
.herd_top2{
    min-width: 320px;
    max-width: 640px;
    width: 100%;
    height: 185px;
    background: #202020;
    border-bottom: 1px solid #111;
}
.herd_top3{

    background: -webkit-linear-gradient (top , #f7f4ed, #f56f6f);
    background: -ms-linear-gradient(top, #f7f4ed, #f56f6f);
    background: -moz-linear-gradient(top,#f7f4ed,##f56f6f);
    background: -webkit-gradient(linear, 0% 0%, 0% 100%,from(#f7f4ed), to(#f56f6f));
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f7f4ed), to(#f56f6f));
    background: -webkit-linear-gradient(top,#f7f4ed, #f56f6f);
    background: -o-linear-gradient(top, #f7f4ed, #f56f6f);
    border-bottom: 1px solid #eee;
}
.herd_top4{

    background: -webkit-linear-gradient (top , #f7f4ed, #f3d68a);
    background: -ms-linear-gradient(top, #f7f4ed, #f3d68a);
    background: -moz-linear-gradient(top,#f7f4ed,##f3d68a);
    background: -webkit-gradient(linear, 0% 0%, 0% 100%,from(#f7f4ed), to(#f3d68a));
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#f7f4ed), to(#f3d68a));
    background: -webkit-linear-gradient(top,#f7f4ed, #f3d68a);
    background: -o-linear-gradient(top, #f7f4ed, #f3d68a);
    border-bottom: 1px solid #eee;
}
.menb2{border-bottom:1px solid #111;}
</style>
<div class="wrap " style="overflow:auto;margin-bottom:56px;position: relative;">
    <div class="herd_top<?php echo ($tpl); ?>" style="position: fixed;top: 0;z-index: 5;">
        <div class="herd_top_1">
            <?php if($suer["portrait"] == ''): ?><img src="/Public/Home/images/pic.gif"><?php else: ?><img src="<?php echo ($suer["portrait"]); ?>"><?php endif; ?>
            <div class="herd_top_2" style="color:#f17304;font-weight:600">个人账户（元）<span class="a-d" style="margin-left:5px;"><?php echo ($result["balance"]); ?></span></div>
            <div class="herd_top_3">
                <?php if($isopen['zfopen'] == 2): ?><a href="<?php echo U('User/recharge');?>" class="acc-btn red" style="background:#28C728">充值</a>
                    <a href="<?php echo U('User/cash');?>" class="acc-btn blue">提现</a>
                    <?php else: ?>
                    <a href="javascript:;" class="acc-btn red code_tan" style="background:#28C728">充值</a>
                    <a href="javascript:;" class="acc-btn blue code_tan">提现</a><?php endif; ?>
                <a href="<?php echo U('User/logout');?>" class="acc-btn red" style="background:red">退出</a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
  <div class="index new_inde<?php echo ($tpl); ?>" style="min-height: 590px;">
  

	
	
	
    <div class="info-box clearfix menb<?php echo ($tpl); ?>" style="margin-top: 185px;">
		<div style="padding-top:9px;height:59px;line-height:59px;width:20%;float:left">
			<div style="margin-left:20px;border-radius:3px;text-align:center;width:40px;height:40px;line-height:40px;background-color:#f26d5f;">
			<i class="icon-deal ico_vip"></i>
			</div>
		</div>
		<div class="info-detail clearfix" style="width:80%;float:left"> <a href="<?php echo U('Detailed/dtrading');?>" class="acc-l">交易明细</a> </div>
    </div>
    <div class="info-box clearfix menb<?php echo ($tpl); ?>"> 
		<div style="padding-top:9px;height:59px;line-height:59px;width:20%;float:left">
			<div style="margin-left:20px;border-radius:3px;text-align:center;width:40px;height:40px;line-height:40px;background-color:#35b87f;">
				<i class="icon-reve ico_vip ico_1"></i>
			</div>
		</div>
      <div class="info-detail clearfix" style="width:80%;float:left"> <a href="<?php echo U('Detailed/drevenue');?>" class="acc-l">收支明细</a> </div>
    </div>
  <!--   <div class="info-box clearfix menb<?php echo ($tpl); ?>"> 
          <div style="padding-top:9px;height:59px;line-height:59px;width:20%;float:left">
              <div style="margin-left:20px;border-radius:3px;text-align:center;width:40px;height:40px;line-height:40px;background-color:#5b99ee;">
                  <i class="icon-quan ico_vip ico_2"></i>
              </div>
          </div>
    <div class="info-detail clearfix" style="width:80%;float:left"> <a href="<?php echo U('User/experiencelist');?>" class="acc-l">我的体验券</a> </div>
  </div> -->

	<div class="info-box clearfix menb<?php echo ($tpl); ?>"> 
		<div style="padding-top:9px;height:59px;line-height:59px;width:20%;float:left">
			<div style="margin-left:20px;border-radius:3px;text-align:center;width:40px;height:40px;line-height:40px;background-color:#D82C54;">
				<i class="icon-password ico_vip ico_4"></i>
			</div>
		</div>
      <div class="info-detail clearfix" style="width:80%;float:left"> <a href="<?php echo U('User/offline');?>" class="acc-l">我的推广码</a> </div>
    </div>

      <?php if(($suer["agenttype"] == 0) OR ($suer["agenttype"] == 1)): ?><div class="info-box clearfix menb<?php echo ($tpl); ?>">
		<div style="padding-top:9px;height:59px;line-height:59px;width:20%;float:left">
			<div style="margin-left:20px;border-radius:3px;text-align:center;width:40px;height:40px;line-height:40px;background-color:#ffa200;">	
				<i class="icon-borker ico_vip ico_3"></i>
			</div>
		</div>

        <div class="info-detail clearfix" style="width:80%;float:left"> <a href="<?php echo U('Broker/applybroker');?>" class="acc-l">申请代理商</a> </div>
    </div>
    <!--<else if condition=" ($suer.agenttype eq 2)"/>-->
        <!--&lt;!&ndash;<div class="info-detail clearfix" style="display:block;width:80%;float:left"> <a href="<?php echo U('Broker/brokerinfo');?>" class="acc-l">代理商中心</a></div>&ndash;&gt;--><?php endif; ?> 

   
    <div class="info-box clearfix menb<?php echo ($tpl); ?>"> 
		<div style="padding-top:9px;height:59px;line-height:59px;width:20%;float:left">
			<div style="margin-left:20px;border-radius:3px;text-align:center;width:40px;height:40px;line-height:40px;background-color:#C200CF;">
				<i class="icon-password ico_vip ico_5"></i>
			</div>
		</div>
      <div class="info-detail clearfix" style="width:80%;float:left"> <a href="<?php echo U('User/edituserb');?>" class="acc-l">修改登陆密码</a> </div>
    </div>
  </div>
</div>
<div style="margin-bottom:-60px;"></div>

<script src="/Public/Home/js/jquery-2.1.1.min.js"></script>
<script src="/Public/Home/js/script.js"></script>
<div class="mask" style="display:none;"></div>
<div class="tan" style="display:none;">
	<div class="tan_top">关注二维码充值和提现</div>
	<div class=""><img src="<?php echo ($isopen['code']); ?>" style="height:100%;width:100%;"/></div>
</div>
<script>
	$(".code_tan").click(function(){
		$(".mask").show();	
		$(".tan").show();	
	});
	$(".mask").click(function(){
		$(".mask").hide();	
		$(".tan").hide();	
	});
</script>



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
<!-- <script type="text/javascript" charset="utf-8" src="/Public/Home/js/sea.js" async=""></script> -->


 </div>     
</body>
</html>