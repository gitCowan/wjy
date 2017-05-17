<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Proton - Admin Template</title>		
		
		<!-- Import google fonts - Heading first/ text second -->
        <link rel='stylesheet' type='text/css' href='http://fonts.useso.com/css?family=Open+Sans:400,700|Droid+Sans:400,700' />
        <!--[if lt IE 9]>
<link href="http://fonts.useso.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
<link href="http://fonts.useso.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
<link href="http://fonts.useso.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
<link href="http://fonts.useso.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="shortcut icon" href="assets/ico/favicon.ico" type="image/x-icon" />    

	    <!-- Css files -->
	    <link href="/Public/Ucenter/css/bootstrap.min.css" rel="stylesheet">		
		<link href="/Public/Ucenter/css/jquery.mmenu.css" rel="stylesheet">		
		<link href="/Public/Ucenter/css/font-awesome.min.css" rel="stylesheet">
		<link href="/Public/Ucenter/css/climacons-font.css" rel="stylesheet">
		    
	    <link href="/Public/Ucenter/css/style.min.css" rel="stylesheet">
		<link href="/Public/Ucenter/css/add-ons.min.css" rel="stylesheet">		
		<link type="text/css" rel="stylesheet" href="/Public/Ucenter/css/calendar.css" >
		<script type="text/javascript" src="/Public/Ucenter/js/calendar.js" ></script>  
		<script type="text/javascript" src="/Public/Ucenter/js/calendar-zh.js" ></script>
		<script type="text/javascript" src="/Public/Ucenter/js/calendar-setup.js"></script>
	    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
</head>

<body>
	<!-- start: Header -->
	<div class="navbar" role="navigation">
	
		<div class="container-fluid">		
			
			<ul class="nav navbar-nav navbar-actions navbar-left">
				<li class="visible-md visible-lg"><a href="" id="main-menu-toggle"><i class="fa fa-th-large"></i></a></li>
				<li class="visible-xs visible-sm"><a href="" id="sidebar-menu"><i class="fa fa-navicon"></i></a></li>			
			</ul>
			
			<!-- <form class="navbar-form navbar-left">
				<button type="submit" class="fa fa-search"></button>
				<input type="text" class="form-control" placeholder="Search..."></a>
			</form> -->
			<!-- <div class="copyrights">Collect from <a href="http://www.cssmoban.com/" >免费模板</a></div> -->
	        <ul class="nav navbar-nav navbar-right">
				<li class="dropdown visible-md visible-lg">
	        		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="user-avatar" src="/Public/Ucenter/img/avatar.jpg" alt="user-mail">jhonsmith@mail.com</a>
	        		<!-- <ul class="dropdown-menu">
						<li class="dropdown-menu-header">
							<strong>Account</strong>
						</li>						
						<li><a href="page-profile.html"><i class="fa fa-user"></i> Profile</a></li>
						<li><a href="page-login.html"><i class="fa fa-wrench"></i> Settings</a></li>
						<li><a href="page-invoice.html"><i class="fa fa-usd"></i> Payments <span class="label label-default">10</span></a></li>
						<li><a href="gallery.html"><i class="fa fa-file"></i> File <span class="label label-primary">27</span></a></li>
						<li class="divider"></li>						
						<li><a href="index.html"><i class="fa fa-sign-out"></i> Logout</a></li>	
	        		</ul> -->
	      		</li>
				<li><a href="index.html"><i class="fa fa-power-off"></i></a></li>
			</ul>
			
		</div>
		
	</div>
	<!-- end: Header -->
	
	<div class="container-fluid content">
	
		<div class="row">
				
			<!-- start: Main Menu -->
			<div class="sidebar ">
								
				<div class="sidebar-collapse">
					<div class="sidebar-header t-center">
                        <span><img class="text-logo" src=""><i class="fa fa-space-shuttle fa-3x blue"></i></span>
                    </div>										
					<div class="sidebar-menu">						
						<ul class="nav nav-sidebar">
							<!--<li><a href="index.html"><i class="fa fa-laptop"></i><span class="text"> Dashboard</span></a></li>-->
							<li>
								<a href="#"><i class="fa fa-file-text"></i><span class="text"> 开户管理</span> <span class="fa fa-angle-down pull-right"></span></a>
								<ul class="nav sub">
									
									<li><a href="<?php echo U('Account/agentlist');?>"><i class="fa fa-folder"></i><span class="text"> 代理列表</span></a></li>
									<li><a href="<?php echo U('Account/agentadd');?>"><i class="fa fa-user"></i><span class="text"> 添加代理</span></a></li>
									
								</ul>	
							</li>
							<li>
								<a href="#"><i class="fa fa-list-alt"></i><span class="text"> 交易流水</span> <span class="fa fa-angle-down pull-right"></span></a>
								<ul class="nav sub">
									<li><a href="<?php echo U('Trade/tradelist');?>"><i class="fa fa-indent"></i><span class="text"> 交易流水</span></a></li>
									
								</ul>
							</li>
							
							<li>
								<a href="#"><i class="fa fa-signal"></i><span class="text"> 客户管理</span> <span class="fa fa-angle-down pull-right"></span></a>
								<ul class="nav sub">
									<li><a href="<?php echo U('Customer/customerlist');?>"><i class="fa fa-random"></i><span class="text"> 客户列表</span></a></li>
									<li><a href="<?php echo U('Customer/customeradd');?>"><i class="fa fa-user"></i><span class="text"> 添加客户</span></a></li>
									
								</ul>
							</li>
							<li>
								<a href="#"><i class="fa fa-briefcase"></i><span class="text"> 返佣记录</span> <span class="fa fa-angle-down pull-right"></span></a>
								<ul class="nav sub">
									<li><a href="<?php echo U('Retlog/returnloglist');?>"><i class="fa fa-align-left"></i><span class="text"> 返佣记录</span></a></li>
									
								</ul>
							</li>
							
						</ul>
					</div>					
				</div>
				<div class="sidebar-footer"></div>	
				
			</div>
			<!-- end: Main Menu -->
		
		<!-- start: Content -->
			
<style type="text/css">
	.datatable,.datatable th{text-align:center;}
</style>
<div class="main sidebar-minified">
<!--/row-->
			<div class="row">		
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><i class="fa fa-table red"></i><span class="break"></span><strong>代理列表</strong></h2>
							<div class="panel-actions">
							  <!--   <a href="window.location.reload();" class="btn-setting"><i class="fa fa-rotate-right"></i></a> -->
								<a href="" ><i class="fa fa-rotate-right"></i></a>
								<a href="table.html#" class="btn-minimize"><i class="fa fa-chevron-up"></i></a>
								<a href="table.html#" class="btn-close"><i class="fa fa-times"></i></a>
							</div>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-bordered bootstrap-datatable datatable">
							  <thead>
								  <tr> 
                                      <th>类别</th>
									  <th>用户名</th>
                                      <th>地区</th>
									  <th>注册时间</th>
									  <th>操作</th>
								  </tr>
							  </thead>   
							  <tbody>
							  <?php if(is_array($ulist)): $i = 0; $__LIST__ = $ulist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
										<td>代理商</td>
	                                    <td><?php echo ($vo["username"]); ?></td>
	                                    <td><?php echo ($vo["address"]); ?></td>
										<td><?php echo (date('Y-m-d H:i',$vo["utime"])); ?></td>
										<td>
<!-- 											<a class="btn btn-success" href="<?php echo U('Account/agentadd');?>">
												<i class="fa fa-search-plus ">新增</i>                                            
											</a> -->
											<a class="btn btn-info" href="<?php echo U('Account/agentadd');?>?uid=<?php echo ($vo['uid']); ?>">
												<i class="fa fa-edit ">修改</i>                                            
											</a>
											<a class="btn btn-danger" href="<?php echo U('Account/agentdel');?>?uid=<?php echo ($vo['uid']); ?>">
												<i class="fa fa-trash-o ">删除</i> 

											</a>
										</td>
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							  </tbody>
						  </table> 						
						 <div class="pagelist"><?php echo ($page); ?></div>						 
						</div>
					</div>
				</div><!--/col-->
			
			</div><!--/row-->
   
		</div>
 
		<!-- end: Content -->
		<br><br><br>
		
		
		
		
	</div><!--/container-->
		
	
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Warning Title</h4>
				</div>
				<div class="modal-body">
					<p>Here settings can be configured...</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<div class="clearfix"></div>
	
		
	<!-- start: JavaScript-->
	<!--[if !IE]>-->

			<script src="/Public/Ucenter/js/jquery-2.1.1.min.js"></script>

	<!--<![endif]-->

	<!--[if IE]>
	
		<script src="/Public/Ucenter/js/jquery-1.11.1.min.js"></script>
	
	<![endif]-->

	<!--[if !IE]>-->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='/Public/Ucenter/js/jquery-2.1.1.min.js'>"+"<"+"/script>");
		</script>

	<!--<![endif]-->

	<!--[if IE]>
	
		<script type="text/javascript">
	 	window.jQuery || document.write("<script src='/Public/Ucenter/js/jquery-1.11.1.min.js'>"+"<"+"/script>");
		</script>
		
	<![endif]-->
	<script src="/Public/Ucenter/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="/Public/Ucenter/js/bootstrap.min.js"></script>	
	
	
	<!-- page scripts -->
	
	<!--[if lte IE 8]>
		<script language="javascript" type="text/javascript" src="assets/plugins/excanvas/excanvas.min.js"></script>
	<![endif]-->
	
	
	<!-- theme scripts -->
	<script src="/Public/Ucenter/js/SmoothScroll.js"></script>
	<script src="/Public/Ucenter/js/jquery.mmenu.min.js"></script>
	<script src="/Public/Ucenter/js/core.min.js"></script>
	
	
	<!-- inline scripts related to this page -->
	
	
	<!-- end: JavaScript-->
	<script src="/Public/Ucenter/js/ucenter.js"></script>
</body>
</html>