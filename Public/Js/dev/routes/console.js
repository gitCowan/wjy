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
                var json = {};
                if (!error && response.statusCode == 200) {
                    if (body && body.status) {
                        json.myAppList = body.result;
                        json.apps = body.apps;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (culm, callback) {
            var reqUrl = hostname + '/userTraining';
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
                        json = culm;
                        if (body.data.exipredate > 0) {
                            body.data.isBegin = 1;
                        } else {
                            body.data.isBegin = 0;
                            body.data.exipredate += 37;
                        };
                        body.data.beginTime = getDate(body.data.beginTime);
                        body.data.endTime = getDate(body.data.endTime);
                        json.culm = body;
                    } else {
                        json = culm;
                        json.culm = '';
                    }
                } else {
                    return callback(response.statusCode, []);
                }

                function getDate(result) {
                    var date = new Date(result),
                        year = date.getFullYear(),
                        month = date.getMonth() + 1,
                        day = date.getDate();
                    return year + '.' + month + '.' + day;
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var options = {
                url: hostname + '/getTicketInfo',
                json: true,
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }

            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200 && body.status == 1) {
                    var time = {};
                    time.min = parseInt(body.result.time / 60);
                    time.second = body.result.time - time.min * 60;
                    body.result.time = time;
                    var result = arg;
                    result.consult = body.result;
                    callback(null, result);
                } else {
                    callback(null, arg);
                }
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
            var reqUrl = 'http://module.apicloud.com/getApicloudSdk?length=8&platform=0';
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
                var json = arg;
                if (!error && response.statusCode == 200) {
                    if (body && body.status) {
                        json.sdkhistory = body.body;
                        json.sdkhistory[0].downloadable = 1;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = config.host + '/api/isuseloader';
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
                var json = arg;
                if (!error && response.statusCode == 200) {
                    if (body && body.status) {
                        if (body.result && body.result.state === 1) {
                            json.isuseloader = 1;
                        }
                        if (body.result && body.result.inseven_day === 0) {
                            json.isseven_day = 1;
                        }
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
            result.title = i18n.t("subMenu.console");
            result.layout = './console-layout';
            result.rolePermission = req.rolePermission;
            res.render('console', result);
        });
    };
});