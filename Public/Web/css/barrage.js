/* @update: 2016-1-12 20:11:11 */ 
var getRandom=function(a,e){return parseInt(a+Math.random()*(e-a))},$barrageWrap=$(".barrage-con"),$barrageItem=$('<div class="stock-states stock-down">\u4eca\u5929\u4e2d\u77f3\u6cb9\u53d1\u529b\u4e86\uff01\uff01\uff01\u4f60\u4e70\u4e86\u4e48\u4f60\u4eec\u90fd\u4e70\u4e86\u4e48\uff1f\uff1f</div>'),winWidth=$(document).width();$barrageItem.css({top:getRandom(0,52),left:winWidth}).attr("barragenum",1),$barrageWrap.append($barrageItem);var w=$barrageItem.width(),r=getRandom(18e3,25e3);$barrageItem.animate({left:"-"+w},r,"linear",function(){$barrageItem.remove()}),setTimeout(function(){var a=$('<a class="ui-sidebar-block barrage-btn" href="javascript:"></a>');a.insertBefore($(".ui-sidebar-block").eq(0))},300);