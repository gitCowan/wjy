var priceNew  = "";
var orderQtyNew = "";
var secuCodeNew = "";
var stockNameCodeNew = "";

var priceNew2  = "";
var orderQtyNew2 = "";
var secuCodeNew2 = "";
var stockNameCodeNew2 = "";

/**
 * 关闭警示框的method
 */
function closeWarnBoxOne()
{
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});
	popUp.hideLayer($("#warnBoxOne"));
}

/*
关闭委托失败时候的显示框
 */
function closeErrorBoxOne()
{
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});
	popUp.hideLayer($("#panelboxMoneyNew"));
}


function submitBuyStock()
{
	var market = $("#market").val();
	$.post("/t/buy.html", {
		"trdId" : "0B",
		"orderPrice" : priceNew,
		"orderQty" : orderQtyNew,
		"characterTer" : "PC",
		"market" : market,
		"secuCode" : secuCodeNew
	}, function(data) {
		if (data.result)
		{
			//先把原来的显示框消失
			var popUp = null;
			seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
				popUp = popup;
			});
			popUp.hideLayer($('#warnBoxOne'));

			//弹出结果框
			$(".panelboxMoney2 h3").first().html("<i class='icon success' style=''></i>"+"发送委托成功");
			$(".panelboxMoney2 .extra").first().html("股票名称："+stockNameCodeNew+"<br>委托价格："+priceNew+"元<br> 买入数量："+orderQtyNew+"股");
			popUp.showLayer($('.panelboxMoney2').first());
            $('.panelboxMoney2').first().find(".ui-button-blue").first().attr("onclick","hidenAlter24()");
		} else
		{
			var popUp = null;
			seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
				popUp = popup;
			});
			popUp.hideLayer($('#warnBoxOne'));
			//弹出结果框
			$("#panelboxMoneyNew h3").first().html(""+"发送委托失败");
			$("#panelboxMoneyNew .extra").first().html(data.msg);
			popUp.showLayer($('#panelboxMoneyNew'));
		}
	}, "json");
}


/**
 * 卖出的时候的弹框的点击函数
 */
function  submitSellStock()
{

	var market = $("#market").val();
	$.post("/t/buy.html", {
		"trdId" : "0S",
		"orderPrice" : priceNew2,
		"orderQty" : orderQtyNew2,
		"characterTer" : "PC",
		"market" : market,
		"secuCode" : secuCodeNew2
	}, function(data) {
		if (data.result)
		{
			//1:原来的提醒框消失
			//2:结果的展示框打开
			var popUp = null;
			seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
				popUp = popup;
			});
			popUp.hideLayer($('#warnBoxOne'));

			//弹出结果框
			$(".panelboxMoney2 h3").first().html("<i class='icon success' style=''></i>"+"发送委托成功");
			$(".panelboxMoney2 .extra").first().html("股票名称："+stockNameCodeNew2+"<br>委托价格："+priceNew2+"元<br> 委托数量："+orderQtyNew2+"股");

			popUp.showLayer($('.panelboxMoney2').first());
			//cl();
		} else
		{
			var popUp = null;
			seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
				popUp = popup;
			});
			popUp.hideLayer($('#warnBoxOne'));

			//弹出结果框
			$("#panelboxMoneyNew h3").first().html(""+"发送委托失败");
			$("#panelboxMoneyNew .extra").first().html(data.msg);

			popUp.showLayer($('#panelboxMoneyNew'));

		}
	}, "json");
}

/**
 * 买入提交
 */
function upbuy() {
	var secuCode = $("#buyholdCode").val().split("(")[0];
	var price = $("#buyprice").val();
	var orderQty = $("#buynum").val();
	var buyStockRrrorMsg = $(this).parent().parent().parent().find(".buyStockRrrorMsgBox").eq(0);
	var buyStockRrrorMsg2 = $(this).parent().parent().parent().find(".buyStockRrrorMsgBox").eq(1);

	if (!checkMoney(orderQty)) {
		//$("#buynum").val("100");
		buyStockRrrorMsg2.css("display","block");
		buyStockRrrorMsg2.find(".buyStockRrrorMsg").first().text("购买数量只能为整数!");
		return false;
	}
	// 购买数只能为100的倍
	if (parseInt(orderQty) % 100 != 0  || parseInt(orderQty)==0) {
		//$("#buynum").val("100");
		buyStockRrrorMsg2.css("display","block");
		buyStockRrrorMsg2.find(".buyStockRrrorMsg").first().text("购买数量必须为100的倍数!");
		return false;
	}

	if(parseInt(orderQty)>parseInt($("#maxnum").val()))
	{
		buyStockRrrorMsg2.css("display","block");
		buyStockRrrorMsg2.find(".buyStockRrrorMsg").first().text("购买数量大于最大可买数!");
		$("#buynum").addClass("stock-errow-input");
		return false;
	}


	//设置买入价格的错误提示信息
	if(!/^([1-9][\d]{0,100}|0)(\.[\d]{1,2})?$/.test(price.trim()))
	{
		$(".buyStockRrrorMsg").first().html("请输入正确的数值(小数点最多两位)");
		$(".buyStockRrrorMsgBox").first().css("display","block");
		return false;
	}


	//在这里进行委托买入价格的校验price

	var maxBuyPrice = $("#buyMaxPrice").text();
	var minBuyPrice = $("#buyMinPrice").text();
	if(parseFloat(price)<parseFloat(minBuyPrice))
	{
		buyStockRrrorMsg.find(".buyStockRrrorMsg").first().text("委托价格低于跌停价");
		buyStockRrrorMsg.css("display","block");

		return;
	}
	if(price>parseFloat(maxBuyPrice))
	{
		buyStockRrrorMsg.find(".buyStockRrrorMsg").first().text("委托价格高于涨停价");
		buyStockRrrorMsg.css("display","block");
		return;
	}


	//在这里加上确认的弹框
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});


	$("#okBtom2").html("您确定委托买入吗？");

	stockNameCodeNew = $("#buyholdCode").val();
	var  okMsgBuy = "<span>股票名称："+$("#buyholdCode").val()+"</span><br/>";
	okMsgBuy+= "<span>委托价格："+ $("#buyprice").val()+"元</span><br/>";
	okMsgBuy+= "<span>委托数量："+$("#buynum").val() +"股</span>";

	priceNew  = $("#buyprice").val();
	orderQtyNew = $("#buynum").val();
	secuCodeNew = $("#buyholdCode").val();

	$("#okMsgBuy2").html(okMsgBuy);

    //$('#pbox').css("display","none");
    popUp.hideLayer( $('#pbox'));
    $("#submitBbNew").attr("onclick","submitBuyStock()");
    $("#submitBbNew").attr("clstag","jr|keycount|gupiao_jiaoyi|mr_qdwt");
	popUp.showLayer($('#warnBoxOne'));





	//return true;
}
/**
 * 卖出提交
 */
function upsell()
{
	//在这里进行数据校验
	var sellPrice = $("#sellpr").val();
	var minSellPrice  = $("#sellMinPrice").text();
	var maxSellPrice =  $("#sellMaxPrice").text();
    var sellnum = $("#sellnum").val();
	var maxSellnum = $("#shareAvl").val();

	if(parseFloat(sellPrice) < parseFloat(minSellPrice))
	{
		$(".sellStockRrrorMsg").eq(0).text("委托价格低于跌停价");
		$(".sellStockRrrorMsgBox").eq(0).css("display","block");
		return false;
	}
	if(parseFloat(sellPrice) > parseFloat(maxSellPrice))
	{
		$(".sellStockRrrorMsg").eq(0).text("委托价格高于涨停价");
		$(".sellStockRrrorMsgBox").eq(0).css("display","block");

		return false;
	}
	//关于价格的格式的提示

	if (!/^([1-9][\d]{0,100}|0)(\.[\d]{1,2})?$/.test(sellPrice.trim()))
	{
		$(".sellStockRrrorMsgBox").eq(0).css("display","block")
		$(".sellStockRrrorMsg").eq(0).text("卖出价格格式不对!");
		return false;
	}
	$(".sellStockRrrorMsgBox").eq(0).css("display","none");

	if (!/^[1-9]*[1-9][0-9]*$/.test(sellnum))//卖出数量 整数
	{
		$(".sellStockRrrorMsgBox").eq(1).css("display","block")
		$(".sellStockRrrorMsg").eq(1).text("卖出数量格式不对!");
		return false;
	}

	//关于卖出数量的校验====>不可以大于最大可卖数量
	if(parseInt(maxSellnum) < parseInt(sellnum) )
	{
		$(".sellStockRrrorMsgBox").eq(1).css("display","block")
		$(".sellStockRrrorMsg").eq(1).text("卖出数量大于最大可卖数!");
		return false;
	}

	$(".sellStockRrrorMsgBox").eq(1).css("display","none")


	//在这里加上确认的弹框
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});


	$("#okBtom2").html("您确定委托卖出吗？");

	stockNameCodeNew2 = $("#sellholdCode").val();
	var  okMsgBuy = "<span>股票名称："+$("#sellholdCode").val()+"</span><br/>";
	okMsgBuy+= "<span>委托价格："+ $("#sellpr").val()+"元</span><br/>";
	okMsgBuy+= "<span>委托数量："+$("#sellnum").val() +"股</span>";

	priceNew2  = $("#sellpr").val();
	orderQtyNew2 = $("#sellnum").val();
	secuCodeNew2 = $("#sellholdCode").val();

    popUp.hideLayer( $('#pbox'));
    popUp.showLayer($('#warnBoxOne'));

	$("#okMsgBuy2").html(okMsgBuy);
	$("#submitBbNew").attr("onclick","submitSellStock()");
	$("#submitBbNew").attr("clstag","jr|keycount|gupiao_jiaoyi|mc_qdwt");

	return ;

}

function closeWaringBoxForAll()
{
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});
	popUp.hideLayer($('.waringBoxForAll').first())
}
/**
 * 买入层弹出并加载事件
 */
function buy(id, market) {
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});

	//seajs.use('//static.360buyimg.com/finance/common/unit/login/1.0.0/login.js', function (login) {
	//	login(function () {
	//		//暂时注释掉
	//	});
	//	});
		$.post("/t/cklg", {}, function(data) {
			if (!data.result)
			{
				//没有登录券商,弹出登陆框
				popUp.showLayer($('#loginLayer'));
				return;
			} else {
				$.post("/t/querystock", {
					"trdid" : "0B",
					"secuCode" : id,
					"market" : market
				}, function(data) {
					// 先清空再说
					$("#pbox").html("");
					$("#pbox").html(data);
					// 切换
					$(".panel-title").children("li").click(function() {
						var index = $(this).index();
						$(this).addClass("curr").siblings().removeClass("curr");
						$("div.panel-trade").hide();
						$("div.panel-trade").eq(index).show();
					});
					popUp.showLayer($('#pbox'));
					tradecode=id;
					setInterval(reffivedata,3000);
				});
			}
		}, "json");


}
/**
 * 卖出层弹出并加载事件
 */
function sell(id, market) {
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});

	$.post("/t/cklg", {}, function(data) {
		if (!data.result)
		{
			popUp.showLayer($('#loginLayer'));
			return;
		} else {
			$.post("/t/querystock", {
				"trdid" : "0S",
				"secuCode" : id,
				"market" : market
			}, function(data) {
				// 添加弹出页面内容
				// 先清空再说
				$("#pbox").html("");
				$("#pbox").html(data);
				// 为弹出的页面增加切换
				$(".panel-title").children("li").click(function() {
					var index = $(this).index();
					$(this).addClass("curr").siblings().removeClass("curr");
					$("div.panel-trade").hide();
					$("div.panel-trade").eq(index).show();
				});
				// 添加弹出组件
				popUp.showLayer($('#pbox'));
				tradecode = id;
				setInterval(reffivedata,3000);

			});
		}
	}, "json");
}

/**
 * 验证金额（可验证 大于等于零，小于等于99999999.99 的数字）
 * 
 * @param obj
 * @returns {Boolean}
 */
function checkMoney(obj) {
	obj = obj.trim();
	if (/^([1-9][\d]{0,}|0)(\.[\d]{1,2})?$/.test(obj)) {
		return true;
	} else {
		return false;
	}
}

/**
 * 校验银行密码
 */
function checkExtAccPwd(extAccPwd)
{
	if(extAccPwd.trim()=="")
	{
		return false;
	}else
	{
		if(/^\d{6}$/.test(extAccPwd))
		{
			return true;
		}else
		{
			return false;
		}
	}
}

/**
 * 校验资金密码
 */
function checkAccPwd(accPwd)
{
	if(accPwd.trim()=="")
	{
		return false;
	}else
	{
		return true;
	}



}


/**
 * 检查转出资金的大小
 * @param obj
 * @returns {boolean}
 */
function checkMoney2(obj)
{
	var avalMoney = $("#avalMoney").text();
	if(parseInt(avalMoney)<obj )
	{
		return false;
	}else
	{
		return true;
	}
}


/**
 * 显示银证转账页面
 */
function showbankroll(tp) {
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});
	$.post("/t/cklg", {}, function(data) {
		if (!data.result)
        {
            //换成经典弹框
            $("#warningForbankH3").html("无法进行转账");
            $("#warningForbankextra").html(data.msg);
            popUp.showLayer($("#warningForbank"));
			return;
		} else {
			$.post("/t/showbankroll", {
				"tp" : tp
			}, function(data) {
				// 添加弹出页面内容
				// 先清空再说
				$("#pbox").html("");
				$("#pbox").html(data);
				// 为弹出的页面增加切换
				$(".panel-title").children("li").click(function() {
					var index = $(this).index();
					$(this).addClass("curr").siblings().removeClass("curr");
					$("ul.trade-details").hide();
					$("ul.trade-details").eq(index).show();
				});
				// 添加弹出组件


                var banktail = $("#weihaobkk").text();
                if(banktail == "nobanknum")
                {
                    popUp.showLayer($("#nobanknum"));
                }else
                {
                    popUp.showLayer($('#pbox'));
                }
			});
		}
	}, "json");
}

function hidenNoLogin()
{
    var popUp = null;
    seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
        popUp = popup;
    });
    popUp.hideLayer($('#warningForbank'));
}
// 关闭银证弹出层
function cl()
{
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});
	popUp.hideLayer($('#pbox'));
}
/**
 * 转入 ：银行转至券商
 */
function bktotd() {
	var cptlAmt = $("#cptlAmt").val();
	var extAccPwd = $("#extAccPwd").val();// 银行密码
	var accPwd =$("#accPwd1").val();// 账户资金密码
	var extInst = $("#extInst").val();
	var outMoneyErrorMsgOne = $(this).parent().parent().parent().find(".outMoneyErrorMsgOne").first();
    var popUp = null;
    seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
        popUp = popup;
    });

	if (!checkMoney(cptlAmt) )
	{
		$(this).parent().parent().parent().find(".outMoneyErrorMsgOne").first().css("display","block");
		$(this).parent().parent().parent().find(".outMoneyErrorMsgOneContent").first().text("转入金额必须为数字!");

		$("#cptlAmt").addClass("stock-errow-input");
		return;
	}
	$(this).parent().parent().parent().find(".outMoneyErrorMsgOne").first().css("display","none");
	$("#cptlAmt").removeClass("stock-errow-input");

	//校验资金密码
	if(!checkAccPwd(accPwd) && !($("#accPwd1").parent().parent().css("display")=="none"))
	{
		$(this).parent().parent().parent().find(".bktotdIsAccPwd").first().css("display","block");
		$(this).parent().parent().parent().find(".bktotdIsAccPwdContent").first().text("资金密码不可以为空!");

		$("#accPwd1").addClass("stock-errow-input");
		return;
	}
	$(this).parent().parent().parent().find(".bktotdIsAccPwd").first().css("display","none");
	$("#accPwd1").removeClass("stock-errow-input");

	// 校验银行密码
	if(!checkExtAccPwd(extAccPwd) && !($("#extAccPwd").parent().parent().css("display")=="none") )
	{
		$(this).parent().parent().parent().find(".bktotdIsextAccPwd").first().css("display","block");
		$(this).parent().parent().parent().find(".bktotdIsextAccPwdContent").first().text("银行密码不为空且为六位数字!");

		$("#extAccPwd").addClass("stock-errow-input");
		return;
	}
	$(this).parent().parent().parent().find(".bktotdIsextAccPwd").first().css("display","none");
	$("#extAccPwd").removeClass("stock-errow-input");

	$.post("/t/bktotd", {
		"cptlAmt" : cptlAmt,
		"extAccPwd" : extAccPwd,
		"extInst" : extInst,
		"accPwd" :accPwd
	}, function(data)
	{
		if (data.result)
		{

			if(data.status)
			{
				outMoneyErrorMsgOne.css("display","none");
				var moneyNum = data.msg;//成功转入"+cptlAmt+"元
				var opeBank = "操作银行："+$("#hiddenBankname").val()+"("+$(".tail-number").first().text()+")<br/>转入金额：" +cptlAmt+"元";

				$("#panelboxMoney22").find("h3").first().html("<i class='icon success' style=''></i>"+moneyNum);
				$("#panelboxMoney22").find(".extra").first().html(opeBank);

				popUp.hideLayer($("#pbox"));
				popUp.showLayer($("#panelboxMoney22"));
			}else
			{
				outMoneyErrorMsgOne.css("display","none");
				var moneyNum = "成功转入"+cptlAmt+"元";
				var opeBank = "操作银行："+$("#hiddenBankname").val()+"("+$(".tail-number").first().text()+")<br/>转入时间：" +getDateNow();

				$("#panelboxMoney22").find("h3").first().html("<i class='icon success' style=''></i>"+moneyNum);
				$("#panelboxMoney22").find(".extra").first().html(opeBank);

				popUp.hideLayer($("#pbox"));
				popUp.showLayer($("#panelboxMoney22"));
			}


		} else
		{
			//根据返回代码来优化前端显示
			$(".panelboxMoney8 .font-red").first().text(data.msg);
			$(".panelboxMoney8 .failed").first().text("抱歉！资金转入失败");
			//$(".panelboxMoney").first().css("display","block");

            popUp.hideLayer($("#pbox"));
            popUp.showLayer($(".panelboxMoney8").first());

		}
	}, "json");

}
/**
 * 券商转银行--转出
 */
function tdtobk() {

    var popUp = null;
    seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
        popUp = popup;
    });


    var cptlAmt = $("#outAmt").val();
	var accPwd = $("#accPwd").val();
	var extInst = $("#extInst").val();
	var extAccPwd = $("#extAccPwd2").val();
	var outMoneyErrorMsgOne =  $(this).parent().parent().parent().find(".outMoneyErrorMsgOne").first();
	if (!checkMoney(cptlAmt)) {
		$("#outAmt").val("1");

		$(this).parent().parent().parent().find(".outMoneyErrorMsgOne").first().css("display","block");
		$(this).parent().parent().parent().find(".outMoneyErrorMsgOneContent").first().text("转出金额必须为数字!");
		$("#outAmt").addClass("stock-errow-input");
		return;
	}
    $(this).parent().parent().parent().find(".outMoneyErrorMsgOne").first().css("display","none");
	$("#outAmt").removeClass("stock-errow-input");

	//校验资金密码
	if(!checkAccPwd(accPwd))
	{
		$(this).parent().parent().parent().find(".tdtobkIsAccPwdOne").first().css("display","block");
		$(this).parent().parent().parent().find(".tdtobkIsAccPwdOneContent").first().text("资金密码不可以为空!");

		$("#accPwd").addClass("stock-errow-input");
		return;
	}
	$(this).parent().parent().parent().find(".tdtobkIsAccPwdOne").first().css("display","none");
	$("#accPwd").removeClass("stock-errow-input");

	if(!checkMoney2(cptlAmt))
	{
		//修改为弹框
		$(this).parent().parent().parent().find(".outMoneyErrorMsgOne").first().css("display","block");
		$(this).parent().parent().parent().find(".outMoneyErrorMsgOneContent").first().text("可转资金不足!");
		$("#outAmt").addClass("stock-errow-input");

		return;
	}
    $(this).parent().parent().parent().find(".outMoneyErrorMsgOne").first().css("display","none");
	$("#outAmt").removeClass("stock-errow-input");

	//校验资金密码
	//if(accPwd==''|| accPwd==null)
	//{
	//	$("#accPwd").css("border","1px solid red").css("color","red");
	//	$(".msgAlertPwd").first().text("*请输入资金密码！")
	//	return false;
	//}

	$.post("/t/tdtobk", {
		"cptlAmt" : cptlAmt,
		"accPwd" : accPwd,
		"extInst" : extInst,
		"extAccPwd" : extAccPwd
	}, function(data) {

		if (data.result)
		{
			if(data.status)
			{
				var moneyNum = data.msg;
				var opeBank = "转入银行："+$("#hiddenBankname").val()+"("+$(".tail-number").first().text()+")<br/>转入金额：" +cptlAmt+"元";
				$(".panelboxMoney22 h3").first().html("<i class='icon success' ></i>"+moneyNum);
				$(".panelboxMoney22 .extra").first().html(opeBank);

				popUp.hideLayer($("#pbox"));
				popUp.showLayer($(".panelboxMoney22").first());
			}else
			{
				var moneyNum = "成功转出"+cptlAmt+"元";
				var opeBank = "转入银行："+$("#hiddenBankname").val()+"("+$(".tail-number").first().text()+")<br/>转出时间：" +getDateNow();
				$(".panelboxMoney22 h3").first().html("<i class='icon success' ></i>"+moneyNum);
				$(".panelboxMoney22 .extra").first().html(opeBank);

				popUp.hideLayer($("#pbox"));
				popUp.showLayer($(".panelboxMoney22").first());
			}
		} else
		{
			//outMoneyErrorMsgOne.css("display","none");
			$(".panelboxMoney8 .font-red").first().text(data.msg);
			$(".panelboxMoney8 .failed").first().text("抱歉！资金转出失败");

            popUp.hideLayer($("#pbox"));
            popUp.showLayer($(".panelboxMoney8").first());
			//$(".panelboxMoney8").first().css("display","block");
		}
	}, "json");

}
function hidenAlter()
{
    var popUp = null;
    seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
        popUp = popup;
    });
    popUp.hideLayer($('.panelboxMoney8').first());

	cl();
}

function hiddenNoBank()
{
    var popUp = null;
    seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
        popUp = popup;
    });
    popUp.hideLayer($('#nobanknum'));
}
/**
 * 买买股票时候的警告框的消失函数
 */
function hiddenBuyStockRrrorMsgBox()
{
	$(this).parent().css("display","none");
}
/*
卖出时候失败的警告框的消失
 */
function hidenAlter4()
{
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});
	popUp.hideLayer($('#panelboxMoneyNew'));
}
function hidenAlter24()
{
    var popUp = null;
    seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
        popUp = popup;
    });
    popUp.hideLayer($('#panelboxMoney22'));

    popUp.hideLayer($('.panelboxMoney2').first());
}
//刷新转账后资金的信息
function hidenAlter2()
{
    var popUp = null;
    seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
        popUp = popup;
    });
    popUp.hideLayer($('#panelboxMoney22'));

    popUp.hideLayer($('.panelboxMoney2').first());



	//点击资金流水的栏目，让用户查看
	//再次刷新资金情况
   if(!$(".toShowResult").first().hasClass("curr")) //之前不是资金流水页面
   {
	   $(".toShowResult").first().click();
	   reloadShowMoney();
   }else//之前已经是资金流水页面，实现再次点击
   {
	   var target = $(".toShowResult").first();
	   var _this = target;
	   _this.addClass("curr").siblings().removeClass("curr");
	   $("div.holding-tab-con").hide();
	   $("div.holding-tab-con").eq(4).show();
	   var to = _this.attr("to");
	   loadTradeHistoryList( to );//流水记录
	   reloadShowMoney();
   }
}

/**
 * 买入成功之后的弹出框消失函数
 */
function hidenAlter3()
{
	var popUp = null;
	seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function(popup) {
		popUp = popup;
	});
	popUp.hideLayer($('.panelboxMoney2').first());
}

function reloadShowMoney()
{
	$.ajax({
		type:'get',
		dataType: 'json',
		url:'/t/reloadShowMoney',
		success: function (msg) {
			if(msg.success)
			{
				$("#money1").text(msg.data.money1);
				$("#money2").text(msg.data.money2);
                $("#money3").text(msg.data.money3);
			}
		}
	});
}



function getDateNow()
{
	var day  = new Date();
	var year =  day.getFullYear();
	var mon = day.getMonth()+1;
	var day2 =  day.getDate();
	var hou =  day.getHours();
	var min =  day.getMinutes();
	if(parseInt(min)<10)
	{
		min="0"+min;
	}
	var re = year +"-"+mon+"-"+day2+" "+hou+":"+min;
	return re;
}

//增加买入价格
function addbuyprice() {
	var buyprice = $("#buyprice").val();
	// checkMoney 判断是不是数字
	if(!checkMoney(buyprice))
	{
		$("#buyprice").val("0.00")
		//隐藏之前的提示框
		$(".buyStockRrrorMsgBox").eq(0).css("display","none");
		$("#buyprice").removeClass("stock-errow-input");
		return false;
	}
	buyprice = (buyprice == null || buyprice == '') ? "0.00" : buyprice;
	$("#buyprice").val((parseFloat(buyprice) + 0.01).toFixed(2));
}

function minusbuyprice() {
	var buyprice = $("#buyprice").val();
	// checkMoney 判断是不是数字
	if(!checkMoney(buyprice))
	{
		$("#buyprice").val("0.00")
		//隐藏之前的提示框
		$(".buyStockRrrorMsgBox").eq(0).css("display","none");
		$("#buyprice").removeClass("stock-errow-input");

		return false;
	}
	buyprice = (buyprice == null || buyprice == '') ? "0.00" : buyprice;
	$("#buyprice").val(
			(parseFloat(buyprice) - 0.01) < 0 ? 0
					: (parseFloat(buyprice) - 0.01).toFixed(2));
}

//买入数量的变化的js
function minusbuynum() {
	var buynum = $("#buynum").val();
	//判断是不是数字
	if((!/^[0-9]*[1-9][0-9]*$/.test(buynum)))
	{
		$("#buynum").val("0");

		$("#buynum").removeClass("stock-errow-input");
		$(".buyStockRrrorMsgBox").eq(1).css("display","none");
		return false;
	}
	buynum = (buynum != null && buynum != "") ? buynum : "0";
	if (buynum % 100 != 0) {
		buynum = parseInt(buynum / 100) * 100;
	}
	$("#buynum").val(
			(parseInt(buynum) - 100 < 0) ? 0 : (parseInt(buynum) - 100));
}

function addbuynum() {
	var maxnum = $("#maxnum").val();//最大量
	var buynum = $("#buynum").val();//买入

	//判断是不是数字
	if((!/^[0-9]*[1-9][0-9]*$/.test(buynum)))
	{
		$("#buynum").val("100");
		$("#buynum").removeClass("stock-errow-input");
		$(".buyStockRrrorMsgBox").eq(1).css("display","none");
		return false;
	}

	buynum = (buynum != null && buynum != "") ? buynum : "0";
	if (buynum % 100 != 0) {
		buynum = parseInt(buynum / 100) * 100;
	}
	$("#buynum").val(
			(parseInt(buynum) + 100) > maxnum ? maxnum
					: (parseInt(buynum) + 100));
}
function minussellpr() {
	var sellpr = $("#sellpr").val();
	if(!checkMoney(sellpr))
	{
		$("#sellpr").val("0.00");


		return false;
	}

	sellpr = (sellpr != null && sellpr != "") ? sellpr : "0.00";
	$("#sellpr").val(
			(parseFloat(sellpr) - 0.01) < 0 ? 0 : (parseFloat(sellpr) - 0.01)
					.toFixed(2));
}
function addsellpr() {
	var sellpr = $("#sellpr").val();

	if(!checkMoney(sellpr))
	{
		$("#sellpr").val("0.00");
		$("#sellpr").removeClass("stock-errow-input");
		$(".sellStockRrrorMsgBox").eq(0).css("display","none");

		return false;
	}
	sellpr = (sellpr != null && sellpr != "") ? sellpr : "0.00";
	$("#sellpr").val((parseFloat(sellpr) + 0.01).toFixed(2));
}
function minussellnum() {
	var sellnum = $("#sellnum").val();

	if((!/^[0-9]*[1-9][0-9]*$/.test(sellnum)))
	{
		$("#sellnum").val("0");
		$("#sellnum").removeClass("stock-errow-input");
		$(".sellStockRrrorMsgBox").eq(1).css("display","none");

		return false;
	}

	sellnum = (sellnum != null && sellnum != "") ? sellnum : "0";
	$("#sellnum").val(
			(parseInt(sellnum) - 100 < 0) ? 0 : (parseInt(sellnum) - 100));
}
//可卖数量的点击增加函数
function addsellnum() {
	var shareAvl = $("#shareAvl").val();
	var sellnum =$("#sellnum").val() ;

	if((!/^[1-9]*[1-9][0-9]*$/.test(sellnum)))
	{
		$("#sellnum").val("100");
		$("#sellnum").removeClass("stock-errow-input");
		$(".sellStockRrrorMsgBox").eq(1).css("display","none");
		return false;
	}
	sellnum = (sellnum != null && sellnum != "") ? sellnum : "0";
	$("#sellnum").val(
			(parseInt(sellnum) + 100) > shareAvl ? shareAvl
					: (parseInt(sellnum) + 100));
}

$(document).on("click", "input[name='bn']", function() {
	var context = $(this).val();
	if (context == '1/2') {
		var num = parseInt($("#maxnum").val() / 2);
		var vl = parseInt(num / 100) * 100;
		$("#buynum").val(vl);
	} else if (context == '1/3') {
		var num = parseInt($("#maxnum").val() / 3);
		var vl = parseInt(num / 100) * 100;
		$("#buynum").val(vl);
	} else {
		var num = parseInt($("#maxnum").val());
		var vl = parseInt(num / 100) * 100;
		$("#buynum").val(vl);
	}
});
$(document).on("click", "input[name='mc']", function() {
	var context = $(this).val();
	if (context == '1/2') {
		var num = parseInt($("#shareAvl").val() / 2);
		$("#sellnum").val(num);
	} else if (context == '1/3') {
		var num = parseInt($("#shareAvl").val() / 3);
		$("#sellnum").val(num);
	} else {
		var num = parseInt($("#shareAvl").val());
		$("#sellnum").val(num);
	}
});

//买入和卖出的blur事件
$(document).on("blur","#buyprice",function(){
	var maxBuyPrice = $("#buyMaxPrice").text();
	var minBuyPrice = $("#buyMinPrice").text();
	var vv = $("#buyprice").val();
	if(parseFloat(vv)<parseFloat(minBuyPrice))
	{
		$(".buyStockRrrorMsg").first().text("委托价格低于跌停价");
		$(".buyStockRrrorMsgBox").first().css("display","block");
		$("#buyprice").addClass("stock-errow-input");
		return ;
	}
	if(vv>parseFloat(maxBuyPrice))
	{
		$(".buyStockRrrorMsg").first().text("委托价格高于涨停价");
		$(".buyStockRrrorMsgBox").first().css("display","block");
		$("#buyprice").addClass("stock-errow-input");
		return ;
	}

	if(!/^([1-9][\d]{0,100}|0)(\.[\d]{1,2})?$/.test(vv.trim()))
	{
		$(".buyStockRrrorMsg").first().html("请输入正确的数值(小数点最多两位)");
		$(".buyStockRrrorMsgBox").first().css("display","block");
		$("#buyprice").addClass("stock-errow-input");
		return ;
	}

	$(".buyStockRrrorMsgBox").first().css("display","none");
	$("#buyprice").removeClass("stock-errow-input");
});

//买入数量失去焦点
$(document).on("blur","#buynum",function()
{
	 var buynum = $("#buynum").val();
	if (!checkMoney(buynum)) {
		$(this).parent().parent().find(".buyStockRrrorMsgBox").first().css("display","block");
		$(this).parent().parent().find(".buyStockRrrorMsg").first().text("购买数量只能为整数!");
		$("#buynum").addClass("stock-errow-input");
		return false;
	}
	// 购买数只能为100的倍
	if (parseInt(buynum) % 100 != 0  || parseInt(buynum)==0) {
		$(this).parent().parent().find(".buyStockRrrorMsgBox").first().css("display","block");
		$(this).parent().parent().find(".buyStockRrrorMsg").first().text("购买数量必须为100的倍数!");
		$("#buynum").addClass("stock-errow-input");
		return false;
	}
	//大于最大的购买数量
	if(parseInt(buynum)>parseInt($("#maxnum").val()))
	{
		$(this).parent().parent().find(".buyStockRrrorMsgBox").first().css("display","block");
		$(this).parent().parent().find(".buyStockRrrorMsg").first().text("购买数量大于最大可买数！");
		$("#buynum").addClass("stock-errow-input");
		return false;
	}
	$(this).parent().parent().find(".buyStockRrrorMsgBox").first().css("display","none");
	$("#buynum").removeClass("stock-errow-input");
});
$(document).on("blur","#sellpr",function(){
	var sellMaxPrice = $("#sellMaxPrice").text();
	var sellMinPrice = $("#sellMinPrice").text();
	var vv = $("#sellpr").val();
	if(parseFloat(vv)<parseFloat(sellMinPrice))
	{
		$(".sellStockRrrorMsg").first().text("委托价格低于跌停价");
		$(".sellStockRrrorMsgBox").first().css("display","block");
		$("#sellpr").addClass("stock-errow-input");
		return ;
	}
	if(vv>parseFloat(sellMaxPrice))
	{
		$(".sellStockRrrorMsg").first().text("委托价格高于涨停价");
		$(".sellStockRrrorMsgBox").first().css("display","block");
		$("#sellpr").addClass("stock-errow-input");
		return ;
	}

	if(!/^([1-9][\d]{0,100}|0)(\.[\d]{1,2})?$/.test(vv.trim()))
	{
		$(".sellStockRrrorMsg").first().html("请输入正确的数值(小数点最多两位)");
		$(".sellStockRrrorMsgBox").first().css("display","block");
		$("#sellpr").addClass("stock-errow-input");
		return ;
	}
	$(".sellStockRrrorMsgBox").first().css("display","none");

	$("#sellpr").removeClass("stock-errow-input");
});

//卖出数量的失去焦点事件
$(document).on("blur","#sellnum",function(){
	var sellnum = $("#sellnum").val();

	if (!/^[0-9]*[1-9][0-9]*$/.test(sellnum))
	{
		$(".sellStockRrrorMsgBox").eq(1).css("display","block")
		$(".sellStockRrrorMsg").eq(1).text("卖出数量格式不对!");
		$("#sellnum").addClass("stock-errow-input");
		return false;
	}


	if (parseInt($("#shareAvl").val()) < parseInt(sellnum) )
	{
		$(".sellStockRrrorMsgBox").eq(1).css("display","block")
		$(".sellStockRrrorMsg").eq(1).text("卖出数量大于最大可卖数!");
		$("#sellnum").addClass("stock-errow-input");
		return false;
	}


	$(".sellStockRrrorMsgBox").eq(1).css("display","none")
	$("#sellnum").removeClass("stock-errow-input");


});


$(document).on("blur","#cptlAmt",function(){
	//检查转入资金
	var vv=  $("#cptlAmt").val();
	if(!checkMoney(vv))
	{
		$("#cptlAmt").parent().parent().find(".outMoneyErrorMsgOne").first().css("display","block");
		$("#cptlAmt").parent().parent().find(".outMoneyErrorMsgOneContent").first().text("转入金额必须为数字!");
		$("#cptlAmt").addClass("stock-errow-input");
	}else
	{
		$("#cptlAmt").parent().parent().find(".outMoneyErrorMsgOne").first().css("display","none");
		$("#cptlAmt").removeClass("stock-errow-input");
	}
});

$(document).on("blur","#outAmt",function(){
	//检查转出资金
	var vv=  $("#outAmt").val();
	if(!checkMoney(vv))
	{
		$("#outAmt").parent().parent().find(".outMoneyErrorMsgOne").first().css("display","block");
		$("#outAmt").parent().parent().find(".outMoneyErrorMsgOneContent").first().text("转出金额必须为数字!");
		$("#outAmt").addClass("stock-errow-input");
	}else
	{
		$("#outAmt").parent().parent().find(".outMoneyErrorMsgOne").first().css("display","none");
		$("#outAmt").removeClass("stock-errow-input");
	}
});



$(document).on("blur","#accPwd",function(){
	//检查转出资金密码
	var vv=  $("#accPwd").val();
	if(!checkAccPwd(vv))
	{
		$("#accPwd").parent().parent().find(".tdtobkIsAccPwdOne").first().css("display","block");
		$("#accPwd").parent().parent().find(".tdtobkIsAccPwdOneContent").first().text("资金密码不可以为空!");
		$("#accPwd").addClass("stock-errow-input");
	}else
	{
		$("#accPwd").parent().parent().find(".tdtobkIsAccPwdOne").first().css("display","none");
		$("#accPwd").removeClass("stock-errow-input");
	}
});



//资金密码  转入的时候
$(document).on("blur","#accPwd1",function(){
	var vv=  $("#accPwd1").val();
	if(!checkAccPwd(vv))
	{
		$("#accPwd1").parent().parent().find(".bktotdIsAccPwd").first().css("display","block");
		$("#accPwd1").parent().parent().find(".bktotdIsAccPwdContent").first().text("资金密码不可以为空!");
		$("#accPwd1").addClass("stock-errow-input");
	}else
	{
		$("#accPwd1").parent().parent().find(".bktotdIsAccPwd").first().css("display","none");
		$("#accPwd1").removeClass("stock-errow-input");
	}
});
//检查银行密码  主要判断六位数字和空
$(document).on("blur","#extAccPwd",function(){
	var vv=  $("#extAccPwd").val();
	if(!checkExtAccPwd(vv))
	{
		$("#extAccPwd").parent().parent().find(".bktotdIsextAccPwd").first().css("display","block");
		$("#extAccPwd").parent().parent().find(".bktotdIsextAccPwdContent").first().text("银行密码不可以为空,且为六位数字!");
		$("#extAccPwd").addClass("stock-errow-input");
	}else
	{
		$("#extAccPwd").parent().parent().find(".bktotdIsextAccPwd").first().css("display","none");
		$("#extAccPwd").removeClass("stock-errow-input");
	}
});





// 数字的控制
$(document).on(
		"change",
		"#buynum,#buyprice,#sellpr,#sellnum",
		function() {
			var content = $(this).val();
			var id = $(this).attr("id");
			var currentBuy = $("#currentBuy").val();
			var currentSold = $("#currentSold").val();
			if (!/^([1-9][\d]{0,100}|0)(\.[\d]{1,2})?$/.test(content))
			{
				if (id == 'buyprice')
				{
					//$(this).val(
					//		(currentBuy == null || currentBuy == '') ? '0.01'
					//				: parseFloat(currentBuy).toFixed(2));



				} else if (id == 'sellpr')
				{
					//$(this).val(
					//		(currentSold == null || currentSold == '') ? '0.01'
					//				: parseFloat(currentSold).toFixed(2));

					//卖出价格
					//$(".sellStockRrrorMsgBox").eq(0).css("display","block")
					//$(".sellStockRrrorMsg").eq(0).text("卖出价格格式不对!");



				} else if (id == "buynum")
				{
					//var num = parseInt($("#maxnum").val());
					//var vl = parseInt(num / 100) * 100;
					//$(this).val(vl);
					//
					//$(".buyStockRrrorMsgBox").eq(1).css("display","block");
					//$(".buyStockRrrorMsg").eq(1).test("买入数量必须为数字");

				} else if (id == "sellnum") {
					//var num = parseInt($("#shareAvl").val());
					//$(this).val(num);

					//卖出数量校验
					//$(".sellStockRrrorMsgBox").eq(1).css("display","block")
					//$(".sellStockRrrorMsg").eq(1).text("卖出数量格式不对!");



				}

			}
		});
var tradecode = "";
//定时刷新指数数据
var reffivedata = function reffivedata(tradecode) {
	var code = tradecode;
	if(code!=null&&code!=''){
		    $.get(
		        "/t/getfivedata",
		        {"code":code},
		        function (data) {
		        	if(data!=null&&data!=""){
		        		$("div.panel-trade").find(".list").find("tr").each(function(obj){
		        			var firsttd = $(this).find("td").first().html();
		        			var t = "0.00";
		        			var s = "0";
		        			if(firsttd=='卖5'){
		        				 t =   typeof(data.applySoldPri5) == "undefined"?0.00:data.applySoldPri5;
		        				 s =   typeof(data.applySoldVol5) == "undefined"?0:data.applySoldVol5;
		        			}else if(firsttd=='卖4'){
		        				 t =   typeof(data.applySoldPri4) == "undefined"?0.00:data.applySoldPri4;
		        				 s =   typeof(data.applySoldVol4) == "undefined"?0:data.applySoldVol4;
		        			}else if(firsttd=='卖3'){
		        				 t =   typeof(data.applySoldPri3) == "undefined"?0.00:data.applySoldPri3;
		        				 s =   typeof(data.applySoldVol3) == "undefined"?0:data.applySoldVol3;
		        			}else if(firsttd=='卖2'){
		        				 t =   typeof(data.applySoldPri2) == "undefined"?0.00:data.applySoldPri2;
		        				 s =   typeof(data.applySoldVol2) == "undefined"?0:data.applySoldVol2;
		        			}else if(firsttd=='卖1'){
		        				 t =   typeof(data.currentSold) == "undefined"?0.00:data.currentSold;
		        				 s =   typeof(data.applySoldVol1) == "undefined"?0:data.applySoldVol1;
		        			}else if(firsttd=='买1'){
		        				 t =   typeof(data.currentBuy) == "undefined"?0.00:data.currentBuy;
		        				 s =   typeof(data.applyBuyVol1) == "undefined"?0:data.applyBuyVol1;
		        			}else if(firsttd=='买2'){
		        				 t =   typeof(data.applyBuyPri2) == "undefined"?0.00:data.applyBuyPri2;
		        				 s =   typeof(data.applyBuyVol2) == "undefined"?0:data.applyBuyVol2;
		        			}else if(firsttd=='买3'){
		        				 t =   typeof(data.applyBuyPri3) == "undefined"?0.00:data.applyBuyPri3;
		        				 s =   typeof(data.applyBuyVol3) == "undefined"?0:data.applyBuyVol3;
		        			}else if(firsttd=='买4'){
		        				 t =   typeof(data.applyBuyPri4) == "undefined"?0.00:data.applyBuyPri4;
		        				 s =   typeof(data.applyBuyVol4) == "undefined"?0:data.applyBuyVol4;
		        			}else if(firsttd=='买5'){
		        				 t =   typeof(data.applyBuyPri5) == "undefined"?0.00:data.applyBuyPri5;
		        				 s =   typeof(data.applyBuyVol5) == "undefined"?0:data.applyBuyVol5;
		        			}
							//将买卖数量进行除以100
							//s = s/100;
	        				$(this).find("td").first().next().html(parseFloat(t).toFixed(2)).next().html(parseIntparseInt(s)/100);

		        		});
		        	}
		        	
		        }, "json"
		    );
	}
}


/**
 * 警告信息框的消失
 */
function hidenSelfStock()
{
	$(this).parent().css("display","none");

}