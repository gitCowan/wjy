define(function (require, exports, module) {
    module.exports = function (req, res) {
        var config = require('../nodeConfig.js');
        var hostname = config.mcmhost;
        var request = require('request');
        var utils = require('../mam/helper.js');
        if (req.cookies.mcmOpened == "1") {
            var appid = req.cookies.curAppId;
            var arr = ["accessToken", "user", "role", "file", "roleMapping", "captcha"];
            var getModelListOptions = {
                url: hostname + '/mcm/explorer/getModelList' + "?times=" + new Date().getTime(),
                method: "GET",
                json: true,
                headers: {
                    'X-APICloud-AppId': appid
                }
            };
            if (req && req.header) {
                getModelListOptions.headers.Cookie = req.header('Cookie');
            }
            request(getModelListOptions, function (error, response, body) {
                var i18n_lang = req.cookies.i18next || "zh-CN";
                i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
                if (body && body.status == 1) {
                    var list = body.result.list;
                    for (var i = 0, len = list.length; i < len; i++) {
                        var modelname = list[i].name;
                        list[i].modelname = modelname;
                        if (arr.indexOf(modelname) != -1) {
                            list[i].name = '_' + modelname;
                        }
                    }
                    return res.render('mcm/database', {
                        title: i18n.t("mainMenu.mcmdatabase"),
                        i18nlng: req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "",
                        list: list,
                        rolePermission: req.rolePermission,
                    });
                } else {
                    return res.render(utils.getStatus(response.statusCode), {
                        url: req.url,
                        jsName: "error400",
                        rolePermission: req.rolePermission
                    });
                }
            })

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
    };
});