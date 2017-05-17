/**
 * Des
 * Created by duqichao on 2015/3/26.
 * E-mail duqichao@jd.com
 * Update 2015/3/26
 */
//var kline = function(json){
//    this.init();
//    this.container = json.container;
//};
var kline = function(){};
kline.prototype = {
    init: function(){
        this.isFigure = isFigure;
        this.stockData = {};
        $(".chart-details").html("");
    },
    getKline: function(type,chartType,rangeSelectorButtons,rangeSelectorIndex){
        var _this = this;
        if(!_this.stockData[chartType]){
            $.ajax({
                url: '/stock/quote/k.html',
                dataType: 'jsonp',
                data:{
                    code:code,
                    t: type
                },
                success: function(data){
                    if(data.result){
                        _this.stockData[chartType] = data.data;
                        _this.initKline(data.data,chartType,rangeSelectorButtons,rangeSelectorIndex);
                    }
                }
            });
        }else{
            _this.initKline(_this.stockData[chartType],chartType);
        }
    },
    initKline:function (data,chartType,rangeSelectorButtons,rangeSelectorIndex) {
        var _this = this;
        var ohlc = [],ma5Data=[] , ma10Data=[], ma20Data=[],ma30Data=[],
            i = 0,
            volume = [],
            dataLength = data.length,
            groupingUnits = [[
                'week',                         // unit name
                [1]                             // allowed multiples
            ], [
                'month',
                [1, 2, 3, 4, 6]
            ]];
        var colors = ["#e4462e", "#55a500"];
        var maColor = ["#6699C7","#CC9933","#7364CE","#99CC33"];//蓝色,棕色,紫色,绿色
        var lineData = [], lineData1 = [];
        for (i; i < dataLength; i += 1) {
            var change = data[i][6];
            var changePercent = data[i][7];
            ohlc.push({
                //日期
                x: data[i][0],
                //开盘
                y: data[i][1],
                //开盘
                open: data[i][1],
                //最高
                high: data[i][2],
                //最低
                low: data[i][3],
                //收盘
                close: data[i][4],
                //涨跌值
                change: change,
                //涨跌幅
                change_percent: changePercent,
                volume: data[i][5],
                ma5: data[i][8],
                ma10: data[i][9],
                ma20: data[i][10],
                ma30: data[i][11],
                kline: !0
            });
            volume.push({
                x: data[i][0], // the date
                y: data[i][5], // the volume
                color: change>0?colors[0]:colors[1]
            });
            ma5Data.push({
                x:data[i][0],
                y:data[i][8]
            });
            ma10Data.push({
                x:data[i][0],
                y:data[i][9]
            });
            ma20Data.push({
                x:data[i][0],
                y:data[i][10]
            });
            ma30Data.push({
                x:data[i][0],
                y:data[i][11]
            });
            lineData.push([
                data[i][0],
                getRandom()
            ]);
            lineData1.push([
                data[i][0],
                getRandom()
            ]);
        }
        function getRandom(base) {
            var r = Math.random() * 10 * (Math.random() - 0.5) - 10;
            return r;
        }

        var $infos = $(".stock_info").find("span");

        //进行MA线的初始化
        //if(!_this.isFigure) {
            $infos.eq(0).css("color", maColor[0]).text("MA5: " + _this.formatDecimal(data[dataLength - 1][8]));
            $infos.eq(1).css("color", maColor[1]).text("MA10: " + _this.formatDecimal(data[dataLength - 1][9]));
            $infos.eq(2).css("color", maColor[2]).text("MA20: " + _this.formatDecimal(data[dataLength - 1][10]));
            $infos.eq(3).css("color", maColor[3]).text("MA30: " + _this.formatDecimal(data[dataLength - 1][11]));
        //}
        Highcharts.setOptions({ global: { useUTC: false } });
        Highcharts.setOptions({
            //语言文字对象：所有highstock文字相关设置
            lang: {
                downloadJPEG:'下载JPGE格式',
                contextButtonTitle: 'hello',
                rangeSelectorFrom:"日期:",
                rangeSelectorTo:"至",
                rangeSelectorZoom:"范围",
                loading:'加载中...',
                shortMonths:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                weekdays:['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六']
            }
        });
        $('.chart-details').highcharts('StockChart', {
            /*chart: {
             marginRight: 50
             },*/
            chart: {margin: 0,marginRight: 40,marginBottom:-20,spacingBottom: 0,style: {fontFamily: '"Helvetica Neue", Arial, "Microsoft YaHei"',fontSize: "12px"},animation: !1,panning: !1},
            //版权信息
            credits: {
                enabled: false
            },
            scrollbar: {liveRedraw: !1},
            rangeSelector: {
                //enabled: false,
                enabled: true,
                selected: rangeSelectorIndex,
                buttons: rangeSelectorButtons,
                inputEnabled: false,
                inputDateFormat: "%Y-%m-%d",
                inputStyle: {color: "#1f1f1f", fontWeight: "bold"},
                labelStyle: {color: "#0b1318", fontWeight: "bold"}
            },
            navigator: {
                //baseSeries: 10,
                xAxis:{
                    labels: {
                        align: 'center',
                        formatter: function () {
                            return Highcharts.dateFormat('%Y-%m-%d', this.value);
                        }
                    }
                }
            },
            title: {text: ""},
            tooltip: {
                //crosshairs:	[true, true],
                borderColor: "#dfdfdf",
                useHTML: true,
                formatter: function () {   //悬浮框内容
                    var pots = this.points;
                    if (!pots || !pots.length) {
                        return;
                    }
                    var point = pots[0].point;
                    var open = _this.formatDecimal(point.open);
                    var high = _this.formatDecimal(point.high);
                    var low = _this.formatDecimal(point.low);
                    var close = _this.formatDecimal(point.close);
                    var deal = _this.formatUnit(point.volume,2);
                    var change = _this.formatDecimal(point.change);
                    var changePercent = _this.formatDecimal(point.change_percent) + '%';
                    var ma5 = _this.formatDecimal(point.ma5);
                    var ma10 = _this.formatDecimal(point.ma10);
                    var ma20 = _this.formatDecimal(point.ma20);
                    var ma30 = _this.formatDecimal(point.ma30);
                    //var y = (this.points[1].point.y * 0.0001).toFixed(2);
                    var tip = '<b style="line-height: 25px;">' + Highcharts.dateFormat('%Y-%m-%d  %A', this.x) + '</b><br/>';
                    /*var stockName = this.points[0].series.name;
                     tip += stockName + "<br/>";*/

                    tip += '开盘价：<span style="line-height: 25px;">' + open + ' </span><br/>';
                    tip += '最高价：<span style="line-height: 25px;">' + high + ' </span><br/>';
                    tip += '最低价：<span style="line-height: 25px;">' + low + ' </span><br/>';
                    tip += '收盘价：<span style="line-height: 25px;">' + close + ' </span><br/>';
                    if (change < 0) {
                        tip += '涨跌额：<span style="color: #3A1;line-height: 25px;">'+change+'</span><br/>';
                        tip += '涨跌幅：<span style="color: #3A1;line-height: 25px;">'+changePercent+'</span><br/>';
                    } else {
                        tip += '涨跌额：<span style="color: #D20;line-height: 25px;">'+change+'</span><br/>';
                        tip += '涨跌幅：<span style="color: #D20;line-height: 25px;">'+changePercent+'</span><br/>';
                    }
                    tip += '成交量：<span style="line-height: 25px;">'+deal+'</span>';
                    //if(!_this.isFigure){
                        $infos.eq(0).css("color",maColor[0]).text("MA5: "+ma5);
                        $infos.eq(1).css("color",maColor[1]).text("MA10: "+ma10);
                        $infos.eq(2).css("color",maColor[2]).text("MA20: "+ma20);
                        $infos.eq(3).css("color",maColor[3]).text("MA30: "+ma30);
                    //}
                    return tip;
                }
            },
            plotOptions: {
                //修改蜡烛颜色
                candlestick: {
                    dataGrouping: {enabled: false},  // 是否合并数据
                    color: '#55a500',
                    lineColor: '#55a500',
                    upColor: '#e4462e',
                    upLineColor: '#e4462e'
                },
                line: {
                    marker: {
                        enabled: false
                    },
                    lineWidth: 1,
                    state:{
                        hover:{
                            enabled:false
                        }
                    },
                    enableMouseTracking: false
                },
                column: {
                    state:{
                        hover:{
                            enabled:false
                        }
                    },
                    //pointWidth:1,
                    enableMouseTracking: false,
                    turboThreshold: Number.MAX_VALUE,
                    minPointLength: 1,
                    dataGrouping: {enabled: false}  // 是否合并数据
                },
                series: {
                    turboThreshold: Number.MAX_VALUE
                }
            },
            xAxis: {
                type: 'datetime',
                gridLineWidth: 1,
                gridLineColor: "#F0F0F0",
                labels: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m-%d', this.value);
                    }
                }
            },
            yAxis: [{
                labels: {
                    align: 'right',
                    x: 28
                },
                title: {text: ' '},
                height: 250,
                top: 10,
                gridLineColor: "#F0F0F0",
                tickPixelInterval: 40,
                offset:3,
                //tickPositioner: function () {
                //    var positions = [],
                //        tick = Math.floor(this.dataMin),
                //        increment = Math.ceil((this.dataMax - this.dataMin) / 6);
                //    for (tick; tick - increment <= this.dataMax; tick += increment) {
                //        positions.push(tick);
                //    }
                //    return positions;
                //}
            }, {
                gridLineColor: "#F0F0F0",
                //gridLineWidth:0,
                labels: {
                    align: 'right',
                    x: 28,
                    formatter: function () {
                        /*var v = this.value;
                        var a = v;
                        var l = v.toString().length;
                        if (l > 9) {
                            a = p(v, 1000000000) + "G";
                        } else if (l > 6) {
                            a = p(v, 1000000) + "M";
                        }
                        return a;
                        function p(a, base) {
                            return parseInt(Math.round(a / base));
                        }*/
                        var val = this.value;
                        if(val<0){
                            return 0;
                        }
                        if(this.value >= 10000 && this.value < 1000000){
                            val = this.value / 10000 + '万';
                        }else if(this.value >= 1000000 && this.value < Math.pow(10,8)){
                            val = this.value / 1000000 + '百万';
                        }else if(this.value >= Math.pow(10,8)){
                            val = this.value / 100000000 + '亿';
                        }
                        return val;
                    }
                },
                tickPixelInterval: 37,
                title: {text: ' '},
                top: 280,
                height: 50,
                offset: 0,
                //tickPositioner: function () {
                //    var positions = [],
                //        tick = Math.floor(this.dataMin),
                //        increment = Math.ceil((this.dataMax - this.dataMin) / 3);
                //    for (var i = 0; i < 4; i++) {
                //        positions.push(tick);
                //        tick += increment;
                //    }
                //    return positions;
                //}
            }],
            series: [
                {
                 type: 'line',
                 name: 'line1',
                 data: ma5Data,
                 color:maColor[0]
             }, {
                 type: 'line',
                 name: 'line2',
                 data: ma10Data,
                 color:maColor[1]
             },{
                type: 'line',
                name: 'line2',
                data: ma20Data,
                color:maColor[2]
            },{
                type: 'line',
                name: 'line2',
                data: ma30Data,
                color:maColor[3]
            }, {
                type: 'candlestick',
                name: 'AAPL',
                data: ohlc,
                dataGrouping: {
                    units: groupingUnits
                }
            }, {
                type: 'column',
                name: '成交量',
                data: volume,
                yAxis: 1,
                dataGrouping: {
                    units: groupingUnits
                }
            }]
        }, function () {
            setTimeout(function(){
                //$('.highcharts-range-selector-buttons').hide();
            },0);
        });
    },
    formatDecimal: function(dec, count){
        count = count || 2;
        if(dec){
            return dec && dec.toFixed(count);
        }else{
            return 0.0.toFixed(count);
        }
    },
    formatUnit: function (num, floatLen) {
        var pointIndex = 0;
        if (num > Math.pow(10, 8)) {
            num = num / Math.pow(10, 8) + '';
            pointIndex = num.indexOf('.');
            num = num.substring(0, pointIndex + floatLen + 1);
            num += '亿';
        } else if (num > Math.pow(10, 4)) {
            num = num / Math.pow(10, 4) + '';
            pointIndex = num.indexOf('.');
            num = num.substring(0, pointIndex + floatLen + 1);
            num += '万';
        }
        return num;
    }
};

var newKline = new kline();
function loadKline( ktype , rangeSelectorIndex ){
    newKline.init();
    loadKlineSelector(ktype , rangeSelectorIndex );
}


function loadKlineSelector( index ,rangeSelectorIndex ){
    var  type = index;
    index = index + 1;
    var rangeSelectorButtons = null;
    //var rangeSelectorIndex = 0;
    if(index == 1){
        chartType = 'kday';
        rangeSelectorButtons = [{
            type:'month',
            count:1,
            text:'1m'
        },{
            type:'month',
            count:3,
            text:'3m'
        },{
            type:'month',
            count:6,
            text:'6m'
        },{
            type: 'year',
            count:1,
            text: '1年'
        }, {
            type: 'year',
            count:3,
            text: '3年'
        }, {
            type: 'year',
            count:5,
            text: '5年'
        }];
        //rangeSelectorIndex = 2;
    }else if(index ==2){
        chartType = 'kweek';
        rangeSelectorButtons = [{
            type:'month',
            count:3,
            text:'3m'
        },{
            type:'month',
            count:6,
            text:'6m'
        },{
            type: 'year',
            count:1,
            text: '1年'
        }, {
            type: 'year',
            count:3,
            text: '3年'
        }, {
            type: 'year',
            count:5,
            text: '5年'
        }];
        //rangeSelectorIndex = 2
    }else if(index == 3){
        chartType = 'kmonth';
        rangeSelectorButtons = [{
            type: 'year',
            count:1,
            text: '1年'
        }, {
            type: 'year',
            count:3,
            text: '3年'
        }, {
            type: 'year',
            count:5,
            text: '5年'
        }];
        //rangeSelectorIndex = 1;
    }
    //如果未发送过请求
    if(!newKline.stockData[chartType]){
        newKline.getKline(type,chartType,rangeSelectorButtons,rangeSelectorIndex);
    }
}