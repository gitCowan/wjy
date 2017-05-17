define(function (require, exports, module) {
    var $ = require("jquery");
    var Handlebars=require("Handlebars");
    var helper = require('./helper.js');
    exports.init = function(){
        helper.init();
        var status="" ,index = 0 , pageNum = 1;
        var reqLock = false;
        
        $(".navSpan").click( function () { 
         	$('.navSpan').removeClass("navActive");
         	$(this).addClass("navActive");
         	$('.navlist').removeClass('listAct');
         	index= $(this).index();
         	$($('.navlist')[index]).addClass('listAct');
            status = "new";
            switch(index){
                case 1:
                    status="new";
                    break;
                case 2:
                    status="open";
                    break;
                case 3:
                    status = "pending";
                    break;
                case 4:
                    status = "solved";
                    break;
                case 5:
                    status = "closed";
                    break
            }
            reqLock = false;
            $('.move').html('查看更多')
            $($('.navlist')[index]).html();
            ajaxFun(status,index);
            pageNum = 1;
            
        });
        
        function ajaxFun(status,index){

            if(index == 0){
                var options={
                    url:"/work/requests?per_page=10&page=1",
                    method:"GET"
                }
            }else{
                var options={
                    url:"/work/requests/search?status="+status+"&per_page=10&page=1",
                    method:"GET"
                }
            }
            $.ajax(options).done(function(result){
                console.log(result)
                var requests = result.result.requests;
                if(requests){
                   for(var i=0;i<requests.length;i++){
                        var current = requests[i];
                        var cc  = current.created_at.substr(5,11); 
                        var bb = cc.replace("-","月");
                        current.created_at = bb.replace(" ","日 ");
                        for(var j=0;j<current.custom_fields.length;j++){
                            if(current.custom_fields[j].name=="field_3948"){
                                current.module=current.custom_fields[j].value;
                            }
                        }
                    }
                    var source = $('#newsMou').html();
                    var template = Handlebars.compile(source);
                    var htm = template({requests:requests});
                    
                    $($('.navlist')[index]).html(htm);
                }else{
                     $('.move').html('这里还没有您的工单信息哦');
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
                    url:"/work/requests?per_page=10&page="+pageNum,
                    method:"GET"
                }
            }else{
                var options={
                    url:"/work/requests/search?status="+status+"&per_page=10&page="+pageNum,
                    method:"GET"
                }
            }
            $.ajax(options).done(function(result){
                var requests = result.result.requests;
                if(requests){
                    for(var i=0;i<requests.length;i++){
                        var current = requests[i];
                        for(var j=0;j<current.custom_fields.length;j++){
                            if(current.custom_fields[j].name=="field_3948"){
                                current.module=current.custom_fields[j].value;
                            }
                        }
                    }
                    var source = $('#newsMou').html();
                    var template = Handlebars.compile(source);
                    var htm = template({requests:requests});

                    $($('.navlist')[index]).append(htm);
                    if(requests.length < 3){
                        $('.move').html('您已经都加载完了')
                        reqLock = true;
                        return true;
                        
                    }
                }else{
                    $('.move').html('这里还没有您的工单信息哦')
                }
                
                

            }).fail(function(err){
                console.log(err)
            })
        })

        

    };

});