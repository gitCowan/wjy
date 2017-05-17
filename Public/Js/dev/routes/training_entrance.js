define(function (require, exports, module) {
    var $ = require('jquery');
    require('cookie');
    var util = require('./utils.js');
    exports.init = function(){
        var getPayStatus;
        var openPay = true;
        var countDownTime;
        $('.room-start-btn').on('click', function(event) {
            var $this = $(this);
            if (!openPay) {
                return;
            };
            openPay = false;
            
            var ispay = $this.attr('data-ispay');
            if (ispay == '1' && $this.hasClass('comming')) {
                var time = $this.next('.room-start-time').text();
                $('#courseNotice .course-time').text(time)
                $('#courseNotice').modal({
                    show:true
                })
                openPay = true;
            }else if (ispay == '0'){
                getQrcode();
            };
            
            
        });
        $('#dataDownload').on('click',function(){
            var $this = $(this),
            ispay = $this.attr('data-ispay');
            if (ispay == '0') {
                $('.room-start-btn:first').trigger('click');
                return;
            }else if (ispay == '1') {

            };

        })
        $('.room-start-btn:first').trigger('click');
        $('#exclusive').on('click',function(){
            if (!openPay) {
                return;
            };
            openPay = false;
            var ispay = $(this).attr('data-ispay');
            if (ispay == '0') {
                getQrcode();
            }
        })
        $('#courseNotice .conmit').click(function(){
            $('#courseNotice').modal('hide');
        });
        $('#buyVideo .close').on('click',function(){
            clearTimeout(getPayStatus);
            getPayStatus = '';
        })
        function getQrcode(){
            $.ajax({
                url:'/checkUserPay',
                type:'GET',
                success:function(data,textStatus,jqXHR){
                    if (jqXHR.status == 200 || jqXHR.status == 304) {
                        if (data.status) {
                            $('#buyVideo .now-price').text('￥'+data.price);
                            $('#buyVideo .old-price').text('￥'+data.official_price);
                            createQrcode($('.qrcode .weixin'),'weixin://'+data.weixinLink);
                            createQrcode($('.qrcode .taobao'),'https://'+data.taobaoLink);
                            setTime(data.leftTime)
                            $('#buyVideo').modal({
                                show:true
                            });
                            clearTimeout(getPayStatus);
                            getPayStatus = '';
                            getOrderState();
                        };
                    }
                    openPay = true;
                },
                error:function(data){
                    openPay = true;
                }
            })
        }
        function getOrderState(){
            $.ajax({
                url:'getOrderState',
                type:'GET',
                success:function(data){
                    if (data.status) {
                        if (data.state == 3) {
                            clearTimeout(getPayStatus);
                            getPayStatus = '';
                            $('#buyVideo').modal('hide');
                            $('#buySuccess').modal({
                                show:true
                            });
                            var countdown = 5;
                            var closeBuySuc = setInterval(function(){
                                countdown--;
                                if (countdown == 0) {
                                    clearInterval(closeBuySuc);
                                    countdown = 5;
                                    $('#buySuccess').modal('hide');
                                    openPay = true;
                                    window.location.reload();
                                };
                                $('#buySuccess .time').text(countdown);
                            },1000);
                            $('.room-start-btn').attr('data-ispay','1');
                        }else if (data.state == 4) {

                        }else{
                            getPayStatus = setTimeout(getOrderState,2000);
                        };
                    }
                },
                error:function(data){
                }
            })
        }
        require('../jquery/jquery.qrcode.min.js');
        var createQrcode = function(el,qrcodeUrl){
            var $this = $(el);
            var size = 120;
            qrcodeUrl = qrcodeUrl || '';
            $this.empty().qrcode({
                ecLevel: 'L',
                render:'image',
                size: size,
                text:qrcodeUrl
            });
        };
        function setTime(time){
            clearInterval(countDownTime);
            countDownTime = '';
            var timeEle = $('#countdown');
            countDownTime = setInterval(function(){
                if (time == 0) {
                    clearInterval(countDownTime);
                    return;
                };
                time--;
                var num = time/60/60/24;
                day = num > 1 ? Math.round(num) : 0;
                hours = Math.floor(time/60/60%60);
                minutes = Math.floor(time/60%60);
                secend = Math.floor(time%60);
                hours = hours.toString().length ==1 ? '0'+hours : hours;
                minutes = minutes.toString().length ==1 ? '0'+minutes : minutes;
                secend = secend.toString().length ==1 ? '0'+secend : secend;
                if (day > 0) {
                    timeEle.text(day+'天');    
                }else{
                    timeEle.text(hours+':'+minutes+':'+secend);    
                };
                
            }, 1000);
        }
        var videojs;
        if(!util.ltIE9()) {
            videojs =require("video/video.js");
            videojs.options.flash.swf = "/libs/video/video-js.swf";
        }

        $('.course-cont').on('click', 'a', function(event) {
            var $this = $(this);
            var isVeo = $this.attr('data-veo');
            if (isVeo == 1) {
            } else {
                event.preventDefault();
                getQrcode();
                return;
            }

        });

        var myvideo;
        $('#courseFree .video-box').on('click',function(event){
            var $this = $(this),
            isVeo = $this.attr('data-veo') || '0',
            id = $this.attr('data-id'),
            url;
            if (isVeo == '0') {
                getQrcode();
                return;
            };
            $.ajax({
                url:'/watchGiftVideo',
                type:'POST',
                data:{
                    id:id
                },
                success:function(data){
                    if (data.status) {
                        url = data.result;
                        if(util.ltIE9()) {
                            var unsupport = '<div id="xcontainer"><h1>'+ i18n.t('appInfo.notice3') +'</h1><table class="browsers"><tr><td><a class="clearfix" href="https://www.google.com/chrome/browser/" target="_blank"><img src="img/browser/chrome.png" alt="Download Chrome"><p>Chrome</p></a></td><td><a class="clearfix" href="http://www.firefox.com.cn/" target="_blank"><img src="img/browser/firefox.png" alt="Download Firefox"><p>Firefox</p></a></td><td><a class="clearfix" href="http://www.apple.com/cn/safari/" target="_blank"><img src="img/browser/safari.png" alt="Download Safari"><p>Safari</p></a></td><td><a class="clearfix" href="http://www.opera.com/zh-cn" target="_blank"><img src="img/browser/opera.png" alt="Download Opera"><p>Opera</p></a></td><td><a class="clearfix" href="http://windows.microsoft.com/ie" target="_blank"><img src="img/browser/ie.png" alt="Download IE"><p>IE</p></a></td></tr></table><div class="suggestion"><table><tr><td class="words"><p>'+ i18n.t('appInfo.notice4') +'</p><p>'+ i18n.t('appInfo.notice5') +'</p></td></tr></table></div><div class="footer"><p>Copyright&nbsp;&nbsp;&copy;&nbsp;&nbsp;2014&nbsp;&nbsp;www.apicloud.com </p></div></div>';
                            $(".modalx .content").html(unsupport);
                        }else {
                            if(!myvideo) {
                                var wRadio = 1092 / 1366;
                                var wvideo = $("body").width() * wRadio;
                                var hvideo = wvideo * 768 / 1366;
                                var $videoContent = '<video oncontextmenu=self.event.returnValue=false id="k-video" class="video-js vjs-default-skin" controls  preload="none" poster="/img/appvideo.jpg" width="' + wvideo + '" height="' + hvideo + '">' +
                                    '<source src="'+url+'" type="video/mp4">' +
                                    '</video>';
                                $(".modalx .content").html($videoContent);
                                videojs("k-video", { }, function () {
                                    myvideo = this;
                                    setTimeout(function () {
                                        myvideo && myvideo.play();
                                    }, 300);
                                });
                            }else{
                                myvideo && myvideo.play();
                                $(".modalx .vjs-control-bar").css("visibility","visible");
                            }
                        }
                        $(".modalx").css("visibility","visible");
                    };
                }
            })
            var eve = event || window.event;
            eve.preventDefault();
        })
        $(".modalx .close").on("click",function(){
            if(myvideo) {
                myvideo.pause();
                myvideo.dispose();
                myvideo=null;
            }
            $(".modalx .vjs-control-bar").css("visibility","hidden");
            $(".modalx").css("visibility","hidden");

        });
    };
});