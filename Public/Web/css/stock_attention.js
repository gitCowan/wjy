var Attention = function (code, isAttr) {
    this.code = code;
    this.isAttr = isAttr;
}
Attention.prototype = {
    execute: function (targetUrl) {
        var attention = this;
        var code = attention.code;
        var url = this.isAttr ? "/stock/c_stock.html" : "/stock/att_stock.html";
        jQuery.ajax({
            url: url,
            dataType: "jsonp",
            type: "post",
            data: {"code": code},
            success: function (data) {
                if (data.result) {
                    if (targetUrl) {
                        window.location.href = targetUrl;
                    } else {
                        attention.display(data);
                    }
                } else {
                    attention.showError(data);
                }
            }
        });
    },
    display: function (data) {
        var isAttr = this.isAttr;
        var attentionCnt_b = isNaN(parseInt($("#att_count").val())) ? 0 : parseInt($("#att_count").val());
        var attentionCnt = isAttr ? attentionCnt_b - 1 : attentionCnt_b + 1;
        $("#att_count").val(attentionCnt);
        $("span.att_count").html(attentionCnt + "人加自选");

        var id = isAttr ? "cancleAttr-btn" : "attr-btn";
        var toId = isAttr ? "attr-btn" : "cancleAttr-btn";
        var nowClass = isAttr ? "ui-button-blue" : "border-button-gray";
        var toClass = isAttr ? "border-button-gray" : "ui-button-blue";
        var text = isAttr ? "+自选" : "已自选";
        $("#" + id).empty().addClass(nowClass).attr("id", toId).html(text).removeClass(toClass);
    },
    showError: function (data) {
        //改为统一样式的弹框
        var OpenCountBox = null;
        seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function (openCountBox) {
            OpenCountBox = openCountBox;
        });
        $("#alertMsgForAllWindowsTitle").html("添加自选失败！")
        $("#alertMsgForAllWindowsContent").html("*" + data.msg + "!");
        OpenCountBox.showLayer($("#alertMsgForAllWindows"));
    }
};

//加入自选
$(document).off("click", "#attr-btn");
$(document).on('click', '#attr-btn', function () {
    seajs.use('//static.360buyimg.com/finance/common/unit/login/1.0.0/login.js', function (login) {
        login(function () {
            var attr = new Attention(code, false);
            attr.execute();
        });
    });
});

//取消自选
$(document).off("click", "#cancleAttr-btn");
$(document).on('click', '#cancleAttr-btn', function () {
    seajs.use('//static.360buyimg.com/finance/common/unit/login/1.0.0/login.js', function (login) {
        login(function () {
            var attr = new Attention(code, true);
            attr.execute();
        });
    });
});

$(document).on("mouseover", '#cancleAttr-btn', function () {
    var cancleBtnWrap = $(this);
    if (cancleBtnWrap.html() == '已自选') {
        cancleBtnWrap.html("取消自选");
    }
});

$(document).on("mouseout", '#cancleAttr-btn', function () {
    var cancleBtnWrap = $(this);
    if (cancleBtnWrap.html() == '取消自选') {
        cancleBtnWrap.html("已自选");
    }
});


//策略关注
var Strategy = function (sId) {
    this.sId = sId;
};
Strategy.prototype = {
    execute: function () {
        var strategy = this,
            sid = strategy.sId,
            url = "/huitou/subStr.html";
        jQuery.ajax({
            url: url,
            dataType: "json",
            type: "post",
            data: {"sId": sid},
            success: function (data) {
                if (data.res) {
                    strategy.display(data);
                } else {
                    strategy.showError(data);
                }
            }
        });
    },
    display: function (data) {
        var sid = data.sid;
        var currentPerson_b = isNaN(parseInt($("#strategy_currentPerson_"+sid).val())) ? 0 : parseInt($("#strategy_currentPerson_"+sid).val());
        var maxPerson_b = isNaN(parseInt($("#strategy_maxPerson_"+sid).val())) ? 0 : parseInt($("#strategy_maxPerson_"+sid).val());
        var personCnt = currentPerson_b + 1;
        $("#expert_strSub_msg_"+sid).html("已订" + personCnt + " 人/满额" + maxPerson_b + " 人");
        $("#expert_strSub_disabled_"+sid).show();
        $("#expert_strSub_"+sid).hide();
    },
    showError: function (data) {
        //改为统一样式的弹框
        var OpenCountBox = null;
        seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function (openCountBox) {
            OpenCountBox = openCountBox;
        });
        $("#alertMsgForAllWindowsTitle").html("订阅失败！")
        $("#alertMsgForAllWindowsContent").html("*" + data.msg + "!");
        OpenCountBox.showLayer($("#alertMsgForAllWindows"));
    }
};

$(document).on('click', '.expert_strSub_btn', function () {
    var strId = $(this).attr("str_id");
    seajs.use('//static.360buyimg.com/finance/common/unit/login/1.0.0/login.js', function (login) {
        login(function () {
            var str = new Strategy(strId);
            str.execute();
        });
    });
});

//牛人主页加载更多
var StrategyMoreBox = null;
seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function (StrategyBox) {
    StrategyMoreBox = StrategyBox;
});

var StrategyHistory = function (expertId) {
    this.expertId = expertId;
    this._strategyWarp = $("#expertStrategyHistoryBox");
    this._strategyWarp.find(".u-tlist").children("li").remove();
    this.huitouUrl = $("#huitouUrl").val();
}
StrategyHistory.prototype = {
    execute: function (pageNo) {
        var history = this;
        var expertId = history.expertId;
        var url = "/huitou/straList.html";
        jQuery.ajax({
            url: url,
            dataType: 'JSON',
            type: "post",
            data: {"expertId": expertId, "pageNo": pageNo},
            success: function (data) {
                if (data.result) {
                    history.display(data);
                } else {
                    history.showError(data);
                }
            }
        });
    },
    display: function (data) {
        var _warp = this._strategyWarp;
        _warp.find(".ch-tid").html(EXPERTNAME + "-慧投策略");
        var strategyList = data.paginator.datas;
        var pageNum = data.paginator.pageNum;
        var nextPage = data.paginator.nextPage;

        for (var i = 0; i < strategyList.length; i++) {
            var _li = this.initLi(strategyList[i], i , pageNum);
            var _warpUl = _warp.find(".u-tlist");
            _warpUl.append(_li);
        }

        $(".expert_strategy_more_loadBtn").remove();//去除更多按钮
        if (pageNum != nextPage) {//不相等才能有更多按钮
            _warpUl.append(this.loadMore());
            this.loadEvent(nextPage);
        }
        if(pageNum && pageNum==1 ){
            StrategyMoreBox.showLayer($("#expertStrategyHistoryBox"));
        }
    },
    initLi: function (strategy, index , pageNum) {
        //只有status为0的时候可以订阅
        var stHtml = '';
        if(strategy.currentPerson!=strategy.maxPerson){
            if (strategy.status == 4) {
                stHtml = '<a href="javascript:;" class="now-d yi-ding">策略已达成</a>';
            } else {
                if (strategy.status == 0 && !strategy.userState) {
                    stHtml= '<input id="strategy_currentPerson_'+strategy.id+'" type="hidden" value="'+strategy.currentPerson+'">'+
                        '<input id="strategy_maxPerson_'+strategy.id+'" type="hidden" value="'+strategy.maxPerson+'">'+
                        '<a id="expert_strSub_'+strategy.id+'" href="javascript:;" class="now-d expert_strSub_btn" str_id="'+strategy.id+'">立即订阅</a>'+
                        '<a id="expert_strSub_disabled_'+strategy.id+'" href="javascript:;" class="now-d yi-ding" style="display: none" onmouseover="return false;">已订阅</a>';
                } else if (strategy.userState == 1) {
                    stHtml = '<a href="javascript:;" class="now-d yi-ding">已订阅</a>';
                }else {
                    stHtml = '<a href="javascript:;" class="now-d yi-ding">未订阅</a>';
                }
            }
        }else{
            stHtml = '<a href="javascript:;" class="now-d yi-ding">已满额</a>';
        }

        var liHtml = '<li class="clearfix ' + (index == 0 && pageNum==1 ? 'li-1' : '') + ' ">' +
            '<div class="gu-f1">' +
            '<div class="gu-tit">' + strategy.rate + '<span class="m-s">%</span></div>' +
            '<div class="gu-text">目标收益率</div>' +
            '<div class="xian"></div>' +
            '</div>' +
            '<div class="gu-f2">' +
            '<div class="f2-tit">' + '<a href="'+this.huitouUrl+'/huitou/fp/index?sid='+strategy.id+'" target="_blank" style="color:#323232">'+ strategy.strategyName + '</a>' +(strategy.status == 4?'': ' <span class="bg-red '+ (this.loadStatus(strategy)=='进行中'?'bglan':'') + ' ">') + this.loadStatus(strategy) + ' </span></div>' +
            '<div class="gu-text">计划天数 ' + strategy.incomeDay + ' 天</div>' +
            '</div>' +
            '<div class="gu-f3 clearfix">' +
            stHtml +
            '<div id="expert_strSub_msg_'+strategy.id+'" class="n-sam-text">已订' + strategy.currentPerson + ' 人/满额' + strategy.maxPerson + ' 人</div>' +
            '</div>' +
            '<div class="wrap-border"></div>' +
            '</li>';
        return liHtml;
    },
    loadMore: function () {
        var moreHtml = '<div class="load-btn expert_strategy_more_loadBtn" style="text-align: center;margin-top:15px;margin-bottom:15px;">' +
            '<a class="ui-button-blue expert_strategy_more_btn" href="javascript:" >加载更多</a>' +
            '</div>';
        return moreHtml;
    },
    loadEvent: function (pageNum) {
        var _this = this;
        $(".expert_strategy_more_btn").click(function () {
            _this.execute(pageNum);
        });
    },
    loadStatus: function (strategy) {
        var statusDesc = "";
        if (strategy.yn == 1) {
            statusDesc = "已下架";
        } else {
            switch (strategy.status) {
                case 0:
                case 1:
                    statusDesc = "未发布";
                    break;
                case 2:
                case 3:
                    statusDesc = "进行中";
                    break;
                //case 4:
                //    statusDesc="已达成";
                //    break;
                case 5:
                    statusDesc="未达成";
                    break;
                case 6:
                    statusDesc = "已删除";
                    break;
            }
        }
        return statusDesc;
    },
    showError: function (data) {
        //改为统一样式的弹框
        var OpenCountBox = null;
        seajs.use('//static.360buyimg.com/finance/financial/common/module/popup/1.0.0/js/popup.js', function (openCountBox) {
            OpenCountBox = openCountBox;
        });
        $("#alertMsgForAllWindowsTitle").html("查询慧投策略失败！")
        $("#alertMsgForAllWindowsContent").html("*" + data.msg + "!");
        OpenCountBox.showLayer($("#alertMsgForAllWindows"));
    }
};
$(document).on("click", "#showStrategyMoreBtn", function () {
    var shistory = new StrategyHistory($("#expertId").val());
    shistory.execute(1);
});
$(document).on("click", ".StrategyHistoryClose", function () {
    StrategyMoreBox.hideLayer($("#expertStrategyHistoryBox"));
});
