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
                url: hostname + '/api/user/setting',
                json: true,
                headers: {}
            }
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                var json = {};
                console.log('statusCode is ', response.statusCode)
                if (!error && response.statusCode == 200) {
                    if (body && body.status) {
                        if (body.result) {
                            json.isLogin = true;
                        } else {
                            json.isLogin = false;
                        };
                    }
                } else {
                    json.isLogin = false;
                }
                callback(null, json);

            });
        }, function (arg, callback) {
            var options = {
                url: hostname + '/getAllMdStore?startNum=0&size=5&order=1&platform=-1',
                json: true,
                method: 'GET',
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                var result = arg;
                if (!error && response.statusCode == 200) {
                    result.newList = body.body;
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, result);
            });

        }, function (arg, callback) {
            var reqUrl = hostname + '/getRanking?isfree=1';
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
                        json.rankList = body.body;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = hostname + '/getSelectedMd';
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
                        json.selectedList = body.body;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = hostname + '/getRanking?isfree=1';
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
                        json.freeList = body.body;
                    }
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, json);
            });
        }, function (arg, callback) {
            var reqUrl = hostname + '/getRanking?isfree=0';
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
                        json.payList = body.body;
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
            result.title = '聚合API';
            result.i18n_lang = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
            result.layout = './standalone/homeLayout';
            result.user = req.feUser;
            res.render('./standalone/modulestore', result);
        });
    };
});