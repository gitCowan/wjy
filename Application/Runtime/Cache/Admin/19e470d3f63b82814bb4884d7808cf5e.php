<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
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
                <th style="width:40%;"><h4 style="font-size:20px;color:#8fb300">订单列表管理</h4></th>
				<th style="width:60%;" class="col-md-12">
				
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
                    <form class="form-horizontal" id="myForm" role="form" action="<?php echo U('Admin/Order/olist');?>" method="get" >

                    <div class="col-sm-3">
						<div class="form-group">
							<label for="" class="col-sm-4 control-label">订单编号</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" placeholder="按订单编号" name="orderno" id="orderno" value="<?php echo ($param['orderno']); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-4 control-label">订单类型</label>
							<div class="col-sm-8">
								<select class="form-control" name="ostyle" id="ostyle">
									<option value="">默认不选</option>
									<option
                                            <?php if($param['ostyle'] == 1): ?>selected<?php endif; ?>
                                            value="1">买涨</option>
									<option
                                    <?php if($param['ostyle'] == 2): ?>selected<?php endif; ?>
                                            value="2">买跌</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label for="" class="col-sm-4 control-label">用户名称</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" placeholder="按用户名称" name="username" id="username" value="<?php echo ($param['username']); ?>">
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label for="" class="col-sm-4 control-label">交易时间</label>
							<div class="col-sm-8">
								<div class="input-group">
									<input type="text" class="form-control form_date"  name="buytime" id="buytime" value="<?php echo ($param['buytime']); ?>">
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						
						<script type="text/javascript">
							$(".form_date").datetimepicker({
								format: 'yyyy-mm-dd hh:ii',
								language: 'zh-CN',					
							
							});
						</script>
					</div>
					<div class="col-sm-3" style="height:80px;line-height:80px;">
						<div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit"  class="btn btn-success" value="开始查找">
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
					<th>用户ID</th>
                    <th>用户名称</th>
                    <th>订单时间</th>
                    <th>产品信息</th>
                    <th>数量</th>
                    <th>状态</th>
                    <th>类型</th>
					<th>买价</th>
					<th>卖价</th>
					<th>账户余额</th>
					<th>手续费</th>
					<th>盈亏</th>
					<th>止盈比</th>
					<th>止损比</th>
					<?php if($_SESSION['username'] == 'admin' ): ?><th>操作</th><?php endif; ?>
                </tr>
            </thead>
			
			<tbody id="ajaxback">
			<?php if(is_array($orders)): $i = 0; $__LIST__ = $orders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="first <?php if($vo["ostaus"] == 0): ?>create<?php else: endif; ?>">
				<td> <?php echo ($vo["orderno"]); ?></td>
				<td> <?php echo ($vo["uid"]); ?></td>
				<td><a href="<?php echo U('User/updateuser',array('uid'=>$vo['uid']));?>"><?php echo ($vo["username"]); ?></a></td> 
				<td>
					<?php if($vo["ostaus"] == 1): echo (date('Y-m-d H:i:s',$vo["selltime"])); ?>
					<?php else: ?>
						<?php echo (date('Y-m-d H:i:s',$vo["buytime"])); endif; ?>
				</td> 
				<td><a href="<?php echo U('Goods/gedit',array('pid'=>$vo['pid']));?>"><?php echo ($vo["ptitle"]); ?></a></td>  
				<td><?php echo ($vo["onumber"]); ?>手</td>  
				<td>
					<?php if($vo["ostaus"] == 1): ?>平仓
					<?php else: ?>
						建仓<?php endif; ?>
				</td> 
				<td>
					<?php if($vo["ostyle"] == 1): ?><font color="#2fb44e">买跌</font>
					<?php else: ?>
						<font color="#ed0000">买涨</font><?php endif; ?>
				</td> 
				<td><font color="#f00" size="2"><?php echo ($vo["buyprice"]); ?></font></td>
				<td class="sellprice">
					<?php if($vo["ostaus"] == 1): if($vo["buyprice"] > $vo["sellprice"]): ?><font color="#ed0000" size="2"><?php echo ($vo["sellprice"]); ?></font>
						<?php else: ?>
							<font color="#2fb44e" size="2"><?php echo ($vo["sellprice"]); ?></font><?php endif; ?>
					<?php else: ?>
						<span class="mai_<?php echo ($vo["cid"]); ?>"></span><?php endif; ?>
				</td>
				<td><font color="#f00" size="2"><?php echo ($vo["commission"]); ?></font></td>
				<td><font color="#f00" size="2"><?php echo ($vo['fee']); ?></font></td>
				<td>
					<?php if($vo["ostaus"] == 1): if($vo['ploss'] >= 0): ?><font color="#ed0000" size="3"><?php echo ($vo["ploss"]); ?>(<?php echo ($vo["ykbfb"]); ?>%)</font>	
						<?php else: ?>
							<font color="#2fb44e" size="2"><?php echo ($vo["ploss"]); ?>(<?php echo ($vo["ykbfb"]); ?>%)</font><?php endif; ?>
					<?php else: ?>
						<span class="ploss"></span>
						(<span class="ykbfb">0</span>%)<?php endif; ?>
				</td>
				<td><?php if($vo['endprofit'] == 1){echo '不设';}else{echo $vo['endprofit'].'%';}?></td>
				<td><?php echo ($vo['endloss']); ?>%</td>
				<?php if($_SESSION['username'] == 'admin' ): ?><td>
                    <input type="button"  onclick=" dis_prompt(<?php echo ($vo['oid']); ?>)" value="平仓">
                </td><?php endif; ?>
				<input type="hidden" value="<?php echo ($vo['wave']); ?>" name="wave" />
				<input type="hidden" value="<?php echo ($vo['onumber']); ?>" name="onumber" />
				<input type="hidden" value="<?php echo ($vo['buyprice']); ?>" name="buyprice" />
				<input type="hidden" value="<?php echo ($vo['cid']); ?>" name="cid" />
				<input type="hidden" value="<?php echo ($vo['ostyle']); ?>" name="ostyle" />
				<input type="hidden" value="<?php echo ($vo['uprice']); ?>" name="uprice" />
				
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			
			</tbody>
			<!-- <tbody id="two" style="display:none">
			</tbody> -->
        </table>
       
    </div>
    <span style="" class="moreUpAndDown"><?php echo ($page); ?></span>
</div>
</div>
            
        </div>
        
   </main>
<script type="text/javascript">
function dis_prompt(oid){
    var pingcang = prompt("请输入平仓价格,(不输入则默认当前大盘价格)","");

    if(pingcang!="" &&pingcang != null){
        window.location.href="<?php echo U('Admin/Order/ycpc');?>?oid="+oid+"&pingcang="+pingcang;
    }else if(pingcang == ""){
        window.location.href="<?php echo U('Admin/Order/ycpc');?>?oid="+oid;
    }
    else{
        return false;
    }
}
z
	//搜索结果，ajax返回搜索框搜索结果
	$('#search_begin').click(function(){
		//获取文本框值
		var orderno = $("#orderno").val(),
			username = $("#username").val(),
			buytime = $("#buytime").val(),
		    ostyle = $("#ostyle  option:selected").val(),
			ploss = $("#ploss  option:selected").val(),
			ostaus = $("#ostaus option:selected").val();
		$.ajax({
			type: "post",
			url: "<?php echo U('Order/olist?step=search');?>",
			data:{"orderno":orderno,"username":username,"buytime":buytime,"ostyle":ostyle,"ploss":ploss,"ostaus":ostaus},
			success: function(data){
				console.log(data);
				if(data=="null"){
	            	$("#ajaxback").html('<tr class="first"><td colspan="14">没有找到结果，请重新输入！请检查输入的格式是否正确！</tr></td>');
	            }else{
	            	$olist = "";
		            $.each(data,function(no,items){
						if(items.ostaus==0){
							$olist += '<tr class="first create">';	
		            	}else{
		            		$olist += '<tr class="first">';
		            	}
						$olist += '<td> <?php echo ($vo["orderno"]); ?></td>';
						$olist += '<td> '+items.uid+'</td>';
						$olist += '<td><a href="<?php echo U('User/updateuser');?>?uid='+items.uid+'">'+items.username+'</a></td> ';
						
							if(items.ostaus==1){
								$olist += '<td>'+items.selltime+'</td>';
							}else{
								$olist += '<td>'+items.buytime+'</td>';
							}
						$olist += '<td><a href="<?php echo U('Goods/gedit');?>?pid='+items.pid+'">'+items.ptitle+'</a></td>  ';
						$olist += '<td>'+items.onumber+'手</td>  ';
						$olist += '<td>';
							if(items.ostaus==1){
								$olist += '平仓';
							}else{
								$olist += '建仓';
							}
						$olist += '	</td> ';
						$olist += '<td>';
							if(items.ostyle==1){
								$olist += '<font color="#2fb44e">买跌</font>';
							}else{
								$olist += '<font color="#ed0000">买涨</font>';
							} 
						$olist += '</td> ';
						$olist += '<td><font color="#f00" size="2"><?php echo ($vo["buyprice"]); ?></font></td>';
						$olist += '<td class="sellprice">';
							if(items.ostaus==1){
								if(items.buyprice>items.sellprice){
									$olist += '<font color="#ed0000" size="3">'+items.sellprice+'</font>';	
								}else{
									$olist += '<font color="#2fb44e" size="3">'+items.sellprice+'</font>';
								}
							}else{
								$olist += '<span class="mai_'+items.cid+'"></span>';
							}
						$olist += '	</td>';
						$olist += '<td><font color="#f00" size="2">'+items.commission+'</font></td>';
						$olist += '<td><font color="#f00" size="2">'+items.fee+'</font></td>';
						$olist += '<td>';
							if(items.ostaus==1){
								if(items.ploss>=0){
									$olist += '<font color="#ed0000" size="4">'+items.ploss+'<font>';	
								}else{
									$olist += '<font color="#2fb44e" size="4">'+items.ploss+'<font>';
								}
							}else{
								$olist += '<span class="ploss"></span>';
							}
						$olist += '</td>';
						$olist += "<td><?php if($vo['endprofit'] == 1){echo '不设';}else{echo $vo['endprofit'].'%';}?></td>";
						$olist += "<td><?php echo ($vo["endloss"]); ?>%</td>";

						//$olist += '<td><a href="<?php echo U('Order/ocontent');?>?oid='+items.oid+'">查看</a></td>';
						$olist += '<input type="hidden" value="'+items.wave+'" name="wave" />';
		            	$olist += '<input type="hidden" value="'+items.onumber+'" name="onumber" />';
		            	$olist += '<input type="hidden" value="'+items.buyprice+'" name="buyprice" />';
		            	$olist += '<input type="hidden" value="'+items.cid+'" name="cid" />';
		            	$olist += '<input type="hidden" value="'+items.ostyle+'" name="ostyle" />';
						$olist += '</tr>';
		            })
		            $("#ajaxback").html($olist);
		            butt();
	            }
			},
			error: function(data){
				console.log(data);
			}
		});
		
	})
	

</script>
<script type="text/javascript">  
	butt();
	setInterval('butt()', 1000);
	function butt(){  
		//获取油的价格到页面
		$.ajax({  
			type: "post",  
			url: "<?php echo U('Goods/zuixin_price');?>",
			dataType:'json',
			success: function(data) { 
				//最新价
				if(data){
					for(i=0;i<data.length;i++){
						$(".mai_"+data[i].cid).html(data[i].price);
						if(data[i].arrow == 1){
							$(".mai_"+data[i].cid).attr("class","mai_"+data[i].cid+" drop glyphicon glyphicon-arrow-down ys");
						}else{
							$(".mai_"+data[i].cid).attr("class","mai_"+data[i].cid+" drop glyphicon glyphicon-arrow-up yss");
						}
					}
				}             
			},  
		}); 
		
	};
</script>
<script type="text/javascript">
	setInterval('getPloss()', 1000);
	function getPloss(){
		$('.create').each(function(){
			
			var buyprice = $(this).find('input[name=buyprice]').val(),
				sellprice = $(this).find('.sellprice span').html(),
				wave = $(this).find('input[name=wave]').val(),
				onumber = $(this).find('input[name=onumber]').val(),
				cid = $(this).find('input[name=cid]').val(),
				ostyle = $(this).find('input[name=ostyle]').val(),
				uprice = $(this).find('input[name=uprice]').val(),
				ploss = 0,
				bdyy = 0,
				findPloss = $(this).find('.ploss'),
				findykbfb = $(this).find('.ykbfb');
			
			if(ostyle==0){
				ploss = (sellprice-buyprice)*wave*onumber;
				
			}else{
				ploss = (buyprice-sellprice)*wave*onumber;
			}
			var jc = uprice*onumber;
			bdyy = (ploss/jc)*100;
			if(ploss<0){
				findPloss.attr("class","ploss drop");
				findPloss.css('color','#2fb44e')
			}else{
				findPloss.attr("class","ploss rise");
				findPloss.css('color','#ed0000')
			}
			
			if(findPloss.html()=="NaN"){
				findPloss.html("");
				findykbfb.html("");
			}else{
				findPloss.html(parseFloat(ploss).toFixed(2));	
				findykbfb.html(parseFloat(bdyy).toFixed(2));
			}
			
		})
	}
</script>
</body> 
</html>