//领涨股，领跌股

function StockGain(url){
    this.url = url;
};
StockGain.prototype.init = function(){
    this.getData();
};
StockGain.prototype.getData = function(){
    var thisObj = this;
    $.post(thisObj.url,function(data){
        if(data.result){
            var list = data.data;
            if(list != null && list.length >0 ){
                for(var i= 0; i < list.length; i++ ){
                    if( !list[i].name || !list[i].price || !list[i].sortedData ){
                        continue;
                    }
                    var clone = thisObj.makeHtml(list[i]);
                    $("#stockGain").children(".list-details").find("tbody").append($(clone));
                }
            }
        }

    },"json");
};

StockGain.prototype.makeHtml = function( stock ){
    var cloneTrHtml = $("#cloneTr").clone();
    var codeHtml = '<a target="_blank" style="color:#a5a5a5" href="/'+stock.code+'">'+stock.name+'</a>';
    $(cloneTrHtml).children(".fore1").html(codeHtml);
    $(cloneTrHtml).children(".fore2").html(parseFloat(stock.price).toFixed(2));
    if( stock.sortedData > 0){
        $(cloneTrHtml).children(".fore3").addClass("font-red");
    }else if(stock.sortedData < 0){
        $(cloneTrHtml).children(".fore3").addClass("font-green");
    }
    $(cloneTrHtml).children(".fore3").html(stock.sortedData.toFixed(2)+"%");
    return $(cloneTrHtml).removeAttr("id").show();
};


//领涨股，领跌股
$("#stockGain").children(".slide-tab-title").children("li").click(function(){
    //if($(this).hasClass("curr")){
    //    return ;
    //}
    $("#stockGain tr").filter(":visible").remove();
    $(this).siblings().removeClass("curr");
    $(this).addClass("curr");
    var url = "/stock/"+$(this).attr("url")+".html";
    var stockGain = new StockGain(url);
    stockGain.init();
});