<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>跳转提示</title>
	<link rel="stylesheet" href="/Public/css/bootstrap.min.css">
	<link rel="stylesheet" href="/Public/css/base.css">
	<script src="/Public/js/jquery-2.1.1.min.js"></script>
	<script src="/Public/Js/bootstrap.min.js"></script> 
		<style>
.aud {width:100%; text-align:center; margin-top:100px;}
.auds{width:70%; margin:0 auto; text-align:center; margin-bottom:20px;}
.auds img { width:100px; height:100px;}
.aud p {font-size:18px; color:#f17304;}
</style>
</head>
<body>

 <body class="forIE" style="background:#fff;">
        
			<div class="aud">
				<?php if(isset($message)): ?><div class="auds"><img src="/Public/images/aud.png"/></div>
					<p><?php echo($message); ?></p>
				<?php else: ?>
					<div class="auds"><img src="/Public/images/error.png"/></div>
					<p><?php echo($error); ?></p><?php endif; ?>
			</div>
							
							<div class="col-md-12" style="margin-top:10px;height:30px;line-height:30px;text-align:center;color:#999;font-size:14px;font-weight:300"><div style="width:90%;">温馨提示：</div>
							</div>
							<div class="col-md-12" style="height:30px;line-height:30px;color:#999;font-size:14px;font-weight:300;text-align:center;"><div style="width:90%;">页面自动 跳转 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>秒</div>
							</div>
							<div class="col-md-12" style="text-align:center;height:65px;line-height:65px;color:#999;font-size:2rem;font-weight:600">
							<div style="text-align:center;width:60%;display:none;">
							<a href="<?php echo($jumpUrl); ?>" id="href" type="button" class="btn btn-success" style="width:40%;">加速跳转<a>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>           
        </div>   
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>