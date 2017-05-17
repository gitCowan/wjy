define(function (require, exports, module) {
    var $ = require("jquery");
    window.UEDITOR_HOME_URL="/libs/library/ue/"
    require("ueditor");
    var util = require('utils');
    require("ueditor.dialog");
    require("ueditor.upload")
    require("ueditor.image");
    var WebUploader = require('webuploader');
    require('cookie');

    exports.init = function(){
        var shade_nav_val ;
        var uploads = [];
        $('.inputTitle').val($.cookie('title'));
        var num;
        var gfileNum = 0;
        switch($.cookie('select')){
             case '端引擎':
                 num = 0;
                 shade_nav_val = '端引擎';
                 break;
             case '云引擎':
                 num = 1;
                 shade_nav_val = '云引擎';
                 break;
             case '应用开发':
                 num = 2;
                 shade_nav_val = '应用开发';
                 break;
             case '聚合API':
                 num = 3;
                 shade_nav_val = '聚合API';
                 break;
             case '开发工具':
                 num = 4;
                 shade_nav_val = '开发工具';
                 break;
             case '其他':
                 num = 5;
                 shade_nav_val = '其他';
                 break;
        }
        $($('.key')[num]).css('color','#5fb2ff');
        uploads.push($.cookie('upfile')); 

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
        
        setTimeout(function(){
            UE.getEditor('derText').setContent($.cookie('main'));
        },500);
               
        var uploadtable = WebUploader.create({
                pick: $('#askimg')[0],
                swf: '/libs/webuploader/Uploader.swf',
                server: '/work/attachments',
                resize: false,
                auto: true,
                accept :{
                    extensions:'gif,jpg,jpeg,png'
                }
        });
        uploadtable.on( 'beforeFileQueued', function( file ) {
            var regPng = /\.png$/;
            var regJpg = /\.jpg$/;
            var regJpeg = /\.jpeg$/;
            var regGif = /\.gif$/;
            if(regPng.test(file.name.toLowerCase()) || regJpg.test(file.name.toLowerCase()) || regJpeg.test(file.name.toLowerCase()) ||regGif.test(file.name.toLowerCase())){
                uploadtable.upload();
            }else{
                alert('请上传正确的图片格式');
                return false;
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
                ueditor.execCommand('insertimage', [{ src:res.result.content_url}]);
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
        
        var size ;
        var uploadtableflie = WebUploader.create({
                pick: $('#askfile')[0],
                swf: '/libs/webuploader/Uploader.swf',
                server: '/work/attachments',
                resize: false,
                auto: true,
                accept :{
                    extensions:'rar,zip,txt,doc,docx,xls,xlsx,pdf,csv,ppt'
                }
        });
        uploadtableflie.on( 'beforeFileQueued', function( file ) {
            var regRar = /\.rar$/;
            var regZip = /\.zip$/;
            var regTxt = /\.txt$/;
            var regDoc = /\.doc$/;
            var regDocx = /\.docx/;
            var regXls = /\.xls/;
            var regXlsx = /\.xlsx/;
            var regPdf = /\.pdf/;
            var regCsv = /\.csv/;
            var regPpt = /\.ppt/;
            
            if(regRar.test(file.name.toLowerCase()) || regZip.test(file.name.toLowerCase()) || regTxt.test(file.name.toLowerCase()) ||regDoc.test(file.name.toLowerCase()) ||regDocx.test(file.name.toLowerCase()) ||regXls.test(file.name.toLowerCase()) ||regXlsx.test(file.name.toLowerCase()) ||regPdf.test(file.name.toLowerCase()) ||regCsv.test(file.name.toLowerCase()) ||regPpt.test(file.name.toLowerCase())){
                
                if(file.size>10485760){
                    util.alertMessage(0, '您上传的附件过大');
                    return false;
                }else{
                    uploadtableflie.upload();
                    if(file.size<1024){
                        size = (file.size).toFixed(2)+'B';
                    }else if((file.size>1024) && (file.size < 1048576) ){
                        size = (file.size/1024).toFixed(2)+'KB';
                    }else if(file.size > 1048576 && (file.size < 10485760)){
                        size = (file.size/(1024*1024)).toFixed(2)+'MB';
                    }
                }
            }else{
               util.alertMessage(0, '您上传的文件格式不对');
                return false;
            }
        })

        uploadtableflie.on("fileQueued", function (file) {
            $('#askfile').css('background','url("/img/order/askfile_l.png") 50% 50% no-repeat').find('input[type=file]').attr('disabled','disabled');
            $('.fileDiv').animate({'opacity':'1','margin':'17px 3px 63px 92px'},300);
            var dd = '<div class="fileDivBox clearfix" data-Token="">'+
                         '<div class="fileDivConHide">'+
                             '<span class="fileBoxClose">×</span>'+
                         '</div>'+
                         '<div class="fileDivCon">'+
                             '<img src="img/order/fileImg.png" alt="" class="l fileBoxImg">'+
                             '<div class="r fileDivConRight">'+
                                 '<p>'+file.name+'</p>'+
                                 '<div class="fileDivsize clearfix">'+
                                     '<span class="l">'+size+'</span>'+
                                     '<span class="r filePer"></span>'+
                                 '</div>'+
                             '</div>'+
                         '</div>'+
                     '</div>';
            $('.fileDiv').append(dd);

            uploadtableflie.option('formData', {
                filename: file.name,
                type: file.type
            });
        });
        uploadtableflie.on('uploadSuccess', function (file, res) {
            if(res.status==1){
                gfileNum+=1;
                $('.fileNum').html(gfileNum);
                $('.fileDiv').find('.fileDivBox:last-child').attr('data-Token',res.result.token);
                var cc = UE.getEditor('derText').getContent();
                UE.getEditor('derText').setContent( cc +' ['+res.result.name+']');
                $('#askfile').css('background','url("/img/order/askfile.png") 50% 50% no-repeat').find('input[type=file]').removeAttr('disabled');
            }
        });
        uploadtableflie.on('uploadError', function (file, reason) {
            util.alertMessage(0, i18n.t("global.UploadFailed"));
            $('.fileDiv').find('.fileDivBox:last-child').remove();
        });
        uploadtableflie.on('uploadComplete', function (file) {
           
            uploadtableflie.removeFile(file);
        });
        uploadtableflie.on('uploadBeforeSend', function (block, data, headers) {
        });
        uploadtableflie.on('uploadProgress',function(file,percentage){
            var rate=util.toFixed(percentage*100,2);
            var obj = $('.fileDiv').find('.fileDivBox');
            obj.eq(obj.length -1).find('.filePer').html(rate+"%");
        });
        
        $('.key').click(function(){
            var index = $(this).index();
            $('.key').css('color','#666');
            $(this).css('color','#5fb2ff');
            switch (index){
                 case 0:
                     shade_nav_val = '端引擎';
                     break;
                 case 1:
                     shade_nav_val = '云引擎';
                     break;
                 case 2:
                     shade_nav_val = '应用开发';
                     break;
                 case 3:
                     shade_nav_val = '聚合API';
                     break;
                 case 4:
                     shade_nav_val = '开发工具';
                     break;
                 case 5:
                     shade_nav_val = '其他';
                     break;
            }
        })
        

        $('.btn-public').click(function(){
            $(this).attr('disabled','disabled');
            var uploadArr = $('.fileDiv').find('.fileDivBox').map(function(i,e){
                return $(e).attr('data-Token');
            });
            var emptArr =[''];
            uploadArr = $.merge( emptArr, uploadArr);
            uploadArr = uploadArr.concat(uploads);
            $.ajax({
                url:'/getTicketState',
                type:'GET',
                success:function(data){
                    console.log(data);
                    if(data.result){
                        if (data.result.state ==1) {
                            $.cookie('title','');
                            $.cookie('main','');
                            $.cookie('select','');
                            $.cookie('upfile','');
                            $.cookie('fname','');
                            var title;
                            var field_3948 ;
                            var comment = {};
                            console.log();
                            comment.content = UE.getEditor('derText').getContent();
                            comment.uploads =uploadArr.length > 0 ? uploadArr : '';

                            if($.trim($('.inputTitle').val())){
                                 title=$.trim($('.inputTitle').val());
                            }else{
                                util.alertMessage(0,'请输入问题标题');
                                 $('.btn-public').removeAttr('disabled');
                                return false;
                            };
                            
                            if(shade_nav_val){
                                 field_3948 = shade_nav_val;
                            }else{
                                util.alertMessage(0,'请选择问题类型');
                                $('.btn-public').removeAttr('disabled');
                                return false;
                            };

                            if(UE.getEditor('derText').getContent()){
                                 comment.content = UE.getEditor('derText').getContent();
                            }else{
                                util.alertMessage(0,'请输入问题描述');
                                $('.btn-public').removeAttr('disabled');
                                return false;
                            };


                            $.ajax({
                               url: "/work/requests",
                               type: "POST",
                               data: {
                                    request:{
                                       title:title,
                                       custom_fields:[{
                                           name:'field_3948',
                                           value:field_3948
                                       }],
                                       comment:{
                                            content: comment.content,
                                            uploads: comment.uploads
                                       }
                                    }
                               },
                               success: function(msg){
                                var xx ='<p class="fileDivTitle">附件（<span>0</span>）</p>';
                                 $('.fileDiv').html(xx).css('opacity','0');
                                 $('.btn-public').removeAttr('disabled');
                                 $('.shadeTip').css('display','block');
                                 $('.inputTitle').val('');
                                 UE.getEditor('derText').setContent('');
                                 $('.key').css('color','rgb(102, 102, 102)');
                                 

                               }
                            });
                           
                        }else if(data.result.state ==0){
                            $('.modalPay').css('display','block');
                            $('.Juris').css('display','block');
                        }
                    }
                    
                },
                error:function(data){}
            })

            
        })
        $('.fileDiv').on('mousemove','.fileDivBox',function(){
            $(this).find('.fileDivConHide').css('display','block');
        })
        $('.fileDiv').on('mouseout ','.fileDivBox',function(){
            $(this).find('.fileDivConHide').css('display','none');
        })
        $('.fileDiv').on('click','.fileBoxClose',function(){
            $(this).parent().parent().remove();
            var text = UE.getEditor('derText').getContent();
            var aa ='<p>['+$(this).parent().next().find('p').html()+']</p>';
            var newCon = text.replace(aa,'');
            var index = $(this).parent().parent().index();
            UE.getEditor('derText').setContent(newCon);
            if($('.fileDivBox').length == 0){
               $('.fileDiv').animate({'opacity':'0','margin':'0'},200);
            }
            
            gfileNum-=1;
            $('.fileNum').html(gfileNum);
        })
        $('.tipClose1').click(function(){
            $('.shadeTip').css('display','none');
        })
        var $channelJuris = $('#channelJuris');
        var $channelPop = $('#channelPop'),paySuccReq;
        $channelJuris.find('.open-way span').on('click',function(){
            var $this = $(this),
            price = $this.attr('data-price'),
            oldPrice = $this.attr('data-oldPrice');
            $channelJuris.find('.open-way .active').removeClass('active');
            $this.addClass('active');
            $channelJuris.find('.price-box .price').text(price);
            $channelJuris.find('.price-box .old-price').text(oldPrice);

        })
        $channelJuris.find('.close').on('click',function(){
            $channelJuris.find('.channel-pay').hide();
            $channelJuris.find('.Juris').hide();
            $('.modalPay').css({'display':'none'});

        })
        $channelJuris.find('.back').on('click',function(){
            $channelJuris.find('.Juris').show();
            $channelJuris.find('.channel-pay').hide();
        })
        $channelJuris.find('.pay-way span').on('click',function(){
            var $this = $(this),
            $invoice = $channelJuris.find('.invoice'),
            name = $this.attr('data-id');
            $channelJuris.find('.pay-way span').removeClass('active');
            $this.addClass('active');
            $channelJuris.find('.pay-box').hide();
            $channelJuris.find('.'+name+'-pay').show();
            $channelJuris.find('.success-way').hide();
            if (name == 'qrcode') {
                $invoice.hide();

            }else{
                $invoice.show();
            };
        })

        $channelJuris.find('.confirm').on('click',function(){
            var $this = $(this),
            price = $channelJuris.find('.price-box .price').text(),
            oldPrice = $channelJuris.find('.price-box .old-price').text(),
            payType = $channelJuris.find('.open-way .active').attr('data-type'),
            count = $channelJuris.find('.open-way .active').text();
            $this.attr('disabled','disabled');
            $.ajax({
                url:'/purchaseTicketService',
                type:'POST',
                data:{
                    pay_type:payType,
                    order_type:1
                },
                success:function(data,query,xhr){
                    console.log('data is ',data);
                    if (data.status) {
                        $this.removeAttr('disabled');
                        var wxUrl = data.result.weixinLink,
                        taobaoUrl = data.result.taobaoLink,
                        hostname = window.location.host,
                        wxImg = hostname+'/img/media/icon-wx.png',
                        tbImg = hostname+'/img/media/icon-tb.png',
                        weixinEle = $channelJuris.find('.weixin'),
                        taobaoEle = $channelJuris.find('.taobao');
                        $channelJuris.find('.channel-pay .time-limit').text(count);
                        $channelJuris.find('.channel-pay .type-info .price').text(price);
                        $channelJuris.find('.channel-pay .type-info .old-price').text(oldPrice);
                        wxUrl = wxUrl ? 'weixin://'+wxUrl : '';
                        taobaoUrl = taobaoUrl ? 'https://'+taobaoUrl : '';
                        payQrcode(weixinEle,wxUrl,wxImg,126);
                        payQrcode(taobaoEle,taobaoUrl,tbImg,126);
                        clearTimeout(paySuccReq);
                        paySuccReq = '';
                        qrcodePay();
                        $channelJuris.find('.Juris').hide();
                        $channelJuris.find('.channel-pay').show();
                    };
                },
                error:function(data){

                }
            })
        })

        $channelJuris.find('.invoice-btn').on('click',function(){
            var $this = $(this);
            if ($this.hasClass('active')) {
                $this.removeClass('active');
                $channelJuris.find('.set-invoice').hide();
            }else{
                $this.addClass('active');
                $channelJuris.find('.set-invoice').show();
            };
            
        })
        $channelJuris.find('#tellMe').on('click',function(){
            var phone = $channelJuris.find('#payPhone').val(),
            reg = /^1[3|4|5|7|8][0-9]\d{8}$/g;
            if (!phone) {
                 console.log(2222222)
                util.alertMessage(0,i18n.t('cadPackage.phoneNo'));
                return;
            }
            if (!reg.test(phone)) {
                util.alertMessage(0,i18n.t('cadPackage.phoneError'));
                console.log(2222222)
                return;
            }
            $.ajax({
                url:'/addTicketcheckInfo',
                type:'POST',
                data:{
                    phone:phone
                },
                success:function(data){
                    if (data.status) {
                        clearTimeout(paySuccReq);
                        paySuccReq = '';
                        var count =3;
                        var td_state = 1;
                        $channelJuris.find('.pay-box,.success-pay').hide();
                        $channelJuris.find('.transfer-success').show();
                        autoCloseSucc(count,td_state);
                    };
                },
                eror:function(data){}
            })
        })

        require('../jquery/jquery.qrcode.min.js');
        var genQrcode = function(el,size){
            var $this = $(el);
            size = size || 90;
            var qrcodeUrl;
            if($this.hasClass('android')){
                qrcodeUrl = $this.attr('data-url');
                $this.empty().qrcode({
                    ecLevel: 'L',
                    render:'image',
                    size: size,
                    text:qrcodeUrl
                });
            }else if($this.hasClass('ios')){
                qrcodeUrl = $this.attr('data-url');
                $this.empty().qrcode({
                    ecLevel: 'L',
                    render:'image',
                    size: size,
                    text: qrcodeUrl
                });
            }
        };
        function payQrcode(el,url,imgUrl,size){
            var $this = $(el);
            size = size || 95;
            url = url || '';
            $this.empty().qrcode({
                ecLevel: 'L',
                render:'image',
                size: size,
                text: url,
                image:imgUrl
            });
        }
         
        function qrcodePay(){
            $.ajax({
                url:'/getTicketOrderSt?order_type=1',
                type:'GEt',
                cache: false,
                success:function(data){
                    if (data.status) {
                        console.log('data.result.state',data.result.state)
                        if (data.result.state == 3) {
                            clearTimeout(paySuccReq);
                            paySuccReq = '';
                            var count = 3;
                            var td_state = 0;
                            $channelJuris.find('.pay-box,.success-pay').hide();

                            $channelJuris.find('.pay-success').show();

                            autoCloseSucc(count,td_state);
                        }else{
                            paySuccReq = setTimeout(qrcodePay,2000);
                        };
                    }else{
                        util.alertMessage(0,data.msg);
                    };
                }
            })
        }
        
        function autoCloseSucc(time,td_state){
            var closeSucc = setInterval(function(){
                time--;
                if (time <= 0) {
                    clearInterval(closeSucc);
                    $channelJuris.hide();
                    $channelJuris.find('.back').trigger('click');
                };
            },1000);

        }
        $channelJuris.find('.invoice-set').on('click',function(){
            var $this = $(this),
            textEle = $channelJuris.find('.invoice-info'),
            payWay = $channelJuris.find('.pay-way .active').attr('data-id');
            if ($this.hasClass('active')) {
                payWay == 'transfer' && addInvoice();
                $this.removeClass('active');
                textEle.attr('disabled','disabled');
            }else{
                $this.addClass('active');
                textEle.removeAttr('disabled');
            };
            
        })

        function addInvoice(){
            var name = $channelJuris.find('.invoice-info').val();
            if (!name) {
                util.alertMessage(0,'请填写发票信息');
                return;
            };
            $.ajax({
                url:'/addTicketcheckInfo',
                type:'POST',
                data:{
                    checkTitle:name
                },
                success:function(data){
                    if (data.status) {
                        util.alertMessage(1,'发票提交成功');
                    };
                },
                error:function(data){

                }
            })
        }


    };

});