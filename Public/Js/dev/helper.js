define(function (require, exports, module) {
    var Handlebars = require("Handlebars");
    exports.init = function(){
        Handlebars.registerHelper('ver_pack_list', function(data, plat, options) {
            var html = '';
            var len = data.length;
            var arr = [];
            var json = {};
            var arr2 = [];
            if (len > 0) {
                
            } else {
                return new Handlebars.SafeString(html);
            }
            for (var i = 0; i < len; i++) {
                if (plat == 3 || data[i].upkPlatform == plat || data[i].upkPlatform == 3) {
                    if (plat == 3) {
                        arr.push(data[i]);
                    } else{
                        if (((plat == 2) && (data[i].upkState == 1 && data[i].androidState == -3)) || ((plat == 2) && (data[i].androidState == 1))) {
                            arr.push(data[i]);
                        } else if(((plat == 1) && (data[i].upkState == 1 && data[i].iosState == -3)) || ((plat == 1) && (data[i].iosState == 1))){
                            arr.push(data[i]);
                        } else{
                        }
                    } 
                } else{
                } 
            }
            for (var j = arr.length - 1; j >= 0; j--) {
                json[arr[j].upkVer] = arr[j];
            }
            for (var name in json) {
                arr2.push(json[name]);    
            }
            arr2.sort(function(a,b){ return a.upkId - b.upkId;});
            for (var k = arr2.length - 1; k >= 0; k--) {
                html +="<option value="+arr2[k].upkVer+" platform="+arr2[k].upkPlatform+">V"+arr2[k].upkVer+"</option>";  
            }
            
            return new Handlebars.SafeString(html);
        });
        Handlebars.registerHelper('pack_3', function(sta1, sta2, sta3, options){
            if (sta1 == -3 && sta2 == -3 && sta3 == -3) {
                return options.fn(this);
            } else{
                return options.inverse(this);
            }
        });
        Handlebars.registerHelper('pack_1', function(sta1, sta2, sta3, options){
            if (sta1 == 1 || sta2 == 1 || sta3 == 1) {
                return options.fn(this);
            } else{
                return options.inverse(this);
            }
        });
        Handlebars.registerHelper('pack_0', function(sta1, sta2, sta3, options){
            if (sta1 == 0 || sta2 == 0 || sta3 == 0) {
                return options.fn(this);
            } else{
                return options.inverse(this);
            }
        });
        Handlebars.registerHelper('native_3', function(sta1, sta2, sta3, sta4, options){
            if (sta1 == -3 && sta2 == -3 && sta3 == -3 && sta4 == -3) {
                return options.fn(this);
            } else{
                return options.inverse(this);
            }
        });
        Handlebars.registerHelper('native_1', function(sta1, sta2, sta3, sta4, options){
            if (sta1 == 1 || sta2 == 1 || sta3 == 1 || sta4 == 1) {
                return options.fn(this);
            } else{
                return options.inverse(this);
            }
        });
        Handlebars.registerHelper('native_0', function(sta1, sta2, sta3, sta4, options){
            if (sta1 == 0 || sta2 == 0 || sta3 == 0 || sta4 == 0) {
                return options.fn(this);
            } else{
                return options.inverse(this);
            }
        });
        Handlebars.registerHelper('packing',function(status){
            var json = {
                '-3': '',
                '-2': i18n.t("cadPackage.-2"),
                '-1': i18n.t("cadPackage.-1"),
                '0': i18n.t("cadPackage.0"),
                '1': i18n.t("cadPackage.1"),
                '2': i18n.t("cadPackage.2"),
                '3': i18n.t("cadPackage.3"),
                '4': i18n.t("cadPackage.4"),
                '5': i18n.t("cadPackage.5"),
                '6': i18n.t("cadPackage.6"),
                '7': i18n.t("cadPackage.7"),
                '8': i18n.t("cadPackage.8"),
                '9': i18n.t("cadPackage.9"),
                '10': i18n.t("cadPackage.10"),
                '11': i18n.t("cadPackage.11"),
                '12': i18n.t("cadPackage.12"),
                '13': i18n.t("cadPackage.13"),
                '14': i18n.t("cadPackage.14"),
                '15': i18n.t("cadPackage.15"),
                '16': i18n.t("cadPackage.16")
            };
            return json[status];
        });
        Handlebars.registerHelper('t', function(i18n_key) {
            var result = i18n.t(i18n_key);
            return new Handlebars.SafeString(result);
        });
        Handlebars.registerHelper('getT', function(name) {
            var result = i18n.t(name);
            return new Handlebars.SafeString(result);
        });
        Handlebars.registerHelper('percent', function(condition1, condition2, options){
            var num1 = parseInt(condition1);
            var num2 = parseInt(condition2) * 1073741824;
            return (100-Math.round((num1 / num2) * 10000) / 100.00 + "%");
        });
        Handlebars.registerHelper('percent_2', function(condition1, condition2, options){
            var num1 = parseInt(condition1);
            var num2 = parseInt(condition2);
            return (Math.round((num1 / (num1 + num2)) * 10000) / 100.00 + "%");
        });
        Handlebars.registerHelper('and', function(condition1, condition2, options) {
            if(condition1 && condition2){
                return options.fn(this);
            } else {
                return options.inverse(this);
            }
        });
        Handlebars.registerHelper('neither', function(condition1, condition2, options) {
            if(!condition1 && !condition2){
                return options.fn(this);
            } else {
                return options.inverse(this);
            }
        });
        Handlebars.registerHelper('eq', function(condition1, condition2, options) {
            if(condition1 == condition2){
                return options.fn(this);
            } else {
                return options.inverse(this);
            }
        });
        Handlebars.registerHelper('versionToNum', function(version, condition2, options) {
            var a = [];
            var ver = version || '0.0.0';
            a = ver.split('.');
            for (var i = 0,len = a.length; i < len; i++) {
                if(a[i] < 10){
                    a[i] = '0'+a[i];
                }
            }
            return a.join('');
        });
        Handlebars.registerHelper('or', function(condition1, condition2, options) {
            if(condition1 || condition2){
                return options.fn(this);
            }
        });
        Handlebars.registerHelper('do', function(condition1, condition2, condition3, condition4, condition5) {
                var arr = [condition1,condition2,condition3,condition4,condition5];
                var ret='';
                for (var i = 0,j=0; i < arr.length; i++) {
                    if (arr[i] && j<3) {
                        j++;
                        ret +='<img src="'+arr[i]+'">';   
                    };
                };
                return new Handlebars.SafeString(ret);;
        });
        Handlebars.registerHelper('gt', function(context, val, options) {
            if(context > val){
                return options.fn(this);
            }
        });
        Handlebars.registerHelper('lt', function(context, val, options) {
            if(context < val){
                return options.fn(this);
            }
        });
        Handlebars.registerHelper('eachTR', function(arr, column, options) {
            var html = '';
            var len;
            if (arr.length % column === 0) {
                len = arr.length;
            } else {
                len = ((parseInt(arr.length/column)+1)*column);
            }
            for(var i=0; i<len; i++){
                if (i%column === 0) {
                    html = html + '<tr>' + options.fn(arr[i]);
                } else if (i%column === (column-1)) {
                    html = html + aaa.fn(arr[i]) + '</tr>';
                } else {
                    html = html + options.fn(arr[i]);
                }
            }
            return new Handlebars.SafeString(html);
        });
        var preFormat = function(str){
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
            return new Date(str).customFormat('yyyy-MM-dd HH:mm:ss');
        };
        Handlebars.registerHelper('formatDate', function(date) {
            var d = preFormat(date);
            return new Handlebars.SafeString(d);
        });
        Handlebars.registerHelper('formatDatemm', function(date) {
            var thisDate = new Date(date);
            function toDouble(num){
                var result;
                if (num < 10) {
                    result = '0'+ num;
                } else {
                    result = num;
                }
                return result;
            }
            var result = thisDate.getFullYear() +'-'+ toDouble(thisDate.getMonth()+1) +'-'+ toDouble(thisDate.getDate()) +' '+ toDouble(thisDate.getHours()) +':'+ toDouble(thisDate.getMinutes());
            return new Handlebars.SafeString(result);
        });
        Handlebars.registerHelper('formatDatedd', function(date) {
            var thisDate = new Date(date);
            function toDouble(num){
                var result;
                if (num < 10) {
                    result = '0'+ num;
                } else {
                    result = num;
                }
                return result;
            }
            var result = thisDate.getFullYear() +'-'+ toDouble(thisDate.getMonth()+1) +'-'+ toDouble(thisDate.getDate());
            return new Handlebars.SafeString(result);
        });
        Handlebars.registerHelper('dateTemplate', function(date, delimiter) {
            var d = new Date(date);
            var yy = d.getFullYear(), mm = d.getMonth() + 1,
                dd = d.getDate();
            delimiter = delimiter || '-';
            var dateStr = [yy, mm, dd].join(delimiter);
            return new Handlebars.SafeString(dateStr);
        });
        Handlebars.registerHelper('newQrcode', function(url , ver, size) {
            var newUrl = url + '&ver=' + ver + '&size=';
            if (size == null) {
                newUrl = '';
            } else{
                newUrl += parseInt(size / (1024 * 1024) * 100) / 100 + 'M'; 
            }

            return newUrl;
        });
        Handlebars.registerHelper('firstHalfEmail', function(fullEmail) {
            function getRandom(len){
                var chars = 'abcdefghijkmnopqrstuvwxyz';
                var str = "";
                while(len > 0){
                    str += chars.charAt(Math.floor(Math.random() * chars.length));
                    len--;
                }
                return str;
            }
            var email = fullEmail.split('@')[0];
            var pkgName = email.replace(/\./g, "").replace(/-/g, "").replace(/_/g, "");

            if(!isNaN(pkgName[0])){
                pkgName =getRandom(1)+pkgName;
            }
            
            return pkgName;
        });
        // 拼接视频列表
        Handlebars.registerHelper('setVideoItem', function(count, id){
            count = parseInt(count);
            var countMap = {
                1: '一',
                2: '二',
                3: '三',
                4: '四',
                5: '五',
                6: '六',
                7: '七',
                8: '八',
                9: '九',
                10: '十',
                11: '十一',
                12: '十二'
            };
            var str = '';
            for (var i = 1; i< 7; i++) {
                if (i <= count) {
                    if (i == 6 && count > 6) {
                        str += '<a target="_blank" href="/video_play?list='+ id + '&index=1" class="list-p-link">更多>></a>';
                    } else {
                        str += '<a target="_blank" href="/video_play?list='+ id + '&index='+ i +'" class="list-p-item">第'+ countMap[i] +'讲</a>';
                    }
                } else {
                    break;
                }
            }
            return str;
        });
        // 几天前
        Handlebars.registerHelper('setDaysAgo', function(thisDate){
            var date1 = new Date(thisDate).getTime();
            var date2 = new Date().getTime();
            var date3 = date2 - date1;
            var date4 = new Date(thisDate);
            var str = '<span class="date">更新于今天</span>';
            if (date3 <= 0) {

            } else {
                var days = Math.floor(date3/86400000);
                if (days == 0) {

                } else if(days <= 50){
                    str = '<span class="date">更新于'+ days +'天前</span>';
                } else {
                    str = '<span class="date">更新于'+ date4.getFullYear() +'年'+ (date4.getMonth() + 1) +'月'+ date4.getDate() +'日</span>';
                }
            }
            return str;
        });
        // APP类型
        Handlebars.registerHelper('apptypes', function(str){
            if (str == null) {
                return '';
            }
            str += '';
            var typeMap = {
                a: '支付',
                b: '设备访问',
                c: '即时通讯',
                d: '第三方登录',
                e: '分享',
                f: '推送',
                g: '扫码',
                h: '网络通信',
                i: '文件管理',
                j: '存储',
                k: '图片处理',
                l: '拍摄',
                m: '视频',
                n: '音频',
                o: '影音处理',
                p: '统计分析',
                q: '提示弹框',
                r: '开发调试',
                s: 'IOT',
                t: '电商',
                u: '应用管理',
                v: '传感器',
                w: '识别',
                x: '验证',
                y: '地图',
                z: '导航',
                1: '短信',
                2: '广告',
                3: 'UI',
                4: '图表',
                5: '列表',
                6: '选择器',
                7: '导航栏',
                8: '日历',
                9: '输入框',
                10: '下拉刷新',
                11: '加载',
                12: '图片轮播',
                13: '阅读',
                14: '社交',
                15: 'O2O',
                16: '直播',
            };
            var html_str = '';
            var str_arr = str.split(',');
            for (var i = 0; i < str_arr.length; i++) {
                html_str += '<li class="app-types-item">'+ typeMap[str_arr[i]] +'</li>';
            }
            return html_str;
        });
        // index 0+n
        Handlebars.registerHelper('add', function(num1, num2) {
            return parseInt(num1) + parseInt(num2);
        });
        Handlebars.registerHelper('date_percent', function(condition1, condition2, options){
            var date1 = new Date(condition1),
                date2 = new Date(condition2),
                date3 = new Date();

            return (Math.round((date3 - date1)/(date2 - date1) * 100) + "%");
        });
        Handlebars.registerHelper('mdhm', function(dateStr){
            function toDouble(params){
                if (params < 10) {
                    return '0'+params;
                } else {
                    return params;
                }
            };
            var date = new Date(dateStr);
            return (date.getMonth() + 1) +'/'+ date.getDate() +' '+ date.getHours() +':'+ date.getMinutes();
        });
    };
});