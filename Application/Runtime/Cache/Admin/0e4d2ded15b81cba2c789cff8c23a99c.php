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

<div class="panel" id="topheader">
    <header>
        <table>
            <tbody>
            <tr>
                <th style="width:30%;"><h4 style="font-size:20px;color:#8fb300">产品编辑管理</h4></th>
				
            </tr>
            </tbody>
        </table>
    </header>
</div>
<div class="panel">
	<form class="form-horizontal" action="" method="post" role="form" style="padding-top:20px;">
	<input type="hidden" name="pid" value="<?php echo ($editgood['pid']); ?>"/>
		<div class="form-group">
			<label for="" class="col-sm-3 control-label" style="padding-right:20px;">商品名称</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="ptitle" value="<?php echo ($editgood['ptitle']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label" style="padding-right:20px;">单位</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="company" value="<?php echo ($editgood['company']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label" style="padding-right:20px;">所属分类</label>
			<div class="col-sm-6">
				<select class="form-control" name="cid">
					<?php if(is_array($pclist)): $i = 0; $__LIST__ = $pclist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pl): $mod = ($i % 2 );++$i;?><option  value="<?php echo ($pl['cid']); ?>" <?php if($pl['cid'] == $editgood['cid']): ?>selected=""<?php endif; ?>><?php echo ($pl['cname']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label" style="padding-right:20px;">价格</label>
			<div class="col-sm-6">
				<div class="input-group">
				  <input class="form-control" name="uprice" type="text" value="<?php echo ($editgood['uprice']); ?>">
				  <div class="input-group-addon">手/元</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label" style="padding-right:20px;">总手数</label>
			<div class="col-sm-6">
				<div class="input-group">
				  <input class="form-control" name="num" type="text" placeholder="" value="<?php echo ($editgood['num']); ?>" >
				  <div class="input-group-addon">手</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label" style="padding-right:20px;">手续费</label>
			<div class="col-sm-6">
				<div class="input-group">
				  <input class="form-control" type="text" placeholder="" value="<?php echo ($editgood['feeprice']); ?>" name="feeprice">
				  <div class="input-group-addon">手/元</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label" style="padding-right:20px;">浮动盈亏</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" value="<?php echo ($editgood['wave']); ?>" name="wave">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label" style="padding-right:20px;">外盘价格</label>
			<div class="col-sm-6">
			<em  style="margin-top:6px;font-size:1.5rem;font-weight:400;" <?php if($editgood["cid"] == 1): ?>id="you"<?php elseif($editgood["cid"] == 2): ?>id="baiyin"<?php elseif($editgood["cid"] == 3): ?>id="tong"<?php else: endif; ?> class=""></em>
			</div>
		</div>
		<hr>
		<!-- <div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">点差x</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="patx" value="<?php echo ($editgood['patx']); ?>">
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label">点差-</label>
			<div class="col-sm-6">
			<input type="text" class="form-control" id="" placeholder="" name="patj" value="<?php echo ($editgood['patj']); ?>">
			</div>
		</div>
		<hr> -->
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-success">提 交</button>
			</div>
		</div>
	</form>
  
	<span style="" class="moreUpAndDown"></span>
</div>
</main>
<script type="text/javascript">
	//butt();
	//setInterval('butt()', 2000);
	function butt(){
		//获取油的价格到页面
		$.ajax({  
			type: "post",  
			url: "<?php echo U('Goods/price');?>",         
			success: function(data) { 
				var yprice = $('#you').text();
				//最新油价
				$('#you').html(data[0]);
				if(data[0]<yprice){
					$('#you').attr("class","drop  glyphicon glyphicon-arrow-up yss");
				}else if(data[0]==yprice){}else{
					$('#you').attr("class","rise glyphicon glyphicon-arrow-down ys");
				}              
			},  
		}); 
		//获取白银的价格到页面  
		$.ajax({  
			type: "post",  
			url: "<?php echo U('Goods/byprice');?>",         
			success: function(data) {
				var byprice = $('#baiyin').text();
				//最新白银价
				$('#baiyin').html(data[0]); 
				if(data[0]<byprice){
					$('#baiyin').attr("class","drop  glyphicon glyphicon-arrow-up yss");
				}else if(data[0]==byprice){}else{
					$('#baiyin').attr("class","rise glyphicon glyphicon-arrow-down ys");
				}                
			},  
		});
		//获取铜的价格到页面  
		$.ajax({  
			type: "post",  
			url: "<?php echo U('Goods/toprice');?>",         
			success: function(data) {
				var toprice = $('#tong').text();
				//最新白银价
				$('#tong').html(data[0]);
				if(data[0]<toprice){
					$('#tong').attr("class","drop  glyphicon glyphicon-arrow-up yss");
				}else if(data[0]==toprice){}else{
					$('#tong').attr("class","rise glyphicon glyphicon-arrow-down ys");
				}   
			},  
		});
	}
</script>
</body></html>