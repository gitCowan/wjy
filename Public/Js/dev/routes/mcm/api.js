define(function (require, exports, module) {
    module.exports = function (req, res) {
        var config = require('../nodeConfig.js');
        var utils = require('../mam/helper.js');
        var hostname = config.mcmhost;
        var request = require("request");
        if (req.cookies.mcmOpened != "1") {
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
        } else {
            var getModelListOptions = {
                url: hostname + "/mcm/explorer/getModelList",
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
            var systemModel = ['accessToken', 'file', 'role', 'user', 'roleMapping'];
            request(getModelListOptions, function (error, response, body) {
                var i18n_lang = req.cookies.i18next || "zh-CN";
                i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
                if (body && body.status == 1) {
                    var list = body.result.list;
                    var resultList = [];
                    for (var i = 0, len = list.length; i < len; i++) {
                        var modelname = list[i].name;
                        if (systemModel.indexOf(modelname) != -1) modelname = '_' + modelname;
                        resultList.push({
                            name: modelname,
                            value: list[i].name
                        });
                    }
                    return res.render('mcm/api', {
                        title: i18n.t("mainMenu.mcmapi"),
                        i18nlng: req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "",
                        list: resultList,
                        rolePermission: req.rolePermission
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