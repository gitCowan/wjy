// 基于准备好的dom，初始化echarts图表
var myChart = echarts.init(document.getElementById('main'));
option = {
	tooltip : {
		trigger: 'axis',
		formatter: function (params) {
			var res = params[0].seriesName + ' ' + params[0].name;
			res += '<br/>  开盘 : ' + params[0].value[0] + '  最高 : ' + params[0].value[3];
			res += '<br/>  收盘 : ' + params[0].value[1] + '  最低 : ' + params[0].value[2];
			return res;
		}
	},
	dataZoom : {
		show : false,  //true 显示下面进度条
		realtime: true,
		start : 10,
		end : 100
	},
	xAxis : [
		{
		   type : 'category',
			boundaryGap : true,
			axisTick: {onGap:false},
			splitLine: {show:false},
			data : {$apiTime}
		}
	],
	yAxis : [
		{
			type : 'value',
			scale:true,
			boundaryGap: [0.01, 0.01]
		}
	],
	series : [
		{
			name:'时间',
			type:'k',
			barMaxWidth: 20,
			itemStyle: {
				normal: {
					color: 'red',           // 阳线填充颜色
					color0: 'lightgreen',   // 阴线填充颜色
					lineStyle: {
						width: 2,
						color: 'orange',    // 阳线边框颜色
						color0: 'green'     // 阴线边框颜色
					}
				},
				emphasis: {
					color: 'black',         // 阳线填充颜色
					color0: 'white'         // 阴线填充颜色
				}
			},
			data:[ // 开盘，收盘，最低，最高
				{
					//value:[2320.26,2302.6,2287.3,2362.94], //蓝色
					itemStyle: {
						normal: {
							color0: 'blue',         // 阴线填充颜色
							lineStyle: {
								width: 3,
								color0: 'blue'      // 阴线边框颜色
							}
						},
						emphasis: {
							color0: 'blue'          // 阴线填充颜色
						}
					}
				},
				{$apiPrice}
			],
		}
	]
};
// 为echarts对象加载数据 
myChart.setOption(option);