


//新闻
$(document).on("click","#stock_info_tab > .slide-tab-title > li",function(){
    $(this).addClass("curr").siblings().removeClass("curr");
    var  url = $(this).attr("url");
    var  tab = $(this).attr("tab");
    stockTabChange(url,tab);
});

//tab页切换
function stockTabChange( url , tab , pageNo){
    $("#stock_info_tab").children("ul.news").remove();
    $("#stock_info_tab").children("div.stock-score").remove();
    $("#stock_info_tab").children("div.stock-fund-tab").remove();
    //移除分页和没有数据的显示
    $("#stock_info_tab").find(".page,.stock-no-tab").remove();
    $("div.jiankuang").hide();
    if( url ){
        $.post("/sInfo/"+url+".html",{"code":code,"market":market,"pageNo":pageNo},function(data){
            if($("#stock_info_tab").children("ul.news").length || !$("div.jiankuang").is(":hidden") || $("div.stock-score").length || $("div.stock-fund").length ){
                return ;
            }
            $("ul.stock-info-news").after(data);
        });
    }else{
        $("#tab_"+tab).show();
    }
};

//个股下tab的分页
function gotoNewsPage(pageNo){
    var _infoTabWrap = $("#stock_info_tab li.curr");
    var url = _infoTabWrap.attr("url");
    var tab = _infoTabWrap.attr("tab");
    stockTabChange(url, tab, pageNo);

}
