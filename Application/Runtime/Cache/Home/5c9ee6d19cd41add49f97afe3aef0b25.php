<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<title>登录</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta name="wap-font-scale" content="no">
	<link rel="stylesheet" href="/Public/Home/css/xin_login/style.css">
	<link rel="stylesheet" href="/Public/Home/css/xin_login/common.css">
	<link rel="stylesheet" type="text/css" href="/Public/Home/css/login1.css" media="all" />
	<link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>
</head>
<body class="page-mobile ">
<div class="wrapper login-wrapper">
	<!-- logo S -->
	<div class="wx-logo">
	</div>
	<!-- logo E -->
	<!-- 登录输入表单 S -->
	<form id="singin" method="post" action="<?php echo U('User/login');?>" onsubmit="return check_data();">
		<div class="login-form def-m mb10">
			<ul class="com-columns span2">
				<li class="comc-item">
					<div class="com-formbox">
						<label class="formbox-hd" for="username"><i class="iconfont icon-user"></i>&nbsp;</label>
						<span class="formbox-bd"><input  type="tel" id="username" name="username"  onkeyup="this.value=this.value.replace(/ /g,'')" maxlength="11" class="input-txt" placeholder="请输入手机号" /></span>
					</div>
				</li>
				<li class="comc-item">
					<div class="com-formbox">
						<label class="formbox-hd" for="password"><i class="iconfont icon-lock"></i>&nbsp;</label>
						<span class="formbox-bd"><input  type="password" id="password" name="password" onkeyup="this.value=this.value.replace(/ /g,'')" maxlength="16" class="input-txt" placeholder="请输入密码" /></span>
					</div>
				</li>
			</ul>
		</div>
		<!-- 登录输入表单 E -->
		<!-- 通用按钮 S -->
		<div class="def-p com-btnbox mb10">
			<button id="btn_Login"  type="submit" class="btn-blue">登 录</button>
		</div>
	</form>
	<!-- 通用按钮 E -->

	<!-- 忘记密码 S -->
	<div class="def-p txtr">
		<a href="<?php echo U('forget_passwd');?>" class="fz13" id="findPwd_btn" style="color: #4490CE;">忘记密码？</a>
	</div>
	<!-- 忘记密码 E -->

	<!-- 底部的注册按钮 S -->
	<div class="login-btm">
		<a href="<?php echo U('reg');?>"  class="btn" id="register_btn" style="border: 1px solid #4490CE !important; color: #4490CE !important;">没有帐号？请注册</a>
	</div>
	<!-- 底部的注册按钮 E -->
</div>
<!-- 登录主要内容 E -->
</div>
<script type='text/javascript'>var ROOT = "";</script>
<script src="/Public/Home/js/new_login/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/Public/Home/js/new_login/common.js"></script>
<script type="text/javascript" src="/Public/Home/js/new_login/login.js"></script>
<div class="loading-wrapper" style="display: none;">
	<div class="loading-area">
		<div id="floatingBarsG1" class="floatingBarsG"></div>
		<p id="msg">登录中...</p>
	</div>
	<div class="mask" style="opacity: 0.3;"></div>
</div>
</body>
</html>