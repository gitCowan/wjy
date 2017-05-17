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
       <link rel="stylesheet" href="/Public/Home/css/weipan.css"><link rel="stylesheet" href="/Public/Home/css/global.css"><link rel="stylesheet" href="/Public/Home/css/index.css"><link rel="stylesheet" href="/Public/Home/css/common.css"/><link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/><link rel="stylesheet" type="text/css" href="/Public/Home/css/styleB.css" media="screen and (max-width: 640px)">    <script type="text/javascript" >        var eloss = "<?php echo $isopen['endloss'];?>";    </script><style>a { color:#fff !important; font-family:宋体;}.weipan_head_2 ul li span em{	padding-right:15px;	font-size:13px;	font-weight:bold;}.TimeMenu li a{	display:block;}</style><div class="weipan_box">	<div class="weipan_head">		<div class="weipan_head_1" style="position: fixed;top: 0;z-index: 5;min-width: 320px;    max-width: 640px;width: 100%;">			<div class="weipan_head_1_left" style="font-family:宋体;">				<?php if($user["portrait"] == ''): ?><img src="/Public/Home/images/pic.gif"/>				<?php else: ?>					<img src="<?php echo ($user["portrait"]); ?>"/><?php endif; ?>				体验券：<?php echo ($sum); ?>张			</div>						<div class="weipan_head_1_right">				<a href="<?php echo U('User/memberinfo');?>" style="color:#fff;">					账户余额：<?php if($user['balance']){echo $user['balance'];}else{echo '0.0';}?>元				</a>				<?php if($isopen['zfopen'] == 2): ?><a href="<?php echo U('User/recharge');?>"><span>充值</span></a>				<?php else: ?>					<a href="javascript:;" class="code_tan"><span>充值</span></a><?php endif; ?>				</div>		</div>		<div class="weipan_head_2" style="margin-top: 50px;">			<ul class="clearfix fix_1">				<?php if(is_array($catgood)): $i = 0; $__LIST__ = $catgood;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v_class): $mod = ($i % 2 );++$i;?><li class="hui width_c_<?php echo ($v_class['cid']); ?> <?php if($i == 1){echo 'sw_active hui_boto';}?> width_c" data-type="<?php echo ($v_class["title"]); ?>" value="<?php echo ($v_class["cid"]); ?>" data-id="<?php echo ($i); ?>">						<span><?php echo ($v_class["cname"]); ?></span> 						<span style="height:27px;"><em class="<?php echo ($v_class['title']); ?> pricess_<?php echo ($v_class['cid']); ?>" ></em></span>						<input type="hidden" value="<?php echo ($v_class['title']); ?>" class="proCode" />					</li><?php endforeach; endif; else: echo "" ;endif; ?>			</ul>		</div>			</div>	<div class="weipan_center" style="">		<div class="weipan_center_shu">			<p>				昨收 <span id="close"></span>				最高 <span id="high"></span>			</p>			<p>				今开 <span id="open"></span>				最低 <span id="low"></span>			</p>		</div>				<div class="weipan_center_k trend-chart" style="max-width:640px;cursor: default;z-index:1;position:relative;">					</div>		<div class="weipan_center_fs" style="margin-top:16%;">			<ul class="trend-nav2 clearfix TimeMenu">				<li class="fs"><a href="javascript:void(0)" data-interval='1' data-type="area" class="cur changed fss">分时线</a></li>				<li class="fs"><a href="javascript:void(0)" data-interval='5' data-type="candlestick">5分钟</a></li>				<li class="fs"><a href="javascript:void(0)" data-interval='15' data-type="candlestick">15分钟</a></li>				<li class="fs"><a href="javascript:void(0)" data-interval='30' data-type="candlestick">30分钟</a></li>				<li class="fs"><a href="javascript:void(0)" data-interval='60' data-type="candlestick">60分钟</a></li>			</ul>		</div>		<div id="lunbo">					</div>		<div style="height:60px;"></div>	</div></div><script src="/Public/Home/js/jquery-1.9.1.min.js"></script><input value="" id="Apicid" type="hidden" />

<div class="box">

    <div id="dialogBg"></div>

    <div id="dialog" class="" >

        <div class="dialogTop">

            <a href="javascript:;" class="claseDialogBtn" id="claseDialogBtn"></a>

        </div>

		<div class="pop-box none zhendui_top2 widgs" id="buildBox" style="display: block;max-width:640px !important; margin:0 auto; ">

			<div style="overflow:hidden;">

				<nav class="pop-nav "> <a href="javascript:;" style="right:10;" class="back" id="claseDialogBtn_1"></a>

					<h3>确认购买</h3>

				</nav>

				<div class="" style="overflow: hidden;">

					<label class="b-label">止盈(%)：</label>

					<p class="num-list   clearfix" id="jcsh" style="margin-top:5px;width:50%;">

						<span class="profit-left pay-left"></span>

						<input type="text" value="不设" class="num-in" disabled="" id="profit">

						<span class="profit-right pay-right"></span>

					</p>

				</div>

				

				<div class="" style="overflow: hidden;">

					<label class="b-label">止损(%)：</label>

					<p class="num-list   clearfix" id="jcsh" style="margin-top:5px;width:50%;">

						<span class="loss-left pay-left"></span>

						<input type="text" value="不设" class="num-in" disabled="" id="loss">

						<span class="loss-right pay-right"></span> 

					</p>

				</div>

			

				<div class="" style="overflow: hidden;">

					<label class="b-label">购买数量：</label>

					<p class="num-list   clearfix" id="jcsh" style="margin-top:5px; width:50%;">

						<span class="num-left pay-left"></span>

						<!--<input type="text" name="sls" value="1" class="num-in" id="sls"  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" disabled=""/>-->
						<input type="text" name="sls" value="1" class="num-in" id="sls"  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" />

						<span class="num-right pay-right"></span> 

					</p>

					<p class="price clearfix" style="display:none">

						<span>方向：</span><em class="fx"><span class="zhd" style="font-size:1.1em"></span></em>

					</p>

				</div>

				

				

				<div class="b-line clearfix">

					<label class="b-label">当前价格：</label>

					<p class="price clearfix"> 

						<em class="c-13" id="price"></em>

						<em  id="dqcid" style="display:none"></em>



					</p>

				</div>

				<div class="b-line clearfix">

					<label class="b-label">品种：</label>

					<div class="type-choose clearfix">

						<div class="type-list clearfix">

							<ul class="p-baiyin" style="margin-top: 0px;">

								<li id="opname" class="xz6" data-l="2" data-bz="200" data-pid="6" data-sxf="30.0" data-juan="0"></li>

							</ul>

						</div>

					</div>

				</div>				

				<div class="b-line clearfix">

					<label class="b-label">所用费用：</label>

					<p class="pay"><span id="opprice">0</span>元</p>

					<input type="hidden" name="sxf" id="sxf" value="30.0">

					<div style="display:none"> <p class="b-info">手续费&nbsp;<span id="j-5">0</span>&nbsp;元&nbsp;</p></div>

				</div>

				<div class="b-line clearfix">

					<label class="b-label" style="text-align:right">体验券：</label>

					<p class="c-c-l clearfix" style="margin:8px 5px 0 0;line-height:20px;">

						<input type="checkbox" id="choose" value="">

						<label for="choose" id="mychoose"></label>

					</p>

					<input type="hidden" name="juansl" value="0" id="juansl">

					<p class="b-info"><i class="c11" id="c11">200</i>元 剩&nbsp;<span class="big" id="big">0</span>&nbsp;张 (<span style="font-size:0.8em">1张/次</span>)</p>

				</div>

				<div id="msgNum" style="background:#fcf8e3; width:94%; margin:0 auto; padding:10px 0;  text-indent:10px; color:#8a6d3b; border-radius:3px;display:none;">

					购买数量大于最大允许购买数量

				</div>

				<input type="hidden" value="" id="codeTilte" />
				
				<input type="hidden" name="type" value="<?php echo ($isopen['isopen']); ?>" id="isopen" />

				<input type="hidden" name="type" value="1" id="type" />

				<input type="hidden" name="bz" value="2" id="bz"/>

				<input type="hidden" name="sl" value="1" id="sl"/>

				<input type="hidden" name="ordernumber" value=""/>

				<input type="hidden" name="product" value="6" id="product">

				<input type="hidden" name="jine" value="<?php echo ($user["balance"]); ?>" id="jine">

				<input type="hidden" name="isJuan" value="" id="isJuan">

				<input type="hidden" value="" id="yu">

				<input type="hidden" class="pwd-btn conform" id="conform1" value="确 认">

				<?php if($isopen['zfopen'] == 2): ?><a href="<?php echo U('User/recharge');?>" class="pwd-btn chr failure none" id="conform2" style="font-size:1.4rem">确 认</a>

				<?php else: ?>

				<a href="javascript:;" class="pwd-btn chr failure none code_tan" id="conform2" style="font-size:1.4rem">余额不足，去充值</a><?php endif; ?>

			</div>

		</div>

	</div>

	

	<!-- 登陆密码设置弹出框 -->

	<div id="dialogBg2"></div>

	<div id="dialog2" class="" >

		<div class="pop-box none" id="buildBox2" style="display: block;">

            <nav class="pop-nav"> 

				<!-- <a href="javascript:;" class="backtop" id="claseDialogBtn2"></a> -->

				<h3>登陆密码设置</h3>

            </nav>

            <form id="jccg" class="build-form" method="post" action="<?php echo U('Index/landpwd');?>" autocomplete="off">

            <div style="overflow: hidden;margin-top:1%;">

				<label class="b-label">用户名称：</label>

				<p class="num-list clearfix wid_ifo">

					<input type="text" value="<?php echo ($user["username"]); ?>" class="num-in-lu" name="username" id="username"/>

				</p>

			</div>

			

			<div style="overflow: hidden;margin-top:1%;">

				<label class="b-label">手机号码：</label>

				<p class="num-list clearfix wid_ifo">

					<input type="tel" value="" name="utel" class="num-in-lu" id="utel"/>

				</p>

			</div>

			<div style="overflow: hidden;margin-top:1%;">

				<label class="b-label">验&nbsp;证&nbsp; 码：</label>

				<p class="num-list clearfix wid_ifo" style="width:30%;">

					<input type="text" value="" name="yzm" class="num-in-lu" id="yzm"/>

				</p>

				<p class="price">

					<span class="msgs" >获取</span>

				</p>

			</div>

			<div style="overflow: hidden;margin-top:1%;">

				<label class="b-label">登陆密码：</label>

				<p class="num-list clearfix wid_ifo">

					<input type="password" value="" name="upwd" class="num-in-lu" id="upwd"/>

				</p>

			</div>

			<input type="hidden" value="" id="code" />

			<input type="button" class="pwd-btn" onclick="baocun()" value="保存设置"/>

			</form>

        </div>

	</div>

	<!-- 弹出框 -->

</div>

<div class="mask" style="display:none;"></div>

<div class="tan" style="display:none;">

	<div class="tan_top">关注二维码充值和提现</div>

	<div class=""><img src="<?php echo ($isopen['code']); ?>" style="height:100%;width:100%;"/></div>

</div>

<script>

	var urlJudgment,urlSelectid,urlPrice,urlNewdata,urlDtrading,urlAddorder,urlReset,urlproduct;

	urlJudgment = "<?php echo U('Detailed/judgment');?>";

	urlSelectid = "<?php echo U('Index/selectid');?>";

	urlPrice    = "<?php echo U('Index/ajax_price');?>";			

	urlNewdata  = "<?php echo U('Index/newsdata');?>";			

	urlDtrading = "<?php echo U('Index/dtrading');?>";			

	urlAddorder = "<?php echo U('Detailed/addorder');?>";			

	urlReset    = "<?php echo U('Index/wap_reset_msg');?>";

	urlproduct  = "<?php echo U('Index/productList');?>";	

</script>

<script type="text/javascript" src="/Public/jsp/foot.js">

</script>
<style>

.al_gs {left:auto;}

</style>

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

<script>
	var phone = "<?php echo ($user["utel"]); ?>";
	if(!phone){
		$('#dialogBg2').show();
		$('#dialog2').show();
	}
	var count   = "<?php echo ($catgood[0]['count']); ?>";
	var width_d = 100/count;
	var cid  	= "<?php echo ($catgood[0]['cid']); ?>";
	var code 	= "<?php echo ($catgood[0]['title']); ?>";
    $(".width_c").css("width",width_d+'%');
	$("#Apicid").val(code);
	var hour = "<?php echo date('H'); ?>";
	var day  = "<?php echo date('w'); ?>";
	var kpan = "<?php echo ($isopen['kpan']); ?>";
	var gpan = "<?php echo ($isopen['gpan']); ?>";
	productList(cid,code);
	if((day == 6 && parseInt(gpan) <= hour) || (day == 0) || (day == 1 && hour <= parseInt(kpan)) || (parseInt(gpan) <= hour && hour <= parseInt(kpan)) || isopen == 2){
		newsdata();
	}else{
		setInterval('newsdata()', 1000);
	}
	get_url(1,code);
	$(".fix_1 li").click(function() {
		var cid=$(this).val();
		var code=$(this).data('type');
		$('.sw_active').removeClass('sw_active');
		$('.width_c_'+cid).addClass('sw_active');
		$("#Apicid").val(code);
		productList(cid,code);
		newsdata();
		get_url(1,code);
	});

	$('.TimeMenu li a').click(function(){
		var code = $('.fix_1 li.sw_active').attr('data-type');
		if($('.TimeMenu li a').attr('data-type') != $(this).attr('data-type') || $(this).attr('data-type')=='area' ){
			$('.TimeMenu li a').removeClass('changed fss');
			$(this).addClass('changed fss');
			get_url(1,code);
		}else{
			interval = $(this).attr('data-interval');
			$('.TimeMenu li a').removeClass('changed');
			$(this).addClass('changed');
			get_url(1,code);
			document.getElementById('chart').contentWindow.changeInterval(interval);
		}
	});

	function get_url(is_iframe,code){
		rows = '45';
		interval = $('.TimeMenu li a.changed').attr('data-interval');
		type = $('.TimeMenu li a.changed').attr('data-type');
		if( !type ){
			type = 'candlestick';
		}
		var url = 'http://'+document.domain+'/index.php/Home/Index/x';
		parameter ={'interval':interval,'type':type,'rows':rows,'code':code};
		parameter_str=""
		for ( var i in parameter){
			parameter_str += '/'+i +'/'+parameter[i];
		}
		parameter_str = parameter_str.substr(1);
		if(is_iframe==1){
			$('.trend-chart').html('Loading...');
			$('.trend-chart').html('<iframe id="chart" class="efc" style="width:96%;overflow: hidden; border:none;height:250px; margin-left:2%;"  scrolling="no" frameborder="0"  src="'+ url +'/'+  parameter_str +'"></iframe>');
		}
	};
	
	function newsdata(){
		var code = $('.fix_1 li.sw_active').attr('data-type');
		var nums = $('.fix_1 li.sw_active').attr('data-id');
		var pai  = nums - 1;
		var str = '';
		$(".proCode").each(function(){
			str += $(this).val()+',';
		})
		$.ajax({  
			type : "post",  
			url  : urlNewdata,
			data : {'code':str},	
			dataType : 'json',
			success: function(data) {
				for(i=0;i<data.length;i++){
					var cid = data[i]['cid'];
					var code  = data[i]['code'];
					var afprice = data[i]['price'];
					var beprice = $(".pricess_"+cid).html();
					var $thi = $('.'+code);
					$thi.html(afprice);
					if(afprice < beprice){
						$thi.css('color','#058c01');
						$thi.css('background',"url(/Public/Home/images/down.png) no-repeat scroll right / 9px 17px");
					}else if(afprice > beprice){
						$thi.css('color','#fe0000');
						$thi.css('background',"url(/Public/Home/images/up.png) no-repeat scroll right / 9px 17px");
					}
				}
				$(".diff").text(data[pai].diff);
				$(".diffrate").text(data[pai].diffRate);
				$('#high').text(data[pai].high);
				$('#open').text(data[pai].open);
				$('#close').text(data[pai].close);
				$('#low').text(data[pai].low);
			}
		})
	};

	function productList(cid,code){
		$.ajax({
			url : urlproduct,
			type: 'post',
			data: 'cid='+cid,
			dataType:'json',
			success:function(json){
				var str = '';
				if(json){
					for(i=0;i<json.length;i++){
						str += '<div class="weipan_deal">';
						str += '<div class="weipan_deal_s">';
						str += '<span class="weipan_deal_z" onclick="';
						str += "mai(1,"+json[i].pid+",'"+code+"'";
						str += ')" >买涨</span>';
						str += '<div class="weipan_deal_cent">';
						str += '<p class="weipan_deal_cent_1">'+json[i].ptitle+' <span>波动盈亏：'+json[i].wave+'元</span></p>';
						str += '<p class="weipan_deal_cent_2">'+json[i].uprice+'元/手</p></div>';
						str += '<span class="weipan_deal_d mai" onclick="';
						str += "mai(2,"+json[i].pid+",'"+code+"'";
						str += ')" >买跌</span>';
						str += '</div>';
						str += '</div>';	
					}
					$("#lunbo").html(str);
				}
			}
		})
	}
</script>

<!--查看交易end  -->  

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
 </div>     
</body>
</html>