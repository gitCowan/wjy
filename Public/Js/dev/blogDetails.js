define(function (require, exports, module) {
    module.exports = function (req, res) {
        var request = require('request');
        var utils = require('./mam/helper.js');
        var config = require('./nodeConfig.js');
        var hostname = config.host;

        var newsId = req.query.id;

        var options = {
            url: hostname + '/newsDetail?id=' + newsId,
            json: true,
            jar: true,
            headers: {}
        };

        if (req && req.header) {
            options.headers.Cookie = req.header('Cookie');
        }

        request(options, function (error, response, body) {
            var i18n_lang = req.cookies.i18next || "zh-CN";
            i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
            if (!error && response.statusCode == 200) {
                if (body && body.status) {
                    var json = {};
                    json.news = body.data || {};
                    json.title = json.news.title || 'APICloud官网博客';
                    json.i18nlng = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
                    json.layout = "./standalone/homeLayout";
                    res.render('./standalone/blogDetails', json);
                }
            } else {
                return res.render(utils.getStatus(response.statusCode), {
                    url: req.url,
                    jsName: "error400"
                });
            }
        });



    };
});