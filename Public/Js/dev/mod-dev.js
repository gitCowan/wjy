define(function (require, exports, module) {
    module.exports = function (req, res) {

        var request = require('request');
        var async = require('async');
        var config = require('./nodeConfig.js');
        var utils = require('./mam/helper.js');
        var hostname = config.host;
        var type = req.cookies['data-first'] || 2;
        var subclass = req.cookies['data-second'] || 0;
        async.waterfall([

        function (callback) {
            var options = {
                url: hostname + '/getAllMdStore?startNum=0&size=12&order=1&platform=-1&searchByName=false&type=' + type + '&subclass=' + subclass,
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
                    result.list = body.body;
                    result.allNum = body.allNum;
                    result.searchNum = body.searchNum;
                } else {
                    return callback(response.statusCode, []);
                }
                callback(null, result);
            });

        }, function (arg, callback) {
            var reqUrl = hostname + '/getSelectedMdByType?type=' + type;
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
                if (error) {
                    console.log(JSON.stringify(error));
                }
                if (!error && response.statusCode == 200) {
                    if (body && body.status) {
                        json = arg;
                        json.selectList = body.body;
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
            result.i18n_lang = i18n_lang;
            result.layout = './standalone/homeLayout';
            res.render('./standalone/mod-show', result);
        });

    };
});