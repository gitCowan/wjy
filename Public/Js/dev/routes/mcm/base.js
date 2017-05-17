define(function (require, exports, module) {
    module.exports = function (req, res) {
        var config = require('../nodeConfig.js');
        var utils = require('../mam/helper.js');
        var hostname = config.mcmhost;
        var request = require("request");
        if (req.cookies.mcmOpened == "1") {
            var getModelListOptions = {
                url: hostname + "/mcm/explorer/getAppInfo",
                method: "GET",
                cache: false,
                json: true,
                headers: {
                    'X-APICloud-AppId': req.cookies.curAppId
                }
            };
            if (req && req.header) {
                getModelListOptions.headers.Cookie = req.header('Cookie');
            }
            request(getModelListOptions, function (error, response, body) {
                var i18n_lang = req.cookies.i18next || "zh-CN";
                i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
                if (body && body.status == 1) {
                    return res.render('mcm/base', {
                        title: i18n.t("mainMenu.mcmbase"),
                        i18nlng: req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "",
                        rolePermission: req.rolePermission,
                        obj: body.result
                    });
                }
                return res.render(utils.getStatus(response.statusCode), {
                    url: req.url,
                    jsName: "error400",
                    rolePermission: req.rolePermission
                });
            });

        } else {
            var options = {
                url: hostname + "/mcm/explorer/isTurnOver",
                method: "POST",
                cache: false,
                json: true,
                headers: {
                    'X-APICloud-AppId': req.cookies.curAppId
                }
            }
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                var i18n_lang = req.cookies.i18next || "zh-CN";
                i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
                if (body && body.status == 1) {
                    return res.render('mcm/databaseAuth', {
                        title: i18n.t("mainMenu.mcmapi"),
                        i18nlng: req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "",
                        jsName: "dataAuth",
                        rolePermission: req.rolePermission,
                        jsfunc: 'function getDataByTemplate() {' + '  return ' + JSON.stringify({
                            isTurnOver: body.result || false
                        }) + '};'
                    });
                }
                return res.render(utils.getStatus(response.statusCode), {
                    url: req.url,
                    jsName: "error400",
                    rolePermission: req.rolePermission
                });
            });
        }
    }
});