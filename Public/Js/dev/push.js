define(function (require, exports, module) {
    module.exports = function (req, res) {
        var request = require('request');
        var async = require('async');
        var appid = req.cookies.curAppId;
        var appname = req.cookies.curAppName;
        var config = require('./nodeConfig.js');
        var utils = require('./mam/helper.js');
        var hostname = config.host;
        async.parallel({
            devs: function (callback) {
                var options = {
                    url: hostname + '/api/push/statistics?appId=' + appid,
                    method: 'GET',
                    json: true,
                    headers: {}
                };
                if (req && req.header) {
                    options.headers.Cookie = req.header('Cookie');
                }
                request(options, function (error, response, body) {
                    if (!error && response.statusCode == 200) {} else {
                        return callback(response.statusCode, []);
                    }
                    var json = body.result;
                    callback(null, json);
                });
            },
            messages: function (callback) {
                var options = {
                    url: hostname + '/api/push/messages?si=0&ps=5&appId=' + appid,
                    method: 'GET',
                    json: true,
                    jar: true,
                    headers: {}
                };
                if (req && req.header) {
                    options.headers.Cookie = req.header('Cookie');
                }
                request(options, function (error, response, body) {
                    if (!error && response.statusCode == 200) {} else {
                        return callback(response.statusCode, []);
                    }
                    var json = body.result.items;
                    callback(null, json);
                });
            },
            groups: function (callback) {
                var options = {
                    url: hostname + '/uzindex_getgrouplist',
                    json: true,
                    method: 'POST',
                    form: {
                        curAppId: appid
                    },
                    jar: true,
                    headers: {}
                };
                if (req && req.header) {
                    options.headers.Cookie = req.header('Cookie');
                }
                request(options, function (error, response, body) {
                    if (!error && response.statusCode == 200) {} else {
                        return callback(response.statusCode, []);
                    }
                    var json = body.msg;
                    callback(null, json);
                });
            },
            config: function (callback) {
                var options = {
                    url: hostname + '/uzampushsetting_select',
                    json: true,
                    method: 'POST',
                    form: {
                        curAppId: appid
                    },
                    jar: true,
                    headers: {}
                };
                if (req && req.header) {
                    options.headers.Cookie = req.header('Cookie');
                }
                request(options, function (error, response, body) {
                    if (!error && response.statusCode == 200) {} else {
                        return callback(response.statusCode, []);
                    }
                    var json = body.msg[0];
                    callback(null, json);
                });
            }
        }, function (err, result) {
            var i18n_lang = req.cookies.i18next || "zh-CN";
            i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
            if (err) {
                return res.render(utils.getStatus(err), {
                    url: req.url,
                    jsName: "error400",
                    rolePermission: req.rolePermission
                });
            }
            result.title = i18n.t("mainMenu.push");
            result.i18nlng = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
            result.rolePermission = req.rolePermission;
            res.render('push', result);
        })
    };
});