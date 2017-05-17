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
                <th><h4 style="font-size:20px;color:#8fb300">数据汇总</h4>
                </th>

            </tr>
            </tbody>
        </table>
    </header>
</div>
<div class="row" style="margin-left:0;margin-right:0;">
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading panel-border phb">
                <div class="pull-left">
                    访问量
                </div>
                <div class="pull-right">
                    【今日】
                </div>
            </div>
            <div class="panel-body" style="position: relative;">
                <div _echarts_instance_="1477119964607" style="width:100%;height:240px;" id="dbpie"><div style="position: relative; overflow: hidden; width: 270px; height: 240px;"><div data-zr-dom-id="bg" height="240" width="270" style="position: absolute; left: 0px; top: 0px; width: 270px; height: 240px;"></div><canvas data-zr-dom-id="_zrender_hover_" height="240" width="270" style="position: absolute; left: 0px; top: 0px; width: 270px; height: 240px;"></canvas></div></div>
                <div class="inChart">
                    <span style="vertical-align: text-bottom; display: inline-block;"></span>
                    <div>200</div>
                    <span>人</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading panel-border phb">
                <div class="pull-left">
                    用户
                </div>
                <div class="pull-right">
                   【截至今天】
                </div>
            </div>
            <div class="panel-body" style="position: relative;">
                <div _echarts_instance_="1477119964608" style="width:100%;height:240px;" id="fspie"><div style="position: relative; overflow: hidden; width: 270px; height: 240px;"><div data-zr-dom-id="bg" height="240" width="270" style="position: absolute; left: 0px; top: 0px; width: 270px; height: 240px;"></div><canvas data-zr-dom-id="_zrender_hover_" height="240" width="270" style="position: absolute; left: 0px; top: 0px; width: 270px; height: 240px;"></canvas></div></div>
                <div class="inChart two">
                    <span style="vertical-align: text-bottom; display: inline-block;"></span>
                    <div><?php echo ($userCount); ?></div>
                    <span>个</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading panel-border phb">
                <div class="pull-left">
                    订单
                </div>
                 <div class="pull-right">
                    【最近七天】
                </div>
            </div>
            <div class="panel-body" style="position: relative;">
                <div _echarts_instance_="1477119964609" style="width:100%;height:240px;" id="dtpie"><div style="position: relative; overflow: hidden; width: 270px; height: 240px;"><div data-zr-dom-id="bg" height="240" width="270" style="position: absolute; left: 0px; top: 0px; width: 270px; height: 240px;"></div><canvas data-zr-dom-id="_zrender_hover_" height="240" width="270" style="position: absolute; left: 0px; top: 0px; width: 270px; height: 240px;"></canvas></div></div>
                <div class="inChart three">
                    <span style="vertical-align: text-bottom; display: inline-block;"></span>
                    <div><?php echo ($orderCount); ?></div>
                    <span>个</span>
                </div>
            </div>
        </div>
    </div>    
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading panel-border phb">
                <div class="pull-left">
                    交易总额
                </div>
                 <div class="pull-right">
                   【最近三十天】
                </div>
            </div>
             <div class="panel-body" style="position: relative;">
                <div _echarts_instance_="1477119964609" style="width:100%;height:240px;" id="dtpie"><div style="position: relative; overflow: hidden; width: 270px; height: 240px;"><div data-zr-dom-id="bg" height="240" width="270" style="position: absolute; left: 0px; top: 0px; width: 270px; height: 240px;"></div><canvas data-zr-dom-id="_zrender_hover_" height="240" width="270" style="position: absolute; left: 0px; top: 0px; width: 270px; height: 240px;"></canvas></div></div>
                <div class="inChart three" style="color:#87c45c">
                    <span style="vertical-align: text-bottom; display: inline-block;"></span>
                    <div><?php echo ($total); ?></div>
                    <span>元</span>
                </div>
            </div>
        </div>
    </div>      
</div>


	<div class="panel">
		<div class="panel-heading">
			<h4 style="font-size:20px;color:#8fb300">最近交易记录</h4>
		</div>
		<div class="panel-body">
			<div id="detailsTable" style="">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>用户</th>
						<th>订单编号</th>
						<th>下单时间</th>
						<th>产品信息</th>
						<th>数量</th>
						<th>类型</th>
						<th>订单状态</th>
						<th>手续费</th>
						<th>订单总额</th>
					</tr>
				</thead>
			   <tbody>
			   <?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>  
				<td style="color:#999;text-decoration:none;"><a href="<?php echo U('User/updateuser',array('uid'=>$vo['uid']));?>" ><?php echo ($vo["username"]); ?></a></td>  
				<td style="color:#999;text-decoration:none;"><?php echo ($vo["orderno"]); ?></td>    
				<td style="color:#999;text-decoration:none;"> <?php echo (date('Y-m-d',$vo["buytime"])); ?></td>    
				<td style="color:#999;text-decoration:none;"><a href="<?php echo U('Goods/gedit',array('pid'=>$vo['pid']));?>"><?php echo ($vo["ptitle"]); ?></a></td>    
				<td style="color:#999;text-decoration:none;"><?php echo ($vo["onumber"]); ?>手</td>    
				<td style="color:#999;text-decoration:none;"><?php if($vo["ostyle"] == 1): ?><span>买跌</span>
                            	<?php else: ?>
								<span>买涨</span><?php endif; ?></td>
				<td style="color:#999;text-decoration:none;"><?php if($vo["ostaus"] == 1): ?><span>平仓</span>
                            	<?php else: ?>
								<span>建仓</span><?php endif; ?></td>  
				<td style="color:#999;text-decoration:none;">￥<?php echo ($vo['fee']); ?></td>  				
				<td style="color:#999;text-decoration:none;">￥<?php echo ($vo['uprice']*$vo['onumber']); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			<div style="text-align:center">
				<div id="Pagination"></div>
			</div>
		</div>
		</div>
	</div>

    <?php if($_SESSION['username'] == 'admin' ): ?><div class="panel">
		<div class="panel-heading">
			<h4 style="font-size:20px;color:#8fb300">产品列表</h4>
		</div>
		<div class="panel-body">
			<div id="detailsTable" style="">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th style="text-align:center;">产品名称</th>
						<th style="text-align:center;">单价</th>
						<th style="text-align:center;">手续费</th>
						<th style="text-align:center;">操作</th>
					</tr>
				</thead>
			   <tbody>
			   <?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pl): $mod = ($i % 2 );++$i;?><tr>    
				<td style="text-align:center;color:#999;text-decoration:none;"><?php echo ($pl['ptitle']); ?></td>   
				<td style="text-align:center;color:#999;text-decoration:none;">￥<?php echo ($pl['uprice']); ?></td>    
				<td style="text-align:center;color:#999;text-decoration:none;"><?php echo ($pl['feeprice']); ?></td>    
				<td style="text-align:center;"><a href="<?php echo U('Goods/gedit',array('pid'=>$pl['pid']));?>" type="button" class="btn btn-primary">编 辑</a> <a href="<?php echo U('Goods/gdel',array('pid'=>$pl['pid']));?>" onclick="if(confirm('确定要删除吗?')){return true;}else{return false;}" type="button" class="btn btn-danger">删 除</a></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			<div style="text-align:center">
				<div id="Pagination"></div>
			</div>
		</div>
		</div>
	</div><?php endif; ?>
</div>
</div>
</main>

</body>
</html>