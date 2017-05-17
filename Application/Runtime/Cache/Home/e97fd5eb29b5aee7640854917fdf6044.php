<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<title><?php echo C('WebName');?></title>
<!-- <style>
.ycdcdDiv ul li{border-bottom:1px solid #fff;}
</style> -->
</head>
<body style="max-width:640px;margin-left:auto;margin-right:auto;background:#202020;">

<div class="main"> 	
       
    <link rel="stylesheet" href="/Public/Home/css/global.css">
    <link rel="stylesheet" href="/Public/Home/css/index.css">
    <link rel="stylesheet" href="/Public/Home/css/pwd.css">
    <link rel="stylesheet" href="/Public/Home/css/ico_foot.css"/>
    <div id="div1"  style="background-color: #FFF;"></div>
    <div class="wrap">
        <div class="">
            <?php if($openid == ''): ?><form id="reviseForm" class="i-form" method="post" action="<?php echo U('User/register');?>" >
                    <input type="hidden" name="puid" value="<?php echo $_GET['uid']; ?>">
                    <input type="hidden" name="oid" value="<?php echo ($oid); ?>">
                    <div style="text-align: center;"><h2>新用户注册</h2></div>
                    <ul class="form-box" style="margin-top:10px;">
                        <li class="f-line clearfix">
                            <label class="f-label">推荐人ID</label>
                            <input style="background-color:transparent" id="t-id" class="f-input text" type="text" maxlength="10" placeholder="请输入推荐人ID" name="oid">
                        </li>
                        <li class="f-line clearfix">
                            <label class="f-label">会员名称</label>
                            <input style="background-color:transparent" id="c-name" class="f-input text" type="text" maxlength="16" placeholder="请输入用户名" name="username">
                        </li>
                        <li class="f-line clearfix">
                            <label class="f-label">手机号</label>
                            <input style="background-color:transparent" id="utel" class="f-input text" type="text" maxlength="11" placeholder="请输入手机号码" name="utel">
                        </li>
                        <li class="f-line clearfix" style="height: 40px;">
                            <label class="f-label">短信验证码</label>
                            <input  class="f-input2 text" type="text " maxlength="12" placeholder="请输短信验证码" name="yzm" id="yzm" style="width:40%;height:30px;background: #fff;">
                            <!--<input type="button" value="获取验证码" id="msgs" class="f-sub2">-->
                            <span class="msgs" style="width:60px; margin-top:3px;margin-left:5px;">获取验证码</span>
                        </li>
                        <li class="f-line clearfix">
                            <label class="f-label">登录密码</label>
                            <input style="background-color:transparent" id="n-pwd" class="f-input text" type="password" maxlength="15" placeholder="请输入六位新密码" name="upwd">
                        </li>

                    </ul>
                    <div id='btnAgree' style="width:95%;margin-left:auto;margin-right:auto">
                        <div><input  name="agree" type="checkbox" value="1" class="text"  id="check" checked/>&nbsp;<span >我已阅读和同意<span id='btnBook'>《服务协议及隐私条款》</span></span></div>
                        <div style="height:300px;overflow:scroll;border: 1px solid ;border-radius:5px;display: none" id="panel">

                        </div>
                    </div>
                    <div class="zhuce">
                        <input type="hidden" value="" id="code" />
                        <input style="background-color:#0697DA" type="button" value="完成注册" class="f-sub" onclick="baocun()" id="send"/>
                    </div>
                    <div class="zhuce"><br/>
                        <a  href="<?php echo U('User/login');?>" >已有账号，立即登录</a>
                    </div>
                </form>
                <?php else: endif; ?>
        </div>
    </div>
    <script src="/Public/Home/js/jquery-2.1.1.min.js"></script>
    <script src="/Public/Home/js/script.js"></script>


    <style type="text/css">
        .formtips{
            width: 100%;
        }
    </style>
    <script type="text/javascript">

        $(function(){
            //如果是必填的，则加红星标识.
            //文本框失去焦点后
            $('form :input').blur(function(){
                var $parent = $(this).parent();
                $parent.find(".formtips").remove();
                //验证用户名
                if( $(this).is('input[name="username"]') ){
                    if( this.value==""){
                        var errorMsg = '请输入用户名.';
                        return false;
                    }
                }
                //手机号码验证
                if( $(this).is('input[name="utel"]') ){
                    if( this.value=="" || ( this.value!="" && !/^1[3|4|5|8][0-9]\d{4,8}$/.test(this.value) ) ){
                        var errorMsg = '请输入正确的手机号码.';
                        return false;
                    }
                }

                //密码验证
                if( $(this).is('input[name="upwd"]') ){
                    if( this.value=="" ){
                        var errorMsg = '请输入正确的密码.';
                        return false;
                    }
                }
/*                //确认密码验证
                if( $(this).is('input[name="repassword"]') ){
                    if( this.value!=$('#n-pwd').val()){
                        var errorMsg = '两次密码不一样.';
                        return false;
                    }
                }*/
//                //确认密码验证
//                if( $(this).is('input[name="oid"]') ){
//                    if( this.value==""  ){
//                        var errorMsg = '请输入推荐人ID.';
//                        $parent.append('<input style="background-color:transparent"  class="f-input formtips onError" type="text" value="'+errorMsg+'" > ');
//                        return false;
//
//                    }else{
//                        $parent.append('<input style="background-color:transparent" class="f-input formtips onSuccess" style="display:none" type="text"  > ');
//                    }
//                }
//                //确认密码验证
//                if( $(this).is('input[name="lid"]') ){
//                    if( this.value!="456852" ){
//                        var errorMsg = '请输入正确的推荐码.';
//                        $parent.append('<input style="background-color:transparent"  class="f-input formtips onError" type="text" value="'+errorMsg+'" > ');
//                        return false;
//
//                    }else{
//                        $parent.append('<input style="background-color:transparent" class="f-input formtips onSuccess" style="display:none" type="text"  > ');
//                    }
//                }

            }).keyup(function(){
                $(this).triggerHandler("blur");
            }).focus(function(){
                $(this).triggerHandler("blur");
            });

//            //提交，最终验证。
//            $('#send').click(function(){
//
//            });
            //服务条款效果
            $("#btnBook").click(function(){
                $("#panel").slideToggle("slow");
            });


        })

    </script>
    <script type="text/javascript">
        $(function  () {
            //获取短信验证码\
            var validCode=true;
            $(".msgs").click(function() {
                var phone = $("#utel").val();
                var tel = /^1([38]\d|4[57]|5[0-35-9]|7[06-8]|8[89])\d{8}$/;
                if(!tel.test($("#utel").val())){
                    alert("手机号输入有误");
                    return false;
                }else{
                    alert('短信已经发送，请注意查收！');
                }
//                    window.location.href="<?php echo U('Public/wap_reset_msg1');?>?phone="+phone;
                $.ajax({
                    type: "post",
                    url:"<?php echo U('Public/wap_reset_msg1');?>",
                    dataType:'json',
                    data:'phone='+phone,
                    success:function(json){
                        if(json['status'] == '1'){
                            $('#code').attr('value',json['code']);
                        }else{
                            alert(json['code']);
                        }
                    }
                });
                var time=100;
                var code=$(this);
                if (validCode) {
                    validCode=false;
                    code.addClass("msgs1");
                    var t = setInterval(function  () {
                        time--;
                        code.html(time+"秒");
                        if (time==0) {
                            clearInterval(t);
                            code.html("重新获取");
                            validCode=true;
                            code.removeClass("msgs1");

                        }
                    },1000)
                }
            })
        });
        function baocun(){

            var username    = $("#c-name").val().length;
            var utel    = $("#utel").val();
            var password    = $("#n-pwd").val().length;
            var tid   = $("#t-id").val().length;//推荐人ID
            var code    = $("#code").val();
            var yzm    = $("#yzm").val();
            if(tid == ""){
                alert('请输入推荐人ID');
                return false;
            }
            if(username == ""){
                alert('请输入用户名');
                return false;
            }
            if(utel == ""){
                alert('请输入手机号码');
                return false;
            }
            var tel = /^1([38]\d|4[57]|5[0-35-9]|7[06-8]|8[89])\d{8}$/;
            if(!tel.test(utel)){
                alert("手机号输入有误");
                return false;
            }
            if(yzm == ""){
                alert('请输入验证码');
                return false;
            }
            if(yzm!==code){
                alert('验证码错误!');
                return false;
            }
            if(password <6 || password>20){
                alert('请输入正确的密码');
                return false;
            }



            $("form :input.text").trigger('blur');
            var numError = $('form .onError').length;
            if(numError){
                return false;
            }
            $("#reviseForm").submit();
        }
    </script>


 </div>     
</body>
</html>