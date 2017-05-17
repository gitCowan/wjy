define(function (require, exports, module) {
    var $ = require("jquery");
    var WebUploader = require('webuploader');
    require('validate');
    var util = require('utils');
    require('icheck');
    var Handlebars=require("Handlebars");
    var helper = require('./helper.js');
    require('cookie');
    require('jquery/jquery.caret.js');
    require('vue');
    exports.init = function(){
        helper.init();
        var file_name = [];
        var shade_nav_val ;
        var shaMain;
        var overdueVue = new Vue({
            el:'#overduePop',
            data:{
                overdueInfo:'',
                remindInfo:''
            }
        })
        $(".notice").click( function (index) { 
            $('.notice').removeClass("noact");
            $(this).addClass("noact");
            $('.recomlist').removeClass('active');
            var index= $(this).index();
            $($('.recomlist')[index]).addClass('active');
            var forum_id;
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
            var options ={};
            if(index == 0){
                options={
                    url:"/work/forums?&per_page=4&page=1",
                    method:"GET"
                }
            }else{
                options={
                    url:"/work/forums?forum_id="+forum_id+"&per_page=4&page=1",
                    method:"GET"
                }
            }
            
            $.ajax(options).done(function(result){
                 var forums = result.result;
                if(forums){
                   
                    var source = '{{#each forums}}'+
            '<a href="/recommendDetails?id={{id}}">{{title}}</a>'+
            '{{/each}}';
                    var template = Handlebars.compile(source);
                    var htm = template({forums:forums});
                    $($('.recomlist')[index]).html(htm);
                }else{
                }
                
            }).fail(function(err){
            })
         });
        function openOrder(){
            $.ajax({
                url:'/getTicketState',
                type:'GET',
                success:function(data){
                    if(data.status){
                        var state = data.result.state;
                        if (state == 1) {
                            $('#shaMain').animate({'height':'80px','opacity':1,'padding':'15px'},500);
                            $('#select .selectHide').css({'display':'block'});
                            $('#select').addClass('active')
                        }else if(state == 0){
                            $('.modalPay').css('display','block');
                            $('.Juris').css('display','block');
                        }else if (state == 611) {
                            overdueVue.overdueInfo = '抱歉，您的提问数量已达上限';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务提问数量已达上限。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if (state == 612) {
                            overdueVue.overdueInfo = '抱歉，您的服务已过期';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务咨询时限已过期。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }
                    }else{
                        alert(data.msg);
                    }
                },
                error:function(data){}
            })
        }
        $('.expbox').click(function(){
            $.ajax({
                url:'/getTicketState',
                type:'GET',
                success:function(data){
                    if(data.status){
                        var state = data.result.state;
                        if (state == 1) {
                            location.href = '/orderProblem';
                        }else if(state == 0){
                            $('.modalPay').css('display','block');
                            $('.Juris').css('display','block');
                        }else if (state == 611) {
                            overdueVue.overdueInfo = '抱歉，您的提问数量已达上限';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务提问数量已达上限。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if (state == 612) {
                            overdueVue.overdueInfo = '抱歉，您的服务已过期';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务咨询时限已过期。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }
                    }else{
                        alert(data.msg);
                    }
                },
                error:function(data){}
            })
        })
        $('#inpid').focus(function(){
            $.ajax({
                url:'/getTicketState',
                type:'GET',
                success:function(data){
                    if (data.status) {
                        var state = data.result.state;
                        if (state ==1) {
                             $('#shaMain').animate({'height':'80px','opacity':1,'padding':'15px'},500);
                        }else if (state == 611) {
                            overdueVue.overdueInfo = '抱歉，您的提问数量已达上限';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务提问数量已达上限。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if (state == 612) {
                            overdueVue.overdueInfo = '抱歉，您的服务已过期';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务咨询时限已过期。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if(state ==0){
                            $('.modalPay').css('display','block');
                            $('.Juris').css('display','block');
                        }
                    }else if(data.status == 0 && data.code == 10){
                        location.href ='/signin';
                    }else{
                        alert(data.msg);
                    }
                },
                error:function(data){}
            })
        })
        $('#btn').click(function(){
            
            $.ajax({
                url:'/getTicketState',
                type:'GET',
                success:function(data){
                    if (data.status) {
                        var state = data.result.state;
                        if (state ==1) {
                            submitA();
                        }else if (state == 611) {
                            overdueVue.overdueInfo = '抱歉，您的提问数量已达上限';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务提问数量已达上限。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if (state == 612) {
                            overdueVue.overdueInfo = '抱歉，您的服务已过期';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务咨询时限已过期。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if(state ==0){
                            $('.modalPay').css('display','block');
                            $('.Juris').css('display','block');
                        }
                    }else if(data.status == 0 && data.code == 10){
                        location.href ='/signin';
                    }else{
                        alert(data.msg);
                    }
                },
                error:function(data){}
            })
        })
        
        $('#askimg').click(function(){
            $('.nv').css('display','block');
            $.ajax({
                url:'/getTicketState',
                type:'GET',
                success:function(data){
                    if (data.status) {
                        var state = data.result.state;
                        if (state ==1) {
                            $('#shaMain').animate({'height':'80px','opacity':1,'padding':'15px'},500);
                            $('.nv').animate({'opacity':1,'height':'100px'},500);
                            $(this).css('background','url(/img/order/askimg_l.png) no-repeat center');
                            $('#askfile').css('background','url(/img/order/askfile.png) no-repeat center');
                            $('.picDiv').css('display','block');
                            $('.picGroup').css('display','block');
                            $('.selectHide').css({'display':'none'});
                            setTimeout(function(){
                                uploadImg();
                            },500);
                        }else if (state == 611) {
                            overdueVue.overdueInfo = '抱歉，您的提问数量已达上限';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务提问数量已达上限。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if (state == 612) {
                            overdueVue.overdueInfo = '抱歉，您的服务已过期';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务咨询时限已过期。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if(state ==0){
                            $('.modalPay').css('display','block');
                            $('.Juris').css('display','block');
                        }
                    }else if(data.status == 0 && data.code == 10){
                        location.href ='/signin';
                    }else{
                        alert(data.msg);
                    }
                },
                error:function(data){}
            })
            

        })
        
        $('#askfilehide').click(function(){
            $.ajax({
                url:'/getTicketState',
                type:'GET',
                success:function(data){
                    if (data.status) {
                        var state = data.result.state;
                        if (state ==1) {
                            $('#shaMain').animate({'height':'80px','opacity':1,'padding':'15px'},500);
                            $('.nv').animate({'opacity':1,'height':'100px'},500);
                            $(this).css('background','url(/img/order/askimg_l.png) no-repeat center');
                            $('#askfile').css('background','url(/img/order/askfile.png) no-repeat center');
                            $('.picDiv').css('display','block');
                            $('.picGroup').css('display','block');
                            $('.selectHide').css({'display':'none'});
                            setTimeout(function(){
                                uploadFile();
                            },500);
                        }else if (state == 611) {
                            overdueVue.overdueInfo = '抱歉，您的提问数量已达上限';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务提问数量已达上限。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if (state == 612) {
                            overdueVue.overdueInfo = '抱歉，您的服务已过期';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务咨询时限已过期。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if(state ==0){
                            $('.modalPay').css('display','block');
                            $('.Juris').css('display','block');
                        }
                    }else if(data.status == 0 && data.code == 10){
                        location.href ='/signin';
                    }else{
                        alert(data.msg);
                    }
                },
                error:function(data){}
            })

        })
             
        $('.aax').click(function(){
            $('.nv').animate({'opacity':0,'height':'0'},500);
            $('#askimg').css('background','url(/img/order/askimg.png) no-repeat center');
        })
        $('#select p').click(function(){
            if ($('#select').hasClass('active')) {
                $('#select').removeClass('active')
            } else {
                openOrder();
                $('.nv').animate({'opacity':0,'height':'0'},500);
                $('#askimg').css('background','url(/img/order/askimg.png) no-repeat center');
            }
            
        })
        $('.selectHide span').click(function(){
            var index = $(this).index();
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
            $('#select p').html(shade_nav_val);
            $('.selectHide').css('display','none');
        })
        
        var uploads = [];
        var images=[];
        var Gcontent;
        var uploadImg = function(){
            var uploadtable = WebUploader.create({
                    pick: '#upload',
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
                    if($('.picimg').length < 8){
                       uploadtable.upload();
                    }else{
                        util.alertMessage(0, '您插入的图片已经达到最大值');
                        return false;
                    }
                }else{
                   util.alertMessage(0, '您上传的图片格式不对');
                    return false;
                }
                
            })

            uploadtable.on("fileQueued", function (file) {
                
                uploadtable.option('formData', {
                    filename: file.name,
                    type: file.type
                });
                console.log(file)
                var dd = '<div class="picimg " data-Token="" data-Name="'+file.name+'">'+
                        '<img class="titlePic" src="">'+
                        '<span class="uploadClose">X</span>'+
                        '<div class="picHide"></div>'+
                    '</div>';
                $('.picGroup').append(dd);
            });
            var glen = 0;
            uploadtable.on('uploadSuccess', function (file, res) {
                shaMain = $('#shaMain').val();
                if(res.status==1){
                    images.push(res.result);
                    glen +=1;
                    if(glen >8){
                        util.alertMessage(0, '您插入的图片已经达到最大值');
                        return false;
                    }
                    $('.picGroup').find('.picimg:last-child').attr('data-Token',res.result.token);
                    $('.picGroup').find('.picimg:last-child .titlePic').attr('src',res.result.content_url).css('display','block');
                    setInterval(function(){
                        $('.picGroup').find('.picHide:last-child').css('display','none');
                    },500)
                    $('#shaMain').insertAtCaret('   ['+res.result.name+']   ');
                    file_name.push(res.result.name);
                }
            });
            uploadtable.on('uploadError', function (file, reason) {
                util.alertMessage(0, '文件上传失败');
                $('.picGroup').find('.picimg:last-child').remove();
            });
            uploadtable.on('uploadComplete', function (file) {
                uploadtable.removeFile(file);

            });
            uploadtable.on('uploadBeforeSend', function (block, data, headers) {
            });
            uploadtable.on('uploadProgress',function(file,percentage){
                var rate=util.toFixed(percentage*100,2);
                var top =60-((rate*60)/100);
                var obj = $('.picGroup').find('.picimg');
                obj.eq(obj.length -1).find('.picHide').css({'top':top+'px'}).html(rate+'%');
            });
        }
        var size;
        var uploadFile = function(){
            var uploadtableflie = WebUploader.create({
                    pick: $("#askfile")[0],
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
                $('#askfile').css('background', 'url("/img/order/askfile_l.png") 50% 50% no-repeat').find('input[type=file]').attr('disabled','disabled');
                uploadtableflie.option('formData', {
                    filename: file.name,
                    type: file.type
                });
            });
            uploadtableflie.on('uploadSuccess', function (file, res) {
                util.alertMessage(1, '您的附件上传成功');
                if(res.status==1){
                    uploads.push(res.result.token);
                    var dd = $('#shaMain').val();
                    $('#shaMain').val(dd+'     ['+res.result.name+']');
                    file_name.push(res.result.name);
                    $('#askfile').css('background','url(/img/order/askfile.png) no-repeat center').find('input[type=file]').removeAttr('disabled');
                }
            });
            uploadtableflie.on('uploadError', function (file, reason) {
                util.alertMessage(0, '文件上传失败');
            });
            uploadtableflie.on('uploadComplete', function (file) {
                uploadtableflie.removeFile(file);
            });
            uploadtableflie.on('uploadBeforeSend', function (block, data, headers) {
                
            });
            uploadtableflie.on('uploadProgress',function(file,percentage){
            });
        }
        
        uploadFile();
        function submitA(){
            $('#btn').attr('disabled','disabled');
            var title;
            if($.trim($('#inpid').val())){
                 title=$.trim($('#inpid').val());
            }else{
                util.alertMessage(0,'请输入问题标题');
                $('#btn').removeAttr('disabled');
                return false;
            }

            var comment = {};
            comment.content = $('#shaMain').val();
            comment.uploads =uploads;

            if($.trim($('#shaMain').val())){
                content=$.trim($('#shaMain').val());
                for(var i=0,len=images.length;i<len;i++){
                    var regStr="\\["+images[i].name+"\\]";
                    var reg=new RegExp(regStr,"g");
                    var imgStr='<img src="'+images[i].content_url+'" alt="" />'; 
                    content=content.replace(reg,imgStr);
                }
                comment.content = content;
            }else{
                util.alertMessage(0,'请输入详细问题描述');
                $('#btn').removeAttr('disabled');
                return false;
            }
            var field_3948;
            if(shade_nav_val){
                 field_3948 = shade_nav_val;
            }else{
                util.alertMessage(0,'请选择问题类型');
                $('#btn').removeAttr('disabled');
                return false;
            }

            $.ajax({
               type: "POST",
               url: "/work/requests/",
               data: {
                    request:{
                   
                       title: title,
                       custom_fields:[{
                           name : 'field_3948',
                           value: field_3948
                       }],
                       comment:{
                            content: comment.content,
                            uploads: comment.uploads
                       }
                    }
               },
               success: function(data){
                    $('#btn').removeAttr('disabled');
                    if (data.status) {
                        $('.nv').css({'opacity':0,'height':'0'});
                        $('#btn').removeAttr('disabled');
                        $('.shadeTip').show();
                        $('#inpid').val('');
                        $('#shaMain').val('');
                        $('#select p').html('选择分类');
                        uploadArr = [];
                        shade_nav_val = '';
                        var xx ='<span class="trang gl"></span>'+
                                '<div class="picGroup clearfix">'+
                                    '<div class="picDiv clearfix ">'+
                                        '<div class="upload" id="upload">'+
                                            '+'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="aax">&#215;</div>'+
                                '</div>';
                        $('.nv').html(xx);
                    }else{
                        alert('工单提问异常，请重试！');
                    }
                }
               
            });
        };
        $('.tipClose1').click(function(){
            $('.shadeTip').css('display','none');
        })
        $('.nv').on('click','.uploadClose',function(){
            var dataName ='['+$(this).parent().attr('data-Name')+']';
            $(this).parent().remove();
            Gcontent=$('#shaMain').val();
            var newGcon =Gcontent.replace(dataName,'');
            console.log(dataName);
            $('#shaMain').val(newGcon) ;
            
        });

        $('.shade_nav span').click(function(){
            $('.shade_nav span').css('color','#333');
            $(this).css('color','#5fb2ff');
            var index = $(this).index();
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
        });
        
        $.ajax({
            url:'/getMobile',
            type:'GET',
            success:function(data){
                if (data.status == 1) {
                    $('#payPhone').val(data.result.phone);
                }else if(data.status ==0){
                }
            },
            error:function(data){}
        })
        $('#fengl').click(function(){
             $.ajax({
                url:'/getTicketState',
                type:'GET',
                success:function(data){
                    if(data.status){
                        var state = data.result.state;
                        if (state == 1) {
                            util.alertMessage(0,'您已经开通工单了');
                        }else if(state == 0){
                            $('.modalPay').css('display','block');
                            $('.Juris').css('display','block');
                        }else if (state == 611) {
                            overdueVue.overdueInfo = '抱歉，您的提问数量已达上限';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务提问数量已达上限。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if (state == 612) {
                            overdueVue.overdueInfo = '抱歉，您的服务已过期';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务咨询时限已过期。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }
                    }else{
                        alert(data.msg);
                    }
                },
                error:function(data){}
            })
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

        });
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
                util.alertMessage(0,i18n.t('cadPackage.phoneNo'));
                return;
            }
            if (!reg.test(phone)) {
                util.alertMessage(0,i18n.t('cadPackage.phoneError'));
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

       

        $('.gmodule').click(function(){
            $.ajax({
                url:'/getTicketState',
                type:'GET',
                success:function(data){
                    if(data.status){
                        var state = data.result.state;
                        if (state == 1) {
                            var title = $('#inpid').val();
                            var select = shade_nav_val;
                            var upfile = uploads;
                            var fname = file_name;
                            var content=$('#shaMain').val();
                            for(var i=0,len=images.length;i<len;i++){
                                var regStr="\\["+images[i].name+"\\]";
                                var reg=new RegExp(regStr,"g");
                                var imgStr='<img src="'+images[i].content_url+'" alt="" />'; 
                                content=content.replace(reg,imgStr);
                            }
                            console.log(upfile);
                            $.cookie('title', title, {domain: '.apicloud.com'});
                            $.cookie('main', content, {domain: '.apicloud.com'});
                            $.cookie('select', select, {domain: '.apicloud.com'});
                            $.cookie('upfile', upfile, {domain: '.apicloud.com'});
                            $.cookie('fname', fname, {domain: '.apicloud.com'});
                            location.href = '/orderProblem';
                        }else if(state == 0){
                            $('.modalPay').css('display','block');
                            $('.Juris').css('display','block');
                        }else if (state == 611) {
                            overdueVue.overdueInfo = '抱歉，您的提问数量已达上限';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务提问数量已达上限。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }else if (state == 612) {
                            overdueVue.overdueInfo = '抱歉，您的服务已过期';
                            overdueVue.remindInfo = '温馨提醒：尊敬的APICloud用户，您购买的优先技术支持服务咨询时限已过期。';
                            $('#overduePop').modal({
                                backdrop:'static',
                                show:true
                            })
                        }
                    }else{
                        alert(data.msg);
                    }
                    
                },
                error:function(data){}
            })
            
        });

        $(document.body).on('click',function(e){
            if (($(e.target).hasClass('order-select')) || ($(e.target).parents('.order-select').length > 0)) {
                
            } else {
                $('#select .selectHide').hide();
                $('#select').removeClass('active');
            }
        });
    };
});