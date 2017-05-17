/**
 * 热门行业列表
 */
function loadHoldStocksList(){
	$.post("/index/hotindustry.html",function(data){
		$("#hot-industry-fuck").html(data);
	});
}
/**
 * 涨幅榜
 */
function loadAddGains(){
	$("#gainsList .stock-con").children("li").remove();
	//$("#gainsList").removeClass("stock-tab-bg");
	$("#gainsList").addClass("stock-tab-bg");
	$.ajax({
		type: 'get',
		url: '/index/addGains.html',
		dataType: 'json',
		success: function (msg) {
			if (msg.success == true) {
				var arr = msg.returnValue;
				var temp = 1;
				for (var d in arr) {
					var l = '<li><a class="linkwrap" href="/'+arr[d].code+'" target="_blank" clstag="jr|keycount|gupiao_tongyong|yc_zfb'+temp+'">'
						+'<div class="cate">'
						+'<span class="name">'+arr[d].name+'</span>'+arr[d].code+'</div>'
						+'<div class="font-black"> '+getPrice(arr[d].price)+'</div>'
						+'<div class="'+isPositive(arr[d].sortedData)+' ">'+getGains(arr[d].sortedData)+'</div>'
						+'</a></li>';
					$("#gainsList .stock-con").append(l);
					temp ++;
				}
			}
			$("#gainsList").removeClass("stock-tab-bg");
		}
	});
}
/**
 * 跌幅榜
 */
function loadDropGains(){
	$("#gainsList .stock-con").children("li").remove();
	//$("#gainsList").removeClass("stock-tab-bg");
	$("#gainsList").addClass("stock-tab-bg");
	$.ajax({
		type: 'get',
		url: '/index/dropGains.html',
		dataType: 'json',
		success: function (msg) {
			if (msg.success == true) {
				var arr = msg.returnValue;
				var temp = 1;
				for (var d in arr) {
					var l = '<li><a class="linkwrap" href="/'+arr[d].code+'" target="_blank" clstag="jr|keycount|gupiao_tongyong|yc_dfb'+temp+'">'
						+'<div class="cate">'
						+'<span class="name">'+arr[d].name+'</span>'+arr[d].code+'</div>'
						+'<div class="font-black"> '+getPrice(arr[d].price)+'</div>'
						+'<div class="'+isPositive(arr[d].sortedData)+' ">'+getGains(arr[d].sortedData)+'</div>'
						+'</a></li>';
					$("#gainsList .stock-con").append(l);
					temp++;
				}
			}
			$("#gainsList").removeClass("stock-tab-bg");
		}
	});
}
/**
 * 快速涨幅
 */
function loadQuickGains(){
	$("#gainsList .stock-con").children("li").remove();
	//$("#gainsList").removeClass("stock-tab-bg");
	$("#gainsList").addClass("stock-tab-bg");
	$.ajax({
		type: 'get',
		url: '/index/quickGains.html',
		dataType: 'json',
		success: function (msg) {
			if (msg.success == true) {
				var arr = msg.returnValue;
				var temp = 1;
				for (var d in arr) {
					var l = '<li><a class="linkwrap" href="/'+arr[d].code+'" target="_blank" clstag="jr|keycount|gupiao_tongyong|yc_kszf'+temp+'">'
						+'<div class="cate">'
						+'<span class="name">'+arr[d].name+'</span>'+arr[d].code+'</div>'
						+'<div class="font-black"> '+getPrice(arr[d].price)+'</div>'
						+'<div class="'+isPositive(arr[d].sortedData)+' ">'+getGains(arr[d].sortedData)+'</div>'
						+'</a></li>';
					$("#gainsList .stock-con").append(l);
					temp ++;
				}
			}
			$("#gainsList").removeClass("stock-tab-bg");
		}
	});
}

/**
 * 量比
 */
function loadThan(){
	$("#thanList .stock-con").children("li").remove();
	//$("#thanList").removeClass("stock-tab-bg");
	$("#thanList").addClass("stock-tab-bg");
	$.ajax({
		type: 'get',
		url: '/index/than.html',
		dataType: 'json',
		success: function (msg) {
			if (msg.success == true) {
				var arr = msg.returnValue;
				var temp = 1;
				for (var d in arr) {
					var l = '<li><a class="linkwrap" href="/'+arr[d].code+'" target="_blank" clstag="jr|keycount|gupiao_tongyong|yc_lb'+temp+'">'
						+'<div class="cate">'
						+'<span class="name">'+arr[d].name+'</span>'+arr[d].code+'</div>'
						+'<div class="font-black"> '+getPrice(arr[d].price)+'</div>'
						+'<div class="'+isPositive(arr[d].sortedData)+' ">'+getPriceLB(arr[d].sortedData)+'</div>'
						+'</a></li>';
					$("#thanList .stock-con").append(l);
					temp++;
				}
			}
			$("#thanList").removeClass("stock-tab-bg");
		}
	});
}

/**
 * 换手率
 */
function loadChange(){
	$("#thanList .stock-con").children("li").remove();
	//$("#thanList").removeClass("stock-tab-bg");
	$("#thanList").addClass("stock-tab-bg");
	$.ajax({
		type: 'get',
		url: '/index/change.html',
		dataType: 'json',
		success: function (msg) {
			if (msg.success == true) {
				var arr = msg.returnValue;
				var temp = 1;
				for (var d in arr) {
					var l = '<li><a class="linkwrap" href="/'+arr[d].code+'" target="_blank" clstag="jr|keycount|gupiao_tongyong|yc_hsl'+temp+'">'
						+'<div class="cate">'
						+'<span class="name">'+arr[d].name+'</span>'+arr[d].code+'</div>'
						+'<div class="font-black"> '+getPrice(arr[d].price)+'</div>'
						+'<div class="'+isPositive(arr[d].sortedData)+' ">'+getGains(arr[d].sortedData)+'</div>'
						+'</a></li>';
					$("#thanList .stock-con").append(l);
					temp++;
				}
			}
			$("#thanList").removeClass("stock-tab-bg");
		}
	});
}

/**
 * 成交量
 */
function loadDeal(){
	$("#thanList .stock-con").children("li").remove();
	//$("#thanList").removeClass("stock-tab-bg");
	$("#thanList").addClass("stock-tab-bg");
	$.ajax({
		type: 'get',
		url: '/index/deal.html',
		dataType: 'json',
		success: function (msg) {
			if (msg.success == true) {
				var arr = msg.returnValue;
				var temp = 1;
				for (var d in arr) {
					var l = '<li><a class="linkwrap" href="/'+arr[d].code+'" target="_blank" clstag="jr|keycount|gupiao_tongyong|yc_cjl'+temp+'">'
						+'<div class="cate">'
						+'<span class="name">'+arr[d].name+'</span>'+arr[d].code+'</div>'
						+'<div class="font-black"> '+getPrice(arr[d].price)+'</div>'
						+'<div class="font-red">'+formatUnit(arr[d].sortedData,2)+'</div>'
						+'</a></li>';
					$("#thanList .stock-con").append(l);
					temp ++;
				}
			}
			$("#thanList").removeClass("stock-tab-bg");
		}
	});
}

function   isPositive(num) {
	if (num && num > 0) {
		return "font-red";
	} else if (num && num == 0) {
		return "font-black";
	} else if (num && num < 0) {
		return "font-green";
	}
	return "font-black";
};

function formatUnit(num, floatLen) {
	var isBig = true;
	if(num < 0){
		isBig = false;
		num = 0 - num;
	}
	var pointIndex = 0;
	if (num > Math.pow(10, 8)) {
		num = num / Math.pow(10, 8) + '';
		pointIndex = num.indexOf('.');
		num = num.substring(0, pointIndex + floatLen + 1);
		num += '亿'
	} else if (num > Math.pow(10, 4)) {
		num = num / Math.pow(10, 4) + '';
		pointIndex = num.indexOf('.');
		num = num.substring(0, pointIndex + floatLen + 1);
		num += '万'
	}
	if(!isBig){
		num = '-' + num;
	}
	return num;
};


function  getPrice(num) {
	if (num != null) {
		return num.toFixed(2)+"";
	} else{
		return "--";
	}
};
function  getPriceLB(num) {
	if (num != null) {
		num = num * 100;
		return num.toFixed(2)+"";
	} else{
		return "--";
	}
};
function  getGains(num) {
	if (num == null) {
		return "--";
	} else{
		if(num>0){
			return "+"+num.toFixed(2)+"%";
		}else{
			return num.toFixed(2)+"%";
		}
	}
};
function  getGainsTemp(tradeType,num) {
	if(tradeType !=null && tradeType == 0){
		return "停牌";
	}
	if(tradeType !=null && tradeType == 2){
		return "退市";
	}
	if (num == null) {
		return "--";
	} else{
		if(num>0){
			return "+"+num.toFixed(2)+"%";
		}else{
			return num.toFixed(2)+"%";
		}
	}
};
function  getThan(num) {
	if (num == null) {
		return "--";
	} else{
		return num.toFixed(2);
	}
};
function  dateFormat(time) {
	var dateTemp = new Date(time);
	return dateTemp.getFullYear()+"-"+(dateTemp.getMonth()+1)+"-"+dateTemp.getDate();
};
//初始化资讯首页推送消息
loadMessage();
//设置5分钟执行一次
setInterval("loadMessage()",300000);

/**
 * 获取首页推送
 */
function loadMessage(){
	$.ajax({
		type: 'get',
		url: '/index/getMessage.html',
		dataType: 'json',
		success: function (msg) {
			if (msg.success == true) {
				var info = msg.info;
				var infoID = info.id;
				if(infoID==null || $.trim(infoID)==''){
					$(".w.messageTag").hide();
					return;
				}else{
					var stockInfo = msg.stockInfo;
					var infoCookie  = readCookie("info");
					if(infoCookie!=null && $.trim(infoCookie)!=''){
						if(infoID == infoCookie){
							$(".w.messageTag").empty();
							$(".w.messageTag").hide();
							return;
						}
					}
					//单位是天，0.0034天相当于5分钟
					createCookie("info",infoID,"0.0035","/");
					var l = '<section>'
						+'<div class="message">'
						+'<span class="news"></span>'
						+'<span class="close">×</span>'
						+'<div class="extra">'
						+'<span class="time fr">'+dateFormat(info.publishTime)+'</span>'
						+'<span class="font-gray text-numbe"><a href="/'+stockInfo.stockCode+'" target="_blank">'+stockInfo.stockName+'</a></span>'
						+'<span class="'+isPositive(stockInfo.change1Range)+' text-number">'+getPrice(stockInfo.current)+'</span>'
						+'<span class="'+isPositive(stockInfo.change1Range)+' text-number">'+getGainsTemp(stockInfo.tradeType,stockInfo.change1Range)+'</span>'
						+'</div>'
						+'<div class="name">'
						+'<a href="/info/detailstocknews-'+info.id+'-'+info.code+'.html " target="_blank">'+info.title+'</a>'
						+'</div>'
						+'</section>';
					$(".w.messageTag").empty();
					$(".w.messageTag").append(l);
					$(".w.messageTag").show();
				}
			}else{
				$(".w.messageTag").hide();
			}
		}
	});
	//设置5秒钟后执行
	setTimeout("hideMessage()",5000);
};
function hideMessage(){
	$(".w.messageTag").hide();
}
//给X上注册事件
$(document).on("click",".close",function(){
	$(".w.messageTag").hide();
});

