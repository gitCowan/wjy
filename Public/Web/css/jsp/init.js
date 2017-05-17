var chart_model = chart_model ? chart_model : 0;
var chart_model_config={};
var interval = 1;


var chart_type = 'area';

var rows = '45';
var code = 'BUIT';
//var code = 'conc';
var width='100%';
var height='auto';
var host = 'http://cevp.workwx.cn/';
//var code = 'cl1000xh';
//var rows = '45';
//var chart_type = 'area'; //area,candlestick
//var interval = '5';//1,5,30,1h,4h,1d,1w,1m
var socket_url = host+'index.php/Home/Jiekou/ajaxKchart';

//var container = '#container';
var url_h      = host+'index.php/Home/Jiekou/ajaxKchart';
var url_d 	   = host+'index.php/Home/Jiekou/ajaxKchart';

var chart_model = 1;

chart_model_config[0] ={
    'Crosshair_x_text': true,
    'Crosshair_y_text': true,
    'Crosshair':[
            {
              width:1,
              color:"#333",  
              dashStyle:"longdash",
              zIndex:5
              ,label: { 
                  style: {
                    color: '#fff'
                  },
                  text: '111' , // Content of the label. 
                  align: 'right', // Positioning of the label. 
                  x: +50 
                }
            },
            {
              width:1,
              color:"#333",  
              dashStyle:"longdash",
              zIndex:5
            }
      ]
};
chart_model_config[1] ={
    'Crosshair_x_text': true,
    'Crosshair_y_text': true,
    'Crosshair':[
            {
              width:1,
              color:"#000",  
              zIndex:5
              ,label: { 
                  style: {
                    color: '#fff'
                  },
                  text: '' , // Content of the label. 
                  align: 'left', // Positioning of the label. 
                  x: +50 
                }
            }
    ]
};


function get_alldata_url(interval){
  switch(interval){
      case '1':
      case '5':
      case '15':
      case '30':
      case '1h':
      case '4h':
          return url_h;
          break;
      case '1d':
      case '1w':
      case '1m':
          return url_d;
  }
}
var alldata_url = get_alldata_url(interval);
$(function() {
var UNDEFINED,
  VISIBLE = 'visible';
/**
 * Check for number
 * @param {Object} n
 */
function isNumber(n) {
  return typeof n === 'number';
}
function defined(obj) {
  return obj !== UNDEFINED && obj !== null;
}
/**
 * Return the first value that is defined. Like MooTools' $.pick.
 */
function pick() {
  var args = arguments,
    i,
    arg,
    length = args.length;
  for (i = 0; i < length; i++) {
    arg = args[i];
    if (arg !== UNDEFINED && arg !== null) {
      return arg;
    }
  }
}


$.extend(Highcharts.Tick.prototype,{

  /**
   * Get the x and y position for ticks and labels //重构Y轴对齐 2015.1.29
   */
  getPosition: function (horiz, pos, tickmarkOffset, old) {
    var axis = this.axis,
      chart = axis.chart,
      cHeight = (old && chart.oldChartHeight) || chart.chartHeight;

        if(!horiz){
            var ohlc = axis.series[0].yData;
            if(chart_type == 'candlestick'){
              var Close_price =ohlc[ohlc.length-1][3];
            }else{
              var Close_price =ohlc[ohlc.length-1];
            }
            //Y轴对齐
            if(  ! Close_price.toString().split(".")[1] || Close_price.toString().split(".")[1].length < 2 ){
              Close_price = Close_price.toFixed(2);
            }
            var Close_price_width = Close_price.toString().visualLength(12);
          }
        return (
          {
          x: horiz ?
            axis.translate(pos + tickmarkOffset, null, null, old) + axis.transB :
            // axis.left + axis.offset + (axis.opposite ? ((old && chart.oldChartWidth) || chart.chartWidth) - axis.right - axis.left : 0),
              chart.plotSizeX+chart.plotLeft+Close_price_width+3,

          y: horiz ?
            cHeight - axis.bottom + axis.offset - (axis.opposite ? axis.height : 0) :
            cHeight - axis.translate(pos + tickmarkOffset, null, null, old) - axis.transB
          }

        );
    
    return {
      x: horiz ?
        axis.translate(pos + tickmarkOffset, null, null, old) + axis.transB :
        axis.left + axis.offset + (axis.opposite ? ((old && chart.oldChartWidth) || chart.chartWidth) - axis.right - axis.left : 0),

      y: horiz ?
        cHeight - axis.bottom + axis.offset - (axis.opposite ? axis.height : 0) :
        cHeight - axis.translate(pos + tickmarkOffset, null, null, old) - axis.transB
    };

  }
});

  $.extend(Highcharts.Series.prototype, {

    translate: function () {
      if (!this.processedXData) { // hidden series
        this.processData();
      }
      this.generatePoints();
      var series = this,
        options = series.options,
        stacking = options.stacking,
        xAxis = series.xAxis,
        categories = xAxis.categories,
        yAxis = series.yAxis,
        points = series.points,
        dataLength = points.length,
        hasModifyValue = !!series.modifyValue,
        i,
        pointPlacement = options.pointPlacement,
        dynamicallyPlaced = pointPlacement === 'between' || isNumber(pointPlacement),
        threshold = options.threshold;

      // Translate each point
      for (i = 0; i < dataLength; i++) {
        var point = points[i],
          xValue = point.x,
          yValue = point.y,
          yBottom = point.low,
          stack = stacking && yAxis.stacks[(series.negStacks && yValue < threshold ? '-' : '') + series.stackKey],
          pointStack,
          stackValues;

        // Discard disallowed y values for log axes
        if (yAxis.isLog && yValue <= 0) {
          point.y = yValue = null;
        }

        // Get the plotX translation
        point.plotX = xAxis.translate(xValue, 0, 0, 0, 1, pointPlacement, this.type === 'flags'); // Math.round fixes #591


        // Calculate the bottom y value for stacked series
        if (stacking && series.visible && stack && stack[xValue]) {

          pointStack = stack[xValue];
          stackValues = pointStack.points[series.index + ',' + i];
          yBottom = stackValues[0];
          yValue = stackValues[1];

          if (yBottom === 0) {
            yBottom = pick(threshold, yAxis.min);
          }
          if (yAxis.isLog && yBottom <= 0) { // #1200, #1232
            yBottom = null;
          }

          point.total = point.stackTotal = pointStack.total;
          point.percentage = pointStack.total && (point.y / pointStack.total * 100);
          point.stackY = yValue;

          // Place the stack label
          pointStack.setOffset(series.pointXOffset || 0, series.barW || 0);

        }

        // Set translated yBottom or remove it
        point.yBottom = defined(yBottom) ?
          yAxis.translate(yBottom, 0, 1, 0, 1) :
          null;

        // general hook, used for Highstock compare mode
        if (hasModifyValue) {
          yValue = series.modifyValue(yValue, point);
        }

        // Set the the plotY value, reset it for redraws
        point.plotY = (typeof yValue === 'number' && yValue !== Infinity) ?
          //mathRound(yAxis.translate(yValue, 0, 1, 0, 1) * 10) / 10 : // Math.round fixes #591
          yAxis.translate(yValue, 0, 1, 0, 1) :
          UNDEFINED;
        point.plotYclose = (typeof point.close === 'number' && point.close !== Infinity) ?
          //mathRound(yAxis.translate(yValue, 0, 1, 0, 1) * 10) / 10 : // Math.round fixes #591
          yAxis.translate(point.close, 0, 1, 0, 1) :
          UNDEFINED;

            // Set client related positions for mouse tracking
        point.clientX = dynamicallyPlaced ? xAxis.translate(xValue, 0, 0, 0, 1) : point.plotX; // #1514

        point.negative = point.y < (threshold || 0);

        // some API data
        point.category = categories && categories[point.x] !== UNDEFINED ?
          categories[point.x] : point.x;

      }

      // now that we have the cropped data, build the segments
      series.getSegments();
    }
  });

  $.extend(Highcharts.Axis.prototype,{
    drawCrosshair: function (e, point) {
        if (!this.crosshair) { return; }// Do not draw crosshairs if you don't have too.

        if ((defined(point) || !pick(this.crosshair.snap, true)) === false) {
          this.hideCrosshair();
          return;
        }
        var path,
          options = this.crosshair,
          animation = options.animation,
          pos;

        // Get the path
        if (!pick(options.snap, true)) {
          pos = (this.horiz ? e.chartX - this.pos : this.len - e.chartY + this.pos);
        } else if (defined(point)) {
          /*jslint eqeq: true*/
          if(chart_type == 'candlestick'){
            // pos = (this.chart.inverted != this.horiz) ? point.plotX : this.len - point.plotYclose;
            pos = (this.chart.inverted != this.horiz) ? point.plotX : (this.len - point.plotYclose);
     
          }else{
            // pos = (this.chart.inverted != this.horiz) ? point.plotX : this.len - point.plotY;
            pos = (this.chart.inverted != this.horiz) ? point.plotX : this.len - point.plotY;
          }
          /*jslint eqeq: false*/
        }
       if(chart_type == 'candlestick'){
        pointClose= point.close;
        coordinateY = point.plotYclose;
       }else{

        pointClose= point.y;
        coordinateY = point.plotY;

       }
       pointClose = parseFloat(pointClose)

       pointClose = pointClose.toFixed(2);
    /*  if(pointClose.length)
      switch( pointClose.length){
        case 4:
          pointClose= '<font color="#27415E">_</font>'+pointClose+'';
        case 5:
          pointClose= '<font color="#27415E">_</font>'+pointClose;
        case 6:
          pointClose= '<font color="#27415E">_</font>'+pointClose;
      }*/

      if(this.chart.inverted == this.horiz){
        if( chart_model_config[chart_model]['Crosshair_y_text'] ){
          $('#rect_Crosshair_y').remove();
          $('#text_Crosshair_y').remove();
          

          this.chart.renderer.rect(this.chart.plotSizeX+this.chart.plotLeft , coordinateY, 50, 20, 0).attr({
                fill: '#27415E',
                        zIndex: 7,
                        id:'rect_Crosshair_y'
                      }).add();

          this.chart.renderer.text(pointClose, this.chart.plotSizeX+this.chart.plotLeft , coordinateY+15)
              .attr({
                  id:'text_Crosshair_y',
                  // rotation: -25,
                  zIndex:8
              })
              .css({
                  color: '#fff'
                  // ,fontSize: '16px'
              })
              .add();

        }

      }else{
        if( chart_model_config[chart_model]['Crosshair_x_text'] ){
          $('#rect_Crosshair_x').remove();
          $('#text_Crosshair_x').remove();
          date = Highcharts.dateFormat("%Y/%m/%d %H:%M",point.x,false);


          this.chart.renderer.rect(point.plotX +this.chart.plotLeft , this.chart.plotSizeY+this.chart.plotTop , 115, 20, 0).attr({
          fill: '#27415E',
                  zIndex: 7,
                  id:'rect_Crosshair_x'
                }).add();

            this.chart.renderer.text(date, point.plotX +this.chart.plotLeft +2, this.chart.plotSizeY+this.chart.plotTop+15 )
              .attr({
                  id:'text_Crosshair_x',
                  // rotation: -25,
                  zIndex:8
              })
              .css({
                  color: '#fff'
                  // ,fontSize: '16px'
              })
              .add();
        }
      }



        if (this.isRadial) {
          path = this.getPlotLinePath(this.isXAxis ? point.x : pick(point.stackY, point.y));
        } else {
          path = this.getPlotLinePath(null, null, null, null, pos);
        }

        if (path === null) {
          this.hideCrosshair();
          return;
        }

        // Draw the cross
        if (this.cross) {
          this.cross
            .attr({ visibility: VISIBLE })[animation ? 'animate' : 'attr']({ d: path }, animation);
        } else {
          var attribs = {
            'stroke-width': options.width || 1,
            stroke: options.color || '#C0C0C0',
            zIndex: options.zIndex || 2
          };
          if (options.dashStyle) {
            attribs.dashstyle = options.dashStyle;
          }
          this.cross = this.chart.renderer.path(path).attr(attribs).add();
        }
      },
      hideCrosshair: function () {
        if (this.cross) {
          $('#rect_Crosshair_x').remove();
          $('#text_Crosshair_x').remove();
          $('#rect_Crosshair_y').remove();
          $('#text_Crosshair_y').remove();
          this.cross.hide();
        }
      }
  });

  $.extend(Highcharts.Pointer.prototype,{
    getIndex: function (e) {
        var chart = this.chart;
        width = $(window).width();
        height = $(window).height();
		
        if (width < height) {
          return chart.inverted ? 
            e.chartX - chart.plotLeft:
            $(window).width() - (chart.plotHeight + chart.plotTop  - e.chartY+50 )
          ;
        }else{
          return chart.inverted ? 
          chart.plotHeight + chart.plotTop - e.chartY : 
          e.chartX - chart.plotLeft;  
        }

      }
  });
});

$(function() {
    //获取字宽
    $('body').append('<span id="ruler" style="white-space: nowrap;font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Arial, Helvetica, sans-serif;"></span>');
    String.prototype.visualLength = function(size){ 
		var ruler = $("#ruler"); 
		$("#ruler").css('font-size',size+'px');
		ruler.text(this); 
		var ruler_width = ruler[0].offsetWidth; 
		ruler.text('');
		return ruler_width;
    }
	$(container).attr('code',code);
	var host = 'http://cevp.workwx.cn/';
	var url = host+'index.php/Home/Jiekou/ajaxKchart';
	

	loadData(result='');
		
	
});   

var iosocket = io.connect(socket_url,{multiplex:false});



function loadData(result) {
	ohlc = sort_data(result);
	Highcharts.setOptions({ global : { useUTC : false } });
  // create the chart
	$(container).highcharts('StockChart', { legend:{width:100},
	chart : {
		plotBorderWidth:1,
		plotBorderColor:"#fff",
		events : {
			load : function() {
			var series = this.series[0];
			var series1 = this.series[1];
			var yAxis = this.yAxis[0];
			var renderer = this.renderer;
			if(chart_type == 'candlestick'){
				var Close_price =ohlc[ohlc.length-1][4];
			}else{
				var Close_price =ohlc[ohlc.length-1][1];
			}
			SChart.nowLine(Close_price);
			//Y轴对齐
			if(  ! Close_price.toString().split(".")[1] || Close_price.toString().split(".")[1].length < 2 ){
				Close_price = Close_price.toFixed(2);
			}
			var Close_price_width = Close_price.toString().visualLength(12);
          
			yaxis_position(chart.plotSizeX+chart.plotLeft+Close_price_width+3);
			//Y轴对齐 end

			if(chart_type == 'candlestick'){
				var update_time =result[result.length-1][5];
			}else{
				var update_time =result[result.length-1][2];
			}
			// update_time = update_time.substring(0,update_time.length-3);

			renderer.text('' , 220, this.containerHeight-150)
			.attr({
				id:'website',
				zIndex:-18
			})
			.css({
				color: '#EFE8E6',
				fontSize:'46px'
			})
			.add();
			var update_text = '更新时间:' + update_time ;

			var Update_width = update_text.toString().visualLength(10);
			renderer.text( "" , this.containerWidth-Update_width, this.containerHeight-2)
			.attr({
				id:'update_time',
				zIndex:8
			})
			.css({
				color: '#ccc',
				fontSize:'10px'
			})
			.add();

			var num = series.data.length;
			var plotSizeX= this.plotSizeX;
			var plotLeft = this.plotLeft;
			if(interval=="1d"){
				intervals = 24*60;
			}else if(interval == '1'){
				intervals=1;
			}else if(interval == '10'){
				intervals=10*60;
			}else if(interval == '30'){
				intervals=30*60;
			}else if(interval == '60'){
				intervals=60*60;
			} 
			var refreshtime=intervals*1*1000;
			var host = 'http://cevp.workwx.cn/';
			setInterval(function () {
				$.ajax({
					url :host+'index.php/Home/Jiekou/ajaxLatest',
					data : {
						type : chart_type,
						code : code,
						rows : rows,
						interval : interval
					},
					success: function(re){
						if(re){
							if(interval==1){
								var Close_price = re[4];
								series.addPoint([(new Date()).getTime(),re[4]], true, true);
							}else{
								var Close_price = re[4];
								series.addPoint([(new Date()).getTime(),re[1],re[2],re[3],re[4]], true, true);
							}
						
							SChart.nowLine(Close_price,true);
						}
						
					}
                });
			}, refreshtime);

        },
/*        redraw: function() {
          var series = this.series[0];
          var num = series.data.length;


          temp_data = SChart.getAllData();
          if( chart_type =='candlestick'){
            var Close_price = temp_data[temp_data.length-1][4];
          }else{
            var Close_price = temp_data[temp_data.length-1][1];
          }

          SChart.nowLine(Close_price,true);
        

          update_time = $('#update_time').text();
          $('#update_time').remove();
          renderer.text(update_time , this.containerWidth-140, this.containerHeight-2)
          .attr({
              id:'update_time',
              zIndex:8
          })
         .css({
              color: '#ccc',
              fontSize:'10px'
          })
          .add();

        },*/
        click:function(e){
          // console.log(e.xAxis,e.yAxis)
        // date = Highcharts.dateFormat("%Y/%m/%d %H:%M",e.xAxis[0].value,false);
        // console.log( date);

                    // chart = $(container).highcharts();

          // c= chart.xAxis.translate(e.xAxis[0].value, 0, 0, 0, 1, undefined, false); 
          // console.log(chart)
          // console.log(c)
        }

      }

           
    },

    plotOptions: {
        area: {
              fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, 'rgba(155,129,94,1)'],
                        [1, 'rgba(36,35,34,0)']
                    ]
                },
              lineWidth: 2,
              marker: {
                  enabled: false
              },
              shadow: false,
              states: {
                  hover: {
                      lineWidth: 2
                  }
              },
            threshold: null,

            marker: {
                symbol: 'circle' //曲线点类型："circle", "square", "diamond", "triangle","triangle-down"，默认是"circle"
            
            }
        }
     /*   ,candlestick:{
          pointWidth:1
        }*/
    },


    tooltip:{
      // crosshairs: [true, true],
      crosshairs: chart_model_config[chart_model]['Crosshair'],
      shape: 'square',
	
      positioner: function (boxWidth, boxHeight, point) {
			
          var chart = this.chart,
          distance = this.distance,
          ret = {},
          swapped,
          first = ['y', chart.chartHeight, boxHeight, point.plotY + chart.plotTop],
          second = ['x', chart.chartWidth, boxWidth, point.plotX + chart.plotLeft],
          // The far side is right or bottom
          preferFarSide = point.ttBelow || (chart.inverted && !point.negative) || (!chart.inverted && point.negative),
          /**
           * Handle the preferred dimension. When the preferred dimension is tooltip
           * on top or bottom of the point, it will look for space there.
           */
          
          secondDimension = function (dim, outerSize, innerSize, point) {
            var roomLeft = innerSize < point - distance,
              roomRight = point + distance + innerSize < outerSize,
              alignedLeft = point - distance - innerSize,
              alignedRight = point + distance;

            if (preferFarSide && roomRight) {
              ret[dim] = alignedRight;
            } else if (!preferFarSide && roomLeft) {
              ret[dim] = alignedLeft;
            } else if (roomLeft) {
              ret[dim] = alignedLeft;
            } else if (roomRight) {
              ret[dim] = alignedRight;
            } else {
              return false;
            }
          },
          /**
           * Handle the secondary dimension. If the preferred dimension is tooltip
           * on top or bottom of the point, the second dimension is to align the tooltip
           * above the point, trying to align center but allowing left or right
           * align within the chart box.
           */
           firstDimension= function (dim, outerSize, innerSize, point) {
            
            // Too close to the edge, return false and swap dimensions
            if (point < distance || point > outerSize - distance) {
              return false;
            
            // Align left/top
            } else if (point < innerSize / 2) {
              ret[dim] = 1;
            // Align right/bottom
            } else if (point > outerSize - innerSize / 2) {
              ret[dim] = outerSize - innerSize - 2;
            // Align center
            } else {
              ret[dim] = point - innerSize / 2;
            }
          },
          /**
           * Swap the dimensions 
           */
          swap = function (count) {
            var temp = first;
            first = second;
            second = temp;
            swapped = count;
          },
          run = function () {
            if (firstDimension.apply(0, first) !== false) {
              if (secondDimension.apply(0, second) === false && !swapped) {
                swap(true);
                run();
              }
            } else if (!swapped) {
              swap(true);
              run();
            } else {
              ret.x = ret.y = 0;
            }
          };

        // Under these conditions, prefer the tooltip on the side of the point
        if (chart.inverted || this.len > 1) {
          swap();
        }
        run();
        return ret;
      },


      formatter:function(){  


        if(chart_type == 'candlestick'){
        var tip = "";
          // tip = this.points[0].series.name+"<br/> ";
          tip += Highcharts.dateFormat("%Y-%m-%d %H:%M",this.points[0].point.x,false)+"<br/>";
          tip += "开盘价："+this.points[0].point.open+"<br/>";
          tip += "收盘价："+this.points[0].point.close+"<br/>";
          tip += "最高价："+this.points[0].point.high+"<br/>";
          tip += "最低价："+this.points[0].point.low+"<br/>";
          return tip;
        }else{
          var tip = "";
          // tip = this.points[0].series.name+"<br/> ";
          tip += Highcharts.dateFormat("%Y-%m-%d %H:%M",this.points[0].point.x,false)+"<br/>";
          tip += "现价："+this.points[0].point.y+"<br/>";
          return tip;
        }
      }
    },

    scrollbar: {
      enabled: false
    },
    navigator: {
       enabled : false
    },
    credits: {
      enabled: false
    },
    exporting: {
      enabled: false
    },
    rangeSelector: {
      enabled : false
        // selected: 1
    },

    xAxis:{

          offset:0,
          tickLength: 1 ,
          labels:{
            fontSize:'20px'
          },
          dateTimeLabelFormats: {
              millisecond: '%H:%M',
              second: '%H:%M',
              minute: '%H:%M',
              hour: '%H:%M',
              day: '%b/%e',
              week: '%b/%e',
              month: '%Y-%b',
              year: '%Y'
          },
            gridLineColor: "#fff",
            gridLineWidth: 1

      },
      yAxis:{
          // offset:40,
          offset:60,
          labels:{
            zIndex:4


            ,formatter:function(){
              if(this.value>10){
                return this.value.toFixed(2);
              }else{
                return this.value.toFixed(4);
              }
            }


          },
          gridLineColor: "#fff",
          gridLineWidth: 1
	/*
          ,plotLines:[{
                color:'black',           
                // dashStyle:'solid',     
                id: 'plot-line' ,
                value:ohlc[ohlc.length-1][1],               
                width:1                
                ,zIndex:6
                ,label: { 
                  style: {
                    color: '#fff'
                  },
                  text: ohlc[ohlc.length-1][1] , // Content of the label. 
                  align: 'right', // Positioning of the label. 
                  x: +50 
                }
            }]
	 */
      },

      series: [{

          type: chart_type,
          name: 'AAPL',
          data: ohlc
      }
/*      ,{

          name: 'AAPL',
          data: ohlc
      }*/
      ]

  });
}

var SChart ={response:[],temp_data:[],temp_data:[],chart_type:'',Close_price_width:0};

SChart.setLastPrice = function (){
    var temp=[];
    var response = this.response;
    var temp_data = this.temp_data;
    var chart_type = this.chart_type;

    temp[0] =temp_data[temp_data.length-1][0];

    if(chart_type =='candlestick'){
      price = temp[4] =  response['last'];
      temp[1] = temp_data[temp_data.length-1][1];

      high = temp_data[temp_data.length-1][2];
      low = temp_data[temp_data.length-1][3];

      high = temp[2] = price > high ? price : high;
      low = temp[3]  = price < low ? price : low;
    }else{
      temp[1] = response['last'];
    }

    temp_data[temp_data.length-1] = temp;
    this.series.setData(temp_data);
    this.temp_data=temp_data;
    // return temp_data;

}

SChart.shiftData = function (){
    var temp=[];
    var response = this.response;
    var temp_data = this.temp_data;
    var chart_type = this.chart_type;

    temp[0] = parseInt( response.start ) *1000;
    temp[1] = response['last'];
    if(chart_type =='candlestick'){
      temp[2] = response['last'];
      temp[3] = response['last'];
      temp[4] = response['last'];
    }
    temp_data.shift();
    temp_data.push(temp);
    this.series.setData(temp_data);
    this.temp_data=temp_data;

    
  }
SChart.getAllData = function (){
    var series = this.series;
    chart_type = this.chart_type;

    xData = series.xData;
    yData = series.yData;
    var temp_data = [];
    if(chart_type == 'candlestick'){
      for(i=0;i < xData.length;i++){
        var temp1=[];
        temp1 = [ xData[i],yData[i][0],yData[i][1],yData[i][2],yData[i][3] ];
        temp_data[i]=temp1;
      }
    }else{
      for(i=0;i < xData.length;i++){
        var temp1=[];
        temp1 = [ xData[i],yData[i]];
        temp_data[i]=temp1;
      }
    }
    this.temp_data = temp_data;
    return temp_data;
}


SChart.nowLine = function(Close_price,remove){
	
    chart = $(container).highcharts();
    var series = chart.series[0];
    var renderer = chart.renderer;
    var yAxis = chart.yAxis[0];

    if(remove==true){
      yAxis.removePlotLine('plot-line');
      $('#rect_backgroud').remove();
    }

    if(  ! Close_price.toString().split(".")[1] || Close_price.toString().split(".")[1].length < 2 ){
      Close_price = Close_price.toFixed(2);
    }

    var Close_price_width = Close_price.toString().visualLength(12);
    SChart.Close_price_width = Close_price_width;

    yAxis.addPlotLine({            
        value:Close_price,                 
        width:1,                             
        color: '#999',                       
        id: 'plot-line',                
        zIndex:6

         ,label: {  
           style: {
             color: '#fff'
           },
           text: Close_price, // Content of the label.  
           align: 'right', // Positioning of the label.  
           x: +Close_price_width+5
	} 
    });
    num = series.data.length;

    if(chart_type == 'candlestick'){
      if( num ){
        var plotClose = series.data[num-1].plotClose;
      }else{
        // var plotClose = yAxis.plotLinesAndBands[0].svgElem.element.animatedPathSegList[0].y - 10;
        var plotClose = yAxis.plotLinesAndBands[0].svgElem.d.toString().split(' ')[2]-10;

      }
    }else{
		if(num){
			var plotClose = series.data[num-1].plotY;
		}
      
    }


    renderer.rect(chart.plotSizeX+chart.plotLeft , plotClose-8 , Close_price_width+10, 20, 0).attr({
      fill: "#fff",
      zIndex: 5,
      id:'rect_backgroud'
    }).add();
}

function updateChartSize() {

  var width1 = (width =='auto') ? $(window).width() : width;
  var height1 = (height =='auto') ? $(window).height() : height;
	
  // width1 = width1 >500 ? width1 : 500;
  // height1 = height1 >500 ? 260 : height1/2;

  if (width1 < height1) {
      var temp = width1;
      width1 = height1;
      height1 = temp;

      var ml = (width1-height1)/2
 
      $(container).css({
        '-moz-transform':'rotate(90deg)',
        '-webkit-transform':'rotate(90deg)',
        'margin-top': ml+'px',
        'margin-left': '-'+ml+'px'
      });
  }else{
    $(container).css({
        '-moz-transform':'rotate(0deg)',
        '-webkit-transform':'rotate(0deg)',
        'margin-top': '0px',
        'margin-left': '0px'
      });
  }


  $('#debug').html('width1:' +width1 +' height1:' +height1);
  $(container).height(height1);
  $(container).width(width1);
  // $('#debug').text('height'+ height1 +"width"+width1);
  chart = $(container).highcharts();
  if(!chart) return;
  



  var yAxis = chart.yAxis[0];

  yAxis.removePlotLine('plot-line');
  $('#rect_backgroud').remove();

  // chart.redraw();

/* 
  var series = chart.series[0];
  var num = series.data.length;
  var renderer = chart.renderer;

  SChart.series = series;
  SChart.chart_type = chart_type;

  if( chart_type =='candlestick'){
    var Close_price = temp_data[temp_data.length-1][4];
  }else{
    var Close_price = temp_data[temp_data.length-1][1];
  }

  SChart.nowLine(Close_price,true);


  update_time = $('#update_time').text();
  $('#update_time').remove();
  renderer.text(update_time , chart.containerWidth-140, chart.containerHeight-2)
  .attr({
      id:'update_time',
      zIndex:8
  })
 .css({
      color: '#ccc',
      fontSize:'10px'
  })
  .add();*/


}
   
$(document).ready(function(){
   updateChartSize();
   //监听窗体大小变更事件
   $(window).resize(updateChartSize);
   $(document).resize(updateChartSize);
});


    function changeData(code){
      chart_type = 'area';
        $.ajax({
          url :alldata_url,
          dataType : 'jsonp',
          data : {
              type : chart_type,
                      code : code,
                      rows : rows,
                      interval : interval
                  },
          success: function(result){
            ohlc = sort_data(result);

            chart = $(container).highcharts();
            chart.series[0].setData(ohlc);
            old_code = $(container).attr('code') 
            $(container).attr('code',code);


            if(chart_type == 'candlestick'){
              var Close_price =ohlc[ohlc.length-1][4];
            }else{
              var Close_price =ohlc[ohlc.length-1][1];
            }
            SChart.nowLine(Close_price,true);



            iosocket.emit('logout',old_code);
            iosocket.emit('login',code);

            //Y轴对齐
            if(  ! Close_price.toString().split(".")[1] || Close_price.toString().split(".")[1].length < 2 ){
              Close_price = Close_price.toFixed(2);
            }
            
            var Close_price_width = Close_price.toString().visualLength(12);
            x = chart.plotSizeX+chart.plotLeft+Close_price_width+3;

            setTimeout("yaxis_position("+x+")",400);
      
            //Y轴对齐 end

          }
        });
    }



    function changeInterval(interval){
        alldata_url = get_alldata_url(interval);
        $.ajax({
          url :alldata_url,
          dataType : 'jsonp',
          data : {
              type : chart_type,
                      code : code,
                      rows : rows,
                      interval : interval
                  },
          success: function(result){
            ohlc = sort_data(result);
            
            window.interval = interval;

            chart = $(container).highcharts();
            chart.series[0].setData(ohlc);
            old_code = $(container).attr('code') 
            $(container).attr('code',code);


            if(chart_type == 'candlestick'){
              var Close_price =ohlc[ohlc.length-1][4];
            }else{
              var Close_price =ohlc[ohlc.length-1][1];
            }
            SChart.nowLine(Close_price,true);

            iosocket.emit('logout',old_code);
            iosocket.emit('login',code);

            //Y轴对齐
            if(  ! Close_price.toString().split(".")[1] || Close_price.toString().split(".")[1].length < 2 ){
              Close_price = Close_price.toFixed(2);
            }
            
            var Close_price_width = Close_price.toString().visualLength(12);
            x = chart.plotSizeX+chart.plotLeft+Close_price_width+3;

            setTimeout("yaxis_position("+x+")",400);

          }
        });
    }







    function yaxis_position(x){
           // $('.highcharts-yaxis-labels text').attr('x',x);
    }

    function sort_data(result){
		var result = [[1481272562000,2487,2519.9,2485.2,2523.5,"2016-12-09 16:36",2519.5],[1481272569000,2487,2519.9,2485.2,2523,"2016-12-09 16:36",2519],[1481272581000,2487,2519.9,2485.2,2522.5,"2016-12-09 16:36",2518.5],[1481272583000,2487,2519.9,2485.2,2522.4,"2016-12-09 16:36",2518.4],[1481272587000,2487,2519.9,2485.2,2522.9,"2016-12-09 16:36",2518.9],[1481272591000,2487,2519.9,2485.2,2523.4,"2016-12-09 16:36",2519.4],[1481272596000,2487,2519.9,2485.2,2523,"2016-12-09 16:36",2519],[1481272621000,2487,2519.9,2485.2,2522.9,"2016-12-09 16:37",2518.9],[1481272639000,2487,2519.9,2485.2,2523.4,"2016-12-09 16:37",2519.4],[1481272639000,2487,2519.9,2485.2,2523.4,"2016-12-09 16:37",2519.4],[1481272641000,2487,2519.9,2485.2,2522.9,"2016-12-09 16:37",2518.9],[1481272656000,2487,2519.9,2485.2,2522.4,"2016-12-09 16:37",2518.4],[1481272664000,2487,2519.9,2485.2,2522.9,"2016-12-09 16:37",2518.9],[1481272677000,2487,2519.9,2485.2,2522.4,"2016-12-09 16:37",2518.4],[1481272683000,2487,2519.9,2485.2,2522.5,"2016-12-09 16:38",2518.5],[1481272687000,2487,2519.9,2485.2,2522.9,"2016-12-09 16:38",2518.9],[1481272694000,2487,2519.9,2485.2,2523.8,"2016-12-09 16:38",2519.8],[1481272706000,2487,2520.6,2485.2,2524.2,"2016-12-09 16:38",2520.2],[1481272716000,2487,2520.6,2485.2,2524.3,"2016-12-09 16:38",2520.3],[1481272718000,2487,2520.6,2485.2,2524.2,"2016-12-09 16:38",2520.2],[1481272718000,2487,2520.6,2485.2,2524.2,"2016-12-09 16:38",2520.2],[1481272731000,2487,2520.6,2485.2,2524.3,"2016-12-09 16:38",2520.3],[1481272733000,2487,2520.7,2485.2,2524.7,"2016-12-09 16:38",2520.7],[1481272733000,2487,2520.7,2485.2,2524.7,"2016-12-09 16:38",2520.7],[1481272746000,2487,2521.1,2485.2,2524.8,"2016-12-09 16:39",2520.8],[1481272748000,2487,2521.7,2485.2,2525.7,"2016-12-09 16:39",2521.7],[1481272752000,2487,2521.7,2485.2,2525.2,"2016-12-09 16:39",2521.2],[1481272758000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:39",2520.7],[1481272764000,2487,2521.7,2485.2,2525.2,"2016-12-09 16:39",2521.2],[1481272766000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:39",2520.7],[1481272770000,2487,2521.7,2485.2,2525.7,"2016-12-09 16:39",2521.7],[1481272775000,2487,2521.7,2485.2,2525.2,"2016-12-09 16:39",2521.2],[1481272775000,2487,2521.7,2485.2,2525.2,"2016-12-09 16:39",2521.2],[1481272777000,2487,2521.7,2485.2,2525.7,"2016-12-09 16:39",2521.7],[1481272777000,2487,2521.7,2485.2,2525.7,"2016-12-09 16:39",2521.7],[1481272779000,2487,2521.7,2485.2,2525.2,"2016-12-09 16:39",2521.2],[1481272796000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:39",2520.7],[1481272829000,2487,2521.7,2485.2,2524.3,"2016-12-09 16:40",2520.3],[1481272831000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:40",2520.7],[1481272839000,2487,2521.7,2485.2,2524.8,"2016-12-09 16:40",2520.8],[1481272850000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:40",2520.7],[1481272852000,2487,2521.7,2485.2,2524.8,"2016-12-09 16:40",2520.8],[1481272860000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:41",2520.7],[1481272870000,2487,2521.7,2485.2,2524.8,"2016-12-09 16:41",2520.8],[1481272877000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:41",2520.7],[1481272879000,2487,2521.7,2485.2,2524.8,"2016-12-09 16:41",2520.8],[1481272883000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:41",2520.7],[1481272893000,2487,2521.7,2485.2,2523.4,"2016-12-09 16:41",2519.4],[1481272898000,2487,2521.7,2485.2,2523.9,"2016-12-09 16:41",2519.9],[1481272900000,2487,2521.7,2485.2,2523.4,"2016-12-09 16:41",2519.4],[1481272902000,2487,2521.7,2485.2,2523.9,"2016-12-09 16:41",2519.9],[1481272906000,2487,2521.7,2485.2,2523.4,"2016-12-09 16:41",2519.4],[1481272908000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:41",2518.9],[1481272916000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:41",2518.8],[1481272920000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:42",2518.4],[1481272927000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:42",2518.8],[1481272935000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:42",2518.9],[1481272939000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:42",2518.4],[1481272945000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:42",2518.9],[1481272950000,2487,2521.7,2485.2,2522.5,"2016-12-09 16:42",2518.5],[1481272952000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:42",2518.4],[1481272983000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:43",2518.8],[1481272991000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:43",2518.4],[1481273008000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:43",2517.9],[1481273020000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:43",2518.4],[1481273027000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:43",2517.9],[1481273037000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:43",2517.5],[1481273060000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:44",2517.9],[1481273068000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:44",2518.4],[1481273077000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:44",2518.9],[1481273081000,2487,2521.7,2485.2,2523.4,"2016-12-09 16:44",2519.4],[1481273085000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:44",2518.9],[1481273093000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:44",2518.4],[1481273099000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:44",2518.9],[1481273108000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:45",2518.4],[1481273129000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:45",2518.9],[1481273135000,2487,2521.7,2485.2,2523.3,"2016-12-09 16:45",2519.3],[1481273137000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:45",2518.9],[1481273139000,2487,2521.7,2485.2,2523.4,"2016-12-09 16:45",2519.4],[1481273145000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:45",2518.9],[1481273151000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:45",2518.4],[1481273160000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:46",2517.9],[1481273162000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:46",2518.4],[1481273166000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:46",2517.9],[1481273168000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:46",2518.4],[1481273172000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:46",2518.9],[1481273189000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:46",2518.8],[1481273193000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:46",2518.9],[1481273201000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:46",2518.8],[1481273206000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:46",2518.9],[1481273208000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:46",2518.8],[1481273228000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:47",2518.9],[1481273245000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:47",2518.8],[1481273253000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:47",2518.9],[1481273258000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:47",2518.8],[1481273274000,2487,2521.7,2485.2,2522.3,"2016-12-09 16:47",2518.3],[1481273276000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:47",2518.4],[1481273280000,2487,2521.7,2485.2,2522.3,"2016-12-09 16:48",2518.3],[1481273283000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:48",2517.9],[1481273287000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:48",2517.5],[1481273295000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:48",2517.9],[1481273310000,2487,2521.7,2485.2,2522.3,"2016-12-09 16:48",2518.3],[1481273312000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:48",2517.9],[1481273335000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:48",2518.4],[1481273364000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:49",2517.9],[1481273376000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:49",2517.5],[1481273401000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:50",2517.9],[1481273405000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:50",2517.5],[1481273410000,2487,2521.7,2485.2,2521.8,"2016-12-09 16:50",2517.8],[1481273412000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:50",2517.9],[1481273418000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:50",2518.4],[1481273435000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:50",2517.9],[1481273437000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:50",2518.4],[1481273441000,2487,2521.7,2485.2,2522.3,"2016-12-09 16:50",2518.3],[1481273447000,2487,2521.7,2485.2,2522.4,"2016-12-09 16:50",2518.4],[1481273449000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:50",2517.9],[1481273466000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:51",2517.5],[1481273472000,2487,2521.7,2485.2,2521,"2016-12-09 16:51",2517],[1481273476000,2487,2521.7,2485.2,2521.4,"2016-12-09 16:51",2517.4],[1481273480000,2487,2521.7,2485.2,2521,"2016-12-09 16:51",2517],[1481273487000,2487,2521.7,2485.2,2521.4,"2016-12-09 16:51",2517.4],[1481273535000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:52",2517.5],[1481273537000,2487,2521.7,2485.2,2521.8,"2016-12-09 16:52",2517.8],[1481273539000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:52",2517.5],[1481273584000,2487,2521.7,2485.2,2521.4,"2016-12-09 16:53",2517.4],[1481273599000,2487,2521.7,2485.2,2521.8,"2016-12-09 16:53",2517.8],[1481273609000,2487,2521.7,2485.2,2521.4,"2016-12-09 16:53",2517.4],[1481273630000,2487,2521.7,2485.2,2521,"2016-12-09 16:53",2517],[1481273634000,2487,2521.7,2485.2,2521.4,"2016-12-09 16:53",2517.4],[1481273653000,2487,2521.7,2485.2,2521.8,"2016-12-09 16:54",2517.8],[1481273655000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:54",2517.5],[1481273662000,2487,2521.7,2485.2,2521.8,"2016-12-09 16:54",2517.8],[1481273668000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:54",2517.5],[1481273672000,2487,2521.7,2485.2,2521.8,"2016-12-09 16:54",2517.8],[1481273680000,2487,2521.7,2485.2,2521.5,"2016-12-09 16:54",2517.5],[1481273695000,2487,2521.7,2485.2,2521.6,"2016-12-09 16:54",2517.6],[1481273697000,2487,2521.7,2485.2,2521.8,"2016-12-09 16:54",2517.8],[1481273753000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:55",2517.9],[1481273759000,2487,2521.7,2485.2,2521.8,"2016-12-09 16:55",2517.8],[1481273762000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:56",2517.9],[1481273766000,2487,2521.7,2485.2,2522.3,"2016-12-09 16:56",2518.3],[1481273795000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:56",2518.8],[1481273805000,2487,2521.7,2485.2,2523.3,"2016-12-09 16:56",2519.3],[1481273816000,2487,2521.7,2485.2,2524.6,"2016-12-09 16:56",2520.6],[1481273818000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:56",2520.7],[1481273820000,2487,2521.7,2485.2,2524.3,"2016-12-09 16:57",2520.3],[1481273822000,2487,2521.7,2485.2,2524.8,"2016-12-09 16:57",2520.8],[1481273826000,2487,2521.7,2485.2,2524.3,"2016-12-09 16:57",2520.3],[1481273830000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:57",2520.7],[1481273836000,2487,2521.7,2485.2,2525.2,"2016-12-09 16:57",2521.2],[1481273841000,2487,2521.7,2485.2,2524.8,"2016-12-09 16:57",2520.8],[1481273843000,2487,2521.7,2485.2,2525.2,"2016-12-09 16:57",2521.2],[1481273847000,2487,2521.7,2485.2,2524.2,"2016-12-09 16:57",2520.2],[1481273851000,2487,2521.7,2485.2,2523.9,"2016-12-09 16:57",2519.9],[1481273857000,2487,2521.7,2485.2,2523.3,"2016-12-09 16:57",2519.3],[1481273863000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:57",2518.8],[1481273866000,2487,2521.7,2485.2,2523.3,"2016-12-09 16:57",2519.3],[1481273868000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:57",2518.9],[1481273870000,2487,2521.7,2485.2,2523.3,"2016-12-09 16:57",2519.3],[1481273874000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:57",2518.9],[1481273876000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:57",2518.8],[1481273880000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:58",2518.9],[1481273884000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:58",2518.8],[1481273901000,2487,2521.7,2485.2,2522.3,"2016-12-09 16:58",2518.3],[1481273926000,2487,2521.7,2485.2,2521.9,"2016-12-09 16:58",2517.9],[1481273928000,2487,2521.7,2485.2,2522.3,"2016-12-09 16:58",2518.3],[1481273936000,2487,2521.7,2485.2,2522.8,"2016-12-09 16:58",2518.8],[1481273945000,2487,2521.7,2485.2,2522.9,"2016-12-09 16:59",2518.9],[1481273968000,2487,2521.7,2485.2,2523.4,"2016-12-09 16:59",2519.4],[1481273972000,2487,2521.7,2485.2,2523.8,"2016-12-09 16:59",2519.8],[1481273984000,2487,2521.7,2485.2,2524.3,"2016-12-09 16:59",2520.3],[1481273988000,2487,2521.7,2485.2,2524.7,"2016-12-09 16:59",2520.7],[1481273993000,2487,2521.7,2485.2,2524.8,"2016-12-09 16:59",2520.8],[1481274003000,2487,2521.7,2485.2,2523.4,"2016-12-09 17:00",2519.4],[1481274005000,2487,2521.7,2485.2,2523.9,"2016-12-09 17:00",2519.9],[1481274020000,2487,2521.7,2485.2,2524.3,"2016-12-09 17:00",2520.3],[1481274028000,2487,2521.7,2485.2,2524.2,"2016-12-09 17:00",2520.2],[1481274032000,2487,2521.7,2485.2,2523.3,"2016-12-09 17:00",2519.3],[1481274040000,2487,2521.7,2485.2,2522.3,"2016-12-09 17:00",2518.3],[1481274047000,2487,2521.7,2485.2,2521.8,"2016-12-09 17:00",2517.8],[1481274051000,2487,2521.7,2485.2,2521.5,"2016-12-09 17:00",2517.5],[1481274057000,2487,2521.7,2485.2,2521.4,"2016-12-09 17:00",2517.4],[1481274068000,2487,2521.7,2485.2,2521.8,"2016-12-09 17:01",2517.8],[1481274107000,2487,2521.7,2485.2,2521.7,"2016-12-09 17:01",2517.7],[1481274111000,2487,2521.7,2485.2,2521.4,"2016-12-09 17:01",2517.4],[1481274118000,2487,2521.7,2485.2,2520.9,"2016-12-09 17:01",2516.9],[1481274130000,2487,2521.7,2485.2,2520.5,"2016-12-09 17:02",2516.5],[1481274134000,2487,2521.7,2485.2,2520.4,"2016-12-09 17:02",2516.4],[1481274140000,2487,2521.7,2485.2,2521.9,"2016-12-09 17:02",2517.9],[1481274149000,2487,2521.7,2485.2,2521.5,"2016-12-09 17:02",2517.5],[1481274151000,2487,2521.7,2485.2,2521.4,"2016-12-09 17:02",2517.4],[1481274157000,2487,2521.7,2485.2,2520.9,"2016-12-09 17:02",2516.9],[1481274159000,2487,2521.7,2485.2,2520.5,"2016-12-09 17:02",2516.5],[1481274178000,2487,2521.7,2485.2,2520,"2016-12-09 17:02",2516],[1481274190000,2487,2521.7,2485.2,2519.4,"2016-12-09 17:03",2515.4],[1481274193000,2487,2521.7,2485.2,2518.9,"2016-12-09 17:03",2514.9],[1481274195000,2487,2521.7,2485.2,2518.6,"2016-12-09 17:03",2514.6],[1481274199000,2487,2521.7,2485.2,2518.5,"2016-12-09 17:03",2514.5],[1481274205000,2487,2521.7,2485.2,2518.6,"2016-12-09 17:03",2514.6],[1481274209000,2487,2521.7,2485.2,2518.9,"2016-12-09 17:03",2514.9]];
      var data = result;
      var ohlc = [],
        volume = [],
        dataLength = data.length;
      if(chart_type == 'candlestick'){
        for (var i = 0; i < dataLength; i++) {
          ohlc.push([
            data[i][0], // the date
            parseFloat( data[i][1] ), // open
            parseFloat( data[i][2] ), // high
            parseFloat( data[i][3] ), // low
            parseFloat( data[i][4] ) // close
          ]);
        }
      }else{
        for (var i = 0; i < dataLength; i++) {
          ohlc.push([
            data[i][0], // the date
            parseFloat(data[i][6]) // close
          ]);
        }
      }
      return ohlc;
    }
