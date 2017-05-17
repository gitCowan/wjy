define(function (require, exports, module) {
    module.exports = function (req, res) {
        var request = require('request');
        var async = require('async');
        var appid = req.cookies.curAppId;
        var appType = req.cookies.appType;
        var config = require('./nodeConfig.js');
        var utils = require('./mam/helper.js');
        var hostname = config.host;

        var ilng = req.cookies.i18next || "zh-CN";

        var i18n_lang = req.cookies.i18next || "zh-CN";
        i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");

        async.waterfall([

        function (callback) {
            var options;
            if (appType == 1) {
                options = {
                    url: hostname + '/getWebApp',
                    json: true,
                    form: {
                        appId: appid
                    },
                    method: 'POST',
                    headers: {}
                };
            } else {
                options = {
                    url: hostname + '/getCADSVNList?appId=' + appid,
                    json: true,
                    headers: {}
                };
            }

            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                var asyncResult = {};

                if (!error && response.statusCode == 200) {
                    if (appType == 1) {
                        var json = body || {};
                        asyncResult = json;
                    } else {
                        var codeResult = body.aaData;
                        var result = {};
                        for (var r = 0, rlen = codeResult.length; r < rlen; r++) {
                            var ritem = codeResult[r];
                            var strs = ritem.date.split(" ");
                            var dates = strs[0].split('-');
                            var times = strs[1].split(':');
                            var year = parseInt(dates[0], 10);
                            var month = parseInt(dates[1], 10);
                            var day = parseInt(dates[2], 10);
                            var hour = parseInt(times[0], 10);
                            var minute = parseInt(times[1], 10);
                            var second = parseInt(times[2], 10);
                            var yearMonth = ilng == "zh-CN" ? (year + "年" + month + "月") : (month + "/" + year);
                            var monthDay = ilng == "zh-CN" ? (month + "月" + day + "日") : (day + "/" + month);
                            var hourMinute = ilng == "zh-CN" ? (hour + "时" + minute + "分") : (hour + ":" + minute);
                            var status = ritem.type.join("; ").replace("A", i18n.t("cadCode.addedCode")).replace("D", i18n.t("cadCode.deletedCode")).replace("M", i18n.t("cadCode.modifiedCode"));
                            var dobj = {
                                monthDay: monthDay,
                                hourMinute: hourMinute,
                                avatar: ritem.avatar || "/img/favicon.png",
                                author: ritem.author || "",
                                message: ritem.message || "",
                                ver: ritem.ver,
                                stats: status
                            }
                            if (!result[yearMonth]) {
                                result[yearMonth] = {};
                            }
                            if (!result[yearMonth][monthDay]) {
                                result[yearMonth][monthDay] = [];
                            }
                            result[yearMonth][monthDay].push(dobj)
                        }

                        var returndata = [];
                        for (var ykey in result) {
                            var yitem = result[ykey];
                            var yarr = [];
                            for (var mkey in yitem) {
                                yarr.push({
                                    key: mkey,
                                    values: yitem[mkey]
                                });
                            }
                            returndata.push({
                                key: ykey,
                                values: yarr
                            });
                        }
                        asyncResult.aData = returndata;
                        asyncResult.isGit = body.isGit;
                        asyncResult.git = body.git;
                        asyncResult.git_u = body.git_u;
                        asyncResult.git_p = body.git_p;
                    }

                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, asyncResult);
            });

        }, function (arg, callback) {
            var reqUrl = hostname + '/getSVNPath?appId=' + appid;
            var options = {
                url: reqUrl,
                json: true,
                method: 'GET',
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }

            request(options, function (error, response, body) {
                var json;
                if (!error && response.statusCode == 200) {
                    if (body && body.status) {
                        json = arg;
                        json.svnPath = body.result.svnPath;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }], function (err, result) {

            if (err) {
                return res.render(utils.getStatus(err), {
                    url: req.url,
                    jsName: "error400",
                    rolePermission: req.rolePermission
                });
            }
            var result = result || {};
            result.title = i18n.t("common.code");
            result.i18nlng = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
            result.appType = appType;
            result.rolePermission = req.rolePermission;
            res.render('code', result);
        });

    };
});