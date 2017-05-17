$.post("/stock/figure.html",function(data){
    $("ul.figure_title").html(data);
    fadeImg({
        oContainer: $(".trend-wraps"),
        oContent: $(".trend"),
        oArrowRight: $(".patten-btn")
    });
});

//保留两位小数
function formatNum(num, floatLen, unit) {
    var aNum = (num + '').split('.');
    var aStr = [], aNewStr = [];
    aStr = aNum[0].split('');

    var floatStr = '';
    if (floatLen) {
        if (aNum[1]) {
            aNum[1] += "000000001";
        } else {
            aNum[1] = "000000001";
        }
        floatStr = aNum[1] ? '.' + aNum[1].substr(0, floatLen) : '';
    }
    return aStr.join('') + floatStr + (unit ? unit : '');
}

function formatUnit(num, floatLen) {
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
    return num;
}
//定时刷新指数数据
function refFigureTitleInfo() {
    $.post(
        "/m/figure.html",
        {},
        function (data) {
            var period = data.period;
            var flist = data.figureList;

            for (var i = 0; i < flist.length; i++) {
                var figure = flist[i];

                var _a_title = $("a.figure_title_" + figure.code);
                var div_chart_img = $(_a_title).children("div.label").children("div.chart").children("img");
                var div_value = $(_a_title).children("div.value");

                var _a_figure = $("a.figure_" + figure.code);
                var div_number = $(_a_figure).children("div.number");
                var div_extra = $(_a_figure).children("div.market-cate-extra");

                var changeInt = parseFloat(figure.change);
                var current = formatNum(figure.current,2);  //当前价
                var change = formatNum(figure.change,2);//涨跌额
                var changeRange = formatNum(figure.changeRange,2);//涨跌幅
                var amount = figure.amount;//成交额
                var high = formatNum(figure.high,2); //最高
                var low = formatNum(figure.low,2); //最低

                if (changeInt >= 0){
                    $(div_chart_img).attr("src","//static.360buyimg.com/finance/stock/1.0.0/images/trendUp.png");
                    $(div_value).html("<div class='now font-red'>" + current + "<span class='arrow'></span></div>" +
                    "<div class='range font-red'><i>+"+ change +"</i><i>+"+changeRange+"%</i></div>");

                    $(div_number).html("<span class='now font-red'>" + current + "</span>" +
                    "<i class='font-red'>+" + change + "</i><i class='font-red'>+" + changeRange + "%</i>");


                    $(div_extra).html("成交额：" + formatUnit(amount,2) + "<br />高：" + high + "&nbsp;&nbsp;低：" + low);
                } else if (changeInt < 0) {
                    $(div_chart_img).attr("src","//static.360buyimg.com/finance/stock/1.0.0/images/trendDown.png");
                    $(div_value).html("<div class='now font-green'>" + current + "<span class='arrow'></span></div>" +
                    "<div class='range font-green'><i>"+ change +"</i><i>"+changeRange+"%</i></div>");

                    $(div_number).html("<span class='now font-green'>" + current + "</span>" +
                    "<i class='font-green'>" + change + "</i><i class='font-green'>" + changeRange + "%</i>");

                    $(div_extra).html("成交额：" + formatUnit(amount,2) + "<br />高：" + high + "&nbsp;&nbsp;低：" + low);
                } else{
                    $(div_chart_img).attr("src","//static.360buyimg.com/finance/stock/1.0.0/images/trendUp.png");
                    $(div_value).html("<div class='now font-red'>--<span class='arrow'></span></div>" +
                    "<div class='range font-red'><i>--</i><i>--%</i></div>")

                    $(div_number).html("<span class='now font-red'>--</span>" +
                    "<i class='font-red'>--</i><i class='font-red'>--%</i>");

                    $(div_extra).html("成交额：--<br />高：--&nbsp;&nbsp;低：--");
                }

            }

            if(period){
                setTimeout(refFigureTitleInfo, period);
            }
        }, "json"
    );
}

//定时刷新美股指数数据
function refUsFigureTitleInfo() {
    $.post(
        "/usm/figure.html",
        {},
        function (data) {
            var period = data.period;
            var flist = data.usfigureList;
            var isTrade = data.isTrade;
            if(!isTrade){
                return;
            }
            for (var i = 0; i < flist.length; i++) {
                var figure = flist[i];

                var _a_title = $("a.figure_title_" + figure.code);
                var div_chart_img = $(_a_title).children("div.label").children("div.chart").children("img");
                var div_value = $(_a_title).children("div.value");

                var _a_figure = $("a.figure_" + figure.code);
                var div_number = $(_a_figure).children("div.number");
                var div_extra = $(_a_figure).children("div.market-cate-extra");

                var changeInt = parseFloat(figure.change);
                var current = formatNum(figure.current,2);  //当前价
                var change = formatNum(figure.change,2);//涨跌额
                var changeRange = formatNum(figure.changeRange,2);//涨跌幅
                var amount = figure.shareTrade;//成交量
                var high = formatNum(figure.high,2); //最高
                var low = formatNum(figure.low,2); //最低

                if (changeInt >= 0){
                    $(div_chart_img).attr("src","//static.360buyimg.com/finance/stock/1.0.0/images/trendUp.png");
                    $(div_value).html("<div class='now font-red'>" + current + "<span class='arrow'></span></div>" +
                        "<div class='range font-red'><i>+"+ change +"</i><i>+"+changeRange+"%</i></div>");

                    $(div_number).html("<span class='now font-red'>" + current + "</span>" +
                        "<i class='font-red'>+" + change + "</i><i class='font-red'>+" + changeRange + "%</i>");


                    $(div_extra).html("成交量：" + formatUnit(amount,2) + "<br />高：" + high + "&nbsp;&nbsp;低：" + low);
                } else if (changeInt < 0) {
                    $(div_chart_img).attr("src","//static.360buyimg.com/finance/stock/1.0.0/images/trendDown.png");
                    $(div_value).html("<div class='now font-green'>" + current + "<span class='arrow'></span></div>" +
                        "<div class='range font-green'><i>"+ change +"</i><i>"+changeRange+"%</i></div>");

                    $(div_number).html("<span class='now font-green'>" + current + "</span>" +
                        "<i class='font-green'>" + change + "</i><i class='font-green'>" + changeRange + "%</i>");

                    $(div_extra).html("成交量：" + formatUnit(amount,2) + "<br />高：" + high + "&nbsp;&nbsp;低：" + low);
                } else{
                    $(div_chart_img).attr("src","//static.360buyimg.com/finance/stock/1.0.0/images/trendUp.png");
                    $(div_value).html("<div class='now font-red'>--<span class='arrow'></span></div>" +
                        "<div class='range font-red'><i>--</i><i>--%</i></div>")

                    $(div_number).html("<span class='now font-red'>--</span>" +
                        "<i class='font-red'>--</i><i class='font-red'>--%</i>");

                    $(div_extra).html("成交量：--<br />高：--&nbsp;&nbsp;低：--");
                }
            }

            setTimeout(refUsFigureTitleInfo, period);
        }, "json"
    );
}

refFigureTitleInfo();
refUsFigureTitleInfo();
