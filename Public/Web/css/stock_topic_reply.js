//回复显示与隐藏
$(document).on("hover",".topic-comment-list",function(){
    if(!$(this).children(".topic-reply-detials").is(":visible")){
        $(this).children().children(".reply").toggle();
    }
});
//回复显示与隐藏
$(document).on("hover",".reply-comment-list",function(){
    if(!$(this).children(".reply-reply-details").is(":visible")){
        $(this).children().children(".reply").toggle();
    }
});
//字数的控制
$(document).on("keyup",".topic-content",function(){
    var topicContent = $.trim($(this).val());
    var $_text = $(this).siblings(".start-topic-btn").children(".text");
    if(400 >= topicContent.length ){
        $($_text).removeClass("font-red");
        $($_text).html("您还可以输入"+(400 - topicContent.length)+"个字");
    }else{
        $($_text).addClass("font-red").html("已超出"+(topicContent.length - 400)+"个字");
    }
});

//字数的控制
$(document).on("keyup",".start-topic-reply,.content-reply",function(){
    var topicContent = $.trim($(this).val());
    var $_text = $(this).siblings(".start-topic-btn").children(".text");
    if(1000 >= topicContent.length ){
        $($_text).removeClass("font-red");
        $($_text).html("您还可以输入"+(1000 - topicContent.length)+"个字");
    }else{
        $($_text).addClass("font-red").html("已超出"+(topicContent.length - 1000)+"个字");
    }
});


//话题点击评论后的展示
$(document).on("click",".topic-reply",function(){
	var $reply = $(this).parent().next(".topic-reply-detials");
    var topicId = $(this).attr("topicId");
    var parentName = $(this).attr('parentName');
    $($reply).find(".start-topic").empty().html("回复 "+parentName+":");
    //$($reply).children(".start-topic").empty().val("");
    $($reply).toggle();
    //把以前的去掉
    if($($reply).children(".reply-comment-list").length > 0 ){
        $($reply).children(".reply-comment-list").remove();
        $($reply).children(".comment-list-more").remove();
    };
    if(!$($reply).is(":hidden")){
        $.post("/discuss/loadDisReplys.html",{"topicId":topicId},function(data){
            $($reply).append(data);
        });
    }
});

//提交对话题的回复
$(document).on("click",".topic-re-reply",function(){
    var $reReply = $(this);
	var parentName = $(this).attr("parentName");//被回复的昵称
	var parentPin = $(this).attr("parentPin");//被回复的pin
    var topicId = $(this).attr("topicId");//话题id
    var content = $.trim($(this).parent().siblings(".start-topic-reply").val());
    if( !checkReplyContent2(content, $(this).parent().find(".text").first()) ){

        return false;
    }
    var startC = "回复 "+ parentName +":" ;
    if(content.startWith(startC)){
        content = content.replace(startC,"");
    }
    seajs.use('//static.360buyimg.com/finance/common/unit/login/1.0.0/login.js', function (login) {
        login(function () {
            //添加二级评论
            addReplyRe( content , topicId ,parentName ,$reReply , parentPin);
        });
    });
});

//添加话题回复
function addReplyRe(content,topicId,parentName,reReply , parentPin){
    reReply.hide();
    reReply.next().show();
    $.post("/discuss/addDisReply.html",{"content":content,"topicId":topicId,"parentPin":parentPin},function(data){
        if(data.success){
            var obj = {"topicId":topicId,"content":data.content,"parentName":parentName,"img":data.img,"nikeNameShow":data.nikeNameShow,"currPin":data.pin,"topicTitle":data.topicTitle,"topicTitleReply":data.topicTitleReply};
            //$(".start-topic").empty().val("回复 "+parentName+":");
            //$(".start-topic").val("");
            reReply.parent().siblings(".start-topic").val("回复 "+parentName+":");
            var replyR = newReplyReply(obj);
            $(reReply).parent().parent().after(replyR);
        }else{
            showMsg( reReply , data.message );
        }
        reReply.show();
        reReply.next().hide();
    },"json");
}

//点击回复的回复按钮
$(document).on("click",".reply-reply",function(){
    var $rreply = $(this).parent().next(".reply-reply-details");
    //$($rreply).children(".start-topic").val("");
    var parentName = $(this).attr('parentName');
    $($rreply).children(".start-topic").empty().val("回复 "+parentName+":");
    $($rreply).toggle();
});

//提交回复的回复
$(document).on("click",".reply-re-reply",function(){
    var $rrReply = $(this);
    var parentName = $(this).attr("parentName");
    var parentPin = $(this).attr("parentPin");
    var topicId = $(this).attr("topicId");
    var content = $.trim($(this).parent().siblings(".start-topic").val());
    //var $rdetials = $(this).parents(".topic-reply-detials");

    if(!checkReplyContent2(content,$(this).parent().find(".text").first())){
        return false;
    }
    var startC = "回复 "+ parentName +":" ;
    if(content.startWith(startC)){
        content = content.replace(startC,"");
    }

    seajs.use('//static.360buyimg.com/finance/common/unit/login/1.0.0/login.js', function (login) {
        login(function () {
            //添加二级评论
            addReplyReply( content , topicId,parentName , $rrReply , parentPin);
        });
    });

});

//添加回复的回复
function addReplyReply(content , topicId ,parentName ,rrReply , parentPin){
        rrReply.hide();
        rrReply.next().show();
    $.post("/discuss/addDisReply.html",{"content":content,"topicId":topicId,"parentPin":parentPin},function(data){
        if(data.success){
            $(".start-topic").empty().html("回复 "+parentName+":");
        	//$(".start-topic").empty().val("");
            var obj = {"topicId":topicId,"content":data.content,"parentName":parentName,"img":data.img,"nikeNameShow":data.nikeNameShow,"currPin":data.pin,"parentPin":parentPin,"topicTitle":data.topicTitle,"topicTitleReply":data.topicTitleReply};
            var replyR = newReplyReply(obj);
            $(rrReply).parents(".reply-comment-list").siblings(".reply-details-info").after(replyR);
            $(rrReply).parents(".reply-comment-list").find("a.reply-reply").trigger("click");
        }else{
            showMsg( rrReply , data.message );
        }
        rrReply.show();
        rrReply.next().hide();
    },"json");
}

//一级回复
function newTopicReply( data ){
    var $topicReply = $("#topic-reply-clone").clone();
    $($topicReply).children(".question").html(data.content);
    $($topicReply).children(".info").children("input.replyCnt").attr("id","replys_count_"+data.topicId);
    var $tc_btn = $($topicReply).children(".info").children("a.topic-reply");
    $($tc_btn).attr("topicId",data.topicId).attr("parentName",data.nikeNameShow);
    var $info = $($topicReply).children(".info").children(".info-details");
    if(!data.img || data.img==""){
        data.img = "//i.jd.com/commons/img/no-img_mid_.jpg";
    }
    $($info).children("img").attr("src",data.img);
    if(data.topicTitle && data.topicTitle=='topman'){
    	$($info).children(".topman").removeClass("manager-tag").addClass("manager-tag").text("牛人");
    }
    $($info).children(".name").html(data.nikeNameShow);
    $($topicReply).children(".topic-reply-detials").children(".reply-details-info").children(".start-topic-btn").children("a.topic-re-reply").attr("topicId",data.topicId).attr("parentName",data.nikeNameShow).attr("parentPin",data.pin);
    return $(($topicReply)).show().removeAttr("id");
}
//回复的回复-增加评论数
function newReplyReply( data ){
    addReplyCount(data.topicId);
    var $topicReply = $("#reply-reply-clone").clone();
    $($topicReply).children(".question").html(data.content);
    var $tc_btn = $($topicReply).children(".info").children("a.reply-reply");
    $($tc_btn).attr("topicId",data.topicId).attr("parentName",data.nikeNameShow);
    var $info = $($topicReply).children(".info").children(".info-details");
    if(!data.img || data.img==""){
        data.img = "//i.jd.com/commons/img/no-img_mid_.jpg";
    }
    $($info).children("img").attr("src",data.img);
    if(data.parentName && data.parentName!=''){
    	if(data.topicTitle && data.topicTitle=='topman'){
    		if(data.topicTitleReply && data.topicTitleReply=='topman'){
    			$($info).children(".name").html(data.nikeNameShow  +" <span class="+"manager-tag"+">牛人</span>  回复    "+  data.parentName+" <span class="+"manager-tag"+">牛人</span>");
    		}else{
    			$($info).children(".name").html(data.nikeNameShow  +" <span class="+"manager-tag"+">牛人</span>  回复     "+  data.parentName);
    		}
    	}else{
    		if(data.topicTitleReply && data.topicTitleReply=='topman'){
    			$($info).children(".name").html(data.nikeNameShow  +"  回复    "+  data.parentName+" <span class="+"manager-tag"+">牛人</span>");
    		}else{
    			$($info).children(".name").html(data.nikeNameShow  +"  回复    "+  data.parentName);
    		}
    	}
    }else{
        $($info).children(".name").html(data.nikeNameShow);
    }
    $($topicReply).children(".reply-reply-details").children(".start-topic-btn").children("a.reply-re-reply").attr("topicId",data.topicId).attr("parentName",data.nikeNameShow).attr("parentPin",data.currPin);
    return $(($topicReply)).show().removeAttr("id");
}

//判断话题输入内容
function checkTopicContent( content ){
    var  contentTrim = $.trim(content);
    if( contentTrim == "" ){
        $("#alertClubMsgs").text("评论内容不能为空");
        $("#alertClubMsgs").addClass("font-red");
        return false ;
    }
    if(contentTrim.length>400){
        $("#alertClubMsgs").text("评论不能超过400字");
        $("#alertClubMsgs").addClass("font-red");
		return false;
	}
    return true;
}
//判断话题输入内容
function checkReplyContent( content )
{
	var  contentTrim = $.trim(content);
	if( contentTrim == "" )
    {
		return false ;
	}
	if(contentTrim.length>1000)
    {

		return false;
	}
	return true;
}


function checkReplyContent2( content ,obj){
    var  contentTrim = $.trim(content);
    if( contentTrim == "" ){
        obj.text("回复内容不能为空");
        obj.addClass("font-red");
        return false ;
    }
    if(contentTrim.length>1000){
        obj.text("回复内容不能超过1000字");
        obj.addClass("font-red");
        return false;
    }
    return true;
}

//提交回复进行增加回复数
function addReplyCount( topicId ){
    var id = "replys_count_"+topicId;
    var $replyId = $("#"+id);
    var count = isNaN($($replyId).val()) ? 0 : parseInt($($replyId).val());
    var replyCount = count + 1 ;
    $( "#"+id ).val( replyCount );
    $( "#"+id ).next().html( "回复"+replyCount );
}

//判断输入内容的开头
String.prototype.startWith=function(str){
    if(str==null||str==""||this.length==0||str.length>this.length)
        return false;
    if(this.substr(0,str.length)==str){
        return true;
    }else{
        return false;
    }
    return true;
}
//评论跳转
$(document).on("click",".topic-comment-list > .question > #topicContent",function(){
    var topicId = $(this).parent().siblings(".info").children("a").attr("topicId");
    window.open("//club.jr.jd.com/topic/"+topicId,"_blank");
});

function showMsg( _obj  , msg){
    _obj.siblings(".text").addClass("font-red").html( msg );
}

/***
$(document).ready(function(){
	$(window).load(function() { 
		$("textarea").val("");
	}); 
});
*/