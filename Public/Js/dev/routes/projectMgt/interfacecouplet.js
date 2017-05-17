define(function (require, exports, module) {
    module.exports = function (req, res) {
        var config = require('../nodeConfig.js');
        var hostname = config.host;
        var request = require('request');
        var async = require('async');
        var utils = require('../mam/helper.js');
        var appid = req.cookies.curAppId;
        var ilng = req.cookies.i18next || "zh-CN";
        var i18n_lang = req.cookies.i18next || "zh-CN";
        i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");

        function dateFormat(str) {
            var strMon, strDate;
            if (i18n_lang == 'en-US') {
                strMon = '-';
                strDate = ' ';
            } else {
                strMon = '月';
                strDate = '日 ';
            }

            function toDouble(num) {
                var result;
                if (num < 10) {
                    result = '0' + num;
                } else {
                    result = num;
                }
                return result;
            }
            var thisDate = new Date(str);
            var result = thisDate.getMonth() + 1 + strMon + thisDate.getDate() + strDate + toDouble(thisDate.getHours()) + ':' + toDouble(thisDate.getMinutes());
            return result;
        }

        async.series([

        function requests(callback) { // 获取计划
            var options = {
                url: hostname + '/uzapp/pm/overview/getChilePlanByType?type=4&appId=' + appid,
                json: true,
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200 && body.status == 1) {
                    var thisResult = body.result;
                    for (var i = 0; i < thisResult['parent'].length; i++) {
                        var thisNode = thisResult['parent'][i];
                        if (thisNode.begin_time) {
                            thisNode.begin_time = utils.toFormat(thisNode.begin_time, 'yyyy-MM-dd');
                        }
                        if (thisNode.end_time) {
                            thisNode.end_time = utils.toFormat(thisNode.end_time, 'yyyy-MM-dd');
                        }
                        if (thisNode.actual_finish_time) {
                            thisNode.actual_finish_time = utils.toFormat(thisNode.actual_finish_time, 'yyyy-MM-dd');
                        }
                        if (thisNode.demand_side_ack_time) {
                            thisNode.demand_side_ack_time = dateFormat(thisNode.demand_side_ack_time);
                        }
                        if (thisNode.developer_ack_time) {
                            thisNode.developer_ack_time = dateFormat(thisNode.developer_ack_time);
                        }
                    }
                    for (var j = 0; j < thisResult['child'].length; j++) {
                        var childNode = thisResult['child'][j];
                        if (childNode.begin_time) {
                            childNode.begin_time = utils.toFormat(childNode.begin_time, 'yyyy-MM-dd');
                        }
                        if (childNode.end_time) {
                            childNode.end_time = utils.toFormat(childNode.end_time, 'yyyy-MM-dd');
                        }
                        if (childNode.actual_finish_time) {
                            childNode.actual_finish_time = utils.toFormat(childNode.actual_finish_time, 'yyyy-MM-dd');
                        }
                        if (childNode.demand_side_ack_time) {
                            childNode.demand_side_ack_time = utils.toFormat(childNode.demand_side_ack_time, 'yyyy-MM-dd');
                        }
                        if (childNode.developer_ack_time) {
                            childNode.developer_ack_time = utils.toFormat(childNode.developer_ack_time, 'yyyy-MM-dd');
                        }
                    }
                    var fullResult = {};
                    fullResult.parentlist = thisResult['parent'];
                    fullResult.childlist = thisResult['child'];
                    callback(null, fullResult);
                } else {
                    callback(null, {
                        parentlist: [],
                        childlist: []
                    });
                }
            });

        },
        // 获取ui

        function requests(callback) { // 获取动态
            var options1 = {
                url: hostname + '/uzapp/pm/UI/getPicture?appId=' + appid,
                json: true,
                headers: {}
            };
            if (req && req.header) {
                options1.headers.Cookie = req.header('Cookie');
            }
            request(options1, function (error, response, body) {
                if (!error && response.statusCode == 200 && body.status == 1 && body.result.length > 0) {

                    var thisResult = [];
                    var dateResult = {};
                    var minuteRule;
                    for (var i = 0; i < body.result.length; i++) {
                        var thisNode = body.result[i];
                        var thisDate = new Date(thisNode.ct);
                        var year = thisDate.getFullYear();
                        var month = thisDate.getMonth() + 1;
                        var day = thisDate.getDate();
                        // var hour = thisDate.getHours();
                        // var minute = thisDate.getMinutes();
                        // var second = thisDate.getSeconds();
                        var yearMonth = ilng == "zh-CN" ? (year + "年" + month + "月") : (month + "/" + year);
                        var monthDay = ilng == "zh-CN" ? (month + "月" + day + "日") : (day + "/" + month);

                        if (!dateResult[yearMonth]) {
                            dateResult[yearMonth] = {};
                        }
                        if (!dateResult[yearMonth][monthDay]) {
                            dateResult[yearMonth][monthDay] = {};
                        }

                        // 先分成time,name
                        var thisTempDate;
                        if (i == 0) {
                            minuteRule = thisDate;
                            thisTempDate = thisDate;
                        } else {
                            if (minuteRule - thisDate < 1000 * 60 * 20) {

                            } else {
                                minuteRule = thisDate;
                                thisTempDate = thisDate;
                            }
                        }
                        var hour = thisTempDate.getHours();
                        var minute = thisTempDate.getMinutes();
                        var hourMinute = ilng == "zh-CN" ? (hour + "时" + minute + "分") : (hour + ":" + minute);

                        if (!dateResult[yearMonth][monthDay][hourMinute]) {
                            dateResult[yearMonth][monthDay][hourMinute] = {};
                        }
                        if (!dateResult[yearMonth][monthDay][hourMinute][thisNode.name]) {
                            dateResult[yearMonth][monthDay][hourMinute][thisNode.name] = {};
                        }
                        if (!dateResult[yearMonth][monthDay][hourMinute][thisNode.name][thisNode.userName]) {
                            dateResult[yearMonth][monthDay][hourMinute][thisNode.name][thisNode.userName] = [];
                        }
                        var thisObj = {
                            monthDay: monthDay,
                            hourMinute: hourMinute,
                            avatar: thisNode.icon2 || '/img/favicon.png',
                            name: thisNode.name || '',
                            url: thisNode.url || '',
                            ct: thisNode.ct
                        };
                        dateResult[yearMonth][monthDay][hourMinute][thisNode.name][thisNode.userName].push(thisObj)
                    }
                    for (var ykey in dateResult) {
                        var yitem = dateResult[ykey]; //[monthDay]
                        var yarr = [];
                        for (var mkey in yitem) {
                            var marr = [];
                            var mitem = yitem[mkey]; //[hourMinute]
                            for (var hkey in mitem) {
                                var nitem = mitem[hkey]; //[thisnode.name]
                                // var narr = [];
                                for (var unitem in nitem) {
                                    var lastItem = nitem[unitem];
                                    for (var thisitem in lastItem) {
                                        marr.push({
                                            hkey: hkey,
                                            name: unitem,
                                            userName: thisitem,
                                            avatar: lastItem[thisitem][0]['avatar'],
                                            values: lastItem[thisitem]
                                        });
                                    }

                                }
                                // marr.push({key: hkey, values: narr});
                            }
                            yarr.push({
                                key: mkey,
                                values: marr
                            });

                        }
                        thisResult.push({
                            key: ykey,
                            values: yarr
                        });
                    }
                    callback(null, thisResult);
                } else {
                    callback(null, []);
                }
            });

        }, ], function (err, results) {
            var i18n_lang = req.cookies.i18next || "zh-CN";
            i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
            if (err) {
                return res.render(utils.getStatus(err), {
                    url: req.url,
                    jsName: "error400"
                });
            }
            var result = {};
            result.i18nlng = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
            result.title = i18n.t("接口联调");

            var getChilePlans = results[0],
                getDynamics = results[1];

            result.parentlist = getChilePlans.parentlist;
            result.childlist = getChilePlans.childlist;
            result.dynamics = getDynamics;
            // console.log('******', result);
            result.rolePermission = req.rolePermission;
            res.render('projectMgt/interfacecouplet', result);
        });
    }
});