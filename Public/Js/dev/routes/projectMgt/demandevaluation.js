define(function (require, exports, module) {
    module.exports = function (req, res) {
        var config = require('../nodeConfig.js');
        var hostname = config.host;
        var request = require('request');
        var async = require('async');
        var utils = require('../mam/helper.js');
        var appid = req.cookies.curAppId;
        var ilng = req.cookies.i18next || "zh-CN";
        var i18n_lang = req.cookies.i18next || "zh-CN";
        i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");

        async.series([

        ], function (err, results) {
            var i18n_lang = req.cookies.i18next || "zh-CN";
            i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
            if (err) {
                return res.render(utils.getStatus(err), {
                    url: req.url,
                    jsName: "error400"
                });
            }
            var result = {};
            result.i18nlng = req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "";
            result.title = i18n.t("需求预评估");


            console.log('******', result);
            result.rolePermission = req.rolePermission;
            res.render('projectMgt/demandevaluation', result);
        });
    }
});