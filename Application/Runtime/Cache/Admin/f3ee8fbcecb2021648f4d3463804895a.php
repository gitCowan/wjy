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
<style>
.shtc{width: 300px;position: absolute; opacity: 1; background: rgb(255, 255, 255);border-radius: 5px;display:none;z-index:3;right: 0;}
.closesh{position: absolute;top: 10px;right: 10px;display: block;width: 40px;padding: 2px 0;text-align: center;background: #fff;border: 1px solid #85B6E2;color: #333;    border-radius: 5px;}
.shtcu{padding: 10px 20px 20px 20px;margin: 0;}
.shtcu li{list-style:none;line-height: 30px;font-size: 14px;}
.shtcu li.lastli{text-align:right;}
.shtcu li.sqs{margin-right: 5px;}
.shtcu li label{display: inline;}
.shtitle{width: 100%;height: 45px;background: #f7f7f7;border-radius: 5px;}
.shtcu li.sqs input{margin: 0;margin-left: 5px;}
#ajaxback td a{cursor:pointer;}
.tpsearch{float:left;width:30%;}
</style>
<div style="display: block;" class="wrapper">

<div class="panel" id="topheader">
    <header>
        <table>
            <tbody>
            <tr>
				<th style="width:40%;"><h4 style="font-size:20px;color:#8fb300">充值提现管理</h4></th>
				<th style="width:60%;" class="col-md-12">
				
				<!--<div class="col-md-12">-->
					<!--<a href="<?php echo U('User/recharge',array('bptype'=>1));?>"><button type="button" class="btn btn-success" style="margin-left:15px;float:right">充值记录</button></a>-->
					<!--<a href="<?php echo U('User/recharge',array('bptype'=>2));?>"><button type="button" class="btn btn-warning" style="float:right">提现记录</button></a>-->
				<!--</div>-->
				
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
					<form class="form-horizontal" role="form" action="<?php echo U('User/recharge');?>" method="get" >
						<div class="col-sm-3">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">用户ID: </label>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="按用户ID" name="uid" id="uid" value='<?php echo ($request_list["uid"]); ?>'>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
                                <label for="" class="col-sm-4 control-label">记录类型</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="bptype" id="bptype">
                                        <option value="">默认不选</option>
                                        <option
										<?php if($request_list['bptype'] == '充值'): ?>selected=""<?php endif; ?>
												value="1">充值</option>
                                        <option
										<?php if($request_list['bptype'] == '提现'): ?>selected=""<?php endif; ?>
												value="2">提现</option>
                                    </select>
                                </div>
                            </div>
						</div>
						<div class="col-sm-3" >
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<!--<a  href="javascript:void(0)"  id="search_begin" style="width:80%;" type="button" class="btn btn-success">-->
										<!--<span class="glyphicon glyphicon-search"></span> 搜 索-->
									<!--</a>-->
									<input type="submit" class="btn btn-success" value="搜 索">
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
					<th>客户ID</th>
                    <th>客户名称</th>
                    <th>操作时间</th>
                    <th>处理时间</th>
                    <th>金额</th>
                    <th>充值/提现</th>
                    <th>账户余额</th>
                    <th>总充值</th>
                    <th>总提现</th>
                    <th>状态</th>
                </tr>
            </thead>
           <tbody>
		   <?php if(is_array($rechargelist)): $i = 0; $__LIST__ = $rechargelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$relist): $mod = ($i % 2 );++$i;?><tr>
			<td> <?php echo ($relist["bpid"]); ?></td>
			<td> <?php echo ($relist["uid"]); ?></td>
			<td><a href="<?php echo U('User/updateuser',array('uid'=>$relist['uid']));?>"><?php echo ($relist["username"]); ?></a></td> 
			<td><?php echo (date('Y-m-d H:i:s',$relist["bptime"])); ?></td> 
			<td><?php if($relist["cltime"] == '' ): ?>暂未处理
                        <?php else: ?>
                        <?php echo (date('Y-m-d H:i:s',$relist["cltime"])); endif; ?></td>  
			<td><font color="#f00" size="4"><?php echo ($relist["bpprice"]); ?></font>元</td>  
			<td><?php echo ($relist["bptype"]); ?></td> 
			<td><font color="#f00" size="4"><?php echo ($relist['balance']); ?></font>元</td>
                <td><font color="#f00" size="4">
                    <?php if($relist['chongzhi'] ==""){ echo 0; }else{ echo $relist['chongzhi']; } ?>
                    </font>元</td>
                <td><font color="#f00" size="4">
                    <?php if($relist['tixian'] ==""){ echo 0; }else{ echo $relist['tixian']; } ?>
                </font>元</td>
                <td>
				<?php if($relist["bptype"] == '提现'): if($relist["isverified"] == 0): ?><a class="elecl" id="elecl<?php echo ($relist["bpid"]); ?>" bpid="<?php echo ($relist["bpid"]); ?>">处理/拒绝</a>
							<?php elseif($relist["isverified"] == 1): ?>
							已通过
							<?php else: ?>
							拒绝申请<?php endif; ?>
                    </td>
                    <?php else: ?>
					    <?php echo ($relist["remarks"]); endif; ?>
			</td>
			</tr>
				<div class="shtc" id="elesh<?php echo ($relist["bpid"]); ?>">
					<div class="shtitle"><a class="closesh" id="closesh<?php echo ($relist["bpid"]); ?>" href="javascript:void(0)" >关闭</a></div>
					<ul class="shtcu">
					    <input type="hidden" id="userid_<?php echo ($relist["bpid"]); ?>" value="<?php echo ($relist['uid']); ?>">
						<li><label>申请用户：</label><a href="<?php echo U('User/updateuser',array('uid'=>$relist['uid']));?>"><?php echo ($relist["username"]); ?></a></li>
						<li><label>申请金额：</label>
						<font color="#f00" size="4" class="rebpprce_<?php echo ($relist["bpid"]); ?>"><?php echo ($relist["bpprice"]); ?></font>元</li>
						<li class="sqs"><label>申请操作：</label><input type="radio" name="isverified" value="1" checked="checked">同意<input type="radio" name="isverified" value="0">拒绝</li>
						<li><label>理由：</label><textarea id="remarks<?php echo ($relist["bpid"]); ?>"></textarea></li>
						<li class="lastli"><a class="btn-flat success shtj" bpid="<?php echo ($relist["bpid"]); ?>">提交</a></li>
					</ul>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
        </table>
       
    </div>
    <span style="" class="moreUpAndDown"><?php echo ($page); ?></span>
</div>
</div>
            
        </div>
        </main>
        <footer class="clearfix">
            <div id="menu-shadow"></div>
            <a href="javascript:;" class="logo toIndex">APICloud</a>
            <div class="contact">
                <a id="toAbout" href="javascript:;">关于我们</a>
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

<script>
	$(".elecl").click(function(){
		var bpid = $(this).attr("bpid");
		$('#popupLayer').css('display','block');
		$('#elesh'+bpid).animate({
			right: '45%', top: 200 ,opacity: 'toggle'
		},600);
	})
	$('.closesh').click(function(){
		$('#popupLayer').css('display','none');
		$('.shtc').css('display','none');
	})
	$(".shtj").click(function(){
		var bpid = $(this).attr("bpid");
		var rebpprce=$('.rebpprce_'+bpid).html();	
		
		var userid=$('#userid_'+bpid).val();
		var isverified = $('#elesh'+bpid+' input[name="isverified"]:checked ').val();
		var remarks = $("#remarks"+bpid).val();
		$.ajax({  
		    type: "post",  
		    url: "<?php echo U('User/upbalance');?>",
        	data:{"bpid":bpid,"isverified":isverified,"remarks":remarks,"rebpprce":rebpprce,"userid":userid},
        	success: function(data) {
        		if(data=="success"){
        			$('#popupLayer').css('display','none');
					$('.shtc').css('display','none');
        			alert('处理成功！');
        			window.location.reload();
        		}else{
        			alert('处理失败!');
        		}
        	},
        	error: function(data) {  
	            console.log(data);
	        }
      });
	})
</script>
		<script type="text/javascript">

//			$('#search_begin').click(function(){
//				//获取文本框值
//				var uid = $("#uid").val();
//				if(uid){
//					window.location.href="<?php echo U('User/recharge');?>?uid="+uid+"&step=sxsearch";
//				}else{
//					window.location.href="<?php echo U('User/recharge');?>";
//				}
//
//			})


		</script>
</body></html>