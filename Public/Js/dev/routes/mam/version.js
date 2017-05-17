define(function (require, exports, module) {
    module.exports = function (req, res) {
        var request = require('request');
        var config = require('../nodeConfig.js');
        var hostname = config.mamhost;
        var utils = require('./helper.js');
        var appid = req.cookies.curAppId;
        var async = require('async');

        async.waterfall([

        function (callback) {
            var options = {
                url: hostname + '/uzindex_getpkgversionlist',
                method: "POST",
                json: {
                    curAppId: appid
                },
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200 && body.st) {
                    return callback(null, body.msg);
                } else {
                    return callback(response.statusCode, []);
                }
            });
        }, function (versionList, callback) {
            var startDate = utils.now();
            var options = {
                url: hostname + '/getV2VersionStatisticDataByAppIdAndDate',
                method: "POST",
                json: {
                    appId: appid,
                    startDate: utils.toFormat(startDate, "yyyy-MM-dd"),
                    endDate: utils.toFormat(utils.now(), "yyyy-MM-dd"),
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
                        var detailsData = [],
                            list;
                        list = body.msg;
                        var codeMap = {};
                        for (var j = 0, jlen = versionList.length; j < jlen; j++) {
                            var versionCode = versionList[j].upkVer;
                            codeMap[versionCode] = {
                                versionCode: versionCode,
                                versionTotalUserCount: 0,
                                versionNewUserCount: 0,
                                versionUpdateUserCount: 0,
                                versionNewOrUpdateUserCount: 0,
                                activeUserCount: 0,
                                startupCount: 0
                            }
                        }

                        for (var i = 0, len = list.length; i < len; i++) {
                            var temp = list[i];
                            var cm = codeMap[temp.versionCode];
                            var obj = {
                                versionCode: temp.versionCode
                            };
                            if (cm) {
                                obj.versionTotalUserCount = cm.versionTotalUserCount;
                                obj.versionNewUserCount += cm.versionNewUserCount;
                                obj.versionUpdateUserCount += cm.versionUpdateUserCount;
                                obj.versionNewOrUpdateUserCount += cm.versionNewOrUpdateUserCount;
                                obj.activeUserCount += cm.activeUserCount;
                                obj.startupCount += cm.startupCount;
                            }
                            codeMap[temp.versionCode] = obj;
                        }


                        for (var key in codeMap) {
                            if (codeMap[key].versionTotalUserCount < 1) continue;
                            detailsData.push(codeMap[key]);
                        }
                        var totalData = {
                            details: detailsData,
                            pagetotal: Math.ceil(detailsData.length / 10)
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
            result.title = i18n.t("Total.VersionData");
            result.appId = appid;
            result.rolePermission = req.rolePermission;
            res.render('mam/version', result);
        });

    }
});