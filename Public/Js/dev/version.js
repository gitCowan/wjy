define(function (require, exports, module) {
    module.exports = function (req, res) {
        var request = require('request');
        var async = require('async');
        var appid = req.cookies.curAppId;
        var appname = req.cookies.curAppName;
        var config = require('./nodeConfig.js');
        var utils = require('./mam/helper.js');
        var hostname = config.mamhost;
        async.waterfall([

        function (callback) {
            var options = {
                url: hostname + '/queryVerByCondition',
                json: true,
                method: 'POST',
                jar: true,
                form: {
                    appId: appid,
                    queryType: 3,
                    startPos: 0,
                    queryCount: 5
                },
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
                url: hostname + '/uzindex_getpkgversionlist',
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
                if (!error && response.statusCode == 200) {
                    arg.list = body;
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, arg);
            });

        }, function (arg, callback) {
            var options = {
                url: hostname + '/getChannel?appId=' + appid,
                json: true,
                method: 'get',
                jar: true,
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    if (body.status) {
                        arg.channel = body.result;
                    };
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
                    jsName: "error400",
                    rolePermission: req.rolePermission
                });
            }
            var data = result || {};
            data.title = i18n.t("mainMenu.version");
            data.i18nlng = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
            data.rolePermission = req.rolePermission;
            res.render('version', data);
        });
    };

});