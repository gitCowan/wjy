<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	public $tpl;
	public function _initialize(){
		
		//判断用户是否已经登录
		if (!session('uid')) {
			//直接跳转页面
			$this->redirect('User/login'); 
		}
		$this->tpl = 2;
		$this->assign('tpl','2');
		 
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
		if ($data->expire_time < time()) {
			$accessToken = $this->getAccessToken();
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&type=jsapi";
			$res = json_decode($this->httpGet($url));
			$ticket = $res->ticket;
			if ($ticket) {
				$data->expire_time = time() + 7000;
				$data->jsapi_ticket = $ticket;
			}
		}else{
			$ticket = $data->jsapi_ticket;
		}
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
		$data = S($conf['appid'].'_access_token');
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

	function webconfig(){
		$config = S('Webconfig');
		if(!$config){
			$config = M('Webconfig')->where('id=1')->find();
			S('Webconfig',$config,600);
		}
		return $config;
	}
	
	function catproduct(){
		$catgood = S('catproductList');
		if(!$catgood){
			$catgood = M('catproduct')->where(array('status'=>1))->select();
			$count   = M('catproduct')->where(array('status'=>1))->count();
			$catgood[0]['count'] = $count;
			S('catproductList',$catgood,600);
		}
		return $catgood;
	}
	
	function catproductcid($cid){
		$catgood = S('catproductcid'.$cid);
		if(!$catgood){
			$catgood = M('catproduct')->where(array('status'=>1,'cid'=>$cid))->find();
			S('catproductcid'.$cid,$catgood,600);
		}
		return $catgood;
	}
	
	function catproductcode($code){
		$catgood = S('catproductcode'.$code);
		if(!$catgood){
			$catgood = M('catproduct')->where(array('status'=>1,'title'=>$code))->find();
			S('catproductcode'.$code,$catgood,600);
		}
		return $catgood;
	}
	
	function productinfo(){
		$goods = S('productinfoList');
		if(!$goods){
			$goods = M('productinfo')->select();
			foreach($goods as $k=>$v){
				$arr  = R('Home/Common/catproductcid',array($v['cid']));
				$goods[$k]['code'] = $arr['title'];
			}
			S('productinfoList',$goods,600);
		}
		return $goods;
	}
	
	function productcid($cid){
		$goods = S('productcidList'.$cid);
		if(!$goods){
			$goods = M('productinfo')->where("cid=$cid")->select();
			S('productcidList'.$cid,$goods,600);
		}
		return $goods;
	}
	
	function productpid($pid){
		$goods = S('productpidList'.$pid);
		if(!$goods){
			$goods = M('productinfo')->where("pid=$pid")->find();
			S('productpidList'.$pid,$goods,600);
		}
		return $goods;
	}
	
	public function wap_phone($phone){
		$RemindMsg  = array(
			 '0' =>'发送成功',
			'101'=>'无此用户',
			'102'=>'密码错',
			'103'=>'提交过快',
			'104'=>'系统忙',
			'105'=>'敏感短信',
			'106'=>'消息长度错',
			'107'=>'错误的手机号码',
			'108'=>'手机号码个数错',
			'109'=>'无发送额度',
			'110'=>'不在发送时间内',
			'111'=>'超出该账户当月发送额度限制',
			'112'=>'无此产品',
			'113'=>'extno格式错',
			'115'=>'自动审核驳回',
			'116'=>'签名不合法，未带签名',
			'117'=>'IP地址认证错',
			'118'=>'用户没有相应的发送权限',
			'119'=>'用户已过期',
			'120'=>'内容不是白名单',
		);
		
		$code  = rand(10000,99999); 
		$data ="您好，您的验证码是" . $code ;
		$_SESSION['code'] = $code;
		$result = $this->sendSMS($phone,$data,'true');
		$arr = $this->execResult($result);
		$aee['status'] = 1;
		$aee['code'] = $code;
		return $aee;
	}

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
	

}