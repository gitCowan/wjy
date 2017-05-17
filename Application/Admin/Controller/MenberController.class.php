<?php

namespace Admin\Controller;
use Think\Controller;
class MenberController extends Controller {
	//会员列表
    public function mlist()
    {
    	//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
    	$tq=C('DB_PREFIX');
    	$user = D('userinfo');
		$order = D('order');
		$account = D('accountinfo');
		$where='';
        $where['ustatus'] = 0;
        $username = trim(I('get.username'));
        $utel     = trim(I('get.utel'));
        $vid    = trim(I('get.vid'));
        $con      = trim((I('get.con')));
        if($_GET['username']){
            $where['username'] = array('like', '%'.$username.'%');
        }
        if($_GET['vid']){
            $where['vid'] = array('like', ''.$vid.'');
        }
        if($_GET['utel']){
            $where['utel'] = array('like', '%'.$utel.'%');
        }
        if($_GET['con']){
            if($con == 1){
                $paixu = array($tq.'accountinfo.balance asc',$tq.'userinfo.uid desc');
            }
            if($con == 2){
                $paixu = array($tq.'accountinfo.balance desc',$tq.'userinfo.uid desc');
            }
            if($con == 3){
                $paixu = array($tq.'userinfo.utime asc');
            }
            if($con == 4){
                $paixu = array($tq.'userinfo.utime desc');
            }
        }else{
            $paixu = array($tq.'userinfo.uid desc');
        }
        $param              = array();
        $param['username'] = $username;
        $param['utel']     = $utel;
        $param['con']      = $con;
        $param['vid']      = $vid;

		$field = $tq.'userinfo.username as username,'.$tq.'userinfo.utel as utel,'.$tq.'userinfo.utime as utime,'.$tq.'userinfo.uid as uid,'.$tq.'userinfo.otype as otype,'.$tq.'userinfo.ustatus as ustatus,'.$tq.'userinfo.oid as oid,'.$tq.'userinfo.address as address,'.$tq.'userinfo.portrait as portrait,'.$tq.'userinfo.lastlog as lastlog,'.$tq.'userinfo.managername as managername,'.$tq.'userinfo.comname as comname,'.$tq.'userinfo.comqua as comqua,'.$tq.'userinfo.rebate as rebate,'.$tq.'userinfo.feerebate as feerebate,'.$tq.'accountinfo.balance as balance';
			$count = $user->where($where)->count();
	        $pagecount = 10;
	        $page = new \Think\Page($count , $pagecount);
	        $page->setConfig('first','首页');
	        $page->setConfig('prev','&#8249;');
	        $page->setConfig('next','&#8250;');
	        $page->setConfig('last','尾页');
	        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
	        $show = $page->show();

			//查询用户和账户信息
			$ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->field($field)->order($paixu)->limit($page->firstRow.','.$page->listRows)->select();

			//循环用户id，获取该用户的所有订单数
			$journal = D('journal');
			foreach($ulist as $k => $v){
				$ocount = $order->where($tq.'order.uid='.$v['uid'])->count();
				$ulist[$k]['ocount'] = $ocount;
				$ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
                $ulist[$k]['utime'] = date("Y-m-d",$ulist[$k]['utime']);

				$where1['uid']   = $v['uid'];
				$where1['jtype'] = '平仓';
				$jploss_all = $journal->where($where1)->sum('jploss');
				$jfee_all = $journal->where($where1)->sum('jfee');
				$ulist[$k]['yingkui'] = $jploss_all - $jfee_all;
			}
			$this->assign('page',$show);
	    	$this->assign('ulist',$ulist);
            $this->assign('param',$param);
		//统计
		//用户数量
    	$userCount = $user->where('ustatus=0')->count();
		//交易手数
		$orders = $order->where('ostaus=1')->field('onumber')->select();
		//所有用户账户余额统计
		$acc = $account->field('balance')->select();
        //平台账户总余额
        $yue = $account->sum('balance');
		$onumber = 0;
		$anumber = 0;
		foreach($orders as $k => $v){
			$onumber += $orders[$k]['onumber'];
		}
		foreach($acc as $k => $v){
			$anumber += $acc[$k]['balance'];
		}
		$anumber = number_format($anumber,2);
        $this->assign('yue',$yue);
        $this->assign('onumber',$onumber);
		$this->assign('anumber',$anumber);
		$this->assign('ucount',$userCount);
		$this->display();
	}
	public function index()
	{
		$this->display('mlist');		
	}
	public function diymen(){
		$class=M('Diymen_class')->order('sort desc')->select();
		$this->assign('class',$class);
		$this->display();
	}
	
	public function muplook(){
		//echo '123456';exit;
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		$tq=C('DB_PREFIX');
		$journal = D('journal');
		$bournal = D('bournal');
		$user = D('userinfo');
		$where1['uid']   = $_GET['uid'];
		//$where1['type']   = 1;
		$count = $journal->where($where1)->count();
		$pagecount = 15;
		$page = new \Think\Page($count , $pagecount);
		//$page->parameter = $row; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','&#8249;');
		$page->setConfig('next','&#8250;');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();

		$tlist = $journal->order('jtime desc')->where($where1)->limit($page->firstRow.','.$page->listRows)->select();		
		$lt = count($tlist);
		$where2['uid']   = $_GET['uid'];
		$blist = $bournal->order('btime desc')->where($where2)->select();
		$times=array();
		foreach($blist as $k => $v){
			$tlist[$lt+$k]['jno'] = $v['bno'];
			$tlist[$lt+$k]['uid'] = $v['uid'];
			$tlist[$lt+$k]['jtype'] = $v['btype'];
			$tlist[$lt+$k]['jtime'] = $v['btime'];
			$tlist[$lt+$k]['number'] = 1;
			$tlist[$lt+$k]['juprice'] = $v['bprice'];
			$tlist[$lt+$k]['jusername'] = $v['username'];
			$tlist[$lt+$k]['isverified'] = $v['isverified'];
			$tlist[$lt+$k]['balance'] = $v['balance'];

		}
		foreach($tlist as $k => $v){
			$times[$k] = $v['jtime'];
		}
		array_multisort($times,SORT_STRING,SORT_DESC,$tlist);
		$this->assign('tlist',$tlist);
		$this->assign('page',$show);
		$this->display();
	}
	
	public function olist(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		$tq=C('DB_PREFIX');
		$order = D('order');
		$pinfo = D('productinfo');
		$step  = I('get.step');
		$uid   = I('get.uid');
		//重命名数据库字段名，以免多表查询字段重复
		$liestr = $tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.ostaus as ostaus,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave,'.$tq.'productinfo.uprice as uprice';
		//die;
		if($step == "search"){
			//获取订单号，生产模糊条件
			$orderno = I('post.orderno');
			//获取用户名，生产模糊条件
			$username = I('post.username');
			//获取订单时间
			$buytime = I('post.buytime');
			
			//$this->ajaxReturn($buytime);
			//获取订单类型
			$ostyle = I('post.ostyle');
			//获取订单盈亏
			$ploss = I('post.ploss');
			//获取订单状态
			$ostaus = I('post.ostaus');
			if($orderno){
				$where['orderno'] = array('like','%'.I('post.orderno').'%');
			}
			if($username){
				$where['username'] = array('like','%'.I('post.username').'%');
			}
			if($buytime){
				$today = date("Y-m-d",strtotime($buytime));
				$today = explode('-', $today);
				$begintime = mktime(0,0,0,$today[1],$today[2],$today[0]);
				$endtime = mktime(23,59,59,$today[1],$today[2],$today[0]);
				$where['buytime'] = array('between',array($begintime,$endtime));
			}
			if($ostyle!=""){
				$where['ostyle'] = $ostyle;	
			}
			if($ploss=='0'){
				$where['ploss'] = array('egt','0');
			}else if($ploss=='1'){
				$where['ploss'] = array('lt','0');
			}
			if($ostaus!=""){
				$where['ostaus'] = $ostaus;	
			}
			
			$orders = $order->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')->field($liestr)->order($tq.'order.oid desc')->where($where)->select();
			foreach($orders as $k => $v){
				$orders[$k]['buytime'] = date("Y-m-d H:m",$orders[$k]['buytime']);
				$orders[$k]['jaccess']=$orders[$k]['sellprice']-$orders[$k]['buyprice']-$orders[$k]['fee'];
			}

			if($orders){
				$this->ajaxReturn($orders);	
			}else{
				$this->ajaxReturn("null");
			}
			
		}
	}
	
	public function diymen_zhifu(){
		$class=M('Diymen_zhifu_class')->order('sort desc')->select();
		$this->assign('class',$class);
		$this->display();
	}

	public function diyadd(){
		if(IS_POST)
		{		
			if($_GET['pid']){
				$data=M('Diymen_class')->where(array('id'=>$_GET['pid']))->save($_POST);
			}else{
				$data=M('Diymen_class')->add($_POST);
			}
			if($data==true){
				$this->success('设置成功',U('diymen'));
			}else{
				$this->error('设置失败',U('diymen'));
			}
		}
		else
		{
			if($_GET['pid']){
				
				$diy=M('Diymen_class')->where(array('id'=>$_GET['pid']))->find();

				$this->assign('diy',$diy);
			}
			$class=M('Diymen_class')->where(array('pid'=>0))->order('sort desc')->select();
			$this->assign('class',$class);
			$this->display();
		}
	}

	public function diyadd_zhifu(){
		if(IS_POST)
		{		
			if($_GET['pid']){
				$data=M('Diymen_zhifu_class')->where(array('id'=>$_GET['pid']))->save($_POST);
			}else{
				$data=M('Diymen_zhifu_class')->add($_POST);
			}
			if($data==true){
				$this->success('设置成功',U('diymen'));
			}else{
				$this->error('设置失败',U('diymen'));
			}
		}
		else
		{
			if($_GET['pid']){
				
				$diy=M('Diymen_zhifu_class')->where(array('id'=>$_GET['pid']))->find();

				$this->assign('diy',$diy);
			}
			$class=M('Diymen_zhifu_class')->where(array('pid'=>0))->order('sort desc')->select();
			$this->assign('class',$class);
			$this->display();
		}
	}

	public function  diy_del()
	{
		$class=M('Diymen_class')->where(array('pid'=>$_GET['id']))->order('sort desc')->find();
		if($class==false){
			$back=M('Diymen_class')->where(array('id'=>$_GET['id']))->delete();
			if($back==true){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}else{
			$this->error('请删除该分类下的子分类');
		}
	}

	public function  diy_zhifu_del()
	{
		$class=M('Diymen_zhifu_class')->where(array('pid'=>$_GET['id']))->order('sort desc')->find();
		if($class==false){
			$back=M('Diymen_zhifu_class')->where(array('id'=>$_GET['id']))->delete();
			if($back==true){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}else{
			$this->error('请删除该分类下的子分类');
		}
	}

	function all_insert($name = '', $back = '/index')
    {
        $name = $name ? $name : MODULE_NAME;
        $db   = D($name);
        if ($db->create() === false) {
            $this->error($db->getError());
        } else {
            $id = $db->add();
            if ($id) {
                $this->success('操作成功', U(MODULE_NAME . $back));
            } else {
                $this->error('操作失败', U(MODULE_NAME . $back));
            }
        }
    }
	//读取关注微信的用户信息。
	public function wxlist(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();

		$userinfo = M('userinfo');
        //分页
		$count = $userinfo->where('usertype=1')->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
		//查询用户和账户信息
		$ulist = $userinfo->where('usertype=1')->order('uid desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		$this->assign('page',$show);
    	$this->assign('ulist',$ulist);


		$this->display();
	} 
	/*
	*获取最新的所有关注用户的信息，添加到用户列表，注意usertype，wxtype，2个参数。
	*/
	public function instruser(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		$wxinfo=M('wechat')->find();
	    $appid = $wxinfo['appid'];  
	    $appsecret = $wxinfo['appsecret'];  

	    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";  
	    $ch = curl_init();  
	    curl_setopt($ch, CURLOPT_URL, $url);  
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	    $output =curl_exec($ch);  
	    curl_close($ch);  
	    $jsoninfo = json_decode($output, true);  
	    $access_token = $jsoninfo["access_token"];     
	    $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token";  
	    $result =$this->https_request($url);  
	    $jsoninfo = json_decode($result);  // 默认false，为Object，若是True，为Array  
	       
	    $data = $jsoninfo -> data;    
	    header("Content-type: text/html; charset=utf-8");
	    $userlist=array();
	    foreach($data -> openid as $x=>$x_value) {   
	        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$x_value;
	        $result = $this->https_request($url); 
	        $php_json =(Array)json_decode($result);   //再把json格式的数据转换成php数组
	        $php_json['username']= substr($php_json['openid'], -5).time();//登录名
            $php_json['address']=$php_json['country'].$php_json['province'].$php_json['city'];//地址
            $php_json['portrait']=$php_json['headimgurl'];//头像
            $php_json['utime']=$php_json['subscribe_time'];//时间
            $php_json['openid']= $php_json['openid'];
            $php_json['nickname']=$php_json['nickname'];
	        $php_json['usertype']='1';
	        $php_json['wxtype']='1';
	        $userlist[]=$php_json;
	    }
        //重组数组
        $mydata=array();
        $userinfo = M('userinfo');
        foreach ($userlist as $key => $value) {
        	$mydata[$key]['username']=$value['username'];
        	$mydata[$key]['address']=$value['address'];
        	$mydata[$key]['portrait']=$value['portrait'];
        	$mydata[$key]['openid']=$value['openid'];
        	$mydata[$key]['utime']=$value['utime'];
        	$mydata[$key]['nickname']=$value['nickname'];
        	$mydata[$key]['usertype']=1;
        	$mydata[$key]['wxtype']=1;
        	$usersum=$userinfo->where("openid='".$value['openid']."'")->count();
        	if ($usersum<1) {
        		$userinfo->add($mydata[$key]);
        	}

        }
        $this->redirect('Menber/wxlist');
	}
	/**
	 * 添加会员
	 * */
	public function madd(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		
		$user = D('userinfo');
		$account = D('accountinfo');
		$manager = D('managerinfo');
		if(IS_POST){
			if($data=$user->create()){
				$data['utime']=date(time());
				$data['upwd']=md5(I('post.upwd'));//.date(time()));
				$data['oid']=session('userid');
				$data['managername']=session('username');
				$data['utime']=date(time());
				$data['agenttype'] = 2;//二开
				$result = $user->add($data);
				if($result){
					$mg['brokerid'] = I('post.brokerid');
					$mg['uid'] = $result;
					$mg['vid'] = session('userid');
					$ac['uid'] = $result;
					//创建账户表
					$account->add($ac);
					//创建身份证信息表
					$manager->add($mg);
					$this->success('添加成功',U('Menber/mlist'));
				}else{
					$this->error("添加失败");
				}
			}else{
				$this->error($user->getError());
			}
		}else{
			$this->display();	
		}
	}
	
	public function mupdate(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		$account = D('accountinfo');
		$user = D('userinfo');
		$manager = D('managerinfo');
		if(IS_POST){
			$ajax = I('get.ajax');
			$uid = I('post.uid');
			$rebate = I('post.rebate');
			$feerebate = I('post.feerebate');
			$balance   = I('post.balance');
			$data['username'] = I('username');
			$data['utel'] = I('utel');
			$data['address'] = I('address');
			$data['brokerid'] = I('post.brokerid');
			$data['comname'] = I('comname');
			$data['comqua'] = I('comqua');
			$data['oid'] = I('post.oid');
			$data['vid'] = I('post.vid');
			$data['rebate'] = $rebate;
			$data['feerebate'] = $feerebate;
			$upwd = I('upwd');
			if(!empty($upwd)){
				$data['upwd'] = md5($upwd);//.I('utime'));
			}
			if(!empty($data['oid'])){
				$user_tj = $user->where('uid='.$data['oid'])->find();
				$data['managername'] = $user_tj['username'];
			}

			$editlt = $user->where('uid='.$uid)->save($data);
			$editba = $account->where('uid='.$uid)->save(array('balance'=>$balance));
			if($editlt!==FALSE || $editba!==FALSE){
				$this->success("修改成功",U("Menber/mlist"));
			}else{
				$this->error('修改失败');
			}
			
			if($ajax=="rebate"){
				$result = $user->where('uid='.$uid)->setField('rebate',$rebate);
				if($result){
					$this->ajaxReturn('修改成功');
				}else{
					$this->ajaxReturn('修改失败');
				}
			}else if($ajax=="feerebate"){
				$result = $user->where('uid='.$uid)->setField('feerebate',$feerebate);
				if($result){
					$this->ajaxReturn('修改成功');
				}else{
					$this->ajaxReturn('修改失败');
				}
			}
			
		}else{
			$uid = I('get.uid');			
			$us = $user->where('uid='.$uid)->find();
			$mg = $manager->where('uid='.$uid)->find();
			$account = $account->where('uid='.$uid)->find();
			if(!$account){
				D('accountinfo')->add(array('uid'=>$uid));
			}
			$this->assign('us',$us);
			$this->assign('mg',$mg);
			$this->assign('account',$account);
			$this->display();
		}
	}
	//微信基本配置
	public function wxinfo(){
		$wechat=D('wechat');
		if (IS_POST) {
			header("Content-type: text/html; charset=utf-8");
				if(!$wechat->create()){
					  // 如果创建失败 表示验证没有通过 输出错误提示信息
                    $this->error($wechat->getError());
				}else{
					//添加
					if (I('post.wcid')=='') {
						$data=$wechat->create();
					    $wechat->add($data);
					}else{
					//修改
						$data['wcid']=I('post.wcid');
						$data=$wechat->create();
					    $wechat->save($data);		
					}	
					
				};

		}
		$wx=$wechat->find();
		$this->assign('wx',$wx);
		$this->display();
	}
	
	public function wxinfo_zhifu(){
		$wechat=D('wechat_zhifu');
		if (IS_POST) {
			header("Content-type: text/html; charset=utf-8");
				if(!$wechat->create()){
					  // 如果创建失败 表示验证没有通过 输出错误提示信息
                    $this->error($wechat->getError());
				}else{
					//添加
					if (I('post.wcid')=='') {
						$data=$wechat->create();
					    $wechat->add($data);
					}else{
					//修改
						$data['wcid']=I('post.wcid');
						$data=$wechat->create();
					    $wechat->save($data);		
					}	
					
				};

		}
		$wx=$wechat->find();
		$this->assign('wx',$wx);
		$this->display();
	}

    //出来微信htpp地址方法
	function https_request($url)  
    {         
        $curl = curl_init();         
        curl_setopt($curl, CURLOPT_URL, $url);         
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);         
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);         
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);         
        $data = curl_exec($curl);         
        if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}         
        curl_close($curl);         
        return $data;  
    } 
public function  diy_send()
	{
		if(IS_GET)
		{
			
			$data = '{"button":[';			
			$class=M('Diymen_class')->where(array('pid'=>0))->limit(3)->order('sort desc')->select();
			//dump($class);
			$kcount=M('Diymen_class')->where(array('pid'=>0))->limit(3)->order('sort desc')->count();
			$k=0;
			foreach($class as $key=>$vo)
			{
				//主菜单
				if ($vo['emoji_code'] != '') {
					$vo['title'] =  $this->unicode2utf8_2 ( '\u' . $vo['emoji_code']).$vo['title'];
				}
				$data.='{"name":"'.$vo['title'].'",';				
				//$data.='{"name":"'.$vo['keyword'].'",';
				$c=M('Diymen_class')->where(array('pid'=>$vo['id']))->limit(5)->order('sort desc')->select();
				$count=M('Diymen_class')->where(array('pid'=>$vo['id']))->limit(5)->order('sort desc')->count();
				//子菜单
				if($c!=false)
				{
					$data.='"sub_button":[';
				}else{
					if($vo['url'])
						$data.='"type":"view","name":"'.$vo['title'].'","url":"'.$vo['url'].'"';
					elseif($vo['keyword'])
						$data.='"type":"click","key":"'.$vo['keyword'].'"';
				}
				$i=1;
				foreach($c as $voo)
				{
					if ($voo['emoji_code'] != '') {
						$voo['title'] =  $this->unicode2utf8_2 ( '\u' . $voo['emoji_code']).$voo['title'];
					}
					if($i==$count)
					{
						if($voo['url'])
						{
							$data.='{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"}';
						}else{
							$data.='{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"}';
						}
					}else{
						if($voo['url']){
							$data.='{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"},';
						}else{
							$data.='{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"},';
						}
					}
					$i++;
				}
				if($c!=false){
					$data.=']';
				}

				if($k==$kcount){
					$data.='}';
				}else{
					$data.='},';
				}
				$k++;
			}
			//print_r($data);die;
			$json=$this->access_token(1);
			$url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$json->access_token;
			$rs = $this->api_notice_increment($url,$data);
			//print_r($json->access_token);die;
			if($rs==false)
			{
				$this->error('操作失败');
			}else{
				$this->success('操作成功');
			}
			exit;
		}else{
			$this->error('非法操作');
		}
	}

	public function  diy_send_zhifu()
	{
		if(IS_GET)
		{
			
			$data = '{"button":[';			
			$class=M('Diymen_zhifu_class')->where(array('pid'=>0))->limit(3)->order('sort desc')->select();
			//dump($class);
			$kcount=M('Diymen_zhifu_class')->where(array('pid'=>0))->limit(3)->order('sort desc')->count();
			$k=0;
			foreach($class as $key=>$vo)
			{
				//主菜单
				if ($vo['emoji_code'] != '') {
					$vo['title'] =  $this->unicode2utf8_2 ( '\u' . $vo['emoji_code']).$vo['title'];
				}
				$data.='{"name":"'.$vo['title'].'",';				
				//$data.='{"name":"'.$vo['keyword'].'",';
				$c=M('Diymen_zhifu_class')->where(array('pid'=>$vo['id']))->limit(5)->order('sort desc')->select();
				$count=M('Diymen_zhifu_class')->where(array('pid'=>$vo['id']))->limit(5)->order('sort desc')->count();
				//子菜单
				if($c!=false)
				{
					$data.='"sub_button":[';
				}else{
					if($vo['url'])
						$data.='"type":"view","name":"'.$vo['title'].'","url":"'.$vo['url'].'"';
					elseif($vo['keyword'])
						$data.='"type":"click","key":"'.$vo['keyword'].'"';
				}
				$i=1;
				foreach($c as $voo)
				{
					if ($voo['emoji_code'] != '') {
						$voo['title'] =  $this->unicode2utf8_2 ( '\u' . $voo['emoji_code']).$voo['title'];
					}
					if($i==$count)
					{
						if($voo['url'])
						{
							$data.='{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"}';
						}else{
							$data.='{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"}';
						}
					}else{
						if($voo['url']){
							$data.='{"type":"view","name":"'.$voo['title'].'","url":"'.$voo['url'].'"},';
						}else{
							$data.='{"type":"click","name":"'.$voo['title'].'","key":"'.$voo['keyword'].'"},';
						}
					}
					$i++;
				}
				if($c!=false){
					$data.=']';
				}

				if($k==$kcount){
					$data.='}';
				}else{
					$data.='},';
				}
				$k++;
			}
			//print_r($data);die;
			$json=$this->access_token(2);
			$url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$json->access_token;
			$rs = $this->api_notice_increment($url,$data);
			//print_r($json->access_token);die;
			if($rs==false)
			{
				$this->error('操作失败');
			}else{
				$this->success('操作成功');
			}
			exit;
		}else{
			$this->error('非法操作');
		}
	}

	public function access_token($status){
		if($status == 1){
			$api=M('wechat')->find();
		}else{
			$api=M('wechat_zhifu')->find();
		}
		
		if($api['appid']==false||$api['appsecret']==false)
		{
			$this->error('必须先填写【AppId】【 AppSecret】');exit;
		}
		$url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$api['appid'].'&secret='.$api['appsecret'];			
		$json=json_decode($this->curlGet($url_get));
		return $json;
	}
	function api_notice_increment($url, $data)
	{
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);		
		if (curl_errno($ch)) {
			return false;
		}else{

			return true;
		}
	}
	function curlGet($url){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}    
	
}