define(function (require, exports, module) {
    module.exports = function (req, res) {
        var DetailsData = [

        ];

        var totalData = {
            details: DetailsData,
            pagetotal: Math.ceil(DetailsData.length / 10)
        };
        var json = {
            title: i18n.t("Total.CustomEvent"),
            i18nlng: req.cookies.i18next && req.cookies.i18next == "en-US" ? "en" : "",
            rolePermission: req.rolePermission,
            jsfunc: 'function getDataByTemplate() {' + '  return ' + JSON.stringify(totalData) + '};'
        };
        res.render('mam/event', json);
    }
});