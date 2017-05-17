define(function (require, exports, module) {
    
    var $ = require("jquery");
    window.UEDITOR_HOME_URL="/libs/library/ue/"
    var util = require('utils');
    var WebUploader = require('webuploader');
    require("ueditor.upload")
    require("ueditor");
    require("ueditor.dialog");
    
    require("ueditor.image");
    
    
    exports.init = function(){
    	var $footer = $('.footer');
        var footerTop = $footer.offset().top;
        var footerHeight = $footer.height();
        var $serviceNumber = $('.service-number');
        var windowHeight = $(window).height();
        $(window).scroll(function(){
            console.log($(window).scrollTop() + 176 + 105 , footerTop);
            if ($(window).scrollTop() + 176 + 105 <= footerTop) {
                $serviceNumber.removeClass('absolute');
            } else {
                $serviceNumber.addClass('absolute');
            }
        });
        $(window).trigger('scroll');

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

        

        var elem = $("#picker")[0];
        var uploads = [];
        var uploadtable = WebUploader.create({
                pick: elem,
                swf: '/libs/webuploader/Uploader.swf',
                server: '/work/attachments',
                resize: false,
                auto: true
        });
        uploadtable.on( 'beforeFileQueued', function( file ) {
            if(file.size > 30*1024*1024){
                util.alertMessage(0,i18n.t('mcm.Error:3'));
                return false;
            }else{
                uploadtable.upload();
            }
        })

        uploadtable.on("fileQueued", function (file) {
            $("#progressBarBox").show();
            uploadtable.option('formData', {
                filename: file.name,
                type: file.type
            });
        });
        uploadtable.on('uploadSuccess', function (file, res) {
            console.log(res)
            if(res.status==1){
                uploads.push(res.result.token);
                UE.getEditor('derText').setContent('<b>['+res.result.name+']</b>');
                
            }
        });
        uploadtable.on('uploadError', function (file, reason) {
            util.alertMessage(0, i18n.t("global.UploadFailed"));
        });
        uploadtable.on('uploadComplete', function (file) {
           
            uploadtable.removeFile(file);
        });
        uploadtable.on('uploadBeforeSend', function (block, data, headers) {
        });
        uploadtable.on('uploadProgress',function(file,percentage){
            
        });
        
        var gurl = location.href;
        if(gurl.indexOf('closed')>= 0){
            $('.reply').css('display','none');
        }
        $('.btn-public').click(function(){
            var title=$('.inputTitle').val();
            var field_3948 = $('select').val();
            var comment = {};
            if (UE.getEditor('derText').getContent() == '') {
                 util.alertMessage(0, '提交的回复不可为空');
                 return false;
            }else{
                comment.content = UE.getEditor('derText').getContent();
            }
            
            comment.uploads =uploads;
            $.ajax({
               type: "POST",
               url: "/work/requests/"+$("#hiddenId").val(),
               data: {
                    request:{
                       comment:{
                            content: comment.content,
                            uploads: comment.uploads
                       }
                    },
                    "_method":"PUT"
               },
               success: function(msg){
                 location.reload() ;
               }
            });
        });
        
       
    };

});