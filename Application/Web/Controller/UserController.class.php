<?php
namespace Web\Controller;

use Think\Controller;

class UserController extends CommonController
{	
	
	
	public function login(){
		$this->redirect('Web/Index/index');die;
		if(IS_POST){
			$this->post();
		}else{
			if(!session('uid')){
				$user_agent = $_SERVER['HTTP_USER_AGENT'];
				if (strpos($user_agent, 'MicroMessenger') === false) {
					$this->display();
				} else {
					if($_GET['pid']){
						cookie('pid',$_GET['pid']);
					}
					R('Home/Oauth/index',array(ACTION_NAME,$_GET));
				}
			}else{
				$this->redirect('Web/Index/index');
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

			//echo("<h1>恭喜！使用 {$type} 用户登录成功</h1><br>");
			//echo("授权信息为：<br>");
			//dump($token);
			//echo("当前登录用户信息为：<br>");
			//dump($user_info);
			$this->redirect('Index/index',array('type'=>$type,'openid'=>$user_info['openid']));
		}
	}
	public function post(){
		//微信登陆
		// dump($_POST);die;
		//post登陆提交
		if (I('post.username')!='' &&I('post.password')!='') {
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
      //  $this->userlogin();
		//dump(1312);die;
        if(IS_POST)
        {// 判断提交方式 做不同处理
            // 实例化User对象
			
            $user = D('userinfo');
            //检查用户名
            header("Content-type: text/html; charset=utf-8");
            //检查手机验证码
            $code = $this->mescontent();
           // $verify = I('post.code');
          //  if ($code != $verify) {
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
                $uname = $user->where('username='.$data['username'])->find();
                
                if($uname){
                    $this->error('用户名已存在',U('Index/reg'));
                }else{
                    //插入数据库
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
							$aid = M('accountinfo')->add($acc);
							$this->success('注册成功',U('Index/index'));
						} else {
							$this->error('注册失败',U('User/login'));
						}
					}
                }
            //}else{
             //   $this->ajaxReturn(0);
           // }

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
              M('accountinfo')->add($accid);
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
		$this->assign('signPackage',$signPackage);
		$this->assign('userinfo',$userinfo);
		$this->display();
	}

	public function wap_ticket(){
		//dump(cookie('wecha_id'));die;
		if($_GET['pid']){
			cookie('tuiguang_pid',$_GET['pid']);
			$url =$this->two_code($_GET['pid']);
		}else{
			$this->check(ACTION_NAME);
			$user = R('Home/Common/userinfo',array(session('uid')));
			$url =$this->two_code($user['openid']);
		}
		//dump($url);die;
		$signPackage=R('Home/Common/wap_index');
		$this->assign('signPackage',$signPackage);
		$this->assign('url',$url);
		$this->assign('wechaId',$user['openid']);
		$this->display();
	}
	
	public function two_code($wecha_id){
		$user = M('userinfo')->where(array('openid'=>$wecha_id))->find();
		$rand = R('Home/Common/get_number',array($wecha_id));
		if($user['agenttype'] == 2){
			$uservip = M("ticket_vip")->where(array('wecha_id'=>$wecha_id,'rand'=>$rand))->find();
			$max = M("ticket_vip")->count();
			$id  = $max+1;
			if(!$uservip){
				$access_token=R('Home/Common/getAccessToken');
				$user_url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
				$data='{
					"action_name": "QR_LIMIT_SCENE", 
					"action_info": {
						"scene": {
							"scene_id":  "'.$id.'"
							}
						}
					}';				
				$user_url_json = $this->api_notice_increment($user_url,$data);
				$user_array = json_decode($user_url_json, true);
				$vips['ticket'] = $user_array['ticket'];
				$vips['time'] = time();
				$vips['wecha_id'] = $wecha_id;
				$vips['rand'] = $rand;
				M("Fenxiao_ticket_vip")->add($vips);
			}else{
				$user_array['ticket'] = $uservip['ticket'];
			}
		}else{
			$acc = M("ticket")->where(array('wecha_id'=>$wecha_id,'rand'=>$rand))->order('time desc')->limit(1)->select();
			$time = S($wecha_id.'_codes');
			if(!$acc or ($time+24*3600*15)<time()){
				$userid = $user['id'];
				$access_token=R('Home/Common/getAccessToken');
				$user_url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
				$data='{
					"expire_seconds": 2592000, 
					"action_name": "QR_SCENE", 
					"action_info": {
						"scene": {
							"scene_id":  "'.$userid.'"
							}
						}
					}';
				$user_url_json = $this->api_notice_increment($user_url,$data);
				$user_array = json_decode($user_url_json, true);
				S($wecha_id.'_codes',time());
				$arr['ticket'] = $user_array['ticket'];
				$arr['time'] = time();
				$arr['wecha_id'] = $wecha_id;
				$arr['rand'] = $rand;
				M("ticket")->add($arr);
			}else{
				$user_array['ticket'] = $acc[0]['ticket'];
			}
		}
		return $user_array['ticket'];
	}
	
	function api_notice_increment($url, $data)
	{
		$ch = curl_init();
		//$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		//curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);		
		return $tmpInfo;
	}

    //生成随机六位验证码

    public function mescontent()
    {

        $CheckCode = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        return $CheckCode;

    }

    //短信验证
    public function smsverify()
    {
        $code = $this->mescontent();
        $post_data = array();
        $post_data['userid'] = '2571';
        $post_data['password'] = 'zjy100200';
        $post_data['account'] = 'zj46602437';
        $post_data['content'] = '【微盘开发】您的验证码是:' . $code;
        $post_data['mobile'] = $_REQUEST['tel'];
        $post_data['sendtime'] = ''; //不定时发送，值为0，定时发送，输入格式YYYYMMDDHHmmss的日期值
        $url = 'http://118.145.18.236:9999/sms.aspx?action=send';
        $o = '';
        foreach ($post_data as $k => $v) {
            $o .= "$k=" . urlencode($v) . '&';
        }
        $post_data = substr($o, 0, -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
        $result = curl_exec($ch);

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
            if($bpwd['pwd']==$pwd){
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
                $this->ajaxReturn("-99");
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
        if (IS_POST) {
             $date['bpprice']=I('post.tfee1');
             $date['bpno']=$this->build_order_no();
             $date['uid']=$uid;
             $date['bptype']='充值';
             $date['bptime']=date(time());
             $date['remarks']='开始充值';
             $balanceid=M('balance')->add($date);
             if ($balanceid) {
                $balc=M('balance')->where('bpid='.$balanceid)->find();
                $this->assign('balc',$balc);
             }
             $this->assign('style','2');
			/*   支付方式  */
			$paytype = I('post.type');
			$bank=M('pay')->where(array('type'=>$paytype))->find();
			//print_r($bank);die;
            $pay = new \Think\Pay($paytype, $bank);
            $order_no = $pay->createOrderNo();
            $vo = new \Think\Pay\PayVo();
            $vo->setBody("商品描述")
                    ->setFee(I('post.money')) //支付金额
                    ->setOrderNo($order_no)
                    ->setTitle("商品标题")
                    ->setCallback("Home/Index/pay")
                    ->setUrl(U("Home/User/order"))
                    ->setParam(array('order_id' => "goods1业务订单号"));
					
			// dump($pay);die;
			$pay->buildRequestForm($vo);
        }else{
			$this->display();
		}
    }
    //处理支付后的结果，加钱
    public function notify_1(){
         $orderno=I('get.order_id');
         $balance=M('balance')->where('bpno='.$orderno)->find();
     
         //判断订单是否存在，并且判断是否是同一个人操作
         if ($balance&&$balance['uid']==session('uid')) {
            $date['bpno']=$balance['bpno'];
            $date['remarks']='充值成功';
            $style=M('balance')->where('uid='.$balance['uid'])->save($date);
            //修改客户的帐号余额
            if ($style) {
                //查询订单金额
                $prict=M('balance')->where('uid='.$balance['uid'])->find();
                //先取出用户帐号的余额。
                $userprice=M('accountinfo')->where('uid='.$balance['uid'])->find();
                $mydate['balance']=$prict['bpprice']+$userprice['balance'];
                M('accountinfo')->where('uid='.$balance['uid'])->save($mydate);
            }
         }
         $this->redirect('User/memberinfo');   
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
        $unifiedOrder->setParameter("total_fee","1");//总金额
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
		//$xml = F('333333');
		//F('333333',$xml);
		//session('uid','733');
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
		F('cml', $notify);
		if($xml['result_code']=='SUCCESS'){
			$balance=M('balance')->where(array('bpno'=>$xml['out_trade_no']))->find();
			 //判断订单是否存在，并且判断是否是同一个人操作
			 if ($balance&&$balance['uid']==session('uid')) {
				$date['bpno']=$balance['bpno'];
				$date['remarks']='充值成功01';
				$style=M('balance')->where(array('bpno'=>$xml['out_trade_no']))->save($date);
				//修改客户的帐号余额
				if ($style) {
					$userprice=M('accountinfo')->where(array('uid'=>$balance['uid']))->find();
					$mydate['balance']=$balance['bpprice']+$userprice['balance'];
					M('accountinfo')->where(array('uid'=>$balance['uid']))->save($mydate);
				}
			 }
		}
    }
    public function orderQuery()
    {  
//         out_trade_no='+$('out_trade_no').value,
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
}