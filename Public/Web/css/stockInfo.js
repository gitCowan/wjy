var stockInfo = function () {
};
stockInfo.prototype = {
    init: function (isFigure,tradeType,isTrade) {
        var _this = this;
        var _isTrue = false;
        this.refeshTime = 10000;
        this.isFigure = isFigure;
        this.tradeType = tradeType;
        this.isTrade = isTrade;
        if(isFigure){
            this.selectFigureEle();
            _isTrue = true;
            this.refeshTime = 5000;
        }else{
            if(tradeType && tradeType == '1'){
                this.selectStockEle();
                _isTrue = true;
            }
        }
        if(this.timer){
            window.clearInterval(this.timer);
        }
        if( isTrade && _isTrue){
            this.timer = setInterval(function () {
                _this.getStockInfo();
            }, this.refeshTime);
        }

    },
    selectStockEle: function () {
        this.stockPriceWrap = $('.stock-own-number');
        this.stockInfoWrap = $('.stock-own-deal');
        this.fiveSoldWrap = $('.five_handicap_sold');
        this.fiveBuyWrap = $('.five_handicap_buy');
    },
    selectFigureEle: function () {
        _figureWrap = $('.stock-own-list');
        this.figurePriceWrap = _figureWrap.children("li.fore1");
        this.figureBlockWrap = _figureWrap.children("li.fore2");
        this.figureInfoWrap = _figureWrap.children("li.fore3");
    },
    getStockInfo: function () {
        var _this = this;
        $.ajax({
            url: '/stock/summary.html',
            dataType: 'jsonp',
            data: {
                code: code
            },
            success: function (data) {
                if (data.result) {
                    if(_this.isFigure){
                     _this.renderFigureData(data.data);
                    }else{
                    _this.renderStockData(data.data);
                    }
                } else {
                    clearInterval(_this.timer);
                }

            }
        });
    },
    renderFigureData: function (data) {
        var _this = this;
        var figurePriceHtml = ''+
                '<div class="number '+_this.isPositive(data.change1)+' ">'+_this.formatMoney(data.current, 2, true)+'</div>'+
                '<i class="'+_this.isPositive(data.change1)+'">'+_this.formatMoney(data.change1, 2 ,true)+' </i>'+
                '<i class="'+_this.isPositive(data.change1Range)+'">'+_this.formatMoney(data.change1Range, 2 , true , true)+'%</i>'
                ;
        var figureInfoHtml = ''+
                '<div class="item">开盘<span class="'+_this.numFont(data.todOpen,data.yesClose)+'">'+_this.formatMoney(data.todOpen, 2)+'</span></div>'+
                '<div class="item">最高<span class="'+_this.numFont(data.todHigh,data.yesClose)+'">'+_this.formatMoney(data.todHigh, 2)+'</span></div>'+
                '<div class="item">昨收<span class="font-black">'+_this.formatMoney(data.yesClose, 2)+'</span></div>'+
                '<div class="item">最低<span class="'+_this.numFont(data.todLow,data.yesClose)+'">'+_this.formatMoney(data.todLow, 2)+'</span></div>'
                ;
        _this.figurePriceWrap.addClass( _this.isPositive(data.current) );
        _this.figurePriceWrap.html(figurePriceHtml);
        _this.figureInfoWrap.html(figureInfoHtml);
    },
    renderStockData: function (data) {
        var _this = this;
        var industry = data.industryName ? "所属行业："+data.industryName :"";
        var stockPriceHtml = "" +
                "<span class='fr'>"+industry+"</span>" +
                "<span class='number " + _this.isPositive(data.change1) + "'>"+_this.formatMoney(data.current, 2 , true)+"</span>" +
                "<i class='" + _this.isPositive(data.change1) + " '>"+_this.formatMoney(data.change1, 2 , true)+" </i>"+
                "<i class='" + _this.isPositive(data.change1) + " '>"+_this.formatMoney(data.change1Range, 2 ,true ,true)+"%</i>"
            ;

        var stockInfoHtml = '' +
                '<li>开盘<span class="'+_this.numFont(data.todOpen , data.yesClose)+'">'+_this.formatMoney(data.todOpen, 2)+'</li>' +
                '<li>最高<span class="'+_this.numFont(data.todHigh , data.yesClose)+'">'+_this.formatMoney(data.todHigh, 2)+'</li>' +
                '<li>最低<span class="' + _this.numFont(data.todLow,data.yesClose)+'">' + _this.formatMoney(data.todLow, 2)+'</li>' +
                '<li>涨停<span class="'+_this.numFont(data.limitUp , data.yesClose)+'">'+_this.formatMoney(data.limitUp, 2)+'</li>' +
                '<li>跌停<span class="' + _this.numFont(data.limitDown,data.yesClose) + '">'+_this.formatMoney(data.limitDown, 2)+'</li>' +
                '<li>昨收<span class=" font-black ">'+_this.formatMoney(data.yesClose, 2)+'</li>' +
                '<li>成交量<span>'+_this.formatUnit(data.tempVolume, 2)+'</li>' +
                '<li>成交额<span>'+_this.formatUnit(data.tempAmount, 2)+'</li>' +
                '<li>总手<span>'+_this.formatUnit(data.totalHand, 2)+'</li>' +
                '<li>振幅<span>'+this.formatMoney(data.amplitude, 2 , true)+'%</li>' +
                '<li>换手<span>'+_this.formatMoney(data.handRate, 2)+'%</li>' +
                '<li>量比<span>'+_this.formatMoney(data.volumeRatio, 2)+'</li>' +
                //'<li>委比<span>'+_this.formatMoney(data.weibi, 2)+'%</li>' +
                '<li>市盈率<span>'+_this.formatMoney(data.profitRate, 2)+'</li>' +
                '<li>总股本<span>'+_this.formatUnit(data.totalVolume, 2)+'</li>' +
                '<li>流通股<span>'+_this.formatUnit(data.currencyNum, 2)+'</li>' +
                '<li>流通值<span>'+_this.formatUnit(data.circulate, 2)+'</li>'
            ;

        var fiveHandicapSoldHtml = '' +
                '<table>' +
                '<colgroup>'+
                '<col class="col1">'+
                '<col class="col2">'+
                '<col class="col3">'+
                '</colgroup>'+
                '<tbody>'+
                '<tr>' +
                '<td class="fore1">卖5</td>' +
                '<td class="fore2 ' + _this.numFont(data.applySoldPri5,data.yesClose) + ' ">'+_this.formatMoney(data.applySoldPri5, 2, true)+'</td>' +
                '<td class="fore3">' + data.applySoldVol5 + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="fore1">卖4</td>' +
                '<td class="fore2 ' + _this.numFont(data.applySoldPri4,data.yesClose) + ' ">'+_this.formatMoney(data.applySoldPri4, 2 ,true)+'</td>' +
                '<td class="fore3">' + data.applySoldVol4 + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="fore1">卖3</td>' +
                '<td class="fore2 ' + _this.numFont(data.applySoldPri3,data.yesClose) + ' ">'+_this.formatMoney(data.applySoldPri3, 2 , true)+'</td>' +
                '<td class="fore3">' + data.applySoldVol3 + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="fore1">卖2</td>' +
                '<td class="fore2 ' + _this.numFont(data.applySoldPri2,data.yesClose) + ' ">'+_this.formatMoney(data.applySoldPri2, 2 ,true)+'</td>' +
                '<td class="fore3">' + data.applySoldVol2 + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="fore1">卖1</td>' +
                '<td class="fore2 ' + _this.numFont(data.currentSold,data.yesClose) + ' ">'+_this.formatMoney(data.currentSold, 2 , true)+'</td>' +
                '<td class="fore3">' + data.applySoldVol1 + '</td>' +
                '</tr>' +
                '</tbody>' +
                '<table>'
            ;
        var fiveHandicapBuyHtml = '' +
                '<table>' +
                '<colgroup>'+
                '<col class="col1">'+
                '<col class="col2">'+
                '<col class="col3">'+
                '</colgroup>'+
                '<tbody>'+
                '<tr>' +
                '<td class="fore1">买1</td>' +
                '<td class="fore2 ' + _this.numFont(data.currentBuy,data.yesClose) + ' ">'+_this.formatMoney(data.currentBuy, 2 , true)+'</td>' +
                '<td class="fore3">' + data.applyBuyVol1 + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="fore1">买2</td>' +
                '<td class="fore2 ' + _this.numFont(data.applyBuyPri2,data.yesClose) + ' ">'+_this.formatMoney(data.applyBuyPri2, 2 , true)+'</td>' +
                '<td class="fore3">' + data.applyBuyVol2 + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="fore1">买3</td>' +
                '<td class="fore2 ' + _this.numFont(data.applyBuyPri3,data.yesClose) + ' ">'+_this.formatMoney(data.applyBuyPri3, 2 , true)+'</td>' +
                '<td class="fore3">' + data.applyBuyVol3 + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="fore1">买4</td>' +
                '<td class="fore2 ' + _this.numFont(data.applyBuyPri4,data.yesClose) + ' ">'+_this.formatMoney(data.applyBuyPri4, 2 , true)+'</td>' +
                '<td class="fore3">' + data.applyBuyVol4 + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="fore1">买5</td>' +
                '<td class="fore2 ' + _this.numFont(data.applyBuyPri5,data.yesClose) + ' ">'+_this.formatMoney(data.applyBuyPri5, 2 , true)+'</td>' +
                '<td class="fore3">' + data.applyBuyVol5 + '</td>' +
                '</tr>' +
                '</tbody>' +
                '<table>'
            ;
        CURRENT_PRICE = _this.formatMoney(data.current, 2);
        this.stockPriceWrap.html(stockPriceHtml);
        this.stockInfoWrap.html(stockInfoHtml);
        this.fiveBuyWrap.html(fiveHandicapBuyHtml);
        this.fiveSoldWrap.html(fiveHandicapSoldHtml);
    },
    //格式化货币保留两位小数
    formatMoney: function (num, floatLen, unit ,showFlag) {
        var _this = this;
        if( _this.isShow(num) && !unit){
            return "--";
        }
        var aNum = (num + '').split('.');
        var aStr = [], aNewStr = [];
        aStr = aNum[0].split('');
        //aStr.reverse();
        //for (var j = 0; j < aStr.length; j++) {
        //    if (!(j % 3) && j) {
        //        aNewStr.push(',');
        //    }
        //    aNewStr.push(aStr[j]);
        //}
        //aNewStr.reverse();
        var floatStr = '';
        if (floatLen) {
            if (aNum[1]) {
                aNum[1] += "000000001";
            } else {
                aNum[1] = "000000001";
            }
            floatStr = aNum[1] ? '.' + aNum[1].substr(0, floatLen) : '';
        }
        var result = aStr.join('') + floatStr;
        if(showFlag){
            if(num && num > 0 ){
                result = "+"+result;
            }
        }
        return result;
    },
    //格式化数字保留两位小数
    formatNumber: function (num, floatLen) {
        var aNum = (num + '').split('.');
        var aStr = [], aNewStr = [];
        aStr = aNum[0].split('');
        aStr.reverse();
        for (var j = 0; j < aStr.length; j++) {
            if (!(j % 3) && j) {
                aNewStr.push(',');
            }
            aNewStr.push(aStr[j]);
        }
        aNewStr.reverse();
        var floatStr = '';
        if (floatLen) {
            if (aNum[1]) {
                aNum[1] += "000000001";
            } else {
                aNum[1] = "000000001";
            }
            floatStr = aNum[1] ? '.' + aNum[1].substr(0, floatLen) : '';
        }
        //console.info(parseFloat(aNewStr.join('') + floatStr))
        return parseFloat(aNewStr.join('') + floatStr);
    },
    formatUnit: function (num, floatLen) {
        var pointIndex = 0;
        var _this =this;
        if( _this.isShow(num)) {
            return "--";
        }
        if (num > Math.pow(10, 8)) {
            num = num / Math.pow(10, 8) + '';
            pointIndex = num.indexOf('.');
            if(pointIndex < 0){
                if(floatLen){
                    num+='.000000001'.substr(0, floatLen + 1);
                }
            }else{
                num+= "000000001";
                num = num.substring(0, pointIndex + floatLen + 1);
            }
            num += '亿'
        } else if (num > Math.pow(10, 4)) {
            num = num / Math.pow(10, 4) + '';
            pointIndex = num.indexOf('.');
            if(pointIndex < 0){
                if(floatLen){
                    num+='.000000001'.substr(0, floatLen + 1);
                }
            }else{
                num+= "000000001";
                num = num.substring(0, pointIndex + floatLen + 1);
            }
            num += '万'
        }
        return num;
    },
    isShow:function( num ){
        if(!num || (num<0.01 && num>0) || (num>-0.01 && num<0)){
            return true;
        }
        return false;
    },
    isPositive: function (num) {
        if(!num || (num<0.01 && num>0) || (num>-0.01 && num<0)){
            return "font-black";
        }
        if(num >= 0.01){
            return "font-red";
        }
        if(num <= -0.01){
            return "font-green";
        }
        return "font-black";
    },
    isNative: function (_data) {
        if (_data) {
            return _data;
        }
        return "--";
    },
    numFont: function( numAA ,numBB ){
        if( !numAA || !numBB ){
            return "font-black";
        }
        if( numAA > numBB ){
            return "font-red";
        }else if( numAA < numBB ){
            return "font-green";
        }
        return "font-black";
    }
};
//$(document).on("click",".cancle-stock-info",function(){
//    window.clearInterval(stockIn.timer);
//});