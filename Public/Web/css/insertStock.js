/**
 * Des
 * Created by duqichao on 2015/9/16.
 * E-mail duqichao@jd.com
 * Update 2015/9/16
 */
var searchReplayList = function(){
    this.init();
};
searchReplayList.prototype = {
    init: function(){
        this.selectEle();
        this.bindEvent();
    },
    //选择元素
    selectEle: function(){
        this.mainWrap = $('.stock');
        this.proListWrap = $('#proReplayListWrap');
    },
    //事件绑定
    bindEvent: function(){
        var _this = this;
        this.mainWrap.delegate('.reply-details-info','mousedown', function(){
            _this.textArea = $(this).find('textarea');
            _this.liLocation = $(this).find('.text-location');
            //_this.insertBtn = $(this).find('.write-p-name');
        });
        this.curPos = 0;
        this.bSearch = false;
        this.bClose = true;
        this.curIndex = 0;
        this.mainWrap.delegate('.start-topic','keyup', function(event){
            var keyCode = event.which;
            if(_this.proListWrap.is(':visible')){
                if(keyCode == 38){
                    var len = _this.proListWrap.find('p').length;
                    if(len > 0){
                        _this.curIndex --;
                        if(_this.curIndex < 0) _this.curIndex = len - 1;
                        _this.selectItem(_this.curIndex);
                    }
                    return false;
                }else if(keyCode == 40){
                    var len = _this.proListWrap.find('p').length;
                    if(len > 0){
                        _this.curIndex ++;
                        if(_this.curIndex > len - 1) _this.curIndex = 0;
                        _this.selectItem(_this.curIndex);
                    }
                    return false;
                }else if(keyCode == 13){
                    _this.proListWrap.children().find('.curr').trigger('click');
                }
            }
            //判断是否可以请求数据
            if(_this.bSearch){
            	//已删掉$
                if(_this.oldPos > _this.curPos){
                    _this.bSearch = false;
                    _this.proListWrap.hide();
                    return;
                }
                var textAreaVal = _this.textArea.val();
	            var searchWords = _this.getSearchWords(textAreaVal, _this.oldPos);
	            _this.getProList(searchWords);
            }
        });
        this.mainWrap.delegate('.start-topic','keydown', function (event) {
            var keyCode = event.which;
            if(keyCode == 38 || keyCode == 40 || keyCode == 13){
                if(!_this.proListWrap.is(':hidden')){
                    return false;
                }
            }
            //$字符键入检
            if(event.shiftKey && event.which == 52){
                _this.getTextAreaScrollTop();
                //_this.getTextAreaScrollBottom();
                _this.getLiLocationScrollTop();
                if(_this.textAreaScrollTop || _this.textArea.get(0).scrollHeight > 180){
                    _this.liLocation.css('overflow-y','scroll');
                    _this.liLocation.scrollTop(1000);
                }else{
                    _this.textAreaScrollTop = 0;
                    _this.liLocationScrollTop = 0;
                    _this.liLocation.css('overflow','hidden');
                }

                //获取光标位置
                _this.curPos = _this.getCursorPos($(this).get(0))+1;
                //光标前的字符
                _this.cursorBeforeWords = _this.getCursorBeforeWords();
                //alert("光标前的字符=="+_this.cursorBeforeWords);
                //光标后的字符
                _this.cursorAfterWords = _this.getCursorAfterWords();
                //alert("光标前的字符=="+_this.cursorAfterWords);
                //获取光标前的字符，插入到列表定位元素HTML中。
                _this.updateLocationHtml(_this.cursorBeforeWords);

                //记录$后的位置
                _this.oldPos = _this.curPos;
                _this.bSearch = true;
            }
        });
        this.mainWrap.delegate('.start-topic','click', function () {
            _this.curPos = _this.getCursorPos($(this).get(0));
            //文本框变高
            $(this).animate({height: 72}, 200);
        });
        this.mainWrap.delegate('.start-topic','blur', function () {
            _this.bSearch = false;
            setTimeout(function(){
                if(_this.bClose){
                    _this.proListWrap.hide();
                }
            },500);
        });
        this.insertTextArea();

        this.mainWrap.delegate('.insert-stock','click',function(){
        	//文本框变高
            _this.textArea.animate({height: 72}, 200);
            _this.proListWrap.show();

            _this.curPos = _this.getCursorPos(_this.textArea.get(0));
            _this.oldPos = _this.curPos;
            //光标前的字符
            _this.cursorBeforeWords = _this.getCursorBeforeWords();
            //光标后的字符
            _this.cursorAfterWords = _this.getCursorAfterWords();

            //文本框为空
            if(_this.textArea.val()){
                var insertText = '$';
                var len = insertText.length;
                //文本框值拼接
                var html = _this.cursorBeforeWords + insertText + _this.cursorAfterWords;
                //设置值
                _this.textArea.val(html);

                var pos = _this.cursorBeforeWords.length + len;

                _this.curPos = _this.getCursorPos($(this).get(0));

                //设置文本框焦点
                _this.setCursorPos(_this.textArea.get(0), pos);
            }else{
                _this.textArea.val('$');
                _this.setCursorPos(_this.textArea.get(0), 1);
            }

            //获取光标位置
            _this.curPos = _this.getCursorPos(_this.textArea.get(0));
            _this.getTextAreaScrollTop();
            //_this.getTextAreaScrollBottom();
            _this.getLiLocationScrollTop();
            if(_this.textAreaScrollTop || _this.textArea.get(0).scrollHeight > 180){
                _this.liLocation.css('overflow-y','scroll');
                _this.liLocation.scrollTop(1000);
            }else{
                _this.textAreaScrollTop = 0;
                _this.liLocationScrollTop = 0;
                _this.liLocation.css('overflow','hidden');
            }

            //获取光标前的字符，插入到列表定位元素HTML中。
            _this.updateLocationHtml(_this.cursorBeforeWords);
            //记录$后的位置
            _this.oldPos = _this.curPos;
            _this.bSearch = true;
            _this.bClose = false;
        });

        this.hideLayer();
    },
    //点击
    hideLayer: function(){
        var _this = this;
        $(document).click(function(event){
            var $target = $(event.target);
            if($target.attr('class') != 'insert-stock'){
                _this.proListWrap.hide();
            }
        });
    },
    //点击搜索列表插入到文本框
    insertTextArea: function(){
        var _this = this;
        this.proListWrap.delegate('p','click', function(){
            var insertText = '$'+$(this).text()+'$ ';
            var len = insertText.length;
            //文本框值拼接
            var html = _this.cursorBeforeWords + insertText + _this.cursorAfterWords;
            //设置值
            _this.textArea.val(html);

            var pos = _this.cursorBeforeWords.length + len;

            _this.curPos = _this.getCursorPos($(this).get(0));

            //设置文本框焦点
            _this.setCursorPos(_this.textArea.get(0), pos);

            //清空搜索列表
            _this.proListWrap.find('p').remove();

            _this.proListWrap.hide();
            _this.bClose = true;
        })
    },
    //
    selectItem: function(index){
        this.proListWrap.find('p').removeClass('curr').eq(index).addClass('curr');
    },
    //获取光标位置
    getCursorPos: function(ctrl){
        var CaretPos = 0;
        if(document.selection) {// IE Support
            ctrl.focus();
            var Sel = document.selection.createRange();
            var Sel2 = Sel.duplicate();
            Sel2.moveToElementText(ctrl);
            CaretPos = -1;
            while(Sel2.inRange(Sel)){
                Sel2.moveStart('character');
                CaretPos++;
            }
        }else if(ctrl.selectionStart || ctrl.selectionStart == '0'){// Firefox support
            CaretPos = ctrl.selectionStart;
        }
        return (CaretPos);
    },
    //设置光标位置
    setCursorPos: function(ctrl, pos){
        if(ctrl.setSelectionRange){
            ctrl.focus();
            ctrl.setSelectionRange(pos,pos);
        }
        else if (ctrl.createTextRange) {
            var range = ctrl.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    },
    //获取光标前字符
    getCursorBeforeWords: function(){
        var _this = this;
        var textAreaVal = this.textArea.val();
        return textAreaVal.substring(0, _this.curPos);
    },

    //获取光标后字符
    getCursorAfterWords: function(){
        var _this = this;
        var textAreaVal = this.textArea.val();
        return textAreaVal.substring(_this.curPos, textAreaVal.length);
    },

    //获取搜索关键字
    getSearchWords: function(str, oldPos){
        this.curPos = this.getCursorPos(this.textArea.get(0));
        var subStr = str.substr(0, this.curPos);
        var newSubStr = subStr.substring(oldPos);
        return(newSubStr)
    },

    //发送接口请求列表
    getProList: function(keywords){
        var _this = this;
        this.oldKeyWords = keywords;
        this.curIndex = 0;
        var temp = getRootPath();
        if(keywords==null || keywords=='' || keywords=='$'){
        	return;
        }
        $.ajax({
            url: temp+'/stock/searchCodeProduct',
            //url: '//gupiao.jd.com/stock/searchCodeProduct',
            dataType: 'jsonp',
            data: {
                keyWord: /*encodeURI(keywords)*/keywords
            },
            success: function(data){
                if(data.success && data.singleData){
                    _this.initProList(data.singleData);
                }
            }
        });
        /*return [{
        name: '易方达科讯易方达科讯',
        sku: '101012'
        },{
        name: '易方达科讯 fdsafdsafdsa',
        sku: '101012'
        },{
        name: '易方达科讯439393',
        sku: '101012'
        }];*/
    },
    getTextAreaScrollTop: function(){
        this.textAreaScrollTop = this.textArea.scrollTop();
        return this.textAreaScrollTop;
    },
    /*getTextAreaScrollBottom: function(){
     this.textAreaScrollBottom = this.textArea.scrollBottom();
     return this.textAreaScrollBottom;
     },*/
    getLiLocationScrollTop: function(){
        this.liLocationScrollTop = this.liLocation.scrollTop();
        return this.liLocationScrollTop;
    },

    //更新定位元素HTML
    updateLocationHtml: function(cursorBeforeWords){
        this.liLocation.html(cursorBeforeWords+'<b>|</b>');
        //显示搜索列表
        this.showProList();
    },
    //获取弹层位置
    getLocation: function(){
        var _this = this;
        var $locationEle = _this.liLocation.find('b');
        var $locationWrapHeight = _this.liLocation.height();
        return {left:$locationEle.offset().left, top: $locationEle.offset().top+28 - (_this.textAreaScrollTop - _this.liLocationScrollTop)};
    },
    //显示弹层列表
    showProList: function(){
        var _this = this;
        var oPos = this.getLocation();
        _this.proListWrap.show().css({top:oPos.top,left:oPos.left})
        /*.html('列表定位成功！')*/;
    },
    initProList: function(data){
        var _this = this;
        var searchListHtml = '';
        for(var i = 0; i < data.length; i ++){
            var proName = data[i].itemName;
            if(i == 0){
                searchListHtml += '<p class="curr"><a href="javascript:">'+proName+'('+data[i].itemCode+')</a></p>'
            }else{
                searchListHtml += '<p><a href="javascript:">'+proName+'('+data[i].itemCode+')</a></p>'
            }
        }
        _this.proListWrap.find('.proList').html(searchListHtml);
    }
};
$(function(){
    new searchReplayList();
});
//js获取项目根路径，如： //localhost:8083/uimcardprj
function getRootPath(){
	var protocol = window.document.location.protocol; 
	var hostname = window.document.location.hostname;
	var url = protocol +"//"+ hostname
    //获取当前网址，如： //localhost:8083/uimcardprj/share/meun.jsp
    //var curWwwPath=window.document.location.href;
    //获取主机地址之后的目录，如： uimcardprj/share/meun.jsp
    //var pathName=window.document.location.pathname;
   // var pos=curWwwPath.indexOf(pathName);
    //获取主机地址，如： //localhost:8083
    //var localhostPaht=curWwwPath.substring(0,pos);
    //获取带"/"的项目名，如：/uimcardprj
    //var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
    return url;
}
