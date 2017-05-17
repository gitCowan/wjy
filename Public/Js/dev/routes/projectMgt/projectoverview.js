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

        function requests(callback) { // 获取动态
            var options1 = {
                url: hostname + '/uzapp/pm/overview/getDynamic?appId=' + appid,
                json: true,
                headers: {}
            };
            if (req && req.header) {
                options1.headers.Cookie = req.header('Cookie');
            }
            request(options1, function (error, response, body) {
                if (!error && response.statusCode == 200 && body.status == 1 && body.result.length > 0) {

                    var thisResult = [];
                    var dateResult = {};
                    for (var i = 0; i < body.result.length; i++) {
                        var thisNode = body.result[i];
                        var thisDate = new Date(thisNode.ct);
                        var year = thisDate.getFullYear();
                        var month = thisDate.getMonth() + 1;
                        var day = thisDate.getDate();
                        var hour = thisDate.getHours();
                        var minute = thisDate.getMinutes();
                        var second = thisDate.getSeconds();
                        var yearMonth = ilng == "zh-CN" ? (year + "年" + month + "月") : (month + "/" + year);
                        var monthDay = ilng == "zh-CN" ? (month + "月" + day + "日") : (day + "/" + month);
                        var hourMinute = ilng == "zh-CN" ? (hour + "时" + minute + "分") : (hour + ":" + minute);
                        var statusMap = {
                            0: '动态',
                            1: '评论',
                            7: '开发方确认',
                            8: '需求方确认',
                            9: '双方确认'
                        };
                        var pTypeMap = {
                            '-1': '-1',
                            0: '0',
                            1: '1',
                            2: '2',
                            3: '3',
                            4: '4',
                            5: '5',
                            6: '6',
                            7: '7',
                            8: '8'
                        };
                        var statusStr = statusMap[thisNode.type];
                        var pTypeStr = pTypeMap[thisNode.plan_type];
                        var thisObj = {
                            monthDay: monthDay,
                            hourMinute: hourMinute,
                            avatar: thisNode.icon2 || '/img/favicon.png',
                            info: thisNode.info || '',
                            status: statusStr || '',
                            plan_type: pTypeStr || '',
                            userName: thisNode.userName
                        }
                        if (!dateResult[yearMonth]) {
                            dateResult[yearMonth] = {};
                        }
                        if (!dateResult[yearMonth][monthDay]) {
                            dateResult[yearMonth][monthDay] = [];
                        }
                        dateResult[yearMonth][monthDay].push(thisObj)
                    }
                    for (var ykey in dateResult) {
                        var yitem = dateResult[ykey];
                        var yarr = [];
                        for (var mkey in yitem) {
                            yarr.push({
                                key: mkey,
                                values: yitem[mkey]
                            });
                        }
                        thisResult.push({
                            key: ykey,
                            values: yarr
                        });
                    }
                    callback(null, thisResult);
                } else {
                    callback(null, []);
                }
            });

        }, ], function (err, results) {
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
            result.title = i18n.t("项目管理总览");

            result.rolePermission = req.rolePermission;
            // console.log('******', result);
            res.render('projectMgt/projectoverview', result);
        });
    }
});