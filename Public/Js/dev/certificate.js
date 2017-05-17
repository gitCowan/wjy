define(function (require, exports, module) {
    module.exports = function (req, res) {
        var request = require('request');
        var appid = req.cookies.curAppId;
        var config = require('./nodeConfig.js');
        var utils = require('./mam/helper.js');
        var username = req.cookies.username;
        var hostname = config.host;
        var options = {
            url: hostname + '/getCer?appId=' + appid,
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
                    var json = body.body[0] || {};
                    json.title = i18n.t("mainMenu.certificate");
                    json.i18nlng = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
                    json.jsfunc = 'function getDataByTemplate() {' + '  return ' + JSON.stringify({
                        androidCert: json.androidP12
                    }) + '};'
                    json.username = username;
                    json.rolePermission = req.rolePermission;
                    res.render('certificate', json);
                }
            } else {
                return res.render(utils.getStatus(response.statusCode), {
                    url: req.url,
                    jsName: "error400",
                    rolePermission: req.rolePermission
                });
            }
        });

    };
});