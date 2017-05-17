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
<link rel="stylesheet" href="/Public/Home/css/pwd.css">

<script src="/Public/Home/js/jquery-1.9.1.min.js"></script>
	<div class="wrap">
		<div class="index new_inde<?php echo ($tpl); ?>">
			<header class="list-head new_id<?php echo ($tpl); ?>">
			  <nav class="list-nav clearfix"> <a href="javascript:history.go(-1)" class="list-back"></a>
				<h3 class="list-title">我的推广码</h3>
			  </nav>
			</header>
			<div class="content shgd<?php echo ($tpl); ?>" style="min-height:760px;">
				<div style="padding:10px 0;">
						<div class="con_sl" ><input  id='link' type="text" value="<?php echo ($userinfo["uid"]); ?>" style="color: #FFF" disabled class="st"/></div>&nbsp;&nbsp;
					<div class="con_sf"><button class="tjrz" id="cop">我的推广码</button></div>
				</div>
				 <p class="form_sfrz">
					<img alt="二维码" src="<?php echo ($code); ?>"/>
					<br/>
					<br/>
					<br/>
					<button class="tjrz2">分享二维码，推荐更多好友!</button>
                     <br/>
                     <br/>
                     <br/>
                     <img alt="二维码" src="/Public/images/dowon1.jpg"/>
                     <br/>
                     <br/>
                     <br/>
                     <button class="tjrz2">下载客户端，使用更快捷!</button>
				<p/> 
			</div>
		</div>
	</div>
<style>
.yh_all{ font-size:16px; font-weight:bold; border:none;}
.zl_table{ border-radius:5px; background:#fff; }
.zl_table tr{ height:42px; line-height:42px;}
.st{ width:98%; height:32px; line-height:32px; border:none;background:none;text-align:center;}
.tjrz{ background:none; border:none; padding:10px 5px; background:#ffb709; border-radius:5px; color:#fff; font-size:14px; }
.tjrz2{ background:none; border:none; padding:9px 35px; background:#19b2ff; border-radius:2px; color:#fff; font-size:14px; }
.form_sfrz{border-radius: 5px;
    font-size: 15px;
    padding: 20px 0 20px 20px;
    text-align: center;
    width: 100%;}
.con_sl {float:left;width:55%; height:40px; line-height:40px; margin-left:10%;  border:1px solid #d5d5d5; border-radius:3px;}
.con_sf {display:inline-block; width:30%;  height:40px; line-height:40px;}
.shgd2{background:#202020;}
.wrap .new_inde2{background:#202020; color:#dedede;min-height:800px;}
.new_id1{background:#5DDC9C;}
.new_id2{background:#111;}
.new_id3{background:#cf0000;}
</style>

<script type="text/javascript"> 
    function copy(){ 
        var content=$('#link');//对象是多行文本框contents 
        content.select(); //选择对象 
        document.execCommand("Copy"); //执行浏览器复制命令
        $('#cop').html('已复制');
    } 
</script> 
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  // 注意：所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
  // 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
  wx.config({
      debug: false,
		appId: '<?php echo ($signPackage["appId"]); ?>',
		timestamp: <?php echo ($signPackage["timestamp"]); ?>,
		nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
		signature: '<?php echo ($signPackage["signature"]); ?>',
      jsApiList: [
        'checkJsApi',
		'hideOptionMenu',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
		'onMenuShareQZone',
		'hideMenuItems'
      ]
  });
</script>

<script>
	wx.ready(function () {
		var oid = "<?php echo ($userinfo["uid"]); ?>";
		var url  = "http://<?php echo $_SERVER['SERVER_NAME'];?>/index.php/Home/User/login/pid/"+oid;
		var shareData = {
			title: '我为微盘代言!',
			desc: '共享经济！云领未来！',
			link: url,
			//imgUrl: "http://<?php echo $_SERVER['SERVER_NAME'];?>/Tpl/Apps/Index/images/fxt.png",
			success: function () { 
				
			},
		};
		wx.onMenuShareAppMessage(shareData);
		wx.onMenuShareTimeline(shareData);
		wx.onMenuShareQQ(shareData);
		wx.onMenuShareWeibo(shareData);
		wx.onMenuShareQZone(shareData);
		
		
	});
	wx.error(function (res) {
	});
</script>


 </div>     
</body>
</html>