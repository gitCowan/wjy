<?php
namespace Home\Controller;

use Think\Controller;

class OauthController extends Controller{
	public function index($name='',$param){
        $str = '';		
		if(!empty($param) && is_array($param)){	
			foreach($param as $key=>$val){
				$str.= '/'.$key.'/'.$val;
			}			    
		}
		$data=$conf=M('wechat')->find();
		$uri='http://'.$_SERVER['HTTP_HOST'].'/index.php/Home/Oauth/code/name/'.$name.$str;
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$data['appid'].'&redirect_uri='.urlencode($uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect ';
		header('Location:'.$url);
	}
	
	public function code(){
		$access_token=$this->access_token($_GET['code']);
		$url='https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token['access_token'].'&openid='.$access_token['openid'].'&lang=zh_CN';
		$infos=json_decode($this->curlGet($url),true);
		//判断中访客还是用户
		$this->userid($infos);
		if($_GET['codename']){
			$this->redirect('Web/Index/wxcode');die;
		}
		$this->redirect('Home/Index/index');
	}
	public function userid($infos){
		$uid = M('userinfo')->where(array('openid'=>$infos['openid']))->find();
		if(!$uid){
			if(cookie('pid')){
				$pid = cookie('pid');
			}elseif($_GET['pid']){
				$pid = $_GET['pid'];
			}
			$arr['username'] = $infos['nickname'];
			$arr['utime']    = time();
			$arr['openid']   = $infos['openid'];
			$arr['portrait'] = $infos['headimgurl'];
			$arr['oid']  	 = $pid;
			$topname = M('userinfo')->where(array('uid'=>$pid))->field('username,vid,cid')->find();
			$arr['managername']  	 = $topname['username'];
			$arr['vid']=$topname['vid'];
			$uid = M('userinfo')->add($arr);
			if($pid){
				$att['cid']  = $topname['cid'].$uid.'|';
			}else{
				$att['cid']  = '|'.$uid.'|';
			}
			M('userinfo')->where(array('uid'=>$uid))->save($att);
			S('tree_num'.$pid,null);
			S('tree_num'.$uid,null);
			session('uid',$uid);
			S('sessionuid',$uid,3600);
		}else{
			session('uid',$uid['uid']);
			S('sessionuid',$uid['uid'],3600);
		}
		return $data;
	}
	
	
	public function access_token($code){
		$data=$conf=M('wechat')->find();
		$url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$data['appid'].'&secret='.$data['appsecret'].'&code='.$code.'&grant_type=authorization_code';
		$res = json_decode($this->curlGet($url),true);
		return $res;
	}
	
	function curlGet($url){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
	
	
}
?>