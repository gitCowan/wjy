$(function  () {
	//获取短信验证码
	var validCode=true;
	$(".msgs").click (function  () {
		var phone = $("#utel").val();
		var tel = /^1([38]\d|4[57]|5[0-35-9]|7[06-8]|8[89])\d{8}$/;
		if(!tel.test($("#utel").val())){
			alert("手机号输入有误");
			return false;
		}
		$.ajax({  
			type: "post",  
			url: urlReset,
			data:{'phone':phone},  
			dataType:'json', 
			success: function(data) {
				if(data['status'] == '1'){
					$('#code').attr('value',data['code']);
				}else{
					alert(data['code']);
					return false;
				}                
				  
			},  
			error: function(data) {  
				
			}  
		});
		
		var time=100;
		var code=$(this);
		if (validCode) {
			validCode=false;
			code.addClass("msgs1");
			var t = setInterval(function  () {
				time--;
				code.html(time+"秒");
				if (time==0) {
					clearInterval(t);
				code.html("重新获取");
					validCode=true;
				code.removeClass("msgs1");

				}
			},1000)
		}
	});
	
	
	$('.hui').click(function(){
        $('.hui').removeClass('hui_boto');  // 其他的就移除“on”的样式 
        $(this).addClass('hui_boto')   // 点击的时候加上 “on”的样式 
    });
	
	$(".code_tan").click(function(){
		$(".mask").show();	
		$(".tan").show();	
	});
	
	$(".mask").click(function(){
		$(".mask").hide();	
		$(".tan").hide();	
	});
	
	$("#sls").click(function(){
		var juan = $("#isJuan").val();
		if(juan == 1){
		
			$("#sls").attr('readonly','readonly');
			return false;
		}
		$("#sls").removeAttr('readonly');
		$("#sls").val('1');
		var bz  = $("#bz").val();
		var num = $("#sls").val();
		var sxf = $("#sxf").val();
		var shouxu = sxf*num;
		$("#sl").val(num); 
		$('#opprice').html(bz*num);
		$('#j-5').html(shouxu.toFixed(2));
		//金额
        var $jine = $("#jine").val();
		if((bz*num)+shouxu > $jine){
			$('#conform1').attr("type","hidden");
			$('#conform2').css('display','block');
			$("#conform2").html("余额不足，去充值");
		}else{
			$(".conform").attr("type","submit");
			$("#conform2").hide();
		}
	});

	$('#sls').bind('input propertychange', function() { 
		var bz  = $("#bz").val();
		var num = $("#sls").val();
		var sxf = $("#sxf").val();
		var shouxu = sxf*num;
		$("#sl").val(num); 
		$('#opprice').html(bz*num);
		$('#j-5').html(shouxu.toFixed(2));
		//金额
        var $jine = $("#jine").val();
		if(bz*num > $jine){
			$('#conform1').attr("type","hidden");
			$('#conform2').css('display','block');
			$("#conform2").html("余额不足，去充值");
		}else{
			$(".conform").attr("type","submit");
			$("#conform2").hide();
		}
	}); 
	
	$("#claseDialogBtn_1,#claseDialogBtn2").click(function() {
		clearInterval(tt);
		$('#dialog ').css('display','none');
		$('#dialogBg ').css('display','none');
	});
	
	
	
	//建仓数量增
	$('.num-right').click(function(){
		var yu = $("#yu").val();
		var $numValue = parseInt($(this).prev().val());
		var  isJuan   = $("#isJuan").val();
		if(isJuan==1){
		  return  false;
		}
		if($numValue < yu){
			jcqr($numValue+1);
			$(this).prev().val($numValue+1);
		}
	});
	//建仓数量减
	$('.num-left').click(function(){
		var $numValue = parseInt($(this).next().val());
		var  isJuan=$("#isJuan").val();
		if(isJuan==1){
		  return  false;
		}
		if($numValue > 1){
			jcqr($numValue-1);
			$(this).next().val($numValue-1);
		}
	});
	//建仓止盈加
	$('.profit-right').click(function(){
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
	$('.profit-left').click(function(){
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
	
	//建仓止损加
	$('.loss-right').click(function(){
		var $numValue = $(this).prev().val();
		if($numValue == "不设"){
			$numValue = 0;
		}else{
			$numValue = parseInt($numValue);
		}
		if($numValue < 80){
			$(this).prev().val($numValue+10);
		}
	});
	
	//建仓止损减
	$('.loss-left').click(function(){
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
	 *  优惠劵的选择
	 */
	$("#choose").click(function(){
		var  juansl=$("#juansl").val();
	    var  juan=$("#isJuan").val();
	    var   bz=$("#bz").val();
		//手续费
		var  sf=$("#sxf").val();
        //金额
        var  $jine=$("#jine").val();		 
		if(juansl == 0){
	        return false;
	    }
		//使用优惠劵
		if(juan==0){
		    $("#isJuan").val(1);
		    $(".pay").html("<span id='opprice'>0</span>元");
		    $("#j-5").html(0);
		    //体验劵
		    $(".big").html(juansl-1);
			$(".conform").attr("type","submit");			  
		    $(".failure").hide();
			$("#sl").val(1);
			$("#sls").val(1);
			$('#mychoose').css('background','#2c8ff4');
		}else{
			$("#sls").val(1);
			$("#isJuan").val(0);
			$("#sl").val(1);
			$(".pay").html("<span id='opprice'>"+bz+"</span>元");
			$("#j-5").html(sf);
			$(".j-4").html(bz);
			$('#mychoose').css('background','#fff');
			//体验劵
			$(".big").html(juansl);
			if(parseInt(sf)+parseInt(bz)+1>$jine){
				$(".conform").attr("type","hidden");
			    $(".failure").show();		   			   
			}
		    else{
			    $(".conform").attr("type","submit");
			    $(".failure").hide();
			}
		}
	});
	
	$(".conform").click(function(){
		var isopen = $("#isopen").val();
		if((day == 6 && parseInt(gpan) <= hour) || (day == 0) || (day == 1 && hour <= parseInt(kpan)) || (parseInt(gpan) <= hour && hour <= parseInt(kpan)) || isopen == 2){
			$("#msgNum").html('现在是非交易时间.');
			$("#msgNum").show();
			$("#msgNum").fadeOut(2000);
			return false;
		}
		
		//获取要提交的参数
		//数量
		var mysum = $('#sl').val();
		//判断是否达到最大手数
		var yu    = $("#yu").val();
		if(parseInt(mysum) > parseInt(yu)){
			$("#msgNum").show();
			$("#msgNum").fadeOut(2000);
			return false;
		}
		//所用费用
		var myfy=$('#opprice').html();
		var code = $("#codeTilte").val();
		//方向
		var myfx=$('.zhd').html();
		//手续费
		var mysxf=$('#j-5').html();
		//入仓价
		var mygetpeice=$('#price').html();

		if(mygetpeice==0 || mygetpeice==null || !code){  
			alert('当前系统繁忙，请重试');
			return false;
		}
		//体验券值
		var mytyj = $('#isJuan').val();
		//商品id
		var mypid = $('#type').val();
		
		//止盈 
		var endprofit = $('#profit').val();
		if(endprofit == '不设'){
			endprofit = 1;
		}else{
			endprofit = parseInt(endprofit);
		}
		
		//止损
		var endloss = $('#loss').val();
		if(endloss == '不设'){
			endloss = 80;
		}else{
			endloss = parseInt(endloss);
		}
		$(this).unbind('click');
		if(mygetpeice!=''&& mypid!=''){ 
		  //体验卷值
			$.ajax({
				type:'post',
				url:urlAddorder,
				data:{"code":code,"mysum":mysum,"myfy":myfy,"myfx":myfx,"mysxf":mysxf,"mytyj":mytyj,"mypid":mypid,'endprofit':endprofit,'endloss':endloss},
				dataType : 'json',
				success:function(data){
					if(data == '-1'){
						alert('余额不足');
					}else if (data==0) {
						alert('购买失败');
					}else{
						window.location.href=urlDtrading;
					}
				}
			});
		}
    }); 
	
});
var tt;
function mai(but,pid,code){
	tt = setInterval('two_up("'+code+'")',1000);
	//购买
	$('#dialogBg').show(500);
	$('#dialog').show(500);
	if(but == 1){
		but = '买涨';
	}else{
		but = '买跌';
	}
	$('.zhd').html(but);
	$("#profit,#loss").val('不设');
	$("#sls").val(1);
	var jine=$("#jine").val();
	//判断余额是否不足
	var myfy=$('#opprice').html();
	$("#codeTilte").val(code);
	//判断剩余多少手
	$.ajax({
		type:'post',
		url:urlJudgment,
		data:{"mypid":pid,"code":code},
		async:false, 
		success:function(data){
			$("#yu").val(data['yu']);
			$('#price').html(data['prices']);
			$('#dqcid').html(data['cid']);
			$('#opname').html(data['ptitle']); 
			$('#opprice').html(data['uprice']);  
			$('#j-5').html(data['feeprice']);
			$('#c11').html(data['uprice']);  
			$('#big').html(data['sum']);
			//算加减传的值
			$('#bz').val(data['uprice']); 
			$('#sxf').val(data['feeprice']); 
			$('#juansl').val(data['sum']);
			$('#type').val(data['pid']); 
			
			
			var myfy=$('#opprice').html();
			if(Number(jine) < Number(myfy)){
				$('#conform1').attr("type","hidden");
				$('#conform2').css('display','block');
				$("#conform2").html("余额不足，去充值");
			}else{
				$('#conform1').attr("type","button");
				$('#conform2').css('display','none');
			}
			
		}
	});
}


function baocun(){
	var code   = $("#code").val();
	var yzm    = $("#yzm").val();
	var upwd   = $("#upwd").val();
	var phone = $("#utel").val();
	var tel = /^1([38]\d|4[57]|5[0-35-9]|7[06-8]|8[89])\d{8}$/;
	if(!tel.test($("#utel").val())){
		alert("手机号输入有误");
		return false;
	}
	if(code !=''){
		if(code!==yzm){
			alert('验证码错误!'); 
			return false; 
		}
	}else{
		alert('请输入验证码!');
		return false; 			
	}
	if(!upwd){
		alert('登陆密码!');
		return false; 
	}
	$("#jccg").submit();
};


	
function two_up(code){
	$.ajax({  
		type: "post",  
		url: urlSelectid,
		data:"code="+code,  
		async:false,  
		success: function(data) { 
			$('#price').html(data.prices);
		},  
		error: function(data) {  
			
		}  
	});
};





//建仓数字选择
function jcqr(sz){
	var bz    = $("#bz").val();
	var $jine = $("#jine").val();
	var $sf   = $("#sxf").val();  		
	var juan  = $("#isJuan").val();
	var ss    = $sf*sz;
	if(juan == 1){
	   return   false;
	}
	$(".pay").html("<span id='opprice'>"+bz*sz+"</span>元");
	$("#j-5").html(parseFloat(ss.toFixed(2)));
	$("#sl").val(sz);
	if($("#conform3").css("display")=="block"){
		$("#conform2").hide();
	}else{
		if(bz*sz>$jine){
			$(".conform").attr("type","hidden");
			$("#conform2").show();
			$("#conform2").html("余额不足，去充值");
		}
		else{
			$(".conform").attr("type","submit");
			$("#conform2").hide();
		}
	}
};
 //消息的提示
function msg(content){
	$("#msg").show();
	$(".msg").html(content);
	setTimeout('$("#msg").fadeOut()',2000);
};




