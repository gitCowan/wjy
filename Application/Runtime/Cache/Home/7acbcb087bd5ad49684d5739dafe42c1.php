<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<title><?php echo C('WebName');?></title>
<link rel="stylesheet" href="/Public/Home/css/global.css">
<link rel="stylesheet" href="/Public/Home/css/index.css">
<link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>
</head>
<style>
.gs1 {
	background-color: #fff;
    width: 100%;
    height: 3.5rem;
    max-width: 640px;
    position: fixed;
    top: 0;
    z-index: 5;
	margin: 0 auto;
	border-bottom: 1px solid #5DDC9C;
}
.gs2 {
	background-color: #202020;
    width: 100%;
    height: 3.5rem;
    max-width: 640px;
    position: fixed;
    top: 0;
    z-index: 5;
	margin: 0 auto;
	border-bottom: 1px solid #111;
}
.gs3 {
	background-color: #fff;
    width: 100%;
    height: 3.5rem;
    max-width: 640px;
    position: fixed;
    top: 0;
    z-index: 5;
	margin: 0 auto;
	border-bottom: 1px solid #DAAC33;
}
.gs4 {
	background-color: #fff;
    width: 100%;
    height: 3.5rem;
    max-width: 640px;
    position: fixed;
    top: 0;
    z-index: 5;
	margin: 0 auto;
	border-bottom: 1px solid #FFCC33;
}

.gs1 li a {
    display: block;
    width: 100%;
    margin: 0 auto;
    padding: 5.2px 0;
    color: #8E8E8E;
    cursor: pointer;
}
.gs2 li a {
    display: block;
    width: 100%;
    margin: 0 auto;
    padding: 5.2px 0;
    color: #fff;
    cursor: pointer;
}
.gs3 li a {
    display: block;
    width: 100%;
    margin: 0 auto;
    padding: 5.2px 0;
    color: #8E8E8E;
    cursor: pointer;
}
.gs4 li a {
    display: block;
    width: 100%;
    margin: 0 auto;
    padding: 5.2px 0;
    color: #8E8E8E;
    cursor: pointer;
}
.gs1 li a.selected {
    font-weight: bold;
    color: #fff;
    background: #5DDC9C;
	border-bottom:1px solid #5DDC9C;
}
.gs2 li a.selected {
    color: #daac33;
    background: #111;
	border-bottom:1px solid #daac33;
}
.gs3 li a.selected {
    font-weight: bold;
    color: #fff;
    background: #cf0000;
	border-bottom:1px solid #cf0000;
}
.gs4 li a.selected {
    font-weight: bold;
    color: #fff;
    background: #FFCC33;
	border-bottom:1px solid #FFCC33;
} 
.fsf1{border-bottom:1px solid #f1f1f1}
.fsf2{border-bottom:1px solid #333}
.fsf3{border-bottom:1px solid #f1f1f1}
.fsf4{border-bottom:1px solid #f1f1f1}
.wrap .new_inde1{background:#fff;}
.wrap .new_inde2{background:#202020; color:#dedede;}
.wrap .new_inde3{background:#fff;}
.wrap .new_inde4{background:#fff;}
.new_id1{background:none;}
.new_id2{background:#111;}
.new_id3{background:none;}
.new_id4{background:none;}
</style>
<body>
<div class="wrap">
	<div class="index new_inde<?php echo ($tpl); ?>" style="min-height: 1782px; height: auto;">
		<div class="info-box new_id<?php echo ($tpl); ?>" style="">
			<ul class="info-nav clearfix gs<?php echo ($tpl); ?>" >
				<?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vos): $mod = ($i % 2 );++$i;?><li><a <?php if($vos["fid"] == $_GET["nid"]): ?>class="selected"<?php endif; ?> href="<?php echo U('News/newslist');?>?nid=<?php echo ($vos["fid"]); ?>" style="padding:.7rem 0"><?php echo ($vos['fclass']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		  <div class="info-d" style="padding-top:3.5rem;">
			  <?php if(is_array($newslist)): $i = 0; $__LIST__ = $newslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="news-list clearfix fsf<?php echo ($tpl); ?>" style="height:50px;line-height:50px;">
					<a href="<?php echo U('News/newsid');?>?nid=<?php echo ($vo['nid']); ?>" style="text-decoration:none;">
						<div style="white-space:nowrap;text-overflow:ellipsis;overflow:hidden;width:70%;float:left;font-size:1.25rem;color:#999;padding-left:1rem;"><?php echo ($vo["ntitle"]); ?></div>
						<div style="width:30%;float:left;text-align:right;padding-right:1rem;"><?php echo (date('Y-m-d',$vo["ntime"])); ?></div>
					</a>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
		  </div>
		</div>
	</div>
</div>
<style>
.foot1{background:#fff; border-top:1px solid #f1f1f1;}
.foot2{background:#202020; border-top:1px solid #111;}
.foot1 {background:#fff;}
.foot2 {background:#202020;}
.foot3 {background:#fff;}
.foot4 {background:#fff;}
.foot3{background:#fff; border-top:1px solid #f1f1f1;}
.foot4{background:#fff; border-top:1px solid #f1f1f1;}
.max_foot1{background:#fff;}
.max_foot2{background:#202020;}
.max_foot3{background:#fff;}
.max_foot4{background:#fff;}
.ico_foot {width:100%;height:33px;line-height:40px; font-size:25px;}
.fmng1{color:#999 !important;}
.fmng2{color:#fff !important;}
.fmng3{color:#cf0000 !important;}
.fmng4{color:#999;}
.ico_dais3{background:#cf0000;color:#fff;}

</style>
<footer style="max-width:640px;margin:0 auto;" class="max_foot2">
	<div style="height:58px;"></div>
	<div style="max-width:640px;position:fixed;bottom:0;z-index:5;width:100%;height:58px;line-height:58px;" class="foot2">
		<ul>
			<a href="/" style="text-decoration:none;">
			<li style="width:25%;text-align:center;float:left" class="ico_dai2 fmng2">
				<div  class="ico_foot ">
					<i class="icon-home" style="font-size:22px;"></i>
				</div>
				<div style="width:100%;height:25px;line-height:25px;">
					首 页
				</div>
			</li>
			</a>
			<a href="<?php echo U('Home/Index/dtrading');?>" style="text-decoration:none;">
			<li style="width:25%;text-align:center;float:left" class="ico_dai2 fmng2">
				<div  class="ico_foot ">
					<i class="icon-pay"></i>
				</div>
				<div style="width:100%;height:25px;line-height:25px;">
					交 易
				</div>
			</li>
			</a>
			<a href="<?php echo U('Home/News/newslist');?>" style="text-decoration:none;">
			<li style="width:25%;text-align:center;float:left" class="ico_dai2  fmng2">
				<div  class="ico_foot">
					<i class="icon-acunt"></i>
				</div>
				<div style="width:100%;height:25px;line-height:25px;">
					公 告
				</div>
			</li>
			</a>
			<a href="<?php echo U('Home/User/memberinfo');?>" style="text-decoration:none;">
				<li style="width:25%;text-align:center;float:left" class="ico_dai2 fmng2">
					<div  class="ico_foot ">
						<i class="icon-vip"></i>
					</div>
					<div style="width:100%;height:25px;line-height:25px;">
						会 员
					</div>
				</li>
			</a>
			
		</ul>
	</div>
	 
</footer>
</body>
</html>