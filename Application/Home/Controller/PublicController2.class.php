<?php

namespace Home\Controller;

use Think\Controller;

class PublicController extends Controller {

    /**
     * 支付结果返回
     */
    public function execResult($result){
        $result=preg_split("/[,\r\n]/",$result);
        return $result;
    }

    public function sendSMS( $mobile, $msg, $needstatus = 'false') {
        $arr = S('Message');
        if(!$arr){
            $arr = M('Message')->find();
            S('Message',$arr,600);
        }
        $postArr = array (
            'account' => $arr['account'],
            'pswd' => $arr['pswd'],
            'mobile' => $mobile,
            'msg' => $msg,
            'needstatus' => $needstatus
        );
        $result = $this->curlPost('http://sapi.253.com/msg/HttpBatchSendSM', $postArr);
        return $result;
    }
    public function curlPost($url,$postFields){
        $postFields = http_build_query($postFields);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
    public function wap_reset_msg1(){
        $phone = I('post.phone');

        $code  = rand(10000,99999);
        $data ="您好，您的验证码是" . $code ;
        $result = $this->sendSMS($phone,$data,'true');
        $arr = $this->execResult($result);
        $aee['status'] = 1;
        $aee['code'] = $code;
        $result = $aee;
        $this->ajaxReturn($result);
    }
    public function notify() {
        $apitype = I('get.apitype');

        $pay = new \Think\Pay($apitype, C('payment.' . $apitype));
        if (IS_POST && !empty($_POST)) {
            $notify = $_POST;
        } elseif (IS_GET && !empty($_GET)) {
            $notify = $_GET;
            unset($notify['method']);
            unset($notify['apitype']);
        } else {
            exit('Access Denied');
        }
        //验证
        if ($pay->verifyNotify($notify)) {
            //获取订单信息
            $info = $pay->getInfo();

            if ($info['status']) {
                $payinfo = M("Pay")->field(true)->where(array('out_trade_no' => $info['out_trade_no']))->find();
                if ($payinfo['status'] == 0 && $payinfo['callback']) {
                    session("pay_verify", true);
                    $check = R($payinfo['callback'], array('money' => $payinfo['money'], 'param' => unserialize($payinfo['param'])));
                    if ($check !== false) {
                        M("Pay")->where(array('out_trade_no' => $info['out_trade_no']))->setField(array('update_time' => time(), 'status' => 1));
                    }
                }
                if (I('get.method') == "return") {
                    redirect($payinfo['url']);
                } else {
                    $pay->notifySuccess();
                }
            } else {
                $this->error("支付失败！");
            }
        } else {
            E("Access Denied");
        }
    }

}
