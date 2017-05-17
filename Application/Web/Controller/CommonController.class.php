<?php
namespace Web\Controller;
use Think\Controller;
class CommonController extends Controller {
	public $tpl;
	public function _initialize(){
	 //判断用户是否已经登录
		$sessionuid = S('sessionuid');
		session('uid',$sessionuid);
		$this->uid      = $sessionuid;
		if(empty($this->uid)){
			$this->assign('login',0); 
		}
		// $this->tpl = M('webconfig')->getfield('tpl');
		// $this->assign('tpl',$this->tpl);
		// $user_agent = $_SERVER['HTTP_USER_AGENT'];
		// if (strpos($user_agent, 'MicroMessenger')==true){
			// $webconfig=M('webconfig')->find();
			// $webconfig['url']="http://".$_SERVER['SERVER_NAME']."/index.php/Home/Index/index/pid/".session('uid');
			// $this->assign('webconfig',$webconfig);
			$jssdk=$this->wap_index();
			$this->assign('signpackage',$jssdk);
		// } 
    }
	
	
	public function wap_index($token=''){
		
		$conf=M('wechat')->find();
		$signPackage = $this->getSignPackage($conf['appid']);
		
		return $signPackage;
	}
  
	public function getSignPackage($appId) {
		$jsapiTicket = $this->getJsApiTicket();
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$timestamp = time();
		$nonceStr = $this->createNonceStr();
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		$signature = sha1($string);
		$signPackage = array(
		  "appId"     => $appId,
		  "nonceStr"  => $nonceStr,
		  "timestamp" => $timestamp,
		  "url"       => $url,
		  "signature" => $signature,
		  "rawString" => $string
		);
		return $signPackage; 
	}

	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
		  $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}
	private function getJsApiTicket() {
		//jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		//$data = json_decode(file_get_contents("jsapi_ticket.json"));
		//$data = S($this->appId.'_jsapi_ticket');
		if ($data->expire_time < time()) {
			$accessToken = $this->getAccessToken();
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&type=jsapi";
			$res = json_decode($this->httpGet($url));
			$ticket = $res->ticket;
			if ($ticket) {
				$data->expire_time = time() + 7000;
				$data->jsapi_ticket = $ticket;
				//dump(json_encode($data));
				//S($this->appId.'_jsapi_ticket',json_encode($data));
			}
		}else{
			$ticket = $data->jsapi_ticket;
		}
		//print_r($ticket);die;
		//F('ticket',$ticket);
		return $ticket;
	}

	/**
	 * 取字符串中前5位数字
	 * @author          wuni
	 */
	public function get_number($wecha_id){
		$str = md5($wecha_id);
		preg_match('/\d+/',$str,$arr);
		$num = $arr[0]; 
		if(strlen($num) > 5){
			$number = substr($num,0,5);
		}else{
			$number = $num;
		}
		return $number;
	}

	public function getAccessToken() {
		$conf=M('wechat')->find();
		// print_r(333);die;
		//把acccesstoken  存入缓存中  并且已json的数据类型保存
		//$data = S($conf['appid'].'_access_token');
		if (!$data) {
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$conf['appid']."&secret=".	$conf['appsecret'];
			$res = json_decode($this->httpGet($url));
			$access_token = $res->access_token;
			if ($access_token) {
				$data['access_token'] = $access_token;
				S($conf['appid'].'_access_token',$data,7200);
			}
		} else{
			$access_token = $data['access_token'];
		}
		return $access_token;
	}
	
	function httpGet($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}


	function userinfo($uid){
		$user = M('userinfo')->where(array('uid'=>$uid))->find();
		return $user;
	}

	function accountinfo($uid){
		$user = M('accountinfo')->where(array('uid'=>$uid))->find();
		return $user;
	}



















}