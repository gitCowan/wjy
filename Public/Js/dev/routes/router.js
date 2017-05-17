define(function (require, exports, module) {
    module.exports = function (app) {
        var blog = require('./blog.js');
        app.get('/blog', blog);
        var blogDetails = require('./blogDetails.js');
        app.get('/blogDetails', blogDetails);

        var _console = require('./console.js');
        app.get('/console', _console);
        var appoverview = require('./appoverview.js');
        app.get('/appoverview', appoverview);

        var restore = require('./restore.js');
        app.get('/restore', restore);

        var profile = require('./profile.js');
        app.get('/profile', profile);
        var certificate = require('./certificate.js');
        app.get('/certificate', certificate);
        var code = require('./code.js');
        app.get('/code', code);
        var version = require('./version.js');
        app.get('/version', version);

        var pack = require('./package.js');
        app.get('/package', pack);

        var appstore = require('./appstore.js');
        app.get('/appstore', appstore);
        var auth = require('./auth.js');
        app.get('/auth', auth);
        var runctrl = require('./runctrl.js');
        app.get('/runctrl', runctrl);
        var member = require('./member.js');
        app.get('/member', member);
        var CADConfig = require('./CADConfig.js');
        app.get('/CADConfig', CADConfig);
        var CADAd = require('./CADAd.js');
        app.get('/CADAd', CADAd);
        var push = require('./push.js');
        app.get('/push', push);

        app.get('/module', require('./module.js'));
        app.get('/module-store', require('./module-store.js'));
        app.get('/module-custom', require('./module-custom.js'));
        app.get('/module-auth', require('./module-auth.js'));
        app.get('/module-loader', require('./module-loader.js'));
        app.get('/modulestore', require('./modulestore.js'));
        app.get('/module_pub_history', require('./module_pub_history.js'));
        app.get('/mod-ui', require('./mod-ui.js'));
        app.get('/mod-nav', require('./mod-nav.js'));
        app.get('/mod-ext', require('./mod-ext.js'));
        app.get('/mod-sdk', require('./mod-sdk.js'));
        app.get('/mod-dev', require('./mod-dev.js'));
        app.get('/mod-cloud', require('./mod-cloud.js'));

        app.get("/total", require('./mam/total.js'));
        app.get("/totalversion", require('./mam/version.js'));
        app.get("/totalarea", require('./mam/area.js'));
        app.get("/totalterminal", require('./mam/terminal.js'));
        app.get("/totalerror", require('./mam/error.js'));
        app.get("/totalcustom", require('./mam/event.js'));

        app.get("/mcmdatabase", require('./mcm/database.js'));
        app.get("/mcmbase", require('./mcm/base.js'));
        app.get("/mcmapi", require('./mcm/api.js'));
        app.get("/mcmdata", require('./mcm/data.js'));


        app.get("/tech-share", require('./tech-share.js'));
        app.get("/training_entrance", require('./training_entrance.js'));
        app.get("/watchvideo", require('./watchvideo.js'));

        app.get("/launch", require('./launch.js'));

        app.get("/nativeSdk", require('./nativeSdk.js'));

        app.get("/order", require('./order.js'));
        app.get("/conlist", require('./conlist.js'));
        app.get("/conDetails", require('./conDetails.js'));
        app.get("/recommendList", require('./recommendList.js'));
        app.get("/recommendDetails", require('./recommendDetails.js'));
        app.get("/noticeList", require('./noticeList.js'));
        app.get("/noticeDetails", require('./noticeDetails.js'));
        app.get("/orderProblem", require('./orderProblem.js'));

        app.get('/projectoverview', require('./projectMgt/projectoverview.js'));
        app.get('/prototypedesign', require('./projectMgt/prototypedesign.js'));
        app.get('/demandevaluation', require('./projectMgt/demandevaluation.js'));
        app.get('/uidesign', require('./projectMgt/uidesign.js'));
        app.get('/pagedevelopment', require('./projectMgt/pagedevelopment.js'));
        app.get('/serverdevelopment', require('./projectMgt/serverdevelopment.js'));
        app.get('/interfacecouplet', require('./projectMgt/interfacecouplet.js'));
        app.get('/acceptancetesting', require('./projectMgt/acceptancetesting.js'));

    };
});