define(function (require, exports, module) {
    module.exports = function (req, res) {
        var config = require('../nodeConfig.js');
        var hostname = config.mamhost;
        var request = require('request');
        var utils = require('./helper.js');
        var async = require('async');
        var appid = req.cookies.curAppId;
        var startDate = utils.now();
        startDate.setDate(startDate.getDate() - 6);
        async.waterfall([

        function (callback) {
            var options = {
                url: hostname + '/getV2ExcepStatisticDataByAppIdAndDate',
                method: "POST",
                json: {
                    appId: appid,
                    startDate: utils.toFormat(startDate, "yyyy-MM-dd"),
                    endDate: utils.toFormat(utils.now(), "yyyy-MM-dd"),
                    versionCode: "",
                    temptick: new Date().getTime()
                },
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    if (body && body.st == 1) {
                        var data = body.msg;
                        var excep = {};
                        var chart = {};
                        for (var i = 0, len = data.length; i < len; i++) {
                            var version = data[i];
                            var chartKey = utils.toFormat(utils.timezone(version.reportDate), 'MM-dd');
                            if (chart[chartKey]) {
                                chart[chartKey] += version.excepCount;
                            } else {
                                chart[chartKey] = version.excepCount
                            }
                            var key = version.excepTitle + version.versionCode;
                            if (excep[key]) {
                                var temp = excep[key];
                                var modalKey = version.model + version.systemVersion;
                                if (temp.modalData[modalKey]) {
                                    temp.modalData[modalKey].errorCount += version.excepCount;
                                } else {
                                    temp.modalData[modalKey] = {
                                        'deviceName': version.model,
                                        'OSCount': version.systemVersion,
                                        'errorCount': version.excepCount
                                    };
                                }
                                temp.errorCount += version.excepCount;
                                excep[key] = temp;
                            } else {
                                var obj = {};
                                var modalKey = version.model + version.systemVersion;
                                obj[modalKey] = {
                                    'deviceName': version.model,
                                    'OSCount': version.systemVersion,
                                    'errorCount': version.excepCount
                                };
                                excep[key] = {
                                    'appCode': version.versionCode,
                                    'errorAbstract': version.excepTitle,
                                    'happenTime': isTrue(version.excepLastDate) ? utils.toFormat(utils.timezone(version.excepLastDate), 'yyyy-MM-dd hh:mm:ss') : "",
                                    'errorCount': version.excepCount,
                                    'modalData': obj
                                }
                            }
                        }
                        var tab1DetailsData = [];
                        for (var key in excep) {
                            tab1DetailsData.push(excep[key]);
                        }
                        var xdata = [],
                            chartdata = [];
                        for (var key in chart) {
                            xdata.unshift(key);
                            chartdata.unshift(chart[key]);
                        }
                        var totalData = {
                            xdata: xdata,
                            chartdata: chartdata,
                            tab1details: tab1DetailsData,
                            tab2details: tab1DetailsData,
                            tab1pagetotal: Math.ceil(tab1DetailsData.length / 10),
                            tab2pagetotal: Math.ceil(tab1DetailsData.length / 10)
                        };
                        var json = {
                            jsfunc: 'function getDataByTemplate() {' + '  return ' + JSON.stringify(totalData) + '};'
                        };
                        callback(null, json);
                    }
                } else {
                    return callback(response.statusCode, []);
                }
            })
        }, function (arg, callback) {
            var options = {
                url: hostname + '/talkingDataSate?appId=' + appid,
                method: "GET",
                json: true,
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    var json = arg || {};
                    if (body.status) {
                        json.tkDataReport = body.result.isHasTDMD;
                    };
                }
                callback(null, json);
            })
        }], function (err, result) {
            var i18n_lang = req.cookies.i18next || "zh-CN";
            i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
            if (err) {
                return res.render(utils.getStatus(err), {
                    url: req.url,
                    jsName: "error400",
                    rolePermission: req.rolePermission
                });
            }
            result.title = i18n.t("Total.ErrorReport");
            result.appId = appid;
            result.rolePermission = req.rolePermission;
            return res.render('mam/error', result);
        });

        function isTrue(dt) {
            if (dt && dt != "0000-00-00 00:00:00") {
                return true;
            }
            else {
                return false;
            }
        }
    }
});