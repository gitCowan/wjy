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
				 <th style="width:40%;"><h4 style="font-size:20px;color:#8fb300">交易流水</h4></th>
				<th style="width:60%;" class="col-md-12">
				<!-- <div class="col-md-8">
				
					<div class="form-group" style="margin-bottom:0;text-align:right;">
						<div class="input-group">
						  <input class="form-control" type="text" placeholder="请输入商品名称">
						  <div class="input-group-addon">搜索</div>
						</div>
					</div>
				
				</div> -->
				<div class="col-md-12">
					<!-- <button type="button" class="btn btn-success" style="margin-left:15px;float:right">添加客户</button> -->
					<!-- <button type="button" class="btn btn-warning" style="float:right">提现记录</button> -->
				</div>
				
				</th>
            </tr>
            </tbody>
        </table>
    </header>
</div>






<div class="panel">
    
    <div id="detailsTable" style="">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>编号</th>
                    <th>用户</th>
                    <th>类型</th>
                    <th>操作时间</th>
                    <th>产品信息</th>
                    <th>数量(手)</th>
                    <th>方向</th>
					<th>金额</th>
					<th>手续费</th>
					<th>买价</th>
					<th>卖价</th>
					<th>账户余额</th>
					<th>出入金</th>
					<th>盈亏</th>
					<th>操作</th>
                </tr>
            </thead>
           <tbody id="ajaxback">
		   <?php if(is_array($tlist)): $i = 0; $__LIST__ = $tlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tl): $mod = ($i % 2 );++$i;?><tr>
			<td>
	            <?php echo ($tl["jno"]); ?>
				</td>
				<td>
					<a href="<?php echo U('User/updateuser',array('uid'=>$tl['uid']));?>" class="name"><?php echo ($tl["jusername"]); ?></a>
				</td>
				<td><?php echo ($tl["jtype"]); ?></td>
				<td><?php echo (date('Y-m-d H:i:s',$tl["jtime"])); ?></td>
				<td>
					<?php if($tl["jtype"] == "提现"): ?>0
					<?php elseif($tl["jtype"] == "充值"): ?>
						0
					<?php else: ?>
						<?php echo ($tl["remarks"]); endif; ?>
				</td>
				<td>
					<?php if($tl["jtype"] == "提现"): ?>0
					<?php elseif($tl["jtype"] == "充值"): ?>
						0
					<?php else: ?>
						<?php if($tl["jtype"] != "返点"): echo ($tl["number"]); ?>手
						<?php else: ?>
							无<?php endif; endif; ?>
				</td>
				<td>
					<?php if($tl["jtype"] == "提现"): ?>0
					<?php elseif($tl["jtype"] == "充值"): ?>
						0
					<?php else: ?>
						<?php if($tl["jostyle"] == 1): ?><font color="#2fb44e">买跌</font>
							<?php else: ?>
							<font color="#ed0000">买涨</font><?php endif; endif; ?>
				</td>
				<td>
					<?php if($tl["jtype"] == "提现"): echo ($tl["juprice"]); ?>
					<?php elseif($tl["jtype"] == "充值"): ?>
						<?php echo ($tl["juprice"]); ?>
					<?php else: ?>
						<?php echo ($tl['number']*$tl['juprice']); endif; ?>
				</td>
				<td>
					<?php if($tl["jtype"] == "提现"): ?>0
					<?php elseif($tl["jtype"] == "充值"): ?>
						0
					<?php else: ?>
						<?php echo ($tl["jfee"]); endif; ?>
				</td>
				<td>
					<?php if($tl["jtype"] == "提现"): ?>0
					<?php elseif($tl["jtype"] == "充值"): ?>
						0
					<?php else: ?>
						<font color="#ed0000" size="3"><?php echo ($tl["jbuyprice"]); ?></font><?php endif; ?>
				</td>
				<td>
					<?php if($tl["jtype"] == "提现"): ?>0
					<?php elseif($tl["jtype"] == "充值"): ?>
						0
					<?php else: ?>
						<?php if($tl["jtype"] != "建仓"): if($tl["jbuyprice"] < $tl["jsellprice"]): ?><font color="#ed0000" size="3"><?php echo ($tl["jsellprice"]); ?></font>
							<?php else: ?>
								<font color="#2fb44e" size="3"><?php echo ($tl["jsellprice"]); ?></font><?php endif; ?>
						<?php else: ?>
							<font color="#ed0000" size="3">0.00</font><?php endif; endif; ?>
					
				</td>
				<td><font color="#f00" size="3"><?php echo ($tl["balance"]); ?></font></td>
				<td>
					<?php if($tl["jtype"] == "提现"): ?><font color="#2fb44e" size="3">-<?php echo ($tl["juprice"]); ?></font>
					<?php elseif($tl["jtype"] == "充值"): ?>
						<font color="#2fb44e" size="3">-<?php echo ($tl["juprice"]); ?></font>
					<?php else: ?>
						<?php if($tl["jtype"] != "返点"): if($tl["jaccess"] >= 0): ?><font color="#ed0000" size="3">+<?php echo ($tl["jaccess"]); ?></font>
							<?php else: ?>
								<font color="#2fb44e" size="3"><?php echo ($tl["jaccess"]); ?></font><?php endif; ?>
						<?php else: ?>
							<font color="#ed0000" size="3">0.00</font><?php endif; endif; ?>
				</td>
				<td>
					<?php if($tl["jtype"] == "提现"): ?>0
					<?php elseif($tl["jtype"] == "充值"): ?>
						0
					<?php else: ?>
						<?php if($tl["jtype"] != "返点"): if($tl["jploss"] >= 0): ?><font color="#ed0000" size="3"><?php echo ($tl["jploss"]); ?></font>
								<?php else: ?>
								<font color="#2fb44e" size="3"><?php echo ($tl["jploss"]); ?></font><?php endif; ?>
						<?php else: ?>
							<font color="#ed0000" size="3">0.00</font><?php endif; endif; ?>
				</td>
				<td>
					<?php if($tl["jtype"] == "提现"): ?>等待审核
					<?php elseif($tl["jtype"] == "充值"): ?>
						等待审核
					<?php elseif($tl["jtype"] == "返点"): ?>
						<?php echo ($tl["explain"]); ?>
					<?php else: ?>
						<a href="<?php echo U('Order/ocontent',array('oid'=>$tl['oid']));?>">查看</a><?php endif; ?>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
        </table>
       
    </div>
    <span style="" class="moreUpAndDown"><?php echo ($page); ?></span>
</div>
</main>
<script type="text/javascript">
	
	//搜索结果，ajax返回搜索框搜索结果
	$('#search_begin').click(function(){
		//获取文本框值
		var orderno = $("#orderno").val(),
			username = $("#username").val(),
			buytime = $("#buytime").val(),
		    ostyle = $("#ostyle  option:selected").val(),
			ploss = $("#ploss  option:selected").val(),
			ostaus = $("#ostaus option:selected").val();
			
		//alert(orderno+username+buytime+ostyle+ploss+ostaus);
		$.ajax({
			type: "post",
			url: "<?php echo U('Menber/olist',array('step'=>'search','uid'=>$_GET['uid']));?>",
			data:{"orderno":orderno,"username":username,"buytime":buytime,"ostyle":ostyle,"ploss":ploss,"ostaus":ostaus},
			success: function(data){
				//console.log(data);
				if(data=="null"){
	            	//$("#loading").hide();
	            	$("#ajaxback").html('<tr class="first"><td colspan="14">没有找到结果，请重新输入！请检查输入的格式是否正确！</tr></td>');
	            }else{
	            	//$("#loading").hide();
	            	$olist = "";
		            $.each(data,function(no,items){
		            	console.log(items);
		            	$olist += '<tr class="first">';
		            	$olist += '<td>'+items.orderno+'</td>';
		            	$olist += '<td><a href="<?php echo U('User/updateuser');?>?uid='+items.uid+'">'+items.username+'</a></td><td>';
		            	if(items.ostaus==1){
		            		$olist += '<span class="label label-info">平仓</span>';
		            	}else{
		            		$olist += '<span class="label">建仓</span>';
		            	}
		            	$olist += '</td><td>'+items.buytime+'</td>';
		            	$olist += '<td><a href="<?php echo U('Goods/gedit');?>?pid='+items.pid+'">'+items.ptitle+'</a></td>';
		            	$olist += '<td>'+items.onumber+'手</td>';
		            	
		            	$olist += '<td>';
		            	if(items.ostyle==1){
		            		$olist += '<span class="label label-success">买涨</span>';
		            	}else{
		            		$olist += '<span class="label label-cc">买跌</span>';
		            	}
		            	$olist += '</td>';
		            	$olist += '<td><font color="#f00" size="3">'+items.uprice+'</font></td>';
		            	$olist += '<td><font color="#f00" size="3">'+items.fee+'</font></td>';
		            	$olist += '<td><font color="#f00" size="3">'+items.buyprice+'</font></td>';
		            	$olist += '<td>';
		            	if(items.ostaus==1){
		            		$olist += '<font color="#f00" size="3">'+items.sellprice+'</font>';
		            	}else{
		            		$olist += '<span class="label">建仓中</span>';
		            	}
		            	$olist += '</td>';
		            	if(items.commission==""){
		            		$olist += '<td><font color="#f00" size="3">0.00</font></td>';
		            	}else{
		            		$olist += '<td><font color="#f00" size="3">'+items.commission+'</font></td>';	
		            	}
		            	$olist += '<td><font color="#f00" size="3">'+items.jaccess+'</font></td>';
		            	$olist += '<td>';
		            	if(items.ostaus==1){
		            		$olist += '<font color="#f00" size="4">'+items.ploss+'</font>';
		            	}else{
		            		$olist += '<span class="label">建仓中</span>';
		            	}
		            	$olist += '</td>';
		            	$olist += '<td><a href="<?php echo U('Order/ocontent');?>?oid='+items.oid+'">查看</a></td>';
		            	$olist += '</tr>';
		            })
		            $("#ajaxback").html($olist);
	            }
			},
			error: function(data){
				console.log(data);
			}
		});
	})
	
	
	
	
	$('#top_search').keyup(top_serch);
	$('#sxsearch').click(top_serch);
	function top_serch(){
		//获取点击参数
		var urlkey = $(this).attr("urlkey");
		//获取文本框值
		var keywords = $("#top_search").val(),
		    sxkey = $("#sxkey  option:selected").val(),
			formula = $("#formula  option:selected").val(),
			sxvalue = $("#sxvalue").val();
		//重新定义提交url
		var newurl = "";
		if(urlkey == "search"){
			newurl = "<?php echo U('Order/olist?step=search');?>"
		}
		if(urlkey == "sxsearch"){
			newurl = "<?php echo U('Order/olist?step=sxsearch');?>"
		}
		$.ajax({
        type: "post",  
        url: newurl,    
        data:{"keywords":keywords,"sxkey":sxkey,"formula":formula,"sxvalue":sxvalue},
//      beforeSend:function(XMLHttpRequest){ 
//            //alert('远程调用开始...'); 
//            $("#loading").show(); 
//      },
        success: function(data) {
        	//$("#ajaxback").html(data);
            if(data=="null"){
            	//$("#loading").hide();
            	$("#ajaxback").html('<tr class="first"><td colspan="13">没有找到结果，请重新输入！请检查输入的格式是否正确！</tr></td>');
            }else{
            	//$("#loading").hide();
            	$olist = "";
	            $.each(data,function(no,items){
	            	$olist += '<tr class="first">';
	            	$olist += '<td>'+items.oid+'</td>';
	            	$olist += '<td><a href="<?php echo U('User/updateuser');?>?uid='+items.uid+'">'+items.username+'</a></td>';
	            	$olist += '<td>'+items.buytime+'</td>';
	            	$olist += '<td><a href="<?php echo U('Goods/gedit');?>?pid='+items.pid+'">'+items.ptitle+'</a></td>';
	            	$olist += '<td>'+items.onumber+'手</td><td>';
	            	if(items.ostaus==1){
	            		$olist += '<span class="label label-info">平仓</span>';
	            	}else{
	            		$olist += '<span class="label">建仓</span>';
	            	}
	            	$olist += '</td><td>';
	            	if(items.ostyle==1){
	            		$olist += '<span class="label label-success">买涨</span>';
	            	}else{
	            		$olist += '<span class="label label-cc">买跌</span>';
	            	}
	            	$olist += '</td>';
	            	$olist += '<td><font color="#f00" size="3">￥'+items.buyprice+'<font></td>';
	            	$olist += '<td>';
	            	if(items.ostaus==1){
	            		$olist += '<font color="#f00" size="3">￥'+items.sellprice+'<font>';
	            	}else{
	            		$olist += '建仓中';
	            	}
	            	$olist += '</td><td>';
	            	if(items.ostaus==1){
	            		$olist += '<font color="#f00" size="3">￥'+items.commission+'<font>';
	            	}else{
	            		$olist += '建仓中';
	            	}
	            	$olist += '</td>';
	            	$olist += '<td><font color="#f00" size="3">￥'+items.fee+'<font></td>';
	            	$olist += '<td>';
	            	if(items.ostaus==1){
	            		$olist += '<font color="#f00" size="4">￥'+items.ploss+'<font>';
	            	}else{
	            		$olist += '建仓中';
	            	}
	            	$olist += '</td>';
	            	$olist += '<td><a href="<?php echo U('Order/ocontent');?>?oid='+items.oid+'">查看</a></td>';
	            	$olist += '</tr>';
	            })
	            $("#ajaxback").html($olist);
            }
            
            //console.log(data);
        },  
        error: function(data) {  
            console.log(data);
        }
      }); 
	}
	
$("#sxkey").bind("change",function(){
	var sxkey = $(this).val();
	switch(sxkey){
		case "orderno":
			$("#sxvalue").attr("placeholder","格式：不允许汉字");
			break;
		case "username":
			$("#sxvalue").attr("placeholder","格式：雁过留痕");
			break;
		case "buytime":
			$("#sxvalue").attr("placeholder","格式：1970-10-01");
			break;
		case "ostyle":
			$("#sxvalue").attr("placeholder","格式：买涨/买跌");
			break;
		case "ploss":
			$("#sxvalue").attr("placeholder","格式：数字格式");
			break;
		case "ostaus":
			$("#sxvalue").attr("placeholder","格式：建仓/平仓");
			break;
		default:
			$("#sxvalue").text("输入内容");
	}
	
})
</script>
</body></html>