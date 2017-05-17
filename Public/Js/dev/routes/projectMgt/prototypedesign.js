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

        function dateFormat(str) {
            var strMon, strDate;
            if (i18n_lang == 'en-US') {
                strMon = '-';
                strDate = ' ';
            } else {
                strMon = '月';
                strDate = '日 ';
            }

            function toDouble(num) {
                var result;
                if (num < 10) {
                    result = '0' + num;
                } else {
                    result = num;
                }
                return result;
            }
            var thisDate = new Date(str);
            var result = thisDate.getMonth() + 1 + strMon + thisDate.getDate() + strDate + toDouble(thisDate.getHours()) + ':' + toDouble(thisDate.getMinutes());
            return result;
        }

        async.series([

        function requests(callback) { // 获取计划
            var options = {
                url: hostname + '/uzapp/pm/overview/getChilePlanByType?type=0&appId=' + appid,
                json: true,
                headers: {}
            };
            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200 && body.status == 1) {
                    var thisResult = body.result;
                    for (var i = 0; i < thisResult['parent'].length; i++) {
                        var thisNode = thisResult['parent'][i];
                        if (thisNode.begin_time) {
                            thisNode.begin_time = utils.toFormat(thisNode.begin_time, 'yyyy-MM-dd');
                        }
                        if (thisNode.end_time) {
                            thisNode.end_time = utils.toFormat(thisNode.end_time, 'yyyy-MM-dd');
                        }
                        if (thisNode.actual_finish_time) {
                            thisNode.actual_finish_time = utils.toFormat(thisNode.actual_finish_time, 'yyyy-MM-dd');
                        }
                        if (thisNode.demand_side_ack_time) {
                            thisNode.demand_side_ack_time = dateFormat(thisNode.demand_side_ack_time);
                        }
                        if (thisNode.developer_ack_time) {
                            thisNode.developer_ack_time = dateFormat(thisNode.developer_ack_time);
                        }
                    }
                    for (var j = 0; j < thisResult['child'].length; j++) {
                        var childNode = thisResult['child'][j];
                        if (childNode.begin_time) {
                            childNode.begin_time = utils.toFormat(childNode.begin_time, 'yyyy-MM-dd');
                        }
                        if (childNode.end_time) {
                            childNode.end_time = utils.toFormat(childNode.end_time, 'yyyy-MM-dd');
                        }
                        if (childNode.actual_finish_time) {
                            childNode.actual_finish_time = utils.toFormat(childNode.actual_finish_time, 'yyyy-MM-dd');
                        }
                        if (childNode.demand_side_ack_time) {
                            childNode.demand_side_ack_time = utils.toFormat(childNode.demand_side_ack_time, 'yyyy-MM-dd');
                        }
                        if (childNode.developer_ack_time) {
                            childNode.developer_ack_time = utils.toFormat(childNode.developer_ack_time, 'yyyy-MM-dd');
                        }
                    }
                    var fullResult = {};
                    fullResult.parentlist = thisResult['parent'];
                    fullResult.childlist = thisResult['child'];
                    callback(null, fullResult);
                } else {
                    callback(null, {
                        parentlist: [],
                        childlist: []
                    });
                }
            });

        }], function (err, results) {
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
            result.title = i18n.t("产品原型设计");

            var getChilePlans = results[0];

            result.parentlist = getChilePlans.parentlist;
            result.childlist = getChilePlans.childlist;
            result.rolePermission = req.rolePermission;
            console.log('******', result);
            res.render('projectMgt/prototypedesign', result);
        });
    }
});