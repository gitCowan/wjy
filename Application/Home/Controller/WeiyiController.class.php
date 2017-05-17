<?php
/*
/*
*Administrator
*2014-4-6
*/
namespace Home\Controller;
use Think\Controller;
use Home\Logic\UsersLevel;
class WeiyiController extends Controller {	
	function response($data,$keywordArr){
		$uid = M('wxuser')->where(array('token'=>$data['token']))->find();
		$usertime = M('users')->where(array('id'=>$uid['uid']))->find();
		if($usertime['status'] == '0'){
			return array(
				'您好，您所关注的公众号已关闭',
				'text'
			);
		}
		if($usertime['viptime'] < time()){
			return array(
				'您好，您所关注的公众号已到期',
				'text'
			);
		}
		$q=M("TokenOpen")->where(array(
			'token'=>$data['token']
		))->field('queryname')->find();
		if($q&&stripos($q['queryname'],'Chat')!==false)
			return R("Apps/Chat/response",array($data));
		else
			return false;
	}	
			
	function areply($data,$keywordArr='')
	{
			$uid = M('wxuser')->where(array('token'=>$data['token']))->find();
			$usertime = M('users')->where(array('id'=>$uid['uid']))->find();
			if($usertime['status'] == '0'){
				return array(
					'您好，您所关注的公众号已关闭',
					'text'
				);
			}
			if($usertime['viptime'] < time()){
				return array(
					'您好，您所关注的公众号已到期',
					'text'
				);
			}
			$other=M("Other")->where(array('token'=>$data["token"]))->find();
			$this->userRequest($data['token'],$data['FromUserName'],$data['Content'],'areply');
			$Text = M("Text");
			$Img = M("Img");
			$Wxuser = M("Wxuser")->where(array('token'=>$data["token"]))->getField('Priority');
			F('Wxuser',$Wxuser);
			if(!empty($Wxuser))
			{
				if($Wxuser==1)
				{
					$db = $Img;
					$type_name = 'Img';
					$type = 1;
				}
				else{
					$db = $Text;
					$type_name = 'Text';
					$type = 2;
				}
				$info = $db->where(array(
					'keyword'=>array('like',"%".$data["Content"]."%"),
					'token'=>$data["token"],
					'type'=>$type
				))->find();
				F('info',$info);
				if(!$info)
				{
					if($Wxuser==1)
					{
						$info = $Text->where(array(
							'keyword'=>array('like',"%".$data["Content"]."%"),
							'token'=>$data["token"],
							'type'=>2
						))->find();
						$type_name = 'Text';
					}
					else
					{
						$info = $Img->where(array(
							'keyword'=>array('like',"%".$data["Content"]."%"),
							'token'=>$data["token"],
							'type'=>1
						))->find();
						$type_name = 'Img';
					}
				}
				if($info)
				{
					$apps=$type_name;
					$action = A("Apps/".$apps);
					return $action->response($data,$arr);
				}
			}
			if(!$other)
			{
				return false;
			}
			if($other["keyword"])
			{
				$key=$other["keyword"];
				$data["Content"]=$key;				
				if(strpos($key,'首页')!==false||stripos($key,'home')!==false)
					return $this->home($data);
				elseif($key=='留言板')	
					$apps='Liuyan';	
				elseif(strpos($key,'会员卡')!==false)
					$apps='Membercard';
				elseif(strpos($key,'附近的')!==false)
					$apps='Lbs';
				elseif(strpos($key,'##')!==false)
					$apps='Wewall';
				elseif(strpos($key,'wx#')!==false)
					$apps='Wall';
				elseif(strpos($key,'p')!==false)
					$apps='Weipai';
				elseif(strpos($key,'摇一摇')!==false)
					$apps='Shake';
				elseif(strpos($key,'相册')!==false)
					$apps='Photo';
				else		
				{
					$arr=M("Keyword")->where(array('keyword'=>$key,'token'=>$data['token']))->find();
					$apps=$arr['module'];
				}
				$action = A("Apps/".$apps);
				return $action->response($data,$arr);
		}
		else
		{
			return array($other["info"],'text');
		}
	}
	//用户关注事件
	public function subscribe($data)
		if($data['Ticket'])
			$user       = M('ticket')->where(array('ticket'=>$data['Ticket']))->find();
			$openid     = M('users')->where(array('openid'=>$user['wecha_id']))->find();
			$map['oid'] = $openid['uid'];
			$map['pid'] = $openid['openid'];
			$map['cid'] = $data['FromUserName'].'|'.$openid['cid'];
		}elseif(cookie('tuiguang_pid')){
			$openid     = M('users')->where(array('openid'=>cookie('tuiguang_pid')))->find();
			$map['oid'] = $openid['uid'];
			$map['pid'] = $openid['openid'];
			$map['cid'] = $data['FromUserName'].'|'.$openid['cid'];
		}
		if(M('users')->where(array('openid'=>$data['FromUserName']))->find()){	
		
		}else{
            $map['openid']   = $data['FromUserName'];
            $map['utime']    = time();
			$map['usertype'] = 1;
			if(!$map['cid']){
				$map['cid'] = $data['FromUserName'];
			}
			$touser         = $user['openid'];
			$this->msg($touser,$user);
			$counts = M('userinfo')->add($map);
		}
		$areply['recontent']='尊敬的用户您好！欢迎您加入我们！';
		$weixin =new WxopenController();
		$weixin->response($areply['recontent'],'text');
		
	}
	
	
	
	function msg($touser,$data,$topcolor = '#7B68EE'){
		/*
		$data['username'] 注册人姓名
		*/
		 $template_id='f6ibRMT_yulD36QwrQDahK0QA_zjkcUTYeadmN5fl2c';
		$info=array(
			//'first'=>array('value'=>'你好！又有一个新朋友加入','color'=>'#743A3A'),
			'keyword1'=>array('value'=>$data['username'],'color'=>'#743A3A'),
			'keyword2'=>array('value'=>date('m-d H:i:s',time()),'color'=>"#743A3A"),
			'remark'=>array('value'=>'老板，恭喜你又增加了一位粉丝，您真是棒棒哒！','color'=>'#743A3A')
		);
		F('nd',$info);
		$url='http://'.$_SERVER['SERVER_NAME'].'/index.php/Mobile/Index/index.html';
        $template = array(
            'touser' => $touser,
            'template_id' => $template_id,
            'url' => $url,
            'topcolor' => $topcolor,
            'data' => $info
        );
	 $logic = new UsersLevel();
		$token = $logic->getAccessToken();
        $json_template = json_encode($template);		
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;		
		$dataRes = $logic->api_notice_increment($url,$json_template);
        if ($dataRes['errcode'] == 0) {
            return true;
        } else {
            return false;
        }
    }
	
	//取消关注事件
	function unsubscribe($data,$arr='')
	{		
		$this->requestdata($data['token'],'unsubscribe');		
	}
	
	//扫描事件
	function scan($data)
	{
		$replyinfo = A("Apps/ReplyInfo");
		$id=$data['EventKey'];
		$new=M('Recognition')->where(array('id'=>$id))->find();
		$data['Content']=trim($new['keyword']);
		$key=trim($new['keyword']);
		//行为分析
		M('Scan')->add(array('scan_id'=>$data['EventKey'],'time'=>time(),'wecha_id'=>$data['FromUserName'],'token'=>$data['token']));
		if(strpos($key,'首页')!==false||stripos($key,'home')!==false)
			return $this->home($data);
		elseif($key=='商城')	
			return $replyinfo->response($data);
		elseif($key=='微商城')
			return $replyinfo->response($data);
		elseif($key=='团购')	
			return $replyinfo->response($data);
		elseif($key=='订餐')	
			return $replyinfo->response($data);
		elseif($key=='留言板')	
			$apps='Liuyan';	
		elseif(strpos($key,'会员卡')!==false)
			$apps='Membercard';
		elseif(strpos($key,'附近的')!==false)
			$apps='Lbs';
		elseif(strpos($key,'##')!==false)
			$apps='Wewall';
		elseif(strpos($key,'wx#')!==false)
			$apps='Wall';
		elseif(strpos($key,'p')!==false)
			$apps='Weipai';
		elseif(strpos($key,'摇一摇')!==false)
			$apps='Shake';
		elseif(strpos($key,'相册')!==false)
			$apps='Photo';
		else		
		{
			$arr=M("Keyword")->where(array('keyword'=>$data["Content"],'token'=>$data['token']))->find();
			$apps=$arr['module'];
		}
		$action = A("Apps/".$apps);
		return $action->response($data,$arr);
	}	
	
	//自定义菜单栏事件
	function click($data,$arr='')
	{		
		$this->userRequest($data['token'],$data['FromUserName'],'自定义菜单','click');
		$data["Content"]=$data["EventKey"];
		$key=$data["EventKey"];
		if(strpos($key,'首页')!==false||stripos($key,'home')!==false)
			return $this->home($data);
		elseif($key=='留言板')	
			$apps='Liuyan';	
		elseif(strpos($key,'会员卡')!==false)
			$apps='Membercard';
		elseif(strpos($key,'新闻')!==false)
			$apps='News';
		elseif(strpos($key,'人品')!==false)
			$apps='Renpin';
		elseif(strpos($key,'表白')!==false)
			$apps='Biaobai';
		elseif(strpos($key,'到计时')!==false)
			$apps='Djs';
		elseif(strpos($key,'投篮球')!==false)
			$apps='Toulan';
		elseif(strpos($key,'Baby')!==false)
			$apps='Baby';
		elseif(strpos($key,'附近的')!==false)
			$apps='Lbs';
		elseif(strpos($key,'五子棋')!==false)
			$apps='Wuziq';
		elseif(strpos($key,'脑残对话')!==false)
			$apps='Funny';	
		elseif(strpos($key,'##')!==false)
			$apps='Wewall';
		elseif(strpos($key,'wx#')!==false)
			$apps='Wall';
		elseif(strpos($key,'p')!==false)
			$apps='Weipai';
		elseif(strpos($key,'摇一摇')!==false)
			$apps='Shake';
		elseif(strpos($key,'相册')!==false)
			$apps='Photo';
		else		
		{
			$arr=M("Keyword")->where(array('keyword'=>$data["EventKey"],'token'=>$data['token']))->find();
			$apps=$arr['module'];
		}
		$action = A("Apps/".$apps);
		return $action->response($data,$arr);	
	}
	public function requestdata($data)
    {
		if($data['Event']=='subscribe'){
			F('daaaaa',$data);
			$this->subscribe($data);
		}
	

    }
	
	public function userRequest($token,$wecha_id,$keyword,$action)
    {
        $data['year']  = date('Y');
        $data['month'] = date('m');
        $data['day']   = date('d');  
		$data['token'] = $token;
		$data['wechat_id'] = $wecha_id;	
		$data['keyword'] = $keyword;
		$data['class'] = $action;		
		$data['time'] = NOW_TIME;
        M('userlocus')->add($data);
    }
	
	//跳转链接事件
	function view($data)
	{
		return array('跳转链接事件','text');
	}
	
	function home($data)
	{
		F('v3',11223);
		$uid = M('wxuser')->where(array('token'=>$data['token']))->find();
		$usertime = M('users')->where(array('id'=>$uid['uid']))->find();
		if($usertime['status'] == '0'){
			return array(
				'您好，您所关注的公众号已关闭',
				'text'
			);
		}
		if($usertime['viptime'] < time()){
			return array(
				'您好，您所关注的公众号已到期',
				'text'
			);
		}
		$field=array(
			'tp_home.title'=>'Title',
			'tp_home.info'=>'Description',
			'tp_home.picurl'=>'PicUrl',
			'tp_reply_info.apiurl'=>'Url'
		);
		$this->requestdata($data['token'],'home');
		$home = M('Home')->field($field)->join("tp_reply_info ON tp_reply_info.token=tp_home.token")
			->where(array(
				'tp_home.token' =>$data["token"]
		))->find();
		if ($home == false) 
		{
			return array(
					'商家未做首页配置，请稍后再试',
					'text'
			);
		}
		else 
		{	
			if ($home['Url'] == false)
			{
				$url = rtrim(C('site_url'), '/') . '/index.php?g=Apps&m=Wap&a=index&token='. $data["token"] .'&wecha_id='.$data['FromUserName'];
			} else {			
				$url=rtrim(C('site_url'), '/').str_replace('{wecha_id}',$data['FromUserName'],$home['Url']);
			}
		}		
		return array(
				array(
						array(
							'Title'=>$home['Title'],
							'Description'=>$home['Description'],
							'PicUrl'=>$home['PicUrl'],
							'Url'=>$url
						)
				),
				'news'
		);
	}
	
	
	
	
	
	private function getKey()
	{
		$key=$this->domain($_SERVER['HTTP_HOST']);
		$key='wykj,'.$key.'10ws22.';		
		$key=md5(json_encode($key));		
		return $key;
	}
	
	private function domain($host)
	{	$domin=$host;
	$arr=explode('.',$host);
	if(count($arr)==3)
	{
		if($arr[0]=='www')
			$domin=$arr[1].'.'.$arr[2];
	}
	return $domin;
	}
}
?>