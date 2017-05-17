define(function (require, exports, module) {
    module.exports = function (req, res) {
        var request = require('request');
        var async = require('async');
        var appid = req.cookies.curAppId;
        var appName = req.cookies.curAppName;
        var config = require('./nodeConfig.js');
        var utils = require('./mam/helper.js');
        var hostname = config.host;
        async.waterfall([

        function (callback) {
            var options = {
                url: hostname + '/getPKG?appId=' + appid,
                json: true,
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                var json;
                if (!error && response.statusCode == 200) {
                    if (body && body.status) {
                        json = body.body || {};
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);


            });

        }, function (arg, callback) {
            var reqUrl = hostname + '/getAllUnpack?appId=' + appid + '&startNum=0&num=5';
            var options = {
                url: reqUrl,
                json: true,
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
                        json.packHistory = body.body;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = hostname + '/getpkgChannelPrice?appId=' + appid;
            var options = {
                url: reqUrl,
                json: true,
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
                        var data = body.result;
                        var time = data.createTime;
                        var date = new Date(time),
                            year = date.getFullYear(),
                            month = date.getMonth() + 1,
                            day = date.getDate();
                        data.createTime = year + '.' + month + '.' + day;
                        json.channelPrice = data;
                        json.channelPrice.appName = appName;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = hostname + '/checkVipPackService';
            var options = {
                url: reqUrl,
                json: true,
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
                        json.createState = body.result.buy;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
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
            result.title = i18n.t("mainMenu.package");
            result.i18nlng = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
            result.appId = appid;
            result.curAppType = req.cookies.appType;
            result.rolePermission = req.rolePermission;
            res.render('package', result);
        });


    };
});