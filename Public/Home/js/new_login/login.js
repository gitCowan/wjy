    $('#password').on('input propertychange',
    function() {
        $("#login_btn").removeClass("btn-dis");
    });
    function check_data() {
        var tel = $("#username").val();
        var passwd = $("#password").val();
        if (tel == "") {
            showLoading('请输入手机号', 2000);
            return false;
        } else {
            if (!$("#username").val().match(/^(((1[0|3|4|5|7|8][0-9]{1}))+\d{8})$/)) {
                showLoading('手机号不正确', 2000);
                return false;
            }
        }
        if (passwd == "") {
            showLoading('请输入密码', 2000);
            return false;
        }
        if (passwd.length < 6 || passwd.length > 20) {
           showLoading('请输入大于6位小于20位的密码', 2000);
            return false;
        }
        return true;
    }
