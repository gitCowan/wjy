define(function (require, exports, module) {
    var $ = require("jquery");
    exports.init = function(){
        var clientWid = $(window).width();
        if(clientWid < 1200){
            //default fold menu
            $('#menu').next('.mainWrap').css('margin-left', '50px');
        }

        $('#menu').on('click','.toggle-menu',function(){
            var $menu = $('#menu');
            if($menu.hasClass('shrink')){
                $('#menu').next('.mainWrap').css('margin-left', '50px');
            }else{
                $('#menu').next('.mainWrap').css('margin-left', '236px');
            }
        });
        
        //placeholder
        require('placeholder');
        $.fn.placeholder();
    
    };
});
