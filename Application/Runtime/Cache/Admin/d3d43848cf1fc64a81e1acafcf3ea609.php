<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>微盘系统</title>
	<link rel="stylesheet" href="/Public/css/bootstrap.min.css">
	<link rel="stylesheet" href="/Public/css/bootstrap.css">
	<link rel="stylesheet" href="/Public/css/font-awesome.css">
	<link rel="stylesheet" href="/Public/css/iconfont.css">
	<link rel="stylesheet" href="/Public/css/jquery-ui.css">
	<link rel="stylesheet" href="/Public/css/base.css">
	<link rel="stylesheet" href="/Public/css/base-responsive.css">
	<link rel="stylesheet" href="/Public/css/butterbar.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="/Public/datetimepicker/css/bootstrap-datetimepicker.min.css">
	<script src="/Public/js/jquery-2.1.1.min.js"></script>
	<!-- <script src="/Public/js/jquery-1.9.1.min.js"></script> -->
	<!-- <script src="/Public/js/jquery.min-1.11.1.js"></script> -->
	<script src="/Public/Js/bootstrap.min.js"></script>
	<script src="/Public/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="/Public/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
	<style>
		.b-page {
			background:#fff;
			box-shadow:0 1px 2px 0 #e2e2e2
		}
		.b-page .page {
			width:100%;
			padding:30px 15px;
			background:#fff;
			text-align:center;
			overflow:hidden
		}
		.b-page .page .first,.b-page .page .prev,.b-page .page .current,.b-page .page .num,.b-page .page .current,.b-page .page .next,.b-page .page .end {
			padding:6px 13px;
			margin:0 3px;
			display:inline-block;
			color:#008cba;
			border:1px solid #f2f2f2;
			border-radius:2px
		}
		.b-page .page .first:hover,.b-page .page .prev:hover,.b-page .page .current:hover,.b-page .page .num:hover,.b-page .page .current:hover,.b-page .page .next:hover,.b-page .page .end:hover {
			text-decoration:none;
			background:#f8f5f5
		}
		.b-page .page .current {
			background-color:#008cba;
			color:#fff;
			border-radius:2px;
			border:1px solid #008cba
		}
		.b-page .page .current:hover {
			text-decoration:none;
			background:#008cba
		}

		.am-aaa .current{color:white;background-color:#0e90d2;padding:5px 10px 5px 10px;margin:0px 6px 0px 6px;}
		.am-aaa a{border:1px solid #dfdfdf; color:#000000;background-color:#fff;padding:5px 10px 5px 10px;margin:0px 6px 0px 6px;}
	</style>
	<script type="text/javascript">
        var wid = $(window).height();
        document.writeln('<div id="popupLayer" style="position:absolute;z-index:2;width:100%;height:'+wid+'px;left:0;top:0;opacity:0.3;filter:Alpha(opacity=30);background:#000;display: none;"></div>');
	</script>
</head>
    <body class="forIE">
        <div class="butterbar hide">
            <span class="bar"></span>
        </div>
        <main class="main">
             <menu id="menu">
	<div class="logoWrap">
		<a class="logo toIndex" href="">123123123</a>
	</div>
	<div class="innerWrap">
	 
		<dl>

			<dt>新闻</dt>
			<dd>
				<ul>
					
					<li class="" id="typelist"><a class="nativeSdk" href="<?php echo U('Admin/News/typelist');?>"><span class="glyphicon glyphicon-list"></span>栏目管理</a></li> 
					<li class="" id="newslist"><a class="mcmapi" title="" href="<?php echo U('Admin/News/newslist');?>"><span class="glyphicon glyphicon-book"></span>文章管理</a></li>
				</ul>
			</dd>
			<?php if($_SESSION['username'] == 'admin' ): ?><dt>产品管理</dt>
			<dd>
				<ul>
					<li class="" id="glist"><a class="nativeSdk" href="<?php echo U('Admin/Goods/glist');?>"><span class="glyphicon glyphicon-barcode"></span>产品列表</a></li> 
					<li class="" id="gtype"><a class="mcmapi" title="" href="<?php echo U('Admin/Goods/gtype');?>"><span class="glyphicon glyphicon-align-left"></span>分类列表</a></li>
				</ul>
			</dd><?php endif; ?>
			<dt>订单管理</dt>
			<dd>
				<ul>
					<li class="" id="olist"><a class="mcmbase" title="订单列表" href="<?php echo U('Admin/Order/olist');?>"><span class="glyphicon glyphicon-bookmark"></span>订单列表</a></li>
					<li class="" id="tlist"><a class="mcmdata" title="交易流水" href="<?php echo U('Admin/Order/tlist');?>"><span class="glyphicon glyphicon-list-alt"></span>交易流水</a></li>
					<li class="" id="yclist"><a class="mcmdatabase" title="异常订单" href="<?php echo U('Admin/Order/yclist');?>"><span class="glyphicon glyphicon-certificate"></span>异常订单</a></li>
				</ul>
			</dd>
		
			<dt>客户管理</dt>
			<dd>
				<ul>
					<li id="mlist"><a class="version" href="<?php echo U('Menber/mlist');?>" title="客户列表"><span class="glyphicon glyphicon-user"></span>客户列表</a></li>
					<li class="" id="recharge"><a class="restore" href="<?php echo U('User/recharge');?>"  title="充值和提现"><span class="glyphicon glyphicon-briefcase"></span>充值和提现</a></li>
					
					
				</ul>
			</dd>
			<?php if($_SESSION['username'] == 'admin' ): ?><dt>代理商</dt>
			<dd>
				<ul>
					<li class="" id="ulist"><a class="push" href="<?php echo U('User/ulist');?>" title="代理商"><span class="glyphicon glyphicon-credit-card"></span>代理商列表</a></li>
					<li class="" id="agentlist"><a class="push" href="<?php echo U('User/agentlist');?>" title="代理商申请"><span class="glyphicon glyphicon-credit-card"></span>代理商申请</a></li>
				</ul>
			</dd>
			 <dt>会员管理</dt>
			<dd>
				<ul>
					<li id="madd"><a class="version" href="<?php echo U('Menber/madd');?>" title="添加会员"><span></span>添加会员</a></li>
					<!--<li class="" id="mlist"><a class="restore" href="<?php echo U('Menber/mlist');?>"  title="会员列表"><span></span>会员列表</a></li>-->
				</ul>
			</dd>
			
			<dt>体验券</dt>
			<dd>
				<ul>
					<!-- <li><a class="version" href="<?php echo U('Coupons/cpadd');?>" title="添加会员"><span></span>添加体验券</a></li> -->
					<li class="" id="cplist"><a class="restore" href="<?php echo U('Coupons/cplist',array('style'=>'list'));?>"  title="会员列表"><span class="glyphicon glyphicon-usd"></span>体验券列表</a></li><!-- <li class=""><a class="restore" href="<?php echo U('Coupons/cpsend');?>"  title="发放体验券"><span></span>发放体验券</a></li> -->
					
				</ul>
			</dd>
			<dt>系统管理员</dt>
			<dd>
				<ul>
					<li id="sadd"><a class="version" href="<?php echo U('Super/sadd');?>" title="添加管理员"><span class="glyphicon glyphicon-cloud"></span>添加管理员</a></li>
					<li class="" id="slist"><a class="restore" href="<?php echo U('Super/slist');?>"  title="管理员列表"><span class="glyphicon glyphicon-th-list"></span>管理员列表</a></li>
					
				</ul>
			</dd>
			<dt>微信管理</dt>
			<dd>
				<ul>
					<li id="wxinfo"><a class="version" href="<?php echo U('Menber/wxinfo');?>" title="微信基本信息"><span class="glyphicon glyphicon-comment"></span>微信基本信息</a></li>
					
					<!-- <li class="" id="wxlist"><a class="restore" href="<?php echo U('Menber/wxlist');?>"  title="微信用户列表"><span class="glyphicon glyphicon-phone"></span>微信用户列表</a></li> -->
					 <li class="" id="diymen"><a class="restore" href="<?php echo U('Menber/diymen');?>"  title="自定义菜单"><span class="glyphicon glyphicon-th"></span>自定义菜单</a></li>
				</ul>
			</dd><?php endif; ?>
			<!--<dt>微信支付管理</dt>
			<dd>
				<ul>
					<li id="wxinfo_zhifu"><a class="version" href="<?php echo U('Menber/wxinfo_zhifu');?>" title="微信基本信息"><span class="glyphicon glyphicon-comment"></span>微信支付基本信息</a></li>
					 <li class="" id="diymen_zhifu"><a class="restore" href="<?php echo U('Menber/diymen_zhifu');?>"  title="自定义菜单"><span class="glyphicon glyphicon-th"></span>支付自定义菜单</a></li>
				</ul>
			</dd>-->

			<!-- <dt>系统设置</dt>
			<dd>
				<ul>
					<li><a class="version" href="http://www.apicloud.com/version" title="基本设置"><span></span>基本设置</a></li>
					<li class=""><a class="restore" href="http://www.apicloud.com/restore"  title="数据备份"><span></span>数据备份</a></li>
					 <li class=""><a class="restore" href="http://www.apicloud.com/restore"  title="退出系统"><span></span>退出系统</a></li>
				</ul>
			</dd> -->
		
			
		</dl>
	</div>
	
	<script>
		var a="<?php echo (ACTION_NAME); ?>";
		$('#'+a).addClass('active');
		$('#'+a+' a').css('color','#8fb300');
   </script>
</menu>
        <div style="max-width: 1348px;" class="mainWrap">
            <link rel="stylesheet" href="/Public/css/module.css">
<header id="main-header" class="header clearfix">
				<div class="submenu"><a href="<?php echo U('Index/index');?>" class="toMember">首页</a>
					<?php if($_SESSION['username'] == 'admin' ): ?><a href="<?php echo U('Super/esystem');?>" class="toMember">基本设置</a>
					<a href="<?php echo U('Super/ftype');?>" class="toMember">分销设置</a>
					<a href="<?php echo U('Super/config');?>" class="toMember">第三方登录</a>
					<a href="<?php echo U('Super/pay');?>" class="toMember">支付设置</a>
					<a href="<?php echo U('Super/sms');?>" class="toMember">短信设置</a>
					<a href="<?php echo U('Super/backupdb');?>" class="toMember">数据备份</a>
					<a href="<?php echo U('Super/slist');?>" class="toMember">管理员</a><?php endif; ?>
					<!--<a href="<?php echo U('Appstore/version');?>" class="toMember">升级</a>-->
					<a href="<?php echo U('User/signinout');?>" class="toMember">退出系统</a>
				</div>
			</header>
<div style="display: block;" class="wrapper">


<div class="panel" id="topheader">
    <header>
        <table>
            <tbody>
            <tr>
                <th style="width:30%;"><h4 style="font-size:20px;color:#8fb300">基本信息</h4></th>
				
            </tbody>
        </table>
    </header>
</div>
<div class="panel">
	<form class="form-horizontal" role="form" style="padding-top:20px;" action="<?php echo U(Menber/wxinfo);?>" method="post">
	<input type="hidden" name="wcid" value="<?php echo ($wx['wcid']); ?>"/>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">公众号名称</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="wxname" value="<?php echo ($wx['wxname']); ?>">
			</div>
		</div>
		<hr>
		 <div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">微信原始账号</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="wxlogin" value="<?php echo ($wx['wxlogin']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">URL(服务器地址)</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="wxurl" value="<?php echo ($wx['wxurl']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">Token(令牌)</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="token" value="Weiyi">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">AppID</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="appid" value="<?php echo ($wx['appid']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">AppSecret</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="appsecret" value="<?php echo ($wx['appsecret']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">EncodingAESKey</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="encodingaeskey" value="<?php echo ($wx['encodingaeskey']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">Partnerid</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="parterid" value="<?php echo ($wx['parterid']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">PartnerKey</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="parterkey" value="<?php echo ($wx['parterkey']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">分享标题</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="title" value="<?php echo ($wx['title']); ?>">
			</div>
		</div>
		<hr>
		
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">分享标题</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="pic" value="<?php echo ($wx['pic']); ?>">
			</div>
		</div>
		<hr>
		<hr>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">关注回复</label>
			<div class="col-sm-6">
			<textarea class="form-control" rows="3" name="content" ><?php echo ($wx['content']); ?></textarea>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-success"><?php if($wx['wcid'] == ''): ?>添加<?php else: ?>修改<?php endif; ?></button>
			</div>
		</div>
	</form>
   
    </div>
    
</div>
</main>
</body></html>