define(function (require, exports, module) {
    var $ = require("jquery");

    exports.init = function(){
        var $header = $('.header');
        var st2 = $('.wraper-container').eq(1).offset().top;
        $(window).on('scroll',function(){
            var st = $(document).scrollTop();
            if(st >= st2){
                $header.addClass('light');
            }else{
                $header.removeClass('light');
            }
        });
    };

});