<?php

namespace Think\Pay\Driver;

class Wxpay extends \Think\Pay\Pay {
    protected $gateway = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    protected $orderquery = 'https://api.mch.weixin.qq.com/pay/orderquery';
   

    public function check() {
        if ( !$this->config['partner'] || !$this->config['key']) {
            E("微信支付设置有误！");
        }
        return true;
    }

    public function buildRequestForm(\Think\Pay\PayVo $vo) {
        // 获取用户openId，微信公众号JSAPI支付必须
        $openId = $this->GetOpenid();
        $param = array(
            'appid'            => $this->config['appid'],
            'mch_id'           => $this->config['partner'],
            'nonce_str'        => $this->getNonceStr(),
            'body'             => $pay_data['body'],
            'out_trade_no'     => $pay_data['out_trade_no'],
            'total_fee'        => $pay_data['money'] * 100,
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
            'notify_url'       => $this->config['notify_url'],
            'trade_type'       => 'JSAPI',
            'openid'           => $openId,
        );

        // 签名
        $param['sign'] = $this->MakeSign($param);
        $xml_param = $this->ToXml($param);
        $result = $this->FromXml($this->postXmlCurl($xml_param, $this->gateway));
        if($result['return_code'] === 'SUCCESS'){
            if ($this->CheckSign($result)) {
                $jsApiParameters = $this->GetJsApiParameters($result);
                $pay_page = <<<EOF
                    <html>
                        <head>
                            <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
                            <meta name="viewport" content="width=device-width, initial-scale=1"/> 
                            <title>微信支付</title>
                            <script type="text/javascript">
                            //调用微信JS api 支付
                            function jsApiCall()
                            {
                                WeixinJSBridge.invoke(
                                    'getBrandWCPayRequest',
                                    {$jsApiParameters},
                                    function(res){
                                        WeixinJSBridge.log(res.err_msg);
                                        //alert(res.err_code+res.err_desc+res.err_msg);
                                    }
                                );
                            }

                            function callpay()
                            {
                                if (typeof WeixinJSBridge == "undefined"){
                                    if( document.addEventListener ){
                                        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                                    }else if (document.attachEvent){
                                        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
                                        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                                    }
                                }else{
                                    jsApiCall();
                                }
                            }
                            </script>
                        </head>
                        <body>
                            <br/>
                            <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">{$pay_data['money']}</span>元</b></font><br/><br/>
                            <div align="center">
                                <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
                            </div>
                        </body>
                        </html>
EOF;
                return $pay_page;
            }
        } else {
            E("微信订单错误！" . $result['return_msg']);
        }
    }
	  public function verifyNotify($notify) {

        //生成签名结果
        $isSign = $this->getSignVeryfy($notify, $notify["sign"]);
        $response = true;
        if (!empty($notify["notify_id"])) {
            $response = $this->getResponse($notify["notify_id"]);
        }
        if ($response && $isSign) {
            $this->setInfo($notify);
            return true;
        } else {
            return false;
        }
    }
}