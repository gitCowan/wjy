<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 微信交互类
 */ 
namespace Home\Controller;
use Think\Controller;
class WeixinController extends Controller {

    public function _initialize(){
       // parent::_initialize();
        //获取微信配置信息
        $wechat_config = M('wechat')->find();
		
        $options = array(
 			'token'=>$wechat_config['token'], //填写你设定的key
 			'encodingaeskey'=>$wechat_config['encodingaeskey'], //填写加密用的EncodingAESKey
 			'appid'=>$wechat_config['appid'], //填写高级调用功能的app id
 			'appsecret'=>$wechat_config['appsecret'], //填写高级调用功能的密钥
        );
		F('dfff',$options);
		// dump($options);die;
    }
	public function index(){
        if($this->wechat_config['wait_access'] == 0)        
            exit($_GET["echostr"]);
        else        
            $this->responseMsg();
    }      
  
	public function responseMsg()
		{
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

			if (!empty($postStr)){
				$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$fromUsername = $postObj->FromUserName;
				$toUsername = $postObj->ToUserName;
				$keyword = trim($postObj->Content);
				$time = time();
				$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
				if($keyword == "?" || $keyword == "？")
				{
					$msgType = "text";
					$contentStr = date("Y-m-d H:i:s",time());
					$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
					echo $resultStr;
				}
			}else{
				echo "";
				exit;
			}
		}

    public function responseMsg1()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
          //extract post data
		if (empty($postStr))                     
            exit("");

			/* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
			   the best way is to check the validity of xml by yourself */
			libxml_disable_entity_loader(true);
			  $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim($postObj->Content);
			$time = time();
			if(empty($keyword))
				exit("Input something...");

			// 图文回复
			$wx_img = M('wx_img')->where("keyword like '%$keyword%'")->find();
			if($wx_img)
			{
				$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<ArticleCount><![CDATA[%s]]></ArticleCount>
							<Articles>
								<item>
									<Title><![CDATA[%s]]></Title> 
									<Description><![CDATA[%s]]></Description>
									<PicUrl><![CDATA[%s]]></PicUrl>
									<Url><![CDATA[%s]]></Url>
								</item>                               
							</Articles>
							</xml>";                                        
				$resultStr = sprintf($textTpl,$fromUsername,$toUsername,$time,'news','1',$wx_img['title'],$wx_img['desc'],$wx_img['pic'], $wx_img['url']);
				//exit($resultStr);     
				return $resultStr;	exit;					
			}


			// 文本回复
			$wx_text = M('wx_text')->where("keyword like '%$keyword%'")->find();
			if($wx_text)
			{
				$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";                    
				$contentStr = $wx_text['text'];
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
				//exit($resultStr);  
				return $resultStr;	exit;				
			}


			// 其他文本回复                
			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";                    
			$contentStr = '欢迎来到TPshop商城!';
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
			//exit($resultStr);   
			return $resultStr;	

    }    
}