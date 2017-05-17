<?php
namespace Home\Controller;

use Think\Controller;

class UserController extends Controller
{

    public function _initialize(){
        //$tpl = M('webconfig')->getfield('tpl');
        $this->assign('tpl','2');
    }
    /**
     * 析构流函数
     */
    public function  __construct() {
        parent::__construct();
        require_once  ("payment/weixin/weixin.class.php");
        $code = '\\weixin';
        $this->payment = new $code();
    }
    public function login(){
        if(IS_POST){
            $this->post();
        }else{
            if(!session('uid')){
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                if (strpos($user_agent, 'MicroMessenger') === false) {
                    //非微信浏览器禁止浏览
                    $this->display();
                } else {
                    if($_GET['pid']){
                        cookie('pid',$_GET['pid']);
                    }
                    R('Home/Oauth/index',array(ACTION_NAME,$_GET));
                }
            }else{
                $this->redirect('Home/Index/index');
            }
        }
    }

    public function login_type($type = null){
        empty($type) && $this->error('参数错误');

        //加载ThinkOauth类并实例化一个对象
        import("ORG.ThinkSDK.ThinkOauth");
        $sns  = \ThinkOauth::getInstance($type);

        //跳转到授权页面
        redirect($sns->getRequestCodeURL());
    }
    //授权回调地址
    public function callback($type = null, $code = null){
        (empty($type) || empty($code)) && $this->error('参数错误');
        //加载ThinkOauth类并实例化一个对象
        import("ORG.ThinkSDK.ThinkOauth");
        $sns  = ThinkOauth::getInstance($type);

        //腾讯微博需传递的额外参数
        $extend = null;
        if($type == 'tencent'){
            $extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
        }

        //请妥善保管这里获取到的Token信息，方便以后API调用
        //调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
        //如： $qq = ThinkOauth::getInstance('qq', $token);
        $token = $sns->getAccessToken($code , $extend);

        //获取当前登录用户信息
        if(is_array($token)){
            $user_info = A('Type', 'Event')->$type($token);

            $this->redirect('Index/index',array('type'=>$type,'openid'=>$user_info['openid']));
        }
    }
    public function post(){
        //微信登陆

        //post登陆提交
        if (I('post.username')!='' && I('post.password')!='') {
            // 实例化Login对象
            $user = D('userinfo');
            $where = array();
            $where['username|utel'] = I('post.username');
            $result = $user->where($where)->field('uid,username,upwd,utel,utime')->find();
            // 验证用户名 对比 密码
            if ($result['upwd'] === md5(I('post.password'))) {
                // 存储session
                session('uid', $result['uid']);          // 当前用户id
                session('husername', $result['username']);   // 当前用户昵称
                // 更新用户登录信息
                $dd['lastlog']=time();
                if($_GET['openid']){
                    $dd['openid']=$result['openid'].'|'.$_GET['openid'];
                }
                $user->where('uid='.$result['uid'])->save($dd);
                $where['uid'] = session('uid');
                $this->redirect('Index/index');
            } else {
                $this->error('用户名或密码不正确!');
            }
        }

    }

    //找回密码页面
    public function forget_passwd()
    {
        if(IS_POST) {
            $user = D('userinfo');
            $data['utel'] = I('post.utel');
            $data['upwd'] = md5(I('post.upwd'));
            $userData = $user->where('utel=' . $data['utel'])->find();
            if ($userData) {
                $user->where('utel=' . $data['utel'])->save($data);
                //添加对应的session
                session('uid', $userData['uid']);          // 当前用户id
                session('husername', $userData['username']);   // 当前用户昵称
                $this->success('修改密码成功',U('Index/index'));
            } else {
                $this->error('该手机号没有注册过了', U('User/login'));
            }
        }
        $this->display();

    }
    //注册页面
    public function reg()
    {
        $openid=I('get.openid');
        $oid = I('get.oid');
        $this->assign('openid',$openid);
        $this->assign('oid',$oid);
        $this->display();

    }
    //注册
    public function register()
    {
        if(IS_POST)
        {// 判断提交方式 做不同处理
            // 实例化User对象
            $user = D('userinfo');
            //检查用户名
            header("Content-type: text/html; charset=utf-8");
            //检查手机验证码
            $code = $this->mescontent();
            /**
             * 推广链接时需要在注册时添加一个获取oid的方法，添加进去，作为上线的记录。
             */
            $data['username'] = I('post.username');
            $data['utel']     = I('post.utel');
            $data['utime']    = date(time());
            $data['upwd']     = md5(I('post.upwd'));
            $data['oid']      = I('post.oid');
            if($_GET['openid']){
                $data['openid']=I('get.openid');
            }
            $uname = $user->where(array('username'=>$data['username']))->find();
            if($uname){
                $this->error('用户名已存在',U('Index/reg'));
            }else{
//                    插入数据库
                $utel = $user->where('utel='.$data['utel'])->find();
                if($utel){
                    $this->error('该手机号已经注册过了',U('User/login'));
                }else{
                    if ($uid = $user->add($data)) {
                        $aww = $user->where(array('uid'=>$data['oid']))->find();
                        if($aww){
                            $avv = $aww['cid'].$uid.'|';
                        }else{
                            $avv = '|'.$uid.'|';
                        }
                        $user->where(array('uid'=>$uid))->save(array('cid'=>$avv));
                        //添加对应的金额表
                        session('uid', $uid);          // 当前用户id
                        session('husername', $data['username']);   // 当前用户昵称
                        $acc['uid'] = $uid;
                        if(M('accountinfo')->where(array('uid'=>$uid))->find()){

                        }else{
                            $aid = M('accountinfo')->add($acc);
                        }
                        if(I('post.oid')){
                            S('tree_num'.I('post.oid'),null);
                        }
                        S('tree_num'.$uid,null);
                        $this->success('注册成功',U('Index/index'));
                    } else {
                        $this->error('注册失败',U('User/login'));
                    }
                }
            }


        }

    }
    //设置初始密码，密码后台可以修改。这里需要创建资金表，创建详细信息表。
    public function myreg(){

        $userinfo=M('userinfo');
        $openid=I('post.openid');
        $user=$userinfo->where("openid='".$openid."'")->find();
        $data['uid']=$user['uid'];
        $data['utime'] = date(time());
        $data['upwd'] = md5(I('post.upwd') . date(time()));
        $data['wxtype']='0';
        if($userinfo->save($data)){
            $brok['uid']=$user['uid'];
            $brok['brokerid']=I('post.brokerid');
            M('managerinfo')->add($brok);
            $accid['uid']=$user['uid'];
            $accid['pwd']=I('post.upwd');
            if(M('accountinfo')->where(array('uid'=>$user['uid']))->find()){
                M('accountinfo')->where(array('uid'=>$user['uid']))->save($accid);
            }else{
                M('accountinfo')->add($accid);
            }

            $this->redirect('User/login');
        }else{
            $this->error('设置失败，请联系管理员');
        }


    }

    public function check($name){
        if(!session('uid')){
            $oauth=A('Home/Oauth');
            $oauth->index($name,$_GET);
        }
    }

    //发展下线
    public function offline(){
        $uid = session('uid');
        $userinfo = R('Home/Common/userinfo',array($uid));
        $signPackage=R('Home/Common/wap_index');
        /* -----------------生成普通二维码 */
        include 'phpqrcode.php';
        $confirm = $userinfo['uid'];
        $value = 'http://'.$_SERVER['SERVER_NAME'].'/index.php/Home/User/login/pid/'.$confirm.'.html';
        //二维码内容
        $errorCorrectionLevel = 'L';//容错级别
        $matrixPointSize = 4.5;//生成图片大小
        //生成二维码图片
        \QRcode::png($value, './Uploads/ucode/qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);
        $logo = './Uploads/ucode/logo.png';//准备好的logo图片
        $QR = './Uploads/ucode/qrcode.png';//已经生成的原始二维码图
        if ($logo !== FALSE) {
            $QR = imagecreatefromstring(file_get_contents($QR));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度
            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width/$logo_qr_width;
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
            $logo_qr_height, $logo_width, $logo_height);
        }
        //输出图片
        imagepng($QR, './Uploads/ucode/'.$confirm.'.png');
        $code='/Uploads/ucode/'.$confirm.'.png';
        $this->assign('code',$code);
        /* -----------------生成普通二维码 */
        $this->assign('signPackage',$signPackage);
        $this->assign('userinfo',$userinfo);
        $this->display();
    }

    //生成随机六位验证码

    public function mescontent()
    {

        $CheckCode = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        return $CheckCode;

    }


    //会员中心
    public function memberinfo()
    {
        $this->userlogin();
        $uid    = session('uid');
        $result = M('accountinfo')->where('uid=' . $uid)->find();
        $suer   = M('userinfo')->where('uid='. $uid)->find();
        $isopen = R('Home/Index/isopen');
        $this->assign('result', $result);
        $this->assign('isopen', $isopen);
        $this->assign('suer', $suer);
        $this->display();
    }

    //修改密码
    public function edituserb()
    {
        $this->userlogin();
        if (IS_POST) {
            $data['uid'] = session('uid');
            $user = M('userinfo')->where($data)->find();
            if ($user['upwd'] === md5(I('post.upwd'))) {
                $edit = M('userinfo');
                if ($edit->create()) {
                    $edit->uid = session('uid');
                    $edit->utime = date(time());
                    $edit->upwd = md5(I('post.mypwdb'));
                    $edituser = $edit->save();
                    if ($edituser) {
                        redirect(U('User/memberinfo'), 1, '密码修改成功...');
                    } else {
                        $this->error('密码修改失败，请重新修改');
                    }
                }
            } else {
                $this->error('原密码不正确，请重新输入');
            }
        }
        $this->display();
    }

    //退出登录
    public function logout()
    {
        // 清楚所有session
        session(null);
        $this->redirect('User/login');

    }

    //账户提现
    public function cash()
    {
        $this->userlogin();
        $account = D('accountinfo');
        $balance = D('balance');
        $bankinfo = D('bankinfo');
        $bournal = D('bournal');
        $uid = session('uid');
        $username = $_SESSION['husername'];
        if(IS_POST){
            //交易密码
            $bpwd = $account->field('pwd,balance')->where('uid='.$uid)->find();
            $pwd = I('post.pwd');
            $banknumber = I('post.banknumber');
            $bankname = I('post.bankname');
            $province = I('post.province');
            $city = I('post.city');
            $branch = I('post.branch');
            $busername = I('post.busername');
            $bpprice = I('post.bpprice');
            if(strlen($banknumber)==16||strlen($banknumber)==19){
                $detailed = A('Home/Detailed');
                //提现表
                $balances['bptype'] = '提现';
                $balances['bptime'] = date(time());
                $balances['bpprice'] = $bpprice;
                $balances['uid'] = $uid;
                $balances['isverified'] = 0;
                //提现记录
                $bournals['btype'] = '提现';
                $bournals['btime'] = date(time());
                $bournals['bprice'] = $bpprice;
                $bournals['uid'] = $uid;
                $bournals['username'] = $username;
                $bournals['isverified'] = 0;
                $bournals['bno'] = $detailed->build_order_no();
                $bournals['balance'] = $bpwd['balance']-$bpprice;
                //银行卡信息，添加或修改
                $banks['bankname'] = $bankname;
                $banks['province'] = $province;
                $banks['city'] = $city;
                $banks['branch'] = $branch;
                $banks['banknumber'] = $banknumber;
                $banks['busername'] = $busername;
                //插入提现记录
                $balance_result = $balance->add($balances);
                $bournal_result = $bournal->add($bournals);
                //查询银行卡表所有用户id数组
                $uidcount = $bankinfo->where('uid='.$uid)->count();
                //判断uid是否已经存在银行卡表内，存在插入数据，不存在修改数据
                if($uidcount==1){
                    //查询用户银行卡表的bid
                    $bid = $bankinfo->field('bid')->where('uid='.$uid)->find();
                    $bankinfo->where('bid='.$bid['bid'])->save($banks);
                }else{
                    $banks['uid'] = $uid;
                    $bankinfo->add($banks);
                }
                if($balance_result){
                    $accounts['balance'] = $bpwd['balance']-$bpprice;
                    $account->where('uid='.$uid)->save($accounts);
                    $this->ajaxReturn();
                }else{
                    $this->ajaxReturn("0");
                }
            }else{
                $this->ajaxReturn("10");
            }

        }else{
            //账户余额
            $totle = $account->field('balance')->where('uid='.$uid)->find();
            //银行信息
            $binfo = $bankinfo->where('uid='.$uid)->find();

            $this->assign('binfo',$binfo);
            $this->assign('totle',$totle);
            $this->display();
        }
    }
    function iyi_pay($ordersn,$price,$zhifu){

        $url = "https://vip.iyibank.com/pay/gateway";  //接口请求地址
        $nonce_str = mt_rand(time(),time()+rand());
        $signature = "key=379bcb4ff56b432bb7f090c4e9988338";//密钥
        $arr['service']    =  $zhifu;    //接口类型 :  支付宝cibalipay，微信cibweixin
        $arr['version']    =  "1.0";       //版本号
        $arr['charset']    =  "utf-8";      //字符集
        $arr['sign_type']  =  "MD5";       //签名方式
        //商户号、密钥请用商户自己的，此为测试商户号，如果用测试商户号测试，请把金额改为0.01，测试所收款概不退还。请商户调试时注意
        $arr['mch_id']        =  "10812";            //商户号
        $arr['out_trade_no']=  $ordersn;     //商户订单号
        $arr['body']      =  "会员充值";    //商品描述
        $arr['total_fee']  =  $price;       //金额
        $arr['mch_create_ip']  =  "127.0.0.1";   //终端IP
        $arr['notify_url'] =  "http://ssp.bajiaoxinxi.cn/Wap/Wxpay/notify_iyi";  //通知地址
        $arr['callback_url']=  "http://ssp.bajiaoxinxi.cn";   //支付完成跳转地址
        $arr['nonce_str']  =  $nonce_str;    //随机数

        ksort($arr);//对数组进行排序
        //遍历数组进行字符串的拼接
        $temp = "";
        foreach ($arr as $x=>$x_value){
            if ($x_value != null){
                $temp = $temp.$x."=".$x_value."&";
            }
        }
        //echo '原始签名串----'.$temp;
        //MD5转码
        $arr['sign']=strtoupper(md5($temp.$signature));
        // $arr['sign'] = $temp.'sign'.'='.$md5;
        // echo "<pre>";
        // var_dump($arr);die;

        $xmls = "<xml>";
        //遍历数组进行xml的拼接
        foreach ($arr as $k=>$v){
            if ($v != null){
                if($k == 'body'){
                    $xmls .= '<body>'.$v.'</body>';
                }else{
                    $xmls .= '<'.$k.'>'.$v.'</'.$k.'>';
                }
            }
        }
        $xmls.='</xml>';
        //print_r($xmls);die;
        //echo '请求XML-----'.$xmls.='</xml>';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$url);//设置抓取的url
        curl_setopt($curl, CURLOPT_HEADER, false);//设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_POST, 1);//设置post方式提交
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmls);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($curl);//执行命令

        curl_close($curl);//关闭URL请求
        //echo ' 返回-----' .$data;//显示获得的数据
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        //print_r($values['token_id']);exit;
        //exit("<img src='" . $values['token_id'] ."' width='500px' align='middle'/>");

        $this->assign('img_src',$values['token_id']);
        $this->assign('ordersn',$ordersn);
        $this->display("iyi_pay");
    }
    //爱益充值
    public function recharge_iyi()
    {

    }
    //账户充值
    public function recharge()
    {
        $this->userlogin();
        $uid = session('uid');
        $result = M('accountinfo')->where('uid='. $uid)->find();
        $suer = M('userinfo')->where('uid='.$uid)->find();
        $this->assign('result', $result);
        $this->assign('suer', $suer);
        $pay=M('pay')->select();
        $this->assign('pay',$pay);
        $this->assign('style','1');

        $payst = M('pay')->where(array('status'=>1))->find();
        $this->assign('payst',$payst);
        if (IS_POST) {

            $orderid = $this->build_order_no();

            $this->assign('style','2');
            $date['bpprice']=I('post.tfee1');
            $date['bpno']=$orderid;
            $date['uid']=$uid;
            $date['bptype']='充值';
            $date['bptime']=date(time());
            $date['remarks']='开始充值';
            $balanceid=M('balance')->add($date);
            $blanktype=I('post.bankname');
            if($payst['type'] == 'wanjio'){
                $url = "https://vip.iyibank.com/pay/gateway";  //接口请求地址
                $nonce_str = mt_rand(time(),time()+rand());
                $signature = "key=16616e1d3ee64dd79cdab9ff09746da3";//密钥
                if($blanktype=='WXZF'){ //接口类型 :  支付宝cibalipay，微信cibweixin
                    $arr['service']='cibweixin';
                }else if($blanktype=='ZFB'){
                    $arr['service']='cibalipay' ;
                }
                $arr['version']    =  "1.0";       //版本号
                $arr['charset']    =  "utf-8";      //字符集
                $arr['sign_type']  =  "MD5";       //签名方式
                //商户号、密钥请用商户自己的，此为测试商户号，如果用测试商户号测试，请把金额改为0.01，测试所收款概不退还。请商户调试时注意
                $arr['mch_id']        =  "10812";            //商户号
                $arr['out_trade_no']=  $orderid;     //商户订单号
                $arr['body']      =  "会员充值";    //商品描述
                $arr['total_fee']  =  I('post.tfee1');       //金额
                $arr['mch_create_ip']  =  "127.0.0.1";   //终端IP
                $arr['notify_url'] =  "http://".$_SERVER['HTTP_HOST']."/index.php/Home/User/notify_iyi";  //通知地址
                $arr['callback_url']=  "http://".$_SERVER['HTTP_HOST']."/index.php";   //支付完成跳转地址
                $arr['nonce_str']  =  $nonce_str;    //随机数

                ksort($arr);//对数组进行排序
                //遍历数组进行字符串的拼接
                $temp = "";
                foreach ($arr as $x=>$x_value){
                    if ($x_value != null){
                        $temp = $temp.$x."=".$x_value."&";
                    }
                }
                //echo '原始签名串----'.$temp;
                //MD5转码
                $arr['sign']=strtoupper(md5($temp.$signature));
                $xmls = "<xml>";
                //遍历数组进行xml的拼接
                foreach ($arr as $k=>$v){
                    if ($v != null){
                        if($k == 'body'){
                            $xmls .= '<body>'.$v.'</body>';
                        }else{
                            $xmls .= '<'.$k.'>'.$v.'</'.$k.'>';
                        }
                    }
                }
                $xmls.='</xml>';
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL,$url);//设置抓取的url
                curl_setopt($curl, CURLOPT_HEADER, false);//设置头文件的信息作为数据流输出
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回，而不是直接输出。
                curl_setopt($curl, CURLOPT_POST, 1);//设置post方式提交
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
                curl_setopt($curl, CURLOPT_POSTFIELDS, $xmls);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                $data = curl_exec($curl);//执行命令

                curl_close($curl);//关闭URL请求
                libxml_disable_entity_loader(true);
                $values = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
                $this->assign('img_src',$values['token_id']);
                $this->display("iyi_pay");
            }
        }else{
            $this->display();
        }
    }
    public function sign($requestarray,$Md5key){
        ksort($requestarray);
        reset($requestarray);
        $md5str = "";
        foreach ($requestarray as $key => $val) {
            $md5str = $md5str . $key . "=>" . $val . "&";
        }
        //echo($md5str . "key=" . $Md5key."<br>");
        $sign = strtoupper(md5($md5str . "key=" . $Md5key));
        return $sign;
    }
    //处理支付后的结果，加钱
    public function notify_1(){
        $balance=M('balance')->where(array('bpno'=>$_GET['orderid']))->find();
        //	$date['bpno']=$balance['bpno'];
        $date['remarks']='充值成功-万嘉';
        $style=M('balance')->where(array('bpid'=>$balance['bpid']))->save($date);
        //修改客户的帐号余额
        $userprice=M('accountinfo')->where(array('uid'=>$balance['uid']))->find();
        $mydate['balance']=$balance['bpprice']+$userprice['balance'];
        $data=M('accountinfo')->where(array('uid'=>$balance['uid']))->save($mydate);
        if($data){
            echo 'OK';
        }
    }
    public function notify_iyi(){

        $input =file_get_contents("php://input"); //接收POST数据
        $postarr = $this ->xmlToArray($input);
        ksort($postarr);
        $postbuff = "";
        foreach ($postarr as $x=>$x_value)
        {
            if($x != "sign" &&  $x_value != ""&& !is_array($x_value)){
                $postbuff .= $x . "=" .  $x_value . "&";
            }
        }
        $encodeStr=strtoupper(md5($postbuff."key=16616e1d3ee64dd79cdab9ff09746da3"));
        if(strtoupper($postarr['sign'])==strtoupper($encodeStr))
        {
            if($postarr['result_code']=="0") //支付成功
            {
                $balance=M('balance')->where(array('bpno'=>$postarr['out_trade_no']))->find();
                //修改订单状态
                if($balance["remarks"]=='充值成功-爱益支付'){
                    echo "SUCCESS";
                }else{
                    $date['remarks']='充值成功-爱益支付';
                    M('balance')->where(array('bpid'=>$balance['bpid']))->save($date);
                    //修改客户的帐号余额
                    $userprice=M('accountinfo')->where(array('uid'=>$balance['uid']))->find();
                    $mydate['balance']=$balance['bpprice']+$userprice['balance'];
                    M('accountinfo')->where(array('uid'=>$balance['uid']))->save($mydate);
                    echo "SUCCESS";
                }
            }
            else
            {
                echo "支付失败";
            }
        }
        else
        {
            echo "签名验证失败";
        }
    }
    function xmlToArray($xml){
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring),true);
        return $val;
    }

    //获取用户收入排行
    public function ranking(){
        $this->userlogin();
        $order=M('order');
        //$userinfo=M('userinfo')->select();
        $tq=C('DB_PREFIX');
        // foreach ($userinfo as $k => $v) {
        $list=$order->field('sum('.$tq.'order.ploss) as pric,'.$tq.'order.uid')->group($tq.'order.uid')->order('sum('.$tq.'order.ploss) desc')->limit(10)->select();
        $lists=array();
        foreach ($list as $k => $v) {
            $lists[$k]=$v;
            $username=M('userinfo')->field('username','portrait')->where('uid='.$v['uid'])->find();
            $lists[$k]['name']=$username['username'];
            $lists[$k]['portrait']=$username['portrait'];
        }
        $this->assign('lists',$lists);
        $this->display();
    }
    //体验卷列表
    public function experiencelist()
    {
        $this->userlogin();
        $uid = session('uid');
        $tq = C('DB_PREFIX');
        $endtime = date(time());

        // $list=M('experience')->join($tq.'experienceinfo on'.$tq.'experienceinfo.exid=' . $tq . 'experience.eid')->select();

        $list=M('experienceinfo')->join($tq.'experience on '.$tq.'experienceinfo.eid='.$tq.'experience.eid')->where($tq.'experienceinfo.uid='.$uid.' and '.$endtime.' < '.$tq.'experienceinfo.endtime and '.$tq.'experienceinfo.getstyle=0')->select();


        $this->assign('list', $list);
        $this->display();
    }


    //体验卷列表
    public function alist()
    {
        $this->userlogin();
        $uid = session('uid');
        $tq = C('DB_PREFIX');
        $endtime = date(time());
        $alist = M('experience')->where(  $endtime . ' < ' . $tq . 'experience.endtime')->select();
        $this->assign('alist', $alist);
        $this->display();
    }





    //体验卷详情页
    public function experienceid()
    {
        $this->userlogin();
        $eid = I('eid');
        $expid = M('experienceinfo')->where('exid=' . $eid)->find();
        $eprice=M('experience')->where('eid='.$expid['eid'])->find();
        $expid['eprice']=$eprice['eprice'];
        //print_r($expid);die;
        $this->assign('expid', $expid);
        $this->display();
    }

    public function userlogin()
    {
        //判断用户是否已经登录
        if (!session('uid')) {
            $this->redirect('User/login');
        }
    }
    public function img(){
        $this->userlogin();
        $hostlink= $_SERVER['HTTP_HOST'];
        $url=  $hostlink.U('User/reg')."?uid=".session('uid');
        $this->assign('url', $url);
        $this->display();
    }

    //随机生成订单编号
    function build_order_no(){
        return date(time()).substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 3);
    }

    //扫码支付
    public function code()
    {
        //使用统一支付接口
        vendor('WxPayPubHelper.WxPayPubHelper');
        $unifiedOrder = new \UnifiedOrder_pub();
        //设置统一支付接口参数
        //设置必填参数
        $timeStamp = time();
        $date['bpprice']=I('get.tfee1');
        $date['bpno']=$timeStamp;
        $date['uid']=session('uid');
        $date['bptype']='充值';
        $date['bptime']=date(time());
        $date['remarks']='开始充值';

        $balanceid=M('balance')->add($date);


        $unifiedOrder->setParameter("body","帐号充值 ");//商品描述
        //自定义订单号，此处仅作举例

        $out_trade_no = "$timeStamp";
        $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
        // $unifiedOrder->setParameter("total_fee","1");//总金额
        $unifiedOrder->setParameter("total_fee",$date['bpprice']*100);//总金额
        $unifiedOrder->setParameter("notify_url", 'http://'.$_SERVER['SERVER_NAME'].'/index.php/Home/User/notify');//通知地址 
        $unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
        //非必填参数，商户可根据实际情况选填
        //获取统一支付接口结果
        $unifiedOrderResult = $unifiedOrder->getResult();
        // var_dump($unifiedOrder);
        //商户根据实际情况设置相应的处理流程
        if ($unifiedOrderResult["return_code"] == "FAIL")
        {
            //商户自行增加处理流程
            echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
        }
        elseif($unifiedOrderResult["result_code"] == "FAIL")
        {
            //商户自行增加处理流程
            echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
            echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
        }
        elseif($unifiedOrderResult["code_url"] != NULL)
        {
            //从统一支付接口获取到code_url
            $code_url = $unifiedOrderResult["code_url"];

            //商户自行增加处理流程
            //......
        }
        $data['url']=$code_url;
        $data['order']=$out_trade_no;
        $this->ajaxReturn($data);
    }
    public function notify(){
        vendor('WxPayPubHelper.WxPayPubHelper');
        $notify = new \Notify_pub();
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        if($xml['result_code'] == "SUCCESS" ){
            $balance=M('balance')->where(array('bpno'=>$xml['out_trade_no']))->find();
            //判断订单是否存在，并且判断是否是同一个人操作
            // if ($balance&&$balance['uid']==session('uid')) {
            $date['bpno']=$balance['bpno'];
            $date['remarks']='充值成功01';
            $style=M('balance')->where(array('bpno'=>$xml['out_trade_no']))->save($date);
            //修改客户的帐号余额
            if ($style) {
                $userprice=M('accountinfo')->where(array('uid'=>$balance['uid']))->find();
                $mydate['balance']=$balance['bpprice']+$userprice['balance'];
                M('accountinfo')->where(array('uid'=>$balance['uid']))->save($mydate);
            }
            // }
        }
    }
    public function orderQuery()
    {
        //退款的订单号
        if (!isset($_GET["out_trade_no"]))
        {
            $out_trade_no = " ";
        }else{
            $out_trade_no = $_GET["out_trade_no"];
            vendor('WxPayPubHelper.WxPayPubHelper');
            //使用订单查询接口
            $orderQuery = new \OrderQuery_pub();
            //设置必填参数
            //appid已填,商户无需重复填写
            //mch_id已填,商户无需重复填写
            //noncestr已填,商户无需重复填写
            //sign已填,商户无需重复填写
            $orderQuery->setParameter("out_trade_no","$out_trade_no");//商户订单号
            //非必填参数，商户可根据实际情况选填
            //$orderQuery->setParameter("sub_mch_id","XXXX");//子商户号
            //$orderQuery->setParameter("transaction_id","XXXX");//微信订单号

            //获取订单查询结果
            $orderQueryResult = $orderQuery->getResult();
            //print_r($orderQueryResult);die;
            //商户根据实际情况设置相应的处理流程,此处仅作举例
            if ($orderQueryResult["return_code"] == "FAIL") {
                $this->error($out_trade_no);
            }
            elseif($orderQueryResult["result_code"] == "FAIL"){
//     			$this->ajaxReturn('','支付失败！',0);
                $this->error($out_trade_no);
            }
            else{
                $i=$_SESSION['i'];
                $i--;
                $_SESSION['i'] = $i;
                //判断交易状态
                switch ($orderQueryResult["trade_state"])
                {
                    case SUCCESS:
                        $SUCCESS="支付成功";
                        break;
                    case REFUND:
                        $SUCCESS="超时关闭订单";
                        break;
                    case NOTPAY:
                        $SUCCESS="超时关闭订单";
                        break;
                    case CLOSED:
                        $SUCCESS="超时关闭订单";
                        break;
                    case PAYERROR:
                        $SUCCESS="支付失败";
                        break;
                    default:
                        $SUCCESS="未知失败";
                        break;
                }
                // F('dasd'.rand(),$SUCCESS);
                if($SUCCESS == '支付成功'){
                    $balance=M('balance')->where(array('bpno'=>$orderQueryResult['out_trade_no']))->find();
                    // 判断订单是否存在，并且判断是否是同一个人操作
                    // if ($balance&&$balance['uid']==session('uid')) {
                    $date['bpno']=$balance['bpno'];
                    $date['remarks']='充值成功-微信独立支付';
                    $style=M('balance')->where(array('bpno'=>$orderQueryResult['out_trade_no']))->save($date);
                    // 修改客户的帐号余额
                    if ($style) {
                        $userprice=M('accountinfo')->where(array('uid'=>$balance['uid']))->find();
                        $mydate['balance']=$balance['bpprice']+$userprice['balance'];
                        M('accountinfo')->where(array('uid'=>$balance['uid']))->save($mydate);
                    }
                    // }
                }
            }
            $this->ajaxReturn($SUCCESS);
        }
    }

    public function paylist(){
        $uid = session('uid');
        $userinfo = R('Home/Common/userinfo',array($uid));
        $user = R('Home/Common/accountinfo',array($uid));
        $userinfo['balance'] = $user['balance'];
        $code = M('webconfig')->where(array('id'=>1))->getfield('code');
        $this->assign('code',$code);
        $this->assign('userinfo',$userinfo);
        $this->display();
    }




    public function paytixian(){
        $uid = session('uid');
        $account = D('accountinfo');
        $balance = D('balance');
        $bournal = D('bournal');
        if(IS_POST){
            //交易密码
            $bpwd = $account->field('balance')->where('uid='.$uid)->find();
            $bpprice = I('post.bpprice');
            $detailed = A('Home/Detailed');
            //提现表
            $balances['bptype'] = '提现';
            $balances['bptime'] = date(time());
            $balances['bpprice'] = $bpprice;
            $balances['uid'] = $uid;
            $balances['isverified'] = 0;
            //提现记录
            $bournals['btype'] = '提现';
            $bournals['btime'] = date(time());
            $bournals['bprice'] = $bpprice;
            $bournals['uid'] = $uid;
            $bournals['isverified'] = 0;
            $bournals['bno'] = $detailed->build_order_no();
            $bournals['balance'] = $bpwd['balance']-$bpprice;
            //插入提现记录
            $balance_result = $balance->add($balances);
            $bournal_result = $bournal->add($bournals);
            if($balance_result){
                $accounts['balance'] = $bpwd['balance']-$bpprice;
                $account->where('uid='.$uid)->save($accounts);
                $this->ajaxReturn("1");
            }else{
                $this->ajaxReturn("0");
            }
        }else{
            $userinfo = R('Home/Common/userinfo',array($uid));
            $user = R('Home/Common/accountinfo',array($uid));
            $userinfo['balance'] = $user['balance'];
            $this->assign('userinfo',$userinfo);
            $this->display();
        }
    }

    public function succ1(){
        require_once ('/ytfpay/shanpayconfig.php');
        require_once ('/ytfpay/lib/shanpayfunction.php');
        //计算得出通知验证结果
        $shanNotify = md5VerifyShan($_REQUEST['out_order_no'],$_REQUEST['total_fee'],$_REQUEST['trade_status'],$_REQUEST['sign'],$shan_config['key'],$shan_config['partner']);
        if($shanNotify) {//验证成功
            if($_REQUEST['trade_status']=='TRADE_SUCCESS'){
                //商户订单号
                $out_trade_no = $_REQUEST['out_order_no'];
                $balance=M('balance')->where(array('bpno'=>$out_trade_no))->find();
                //判断订单是否存在，并且判断是否是同一个人操作
                if ($balance&&$balance['uid']==session('uid')) {
                    $date['bpno']=$balance['bpno'];
                    $date['remarks']='充值成功-云通付';
                    $style=M('balance')->where(array('bpno'=>$out_trade_no))->save($date);
                    //修改客户的帐号余额
                    if ($style) {
                        $userprice=M('accountinfo')->where(array('uid'=>$balance['uid']))->find();
                        $mydate['balance']=$balance['bpprice']+$userprice['balance'];
                        M('accountinfo')->where(array('uid'=>$balance['uid']))->save($mydate);
                    }
                }
                if(session('admin_id')){   //公众号支付
                    $this->success("支付已成功!",U('User/recharge'));exit;
                }else{
                    $this->success("支付已成功!",U('User/memberinfo'));exit;
                }
            }else{
                if(session('admin_id')){   //公众号支付
                    $this->success("支付失败!",U('User/recharge'));exit;
                }else{
                    $this->success("支付失败!",U('User/memberinfo'));exit;
                }
            }
        }else {
            if(session('admin_id')){   //公众号支付
                $this->success("验证失败!",U('User/recharge'));exit;
            }else{
                $this->success("验证失败!",U('User/memberinfo'));exit;
            }
        }
    }
    public function succ2(){
        require_once ('/ytfpay/shanpayconfig.php');
        require_once ('/ytfpay/lib/shanpayfunction.php');
        //计算得出通知验证结果
        $shanNotify = md5VerifyShan($_REQUEST['out_order_no'],$_REQUEST['total_fee'],$_REQUEST['trade_status'],$_REQUEST['sign'],$shan_config['key'],$shan_config['partner']);
        if($shanNotify) {//验证成功
            if($_REQUEST['trade_status']=='TRADE_SUCCESS'){
                //商户订单号
                $out_trade_no = $_REQUEST['out_order_no'];
                $balance=M('balance')->where(array('bpno'=>$out_trade_no))->find();
                //判断订单是否存在，并且判断是否是同一个人操作
                if ($balance&&$balance['uid']==session('uid')) {
                    $date['bpno']=$balance['bpno'];
                    F('yftpay2',1);
                    $date['remarks']='充值成功-云通付';
                    $style=M('balance')->where(array('bpno'=>$out_trade_no))->save($date);
                    //修改客户的帐号余额
                    if ($style) {
                        $userprice=M('accountinfo')->where(array('uid'=>$balance['uid']))->find();
                        $mydate['balance']=$balance['bpprice']+$userprice['balance'];
                        M('accountinfo')->where(array('uid'=>$balance['uid']))->save($mydate);
                    }
                }
                if(session('admin_id')){   //公众号支付
                    $this->success("支付已成功!",U('User/recharge'));exit;
                }else{
                    $this->success("支付已成功!",U('User/memberinfo'));exit;
                }

            }else{
                if(session('admin_id')){   //公众号支付
                    $this->success("支付失败!",U('User/recharge'));exit;
                }else{
                    $this->success("支付失败!",U('User/memberinfo'));exit;
                }
            }
        }else {
            if(session('admin_id')){   //公众号支付
                $this->success("验证失败!",U('User/recharge'));exit;
            }else{
                $this->success("验证失败!",U('User/memberinfo'));exit;
            }
        }
    }
    public function http_post($url, $data)
    {
        $oCurl = curl_init ();

        curl_setopt ( $oCurl, CURLOPT_URL, $url );
        curl_setopt ( $oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $oCurl, CURLOPT_POST, true );
        curl_setopt ( $oCurl, CURLOPT_POSTFIELDS, $data );
        $sContent = curl_exec ( $oCurl );
        $aStatus = curl_getinfo ( $oCurl );
        curl_close ( $oCurl );
        //print_r($aStatus);die;
        return $aStatus;
    }
}