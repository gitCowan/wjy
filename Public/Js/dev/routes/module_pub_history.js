define(function (require, exports, module) {
    module.exports = function (req, res) {

        var request = require('request');
        var async = require('async');
        var config = require('./nodeConfig.js');
        var utils = require('./mam/helper.js');
        var hostname = config.host;

        async.waterfall([

        function (callback) {
            var options = {
                url: hostname + '/api/user/info',
                json: true,
                method: 'GET',
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                var result = {};
                if (!error && response.statusCode == 200) {
                    var data = body;
                    if (data && data.status) {

                    } else {
                        return res.render('./users/signin', {
                            layout: './users/usersLayout',
                            i18nlng: req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "",
                            title: i18n.t("common.login")
                        });
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, result);
            });

        }, function (arg, callback) {
            var reqUrl = hostname + '/getAllMdStoreByUser';
            var options = {
                url: reqUrl,
                json: true,
                method: 'POST',
                form: {
                    start: 0,
                    size: 8
                },
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
                        json.list = body.body;
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
                    jsName: "error400"
                });
            }
            var result = result || {};
            result.title = i18n.t("moduleStore.ModuleMgt");
            result.i18n_lang = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
            result.layout = './standalone/homeLayout';
            res.render('./standalone/module_pub_history', result);
        });
    };
});