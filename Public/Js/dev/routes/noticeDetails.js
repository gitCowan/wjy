define(function (require, exports, module) {
    var $ = require("jquery");
    window.UEDITOR_HOME_URL="/libs/library/ue/"
    require("ueditor");
    var util = require('utils');
    require("ueditor.dialog");
    require("ueditor.upload")
    require("ueditor.image");
    var WebUploader = require('webuploader');


    exports.init = function(){
    	var ueditor = new UE.ui.Editor({
            toolbars: [['bold', 'italic', 'underline', 
                'insertorderedlist', 'insertunorderedlist',
                'insertcode', 
                'forecolor', 'backcolor',
                'link', 'unlink', 
                'date','time','drafts'
            ]],
            imageUrl:'/posts/ueupload',
            imagePath:'',
            imageManagerUrl:'/posts/ueimagemanage',
            imageManagerPath:'',  
            retainOnlyLabelPasted:true,
                
            serverUrl: '',
            imageActionName: 'autoupload',
            imageFieldName: 'upfile',
            imageUrlPrefix: '', 
            
            zIndex:5,initialFrameHeight:150,initialFrameWidth:'100%',autoHeightEnabled:true,
            elementPathEnabled:false, wordCount:false,
            lang:'zh-cn',   
            minFrameWidth:500, minFrameHeight:60});
        ueditor.render("derText");
        
     
        $('.btn-public').click(function(){
            var comment;
            if (UE.getEditor('derText').getContent() == '') {
                 util.alertMessage(0, '提交的回复不可为空');
                 return false;
            }else{
                comment = UE.getEditor('derText').getContent();
            }
             
            $.ajax({
               type: "POST",
               url: "/work/forums/"+$("#hiddenId").val(),
               data: {
                    post_comment:{
                       content:comment
                    }
               },
               success: function(msg){
                 console.log(msg);
                 location.reload() ;
               }
            });
        })

        $.ajax({
            url:'/getTicketState',
            type:'GET',
            success:function(data){
                console.log(data);
                if (data.result.state ==1) {
                }else if(data.result.state ==0){
                    $('.reply').css('display','none');
                }
            },
            error:function(data){}
        })
        
    };

});