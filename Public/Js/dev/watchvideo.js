define(function (require, exports, module) {
    var $ = require('jquery');
    require('cookie');

    exports.init = function(){
        var roomId = window.location.search.split('roomId=')[1];
        if (roomId == '') {
            return false;
        };
        var loadVideo = $('#load-video');
        /*Duobei does not support the HTTPS protocol*/
        if (window.location.protocol == 'https:') {
            window.location.protocol = 'http';
        };
        loadVideo.attr('src', '/watchVideoDuobeiyun?roomId='+ roomId + '&_=' + new Date().getTime());
        $('.qrcode-box .btn-qrcode').on('click',function(){
            var $this = $(this),
            $parent = $this.parents('.qrcode-box');
            if ($parent.hasClass('qrcode-hide')) {
                $parent.removeClass('qrcode-hide');
            }else{
                $parent.addClass('qrcode-hide');
            };
        })
    };
});