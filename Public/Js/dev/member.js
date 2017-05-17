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
                url: hostname + '/getAllAppByUser',
                json: true,
                method: 'POST',
                headers: {},
                form: {
                    cooperate_flag: 1
                }
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
            var reqUrl = hostname + '/api/apps';
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
                        json.myAppList = body.result;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = hostname + '/api2/cooperator';
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
                        json.myCooperator = body.result;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = hostname + '/api2/cooperator/demand';
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
                // console.log('..............',body.result);
                if (!error && response.statusCode == 200) {
                    if (body && body.status) {
                        json = arg;
                        json.reqCooperator = body.result;
                    }
                } else {
                    return callback(response.statusCode, []);
                }

                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = hostname + '/api/user/setting';
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
                        var phone = body.result.phone;
                        json.phone = phone;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = hostname + '/api2/cooperator/getCustomApp';
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
                        if (body.result.length == 0) {
                            json.relationship = 1;
                            json.appList = body.result;
                        } else if (body.result.length > 0) {
                            json.relationship = 2;
                            json.appList = body.result;
                        }
                        // json.relationship = 2;
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
            var result = result || {};
            result.title = i18n.t("subMenu.member");
            result.layout = './console-layout';
            result.rolePermission = req.rolePermission;
            res.render('member', result);
        });
    };
});