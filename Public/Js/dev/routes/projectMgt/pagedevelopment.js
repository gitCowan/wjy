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
                url: hostname + '/uzapp/pm/overview/getChilePlanByType?type=2&appId=' + appid,
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

        }, function requests(callback) {
            var options = {
                url: hostname + '/getCADSVNList?appId=' + appid,
                json: true,
                headers: {}
            };

            if (req && req.header) {
                options.headers.Cookie = req.header('Cookie');
            }
            request(options, function (error, response, body) {
                if (!error && response.statusCode == 200) {
                    var codeResult = body.aaData;
                    var result = {};
                    for (var r = 0, rlen = codeResult.length; r < rlen; r++) {
                        var ritem = codeResult[r];
                        var strs = ritem.date.split(" ");
                        var dates = strs[0].split('-');
                        var times = strs[1].split(':');
                        var year = parseInt(dates[0], 10);
                        var month = parseInt(dates[1], 10);
                        var day = parseInt(dates[2], 10);
                        var hour = parseInt(times[0], 10);
                        var minute = parseInt(times[1], 10);
                        var second = parseInt(times[2], 10);
                        var yearMonth = ilng == "zh-CN" ? (year + "年" + month + "月") : (month + "/" + year);
                        var monthDay = ilng == "zh-CN" ? (month + "月" + day + "日") : (day + "/" + month);
                        var hourMinute = ilng == "zh-CN" ? (hour + "时" + minute + "分") : (hour + ":" + minute);
                        var status = ritem.type.join("; ").replace("A", i18n.t("cadCode.addedCode")).replace("D", i18n.t("cadCode.deletedCode")).replace("M", i18n.t("cadCode.modifiedCode"));
                        var dobj = {
                            monthDay: monthDay,
                            hourMinute: hourMinute,
                            avatar: ritem.avatar || "/img/favicon.png",
                            author: ritem.author || "",
                            message: ritem.message || "",
                            ver: ritem.ver,
                            stats: status
                        }
                        if (!result[yearMonth]) {
                            result[yearMonth] = {};
                        }
                        if (!result[yearMonth][monthDay]) {
                            result[yearMonth][monthDay] = [];
                        }
                        result[yearMonth][monthDay].push(dobj)
                    }

                    var returndata = [];
                    for (var ykey in result) {
                        var yitem = result[ykey];
                        var yarr = [];
                        for (var mkey in yitem) {
                            yarr.push({
                                key: mkey,
                                values: yitem[mkey]
                            });
                        }
                        returndata.push({
                            key: ykey,
                            values: yarr
                        });
                    }
                    return callback(null, returndata);
                } else {
                    return callback(null, []);
                }
            });

        }, function requests(callback) {
            var options1 = {
                url: hostname + '/uzapp/pm/static_page/getAppStatus?appId=' + appid,
                json: true,
                jar: true,
                headers: {}
            };
            if (req && req.header) {
                options1.headers.Cookie = req.header('Cookie');
            }
            request(options1, function (error, response, body) {
                var json;
                if (!error && response.statusCode == 200) {
                    json = body.result || [];
                } else {
                    return callback(null, []);
                }
                callback(null, json);
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
            result.title = i18n.t("APP端开发");

            var getChilePlans = results[0],
                getAdata = results[1],
                getState = results[2];

            result.parentlist = getChilePlans.parentlist;
            result.childlist = getChilePlans.childlist;
            result.aData = getAdata;
            result['stat-info'] = getState;
            console.log('******', result);
            result.rolePermission = req.rolePermission;
            res.render('projectMgt/pagedevelopment', result);
        });
    }
});