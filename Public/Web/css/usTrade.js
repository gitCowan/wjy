/**
 * Created by liumin3 on 2016/7/4.
 */

var isHasLoadDealer = false;
var uscode;

//登录美股券商
function loginUsstock()
{
    var username = $("#usernameUS").val();
    var password = $("#passwordUS").val();
    var checkCode = $("#checkCodeUS").val();

    if(uscode=='' || uscode== null)
    {
        $("#uslogindealererror").html("请选择证券公司");
        $("#uslogindealererror").show();
        return;
    }
    $("#uslogindealererror").hide();

    if(username=='')
    {

        $("#usloginusererror").html("请输入用户名");
        $("#usloginusererror").show();
        return;
    }
    $("#usloginusererror").hide();

    if(password=='')
    {
        $("#usloginpwderror").html("请输入交易密码");
        $("#usloginpwderror").show();
        return;
    }
    $("#usloginpwderror").hide();

    if(checkCode=='')
    {
        $("#uslogincodeerror").html("请输入验证码");
        $("#uslogincodeerror").show();
        return;
    }
    $("#uslogincodeerror").hide();



    //记住我的功能
    var isremme = 0;
    if($("#usremme").attr("checked")=='checked')
    {
        isremme=1;
    }
    $.ajax({
        type:'post',
        dataType:'json',
        url:'/usTrade/login',
        data:{dealerCode:uscode,password:password,username:username,checkCode:checkCode,isremme:isremme},
        success:function (msg)
        {
            if(msg.code==1)
            {
                //刷新当前页面
                window.location.reload();
            }else
            {
                //给出错误提示信息
                if(msg.code==1007) //用户名不存在
                {
                    $("#usloginusererror").html("请输入用户名");
                    $("#usloginusererror").show();
                    return;
                }
                if(msg.code==1009) //用户名不存在
                {
                    $("#usloginusererror").html("用户名或者密码错误，请重新输入");//用户名不存在
                    $("#usloginusererror").show();
                    return;
                }
                $("#usloginusererror").hide();

                if(msg.code==1008) //密码错误
                {
                    $("#usloginpwderror").html("请输入交易密码");
                    $("#usloginpwderror").show();
                    return;
                }

                if(msg.code==1029) //密码错误
                {
                    $("#usloginpwderror").html("密码错误");
                    $("#usloginpwderror").show();
                    return;
                }
                $("#usloginpwderror").hide();
                if(msg.code==-11)
                {
                    $("#uslogincodeerror").html("验证码错误");
                    $("#uslogincodeerror").show();
                    return;
                }
                $("#uslogincodeerror").hide();
            }
        },
        error:function(msg)
        {


        }
    });
}

function getUsRem(dealerCode)
{
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/usTrade/getUsRem',
        data:{dealerCode:dealerCode},
        success: function (msg)
        {
            if(msg.code==0)
            {
                $("#usernameUS").val(msg.data);
            }else
            {
                $("#usernameUS").val("");
            }
        },
        error: function (msg) {
        }
    });
}


//展示所有美股券商
function showAllUsdealer(event)
{


    $("#dealerShow").trigger("click");
    if(!isHasLoadDealer)//还没加载
    {
        isHasLoadDealer = true;
        $.ajax({
            type:'get',
            dataType:'json',
            url:'/usTrade/getDealers',
            success:function (msg)
            {
                if(msg.code==1)
                {
                    //判断是否有可以登录的券商
                    if(msg.data.length==0)
                    {
                        $("#usloginshow").text("美股券商维护中，请稍后再试!");
                    }else
                    {
                        var arr = msg.data;
                        for (var d in arr)
                        {
                            var l = '<li onclick="selectusDealer.call(this)"  uscode="'+arr[d].dealerCode+'" logoo="'+arr[d].logo4+'"><span class="fund-logos" style="background-image: url('+ arr[d].logo4+');width:120px;height:38px;"></span></li>';
                            $('#allUsdealers').append(l);
                        }
                    }

                    $("#allUsdealers").show();
                    isHasLoadDealer = true;
                }else{
                    isHasLoadDealer = false;
                }
            },
            error:function(msg)
            {
                isHasLoadDealer = false;
            }
        });
    }else//已经加载
    {
        if($("#allUsdealers").css("display")=="block")
        {
            $("#allUsdealers").hide();
        }else
        {

            $("#allUsdealers").show();
        }
    }
    window.event?window.event.cancelBubble=true:event.stopPropagation();

}

//选择一个美股券商
function selectusDealer()
{
    $("#allUsdealers").hide();
    uscode=$(this).attr("uscode");
    var logoo = $(this).attr("logoo");
    $("#selectedDealer").html('<span class="fund-logo" style="background-image: url('+ logoo+');width:120px;height:38px;"></span>');

    $(".security-select").removeAttr("style");
    $("#uslogindealererror").html("");

    getUsRem(uscode);
}


//刷新美股登录验证码
function reloadUsCheckCode()
{
    $.get("/index/code/code.html",function(data){
        console.log(data);
    });
}