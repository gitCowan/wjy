define(function (require, exports, module) {
    var a = require("./bowser.min.js");

    exports.init = function(){
        if (bowser.msie && bowser.version <= 9) {
        	require.async('./es5-shim.min.js');
            require.async('./json2.js');
            require.async('./respond.js');
            require.async('./formdata.js');
        }
    };
});