define(function (require, exports, module) {
    module.exports = function (req, res) {
        var request = require('request');
        var async = require('async');
        var utils = require('./mam/helper.js');
        var appid = req.cookies.curAppId;
        var appname = req.cookies.curAppName;
        var config = require('./nodeConfig.js');
        var hostname = config.host;
        async.waterfall([

        function (callback) {
            if (appid) {
                return callback(null, appid);
            }
            var options = {
                url: hostname + '/getFirstApp',
                json: true,
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    appid = body.body.appId;
                    appname = body.body.appName;
                } else {}
                callback(null, appid);
            });

        }, function (appid_temp, callback) {
            var options1 = {
                url: hostname + '/api2/app/info?appId=' + appid_temp,
                json: true,
                jar: true,
                headers: {}
            };
            if (req && req.header) {
                options1.headers.Cookie = req.header('Cookie');
            }
            request(options1, function (error, response, body) {
                var json;
                if (!error && response.statusCode == 200) {
                    json = body.result || {};
                    json.appid_temp = appid_temp;
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });

        }, ], function (err, result) {
            var i18n_lang = req.cookies.i18next || "zh-CN";
            i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
            if (err) {
                return res.render(utils.getStatus(err), {
                    url: req.url,
                    jsName: "error400",
                    rolePermission: req.rolePermission
                });
            }
            result.i18nlng = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
            result.title = i18n.t("mainMenu.overview");
            result.rolePermission = req.rolePermission;
            res.render('appoverview', result);
        });
    };
});