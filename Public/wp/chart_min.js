WEB_SOCKET_SWF_LOCATION = "/public/so/WebSocketMain.swf";
var swfobject = function() {
    function e() {
        if (!X) {
            try {
                var p = q.getElementsByTagName("body")[0].appendChild(q.createElement("span"));
                p.parentNode.removeChild(p)
            } catch(C) {
                return
            }
            X = !0;
            for (var p = A.length,
            g = 0; g < p; g++) A[g]()
        }
    }
    function d(p) {
        X ? p() : A[A.length] = p
    }
    function h(p) {
        if ("undefined" != typeof H.addEventListener) H.addEventListener("load", p, !1);
        else if ("undefined" != typeof q.addEventListener) q.addEventListener("load", p, !1);
        else if ("undefined" != typeof H.attachEvent) I(H, "onload", p);
        else if ("function" == typeof H.onload) {
            var g = H.onload;
            H.onload = function() {
                g();
                p()
            }
        } else H.onload = p
    }
    function b() {
        var p = q.getElementsByTagName("body")[0],
        g = q.createElement("object");
        g.setAttribute("type", "application/x-shockwave-flash");
        var b = p.appendChild(g);
        if (b) {
            var d = 0; (function() {
                if ("undefined" != typeof b.GetVariable) {
                    var e = b.GetVariable("$version");
                    e && (e = e.split(" ")[1].split(","), n.pv = [parseInt(e[0], 10), parseInt(e[1], 10), parseInt(e[2], 10)])
                } else if (10 > d) {
                    d++;
                    setTimeout(arguments.callee, 10);
                    return
                }
                p.removeChild(g);
                b = null;
                k()
            })()
        } else k()
    }
    function k() {
        var p = B.length;
        if (0 < p) for (var g = 0; g < p; g++) {
            var b = B[g].id,
            d = B[g].callbackFn,
            e = {
                success: !1,
                id: b
            };
            if (0 < n.pv[0]) {
                var k = E(b);
                if (k) if (!x(B[g].swfVersion) || n.wk && 312 > n.wk) if (B[g].expressInstall && L()) {
                    e = {};
                    e.data = B[g].expressInstall;
                    e.width = k.getAttribute("width") || "0";
                    e.height = k.getAttribute("height") || "0";
                    k.getAttribute("class") && (e.styleclass = k.getAttribute("class"));
                    k.getAttribute("align") && (e.align = k.getAttribute("align"));
                    for (var h = {},
                    k = k.getElementsByTagName("param"), m = k.length, q = 0; q < m; q++)"movie" != k[q].getAttribute("name").toLowerCase() && (h[k[q].getAttribute("name")] = k[q].getAttribute("value"));
                    t(e, h, b, d)
                } else J(k),
                d && d(e);
                else S(b, !0),
                d && (e.success = !0, e.ref = F(b), d(e))
            } else S(b, !0),
            d && ((b = F(b)) && "undefined" != typeof b.SetVariable && (e.success = !0, e.ref = b), d(e))
        }
    }
    function F(p) {
        var b = null; (p = E(p)) && "OBJECT" == p.nodeName && ("undefined" != typeof p.SetVariable ? b = p: (p = p.getElementsByTagName("object")[0]) && (b = p));
        return b
    }
    function L() {
        return ! pa && x("6.0.65") && (n.win || n.mac) && !(n.wk && 312 > n.wk)
    }
    function t(p, b, d, e) {
        pa = !0;
        fa = e || null;
        r = {
            success: !1,
            id: d
        };
        var g = E(d);
        if (g) {
            "OBJECT" == g.nodeName ? (T = G(g), ga = null) : (T = g, ga = d);
            p.id = "SWFObjectExprInst";
            if ("undefined" == typeof p.width || !/%$/.test(p.width) && 310 > parseInt(p.width, 10)) p.width = "310";
            if ("undefined" == typeof p.height || !/%$/.test(p.height) && 137 > parseInt(p.height, 10)) p.height = "137";
            q.title = q.title.slice(0, 47) + " - Flash Player Installation";
            e = n.ie && n.win ? "ActiveX": "PlugIn";
            e = "MMredirectURL\x3d" + H.location.toString().replace(/&/g, "%26") + "\x26MMplayerType\x3d" + e + "\x26MMdoctitle\x3d" + q.title;
            b.flashvars = "undefined" != typeof b.flashvars ? b.flashvars + ("\x26" + e) : e;
            n.ie && n.win && 4 != g.readyState && (e = q.createElement("div"), d += "SWFObjectNew", e.setAttribute("id", d), g.parentNode.insertBefore(e, g), g.style.display = "none",
            function() {
                4 == g.readyState ? g.parentNode.removeChild(g) : setTimeout(arguments.callee, 10)
            } ());
            Q(p, b, d)
        }
    }
    function J(b) {
        if (n.ie && n.win && 4 != b.readyState) {
            var g = q.createElement("div");
            b.parentNode.insertBefore(g, b);
            g.parentNode.replaceChild(G(b), g);
            b.style.display = "none"; (function() {
                4 == b.readyState ? b.parentNode.removeChild(b) : setTimeout(arguments.callee, 10)
            })()
        } else b.parentNode.replaceChild(G(b), b)
    }
    function G(b) {
        var g = q.createElement("div");
        if (n.win && n.ie) g.innerHTML = b.innerHTML;
        else if (b = b.getElementsByTagName("object")[0]) if (b = b.childNodes) for (var d = b.length,
        p = 0; p < d; p++) 1 == b[p].nodeType && "PARAM" == b[p].nodeName || 8 == b[p].nodeType || g.appendChild(b[p].cloneNode(!0));
        return g
    }
    function Q(b, g, d) {
        var e, p = E(d);
        if (n.wk && 312 > n.wk) return e;
        if (p) if ("undefined" == typeof b.id && (b.id = d), n.ie && n.win) {
            var k = "",
            h;
            for (h in b) b[h] != Object.prototype[h] && ("data" == h.toLowerCase() ? g.movie = b[h] : "styleclass" == h.toLowerCase() ? k += ' class\x3d"' + b[h] + '"': "classid" != h.toLowerCase() && (k += " " + h + '\x3d"' + b[h] + '"'));
            h = "";
            for (var C in g) g[C] != Object.prototype[C] && (h += '\x3cparam name\x3d"' + C + '" value\x3d"' + g[C] + '" /\x3e');
            p.outerHTML = '\x3cobject classid\x3d"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"' + k + "\x3e" + h + "\x3c/object\x3e";
            ha[ha.length] = b.id;
            e = E(b.id)
        } else {
            C = q.createElement("object");
            C.setAttribute("type", "application/x-shockwave-flash");
            for (var m in b) b[m] != Object.prototype[m] && ("styleclass" == m.toLowerCase() ? C.setAttribute("class", b[m]) : "classid" != m.toLowerCase() && C.setAttribute(m, b[m]));
            for (k in g) g[k] != Object.prototype[k] && "movie" != k.toLowerCase() && (b = C, h = k, m = g[k], d = q.createElement("param"), d.setAttribute("name", h), d.setAttribute("value", m), b.appendChild(d));
            p.parentNode.replaceChild(C, p);
            e = C
        }
        return e
    }
    function aa(b) {
        var d = E(b);
        d && "OBJECT" == d.nodeName && (n.ie && n.win ? (d.style.display = "none",
        function() {
            if (4 == d.readyState) {
                var g = E(b);
                if (g) {
                    for (var e in g)"function" == typeof g[e] && (g[e] = null);
                    g.parentNode.removeChild(g)
                }
            } else setTimeout(arguments.callee, 10)
        } ()) : d.parentNode.removeChild(d))
    }
    function E(b) {
        var d = null;
        try {
            d = q.getElementById(b)
        } catch(C) {}
        return d
    }
    function I(b, d, e) {
        b.attachEvent(d, e);
        M[M.length] = [b, d, e]
    }
    function x(b) {
        var d = n.pv;
        b = b.split(".");
        b[0] = parseInt(b[0], 10);
        b[1] = parseInt(b[1], 10) || 0;
        b[2] = parseInt(b[2], 10) || 0;
        return d[0] > b[0] || d[0] == b[0] && d[1] > b[1] || d[0] == b[0] && d[1] == b[1] && d[2] >= b[2] ? !0 : !1
    }
    function ua(b, d, e, k) {
        if (!n.ie || !n.mac) {
            var g = q.getElementsByTagName("head")[0];
            g && (e = e && "string" == typeof e ? e: "screen", k && (qa = N = null), N && qa == e || (k = q.createElement("style"), k.setAttribute("type", "text/css"), k.setAttribute("media", e), N = g.appendChild(k), n.ie && n.win && "undefined" != typeof q.styleSheets && 0 < q.styleSheets.length && (N = q.styleSheets[q.styleSheets.length - 1]), qa = e), n.ie && n.win ? N && "object" == typeof N.addRule && N.addRule(b, d) : N && "undefined" != typeof q.createTextNode && N.appendChild(q.createTextNode(b + " {" + d + "}")))
        }
    }
    function S(b, d) {
        if (m) {
            var e = d ? "visible": "hidden";
            X && E(b) ? E(b).style.visibility = e: ua("#" + b, "visibility:" + e)
        }
    }
    function va(b) {
        return null != /[\\\"<>\.;]/.exec(b) && "undefined" != typeof encodeURIComponent ? encodeURIComponent(b) : b
    }
    var H = window,
    q = document,
    R = navigator,
    U = !1,
    A = [function() {
        U ? b() : k()
    }],
    B = [],
    ha = [],
    M = [],
    T,
    ga,
    fa,
    r,
    X = !1,
    pa = !1,
    N,
    qa,
    m = !0,
    n = function() {
        var b = "undefined" != typeof q.getElementById && "undefined" != typeof q.getElementsByTagName && "undefined" != typeof q.createElement,
        d = R.userAgent.toLowerCase(),
        e = R.platform.toLowerCase(),
        k = e ? /win/.test(e) : /win/.test(d),
        e = e ? /mac/.test(e) : /mac/.test(d),
        d = /webkit/.test(d) ? parseFloat(d.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, "$1")) : !1,
        h = !+"\v1",
        m = [0, 0, 0],
        n = null;
        if ("undefined" != typeof R.plugins && "object" == typeof R.plugins["Shockwave Flash"]) ! (n = R.plugins["Shockwave Flash"].description) || "undefined" != typeof R.mimeTypes && R.mimeTypes["application/x-shockwave-flash"] && !R.mimeTypes["application/x-shockwave-flash"].enabledPlugin || (U = !0, h = !1, n = n.replace(/^.*\s+(\S+\s+\S+$)/, "$1"), m[0] = parseInt(n.replace(/^(.*)\..*$/, "$1"), 10), m[1] = parseInt(n.replace(/^.*\.(.*)\s.*$/, "$1"), 10), m[2] = /[a-zA-Z]/.test(n) ? parseInt(n.replace(/^.*[a-zA-Z]+(.*)$/, "$1"), 10) : 0);
        else if ("undefined" != typeof H.ActiveXObject) try {
            if (n = (new ActiveXObject("ShockwaveFlash.ShockwaveFlash")).GetVariable("$version")) h = !0,
            n = n.split(" ")[1].split(","),
            m = [parseInt(n[0], 10), parseInt(n[1], 10), parseInt(n[2], 10)]
        } catch(La) {}
        return {
            w3: b,
            pv: m,
            wk: d,
            ie: h,
            win: k,
            mac: e
        }
    } (); (function() {
        n.w3 && (("undefined" != typeof q.readyState && "complete" == q.readyState || "undefined" == typeof q.readyState && (q.getElementsByTagName("body")[0] || q.body)) && e(), X || ("undefined" != typeof q.addEventListener && q.addEventListener("DOMContentLoaded", e, !1), n.ie && n.win && (q.attachEvent("onreadystatechange",
        function() {
            "complete" == q.readyState && (q.detachEvent("onreadystatechange", arguments.callee), e())
        }), H == top &&
        function() {
            if (!X) {
                try {
                    q.documentElement.doScroll("left")
                } catch(p) {
                    setTimeout(arguments.callee, 0);
                    return
                }
                e()
            }
        } ()), n.wk &&
        function() {
            X || (/loaded|complete/.test(q.readyState) ? e() : setTimeout(arguments.callee, 0))
        } (), h(e)))
    })(); (function() {
        n.ie && n.win && window.attachEvent("onunload",
        function() {
            for (var b = M.length,
            d = 0; d < b; d++) M[d][0].detachEvent(M[d][1], M[d][2]);
            b = ha.length;
            for (d = 0; d < b; d++) aa(ha[d]);
            for (var e in n) n[e] = null;
            n = null;
            for (var k in swfobject) swfobject[k] = null;
            swfobject = null
        })
    })();
    return {
        registerObject: function(b, d, e, k) {
            if (n.w3 && b && d) {
                var g = {};
                g.id = b;
                g.swfVersion = d;
                g.expressInstall = e;
                g.callbackFn = k;
                B[B.length] = g;
                S(b, !1)
            } else k && k({
                success: !1,
                id: b
            })
        },
        getObjectById: function(b) {
            if (n.w3) return F(b)
        },
        embedSWF: function(b, e, k, h, m, q, F, r, A, B) {
            var g = {
                success: !1,
                id: e
            };
            n.w3 && !(n.wk && 312 > n.wk) && b && e && k && h && m ? (S(e, !1), d(function() {
                k += "";
                h += "";
                var d = {};
                if (A && "object" === typeof A) for (var p in A) d[p] = A[p];
                d.data = b;
                d.width = k;
                d.height = h;
                p = {};
                if (r && "object" === typeof r) for (var n in r) p[n] = r[n];
                if (F && "object" === typeof F) for (var C in F) p.flashvars = "undefined" != typeof p.flashvars ? p.flashvars + ("\x26" + C + "\x3d" + F[C]) : C + "\x3d" + F[C];
                if (x(m)) n = Q(d, p, e),
                d.id == e && S(e, !0),
                g.success = !0,
                g.ref = n;
                else {
                    if (q && L()) {
                        d.data = q;
                        t(d, p, e, B);
                        return
                    }
                    S(e, !0)
                }
                B && B(g)
            })) : B && B(g)
        },
        switchOffAutoHideShow: function() {
            m = !1
        },
        ua: n,
        getFlashPlayerVersion: function() {
            return {
                major: n.pv[0],
                minor: n.pv[1],
                release: n.pv[2]
            }
        },
        hasFlashPlayerVersion: x,
        createSWF: function(b, d, e) {
            if (n.w3) return Q(b, d, e)
        },
        showExpressInstall: function(b, d, e, k) {
            n.w3 && L() && t(b, d, e, k)
        },
        removeSWF: function(b) {
            n.w3 && aa(b)
        },
        createCSS: function(b, d, e, k) {
            n.w3 && ua(b, d, e, k)
        },
        addDomLoadEvent: d,
        addLoadEvent: h,
        getQueryParamValue: function(b) {
            var d = q.location.search || q.location.hash;
            if (d) { / \ ? /.test(d)&&(d=d.split("?")[1]);if(null==b)return va(d);for(var d=d.split("\x26"),e=0;e<d.length;e++)if(d[e].substring(0,d[e].indexOf("\x3d"))==b)return va(d[e].substring(d[e].indexOf("\x3d")+1))}return""},expressInstallCallback:function(){if(pa){var b=E("SWFObjectExprInst");b&&T&&(b.parentNode.replaceChild(T,b),ga&&(S(ga,!0),n.ie&&n.win&&(T.style.display="block")),fa&&fa(r));pa=!1}}}}();(function(){if(!window.WEB_SOCKET_FORCE_FLASH){if(window.WebSocket)return;if(window.MozWebSocket){window.WebSocket=MozWebSocket;return}}var e;e=window.WEB_SOCKET_LOGGER?WEB_SOCKET_LOGGER:window.console&&window.console.log&&window.console.error?window.console:{log:function(){},error:function(){}};10>swfobject.getFlashPlayerVersion().major?e.error("Flash Player \x3e\x3d 10.0.0 is required."):("file:"==location.protocol&&e.error("WARNING: web-socket-js doesn't work in file:/ //... URL unless you set Flash Security Settings properly. Open the page via Web server i.e. http://..."),window.WebSocket=function(d,e,b,k,F){var h=this;h.__id=WebSocket.__nextId++;WebSocket.__instances[h.__id]=h;h.readyState=WebSocket.CONNECTING;h.bufferedAmount=0;h.__events={};e?"string"==typeof e&&(e=[e]):e=[];h.__createTask=setTimeout(function(){WebSocket.__addTask(function(){h.__createTask=null;WebSocket.__flash.create(h.__id,d,e,b||null,k||0,F||null)})},0)},WebSocket.prototype.send=function(d){if(this.readyState==WebSocket.CONNECTING)throw"INVALID_STATE_ERR: Web Socket connection has not been established";d=WebSocket.__flash.send(this.__id,encodeURIComponent(d));if(0>d)return!0;this.bufferedAmount+=d;return!1},WebSocket.prototype.close=function(){this.__createTask?(clearTimeout(this.__createTask),this.__createTask=null,this.readyState=WebSocket.CLOSED):this.readyState!=WebSocket.CLOSED&&this.readyState!=WebSocket.CLOSING&&(this.readyState=WebSocket.CLOSING,WebSocket.__flash.close(this.__id))},WebSocket.prototype.addEventListener=function(d,e,b){d in this.__events||(this.__events[d]=[]);this.__events[d].push(e)},WebSocket.prototype.removeEventListener=function(d,e,b){if(d in this.__events)for(d=this.__events[d],b=d.length-1;0<=b;--b)if(d[b]===e){d.splice(b,1);break}},WebSocket.prototype.dispatchEvent=function(d){for(var e=this.__events[d.type]||[],b=0;b<e.length;++b)e[b](d);(e=this["on"+d.type])&&e.apply(this,[d])},WebSocket.prototype.__handleEvent=function(d){"readyState"in d&&(this.readyState=d.readyState);"protocol"in d&&(this.protocol=d.protocol);var e;if("open"==d.type||"error"==d.type)e=this.__createSimpleEvent(d.type);else if("close"==d.type)e=this.__createSimpleEvent("close"),e.wasClean=d.wasClean?!0:!1,e.code=d.code,e.reason=d.reason;else if("message"==d.type)d=decodeURIComponent(d.message),e=this.__createMessageEvent("message",d);else throw"unknown event type: "+d.type;this.dispatchEvent(e)},WebSocket.prototype.__createSimpleEvent=function(d){if(document.createEvent&&window.Event){var e=document.createEvent("Event");e.initEvent(d,!1,!1);return e}return{type:d,bubbles:!1,cancelable:!1}},WebSocket.prototype.__createMessageEvent=function(d,e){if(window.MessageEvent&&"function"==typeof MessageEvent&&!window.opera)return new MessageEvent("message",{view:window,bubbles:!1,cancelable:!1,data:e});if(document.createEvent&&window.MessageEvent&&!window.opera){var b=document.createEvent("MessageEvent");b.initMessageEvent("message",!1,!1,e,null,null,window,null);return b}return{type:d,data:e,bubbles:!1,cancelable:!1}},WebSocket.CONNECTING=0,WebSocket.OPEN=1,WebSocket.CLOSING=2,WebSocket.CLOSED=3,WebSocket.__isFlashImplementation=!0,WebSocket.__initialized=!1,WebSocket.__flash=null,WebSocket.__instances={},WebSocket.__tasks=[],WebSocket.__nextId=0,WebSocket.loadFlashPolicyFile=function(d){WebSocket.__addTask(function(){WebSocket.__flash.loadManualPolicyFile(d)})},WebSocket.__initialize=function(){if(!WebSocket.__initialized)if(WebSocket.__initialized=!0,WebSocket.__swfLocation&&(window.WEB_SOCKET_SWF_LOCATION=WebSocket.__swfLocation),window.WEB_SOCKET_SWF_LOCATION){if(!window.WEB_SOCKET_SUPPRESS_CROSS_DOMAIN_SWF_ERROR&&!WEB_SOCKET_SWF_LOCATION.match(/(^|\/)WebSocketMainInsecure\.swf(\?.*)?$/)&&WEB_SOCKET_SWF_LOCATION.match(/^\w+:\/\/([^\/]+)/)){var d=RegExp.$1;location.host!=d&&e.error("[WebSocket] You must host HTML and WebSocketMain.swf in the same host ('"+location.host+"' !\x3d '"+d+"'). See also 'How to host HTML file and SWF file in different domains' section in README.md. If you use WebSocketMainInsecure.swf, you can suppress this message by WEB_SOCKET_SUPPRESS_CROSS_DOMAIN_SWF_ERROR \x3d true;")}d=document.createElement("div");d.id="webSocketContainer";d.style.position="absolute";WebSocket.__isFlashLite()?(d.style.left="0px",d.style.top="0px"):(d.style.left="-100px",d.style.top="-100px");var h=document.createElement("div");h.id="webSocketFlash";d.appendChild(h);document.body.appendChild(d);swfobject.embedSWF(WEB_SOCKET_SWF_LOCATION,"webSocketFlash","1","1","10.0.0",null,null,{hasPriority:!0,swliveconnect:!0,allowScriptAccess:"always"},null,function(b){b.success||e.error("[WebSocket] swfobject.embedSWF failed")})}else e.error("[WebSocket] set WEB_SOCKET_SWF_LOCATION to location of WebSocketMain.swf")},WebSocket.__onFlashInitialized=function(){setTimeout(function(){WebSocket.__flash=document.getElementById("webSocketFlash");WebSocket.__flash.setCallerUrl(location.href);WebSocket.__flash.setDebug(!!window.WEB_SOCKET_DEBUG);for(var d=0;d<WebSocket.__tasks.length;++d)WebSocket.__tasks[d]();WebSocket.__tasks=[]},0)},WebSocket.__onFlashEvent=function(){setTimeout(function(){try{for(var d=WebSocket.__flash.receiveEvents(),h=0;h<d.length;++h)WebSocket.__instances[d[h].webSocketId].__handleEvent(d[h])}catch(b){e.error(b)}},0);return!0},WebSocket.__log=function(d){e.log(decodeURIComponent(d))},WebSocket.__error=function(d){e.error(decodeURIComponent(d))},WebSocket.__addTask=function(d){WebSocket.__flash?d():WebSocket.__tasks.push(d)},WebSocket.__isFlashLite=function(){if(!window.navigator||!window.navigator.mimeTypes)return!1;var d=window.navigator.mimeTypes["application/x-shockwave-flash"];return d&&d.enabledPlugin&&d.enabledPlugin.filename?d.enabledPlugin.filename.match(/flashlite/i)?!0:!1:!1},window.WEB_SOCKET_DISABLE_AUTO_INITIALIZATION||swfobject.addDomLoadEvent(function(){WebSocket.__initialize()}))})();var mySocket=function(){var e=function(d){this.server=d;this.getMsg=this.ws=null;this.init()};e.prototype.init=function(){if(this.ws)return!1;var d=this;this.ws=new WebSocket(this.server);this.ws.onopen=function(){d.login();d.ws.onmessage=function(e){d.onmessage(e.data)};d.ws.onclose=function(){d.onclose()};d.ws.onerror=function(){d.onerror()};setInterval(function(){d.ws.send("")},18E4)};this.ws.onerror=function(d){};window.onbeforeunload=function(){d.ws.close()}};e.prototype.onmessage=function(d){if(!this.getMsg)return!1;this.getMsg(d)};e.prototype.onclose=function(){console.info("\u5173\u95ed\u4e86")};e.prototype.onerror=function(){};e.prototype.login=function(){var d={cmd:"login",codes:[code]},d=JSON.stringify(d);try{this.ws.send(d)}catch(h){}};return e}();function getQueryString(e){e=new RegExp("(^|\x26)"+e+"\x3d([^\x26]*)(\x26|$)","i");e=window.location.search.substr(1).match(e);return null!=e?unescape(e[2]):null}(function(e,d){"object"===typeof exports&&"undefined"!==typeof module?module.exports=d():"function"===typeof define&&define.amd?define(d):e.moment=d()})(this,function(){function e(){return fb.apply(null,arguments)}function d(a){return"[object Array]"===Object.prototype.toString.call(a)}function h(a){return a instanceof Date||"[object Date]"===Object.prototype.toString.call(a)}function b(a,c){var f=[],b;for(b=0;b<a.length;++b)f.push(c(a[b],b));return f}function k(a,c){return Object.prototype.hasOwnProperty.call(a,c)}function F(a,c){for(var f in c)k(c,f)&&(a[f]=c[f]);k(c,"toString")&&(a.toString=c.toString);k(c,"valueOf")&&(a.valueOf=c.valueOf);return a}function L(a,c,f,b){return gb(a,c,f,b,!0).utc()}function t(a){null==a._pf&&(a._pf={empty:!1,unusedTokens:[],unusedInput:[],overflow:-2,charsLeftOver:0,nullInput:!1,invalidMonth:null,invalidFormat:!1,userInvalidated:!1,iso:!1});return a._pf}function J(a){if(null==a._isValid){var c=t(a);a._isValid=!isNaN(a._d.getTime())&&0>c.overflow&&!c.empty&&!c.invalidMonth&&!c.invalidWeekday&&!c.nullInput&&!c.invalidFormat&&!c.userInvalidated;a._strict&&(a._isValid=a._isValid&&0===c.charsLeftOver&&0===c.unusedTokens.length&&void 0===c.bigHour)}return a._isValid}function G(a){var c=L(NaN);null!=a?F(t(c),a):t(c).userInvalidated=!0;return c}function Q(a,c){var f,b,d;"undefined"!==typeof c._isAMomentObject&&(a._isAMomentObject=c._isAMomentObject);"undefined"!==typeof c._i&&(a._i=c._i);"undefined"!==typeof c._f&&(a._f=c._f);"undefined"!==typeof c._l&&(a._l=c._l);"undefined"!==typeof c._strict&&(a._strict=c._strict);"undefined"!==typeof c._tzm&&(a._tzm=c._tzm);"undefined"!==typeof c._isUTC&&(a._isUTC=c._isUTC);"undefined"!==typeof c._offset&&(a._offset=c._offset);"undefined"!==typeof c._pf&&(a._pf=t(c));"undefined"!==typeof c._locale&&(a._locale=c._locale);if(0<Oa.length)for(f in Oa)b=Oa[f],d=c[b],"undefined"!==typeof d&&(a[b]=d);return a}function aa(a){Q(this,a);this._d=new Date(null!=a._d?a._d.getTime():NaN);!1===Pa&&(Pa=!0,e.updateOffset(this),Pa=!1)}function E(a){return a instanceof aa||null!=a&&null!=a._isAMomentObject}function I(a){return 0>a?Math.ceil(a):Math.floor(a)}function x(a){a=+a;var c=0;0!==a&&isFinite(a)&&(c=I(a));return c}function ua(a,c,f){var b=Math.min(a.length,c.length),d=Math.abs(a.length-c.length),e=0,k;for(k=0;k<b;k++)(f&&a[k]!==c[k]||!f&&x(a[k])!==x(c[k]))&&e++;return e+d}function S(){}function va(a){return a?a.toLowerCase().replace("_","-"):a}function H(a){var c=null;if(!ja[a]&&"undefined"!==typeof module&&module&&module.exports)try{c=za._abbr,require("./locale/"+a),q(c)}catch(f){}return ja[a]}function q(a,c){var f;a&&(f="undefined"===typeof c?U(a):R(a,c))&&(za=f);return za._abbr}function R(a,c){if(null!==c)return c.abbr=a,ja[a]=ja[a]||new S,ja[a].set(c),q(a),ja[a];delete ja[a];return null}function U(a){var c;a&&a._locale&&a._locale._abbr&&(a=a._locale._abbr);if(!a)return za;if(!d(a)){if(c=H(a))return c;a=[a]}a:{c=0;for(var f,b,e,k;c<a.length;){k=va(a[c]).split("-");f=k.length;for(b=(b=va(a[c+1]))?b.split("-"):null;0<f;){if(e=H(k.slice(0,f).join("-"))){a=e;break a}if(b&&b.length>=f&&ua(k,b,!0)>=f-1)break;f--}c++}a=null}return a}function A(a,c){var f=a.toLowerCase();wa[f]=wa[f+"s"]=wa[c]=a}function B(a){return"string"===typeof a?wa[a]||wa[a.toLowerCase()]:void 0}function ha(a){var c={},f,b;for(b in a)k(a,b)&&(f=B(b))&&(c[f]=a[b]);return c}function M(a,c){return function(f){return null!=f?(this._d["set"+(this._isUTC?"UTC":"")+a](f),e.updateOffset(this,c),this):T(this,a)}}function T(a,c){return a._d["get"+(a._isUTC?"UTC":"")+c]()}function ga(a,c){var f;if("object"===typeof a)for(f in a)this.set(f,a[f]);else if(a=B(a),"function"===typeof this[a])return this[a](c);return this}function fa(a,c,f){var b=""+Math.abs(a);return(0<=a?f?"+":"":"-")+Math.pow(10,Math.max(0,c-b.length)).toString().substr(1)+b}function r(a,c,f,b){var d=b;"string"===typeof b&&(d=function(){return this[b]()});a&&(ra[a]=d);c&&(ra[c[0]]=function(){return fa(d.apply(this,arguments),c[1],c[2])});f&&(ra[f]=function(){return this.localeData().ordinal(d.apply(this,arguments),a)})}function X(a){return a.match(/\[[\s\S]/)?a.replace(/^\[|\]$/g,""):a.replace(/\\/g,"")}function pa(a){var c=a.match(hb),f,b;f=0;for(b=c.length;f<b;f++)c[f]=ra[c[f]]?ra[c[f]]:X(c[f]);return function(d){var e="";for(f=0;f<b;f++)e+=c[f]instanceof Function?c[f].call(d,a):c[f];return e}}function N(a,c){if(!a.isValid())return a.localeData().invalidDate();c=qa(c,a.localeData());Qa[c]=Qa[c]||pa(c);return Qa[c](a)}function qa(a,c){function f(a){return c.longDateFormat(a)||a}var b=5;for(Aa.lastIndex=0;0<=b&&Aa.test(a);)a=a.replace(Aa,f),Aa.lastIndex=0,--b;return a}function m(a,c,f){Ra[a]="function"===typeof c&&"[object Function]"===Object.prototype.toString.call(c)?c:function(a){return a&&f?f:c}}function n(a,c){return k(Ra,a)?Ra[a](c._strict,c._locale):new RegExp(p(a))}function p(a){return a.replace("\\","").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g,function(a,f,b,d,e){return f||b||d||e}).replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$\x26")}function g(a,c){var f,b=c;"string"===typeof a&&(a=[a]);"number"===typeof c&&(b=function(a,f){f[c]=x(a)});for(f=0;f<a.length;f++)Sa[a[f]]=b}function C(a,c){g(a,function(a,b,d,e){d._w=d._w||{};c(a,d._w,d,e)})}function Ja(a,c){return(new Date(Date.UTC(a,c+1,0))).getUTCDate()}function cb(a,c){var f;if("string"===typeof c&&(c=a.localeData().monthsParse(c),"number"!==typeof c))return a;f=Math.min(a.date(),Ja(a.year(),c));a._d["set"+(a._isUTC?"UTC":"")+"Month"](c,f);return a}function db(a){return null!=a?(cb(this,a),e.updateOffset(this,!0),this):T(this,"Month")}function Ka(a){var c;(c=a._a)&&-2===t(a).overflow&&(c=0>c[Y]||11<c[Y]?Y:1>c[V]||c[V]>Ja(c[W],c[Y])?V:0>c[K]||24<c[K]||24===c[K]&&(0!==c[ka]||0!==c[la]||0!==c[ma])?K:0>c[ka]||59<c[ka]?ka:0>c[la]||59<c[la]?la:0>c[ma]||999<c[ma]?ma:-1,t(a)._overflowDayOfYear&&(c<W||c>V)&&(c=V),t(a).overflow=c);return a}function La(a){!1===e.suppressDeprecationWarnings&&"undefined"!==typeof console&&console.warn&&console.warn("Deprecation warning: "+a)}function P(a,c){var f=!0;return F(function(){f&&(La(a+"\n"+Error().stack),f=!1);return c.apply(this,arguments)},c)}function eb(a){var c,f,b=a._i,d=Hb.exec(b);if(d){t(a).iso=!0;c=0;for(f=Ta.length;c<f;c++)if(Ta[c][1].exec(b)){a._f=Ta[c][0];break}c=0;for(f=Ua.length;c<f;c++)if(Ua[c][1].exec(b)){a._f+=(d[6]||" ")+Ua[c][0];break}b.match(Ba)&&(a._f+="Z");Va(a)}else a._isValid=!1}function Fb(a){var c=Ib.exec(a._i);null!==c?a._d=new Date(+c[1]):(eb(a),!1===a._isValid&&(delete a._isValid,e.createFromInputFallback(a)))}function Gb(a,c,f,b,d,e,k){c=new Date(a,c,f,b,d,e,k);1970>a&&c.setFullYear(a);return c}function Ma(a){var c=new Date(Date.UTC.apply(null,arguments));1970>a&&c.setUTCFullYear(a);return c}function Na(a){return 0===a%4&&0!==a%100||0===a%400}function ia(a,c,f){c=f-c;f-=a.day();f>c&&(f-=7);f<c-7&&(f+=7);a=z(a).add(f,"d");return{week:Math.ceil(a.dayOfYear()/7),year:a.year()}}function sa(a,c,f){return null!=a?a:null!=c?c:f}function Wa(a){var c,f,b=[],d;if(!a._d){d=new Date;d=a._useUTC?[d.getUTCFullYear(),d.getUTCMonth(),d.getUTCDate()]:[d.getFullYear(),d.getMonth(),d.getDate()];if(a._w&&null==a._a[V]&&null==a._a[Y]){var e,k,g;e=a._w;null!=e.GG||null!=e.W||null!=e.E?(g=1,c=4,f=sa(e.GG,a._a[W],ia(z(),1,4).year),k=sa(e.W,1),e=sa(e.E,1)):(g=a._locale._week.dow,c=a._locale._week.doy,f=sa(e.gg,a._a[W],ia(z(),g,c).year),k=sa(e.w,1),null!=e.d?(e=e.d,e<g&&++k):e=null!=e.e?e.e+g:g);c=6+g-c;var l=Ma(f,0,1+c).getUTCDay();l<g&&(l+=7);g=1+c+7*(k-1)-l+(null!=e?1*e:g);c=0<g?f:f-1;f=0<g?g:(Na(f-1)?366:365)+g;a._a[W]=c;a._dayOfYear=f}a._dayOfYear&&(f=sa(a._a[W],d[W]),a._dayOfYear>(Na(f)?366:365)&&(t(a)._overflowDayOfYear=!0),f=Ma(f,0,a._dayOfYear),a._a[Y]=f.getUTCMonth(),a._a[V]=f.getUTCDate());for(f=0;3>f&&null==a._a[f];++f)a._a[f]=b[f]=d[f];for(;7>f;f++)a._a[f]=b[f]=null==a._a[f]?2===f?1:0:a._a[f];24===a._a[K]&&0===a._a[ka]&&0===a._a[la]&&0===a._a[ma]&&(a._nextDay=!0,a._a[K]=0);a._d=(a._useUTC?Ma:Gb).apply(null,b);null!=a._tzm&&a._d.setUTCMinutes(a._d.getUTCMinutes()-a._tzm);a._nextDay&&(a._a[K]=24)}}function Va(a){if(a._f===e.ISO_8601)eb(a);else{a._a=[];t(a).empty=!0;var c=""+a._i,f,b,d,g,l,m=c.length,h=0;d=qa(a._f,a._locale).match(hb)||[];for(f=0;f<d.length;f++){g=d[f];if(b=(c.match(n(g,a))||[])[0])l=c.substr(0,c.indexOf(b)),0<l.length&&t(a).unusedInput.push(l),c=c.slice(c.indexOf(b)+b.length),h+=b.length;if(ra[g]){if(b?t(a).empty=!1:t(a).unusedTokens.push(g),l=a,null!=b&&k(Sa,g))Sa[g](b,l._a,l,g)}else a._strict&&!b&&t(a).unusedTokens.push(g)}t(a).charsLeftOver=m-h;0<c.length&&t(a).unusedInput.push(c);!0===t(a).bigHour&&12>=a._a[K]&&0<a._a[K]&&(t(a).bigHour=void 0);c=a._a;f=K;m=a._locale;d=a._a[K];h=a._meridiem;null!=h&&(null!=m.meridiemHour?d=m.meridiemHour(d,h):null!=m.isPM&&((m=m.isPM(h))&&12>d&&(d+=12),m||12!==d||(d=0)));c[f]=d;Wa(a);Ka(a)}}function Jb(a){if(!a._d){var c=ha(a._i);a._a=[c.year,c.month,c.day||c.date,c.hour,c.minute,c.second,c.millisecond];Wa(a)}}function ib(a){var c=a._i,f=a._f;a._locale=a._locale||U(a._l);if(null===c||void 0===f&&""===c)return G({nullInput:!0});"string"===typeof c&&(a._i=c=a._locale.preparse(c));if(E(c))return new aa(Ka(c));if(d(f)){var b,e,k;if(0===a._f.length)t(a).invalidFormat=!0,a._d=new Date(NaN);else{for(c=0;c<a._f.length;c++)if(f=0,b=Q({},a),null!=a._useUTC&&(b._useUTC=a._useUTC),b._f=a._f[c],Va(b),J(b)&&(f+=t(b).charsLeftOver,f+=10*t(b).unusedTokens.length,t(b).score=f,null==k||f<k))k=f,e=b;F(a,e||b)}}else f?Va(a):h(c)?a._d=c:Kb(a);return a}function Kb(a){var c=a._i;void 0===c?a._d=new Date:h(c)?a._d=new Date(+c):"string"===typeof c?Fb(a):d(c)?(a._a=b(c.slice(0),function(a){return parseInt(a,10)}),Wa(a)):"object"===typeof c?Jb(a):"number"===typeof c?a._d=new Date(c):e.createFromInputFallback(a)}function gb(a,c,f,b,d){var e={};"boolean"===typeof f&&(b=f,f=void 0);e._isAMomentObject=!0;e._useUTC=e._isUTC=d;e._l=f;e._i=a;e._f=c;e._strict=b;a=new aa(Ka(ib(e)));a._nextDay&&(a.add(1,"d"),a._nextDay=void 0);return a}function z(a,c,f,b){return gb(a,c,f,b,!1)}function jb(a,c){var f,b;1===c.length&&d(c[0])&&(c=c[0]);if(!c.length)return z();f=c[0];for(b=1;b<c.length;++b)if(!c[b].isValid()||c[b][a](f))f=c[b];return f}function Ca(a){a=ha(a);var c=a.year||0,f=a.quarter||0,b=a.month||0,d=a.week||0,e=a.day||0;this._milliseconds=+(a.millisecond||0)+1E3*(a.second||0)+6E4*(a.minute||0)+36E5*(a.hour||0);this._days=+e+7*d;this._months=+b+3*f+12*c;this._data={};this._locale=U();this._bubble()}function Xa(a){return a instanceof Ca}function kb(a,c){r(a,0,0,function(){var a=this.utcOffset(),b="+";0>a&&(a=-a,b="-");return b+fa(~~(a/60),2)+c+fa(~~a%60,2)})}function Ya(a){a=(a||"").match(Ba)||[];a=((a[a.length-1]||[])+"").match(Lb)||["-",0,0];var c=+(60*a[1])+x(a[2]);return"+"===a[0]?c:-c}function Za(a,c){var f,b;return c._isUTC?(f=c.clone(),b=(E(a)||h(a)?+a:+z(a))-+f,f._d.setTime(+f._d+b),e.updateOffset(f,!1),f):z(a).local()}function lb(){return this._isUTC&&0===this._offset}function ba(a,c){var f=a,b;Xa(a)?f={ms:a._milliseconds,d:a._days,M:a._months}:"number"===typeof a?(f={},c?f[c]=a:f.milliseconds=a):(b=Mb.exec(a))?(f="-"===b[1]?-1:1,f={y:0,d:x(b[V])*f,h:x(b[K])*f,m:x(b[ka])*f,s:x(b[la])*f,ms:x(b[ma])*f}):(b=Nb.exec(a))?(f="-"===b[1]?-1:1,f={y:na(b[2],f),M:na(b[3],f),d:na(b[4],f),h:na(b[5],f),m:na(b[6],f),s:na(b[7],f),w:na(b[8],f)}):null==f?f={}:"object"===typeof f&&("from"in f||"to"in f)&&(b=z(f.from),f=z(f.to),f=Za(f,b),b.isBefore(f)?f=mb(b,f):(f=mb(f,b),f.milliseconds=-f.milliseconds,f.months=-f.months),b=f,f={},f.ms=b.milliseconds,f.M=b.months);f=new Ca(f);Xa(a)&&k(a,"_locale")&&(f._locale=a._locale);return f}function na(a,c){var b=a&&parseFloat(a.replace(",","."));return(isNaN(b)?0:b)*c}function mb(a,c){var b={milliseconds:0,months:0};b.months=c.month()-a.month()+12*(c.year()-a.year());a.clone().add(b.months,"M").isAfter(c)&&--b.months;b.milliseconds=+c-+a.clone().add(b.months,"M");return b}function nb(a,c){return function(b,d){var f;null===d||isNaN(+d)||(ob[c]||(La("moment()."+c+"(period, number) is deprecated. Please use moment()."+c+"(number, period)."),ob[c]=!0),f=b,b=d,d=f);f=ba("string"===typeof b?+b:b,d);pb(this,f,a);return this}}function pb(a,c,b,d){var f=c._milliseconds,k=c._days;c=c._months;d=null==d?!0:d;f&&a._d.setTime(+a._d+f*b);k&&(f=T(a,"Date")+k*b,a._d["set"+(a._isUTC?"UTC":"")+"Date"](f));c&&cb(a,T(a,"Month")+c*b);d&&e.updateOffset(a,k||c)}function qb(){var a=this.clone().utc();return 0<a.year()&&9999>=a.year()?"function"===typeof Date.prototype.toISOString?this.toDate().toISOString():N(a,"YYYY-MM-DD[T]HH:mm:ss.SSS[Z]"):N(a,"YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]")}function rb(a){if(void 0===a)return this._locale._abbr;a=U(a);null!=a&&(this._locale=a);return this}function sb(){return this._locale}function Da(a,c){r(0,[a,a.length],0,c)}function tb(a,c,b){return ia(z([a,11,31+c-b]),c,b).week}function ub(a,c){r(a,0,0,function(){return this.localeData().meridiem(this.hours(),this.minutes(),c)})}function vb(a,c){return c._meridiemParse}function Ob(a,c){c[ma]=x(1E3*("0."+a))}function wb(a){return a}function xb(a,c,b,d){var f=U();c=L().set(d,c);return f[b](c,a)}function xa(a,c,b,d,e){"number"===typeof a&&(c=a,a=void 0);a=a||"";if(null!=c)return xb(a,c,b,e);var f=[];for(c=0;c<d;c++)f[c]=xb(a,c,b,e);return f}function yb(a,c,b,d){c=ba(c,b);a._milliseconds+=d*c._milliseconds;a._days+=d*c._days;a._months+=d*c._months;return a._bubble()}function zb(a){return 0>a?Math.floor(a):Math.ceil(a)}function ca(a){return function(){return this.as(a)}}function oa(a){return function(){return this._data[a]}}function Pb(a,c,b,d,e){return e.relativeTime(c||1,!!b,a,d)}function Ea(){var a=$a(this._milliseconds)/1E3,c=$a(this._days),b=$a(this._months),d,e;d=I(a/60);e=I(d/60);a%=60;d%=60;var k=I(b/12),b=b%12,g=this.asSeconds();return g?(0>g?"-":"")+"P"+(k?k+"Y":"")+(b?b+"M":"")+(c?c+"D":"")+(e||d||a?"T":"")+(e?e+"H":"")+(d?d+"M":"")+(a?a+"S":""):"P0D"}var fb,Oa=e.momentProperties=[],Pa=!1,ja={},za,wa={},hb=/(\[[^\[]*\])|(\\)?(Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Q|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g,Aa=/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,Qa={},ra={},Ab=/\d/,O=/\d\d/,Bb=/\d{3}/,ab=/\d{4}/,Fa=/[+-]?\d{6}/,D=/\d\d?/,Ga=/\d{1,3}/,bb=/\d{1,4}/,Ha=/[+-]?\d{1,6}/,Qb=/\d+/,Ia=/[+-]?\d+/,Ba=/Z|[+-]\d\d:?\d\d/gi,ya=/[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i,Ra={},Sa={},W=0,Y=1,V=2,K=3,ka=4,la=5,ma=6;r("M",["MM",2],"Mo",function(){return this.month()+1});r("MMM",0,0,function(a){return this.localeData().monthsShort(this,a)});r("MMMM",0,0,function(a){return this.localeData().months(this,a)});A("month","M");m("M",D);m("MM",D,O);m("MMM",ya);m("MMMM",ya);g(["M","MM"],function(a,c){c[Y]=x(a)-1});g(["MMM","MMMM"],function(a,c,b,d){d=b._locale.monthsParse(a,d,b._strict);null!=d?c[Y]=d:t(b).invalidMonth=a});var ob={};e.suppressDeprecationWarnings=!1;var Hb=/^\s*(?:[+-]\d{6}|\d{4})-(?:(\d\d-\d\d)|(W\d\d$)|(W\d\d-\d)|(\d\d\d))((T| )(\d\d(:\d\d(:\d\d(\.\d+)?)?)?)?([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,Ta=[["YYYYYY-MM-DD",/[+-]\d{6}-\d{2}-\d{2}/],["YYYY-MM-DD",/\d{4}-\d{2}-\d{2}/],["GGGG-[W]WW-E",/\d{4}-W\d{2}-\d/],["GGGG-[W]WW",/\d{4}-W\d{2}/],["YYYY-DDD",/\d{4}-\d{3}/]],Ua=[["HH:mm:ss.SSSS",/(T| )\d\d:\d\d:\d\d\.\d+/],["HH:mm:ss",/(T| )\d\d:\d\d:\d\d/],["HH:mm",/(T| )\d\d:\d\d/],["HH",/(T| )\d\d/]],Ib=/^\/?Date\((\-?\d+)/i;e.createFromInputFallback=P("moment construction falls back to js Date. This is discouraged and will be removed in upcoming major release. Please refer to https://github.com/moment/moment/issues/1407 for more info.",function(a){a._d=new Date(a._i+(a._useUTC?" UTC":""))});r(0,["YY",2],0,function(){return this.year()%100});r(0,["YYYY",4],0,"year");r(0,["YYYYY",5],0,"year");r(0,["YYYYYY",6,!0],0,"year");A("year","y");m("Y",Ia);m("YY",D,O);m("YYYY",bb,ab);m("YYYYY",Ha,Fa);m("YYYYYY",Ha,Fa);g(["YYYYY","YYYYYY"],W);g("YYYY",function(a,c){c[W]=2===a.length?e.parseTwoDigitYear(a):x(a)});g("YY",function(a,c){c[W]=e.parseTwoDigitYear(a)});e.parseTwoDigitYear=function(a){return x(a)+(68<x(a)?1900:2E3)};var Cb=M("FullYear",!1);r("w",["ww",2],"wo","week");r("W",["WW",2],"Wo","isoWeek");A("week","w");A("isoWeek","W");m("w",D);m("ww",D,O);m("W",D);m("WW",D,O);C(["w","ww","W","WW"],function(a,c,b,d){c[d.substr(0,1)]=x(a)});r("DDD",["DDDD",3],"DDDo","dayOfYear");A("dayOfYear","DDD");m("DDD",Ga);m("DDDD",Bb);g(["DDD","DDDD"],function(a,c,b){b._dayOfYear=x(a)});e.ISO_8601=function(){};var Rb=P("moment().min is deprecated, use moment.min instead. https://github.com/moment/moment/issues/1548",function(){var a=z.apply(null,arguments);return a<this?this:a}),Sb=P("moment().max is deprecated, use moment.max instead. https://github.com/moment/moment/issues/1548",function(){var a=z.apply(null,arguments);return a>this?this:a});kb("Z",":");kb("ZZ","");m("Z",Ba);m("ZZ",Ba);g(["Z","ZZ"],function(a,c,b){b._useUTC=!0;b._tzm=Ya(a)});var Lb=/([\+\-]|\d\d)/gi;e.updateOffset=function(){};var Mb=/(\-)?(?:(\d*)\.)?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?)?/,Nb=/^(-)?P(?:(?:([0-9,.]*)Y)?(?:([0-9,.]*)M)?(?:([0-9,.]*)D)?(?:T(?:([0-9,.]*)H)?(?:([0-9,.]*)M)?(?:([0-9,.]*)S)?)?|([0-9,.]*)W)$/;ba.fn=Ca.prototype;var Tb=nb(1,"add"),Ub=nb(-1,"subtract");e.defaultFormat="YYYY-MM-DDTHH:mm:ssZ";var Db=P("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.",function(a){return void 0===a?this.localeData():this.locale(a)});r(0,["gg",2],0,function(){return this.weekYear()%100});r(0,["GG",2],0,function(){return this.isoWeekYear()%100});Da("gggg","weekYear");Da("ggggg","weekYear");Da("GGGG","isoWeekYear");Da("GGGGG","isoWeekYear");A("weekYear","gg");A("isoWeekYear","GG");m("G",Ia);m("g",Ia);m("GG",D,O);m("gg",D,O);m("GGGG",bb,ab);m("gggg",bb,ab);m("GGGGG",Ha,Fa);m("ggggg",Ha,Fa);C(["gggg","ggggg","GGGG","GGGGG"],function(a,c,b,d){c[d.substr(0,2)]=x(a)});C(["gg","GG"],function(a,c,b,d){c[d]=e.parseTwoDigitYear(a)});r("Q",0,0,"quarter");A("quarter","Q");m("Q",Ab);g("Q",function(a,c){c[Y]=3*(x(a)-1)});r("D",["DD",2],"Do","date");A("date","D");m("D",D);m("DD",D,O);m("Do",function(a,c){return a?c._ordinalParse:c._ordinalParseLenient});g(["D","DD"],V);g("Do",function(a,c){c[V]=x(a.match(D)[0],10)});var Eb=M("Date",!0);r("d",0,"do","day");r("dd",0,0,function(a){return this.localeData().weekdaysMin(this,a)});r("ddd",0,0,function(a){return this.localeData().weekdaysShort(this,a)});r("dddd",0,0,function(a){return this.localeData().weekdays(this,a)});r("e",0,0,"weekday");r("E",0,0,"isoWeekday");A("day","d");A("weekday","e");A("isoWeekday","E");m("d",D);m("e",D);m("E",D);m("dd",ya);m("ddd",ya);m("dddd",ya);C(["dd","ddd","dddd"],function(a,c,b){var f=b._locale.weekdaysParse(a);null!=f?c.d=f:t(b).invalidWeekday=a});C(["d","e","E"],function(a,c,b,d){c[d]=x(a)});r("H",["HH",2],0,"hour");r("h",["hh",2],0,function(){return this.hours()%12||12});ub("a",!0);ub("A",!1);A("hour","h");m("a",vb);m("A",vb);m("H",D);m("h",D);m("HH",D,O);m("hh",D,O);g(["H","HH"],K);g(["a","A"],function(a,c,b){b._isPm=b._locale.isPM(a);b._meridiem=a});g(["h","hh"],function(a,c,b){c[K]=x(a);t(b).bigHour=!0});var Vb=M("Hours",!0);r("m",["mm",2],0,"minute");A("minute","m");m("m",D);m("mm",D,O);g(["m","mm"],ka);var Wb=M("Minutes",!1);r("s",["ss",2],0,"second");A("second","s");m("s",D);m("ss",D,O);g(["s","ss"],la);var Xb=M("Seconds",!1);r("S",0,0,function(){return~~(this.millisecond()/100)});r(0,["SS",2],0,function(){return~~(this.millisecond()/10)});r(0,["SSS",3],0,"millisecond");r(0,["SSSS",4],0,function(){return 10*this.millisecond()});r(0,["SSSSS",5],0,function(){return 100*this.millisecond()});r(0,["SSSSSS",6],0,function(){return 1E3*this.millisecond()});r(0,["SSSSSSS",7],0,function(){return 1E4*this.millisecond()});r(0,["SSSSSSSS",8],0,function(){return 1E5*this.millisecond()});r(0,["SSSSSSSSS",9],0,function(){return 1E6*this.millisecond()});A("millisecond","ms");m("S",Ga,Ab);m("SS",Ga,O);m("SSS",Ga,Bb);var da;for(da="SSSS";9>=da.length;da+="S")m(da,Qb);for(da="S";9>=da.length;da+="S")g(da,Ob);var Yb=M("Milliseconds",!1);r("z",0,0,"zoneAbbr");r("zz",0,0,"zoneName");var l=aa.prototype;l.add=Tb;l.calendar=function(a,c){var b=a||z(),d=Za(b,this).startOf("day"),d=this.diff(d,"days",!0),d=-6>d?"sameElse":-1>d?"lastWeek":0>d?"lastDay":1>d?"sameDay":2>d?"nextDay":7>d?"nextWeek":"sameElse";return this.format(c&&c[d]||this.localeData().calendar(d,this,z(b)))};l.clone=function(){return new aa(this)};l.diff=function(a,c,b){a=Za(a,this);var d=6E4*(a.utcOffset()-this.utcOffset());c=B(c);if("year"===c||"month"===c||"quarter"===c){var d=12*(a.year()-this.year())+(a.month()-this.month()),f=this.clone().add(d,"months"),e;0>a-f?(e=this.clone().add(d-1,"months"),a=(a-f)/(f-e)):(e=this.clone().add(d+1,"months"),a=(a-f)/(e-f));a=-(d+a);"quarter"===c?a/=3:"year"===c&&(a/=12)}else a=this-a,a="second"===c?a/1E3:"minute"===c?a/6E4:"hour"===c?a/36E5:"day"===c?(a-d)/864E5:"week"===c?(a-d)/6048E5:a;return b?a:I(a)};l.endOf=function(a){a=B(a);return void 0===a||"millisecond"===a?this:this.startOf(a).add(1,"isoWeek"===a?"week":a).subtract(1,"ms")};l.format=function(a){a=N(this,a||e.defaultFormat);return this.localeData().postformat(a)};l.from=function(a,c){return this.isValid()?ba({to:this,from:a}).locale(this.locale()).humanize(!c):this.localeData().invalidDate()};l.fromNow=function(a){return this.from(z(),a)};l.to=function(a,c){return this.isValid()?ba({from:this,to:a}).locale(this.locale()).humanize(!c):this.localeData().invalidDate()};l.toNow=function(a){return this.to(z(),a)};l.get=ga;l.invalidAt=function(){return t(this).overflow};l.isAfter=function(a,c){c=B("undefined"!==typeof c?c:"millisecond");return"millisecond"===c?(a=E(a)?a:z(a),+this>+a):(E(a)?+a:+z(a))<+this.clone().startOf(c)};l.isBefore=function(a,c){var b;c=B("undefined"!==typeof c?c:"millisecond");if("millisecond"===c)return a=E(a)?a:z(a),+this<+a;b=E(a)?+a:+z(a);return+this.clone().endOf(c)<b};l.isBetween=function(a,c,b){return this.isAfter(a,b)&&this.isBefore(c,b)};l.isSame=function(a,c){var b;c=B(c||"millisecond");if("millisecond"===c)return a=E(a)?a:z(a),+this===+a;b=+z(a);return+this.clone().startOf(c)<=b&&b<=+this.clone().endOf(c)};l.isValid=function(){return J(this)};l.lang=Db;l.locale=rb;l.localeData=sb;l.max=Sb;l.min=Rb;l.parsingFlags=function(){return F({},t(this))};l.set=ga;l.startOf=function(a){a=B(a);switch(a){case "year":this.month(0);case "quarter":case "month":this.date(1);case "week":case "isoWeek":case "day":this.hours(0);case "hour":this.minutes(0);case "minute":this.seconds(0);case "second":this.milliseconds(0)}"week"===a&&this.weekday(0);"isoWeek"===a&&this.isoWeekday(1);"quarter"===a&&this.month(3*Math.floor(this.month()/3));return this};l.subtract=Ub;l.toArray=function(){return[this.year(),this.month(),this.date(),this.hour(),this.minute(),this.second(),this.millisecond()]};l.toObject=function(){return{years:this.year(),months:this.month(),date:this.date(),hours:this.hours(),minutes:this.minutes(),seconds:this.seconds(),milliseconds:this.milliseconds()}};l.toDate=function(){return this._offset?new Date(+this):this._d};l.toISOString=qb;l.toJSON=qb;l.toString=function(){return this.clone().locale("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ")};l.unix=function(){return Math.floor(+this/1E3)};l.valueOf=function(){return+this._d-6E4*(this._offset||0)};l.year=Cb;l.isLeapYear=function(){return Na(this.year())};l.weekYear=function(a){var c=ia(this,this.localeData()._week.dow,this.localeData()._week.doy).year;return null==a?c:this.add(a-c,"y")};l.isoWeekYear=function(a){var c=ia(this,1,4).year;return null==a?c:this.add(a-c,"y")};l.quarter=l.quarters=function(a){return null==a?Math.ceil((this.month()+1)/3):this.month(3*(a-1)+this.month()%3)};l.month=db;l.daysInMonth=function(){return Ja(this.year(),this.month())};l.week=l.weeks=function(a){var c=this.localeData().week(this);return null==a?c:this.add(7*(a-c),"d")};l.isoWeek=l.isoWeeks=function(a){var c=ia(this,1,4).week;return null==a?c:this.add(7*(a-c),"d")};l.weeksInYear=function(){var a=this.localeData()._week;return tb(this.year(),a.dow,a.doy)};l.isoWeeksInYear=function(){return tb(this.year(),1,4)};l.date=Eb;l.day=l.days=function(a){var c=this._isUTC?this._d.getUTCDay():this._d.getDay();if(null!=a){var b=this.localeData();"string"===typeof a&&(isNaN(a)?(a=b.weekdaysParse(a),a="number"===typeof a?a:null):a=parseInt(a,10));return this.add(a-c,"d")}return c};l.weekday=function(a){var c=(this.day()+7-this.localeData()._week.dow)%7;return null==a?c:this.add(a-c,"d")};l.isoWeekday=function(a){return null==a?this.day()||7:this.day(this.day()%7?a:a-7)};l.dayOfYear=function(a){var c=Math.round((this.clone().startOf("day")-this.clone().startOf("year"))/864E5)+1;return null==a?c:this.add(a-c,"d")};l.hour=l.hours=Vb;l.minute=l.minutes=Wb;l.second=l.seconds=Xb;l.millisecond=l.milliseconds=Yb;l.utcOffset=function(a,c){var b=this._offset||0,d;return null!=a?("string"===typeof a&&(a=Ya(a)),16>Math.abs(a)&&(a*=60),!this._isUTC&&c&&(d=15*-Math.round(this._d.getTimezoneOffset()/15)),this._offset=a,this._isUTC=!0,null!=d&&this.add(d,"m"),b!==a&&(!c||this._changeInProgress?pb(this,ba(a-b,"m"),1,!1):this._changeInProgress||(this._changeInProgress=!0,e.updateOffset(this,!0),this._changeInProgress=null)),this):this._isUTC?b:15*-Math.round(this._d.getTimezoneOffset()/15)};l.utc=function(a){return this.utcOffset(0,a)};l.local=function(a){this._isUTC&&(this.utcOffset(0,a),this._isUTC=!1,a&&this.subtract(15*-Math.round(this._d.getTimezoneOffset()/15),"m"));return this};l.parseZone=function(){this._tzm?this.utcOffset(this._tzm):"string"===typeof this._i&&this.utcOffset(Ya(this._i));return this};l.hasAlignedHourOffset=function(a){a=a?z(a).utcOffset():0;return 0===(this.utcOffset()-a)%60};l.isDST=function(){return this.utcOffset()>this.clone().month(0).utcOffset()||this.utcOffset()>this.clone().month(5).utcOffset()};l.isDSTShifted=function(){if("undefined"!==typeof this._isDSTShifted)return this._isDSTShifted;var a={};Q(a,this);a=ib(a);if(a._a){var c=a._isUTC?L(a._a):z(a._a);this._isDSTShifted=this.isValid()&&0<ua(a._a,c.toArray())}else this._isDSTShifted=!1;return this._isDSTShifted};l.isLocal=function(){return!this._isUTC};l.isUtcOffset=function(){return this._isUTC};l.isUtc=lb;l.isUTC=lb;l.zoneAbbr=function(){return this._isUTC?"UTC":""};l.zoneName=function(){return this._isUTC?"Coordinated Universal Time":""};l.dates=P("dates accessor is deprecated. Use date instead.",Eb);l.months=P("months accessor is deprecated. Use month instead",db);l.years=P("years accessor is deprecated. Use year instead",Cb);l.zone=P("moment().zone is deprecated, use moment().utcOffset instead. https://github.com/moment/moment/issues/1779",function(a,c){return null!=a?("string"!==typeof a&&(a=-a),this.utcOffset(a,c),this):-this.utcOffset()});var u=S.prototype;u._calendar={sameDay:"[Today at] LT",nextDay:"[Tomorrow at] LT",nextWeek:"dddd [at] LT",lastDay:"[Yesterday at] LT",lastWeek:"[Last] dddd [at] LT",sameElse:"L"};u.calendar=function(a,c,b){a=this._calendar[a];return"function"===typeof a?a.call(c,b):a};u._longDateFormat={LTS:"h:mm:ss A",LT:"h:mm A",L:"MM/DD/YYYY",LL:"MMMM D, YYYY",LLL:"MMMM D, YYYY h:mm A",LLLL:"dddd, MMMM D, YYYY h:mm A"};u.longDateFormat=function(a){var c=this._longDateFormat[a],b=this._longDateFormat[a.toUpperCase()];if(c||!b)return c;this._longDateFormat[a]=b.replace(/MMMM|MM|DD|dddd/g,function(a){return a.slice(1)});return this._longDateFormat[a]};u._invalidDate="Invalid date";u.invalidDate=function(){return this._invalidDate};u._ordinal="%d";u.ordinal=function(a){return this._ordinal.replace("%d",a)};u._ordinalParse=/\d{1,2}/;u.preparse=wb;u.postformat=wb;u._relativeTime={future:"in %s",past:"%s ago",s:"a few seconds",m:"a minute",mm:"%d minutes",h:"an hour",hh:"%d hours",d:"a day",dd:"%d days",M:"a month",MM:"%d months",y:"a year",yy:"%d years"};u.relativeTime=function(a,c,b,d){var f=this._relativeTime[b];return"function"===typeof f?f(a,c,b,d):f.replace(/%d/i,a)};u.pastFuture=function(a,c){var b=this._relativeTime[0<a?"future":"past"];return"function"===typeof b?b(c):b.replace(/%s/i,c)};u.set=function(a){var c,b;for(b in a)c=a[b],"function"===typeof c?this[b]=c:this["_"+b]=c;this._ordinalParseLenient=new RegExp(this._ordinalParse.source+"|"+/\d{1,2}/.source)};u.months=function(a){return this._months[a.month()]};u._months="January February March April May June July August September October November December".split(" ");u.monthsShort=function(a){return this._monthsShort[a.month()]};u._monthsShort="Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" ");u.monthsParse=function(a,c,b){var d,f;this._monthsParse||(this._monthsParse=[],this._longMonthsParse=[],this._shortMonthsParse=[]);for(d=0;12>d;d++)if(f=L([2E3,d]),b&&!this._longMonthsParse[d]&&(this._longMonthsParse[d]=new RegExp("^"+this.months(f,"").replace(".","")+"$","i"),this._shortMonthsParse[d]=new RegExp("^"+this.monthsShort(f,"").replace(".","")+"$","i")),b||this._monthsParse[d]||(f="^"+this.months(f,"")+"|^"+this.monthsShort(f,""),this._monthsParse[d]=new RegExp(f.replace(".",""),"i")),b&&"MMMM"===c&&this._longMonthsParse[d].test(a)||b&&"MMM"===c&&this._shortMonthsParse[d].test(a)||!b&&this._monthsParse[d].test(a))return d};u.week=function(a){return ia(a,this._week.dow,this._week.doy).week};u._week={dow:0,doy:6};u.firstDayOfYear=function(){return this._week.doy};u.firstDayOfWeek=function(){return this._week.dow};u.weekdays=function(a){return this._weekdays[a.day()]};u._weekdays="Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" ");u.weekdaysMin=function(a){return this._weekdaysMin[a.day()]};u._weekdaysMin="Su Mo Tu We Th Fr Sa".split(" ");u.weekdaysShort=function(a){return this._weekdaysShort[a.day()]};u._weekdaysShort="Sun Mon Tue Wed Thu Fri Sat".split(" ");u.weekdaysParse=function(a){var c,b;this._weekdaysParse=this._weekdaysParse||[];for(c=0;7>c;c++)if(this._weekdaysParse[c]||(b=z([2E3,1]).day(c),b="^"+this.weekdays(b,"")+"|^"+this.weekdaysShort(b,"")+"|^"+this.weekdaysMin(b,""),this._weekdaysParse[c]=new RegExp(b.replace(".",""),"i")),this._weekdaysParse[c].test(a))return c};u.isPM=function(a){return"p"===(a+"").toLowerCase().charAt(0)};u._meridiemParse=/[ap]\.?m?\.?/i;u.meridiem=function(a,c,b){return 11<a?b?"pm":"PM":b?"am":"AM"};q("en",{ordinalParse:/\d{1,2}(th|st|nd|rd)/,ordinal:function(a){var c=a%10,c=1===x(a%100/10)?"th":1===c?"st":2===c?"nd":3===c?"rd":"th";return a+c}});e.lang=P("moment.lang is deprecated. Use moment.locale instead.",q);e.langData=P("moment.langData is deprecated. Use moment.localeData instead.",U);var Z=Math.abs,Zb=ca("ms"),$b=ca("s"),ac=ca("m"),bc=ca("h"),cc=ca("d"),dc=ca("w"),ec=ca("M"),fc=ca("y"),gc=oa("milliseconds"),hc=oa("seconds"),ic=oa("minutes"),jc=oa("hours"),kc=oa("days"),lc=oa("months"),mc=oa("years"),ta=Math.round,ea={s:45,m:45,h:22,d:26,M:11},$a=Math.abs,w=Ca.prototype;w.abs=function(){var a=this._data;this._milliseconds=Z(this._milliseconds);this._days=Z(this._days);this._months=Z(this._months);a.milliseconds=Z(a.milliseconds);a.seconds=Z(a.seconds);a.minutes=Z(a.minutes);a.hours=Z(a.hours);a.months=Z(a.months);a.years=Z(a.years);return this};w.add=function(a,c){return yb(this,a,c,1)};w.subtract=function(a,c){return yb(this,a,c,-1)};w.as=function(a){var c,b=this._milliseconds;a=B(a);if("month"===a||"year"===a)return c=this._days+b/864E5,c=this._months+4800*c/146097,"month"===a?c:c/12;c=this._days+Math.round(146097*this._months/4800);switch(a){case "week":return c/7+b/6048E5;case "day":return c+b/864E5;case "hour":return 24*c+b/36E5;case "minute":return 1440*c+b/6E4;case "second":return 86400*c+b/1E3;case "millisecond":return Math.floor(864E5*c)+b;default:throw Error("Unknown unit "+a);}};w.asMilliseconds=Zb;w.asSeconds=$b;w.asMinutes=ac;w.asHours=bc;w.asDays=cc;w.asWeeks=dc;w.asMonths=ec;w.asYears=fc;w.valueOf=function(){return this._milliseconds+864E5*this._days+this._months%12*2592E6+31536E6*x(this._months/12)};w._bubble=function(){var a=this._milliseconds,c=this._days,b=this._months,d=this._data;0<=a&&0<=c&&0<=b||0>=a&&0>=c&&0>=b||(a+=864E5*zb(146097*b/4800+c),b=c=0);d.milliseconds=a%1E3;a=I(a/1E3);d.seconds=a%60;a=I(a/60);d.minutes=a%60;a=I(a/60);d.hours=a%24;c+=I(a/24);a=I(4800*c/146097);b+=a;c-=zb(146097*a/4800);a=I(b/12);d.days=c;d.months=b%12;d.years=a;return this};w.get=function(a){a=B(a);return this[a+"s"]()};w.milliseconds=gc;w.seconds=hc;w.minutes=ic;w.hours=jc;w.days=kc;w.weeks=function(){return I(this.days()/7)};w.months=lc;w.years=mc;w.humanize=function(a){var c=this.localeData(),b;b=!a;var d=ba(this).abs(),e=ta(d.as("s")),k=ta(d.as("m")),g=ta(d.as("h")),l=ta(d.as("d")),m=ta(d.as("M")),d=ta(d.as("y")),e=e<ea.s&&["s",e]||1===k&&["m"]||k<ea.m&&["mm",k]||1===g&&["h"]||g<ea.h&&["hh",g]||1===l&&["d"]||l<ea.d&&["dd",l]||1===m&&["M"]||m<ea.M&&["MM",m]||1===d&&["y"]||["yy",d];e[2]=b;e[3]=0<+this;e[4]=c;b=Pb.apply(null,e);a&&(b=c.pastFuture(+this,b));return c.postformat(b)};w.toISOString=Ea;w.toString=Ea;w.toJSON=Ea;w.locale=rb;w.localeData=sb;w.toIsoString=P("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)",Ea);w.lang=Db;r("X",0,0,"unix");r("x",0,0,"valueOf");m("x",Ia);m("X",/[+-]?\d+(\.\d{1,3})?/);g("X",function(a,b,d){d._d=new Date(1E3*parseFloat(a,10))});g("x",function(a,b,d){d._d=new Date(x(a))});e.version="2.10.6";fb=z;e.fn=l;e.min=function(){var a=[].slice.call(arguments,0);return jb("isBefore",a)};e.max=function(){var a=[].slice.call(arguments,0);return jb("isAfter",a)};e.utc=L;e.unix=function(a){return z(1E3*a)};e.months=function(a,b){return xa(a,b,"months",12,"month")};e.isDate=h;e.locale=q;e.invalid=G;e.duration=ba;e.isMoment=E;e.weekdays=function(a,b){return xa(a,b,"weekdays",7,"day")};e.parseZone=function(){return z.apply(null,arguments).parseZone()};e.localeData=U;e.isDuration=Xa;e.monthsShort=function(a,b){return xa(a,b,"monthsShort",12,"month")};e.weekdaysMin=function(a,b){return xa(a,b,"weekdaysMin",7,"day")};e.defineLocale=R;e.weekdaysShort=function(a,b){return xa(a,b,"weekdaysShort",7,"day")};e.normalizeUnits=B;e.relativeTimeThreshold=function(a,b){if(void 0===ea[a])return!1;if(void 0===b)return ea[a];ea[a]=b;return!0};return e});$(function(){window.Hc=function(){var e={areas:{series:{type:"areaspline",threshold:null,tooltip:{valueDecimals:2},data:null,selected:!0,fillColor:Highcharts.Color("#E2E2E2").setOpacity(.3).get("rgba"),lineColor:"#45496E",marker:{states:{fillColor:"#45496E",radius:0,hover:{fillColor:"#45496E",lineColor:"#222"},select:{fillColor:"#45496E",lineColor:"#45496E",radius:50}}},dataGrouping:{dateTimeLabelFormats:{minute:["%Y-%m-%d %H:%M"],hour:["%Y-%m-%d %H:%M"],day:["%Y-%m-%d"],week:["%Y-%m-%d"],month:["%Y-%m"],yers:["%Y-%m"]}},tooltip:{dateTimeLabelFormats:{minute:"%Y-%m-%d %H:%M",hour:"%Y-%m-%d %H:%M",day:"%Y-%m-%d",week:"%Y-%m-%d",month:"%Y-%m",yers:"%Y-%m"},pointFormatter:function(){return"\u73b0\u4ef7:"+this.y.toFixed(2)}}},timeType:{1:{xAxis:{units:["hour",[1]]}}}},candlestick:{series:{type:"candlestick",selected:!1,data:null,color:"#227922",lineColor:"#227922",upColor:"#F00",upLineColor:"#F00",dataGrouping:{dateTimeLabelFormats:{minute:["%Y-%m-%d %H:%M"],hour:["%Y-%m-%d %H:%M"],day:["%Y-%m-%d"],week:["%Y-%m-%d"],month:["%Y-%m"],yers:["%Y-%m"]}},tooltip:{dateTimeLabelFormats:{minute:"%Y-%m-%d %H:%M",hour:"%Y-%m-%d %H:%M",day:"%Y-%m-%d",week:"%Y-%m-%d",month:"%Y-%m",yers:"%Y-%m"},pointFormatter:function(){return"\u5f00\u76d8\u4ef7:"+this.open+"\x3cbr/\x3e\u6700\u9ad8\u4ef7:"+this.high+"\x3cbr/\x3e\u6700\u4f4e\u4ef7:"+this.low+"\x3cbr/\x3e\u6536\u76d8\u4ef7:"+this.close}}}}},d=[{number:5,color:"#aa0"},{number:10,color:"#f00"},{number:30,color:"#a3a"}],h=function(b){this.seriesName=this.Seriesed=this.Chart=null;this.timeType=1;this.Resources=this.HlineTip=this.Hline=null;this.HlineOffY=this.HlineOffX=10;this.ElementNode=b;this.evenLineNumber=30;this.evenLineData;this.evenSeries={};this.evenLineBox=[];this.evenLineTip=[];var d={global:{useUTC:!1}};1==getQueryString("yejian")&&(d.chart={backgroundColor:"#0E2C52"},d.yAxis={gridLineColor:"#315784"});Highcharts.setOptions(d);b.highcharts("StockChart",{chart:{zoomType:"null",resetZoomButton:"null"},series:null,rangeSelector:{enabled:!1},scrollbar:{enabled:!1},navigator:{enabled:!1},credits:{enabled:!1},exporting:{enabled:!1}});this.init()};h.prototype.init=function(){if(!this.isSafe())return!1;var b=this;this.Chart=this.ElementNode.highcharts();this.Timer=null;window.onresize=function(){b.Timer&&clearTimeout(b.Timer);b.Timer=setTimeout(function(){b.resize();clearTimeout(b.Timer)},50)}};h.prototype.isSafe=function(){try{if(document.domain="kxt.com",0>window.parent.location.host.indexOf("kxt.com"))return!1}catch(b){return!1}return!0};h.prototype.setAxis=function(b){if(!e)return!1;b||(b=[void 0,void 0]);b={allowDecimals:!0,labels:{align:"left",autoRotation:[-45],formatter:function(){return this.value.toFixed(2)},x:1},min:b[0],max:b[1],tickColor:"#FF0000"};this.Seriesed.xAxis.update({dateTimeLabelFormats:{minute:"%H:%M",hour:"%H:%M",day:"%m-%d",week:"%m-%d",month:"%Y-%m"}});this.Seriesed.yAxis.update(b)};h.prototype.addSeries=function(b,d){e=e[b];if(!e)return!1;d&&(this.timeType=d);this.seriesName=b;obj=e.series;this.Chart.addSeries(obj)};h.prototype.frame=function(b){if(!this.Seriesed)return!1;switch(this.seriesName){case "areas":this.lineFrame(b);break;case "candlestick":this.oneMinuteFrame(b),this.updateEven(b),this.updateLine(b.p)}this.Chart.reflow();this.Chart.redraw()};h.prototype.setData=function(b){var d=this.Chart.series;this.Seriesed=d[0];this.Resources=b;if("candlestick"==this.seriesName){this.evenLine(b);var e=b.slice(this.evenLineNumber,b.length)}d[0].setData(e||b);this.setAxis();this.updateLine();this.socket()};h.prototype.evenLine=function(){for(var b=0;b<d.length;b++){var e=d[b];this.evenData(e.number,e.color,b)}};h.prototype.evenData=function(b,d,e){for(var k=this.Resources[this.evenLineNumber][0],h,F=[],G=0;G<=this.Resources.length-b;G++){var Q=this.pointXY(this.Resources.slice(G,b+G));h=Q[1];Q[0]>=k&&F.push(Q)}this.drawEven(F,d,b);this.evenLineTip[name]=this.Chart.renderer.label("\u25cfMA"+b+" \x3cspan\x3e"+h.toFixed(2)+"\x3c/span\x3e",0+120*e,20).css({color:d,"font-size":"10px"}).attr({padding:0,zIndex:80,"class":"type"+b}).add()};h.prototype.drawEven=function(b,d,e){this.evenSeries[e]=this.Chart.addSeries({type:"spline",name:e,color:d,lineWidth:1,index:99,tooltip:{pointFormat:""},states:{hover:{enabled:!1}},point:{events:{mouseOver:function(){var b=".type"+this.series.name,d=Number(this.y).toFixed(2);$(b+" tspan:last").length?$(b+" tspan:last").text(d):$(b+" span span").text(d)}}},data:b})};h.prototype.pointXY=function(b){for(var d,e=b.length,h=0,t;d=b.shift();)t=d.x||d[0],h+=d.close||d[4];return[t,h/e]};h.prototype.lineFrame=function(b){var d=this.getTime(b.t);y=b.p;(b=this.checkX(d))?b.y=y:this.Seriesed.addPoint([d,y],!1);this.updateLine(y)};h.prototype.oneMinuteFrame=function(b){var d=this.getTime(b.t);b={x:d,open:Number(b.p),high:Number(b.p),low:Number(b.p),close:Number(b.p)};if(d=this.checkX(d))b.open=d.open,b.high<d.high&&(b.high=d.high),b.low>d.low&&(b.low=d.low),d.remove();this.Seriesed.addPoint(b,!1)};h.prototype.getTime=function(b){switch(this.timeType.toString()){case "1":var d=moment(1E3*parseFloat(b)).startOf("minute");break;case "5":case "15":case "30":var e=parseInt(this.timeType),d=moment(1E3*parseFloat(b)).startOf("minute");b=d.minute();d.minute(b-b%e+e);break;case "1h":case "4h":e=parseInt(this.timeType);d=moment(1E3*parseFloat(b)).startOf("hour");b=d.hour();d.hour(b-b%e+e);break;case "1d":d=moment(1E3*parseFloat(b)).startOf("day");break;case "1w":d=moment(1E3*parseFloat(b)).day(5).hour(0).minute(0).seconds(0).milliseconds(0);d.add(1,"week");break;case "1m":d=moment(1E3*parseFloat(b)).endOf("month"),d.hour(0).minute(0).seconds(0).milliseconds(0)}return d.toDate().getTime()};h.prototype.updateLine=function(b){var d=this.Chart.renderer,e=this.Seriesed.points[this.Seriesed.points.length-1];e.close?(y=e.plotClose+this.HlineOffY,v=e.close):(y=e.plotY+this.HlineOffY,v=e.y);this.Hline&&this.Hline.destroy();e=this.Chart.plotSizeX+this.Chart.plotLeft;this.Hline=d.path(["M",this.Chart.plotLeft,y,"L",e,y]).attr({"stroke-width":1,stroke:"#000"}).add();this.HlineTip&&this.HlineTip.destroy();b&&(v=b);this.HlineTip=d.label(v,e+1,y-10).css({"font-size":"10px",color:"#FFF"}).attr({fill:"#27415E",zIndex:10}).add()};h.prototype.updateEven=function(b){var e=this.getTime(b.t),h=[];h[0]=e;h[1]=parseFloat(b.o);h[2]=parseFloat(b.h);h[3]=parseFloat(b.l);h[4]=parseFloat(b.p);b=this.Resources.slice(-1)[0];e>b[0]?this.Resources.push(h):e==b[0]&&this.Resources.splice(-1,1,h);b=this.Resources;for(var L=0;L<d.length;L++){for(var h=d[L],h=Number(h.number),t=b.slice(b.length-h,b.length),J=0,G=0;G<t.length;G++)e=t[G][0],J+=t[G][4];t=J/h;J=this.evenSeries[h].points;J=J[J.length-1];J.x==e?J.y=t:J.x<e&&this.evenSeries[h].addPoint([e,t],!1)}};h.prototype.checkX=function(b){var d=this.Seriesed.points[this.Seriesed.points.length-1];return d.x==b?d:d.x>b?null:!1};h.prototype.socket=function(){var b=this;(new mySocket(server)).getMsg=function(d){d=JSON.parse(d);d.c||(d=d[0]);if(!d.c)return!1;window.parent.chartMsg(d);b.frame(d)}};h.prototype.resize=function(){this.updateLine()};return h}()});
                