define(function (require, exports, module) {
    module.exports = function (req, res) {
        var i18n_lang = req.cookies.i18next || "zh-CN";
        i18n.setLng(i18n_lang == "zh-CN" ? "zh-CN" : "en-US");
        res.render('auth', {
            title: i18n.t("feTitle.Authentication"),
            rolePermission: req.rolePermission
        });
    };
});