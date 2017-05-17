define(function (require, exports, module) {
    var $ = require("jquery");
    var Handlebars=require("Handlebars");
    var helper = require('./helper.js');
    exports.init = function(){
        helper.init();
        var forum_id="" ,index = 0 , pageNum = 1;
        var reqLock = false;
        $(".navSpan").click( function () { 
         	$('.navSpan').removeClass("navActive");
         	$(this).addClass("navActive");
         	$('.recombox').removeClass('boxAct');
         	index= $(this).index();
         	$($('.recombox')[index]).addClass('boxAct');

            switch(index){
                case 1:
                    forum_id="72807";
                    break;
                case 2:
                    forum_id="72808";
                    break;
                case 3:
                    forum_id="72809";
                    break;
                case 4:
                    forum_id="72810";
                    break;
                case 5:
                    forum_id="73171";
                    break;
                case 6:
                    forum_id="73597";
                    break
            }
            
            reqLock = false;
            $('.move').html('查看更多')
            $($('.recombox')[index]).html();
            ajaxFun (forum_id,index);
            pageNum = 1;
        });
        
        function ajaxFun(forum_id,index){

            if(index == 0){
                var options={
                    url:"/work/forums?per_page=10&page=1",
                    method:"GET"
                }
            }else{
                var options={
                    url:"/work/forums?forum_id="+forum_id+"&per_page=10&page=1",
                    method:"GET"
                }
            }
            $.ajax(options).done(function(result){
                console.log(result)
                 var forums = result.result;
                if(forums){
                    for(var i = 0; i<forums.length; i++){
                        forums[i].created_at =  forums[i].created_at.substr(0,16);
                    }
                    var source = $('#newsMou').html();
                    var template = Handlebars.compile(source);
                    var htm = template({forums:forums});
                    $($('.recombox')[index]).html(htm);
                }else{
                     $('.move').html('这里还没有您的想要的推荐信息哦');
                }
                
            }).fail(function(err){
                console.log(err)
            })
        }

        $('.move').click(function(){
            pageNum +=1;
            if(reqLock){
                return false;
            }

            if(index == 0){
                var options={
                    url:"/work/forums?per_page=10&page="+pageNum,
                    method:"GET"
                }
            }else{
                var options={
                    url:"/work/forums?forum_id="+forum_id+"&per_page=10&page="+pageNum,
                    method:"GET"
                }
            }
            $.ajax(options).done(function(result){
               
                var forums = result.result;
                for(var i = 0; i<forums.length; i++){
                    forums[i].created_at =  forums[i].created_at.substr(0,16);
                }
                var source = $('#newsMou').html();
                var template = Handlebars.compile(source);
                var htm = template({forums:forums});
               
                $($('.recombox')[index]).append(htm);
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