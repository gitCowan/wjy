<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<title><?php echo C('WebName');?></title>
<!-- <style>
.ycdcdDiv ul li{border-bottom:1px solid #fff;}
</style> -->
</head>
<body style="max-width:640px;margin-left:auto;margin-right:auto;background:#202020;">

<div class="main"> 	
       
<link rel="stylesheet" href="/Public/Home/css/global.css">
<link rel="stylesheet" href="/Public/Home/css/index.css">
<link rel="stylesheet" href="/Public/Home/css/common.css"/>
<link rel="stylesheet" href="/Public/Home/css/weipan.css"/>
<link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>
<style>
	.chooseAll{
		background:#d82c2c;
		padding:3px 8px;
		border-radius:5px;
		width:50px;
		color:#fff;
	}
	.al_gs {left:auto;}
	.weipan_head_2 ul li span em{
		padding-right:15px;
		font-size:17px;
		font-weight:bold;
	}
	.mask{
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.7);
		display: none;
		z-index: 10000;
		cursor: pointer;
	}
	.delete_ad,.feijiao{
		position: fixed;
		width: 265px;
		top: 50%;
		left: 50%;
		margin-left: -130px;
		margin-top: -100px;
		background: #fff;
		z-index: 70000;
		border-radius: 5px;
		display: none;
	}
	.feijiao{
		height:50px;
		line-height:50px;
		text-align:center;
		background:#fcf8e3 ;
	}
	.boxCheck1 {
		top: 10%;
		left: 50%;
		background: #fff;
		z-index: 70000;
		border-radius: 4px;
		height: auto;
		margin:25px 20px;
		color:#333;
		text-align: left;
		font-size: 16px;
		line-height: 25px;
	}
	.boxCheck2 {
		border-top: 1px solid #ddd;
		text-align: center;
	}
	.boxNo {
		float: left;
		height: 44px;
		width: 50%;
		font-size: 16px;
		border: 0;
		color: #F76C28;
		cursor: pointer;
		background: #fff;
		font-weight: 700;
		border-bottom-left-radius: 4px;
	}
	.boxYes {
		float: right;
		height: 44px;
		width: 50%;
		font-size: 16px;
		border: 0;
		color: #dd4c3a;
		cursor: pointer;
		background: #fff;
		border-left: 1px solid #ddd;
		font-weight: 700;
		border-bottom-right-radius: 4px;
	}
	.weipan_head .wei_color_2{
		background:#202020;
		border-top:1px solid #333;
	}
	.weipan_head .wei_color_1{
		background:-webkit-linear-gradient(top,#5DDC9C, #CAF3DA);
		border-top:1px solid #CAF3DA;
		color:#fff;
	}
	
	.weipan_head .wei_color_3{
		background:-webkit-linear-gradient(top,#D82C2C, #F4ADAA);
		border-top:1px solid #DE4141;
	}
	.weipan_head .wei_color_4{
		background:-webkit-linear-gradient(top,#FFCC33, #F7E4B4);
		border-top:1px solid #F7E4B4;
	}
	.weipan_head_color{
		height:60px;
		border-bottom:1px solid #111;
		text-align:center;
	}
	.weipan_head ul li{
		float:left;
		padding-top:10px;
	}	
	.weipan_head ul li span{
		color:#dedede;
		font-size:12px;
		display:block;
		height:20px;
	}
	.weipan_head ul li span em{
		font-size:17px;
		padding-right:15px;
		font-weight:bold;
	}
	.wei_color_3 ul li span{
		color:#000;
	}
	.wei_color_4 ul li span{
		color:#fff;
	}
</style>
<div class="wrap" style="overflow:scroll;overflow-x:hidden;">
	<div class="index<?php echo ($tpl); ?>" style="min-height:740px;">
  
    <input type="hidden" id="tpqh" value="1"/>
    <!-- 账户有建仓订单时显示所有没有平仓的订单 -->
    <div style="position: fixed;top: 0;z-index: 5;width: 100%;">

		<div class="jryk<?php echo ($tpl); ?>" >
            <div class="yk_left" >今日盈亏</div>
            <div class="yk_con">0.00</div>元
            <div class="yk_right<?php echo ($tpl); ?> box2" style="font-size:12px;">
				<span class="times"></span>
            </div>
            <div class="clearfix"></div>
		</div>
		
		<div class="weipan_head" style="height:59px;">
			<div class="weipan_head_color wei_color_<?php echo ($tpl); ?>">
				<ul class="clearfix fix_1">
					<?php if(is_array($catgood)): $i = 0; $__LIST__ = $catgood;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v_class): $mod = ($i % 2 );++$i;?><li class="hui width_c_<?php echo ($v_class["cid"]); ?> width_c" data-type="<?php echo ($v_class["title"]); ?>" value="<?php echo ($v_class["cid"]); ?>">
							<span><?php echo ($v_class["cname"]); ?></span> 
							<span style="height:27px;"><em class="<?php echo ($v_class['title']); ?> pricess_<?php echo ($v_class['cid']); ?>"></em></span>
							<input type="hidden" value="<?php echo ($v_class["title"]); ?>" class="proCode" />
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
		</div>
    </div>

        <div class="b-line noclearfix<?php echo ($tpl); ?>" style="margin-bottom:0;margin-top: 101px;" id="useror">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="10%">汇率浮动</td>
                    <!--<td width="10%">违约金</td> -->
					<td width="30%">建仓价</td>
					<td width="20%">产品</td>
					<td width="10%">手数</td>
					<td><a href="javascript:;" class="chooseAll">一键平仓</a></td>
				</tr>
				<?php if(is_array($nolist)): $i = 0; $__LIST__ = $nolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$on): $mod = ($i % 2 );++$i;?><tr class="ykzf openpay">
						<td class="ykzfwave" style="display:none"><?php echo ($on["wave"]); ?></td>
						<td class="ykzfostyle" style="display:none"><?php echo ($on["ostyle"]); ?></td>
						<td class="ykzfeid" style="display:none"><?php echo ($on["eid"]); ?></td>
						<td class="ptitle" style="display:none"><?php echo ($on["ptitle"]); ?></td>
						<td class="uprice" style="display:none"><?php echo ($on["uprice"]); ?></td>
						<td class="oid" style="display:none"><?php echo ($on["oid"]); ?></td>
						<td class="Ctitle" style="display:none"><?php echo ($on["title"]); ?></td>
						<td style="display:none" class="yincangyoujia_<?php echo ($on["title"]); ?> latest-price"></td>
						
						<td class="cash1 ploss ProLoss_<?php echo ($on["oid"]); ?>"></td>  
						<!--<td class="ykzfwave" ><?php echo ($on["fee"]); ?></td>-->
						<td class="buyprice"><?php echo ($on["buyprice"]); ?>
						<?php if($on["ostyle"] == 1): ?><font color="#2fb44e">(空)</font><?php else: ?><font color="#ed0000">(多)</font><?php endif; ?>
						</td>                     
						<td><?php echo ($on["cname"]); ?>(<?php echo ($on["company"]); ?>)</td>
						<td class="onumber"><?php echo ($on["onumber"]); ?></td>                        
						<td class="mypwd-btn"   style="text-align: center; margin-left: 20px; ">
						<a href="<?php echo U('Detailed/orderid',array('orderid'=>$on['oid']));?>" class="red" data-cid='<?php echo ($on["cid"]); ?>' data-oid='<?php echo ($on["oid"]); ?>' style="">平仓</a>
						<a href="javascript:void(0);" class="blue" data-onumber='<?php echo ($on["onumber"]); ?>' data-oid='<?php echo ($on["oid"]); ?>' data-zy='<?php echo ($on["endprofit"]); ?>' data-zk='<?php echo ($on["endloss"]); ?>' style="margin-left:5%;">设置</a>
						<div style="clear: both;"></div>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
		</div>
   
	</div>
</div>
	<!-------切换隐藏------->

	
<div class="box">
    <div id="dialogBg2"></div>
    <div id="dialog2" class="">
        <div class="dialogTop">
            <a href="javascript:;" class="claseDialogBtn">关闭</a>
        </div>
        <div class="pop-box none widgs" id="buildBox2" style="display: block; max-width:640px; margin:0 auto; overflow:hidden;">
            <nav class="pop-nav"> <a href="javascript:;" class="backtop" id="claseDialogBtn2"></a>
              <h3>设置止盈/止损</h3>
            </nav>
            <form id="jccg" class="build-form" autocomplete="off">
				<div class="b-line">
					<label class="b-label">确认数量：</label>
					<p class="num qrsl"><?php echo ($order["onumber"]); ?></p>
				</div>
				<div style="height:48px;"></div>
				<div class="" style="overflow: hidden;">
					<label class="b-label">止盈(%)：</label>
					<p class="num-list   clearfix" id="jcsh">
					<span class="profit-left pay-left"></span>
					<input type="text" value="不设" class="num-in" disabled="" id="profit"/>
					<span class="profit-right pay-right"></span></p>
				</div>
				
				<div class="" style="overflow: hidden;">
					<label class="b-label">止损(%)：</label>
					<p class="num-list   clearfix" id="jcsh">
					<span class="loss-left pay-left"></span>
					<input type="text" value="不设" class="num-in" disabled="" id="loss"/>
					<span class="loss-right pay-right"></span> </p>
				</div>
				<input type="hidden" name="oid" value="" id="buyid"/>
				<input type="hidden" name="profit" value="" id="zy"/>
				<input type="hidden" name="loss" value="" id="zk"/>
				<input type="button" class="pwd-btn" onclick="baocun()" value="保存设置"/>
			</form>
        </div>
	</div>
</div>

<!-- 遮罩层  -->
<div class="mask"></div>
<!-- 删除广告弹出层 -->
<div class="delete_ad">
	<div class="boxCheck1" >
		您确定要一键平仓？
	</div>
	<div class="boxCheck2">
		<button type="button" class="boxNo" style="color:#aaa;">取消</button>
		<button type="button" class="boxYes">确定</button>
		
	</div>
</div>
<!--弹窗开始-->
<div class="feijiao">现在是非交易时间</div>
<script src="/Public/Home/js/jquery-2.1.1.min.js"></script>
<script src="/Public/Home/js/idangerous.swiper.min.js"></script>
<script src="/Public/Home/js/fastclick.js"></script>
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

<!-- <script type="text/javascript"> 

var SysSecond;    
var InterValObj;    
var deadline;     
$(document).ready(function() { 
	deadline    = "<?php echo ($time); ?>";
	SysSecond   = parseInt(deadline); //这里获取倒计时的起始时间    
	InterValObj = window.setInterval(SetRemainTime, 1000); //间隔函数，1秒执行    
});    
    
//将时间减去1秒，计算天、时、分、秒    
function SetRemainTime() {
	if (SysSecond > 0) {    
		SysSecond  = SysSecond - 1;    
		var second = Math.floor(SysSecond % 60);             // 计算秒        
		var minite = Math.floor((SysSecond / 60) % 60);      //计算分    
		var hour   = Math.floor((SysSecond / 3600) % 24);      //计算小时    
		var day    = Math.floor((SysSecond / 3600) / 24);        //计算天 
		$(".times").html(day + "天" + hour + "小时" + minite + "分" + second + "秒后强制平仓"); 
		
	}else{									//剩余时间小于或等于0的时候，就停止间隔函数    
		window.clearInterval(InterValObj);  //这里可以添加倒计时时间为0后需要执行的事件
		window.location.reload(); 
		$.ajax({
			type : 'post',
			url  : "<?php echo U('Detailed/allOrder');?>",
			dataType : 'json',
			success  : function(json){
				if(json){
					window.location.reload(); 
				}
			}
		})
	}    
};  
</script> -->

<!-- 一键平仓 -->
<script>
	var hour = "<?php echo date('H'); ?>";
	var day  = "<?php echo date('w'); ?>";
	var kpan = "<?php echo ($isopen['kpan']); ?>";
	var gpan = "<?php echo ($isopen['gpan']); ?>";
	var isopen = "<?php echo ($isopen['isopen']); ?>";
	if((day == 6 && parseInt(gpan) <= hour) || (day == 0) || (day == 1 && hour <= parseInt(kpan)) || (parseInt(gpan) <= hour && hour <= parseInt(kpan)) || isopen == 2){
		newsdata();
	}else{
		setInterval('newsdata()', 1000);
	}
	
	
	var count = "<?php echo ($catgood[0]['count']); ?>";
	var width_d=100/count;
	var cid  = "<?php echo ($catgood[0]['cid']); ?>";
	var code = "<?php echo ($catgood[0]['title']); ?>";
    $(".width_c").css("width",width_d+'%');
	function newsdata(){
		var str = '';
		$(".proCode").each(function(){
			str += $(this).val()+',';
		})
		$.ajax({  
			type : "post",  
			url  : "<?php echo U('Index/newsData');?>",
			data : {'code':str},	
			dataType : 'json',
			success: function(data) {
				for(i=0;i<data.length;i++){
					var cid = data[i]['cid'];
					var beprice = $(".pricess_"+cid).html();
					var code  = data[i]['code'];
					var afprice = data[i]['price'];
					$('.'+code).html(afprice);
					if(afprice < beprice){
						$("."+code).css('color','#058c01');
						$('.'+code).css('background',"url(/Public/Home/images/down.png) no-repeat scroll right / 9px 17px");
					}else if(afprice > beprice){
						$("."+code).css('color','#fe0000');
						$('.'+code).css('background',"url(/Public/Home/images/up.png) no-repeat scroll right / 9px 17px");
					}
				}
			}
		})
	}
	
	$(".chooseAll").click(function(){
		if((day == 6 && parseInt(gpan) <= hour) || (day == 0) || (day == 1 && hour <= parseInt(kpan)) || (parseInt(gpan) <= hour && hour <= parseInt(kpan)) || isopen == 2){
			$(".feijiao").show();
			$(".feijiao").fadeOut(2000);
			return false;
		}else{
			$('.mask').show();
			$('.delete_ad').show();
		}
		
	});
	
	$(".boxNo").click(function(){
		$(".mask").hide();
		$(".delete_ad").hide();
	})
	
	$(".boxYes").click(function(){
		var openpay = $('.openpay');
		var str = '';
		if(openpay){
			openpay.each(function(){
				var oid = $(this).find('.oid').text();
				str += oid+',';
			})
		}
		$.ajax({
			type : 'post',
			url  : "<?php echo U('Detailed/ajaxAllclose');?>",
			data : {'allOid':str},
			dataType : 'json',
			success  : function(json){
				if(json == '-1'){
					alert('平仓失败，稍后平仓');
					window.location.reload();
				}else if(json == '-2'){
					alert('订单列表中有订单已自动平仓，稍后平仓');
					window.location.reload();
				}else{
					location.href = "<?php echo U('Index/dtrading');?>";
				} 
			}
		})
	});
</script>
<script>
	
    $('.blue').click(function(){
		if((day == 6 && parseInt(gpan) <= hour) || (day == 0) || (day == 1 && hour <= parseInt(kpan)) || (parseInt(gpan) <= hour && hour <= parseInt(kpan)) || isopen == 2){
			$(".feijiao").show();
			$(".feijiao").fadeOut(2000);
			return false;
		}
		var onumber = $(this).attr('data-onumber');
		var zy = $(this).attr('data-zy');
		if(zy == 1){
			$("#profit").val('不设');
		}else{
			$("#profit").val(zy);
		}
		var zk = $(this).attr('data-zk');
		$('.qrsl').text(onumber);
		$('#buyid').val($(this).attr('data-oid'));
		
		$("#loss").val(zk);
		$("#zy").val(zy);
		$("#zk").val(zk);
		$('#dialogBg2').show();
		$('#dialog2').show();
	});

	//建仓止盈加
	$('#jcsh  .profit-right').click(function(){
		var $numValue = $(this).prev().val();
		if($numValue == "不设"){
			$numValue = 0;
		}else{
			$numValue = parseInt($numValue);
		}
		if($numValue < 90){
			$(this).prev().val($numValue+10);
		}
	});
	
	//建仓止盈减
	$('#jcsh  .profit-left').click(function(){
		var $numValue = $(this).next().val();
		if($numValue == "不设"){
			$numValue = 0;
		}else{
			$numValue = parseInt($numValue);
		}
		if($numValue > 10){
			$(this).next().val($numValue-10);
		}else{
			$(this).next().val('不设');
		}
	});
	var endloss = "<?php echo $isopen['endloss']?>";
	//建仓止损加
	$('#jcsh  .loss-right').click(function(){
		var $numValue = $(this).prev().val();
		if($numValue == "不设"){
			$numValue = 0;
		}else{
			$numValue = parseInt($numValue);
		}
		if($numValue < endloss){
			$(this).prev().val($numValue+10);
		}
	});
	
	//建仓止损减
	$('#jcsh  .loss-left').click(function(){
		var $numValue = $(this).next().val();
		if($numValue == "不设"){
			$numValue = 0;
		}else{
			$numValue = parseInt($numValue);
		}
		if($numValue > 10){
			$(this).next().val($numValue-10);
		}else{
			$(this).next().val('不设');
		}
	});
	
	function baocun(){
		var zy = $("#profit").val();
		var zk = $("#loss").val();
		var oid = $('#buyid').val();
		if(zy == '不设'){
			zy = 1;
		}
		if(zk == '不设'){
			zk = endloss;
		}
		$.ajax({
			url  : "<?php echo U('Index/edityk');?>",
			type : 'post',
			data : {'profit':zy,'loss':zk,'oid':oid},
			dataType: 'json',
			success:function(json){
				if(json == 1){
					window.location.reload();
				}else{
					alert('修改失败');
				}
			}
		})
	};
	var strs = '';
	$(".Ctitle").each(function(){
		strs += $(this).html()+',';
	})
	if(!strs){
		
	}else{
		setInterval('butt1()', 1000);
	}
	
	function butt1(){

		

		//获取油的价格到页面

		$.ajax({  

			type: "post",  

			url: "<?php echo U('Index/price');?>",

			data : {'code':strs},

			dataType: 'json',

			success: function(data) { 

				if(data){

					for(i=0;i<data.length;i++){

						$(".yincangyoujia_"+data[i].code).html(data[i].price);

					}  

				}            

			},  

		}); 

	};
	
	//关闭弹窗
	$('#claseDialogBtn2').click(function(){
		$('#dialogBg2').css('display','none');
		$('#dialog2').css('display','none');
		
	});
	
  </script>
  <script type="text/javascript">
	setInterval('pcprice()', 1000);
	function pcprice(){
		var yinprice1=0;
		var yinprice2=0;
		var yinprice3=0;
		var ykzf = $(".ykzf");
		ykzf.each(function(){
			var yincangyoujia=parseFloat($(this).children('.latest-price').html()).toFixed(5);
			var buyprice = parseFloat($(this).children(".buyprice").html()).toFixed(5);
			//状态0是涨，1是跌
			var ykzfostyle = $(this).children(".ykzfostyle").html();
			//是否体验卷0不是，1是
			var ykzfeid = $(this).children(".ykzfeid").html();
			//数量
			var onumber = $(this).children(".onumber").html();
			//波动
			var ykzfwave = $(this).children(".ykzfwave").html();
			
			if (ykzfostyle==0) {
				var newprice1 = (yincangyoujia-buyprice)*ykzfwave*onumber;
			}else{
				var newprice1 = (buyprice-yincangyoujia)*ykzfwave*onumber;
			};
			yinprice1 = newprice1+yinprice1;
			var newprice3 = newprice1.toFixed(5);
			
			
			if(yincangyoujia=="NaN"){
				$(this).children(".cash1").text("");
			}else{
				$(this).children(".cash1").html(newprice3);
				if(newprice3>=0){
					$(this).children(".cash1").css('color','#ed0000')
				}else{
					$(this).children(".cash1").css('color','#2fb44e')
				}
			}         
		});
	 
		var picsum=Number(yinprice1+yinprice2+yinprice3).toFixed(5);
		$('.ploss').each(function(){
			if($(this).text()==""){
				$('.yk_con').html();
			}else{
				$('.yk_con').html(picsum);
			}	
		})
    } 
</script>
<script>
  $(function(){
        var width = $(window).width();
        if(width>640){
            $('.widgs').addClass('al_gs');
        }else{
            $('.widgs').removeClass('al_gs');
        }
		var height = $(window).height();
		$(".index2").css('height',height);
    });
</script>


 </div>     
</body>
</html>