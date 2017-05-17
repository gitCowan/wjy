define(function (require, exports, module) {
    module.exports = function (req, res) {
        var request = require('request');
        var async = require('async');
        var appid = req.cookies.curAppId;
        var appname = req.cookies.curAppName;
        var config = require('./nodeConfig.js');
        var utils = require('./mam/helper.js');
        var hostname = config.host;

        async.waterfall([

        function (callback) {
            var options = {
                url: hostname + '/api/msm/app_store?iDisplayStart=0&iDisplayLength=5',
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
                callback(null, body);
            });

        }, function (arg, callback) {
            var options = {
                url: hostname + '/api/msm/app_store/groups',
                json: true,
                jar: true,
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    arg.groups = body.result;
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, arg);
            });

        }, function (arg, callback) {
            var options = {
                url: hostname + '/api/msm/app_store/apps/publishable',
                json: true,
                jar: true,
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    arg.appinfo = body.result;
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, arg);
            });

        }], function (err, result) {
            var i18n_lang = req.cookies.i18next || "zh-CN";
            i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
            if (err) {
                return res.render(utils.getStatus(err), {
                    url: req.url,
                    jsName: "error400"
                });
            }
            var result = result || {};
            result.title = i18n.t("feTitle.Enterprise");
            res.render('appstore', result);
        });
    };
});