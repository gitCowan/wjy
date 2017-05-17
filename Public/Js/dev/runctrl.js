define(function (require, exports, module) {
    module.exports = function (req, res) {
        var config = require('./nodeConfig.js');
        var hostname = config.host;
        var request = require('request');
        var utils = require('./mam/helper.js');
        var appid = req.cookies.curAppId;
        var options = {
            url: hostname + '/api/msm/runcontrol?appId=' + appid + "&timetick=" + new Date().getTime(),
            method: "GET",
            json: true,
            headers: {}
        };
        if (req && req.header) {
            options.headers.Cookie = req.header('Cookie');
        }
        request(options, function (error, response, body) {
            var i18n_lang = req.cookies.i18next || "zh-CN";
            i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
            if (!error && response.statusCode == 200) {
                if (body && body.status == 1) {
                    var json = {
                        title: i18n.t("feTitle.Operation"),
                        i18nlng: req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "",
                        jsfunc: 'function getDataByTemplate() {' + '  return ' + JSON.stringify(body.result) + '};'
                    };
                    json.rolePermission = req.rolePermission;
                    return res.render('runctrl', json);
                }
            }
            return res.render(utils.getStatus(response.statusCode), {
                url: req.url,
                jsName: "error400",
                rolePermission: req.rolePermission
            });
        })
    };
});