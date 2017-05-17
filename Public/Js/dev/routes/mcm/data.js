define(function (require, exports, module) {
    function toFixed(num, len) {
        var str = num.toString();
        if (len == 0) {
            return Math.floor(num);
        }
        var reg = /\d+\.\d+/g;
        if (reg.test(str)) {
            return str.substring(0, str.indexOf('.') + len + 1);
        }
        str = str.replace('.0', '');
        return str;
    }

    function isLe(num) {
        return !!(num < 1 && num > 0);
    }
    module.exports = function (req, res) {
        var utils = require('../mam/helper.js');
        var config = require('../nodeConfig.js');
        var hostname = config.mcmhost;
        var request = require("request");
        if (req.cookies.mcmOpened == "1") {
            var options = {
                url: hostname + '/mcm/explorer/getAnalysisInfo',
                method: "GET",
                json: true,
                headers: {
                    'X-APICloud-AppId': req.cookies.curAppId
                }
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                var i18n_lang = req.cookies.i18next || "zh-CN";
                i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
                var result = body.result;
                var baseG = 1024 * 1024 * 1024.0;
                var baseM = 1024 * 1024.0;

                var totalData = {
                    dbuse: 0,
                    dbunuse: 10,
                    fileuse: 0,
                    fileunuse: 10,
                    transferuse: 0,
                    transferunuse: 20,
                    served: 0,
                    failed: 0,
                    total: 1
                };
                var jsondata = {
                    title: "data",
                    db: 0,
                    file: 0,
                    transfer: 0,
                    apir: 0,
                    jsfunc: 'function getDataByTemplate() {' + '  return ' + JSON.stringify(totalData) + '};'
                };
                if (body.status == 1) {
                    var db = 0,
                        dbm, dbt = 10;
                    if (result.db / baseM > 1000) {
                        db = toFixed(result.db / baseG, 1);
                        dbm = "G";
                    } else {
                        dbt = dbt * 1024;
                        db = toFixed(result.db / baseM, 0);
                        dbm = "M";
                    }
                    var file = 0,
                        filem, filet = 10;
                    if (result.db / baseM > 1000) {
                        file = toFixed(result.file / baseG, 1);
                        filem = "G";
                    } else {
                        file = toFixed(result.file / baseM, 0);
                        filem = "M";
                        filet = 20 * 1024;
                    }
                    var transfer = 0,
                        transferm, transfert = 20;
                    if (result.db / baseM > 1000) {
                        transfer = toFixed(result.transfer / baseG, 1);
                        transferm = "G";
                    } else {
                        transfer = toFixed(result.transfer / baseM, 0);
                        transferm = "M";
                        transfert = transfert * 2014;
                    }

                    totalData = {
                        dbuse: db,
                        dbunuse: dbt - db,
                        fileuse: file,
                        fileunuse: filet - file,
                        transferuse: transfer,
                        transferunuse: transfert - transfer,
                        served: result.serverd,
                        failed: result.failed,
                        total: (result.serverd + result.failed) ? 0 : 1
                    };
                    jsondata = {
                        title: i18n.t("mainMenu.mcmdata"),
                        db: isLe(db) ? 1 : db,
                        dbm: dbm || "M",
                        dbz: isLe(db) ? "<" : "",
                        file: isLe(file) ? 1 : file,
                        filem: filem || "M",
                        filez: isLe(file) ? "<" : "",
                        transfer: isLe(transfer) ? 1 : transfer,
                        transferm: transferm || "M",
                        transferz: isLe(transfer) ? "<" : "",
                        served: result.serverd || 0,
                        apir: (result.serverd || 0) + (result.failed || 0),
                        i18nlng: req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "",
                        rolePermission: req.rolePermission,
                        jsfunc: 'function getDataByTemplate() {' + '  return ' + JSON.stringify(totalData) + '};'
                    }
                    return res.render('mcm/data', jsondata);
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