$(document).ready(function(){
    var Hc = new window.Hc($("#container"));
	Hc.addSeries(type,interval);
	Hc.setData( JSON.parse(data) );
});



