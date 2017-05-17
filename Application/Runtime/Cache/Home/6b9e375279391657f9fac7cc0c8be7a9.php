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
<link rel="stylesheet" href="/Public/Home/css/charge.css?v=<?php echo time();?>">
<link rel="stylesheet" href="/Public/Home/css/common.css"/>
<link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>

<script id="G--xyscore-load" type="text/javascript" charset="utf-8" async src="/Public/Home/js/xyscore_main.js"></script>
</head>
<style>*{padding:0;margin:0;}  
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,p,blockquote,th,td{margin:0;padding:0; border:0}
img,input,select,button{border:none;vertical-align:middle;}  
body{font-family:"微软雅黑","宋体",Arial;font-size:12px;text-align:center;background:#f5f5f5;color:#999999; padding:0px; margin:0px} 
ul,ol{list-style-type:none;}  
th,td,input{font-size:12px;}  
fieldset,img{border:0;}
input,textarea,select{border:solid 1px #d4d4d4; font-size:14px; color:#000000; line-height:18px; font-family:"微软雅黑","宋体",Arial; vertical-align:middle}

input{padding-left:5px;}
button{border:none;cursor:pointer;font-size:12px;background-color:transparent;}  

a {text-decoration:none;color:#666666;}  
a:hover{text-decoration:none;color:#ff8900;} 
td{word-break: break-all;}
.choose-none{border:none}


.fll{float:left;}
.flr{float:right;}
.fln{float:none;}
*{	
	margin: 0;
	outline: 0;
	padding: 0;
	font-size: 100%;
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
a {
    text-decoration: none;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0.35);
}
html {
	height: 100%;
	font-size: 100%;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
}

img {
	-ms-interpolation-mode: bicubic;
	vertical-align: middle;}

.borderBtm{border-bottom:solid 1px #f6f6f6;}
.payqdList ul li{border-bottom:solid 1px #333; padding-top:10px; padding-bottom:10px; text-align:left; height:56px; padding-left:16px; padding-right:13px; clear:both}
.payqdPic{width:36px; height:36px; margin-right:10px;}
.payqdName{}
.payqdName h2{color:#4f4f50; font-size:14px; padding-top:2px; padding-bottom:1px; font-weight:normal}
.payqdName h2 span{background:#ff0000; color:#fff; font-size:12px; padding:0px 2px}
.payqdName p{color:#999999; font-size:12px;}
.payqdIco{ width:8px; height:11px; margin-top:15px; background-size:100% 100%}

.wrap .new_inde1{background:#fff;}
.wrap .new_inde2{background:#202020; color:#dedede;}
.wrap .new_inde3{background:#fff;}
.wrap .new_inde4{background:#fff;}
.new_id1{background:#FFCC33;}
.new_id2{background:#111;}
.new_id3{background:#cf0000;}
.new_id4{background:#daac33;}
.zh_f2{background:#111 !important; color:#fff !important;}
.yue2 li{border:1px solid #111;}
.jiug2{border:1px solid #111;}
.pay_i {height:150px;text-align:center;}
.pay_i img {width:70px; height:70px; margin-top:15px; border-radius:100%; margin-bottom:5px;}
.pay_i p {font-size:15px; color:#dedede;margin-top:5px;}
.pay_i span {color:#ff7c80;}

.backmask{ position: fixed; top: 0;left: 0;width: 100%;height: 100%; background: rgba(0, 0, 0, 0.7); display: none;    z-index: 10000; cursor: pointer;}
.tan_back{ position: fixed; bottom: 0%; width:100%; background: #fff;z-index: 30000;border-radius: 5px;overflow: hidden; display:none; max-width:640px;}
.tan_back ul {width:98%; margin:1%;}
.tan_back ul li { width:48%; padding:2%; text-align:center; border:1px solid #dedede; margin:3px; float:left; }
.bank-logo { background: url(/Public/Home/images/bank-logo.png) no-repeat ; background-size:100%; display: block;   width: 125px;height: 28px; overflow: hidden; text-indent: -9999px;}
#back-icbc{background-position: 0 -140px;}
#back-ccb{background-position: 0 -338px;}
#back-cmbc{background-position: 0 -790px;}
#back-abc{background-position: 0 -534px;}
#back-bcm{background-position: 0 -394px;}
#back-gdb{background-position: 0 -197px;}
#back-boc{background-position: 0 -848px;}
#back-cmsb{background-position: 0 -451px;}
#back-hxb{background-position: 0 -312px;}
#back-cib{background-position: 0 -760px;}
#back-sdb{background-position: 0 -705px;}


#back-ceb{background-position: 0 -171px;}
#back-spdb{background-position: 0 -591px;}
#back-pab{background-position: 0 -562px;}
#back-psbc{background-position: 0 -874px;}
#back-cncb{background-position: 0 -903px;}
#back-bos{background-position: 0 -675px;}
#back-srcb{background-position: 0 -645px;}
#back-brcb{background-position: 0 -0px;}
#back-hzcb{background-position: 0 -254px;}
#back-nbcb{background-position: 0 -506px;}
#back-cbhb{background-position: 0 -55px;}
#back-njcb{background-position: 0 -477px;}
.showdow {font-size:18px;}
.tan_back ul .backcards {border:1px solid red;}
</style>
<body>
<div class="wrap">
  <div class="index new_inde<?php echo ($tpl); ?>" style="min-height: 480px;">
    <header class="list-head new_id<?php echo ($tpl); ?>">
      <nav class="list-nav clearfix"> <a href="javascript:history.go(-1)" class="list-back"></a>
        <h3 class="list-title" style="font-size:16px;">账户充值</h3>
      </nav>
    </header>
	<div class="pay_i">
		<?php if($suer["portrait"] == ''): ?><img src="/Public/Home/images/pic.gif"><?php else: ?><img src="<?php echo ($suer["portrait"]); ?>"><?php endif; ?>
		<p>账户ID：<?php echo ($suer['username']); ?></p>
		<p>余额：<span><?php if($result['balance']){echo $result['balance'];}else{echo 0;}?></span><i>元</i></p>
	</div>
   <!--  <ul class="account-info yue<?php echo ($tpl); ?>">
		<li style="border-bottom:none;background:#fcfaf0;" class="zh_f<?php echo ($tpl); ?>">账户ID：<?php echo ($suer['username']); ?></li>
		<li>余额：<span><?php echo ($result['balance']); ?></span><i>元</i></li>
    </ul> -->
		
        <form id="moneyCharge1" class="" method="post" action="<?php echo U('User/recharge');?>">
			
			<ul class="PAY_con"> 
				<li class="PAY_con_1 vip_cz jiug<?php echo ($tpl); ?>">100</li>
				<li class="PAY_con_1 jiug<?php echo ($tpl); ?>">300</li>
				<li class="PAY_con_1 jiug<?php echo ($tpl); ?>">500</li>
				<li class="PAY_con_1 jiug<?php echo ($tpl); ?>">1000</li>
				<li class="PAY_con_1 jiug<?php echo ($tpl); ?>">3000</li>
				<li class="PAY_con_1 jiug<?php echo ($tpl); ?>">5000</li>
				<li class="PAY_con_1 jiug<?php echo ($tpl); ?>">10000</li>
				<li class="PAY_con_1 jiug<?php echo ($tpl); ?>">30000</li>
				<li class="PAY_con_1 jiug<?php echo ($tpl); ?>">其它金额</li> 
			</ul>
			<p class="c-line clearfix zh_f<?php echo ($tpl); ?>" >
				<label class="fl">充值</label>
				<em>元</em>
				<input type="text" class="c-input" readonly id="smoney" maxlength="6" placeholder="100" value="100" name="tfee1">
			</p>

			<div class="payqdList">
				<ul id="backcard">
					<!--<li data-id="1">
						<label >
							<input name="zf" style="float:left; margin-top:10px; margin-right:8px; margin-left:8px; height:18px; width:18px;border-radius:100%;" type="radio" value="blank" />
							<div class="payqdPic fll"><img data-cfsrc="/Public/Home/images/quick.png" width="36" height="36" src="/Public/Home/images/quick.png"></div>
							<div class="payqdName fll">
								<h2>储蓄卡支付</h2>
								<p>单笔限额2000元，日限额5000元</p>
							</div>
							<div class="payqdIco flr"></div>
						</label>
					</li> -->
					<li data-id="2" >
						<label class="fll" style=" width: 100%;">
							<input id="wx"  style="float:left; margin:10px 8px 5px 8px; height:18px; width:18px;border-radius:100%; border-color: #2799eb;" type="radio" value="RongBaoWx" checked=""/>
							  <div class="payqdPic fll" ><img data-cfsrc="/Public/Home/images/weixin.png" width="36" height="36" src="/Public/Home/images/weixin.png"></div>
							  <div class="payqdName fll" >
								<h2>微信支付</h2>
								<p>推荐微信用户使用</p>
							  </div>

							  <div class="payqdIco flr" style=" width: 100px; height: 21px; margin-top: 10px;"><span  id="bankwk1" > <h2>已&nbsp;选&nbsp;中</h2></span></div>
						</label>
					</li>
					<li data-id="3" >
						<label  class="fll" style=" width: 100%;">
							<input id="zfb"  style="float:left; margin:10px 8px 5px 8px; height:18px; width:18px;border-radius:100%;" type="radio" value="RongBaoZfb" />
						<div class="payqdPic fll" >
						<img data-cfsrc="/Public/Home/images/M_alipay.png" width="36" height="36" src="/Public/Home/images/M_alipay.png"></div>
						<div class="payqdName fll" >
						  <h2>支付宝支付</h2>
						   <p>推荐支付宝用户使用</p>
						</div>
							<div class="payqdIco flr" style=" width:100px; height: 21px; margin-top: 10px;"><span  id="bankwk2" style="display:none;"> 已&nbsp;选&nbsp;中</span></div>
						</label>
					</li>
				</ul>
			</div> 
			
			
			<input type="hidden" class="bankname" name="bankname" value="WXZF" />
			<div class="backmask"></div>
			<div class="tan_back" >
			<ul>
			
				<li class="bakcs"><span class="bank-logo" id="back-ccb" data-type="CCB"></span></li><!-- 建设 -->
				<li class="bakcs"><span class="bank-logo" id="back-cmbc" data-type="CMBC"></span></li><!-- 招商 -->
				<li class="bakcs"><span class="bank-logo" id="back-abc" data-type="ABC"></span></li><!-- 农业 -->
				<li class="bakcs"><span class="bank-logo" id="back-bcm" data-type="BCM"></span></li><!-- 交通 -->
				<li class="bakcs"><span class="bank-logo" id="back-gdb" data-type="GDB"></span></li><!-- 广发 -->
				<li class="bakcs"><span class="bank-logo" id="back-boc" data-type="BOC"></span></li><!-- 中国银行 -->
				<li class="bakcs"><span class="bank-logo" id="back-cmsb" data-type="CMSB"></span></li><!-- 民生 -->
				<li class="bakcs"><span class="bank-logo" id="back-cib" data-type="CIB"></span></li><!-- 兴业 -->
			<!-- 	<li><span class="bank-logo" id="back-nbcb" data-type="NBCB"></span></li>宁波 -->
				<li class="bakcs"><span class="bank-logo" id="back-cncb" data-type="CNCB"></span></li><!-- 中信 -->
				<li class="bakcs"><span class="bank-logo" id="back-spdb" data-type="SPDB"></span></li><!-- 浦发 -->
				<li class="bakcs"><span class="bank-logo" id="back-pab" data-type="PAB"></span></li><!-- 平安 -->
				<li class="bakcs"><span class="bank-logo" id="back-ceb" data-type="CEB"></span></li><!-- 光大 -->
				<li class="bakcs"><span class="bank-logo" id="back-sdb" data-type="SDB"></span></li><!-- 深圳发展 -->
				<li class="bakcs"><span class="bank-logo" id="back-icbc" data-type="ICBC"></span></li><!-- 工商 -->
				
				<!-- <li><span class="bank-logo" id="back-psbc"></span></li>邮政
				<li><span class="bank-logo" id="back-bos"></span></li>上海
				<li><span class="bank-logo" id="back-srcb"></span></li>上海农业
				<li><span class="bank-logo" id="back-brcb"></span></li>北京农商
				<li><span class="bank-logo" id="back-hzcb"></span></li>杭州
				<li><span class="bank-logo" id="back-cbhb"></span></li>渤海
				<li><span class="bank-logo" id="back-njcb"></span></li>南京
				<li><span class="bank-logo" id="back-hxb"></span></li>华夏 -->
			</ul>
			<div style="margin:30px 5%; margin-top:10px; width:90%;height:40px;line-height:40px; text-align:center; float:left;">
				<div id="quxiao" style="width:30%; margin-right:2%; background:#999; color:#fff; border-radius:3px; float:left;">取消</div>
				<p style="width:68%;  float:left; background:red; color:#fff; border-radius:3px; float:left;"> 
					<input type="submit" value="确定充值" style="background:none; border:none; width:99%; text-align:center; color:#fff;"/>
				</p>
			</div>
			</div>

			 <!-- <input id="type" type="hidden"  name="type" value="Wxpay"> -->
            
			<!-- <div class="xieyi">
				<input type="checkbox" name="up_xieyi" id="up_xieyi"/>
				<p style="margin-top:.4rem;">我已阅读并同意<span style="color:#1fb3b6;">《服务协议及隐私条款》</span></p>
			</div> -->
			<?php if($payst['zfopen'] == 1): ?><input type="button" class="f-sub que showdow" value="确定充值">
				<input type="button"  class="f-sub showdow" value="确定充值">
			<?php else: ?>
				<input type="submit" class="f-sub showdow" value="确定充值"/><?php endif; ?>
        </form>
  </div>
 
</div>

<div class="box" style="max-width:640px;">
    <div id="dialogBg"></div>
    <div id="dialog" class="">
        <div class="dialogTop">
            <a href="javascript:;" class="claseDialogBtn" id="claseDialogBtn"></a>
        </div>
		<div class="pop-box none" id="buildBox" style="display: block;">
           <nav class="pop-nav "> <a href="javascript:;" style="right:10;" class="back" id="claseDialogBtn_1"></a>
              <h3>扫码支付</h3>
            </nav>
			<form id="jcForm" class="build-form" method="post" action="<?php echo U('Detailed/addorder');?>" >
			
				<div class="b-line clearfix">
					
					<div style="margin-top:20px;" align="center" id="qrcode">
					</div>
					<input type="hidden" name="orderid" id="orderid" value="" />
				</div>
				
			
               
              <a href="<?php echo U('Index/index');?>" class="pwd-btn chr failure  none" style="display: none;font-size:1.4rem" id="conform3">222</a>
            </form>
		</div>

	</div>
</div>

<script src="/Public/Home/js/jquery-2.1.1.min.js"></script>
<script src="/Public/Home/js/script.js"></script>
<script src="/Public/Home/js/qrcode.js"></script>
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
<script type="text/javascript">
$(function(){  
  if ($('#order_id').val()!='') {
       $('#moneyCharge2').submit();
    };
});
</script>
<script>
	//购买
	$(".que").click(function(){
		$('#dialog').css('display','block');
		$('#dialogBg').css('display','block');
		var tfee1 = $("#smoney").val(); 
		 $.get("<?php echo U('code');?>?tfee1="+tfee1,function(data){
            if(data){
               var url = data.url;
			    //$('#orderid').attr('value',data.order);  对value进行赋值
				$('#orderid').val(data.order);
				//参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
				var qr = qrcode(10, 'H');
				qr.addData(url);
				qr.make();
				var orderid=data.order;
				//var wording=document.createElement('p');
				//wording.innerHTML = "微信支付";
				var code=document.createElement('div');
				code.innerHTML = qr.createImgTag();
				var element=document.getElementById("qrcode");
				//element.appendChild(wording);
				element.appendChild(code);
				Check();
            }
        });
		
	});
	
	$("#claseDialogBtn_1").click(function() {
		$('#dialog ').css('display','none');
		$('#dialogBg ').css('display','none');
	});
</script>
<script language="JavaScript">
	    function Check()
	    {
	    	var out_trade_no = $("#orderid").val(); 
			//alert(out_trade_no);
			$.get("<?php echo U('orderQuery');?>?ajax=1&out_trade_no="+out_trade_no,function(data){
			//alert(data);
            if(data=='支付成功'){
                alert('支付成功！');
               window.location.href='<?php echo U("memberinfo");?>';//跳转地址
            }
			
			
        });
		setTimeout("Check()",1000);  
		}
		
	</script>
<script>
/* 充值 */
	$('.PAY_con_1').click(function(){
        $('.PAY_con_1').removeClass('vip_cz');
        $(this).addClass('vip_cz');
		var money = $(this).html();
		
		if(money == '其它金额'){
			
			$("#smoney").val('');
			//$('.sale_after').html('0');
			$("#smoney").removeAttr('readonly');
			$("#smoney").focus();
			
			$(document).on('#smoney input propertychange', function() {  
				var money = $('#smoney').val();
				var rng  = /^[1-9]\d*$/;;
				if(!rng.test(money)){
					alert('请输入正整数');
					var money = $('#smoney').val('');
					$('#smoney').val('');
					return false;
				}
			});
			
			
		}else{
			$("#smoney").val(money);		
		}
		
		
    });
	/* 支付方式  */
	function bank(pay){
		$('.PAY_con_bank').removeClass('vip_cz');
        $('#'+pay).addClass('vip_cz');
		$('#type').attr('value',pay);
	}

</script>
<script>
	$("#up_xieyi").click(function(){
		if($("#up_xieyi").attr("checked")=='checked'){
			$("#up_xieyi").attr('checked',false);
		}else{
			$("#up_xieyi").attr('checked',true);
		}
	});
/*	$("#cz_xieyi").click(function(){
		if($("#cz_xieyi").attr("checked")=='checked'){
			$("#cz_xieyi").attr('checked',false);
		}else{
			$("#cz_xieyi").attr('checked',true);
		}
	});*/
	/*$(".bakcs").click(function(){
		var bank_name=$(this).children().attr('data-type'); 
		
		$('.bakcs').removeClass('backcards');
		$(this).addClass('backcards');
		$(".bankname").val(bank_name);
		
	});*/
</script>
<script>
$(function(){
	$("#backcard li").click(function(){
		var type = $(this).data('id');
		if(type == 1){
			$(".tan_back").show();   //弹出层
			$(".backmask").hidden();       //遮罩层
		}else if(type == 2){
			$(".bankname").val('WXZF');
			$("#zfb").attr('checked',false);
			$("#wx").attr('checked',true);
			document.getElementById("bankwk2").style.display="none";
			document.getElementById("bankwk1").style.display="";
		}else if(type == 3){
			$("#wx").attr('checked',false);
			$("#zfb").attr('checked',true);
			$(".bankname").val('ZFB');
			document.getElementById("bankwk2").style.display="";
			document.getElementById("bankwk1").style.display="none";

		}
		
	})
  });
  $(function(){
   $("#quxiao").click(function(){
   $(".tan_back").hide();   //弹出层
   $(".backmask").hide();       //遮罩层
   })
  });
</script>
<script type="text/javascript" charset="utf-8" src="/Public/Home/js/sea.js" async></script>
</body>
</html>