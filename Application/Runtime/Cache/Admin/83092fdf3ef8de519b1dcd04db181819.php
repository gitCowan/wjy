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
				<th style="width:30%;"><h4 style="font-size:20px;color:#8fb300">客户列表</h4></th>
				<th style="width:60%;" class="col-md-12">
				
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

    <div class="row" style="margin:0;">
        <div class="col-md-12">
            <div class="panel">
                <div class="col-md-12" style="padding-top:15px;box-shadow:0px 2px 4px #ccc;margin-bottom:20px;background-color:#fff;">
                    <form class="form-horizontal" id="myForm" role="form" action="<?php echo U('Menber/mlist');?>" method="get">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">手机号码： </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="按手机号码" name="utel" id="utel" value="<?php echo ($param["utel"]); ?>">
                            </div>
                        </div>
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label">代理ID： </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="代理ID" name="vid" id="vid" value="<?php echo ($param["vid"]); ?>">
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">用户名称： </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="按用户名称" name="username" id="username" value="<?php echo ($param["username"]); ?>">
                            </div>
                        </div>
                    </div>

                        <div class="col-sm-3">
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">排序条件：</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="con">
                                    <option value="">默认不选</option>
                                    <option value="2" <?php if($param['con'] == 2): ?>selected=""<?php endif; ?>>按余额倒叙</option>
                                    <option value="1" <?php if($param['con'] == 1): ?>selected=""<?php endif; ?>>按余额正序</option>
                                    <option value="4" <?php if($param['con'] == 4): ?>selected=""<?php endif; ?>>按时间倒叙</option>
                                    <option value="3" <?php if($param['con'] == 3): ?>selected=""<?php endif; ?>>按时间正序</option>
                                </select>
                            </div>
                        </div>
                        </div>
                    <div class="col-sm-3" >
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-success" value=" 搜 索">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">平台总余额：</label>
                            <div class="col-sm-7">
                                <span style="font-size: 2em;color: red;">　￥<?php echo ($yue); ?></span>
                            </div>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

<div class="panel">
    
    <div id="detailsTable" style="">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>编号</th>
                    <th>客户名</th>
                    <th>手机号码</th>
                    
                    <th>微信头像</th>
                    <th>创建日期</th>
					<th>上级</th>
					<th>订单数量</th>
					<th>账户余额</th>
                    <th>总盈亏</th>
					<th>会员类别</th>
					<th>交易流水</th>
					<th>操作</th>
                </tr>
            </thead>
           <tbody>
		    <?php if(is_array($ulist)): $i = 0; $__LIST__ = $ulist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ult): $mod = ($i % 2 );++$i;?><tr>
				<td><?php echo ($ult['uid']); ?></td>
				<td>
					<a href="<?php echo U('Menber/mupdate',array('uid'=>$ult['uid']));?>"><?php echo ($ult['username']); ?></a>
				</td>
				<td><?php echo ($ult['utel']); ?></td>
				<td><img src="<?php echo ($ult['portrait']); ?>" width="30px" height="30px" /></td>
			
				<td><?php echo ($ult['utime']); ?></td>
				<td><?php echo ($ult["managername"]); ?></td>
				<td>
					<?php if($ult['ocount'] == 0): ?>0
					<?php else: ?>
						<a href=""><?php echo ($ult['ocount']); ?></a><?php endif; ?>
				</td>
				<td><font color="#f00" size="3">￥<?php echo ($ult['balance']); ?><font></td>
                <td>
                    <?php if($ult["yingkui"] >= 0): ?><font color="#ed0000" size="3"><?php echo ($ult["yingkui"]); ?></font>
                        <?php else: ?>
                        <font color="#2fb44e" size="3"><?php echo ($ult["yingkui"]); ?></font><?php endif; ?>
                </td>
				<td>
					<?php if($ult["otype"] == 0): ?>客户<?php endif; ?>
					<?php if($ult["otype"] == 1): ?>代理商<?php endif; ?>
					<?php if($ult["otype"] == 2): ?>会员单位<?php endif; ?>
					<?php if($ult["otype"] == 3): ?>超级管理员<?php endif; ?>
				</td>
				<td><a href="<?php echo U('Menber/muplook',array('uid'=>$ult['uid']));?>"><i class="table-edit"></i>查看</a></td>
				<td>
					<ul class="actions">
						<li><a href="<?php echo U('Menber/mupdate',array('uid'=>$ult['uid']));?>"><i class="table-edit"></i>编辑</a></li>
                        <?php if($_SESSION['username'] == 'admin' ): ?><li class="last"><a href="<?php echo U('User/userdel',array('uid'=>$ult['uid']));?>" onclick="if(confirm('确定要删除吗?客户账户请谨慎操作！')){return true;}else{return false;}">删除</a></li><?php endif; ?>
					</ul>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
        </table>
       
    </div>
    <span style="" class="moreUpAndDown"><?php echo ($page); ?></span>
</div>
<script type="text/javascript">
    function getDataByTemplate() {  return {"totalUsersCount":0,"activeUsersCountRatioBySeven":0,"activeUsersCountBySeven":0,"activeUsersCountRatioByThirty":0,"activeUsersCountByThirty":0,"avgOnceUseTim6eBySeven":0,"avgOnceUseTimeByDay":0,"avgOnceUseTimeBySeven":0,"xdate":["10-16","10-17","10-18","10-19","10-20","10-21","10-22"],"newUser":[0,0,0,0,0,0,0],"activeUser":[0,0,0,0,0,0,0],"activeUserRatio":[0,0,0,0,0,0,0],"startupCount":[0,0,0,0,0,0,0],"avgUseTime":[0,0,0,0,0,0,0],"totalUser":[0,0,0,0,0,0,0],"details":[{"date":"10-22","newUserCount":0,"totalUserCount":0,"activeUserCount":0,"activeUserCountRatio":"0%","startupCount":0,"userTime":"00:00:00"},{"date":"10-21","newUserCount":0,"totalUserCount":0,"activeUserCount":0,"activeUserCountRatio":"0%","startupCount":0,"userTime":"00:00:00"},{"date":"10-20","newUserCount":0,"totalUserCount":0,"activeUserCount":0,"activeUserCountRatio":"0%","startupCount":0,"userTime":"00:00:00"},{"date":"10-19","newUserCount":0,"totalUserCount":0,"activeUserCount":0,"activeUserCountRatio":"0%","startupCount":0,"userTime":"00:00:00"},{"date":"10-18","newUserCount":0,"totalUserCount":0,"activeUserCount":0,"activeUserCountRatio":"0%","startupCount":0,"userTime":"00:00:00"},{"date":"10-17","newUserCount":0,"totalUserCount":0,"activeUserCount":0,"activeUserCountRatio":"0%","startupCount":0,"userTime":"00:00:00"},{"date":"10-16","newUserCount":0,"totalUserCount":0,"activeUserCount":0,"activeUserCountRatio":"0%","startupCount":0,"userTime":"00:00:00"}],"pagetotal":1}};
</script>
</div>
            
        </div>
        </main>
        <footer class="clearfix">
            <div id="menu-shadow"></div>
            <a href="http://www.apicloud.com/" class="logo toIndex">APICloud</a>
            <div class="contact">
                <!-- <a href="" data-i18n="contact.help"></a><a href="" data-i18n="contact.about"></a><a href="" data-i18n="contact.team"></a><a href="" data-i18n="contact.contact"></a> -->
                <a id="toAbout" href="http://www.apicloud.com/about">关于我们</a>
                <!-- <a href="javascript:void(0)">联系</a> -->
                <!-- <a href="/newsReports">Blog</a> -->
               <!--  <select name="" id="langSelect">
                    <option value="zh-CN">中文简体</option>
                    <option value="en-US">English</option>
                </select> -->
                        
            </div>
        </footer>
        <div id="loading">
            <div class="loadInner">
                <p>
                    正在加载中...
                </p>
            </div>
        </div>
        <!-- service3rd start-->
        <div class="mask"></div>
        <div class="service-pop">
            <div class="title">
                <span id="version"></span>
                <span>使用第三方的服务</span>
                <a id="closeBtn" class="closeBtn" href="javascript:;"></a>
            </div>
            <div class="list-service">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <!-- <tr><td class="no-info">未使用任何第三方服务</td></tr> -->
                    <!-- <tr>
                        <td width="130px;">
                            <span class="three-party testin"></span>
                        </td>
                        <td width="20px"><span class="line"></span></td>
                        <td id="testIn">
                        <span style="margin-right:20px;">测试机型：196</span>
                        <span>通过率：91.33%</span>
                        </td>
                        <td class="t-right">
                            <a class="detail" href="" target="_blank">查看详情</a>
                        </td>
                    </tr>
                    <tr>
                        <td width="130px;">
                            <span class="three-party bangcle"></span>
                        </td>
                        <td width="20px"><span class="line"></span></td>
                        <td>加固中...</td>
                        <td class="t-right">
                        </td>
                    </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="upgradEentedPOp">
            <div class="modal-dialog">
                <div class="modal-content border-r">
                    <div class="modal-body">
                        <span type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></span>
                        <h3 class="title"></h3>
                        <div class="modal-cont">
                            <div class="pic"></div>
                            <p class="price-box">￥<span class="price">99</span>
                            <span class="on-trail">（试用）</span></p>
                            <ul class="type-box">
                                <li class="active" data-price="99" data-type="1"><span>1</span>个月</li>
                                <li data-price="1800" data-type="2"><span>6</span>个月</li>
                                <li data-price="2400" data-type="3"><span>12</span>个月</li>
                            </ul>
                            <button type="button" class="btn btn-warning">立即升级</button>
                            <p class="info-box"><a href="http://www.apicloud.com/vipservice/enterpEdition">查看详情</a> <span>或</span> <a href="http://wpa.b.qq.com/cgi/wpa.php?ln=1&amp;key=XzgwMDE0ODc4M18zNzQyNDdfODAwMTQ4NzgzXzJf" target="_blank">咨询客服</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade pay-pop" id="entedPayPOp">
            <div class="modal-dialog">
                <div class="modal-content border-r">
                    <div class="modal-body">
                        <span type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></span>
                        <div class="pay-cont">
                            <div class="left">
                                <h3>企业版</h3>
                                <div class="pay-type">
                                    <span class="time-limit"><span class="num">6</span>个月</span>
                                    <div class="type-info">
                                        <span class="now">￥<span class="price">10000</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="right">
                                <div class="pay-box qrcode-pay">
                                    <div class="col-md-6">
                                        <span class="weixin"></span>
                                        <p><b>微信</b>扫描购买</p>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="taobao"></span>
                                        <p><b>支付宝</b>扫描购买</p>
                                    </div>
                                </div>
                                <div class="success-way pay-success">
                                        <div class="pic">
                                            <img src="images/success.png">
                                        </div>
                                        <p>支付成功<br>
                                            <span>客服会尽快与您联系</span>
                                        </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="authentication_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header clearfix">
                        <h4 class="pull-left">APICloud实名认证</h4>
                    </div>
                    <div class="modal-body">
                        <form id="authentication_form">
                            <div class="form-group clearfix">
                                <div class="col-md-3">
                                    <label class="label">真实姓名：</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="auth_idcard_name" name="auth_idcard_name" class="form-control" placeholder="您的身份证姓名" type="text">
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-md-3">
                                    <label class="label">身份证号：</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="auth_idcard_num" name="auth_idcard_num" class="form-control" placeholder="您的中国大陆18位有效身份证号" type="text">
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-md-3">
                                    <label class="label">银行卡号：</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="auth_bankcard" name="auth_bankcard" class="form-control" placeholder="您名下任意一张银行卡卡号" type="text">
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="form-group clearfix btn-row">
                                <input class="btn btn-blue" value="提交" type="submit">
                                <input class="btn btn-cancel" value="取消" data-dismiss="modal" aria-label="Close" type="button">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="stage_confirm_modal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">阶段确认</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                            
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-confirm">阶段性确认</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="new_stage_confirm_modal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">阶段确认</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                该阶段还有未完成任务，阶段确认操作将会自动确认所有未完成任务
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-confirm">阶段性确认</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="stage_code_modal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title">阶段确认</h4>
                    </div>
                    <div class="modal-body">
                        <form id="stage_code_form" class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-md-8">
                                    <input id="stage_code_ccap" name="stage_code_ccap" class="form-control" placeholder="请输入右侧答案" type="text">
                                </div>
                                <div class="col-md-4">
                                    <img class="ccap-img" src="" alt="">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-8">
                                    <input id="stage_code_code" name="stage_code_code" class="form-control" placeholder="请输入手机验证码" type="text">
                                </div>
                                <div class="col-md-4">
                                    <span class="code-phone-btn btn-blue btn">
                                        <span class="code_phone_count"></span>
                                        <span class="codeText">获取验证码</span>
                                    </span>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <button type="submit" class="btn btn-primary btn-confirm">确认本阶段完成</button>
                                <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">取消</button>
                            </div>
                            <div class="row clearfix">
                                <a href="http://www.apicloud.com/profile" target="_blank" class="pull-right modal-go-link">更换预留手机号</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="image-browser" id="fake_image_browser">
            <div class="btn-close" title="关闭"></div>
            <div class="info-box">
                <h5 class="image-name">
                </h5>
                <p class="image-info">
                </p>
                <div class="btn-container">
                    <div class="btn-box">
                        <a href="javascript:void(0)" target="_blank" class="btn-download">
                            <i class="cus-icon-download"></i>
                            下载 
                        </a>
                    </div>
                    <div class="btn-box">
                        <span class="btn-delete">
                            <i class="cus-icon-delete"></i>
                            删除                            
                        </span>
                    </div>
                </div>
            </div>
            <div class="image-container">
                
            </div>
        </div>
        <!-- service3rd end-->
        <!--[if lt IE 10]>
        <link rel="stylesheet" href="/css/ie.css">
        <![endif]-->
        <!--[if lt IE 8]>
        <link rel="stylesheet" href="/fonts/font-awesome/css/font-awesome-ie7.min.css">
        <link rel="stylesheet" href="/css/glyphicons-ie7.css">
        <link rel="stylesheet" href="/css/ie7.css">
        <![endif]-->
        
        <script src="js/sea.js"></script>
        <script>
            function getJsName(){
                return "";
            }
        </script>
        
    
<div id="mobileForm_modal" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">
<span aria-hidden="true">×</span>
<span class="sr-only">Close</span>
</button>
<p class="modal-title">为了加强您的账户安全，请绑定手机后再创建！</p>
</div>
<div class="modal-body">
<form novalidate="novalidate" action="" id="mobileForm" class="clearfix">
<div class="form-group forCodePhone">
<span class="region-btn">
<i class="btn-flag china"></i>
<ul style="display: none;" id="region-list">
<li data-region="china" data-code="86" class="region-item china">中国</li>
<li data-region="usa" data-code="1" class="region-item usa">美国</li>
<li data-region="hongkong" data-code="852" class="region-item hongkong">香港</li>
<li data-region="taiwan" data-code="886" class="region-item taiwan">台湾</li>
<li data-region="japan" data-code="81" class="region-item japan">日本</li>
<li data-region="australia" data-code="61" class="region-item australia">澳大利亚</li>
<li data-region="singapore" data-code="65" class="region-item singapore">新加坡</li>
<li data-region="s-korea" data-code="82" class="region-item s-korea">韩国</li>
<li data-region="malaysia" data-code="60" class="region-item malaysia">马来西亚</li>
<li data-region="canada" data-code="1" class="region-item canada">加拿大</li>
</ul>
</span>
<span class="region-add">+</span>
<input class="region-code" name="region-code" value="86" placeholder="国家码" readonly="readonly" maxlength="4" autocomplete="off" type="text">
<input class="form-control" id="codePhoneNum" name="codePhoneNum" placeholder="请输入手机号码" type="text">
</div>
<div class="form-group clearfix">
<div class="form-left">
<input class="form-control" id="ccap-text" name="ccap" placeholder="验证码" type="text">
</div>
<div class="form-right"><img class="ccap"></div>
<div class="err-popover-out">
<div class="err-popover">
<div class="tri-right"></div>
<div class="tri-right-in"></div>
<div class="err-popover-content"></div>
</div>
</div>
</div>
<div class="form-group clearfix code-phone" style="margin-bottom: 30px;">
<div class="form-left">
<div class="form-group code-text">
<input class="form-control" id="codePhoneText" name="codePhoneText" placeholder="请输入手机验证码" type="text">
</div>
</div>
<div class="form-right">
<button class="code-phone-btn btn-blue btn">
<span id="code_phone_count">40</span>
<span id="codeText" class="codeText">获取验证码</span>
</button>
</div>
</div>
<button type="submit" class="btn btn-blue ensure">绑定并创建</button>
</form>
</div>
</div>
</div>
</div>

    <div style="width: 1583px; height: 910px;" class="box" id="box">
      <ul style="position: absolute; left: 541.5px; top: 337.5px;" class="con">
        <li class="titlel">
             <span>详细信息</span>
             <span class="closel">X</span>
        </li>
        <li class="gai"></li>
     </ul>
    </div>
        <script type="text/javascript">

            $('#search_begin').click(function(){
                //获取文本框值
                var utel = $("#utel").val(),
                username = $("#username").val();
                var vid = $("#vid").val();
                window.location.href="mlist?utel="+utel+"&username="+username+"&vid="+vid;
            })


        </script>
</body></html>