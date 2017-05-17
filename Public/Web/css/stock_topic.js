
//个股页的话题

//提交一级回复
$(document).on("click",".submit_topic",function(){
    var _submitTopic = $(this);
    _submitTopic.hide();
    _submitTopic.next().show();
    var content = $.trim(_submitTopic.parent().siblings(".start-topic").val());
    if(!checkTopicContent(content)){
        _submitTopic.show();
        _submitTopic.next().hide();
        return ;
    }
    seajs.use('//static.360buyimg.com/finance/common/unit/login/1.0.0/login.js', function (login) {
        login(function () {
            //添加一级评论
            addTopicReply( code ,key, content , _submitTopic );
        });
    });
});

function addTopicReply( code ,key, content , _submitTopic ){
    $.post("/discuss/addDiscussion.html",{"code":code,"key":key,"content":content},function(data){
        if(data.success){
            //清空输入框
            $(".topic-content").val("");
            var topicReply =  newTopicReply(data);
            $(".no-comment").remove();
            $("h3.comment-new").after(topicReply)
        }else{
            showMsg( _submitTopic , data.message  );
        }
        $(_submitTopic).show();
        $(_submitTopic).next().hide();
    },"json");
}

function gotoPage(pageNum) {
    $.post("/discuss/loadDiscussion.html",{"code":code,"key":key,"pageNum":pageNum},function(data){
        $("div.comment").children(".topic-comment-list,.page,.no-comment").remove().end().append(data);
    });
}