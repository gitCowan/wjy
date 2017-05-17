<?php
$ytfpay = M('pay')->where(array('type'=>'ytfpay'))->find();
//商户号（6位数字）
$shan_config['user_seller'] = $ytfpay['pid'];
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者PID，签约账号，由16位纯数字组成的字符串，请登录商户后台查看
$shan_config['partner']		= $ytfpay['partner'];
// MD5密钥，安全检验码，由数字和字母组成的32位字符串，请登录商户后台查看
$shan_config['key']			=  $ytfpay['key'];
// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$shan_config['notify_url'] = "http://".$_SERVER['SERVER_NAME']."/index.php/Home/User/succ2.html";
// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$shan_config['return_url'] = "http://".$_SERVER['SERVER_NAME']."/index.php/Home/User/succ1.html";
//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

?>