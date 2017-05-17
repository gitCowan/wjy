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
<link rel="stylesheet" href="/Public/Home/css/weipan.css"/>
<link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>
<link rel="stylesheet" href="/Public/Home/css/common.css"/>
<link rel="stylesheet" href="/Public/Home/css/trainfo.css"/>
<style>
.sdeg {font-size:12px;}
.tixing2{background:#202020;}
.zhi_po2{background:none; color:#fff;}
.trs2{background:#202020; color:#999; width:100%; margin:0; min-height:740px;} 

.new_inde2 p {background:#111; color:#dedede;}
.tarn2 {border-bottom:1px solid #111;}
.al_gs {left:auto;}
.feijiao{
	position: fixed;
	width: 265px;
	top: 50%;
	left: 50%;
	margin-left: -130px;
	margin-top: -100px;
	z-index: 70000;
	border-radius: 5px;
	display: none;
	height:50px;
	line-height:50px;
	text-align:center;
	background:#fcf8e3 ;
}

</style>

	<div class="index new_inde<?php echo ($tpl); ?>">
		<header class="list-head new_id<?php echo ($tpl); ?>" style="width:100%;">
			  <nav class="list-nav clearfix"> <a href="<?php echo U('Index/index');?>" target="_self" class="list-back"></a>
				<input value="<?php echo ($order["cid"]); ?>" id="orcid" type="hidden">
				<h3 class="list-title"><?php echo ($order["ptitle"]); ?></h3>
			  </nav>
			</header>
		<div class="trainfo trs<?php echo ($tpl); ?>">
		<div class="trainfo_top<?php echo ($tpl); ?> new_inde<?php echo ($tpl); ?>">
			<p>交易详情</p>
			<div class="trainfo_cen tarn<?php echo ($tpl); ?>">
				<dl>
					<dt>订单号：</dt>
					<dd><?php echo ($order["orderno"]); ?></dd>
				</dl>
				<dl>
					<dt>合同订立时间：</dt>
					<dd><?php echo (date('Y-m-d H:i:s',$order["buytime"])); ?></dd>
				</dl>
				<dl>
					<dt>产品：</dt>
					<dd><?php echo ($order["ptitle"]); ?></dd>
				</dl>
			</div>
			<div class="trainfo_cen tarn<?php echo ($tpl); ?>">
				<div class="trainfo_cen_left">
					<dl>
						<dt class="trainfo_cen_1">方向：</dt>
						<dd class="trainfo_cen_2">
							<?php if($order["ostyle"] == 1): ?><font color="#2fb44e">买跌</font>
								<?php else: ?>
								<font color="#ed0000">买涨</font><?php endif; ?>
						</dd>				
					</dl>		
					<dl>
						<dt class="trainfo_cen_1">入仓价：</dt>
						<dd class="trainfo_cen_2"><?php echo ($order["buyprice"]); ?></dd>	
					</dl>	
					
					<dl>
						<dt class="trainfo_cen_1">止盈：</dt>
						<dd class="trainfo_cen_2"><?php if($order['endprofit'] == 1){echo '不设';}else{echo $order['endprofit'].'%';}?></dd>
					</dl>
				</div>
				<div class="trainfo_cen_right">
					<dl>
						<dt class="trainfo_cen_1">数量：</dt>
						<dd class="trainfo_cen_2"><?php echo ($order["onumber"]); ?></dd>
					</dl>
					<dl>
						<dt class="trainfo_cen_1">现价：</dt>
						<dd class="trainfo_cen_2" id="youjia" style="padding:0;"><?php echo ($order["price"]); ?></dd>	
					</dl>
					<dl>
						<dt class="trainfo_cen_1">止损：</dt>
						<dd class="trainfo_cen_2"><?php echo ($order["endloss"]); ?>%&nbsp;&nbsp;<span class="tiaozheng">调整</span></dd>
					</dl>
				</div>			
			</div>
			<div class="trainfo_cen trainfo_fo tarn<?php echo ($tpl); ?>">
				<dl>
					<dt>建仓支付金额：</dt>
					<?php if($order["eid"] == 1): ?><!-- <dd class="l_l"><em class="ykzjload"><img src="/Public/Home/images/loading.gif" alt="正在加载"/></em></dd> -->
					<dd class="l_l"><em class=""><img src="/Public/Home/images/ticket-small.png"/>(已使用<?php echo ($order["uprice"]); ?>元体验券)</em></dd>
					<?php else: ?>
					<dd class="l_l" id="jiancj"><?php echo $order['uprice']*$order['onumber']?></dd><?php endif; ?>
				</dl>
				<dl>
					<dt>盈亏资金：</dt>
					<dd style="color:#1ebb30;" > <span id="ykzj" style="padding:0 3px;"></span> <span id="mykbfb" style="padding:0 3px; font-size:1.4rem;"></span></dd>
					<!-- <dd style="color:#1ebb30; width:3rem;" ></dd> -->
					<!-- <?php if($order["eid"] == 1): ?><span class="r_r"><img src="/Public/Home/images/ticket-small.png"/>(已使用<?php echo ($order["uprice"]); ?>元体验券)</span><?php endif; ?> -->
				</dl>
				<dl>
					<dt>本单盈余：</dt>
					<dd id="bdyy"></dd>
				</dl>
			</div>
			<input value="<?php echo ($order["wave"]); ?>" id="orwave" type="hidden"/>
			<input value="<?php echo ($order["ostyle"]); ?>" id="orostyle" type="hidden"/>
			<input value="<?php echo ($order["uprice"]); ?>" id="uprice" type="hidden"/>
			<input value="<?php echo ($order["cid"]); ?>" id="orcid" type="hidden"/>
			<div style="padding-bottom:14px;">
			<?php if($order['ostaus'] == 1): ?><input type="button" class="pwd-btn  conform" value="已平仓" >
			<?php else: ?>
				<input type="button" class="pwd-btn  conform" id="aa" value="确认平仓" ><?php endif; ?>
			</div>
			
		</div>
		
	</div>



	<div class="box" style="margin-top:-370px;">
		<div id="dialogBg"></div>
		<div id="dialog" class="">
			<!--建仓确认-->
			<div class="pop-box none widgs" id="buildBox" style="display: block; max-width:640px; margin:0 auto;">
				<nav class="pop-nav"> <a href="javascript:;" class="back" id="claseDialogBtn"></a>
				  <h3>设置止盈/止损</h3>
				</nav>
				<form id="jccg" class="build-form" method="post"  autocomplete="off">
					<div class="b-line">
						<label class="b-label">确认数量：</label>
						<p class="num qrsl" style="background:#fff;"><?php echo ($order["onumber"]); ?></p>
					</div>
					<div style="height:48px;"></div>
					<div class="" style="overflow: hidden;">
						<label class="b-label">止盈(%)：</label>
						<p class="num-list   clearfix" id="jcsh" style="background:#fff;">
						<span class="profit-left pay-left"></span>
						<input type="text" value="<?php if($order['endprofit'] == 1){echo '不设';}else{echo $order['endprofit'];}?>" class="num-in" disabled="" id="profit"/>
						<span class="profit-right pay-right"></span></p>
					</div>
					
					<div class="" style="overflow: hidden;">
						<label class="b-label">止损(%)：</label>
						<p class="num-list   clearfix" id="jcsh" style="background:#fff;">
						<span class="loss-left pay-left"></span>
						<input type="text" value="<?php echo ($order["endloss"]); ?>" class="num-in" disabled="" id="loss"/>
						<span class="loss-right pay-right"></span> </p>
					</div>
					<input type="hidden" name="oid" value="<?php echo ($order["oid"]); ?>" id="buyid"/>
					<input type="hidden" name="profit" value="<?php echo ($order["endprofit"]); ?>" id="zy"/>
					<input type="hidden" name="loss" value="<?php echo ($order["endloss"]); ?>" id="zk"/>
					<input type="button" class="pwd-btn  save" value="保存设置" onclick="baocun()"/>
				</form>
			</div>
		</div>
	</div>

	<div id="loading" style="width: 100%;height: 105%;position: absolute;top: 0; z-index: 9999;display: none;">
		<div class="load-center" style="background: #000;position: absolute;width: 60%;height: 14%;bottom: 10%;border-radius: 10px;color: #fff;text-align: center;font-size: 24px;left: 17%;padding: 1%;">
			<img src="/Public/Home/images/ajax-loading.jpg" alt="ajax-loading" width="40"/><br/>页面加载中...
		</div>
	</div>
	
	<div class="feijiao">现在是非交易时间</div>
</div>
<script type="text/javascript" src="/Public/Home/js/jquery.min.js"></script>
<script type="text/javascript">
	setInterval('mybutt()', 1000);
	var hour = "<?php echo date('H'); ?>";
	var day  = "<?php echo date('w'); ?>";
	var kpan = "<?php echo ($isopen['kpan']); ?>";
	var gpan = "<?php echo ($isopen['gpan']); ?>";
	var isopen = "<?php echo ($isopen['isopen']); ?>";
	//建仓止盈加
	$('#jcsh .profit-right').click(function(){
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
//    alert(9);
    //    alert(endloss);
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
	
	/**
	 * @param  int    oid   	订单id
	 * @param  int    cid   	产品id
	 * @param  float  youjia    最新价格
	 */
    function mybutt(){  
		var nprice = $("#youjia").html();
		$.ajax({  
			type: "post",  
			url: "<?php echo U('Detailed/orderxq');?>",    
			data:{"oid":$('#buyid').val()},
			beforeSend:function(XMLHttpRequest){ 
				//alert('远程调用开始...'); 
			},
			success: function(data) {
				$('#youjia').html(data['price']);
				//隐藏油价
				if(data['price']>nprice){
					$('#youjia').attr("class","l_l redd");
				}else if(data[0]==nprice){
				
				}else{
					$('#youjia').attr("class","l_l jg2");
				} 
				
				$('#ykzj').html(data['ykzj']);
				$('#bdyy').html(data['bdyy']);
				if(data['ykbfb']){
					var sum1 = parseFloat((data['ykbfb']*100).toFixed(2));
					if(sum1 != 'NaN'){
						$('#mykbfb').html('(<em id="ykbfb">'+sum1+'</em>)%');
					}
				}
				//盈亏资金
				var sum= data['ykzj'];
				if(sum>0){
					$('#ykzj').attr("class","l_l redd");
				}else{
					$('#ykzj').attr("class","l_l jg2");
				}  
			  
				if(sum1>0){
					$('#mykbfb').attr("class","l_l redd");
				}else{
					$('#mykbfb').attr("class","l_l jg2");
				}             
			},  
			error: function(data) {  
				//alert(data);
			}  
        }); 
    };
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
	}
</script>
<script type="text/javascript">
$(function(){
	//显示弹框
	$('.tiaozheng').click(function(){
		if((day == 6 && parseInt(gpan) <= hour) || (day == 0) || (day == 1 && hour <= parseInt(kpan)) || (parseInt(gpan) <= hour && hour <= parseInt(kpan)) || isopen == 2){
			$(".feijiao").show();
			$(".feijiao").fadeOut(2000);
			return false;
		}
		$('#dialogBg').show();
		$('#dialog').show();
		
	});
	//关闭弹窗
	$('#claseDialogBtn').click(function(){
		$('#dialogBg').css('display','none');
		$('#dialog').css('display','none');
	});
});
	
  
$("#aa").click(function(){
	if((day == 6 && parseInt(gpan) <= hour) || (day == 0) || (day == 1 && hour <= parseInt(kpan)) || (parseInt(gpan) <= hour && hour <= parseInt(kpan)) || isopen == 2){
		$(".feijiao").show();
		$(".feijiao").fadeOut(2000);
		return false;
	}
	//订单id
	var oid	  = $('#buyid').val();
	$(this).unbind('click');
	$.ajax({  
        type: "post",  
        url: "<?php echo U('Detailed/updateore');?>",    
        data:{"oid":oid},
        success: function(data) {
           location.href = "<?php echo U('Index/dtrading');?>";   
        },  
        error: function(data) {  
            //alert(data);
        }
        
    }); 
});
</script>
<script>
  $(function(){
        var width = $(window).width();

        if(width>640){
            $('.widgs').addClass('al_gs');
        }else{
            $('.widgs').removeClass('al_gs');
        }
    });
</script>

 </div>     
</body>
</html>