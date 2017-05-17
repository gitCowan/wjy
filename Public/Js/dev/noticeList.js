define(function (require, exports, module) {
    var $ = require("jquery");
    var Handlebars=require("Handlebars");
    var helper = require('./helper.js');
    
    exports.init = function(){
        helper.init();
        var pageNum = 1;
        var reqLock = false;
        
        $('.move').click(function(){
            pageNum +=1;
            if(reqLock){
                return false;
            }

            var options={
                url:"/work/forums?forum_id=73182&per_page=10&page="+pageNum,
                method:"GET"
            }
           
            $.ajax(options).done(function(result){
               
                var forums = result.result;
                for(var i = 0; i<forums.length; i++){
                    forums[i].created_at =  forums[i].created_at.substr(0,16);
                }
                var source = $('#newsMou').html();
                var template = Handlebars.compile(source);
                var htm = template({forums:forums});
               
                $('.recombox').append(htm);
                if(forums.length < 2){
                    $('.move').html('您已经都加载完了')
                    reqLock = true;
                    return true;
                    
                }

            }).fail(function(err){
                console.log(err)
            })
        })

    };

});