define(function (require, exports, module) {
    'use strict';
    var $ = require('jquery');
    require('cookie');
    var Handlebars = require('Handlebars');
    var appid = $.cookie('curAppId');
    require('validate');
    require('icheck');
    require('jqui');
    var errors=require("cadErrors");
    var util = require('./utils.js');


    exports.init = function(){
        var curAppType = $.cookie('appType');
       
        $('#historyType').iCheck('uncheck');

        var $eng = $('#engine');
        var $engInput = $('#engineId');

        var $platform = $('#platform-area');
        $platform.find('a.pf-name').on('click',function(){
            var $this = $(this);
            var $pack = $this.find('td.pack');

            if ($this.hasClass('android')) {
                $platform.find('.pf-name.tencent').removeClass('checked');
                $platform.find('.pf-name.tencent td.pack').hide();
                $platform.find('.pf-name.tencent input[type="checkbox"]').removeAttr('checked');
            } else if($this.hasClass('tencent')){
                $platform.find('.pf-name.android').removeClass('checked');
                $platform.find('.pf-name.android td.pack').hide();
                $platform.find('.pf-name.android input[type="checkbox"]').removeAttr('checked');
            } else{

            }

            $this.toggleClass('checked');
            $pack.toggle();

            var $chk = $this.find('input[type="checkbox"]');
            if($this.hasClass('checked')){
                $chk.attr('checked','checked');
            }else{
                $chk.removeAttr('checked');
            }
        });

        $('#toggleHistory').on('click',function(){
            var $this = $(this);
            var $history = $('#pack-history');
            $this.toggleClass('up');

            if($this.hasClass('up')){
                $history.find('table').show();
                $history.find('a.more').css('display','block');
            }else{
                $history.find('table').hide();
                $history.find('a.more').hide();
            }

            return false;
        });
        
        var $hisTable = $('#pack-history table');
        $hisTable.on('mouseover','tr',function(){
            var $this = $(this);
            var $succ = $this.find('.succ');
            var $err = $this.find('.err');
            var $errBuild = $this.find('.build');
            var $build = $this.find('.build');
            var $packing = $this.find('.packing');
            if($succ.get(0) || $packing.get(0)){
                $build.show();
                
                
            } else if ($err.eq(0).get(0)){
                $errBuild.addClass('active');
            }
        });
        $hisTable.on('mouseout','tr',function(){
            var $this = $(this);
            var $succ = $(this).find('.succ');
            var $err = $(this).find('.err');
            var $errBuild = $(this).find('.build');
            var $build = $this.find('.build');
            var $packing = $this.find('.packing');
            if($succ.get(0) || $packing.get(0)){
                $packing.get(0) && $packing.show();
                $build.hide();
            } else if ($err.eq(0).get(0)){
                $errBuild.removeClass('active');
            }
        });

        var startNum = 0;
        $hisTable.on('click','a.del',function(){
            var $this = $(this);
            var uid = $this.attr('upkId');
            if(uid){
                if(confirm(i18n.t('cadModule.delConfirm'))){
                    $.post('/delUnpack', {
                        upkId: uid
                    }, function(data, textStatus, xhr) {
                        $this.closest('tr').animate({'height':'hide'}, 300,function(){
                            $this.closest('tr').remove();
                        });

                        startNum--;
                    });
                }
            }
        });
        
        var $packHistory = $('#pack-history');
        $packHistory.on('click','a.more',function(){
            var typeLabel = $('#historyType').closest('.icheckbox_minimal-green');
            var type = 0;
            if (typeLabel.hasClass('checked')) {
                type = 1;
            }
            var $this = $(this);
            startNum += 5;
            $.ajax({
                url: '/getAllUnpack',
                type: 'GET',
                dataType: 'json',
                cache: false,
                data: {
                    appId: appid,
                    startNum: startNum,
                    num: 5,
                    type: type
                }
            })
            .done(function(data) {
                if(data && data.status){
                    var json = data.body;
                    var totalNum = json.pageSize;
                    var $tpl = $('#pack-tpl');
                    var tpl = $tpl.html();
                    var template = Handlebars.compile(tpl);
                    var html = template(json);
                    if ($('#pack-history table tbody')) { 
                    } else{
                        $('#pack-history table').html('<tbody></tbody>');
                    }
                    $('#pack-history table tbody').append(html);
                    if(totalNum - startNum < 5){
                        $this.hide();
                    }
                }
            });

        });

        var $pkgBtn = $('#pack-btn .package');
        $pkgBtn.removeAttr('disabled');
        var $pkgProgress = $('#pack-btn .progress');
        var $pkgText = $('#pack-btn .packing-status');
        
        var timer;
        var timeCount,timeCount1,timeCount2,timeCount3;
        var time = [50, 50, 50, 50];
        var initMark = [false,false,false,false];
        var packStatus = [false, false, false, false];
        var listJson = {};
        var countCircle1 = 0,countCircle2 = 0,countCircle3 = 0,countCircle4 = 0;
        var upkid;
        var showPackSta = function(){
            if (packStatus[0] && packStatus[1] && packStatus[2] && packStatus[3]) {
                clearInterval(timer);
                $('#pack-btn').hide();
                var $packSuc = $('#pack-succ');
                $packSuc.fadeIn();

                listJson.appType = curAppType;
                var typeLabel = $('#historyType').closest('.icheckbox_minimal-green');
                var type = 0;
                if (typeLabel.hasClass('checked')) {
                    type = 1;
                }
                if (type == 0 || (type == 1 && listJson.type == 0)) {
                    var tempClass = 'tr.n'+upkid;
                    $('#pack-history').find(tempClass).each(function(index, el) {
                        $(el).remove();
                    });

                    var tpl = $('#last-history').html();

                    var template = Handlebars.compile(tpl);
                    var html = template(listJson);
                    $('#pack-history table tbody').prepend(html);
                    var $toggleHistory = $('#toggleHistory');
                    var $history = $('#pack-history');
                    $toggleHistory.addClass('up');
                    $history.find('table').show();
                    $history.find('a.more').css('display','block');
                }
                    
                startNum++;
            } else{

            }    
        };

        var getPackSta = function(pkgId,platform){

            var data = {
                appId: appid,
                pkgId: pkgId,
                platform: platform
            };
            $.post('/getPKGState', data, function(data, textStatus, xhr) {

                var $packSuc = $('#pack-succ');
                var $iosWrap = $packSuc.find('.ios-wrap');
                var $andWrap = $packSuc.find('.and-wrap');
                var $wgtWrap = $packSuc.find('.widget-wrap');
                var $tencentWrap = $packSuc.find('.tencent-wrap');
                var $ver = $packSuc.find('.ver');
                var $size = $packSuc.find('.size');
                var $disi = $packSuc.find('.ios label.dis');
                var $disa = $packSuc.find('.android label.dis');
                var $disW = $packSuc.find('.widget label.dis');
                var $dist = $packSuc.find('.tencent label.dis');
                var $dislogi = $packSuc.find('.ios .dis-url');
                var $disloga = $packSuc.find('.android .dis-url');
                var $dislogt = $packSuc.find('.tencent .dis-url');
                $disloga.hide();
                $dislogi.hide();
                $dislogt.hide();
                var showErr = function(index){
                    var res = data.body;

                    var packSta = res.status;
                    var apkUrl = res.apkUrl;
                    var ipaUrl = res.ipaUrl;
                    var plistUrl = res.plistUrl;
                    var wgtUrl = res.wgtUrl;
                    var X5Url = res.X5Url;
                    var version = res.ver;
                    var createDate = res.createDate;
                    var type = res.type;
                    var userName = res.userName;
                    upkid = res.id;

                    listJson.upkType = type;
                    listJson.upkVer = version;
                    listJson.upkCreateDate = createDate;
                    listJson.userName = userName;
                    listJson.upkState = packSta;
                    listJson.upkId = upkid;
                    if (res.iosLog) {
                        listJson.iosLog = res.iosLog;
                    } else{
                        listJson.iosLog = '';
                    }
                    if (res.androidLog) {
                        listJson.androidLog = res.androidLog;
                    } else{
                        listJson.androidLog = '';
                    }
                    if (res.X5Log) {
                        listJson.X5Log = res.X5Log;
                    } else{
                        listJson.X5Log = '';
                    }
                    listJson.verCode = res.verCode;

                    if (platform == 0) {
                        listJson.iosState = packSta;
                        $iosWrap.find('.icon-cus-apple').addClass('u');
                        $disi.text(i18n.t("cadPackage."+index));
                        $iosWrap.show();
                    }
                    if (platform == 1) {
                        listJson.androidState = packSta;
                        if (curAppType == 4) {
                            $tvWrap.find('.icon-cus-tv').addClass('u');
                            $distv.text(i18n.t("cadPackage."+index));
                            $tvWrap.show();
                        } else{
                            $andWrap.find('.icon-cus-android').addClass('u');
                            $disa.text(i18n.t("cadPackage."+index));
                            $andWrap.show();
                        }
                    }
                    if (platform == 2) {
                        listJson.wgtState = packSta;
                        $wgtWrap.find('.icon-cus-widget').addClass('u');
                        $disW.text(i18n.t("cadPackage."+index));
                        $wgtWrap.show();
                    }
                    if (platform == 3) {
                        listJson.X5State = packSta;
                        $tencentWrap.find('.icon-cus-tencent').addClass('u');
                        $dist.text(i18n.t("cadPackage."+index));
                        $tencentWrap.show();
                    }
                    if (res.iosLog) {
                        $dislogi.attr('href', res.iosLog);
                    } else{
                        $dislogi.attr('href', 'javascript:void(0)');
                    }
                    if (res.androidLog) {
                        if (curAppType == 4) {
                            $dislogtv.attr('href', res.androidLog);
                        } else{
                            $disloga.attr('href', res.androidLog);
                        }
                    } else{
                        if (curAppType == 4) {
                            $dislogtv.attr('href', 'javascript:void(0)');
                        } else{
                            $disloga.attr('href', 'javascript:void(0)');
                        }
                    }
                    if (res.X5Log) {
                        $dislogt.attr('href', res.X5Log);
                    } else{
                        $dislogt.attr('href', 'javascript:void(0)');
                    }
                    if (apkUrl) {
                        if (curAppType == 4) {
                            $dislogtv.hide();
                        } else{
                            $disloga.hide();
                        }
                    } else {
                        if(res.androidLog){
                            if (curAppType == 4) {
                                $dislogtv.show();
                            } else{
                                $disloga.show();
                            }
                        }
                    }
                    if (ipaUrl) {
                        $dislogi.hide();
                    } else{
                        if(res.iosLog){
                            $dislogi.show();
                        }
                    }
                    if (X5Url) {
                        $dislogt.hide();
                    } else{
                        if(res.X5Log){
                            $dislogt.show();
                        }
                    }
                    if (curAppType == 4) {
                        $ver.eq(2).addClass('dis');
                        $ver.eq(2).text(i18n.t("cadPackage.fail"));
                    } else{
                        $ver.eq(platform).addClass('dis');
                        $ver.eq(platform).text(i18n.t("cadPackage.fail"));
                    }
                    $pkgProgress.eq(platform).removeClass('progress-striped');
                    $pkgText.eq(platform).text(i18n.t("cadPackage."+index));
                    packStatus[platform] = true;
                    showPackSta();
                    if (platform == 0) {
                        clearInterval(timeCount);
                    }
                    if (platform == 1) {
                        clearInterval(timeCount1);
                    }
                    if (platform == 2) {
                        clearInterval(timeCount2);
                    }
                    if (platform == 3) {
                        clearInterval(timeCount3);
                    }
                };
                if(data && data.status === 1){
                    $pkgBtn.hide();
                    
                    if ($('#pack-btn .status-container') && $('#pack-btn .package').attr('firstEnter')) {
                        $('#pack-btn .status-container').show();
                    } else{
                        clearInterval(timer);
                        clearInterval(timeCount);
                        clearInterval(timeCount1);
                        clearInterval(timeCount2);
                        clearInterval(timeCount3);
                    }
                    
                    if (packStatus[platform]) {
                        $pkgProgress.eq(platform).removeClass('progress-striped');
                    } else {
                        $pkgProgress.eq(platform).addClass('progress-striped');
                    }
                    var res = data.body;

                    switch (res.status) {
                        case -2:
                            var index = res.index +1;
                            var txt = index+ i18n.t("cadPackage.text-2");
                            $pkgText.eq(platform).text(txt);
                            showPackSta();
                            break;
                        case -1:
                            showErr(res.status);
                            break;
                        case 0:
                            var str;
                            if(!initMark[platform]){
                                countCircle1 = 0;
                                countCircle2 = 0;
                                countCircle3 = 0;
                                countCircle4 = 0;
                                str = i18n.t("cadPackage.text0_1")+ time[platform] +'s...';
                                $pkgText.eq(platform).text(str);
                                if (platform == 0) {
                                    timeCount = setInterval(function(){
                                        time[platform]--;
                                        if(time[platform] <= 0){
                                            time[platform] = 50;
                                            countCircle1++;
                                        }
                                        if (countCircle1 === 0) {
                                            str = i18n.t("cadPackage.text0_2")+ time[platform] +'s...';
                                        } else if(countCircle1 === 1){
                                            str = i18n.t("cadPackage.text0_3")+ time[platform] +'s...';
                                        } else{
                                            str = i18n.t("cadPackage.text0_4");
                                        }
                                        
                                        $pkgText.eq(platform).text(str);

                                    },1000);
                                }
                                if (platform == 1) {
                                    timeCount1 = setInterval(function(){
                                        time[platform]--;
                                        if(time[platform] <= 0){
                                            time[platform] = 50;
                                            countCircle2++;
                                        }
                                        if (countCircle2 === 0) {
                                            str = i18n.t("cadPackage.text0_2")+ time[platform] +'s...';
                                        } else if(countCircle2 === 1){
                                            str = i18n.t("cadPackage.text0_3")+ time[platform] +'s...';
                                        } else{
                                            str = i18n.t("cadPackage.text0_4");
                                        }
                                        
                                        $pkgText.eq(platform).text(str);

                                    },1000);
                                } 
                                if (platform == 2) {
                                    timeCount2 = setInterval(function(){
                                        time[platform]--;
                                        if(time[platform] <= 0){
                                            time[platform] = 50;
                                            countCircle3++;
                                        }
                                        if (countCircle3 === 0) {
                                            str = i18n.t("cadPackage.text0_2")+ time[platform] +'s...';
                                        } else if(countCircle3 === 1){
                                            str = i18n.t("cadPackage.text0_3")+ time[platform] +'s...';
                                        } else{
                                            str = i18n.t("cadPackage.text0_4");
                                        }
                                        
                                        $pkgText.eq(platform).text(str);

                                    },1000);
                                }
                                if (platform == 3) {
                                    timeCount3 = setInterval(function(){
                                        time[platform]--;
                                        if(time[platform] <= 0){
                                            time[platform] = 50;
                                            countCircle4++;
                                        }
                                        if (countCircle4 === 0) {
                                            str = i18n.t("cadPackage.text0_2")+ time[platform] +'s...';
                                        } else if(countCircle4 === 1){
                                            str = i18n.t("cadPackage.text0_3")+ time[platform] +'s...';
                                        } else{
                                            str = i18n.t("cadPackage.text0_4");
                                        }
                                        
                                        $pkgText.eq(platform).text(str);

                                    },1000);
                                }

                                initMark[platform] = true;
                            }
                            showPackSta();
                            break;
                        case 1:
                            $pkgProgress.eq(platform).removeClass('progress-striped');
                            $pkgText.eq(platform).text(i18n.t("cadPackage.pack-succ"));
                            var packSta = res.status;
                            var apkUrl = res.apkUrl;
                            var ipaUrl = res.ipaUrl;
                            var wgtUrl = res.wgtUrl;
                            var X5Url = res.X5Url;
                            var plistUrl = res.plistUrl;
                            var version = res.ver;
                            var createDate = res.createDate;
                            var type = res.type;
                            var userName = res.userName;
                            upkid = res.id;

                            listJson.upkType = type;
                            listJson.upkVer = res.ver;
                            listJson.upkCreateDate = createDate;
                            listJson.userName = userName;
                            listJson.upkState = packSta;
                            listJson.upkId = upkid;
                            listJson.verCode = res.verCode;
                            if (res.iosLog) {
                                listJson.iosLog = res.iosLog;
                            } else{
                                listJson.iosLog = '';
                            }
                            if (res.androidLog) {
                                listJson.androidLog = res.androidLog;
                            } else{
                                listJson.androidLog = '';
                            }
                            if (res.X5Log) {
                                listJson.X5Log = res.X5Log;
                            } else{
                                listJson.X5Log = '';
                            }

                            if (platform == 0) {
                                listJson.upkPlistUrl = plistUrl;
                                listJson.upkToken = res.upkToken;
                                listJson.upkIpaUrl = ipaUrl;
                                listJson.iosState = packSta;
                                listJson.ipaSize = res.ipaSize;
                            }
                            if (platform == 1) {
                                listJson.upkApkUrl = apkUrl;
                                listJson.androidState = packSta;
                                listJson.upkApkSize = res.apkSize;
                            }
                            if (platform == 2) {
                                listJson.upkWebUrl = wgtUrl;
                                listJson.wgtState = packSta;
                                listJson.wgtSize = res.wgtSize;
                            }
                            if (platform == 3) {
                                listJson.X5Url = X5Url;
                                listJson.X5State = packSta;
                                listJson.upkX5Size = res.X5Size;
                            }
                            if(ipaUrl){
                                $iosWrap.show();
                                $disi.hide();
                                $ver.eq(0).addClass('en');
                                $ver.eq(0).text(i18n.t("cadPackage.download")+' '+getSize(listJson.ipaSize));
                                $packSuc.find('a.ios').attr('href',ipaUrl );
                            }
                            if(apkUrl){
                                if (curAppType == 4) {
                                } else{
                                    $andWrap.show();
                                    $disa.hide();
                                    $ver.eq(1).addClass('en');
                                    $ver.eq(1).text(i18n.t("cadPackage.download")+' '+getSize(listJson.upkApkSize));
                                    $packSuc.find('a.android').attr('href',apkUrl );
                                }
                            }
                            if (wgtUrl) {
                                $wgtWrap.show();
                                $disW.hide();
                                $ver.eq(2).addClass('en');
                                $ver.eq(2).text(i18n.t("cadPackage.download")+' '+getSize(listJson.wgtSize));
                                $packSuc.find('a.widget').attr('href',wgtUrl);
                            };
                            if (X5Url) {
                                $tencentWrap.show();
                                $dist.hide();
                                $ver.eq(3).addClass('en');
                                $ver.eq(3).text(i18n.t("cadPackage.download")+' '+getSize(listJson.upkX5Size));
                                $packSuc.find('a.tencent').attr('href',X5Url );
                            };
                            packStatus[platform] = true;
                            showPackSta();
                            if (platform == 0) {
                                clearInterval(timeCount);
                            }
                            if (platform == 1) {
                                clearInterval(timeCount1);
                            }
                            if (platform == 2) {
                                clearInterval(timeCount2);
                            } 
                            if (platform == 3) {
                                clearInterval(timeCount3);
                            }
                            break;
                        case 2:
                            showErr(res.status);
                            break;
                        case 3:
                            showErr(res.status);
                            break;
                        case 4:
                            showErr(res.status);
                            break;
                        case 5:
                            showErr(res.status);
                            break;
                        case 6:
                            showErr(res.status);
                            break;
                        case 7:
                            showErr(res.status);
                            break;
                        case 8:
                            showErr(res.status);
                            break;
                        case 9:
                            showErr(res.status);
                            break;
                        case 10:
                            showErr(res.status);
                            break;
                        case 11:
                            showErr(res.status);
                            break;
                        case 12:
                            showErr(res.status);
                            break;
                        case 13:
                            showErr(res.status);
                            break;
                        case 14:
                            showErr(res.status);
                            break;
                        case 15:
                            showErr(res.status);
                            break;
                        case 16:
                            showErr(res.status);
                            break;
                    }

                }
            });
        };

       
        $.validator.addMethod("ifPackPlatform", function (value, element, param) {
            var $inputs = $('#platform-area').find('input[type="checkbox"]');
            if ($inputs.eq(0).attr('checked') == 'checked' || $inputs.eq(1).attr('checked') == 'checked' || $inputs.eq(3).attr('checked') == 'checked') {
                return true;
            } else{
                return false;
            }
        }, i18n.t("cadPackage.warn_3"));

        $("#cloud-packfrm").validate({
            errorPlacement: function (error, element) {
                if(element.attr('name') === 'packPlatform'){
                    $('#packPf-err').html(error);
                }
                if(element.attr('name') === 'packPlatform1'){
                    $('#packPf-err').html(error);
                }
                if(element.attr('name') === 'packPlatform2'){
                    $('#packPf-err').html(error);
                }
                if(element.attr('name') === 'packPlatform3'){
                    $('#packPf-err').html(error);
                }
            },
            rules: {
                packPlatform: {
                    ifPackPlatform: true
                },
                packPlatform1: {
                    ifPackPlatform: true
                },
                packPlatform2: {
                    ifPackPlatform: true
                },
                packPlatform3: {
                    ifPackPlatform: true
                }
            },
            messages: {
                packPlatform: i18n.t("cadPackage.valid_platform"),
                packPlatform1: i18n.t("cadPackage.valid_platform"),
                packPlatform2: i18n.t("cadPackage.valid_platform"),
                packPlatform3: i18n.t("cadPackage.valid_platform")
            },
            submitHandler: function (form) {
                
                $pkgBtn.removeClass('pack-err');
                $pkgBtn.attr('disabled','disabled');
                $pkgBtn.addClass('active');
                $pkgBtn.text(i18n.t("cadPackage.0"));
                $pkgBtn.attr('firstEnter', 'true');
                var version = [];
                
                var platform = [];
                $('#platform-area').find('input').each(function(index, el) {
                    var p = $(el).val();
                    if ($(el).attr('checked') == 'checked') {
                        platform.push(p);
                    } else{

                    }
                });
                platform = platform.join(',');
                
                
                var engine = $('#engineId').val();
                
                var data = {
                    appId: appid,
                    appName: $(".app-name").text(),
                    version: "0.0.0",
                    verType: 1,
                    platform: platform,
                    engine: engine,
                    isSDK:1
                };

                $.ajax({
                    url: '/addUnpack',
                    type: 'POST',
                    data: data
                })
                .done(function(data) {
                    if(data && data.status === 1){
                        
                        var pkgId = data.body.pkgId;
                        var tempFn = function(){
                            var platformArr = platform.split(','),
                            len = platformArr.length,
                            statusLen = packStatus.length,
                            state = ['androidState', 'iosState', 'widgetState', 'X5State'];
                            for (var i = 0; i < statusLen; i++) {
                                packStatus[i] = true;
                                listJson[state[i]] = -3;
                            };
                            for (var i = 0; i < len; i++) {
                                packStatus[platformArr[i]] = false;
                                getPackSta(pkgId,platformArr[i]);
                                if(platformArr[i] == 3){
                                    $('.progress-android').addClass('hidden');
                                    $('.progress-x5').removeClass('hidden');
                                }
                                if(platformArr[i] == 1){
                                    $('.progress-x5').addClass('hidden');
                                    $('.progress-android').removeClass('hidden');
                                }
                            };
                           
                        };
                        setTimeout(function(){
                            tempFn();
                        },2000);
                        timer = setInterval(function(){
                            tempFn();
                        },10000);
                    }else if(data && data.status === 0){
                        tempResetBtn();
                        if (data.code == 347) {
                            util.alertMessage(0, errors.cadTip[data.code].replace("__moduleName__", data.msg));
                        }else if(data.code == 348){
                            util.alertMessage(0, '请上传watch的Provision 文件');
                        }else{
                            util.alertMessage(0, errors.cadTip[data.code]);
                        }
                    }
                })
                .fail(function() {
                })
                .always(function() {
                });

            }
        });
        function getSize(size){
            return parseFloat(size/1024/1024).toFixed(1) + 'M';
        };
        var tempResetBtn = function(){
            $pkgBtn.removeAttr('disabled');
            $pkgBtn.removeClass('active');
            $pkgBtn.text(i18n.t("nativeSdk.CompileSdk"));
        };

        if ($.cookie('ifPackageList')) {
            window.location.hash = "pack-history";
            $('#toggleHistory').trigger('click');
            $.removeCookie('ifPackageList');
        }
    };
});