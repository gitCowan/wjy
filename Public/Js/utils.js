define(function (require, exports, module) {
    var $ = require('jquery');
    require('validate');
    var ltIE10 = function(){
        var ua = navigator.userAgent;
        if(/MSIE 7.0/.test(ua) || /MSIE 8.0/.test(ua) || /MSIE 9.0/.test(ua)){
            return true;
        }else{
            return false;
        }
    };
    var ltIE9 = function(){
        var ua = navigator.userAgent;
        if(/MSIE 7.0/.test(ua) || /MSIE 8.0/.test(ua)){
            return true;
        }else{
            return false;
        }
    };
    var isIE7 = function(){
        var ua = navigator.userAgent;
        if(/MSIE 7.0/.test(ua)){
            return true;
        }else{
            return false;
        }
    };

    var hasFlash = function() {
        if(ltIE10()){
            (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) ?
                     navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin : false;
        }
    };

    var isInit = false;
    var singlePopover = function(options){
        options = options || {};
        var $popover;
        var container = options.container || '.wrapper';
        var placement = options.placement || 'bottom';
        var targetEl = options.target || 'body';
        var customClass = options.customClass || '';
        var title = options.title || '';
        var content = options.content || 'Popover Content';
        var left = options.left || '0';
        var top = options.top || '0';
        var cssTxt = 'left:'+ left +'px; top:'+ top +'px;';
        var tpl = '<div id="single-popover" style="'+ cssTxt +'" class="popover '+ placement +' '+ customClass +'">'+
            '<div class="arrow"></div>'+
            '<h3 class="popover-title">'+ title +'</h3>'+
            '<div class="popover-content">'+ content +'</div>'+
        '</div>';
        if(container){
            $popover = $('#single-popover');
            if(!$popover.get(0)){
                $(container).append(tpl);
            }else{
                if(placement){
                    var $title = $popover.find('.popover-title');
                    var $con = $popover.find('.popover-content');
                    $popover.css({
                        left: left+'px',
                        top: top+ 'px'
                    });
                    $popover.removeClass();
                    var cls = 'popover '+ placement +' '+ customClass;
                    $popover.attr('class', cls);
                    $title.html(title);
                    $con.html(content);

                }
            }

            options.init && options.init();

            $popover = $('#single-popover');
            $popover.on('close',function(){
                options && options.close && options.close();
                $popover.hide();
            });
            $popover.on('destroy',function(){
                $popover.remove();
            });
            $popover.on('show',function(){
                $popover.show();
            });
            $popover.show();

        }

        var clickFn = function(e){
            var $popover = $('#single-popover');
            var popover = $popover.get(0);
            if(!popover){
                return;
            }
            if(!$.contains(popover, e.target)){
                $popover.trigger('close');
            }
        };
        if(!isInit){
            $(document.body).on('click', clickFn);
            isInit = true;
        }

    };

    var spreadFooter = function(height){
        if(!height){return;}
        var $footer = $(document.body).find('footer:last');
        var $wrap = $('.mainWrap:first');
        var $main = $('main');
        var prevHeight = $wrap.height();

        $footer.css('margin-top', height+'px');
        $footer.on('recover',function(){
            $footer.css('margin-top','auto');
            $wrap.height(prevHeight);
            $main.height(prevHeight);
            setTimeout(function(){
                $wrap.height('auto');
                $main.height('auto');
            },100);
        });
    };
    function getUtf8BytesLen(str) {
        var m = encodeURIComponent(str).match(/%[89ABab]/g);
        var len = str.length + (m ? m.length : 0);
        return len;
    }
    function getUtf8Bytes(str,maxLen) {
        var reg = /[^\x00-\xff]/;
        if (getUtf8BytesLen(str) > maxLen) {
            var len = maxLen, i = 0;
            for (i; i < len; i++) {
                if (reg.test(str[i])) {
                    len = len - 2;
                }
            }
            return str.substr(0, len);
        }else{
            return str
        };
    }
    var setUtf8Bytes = function(options){
        var opts = options || {};
        var ele1 = opts.ele1;
        var ele2 = opts.ele2;
        var maxLen = opts.maxLen;
        maxLen = parseInt(maxLen,10);
        var labelEl = opts.labelElement;
        var $ele1 = $(ele1);
        var $ele2 = $(ele2);
        var changeFn = opts.change;
        var exceedFn = opts.exceed;
        if(!$ele1.get(0)){return;}
        if(!$ele2.get(0)){return;}
        var nowLen = 0,len = 0;
        var limitFn = function(){
            var $this = $(this);
            if ($this.attr('name') == 'notice-title') {
                len = getUtf8BytesLen($ele2.val());
            }
            if ($this.attr('name') == 'notice-content'){
                len = getUtf8BytesLen($ele1.val());
            };
            var remaLen = maxLen - len;
            
            var txt = $this.val();
            var substr = getUtf8Bytes(txt, remaLen);
            nowLen = getUtf8BytesLen(txt);

            if ( nowLen > remaLen) {
                $this.val(substr);
                exceedFn && exceedFn();
            }
            if($(labelEl).get(0)){
                if(nowLen <= remaLen){
                    $(labelEl).text(len+nowLen);
                }else{
                    $(labelEl).text(maxLen);
                }
            }
            changeFn && changeFn();
        };
        $ele1.off();
        $ele2.off();
        $ele1.on('input', limitFn);
        $ele2.on('input', limitFn);
        $ele2.trigger('input');
    };

    function getStrLen(str) {
        var len = 0, i = 0;
        var reg = /[^\x00-\xff]/;
        for (i; i < str.length; i++) {
            if (reg.test(str[i])) {
                len += 2;
            } else {
                len++;
            }
        }
        return len;
    }
    function getSubStr(str, maxLen) {
        var reg = /[^\x00-\xff]/;
        if (getStrLen(str) > maxLen) {
            var len = maxLen, i = 0;
            for (i; i < len; i++) {
                if (reg.test(str[i])) {
                    len = len - 1;
                }
            }
            return str.substr(0, len);
        } else {
            return str;
        }
    }
    var limitWord = function(options){
        var opts = options || {};
        var el = opts.element;
        var maxLen = opts.maxLen;
        maxLen = parseInt(maxLen,10);
        var labelEl = opts.labelElement;
        var $input = $(el);
        var changeFn = opts.change;
        var exceedFn = opts.exceed;
        if(!$input.get(0)){return;}
        var limitFn = function(){
            var $this = $(this);
            var txt = $this.val();
            var substr = getSubStr(txt, maxLen);
            var len = getStrLen(txt);
            if ( len > maxLen) {
                if(/Firefox/.test(navigator.userAgent)){
                    $this.blur();
                }
                $this.val(substr);
                exceedFn && exceedFn();
            }
            if($(labelEl).get(0)){
                if(len <= maxLen){
                    $(labelEl).text(len);
                }else{
                    $(labelEl).text(maxLen);
                }
            }
            changeFn && changeFn();
        };
        $input.on('propertychange', limitFn);
        $input.on('input', limitFn);
    };
    var ilng=$.cookie("i18next")||"zh-CN";
    function isChinese(){
        return ilng=="zh-CN";
    }
    Date.prototype.customFormat = function (fmt) {
        var o = {
            'y+': this.getFullYear(),
            'M+': this.getMonth() + 1,
            'd+': this.getDate(),
            'h+': this.getHours() % 12 === 0 ? 12 : this.getHours() % 12,
            'H+': this.getHours(),
            'm+': this.getMinutes(),
            's+': this.getSeconds(),
            'q+': Math.floor((this.getMonth() + 3) / 3),
            'S': this.getMilliseconds()
        };
        var today = new Date(),oldDay = this,tempDate = new Date();
        var toDouble = function(params){
            if (params < 10) {
                return '0'+params;
            } else {
                return params;
            }
        };
        if ( /(H+)/.test(fmt) ){
            tempDate.setDate(0);
            if ((today.getFullYear() === oldDay.getFullYear()) && (today.getMonth() === oldDay.getMonth()) && (today.getDate() === oldDay.getDate())) {
                fmt = i18n.t("global.Today")+' '+oldDay.getHours()+':'+toDouble(oldDay.getMinutes());
            } else if ((today.getFullYear() - oldDay.getFullYear()) >= 2){
                if(isChinese())
                    fmt = oldDay.getFullYear()+'年'+(oldDay.getMonth()+1)+'月'+oldDay.getDate()+'日';
                else
                    fmt = oldDay.getDate()+"/"+(oldDay.getMonth()+1)+"/"+oldDay.getFullYear();
            } else if ((today.getFullYear() - oldDay.getFullYear()) === 1){
                if ((oldDay.getMonth() === 11) && (oldDay.getDate() === 31) && (today.getMonth() === 0) && (today.getDate() === 1)) {
                    fmt = i18n.t("global.Yestday")+' '+oldDay.getHours()+':'+toDouble(oldDay.getMinutes());
                } else {
                    if(isChinese())
                        fmt = oldDay.getFullYear()+'年'+(oldDay.getMonth()+1)+'月'+oldDay.getDate()+'日';
                    else
                        fmt = oldDay.getDate()+"/"+(oldDay.getMonth()+1)+"/"+oldDay.getFullYear();
                }
            } else if (today.getFullYear() === oldDay.getFullYear()) {
                if ((today.getMonth() === oldDay.getMonth()) && (today.getDate() === oldDay.getDate())) {
                    fmt = i18n.t("global.Today")+' '+oldDay.getHours()+':'+toDouble(oldDay.getMinutes());
                } else if ((today.getMonth() === oldDay.getMonth()) && (today.getDate() - oldDay.getDate() === 1) || ((today.getMonth() - oldDay.getMonth() === 1) && (tempDate.getDate() === oldDay.getDate()) && (today.getDate() === 1))) {
                    fmt = i18n.t("global.Yestday")+' '+oldDay.getHours()+':'+toDouble(oldDay.getMinutes());
                } else {
                    if(isChinese())
                        fmt = (oldDay.getMonth()+1)+'月'+oldDay.getDate()+'日 '+oldDay.getHours()+':'+toDouble(oldDay.getMinutes());
                    else
                        fmt = oldDay.getDate()+"/"+(oldDay.getMonth()+1)+' '+oldDay.getHours()+':'+toDouble(oldDay.getMinutes());
                }
            } else {
                fmt = oldDay.getFullYear()+'-'+(oldDay.getMonth()+1)+'-'+oldDay.getDate()+' '+oldDay.getHours()+':'+toDouble(oldDay.getMinutes())+':'+toDouble(oldDay.getSeconds());
            }
        } else {
            fmt = oldDay.getFullYear()+'-'+(oldDay.getMonth()+1)+'-'+oldDay.getDate();
        }
        return fmt;
    };
    var modStoreFormat = function(str){
        if (isNaN(str)) {
            str = str+'';
            if (/(T+)/.test(str)) { 
                var parts = str.match(/\d+/g);
                var isoTime = Date.UTC(parts[0], parts[1] - 1, parts[2], parts[3], parts[4], parts[5]);
                str = new Date(isoTime);
            } else {
                str = str.replace(/\-/g,'\/');
            }
        } else{

        }
        return new Date(str).customFormat();
    };
    var ERRORSTATUS = 0,
        SUCCESSSTATUS = 1,
        INFOSTATUS = 2,
        WARNSTATUS = 3;

    function alertMessage(messageStatus, message) {
        message=message||i18n.t("common.error");
        var className = "";
        switch (messageStatus) {
            case ERRORSTATUS:
                className = "fail";
                break;
            case SUCCESSSTATUS:
                className = "succ";
                break;
            case INFOSTATUS:
                className = "fail";
                break;
            case WARNSTATUS:
                className = "fail";
                break;
        }

        var $str = $('<div id="errTop" class="err-top ' + className + '">'+
                '   <i class="err-close">'+
                '       <i class="icon-remove"></i>'+
                '   </i>'+
                '   <div class="err-out">'+
                '       <div class="err-switch">'+
                '           <i class="err-switch-i icon-smile"></i>'+
                '           <i class="err-switch-i icon-frown"></i>'+
                '           <span class="err-content">' + message + '</span>'+
                '       </div>'+
                '   </div>'+
                '</div>');
        $str.appendTo($("body"));
        $str.slideDown();

        $str.find(".icon-remove").on("click", function () {
            $(this).slideUp(400, function () {
                $str.remove();
            });
        });
        setTimeout(function () {
            $str.slideUp(400, function () {
                $str.remove();
            });
        }, 5000);
        $(".butterbar").removeClass("active").addClass("hide");
    }

    function toFixed(num,len) {
        var str = num.toString();
        if(len == 0){
            return Math.floor(num);
        }
        var reg = /\d+\.\d+/g;
        if (reg.test(str)) {
            return str.substring(0, str.indexOf('.') + len + 1);
        }
        str=str.replace('.0','');
        return str;
    }

    var placeholderForPwd = function(obj,options){
        var $this = obj;
        if ($this.next('span.placeholder')) {
            $this.next('span.placeholder').remove();
        }
        var position = $this.position();
        var left = position.left;
        var top = position.top;
        var width = $this.outerWidth();
        var height = $this.outerHeight();
        var indent = $this.css('text-indent');
        var options = options ||'';
        options.left = left + 'px';
        options.top = top + 'px';
        options.height = height + 'px';
        options['line-height'] = height + 'px';
        options['font-family'] = 'inherit';
        var style ="";
        for (var i in options) {
            style += i + ':' + options[i] + ';';
        }
        if (/(MSIE 8.0)/g.test(navigator.userAgent)||/(MSIE 9.0)/g.test(navigator.userAgent)){
            var place = $this.attr('placeholder');
            if ($this.val() == '') {
                $('<span class="placeholder" style = '+style+'>'+place+'</span>').insertAfter($this);
            }
            $this.next('span.placeholder').on('click', function(event) {
                if ($this.attr('disabled')) {
                    return;
                }
                $this.focus();
                $(this).remove();
            });
            $this.on('focus',function(event){
                $this.next('span.placeholder').remove();
            });
            $this.on('blur',function(event){
                if ($this.val() == '') {
                    $('<span class="placeholder" style = '+style+'>'+place+'</span>').insertAfter($this);
                }
                $this.next('span.placeholder').on('click', function(event) {
                    if ($this.attr('disabled')) {
                        return;
                    }
                    $this.focus();
                });
            });
            
        } else {
            return;
        }
    };
    var setBxSliderForModDetail = function(bxsliderB,el){
        if (bxsliderB > 1) {
            el.find('.bxslider').eq(0).bxSlider({
                preloadImages: 'visible',
                auto: false,
                infiniteLoop: true
            });
            
            el.find('.mod_detail_carousel .bx-controls').eq(0).show();
        } else{
            el.find('.mod_detail_carousel .bx-controls').eq(0).hide();
        }
    };

    function authentication (opt){
        opt.auth_form.validate({
            rules: {
                auth_idcard_name: {
                    required: true,
                },
                auth_idcard_num: {
                    required: true,
                    rangelength: [18, 18]
                },
                auth_bankcard: {
                    required: true,
                    rangelength: [16, 19]
                },
            },
            messages: {
                auth_idcard_name: {
                    required: '请输入真实姓名',
                },
                auth_idcard_num: {
                    required: '请输入身份证号',
                    rangelength: '请输入18位有效身份证号'
                },
                auth_bankcard: {
                    required: '请输入银行卡号',
                    rangelength: '请输入有效银行卡号'
                },
            },
            submitHandler: function(form){
                $(form).find('.btn-blue').attr('disabled', 'disabled');
                $.ajax({
                    url: '/uzapp/pm/wenqian/bankcard',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        appId: opt.appId,
                        user_name: $(form).find('#auth_idcard_name').val(),
                        user_identity: $(form).find('#auth_idcard_num').val(),
                        bank_card: $(form).find('#auth_bankcard').val(),
                    },
                })
                .done(function(data) {
                    if (data && data.status) {
                        opt.callback && opt.callback();
                    } else {
                        alertMessage(0, '验证失败');
                    }
                    
                })
                .fail(function() {
                })
                .always(function() {
                    $(form).find('.btn-blue').removeAttr('disabled');
                });
                
            }
        });
    };
    
    module.exports = {
        ltIE10: ltIE10,
        ltIE9: ltIE9,
        isIE7: isIE7,
        singlePopover: singlePopover,
        spreadFooter: spreadFooter,
        getStrLen: getStrLen,
        getSubStr: getSubStr,
        limitWord: limitWord,
        alertMessage: alertMessage,
        toFixed:toFixed,
        hasFlash: hasFlash,
        placeholderForPwd: placeholderForPwd,
        modStoreFormat: modStoreFormat,
        setBxSliderForModDetail: setBxSliderForModDetail,
        setUtf8Bytes:setUtf8Bytes,
        authentication: authentication
    };
});
