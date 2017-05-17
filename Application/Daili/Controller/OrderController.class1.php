<?php
// 本类由系统自动生成，仅供测试用途
namespace Daili\Controller;
use Think\Controller;
class OrderController extends Controller {
    public function ocontent()
	{
		//判断用户是否登陆//判断用户是否登陆
        $user= A('Admin/User');
        $user->checklogin();
		$order = D('order');
		$users = D('userinfo');
		$binfo = D('bankinfo');
		$pinfo = D('productinfo');
		$manager = D('managerinfo');
		$account = D('accountinfo');
		//获取订单id
		$oid = I('get.oid');
		//查询订单数据基本信息
		$oinfo = $order->where('oid='.$oid)->find();		
		//客户信息
		$uinfo = $users->where('uid='.$oinfo['uid'])->find();
		//商品信息
		$goods = $pinfo->where('pid='.$oinfo['pid'])->find();
		//银行卡信息
		$bank = $binfo->where('uid='.$oinfo['uid'])->field('bnkmber')->find();
		//身份证信息
		$mger = $manager->where('uid='.$oinfo['uid'])->field('mname,brokerid')->find();
		//用户账户信息
		$acount = $account->where('uid='.$oinfo['uid'])->field('balance')->find();
		
		$this->assign('oinfo',$oinfo);
		$this->assign('uinfo',$uinfo);
		$this->assign('goods',$goods);
		$this->assign('bank',$bank);
		$this->assign('mger',$mger);
		$this->assign('acount',$acount);
		$this->display();
	}
	public function olist(){
		//判断用户是否登陆
        $user= A('Admin/User');
        $user->checklogin();
		
		
		$tq=C('DB_PREFIX');
		$order = D('order');
		$pinfo = D('productinfo');
		$users = D('userinfo');
		$step = I('get.step');
		//重命名数据库字段名，以免多表查询字段重复
		$vid = R('Daili/Index/daili_lower',array(session('did')));
	
	
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
			$where['uid'] = array('in',$vid);
			$orders = $order->where($where)->field('uid,pid,orderno,fee,onumber,ostyle,ostaus,selltime,buytime,sellprice,buyprice,ploss')->select();
			foreach($orders as $k => $v){
				$products = $pinfo->where(array('pid'=>$v['pid']))->field('ptitle,uprice')->find();
				$orders[$k]['ptitle'] = $products['ptitle'];
				$orders[$k]['uprice'] = $products['uprice'];
				$userinfo = $users->where(array('uid'=>$v['uid']))->field('username')->find();
				$orders[$k]['username'] = $userinfo['username'];
				$arr = R('Home/Common/accountinfo',array($v['uid']));
				$orders[$k]['commission'] = $arr['balance'];
				$orders[$k]['buytime'] = date("Y-m-d H:m",$orders[$k]['buytime']);
				$orders[$k]['selltime'] = date("Y-m-d H:m",$orders[$k]['selltime']);
				$orders[$k]['jaccess']=$orders[$k]['sellprice']-$orders[$k]['buyprice']-$orders[$k]['fee'];
			}

			if($orders){
				$this->ajaxReturn($orders);	
			}else{
				$this->ajaxReturn("null");
			}
			
		}else{
			
			$where1['uid'] = array('in',$vid);
			//分页
			$count = $order->where($where1)->count();
			
	        $pagecount = 15;
	        $page = new \Think\Page($count , $pagecount);
	        $page->parameter = $row; //此处的row是数组，为了传递查询条件
	        $page->setConfig('first','首页');
	        $page->setConfig('prev','&#8249;');
	        $page->setConfig('next','&#8250;');
	        $page->setConfig('last','尾页');
	        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	        $show = $page->show();
			//订单列表
			$orders = $order->where($where1)->field('uid,pid,orderno,fee,onumber,ostyle,ostaus,selltime,buytime,sellprice,buyprice,ploss')->limit($page->firstRow.','.$page->listRows)->select();
			
			foreach($orders as $k=>$v){
				$products = $pinfo->where(array('pid'=>$v['pid']))->field('ptitle,uprice,cid,wave')->find();
				$orders[$k]['ptitle'] = $products['ptitle'];
				$orders[$k]['uprice'] = $products['uprice'];
				$orders[$k]['cid']    = $products['cid'];
				$orders[$k]['wave']   = $products['wave'];
				$userinfo = $users->where(array('uid'=>$v['uid']))->field('username')->find();
				$orders[$k]['username'] = $userinfo['username'];
				//$arr = R('Home/Common/accountinfo',array($v['uid']));
				$orders[$k]['commission'] = 0;//$arr['balance'];
			} 
			//print_r($orders);die;
			//今日统计
			$today = date("Y-m-d",time());
			$today = explode('-', $today);
			$begintime = mktime(0,0,0,$today[1],$today[2],$today[0]);
			$endtime = mktime(23,59,59,$today[1],$today[2],$today[0]);
			$where['buytime'] = array('between',array($begintime,$endtime));
			$statis = $order->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->field('onumber,uprice,ploss')->where($where)->select();
			foreach($statis as $k => $v){
				$total = $v['onumber']*$v['uprice'];
				$totals += $total;
				$number = $v['onumber'];
				$num += $number;
				$ploss = $v['ploss'];
				$tploss += $ploss;
			}
			
			$this->assign('totals',$totals);
			$this->assign('tploss',$tploss);
			$this->assign('num',$num);
			$this->assign('page',$show);
			$this->assign('orders',$orders);			
		}
		$this->display();
	}
    //最新订单，默认查询30秒内要平仓的全部订单。并统计。
    public function zxlist(){
    	//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		$tq=C('DB_PREFIX');
		$order = D('order');
		$pinfo = D('productinfo');
		if (IS_POST) {
			//商品分类：
			$ostyle = I('post.ostyle');
			//交易金额
			$ploss = I('post.ploss');
			//平仓时间
			$ostaus = I('post.ostaus');

			if($ostyle!=""){
				$where['cid']=$ostyle;	
			}
			if($ploss!=''){
			    $where['uprice']=$ploss;
			}
			if($ostaus!=""){
				$time1=time()+$ostaus;
				$where['selltime'] =array(array('EGT',time()),array('ELT',$time1));
			}

			if ($ostyle==""&&$ploss==""&&$ostaus=="") {
				$time1=time()+60;
				$where['selltime'] =array(array('EGT',time()),array('ELT',$time1));
			}
			$where['ostaus']=0;
			
		}else{
			//$time1=time()+60;
			//$where['selltime'] =array(array('EGT',time()),array('ELT',$time1));
			$where['ostaus']=0;
		}
		$vid = R('Daili/Index/daili_lower',array(session('did')));
		$where['uid'] = array('in',$vid);
		$orders = $order->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($where)->order($tq.'order.oid desc')->select();
		
		//买涨的手数。
		$zhang=$order->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($where.' and '.$tq.'order.ostyle=0')->sum($tq.'order.onumber');
        $sum['zhang']=$zhang;
		//买跌的手数。
		$die=$order->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($where.' and '.$tq.'order.ostyle=1')->sum($tq.'order.onumber');
        $sum['die']=$die;
        //查询所有商品信息
        $goods=$pinfo->distinct(true)->field('uprice')->select();

		//echo $order->getLastSql();
		$this->assign('goods',$goods);
		$this->assign('sum',$sum);
		$this->assign('orders',$orders);

    	$this->display();
    }

	//最新订单，默认查询30秒内要平仓的全部订单。并统计。
    public function yclist(){
    	//判断用户是否登陆
		$user  = A('Admin/User');
		$user->checklogin();
		$tq    = C('DB_PREFIX');
		$order = D('order');
		$pinfo = D('productinfo');
		$users = D('userinfo');
		if (IS_POST) {
			//商品分类：
			$ostyle = I('post.ostyle');
			//交易金额
			$ploss = I('post.ploss');
			//平仓时间
			if($ostyle!=""){
				$where['pid']=$ostyle;	
			}
			if($ploss!=''){
			    $where['uprice']=$ploss;
			}
			$endprofit = I('post.endprofit');
			$endloss   = I('post.endloss');
			$where['ostaus']=0;
		}else{
			$where['ostaus']=0;
			$endprofit = 10;
			$endloss   = 10;
		}
		$vid = R('Daili/Index/daili_lower',array(session('did')));
		$where['uid'] = array('in',$vid);
		$arraynow = $order->where($where)->order('oid desc')->select();
		foreach($arraynow as $k=>$v){
			$product = M('productinfo')->where(array('pid'=>$v['pid']))->find();
			$cid     = $product['cid'];
			$arr     = M('api')->where(array('cid'=>$cid,'time'=>array('ELT',time())))->order('time desc')->find();
			$youjia  = (float)$arr['price'];
			$orderx['eid']      = $v['eid'];
			$orderx['uprice']   = $product['uprice'];
			$orderx['onumber']  = $v['onumber'];
			$orderx['buyprice'] = $v['buyprice'];
			$orderx['wave']     = $product['wave'];
			$orderid = R('Home/Detailed/trends',array($youjia,$cid,$orderx));
			//盈亏百分百
			$ykbfb = $orderid['ykbfb']*100;
			//达到后台设置止盈或止亏的百分比时消息提醒
			if($ykbfb >= ($v['endprofit']-$endprofit) || $ykbfb >= ($v['endloss']-$endloss)){
				$result[$k] = $v;
				$result[$k]['percent'] = $ykbfb;
				$result[$k]['sellprice'] = $youjia;
			}
		}
		foreach($result as $k=>$v){
			$result[$k]['username'] = $users->where(array('uid'=>$v['uid']))->getfield('username');
			$aee                    = $pinfo->where(array('pid'=>$v['pid']))->field('ptitle,cid,wave')->find();
			$result[$k]['ptitle']   = $aee['ptitle'];
			$result[$k]['cid']      = $aee['cid'];
			$result[$k]['wave']     = $aee['wave'];
		}
		
		//买涨的手数。
		$zhang=$order->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($where.' and '.$tq.'order.ostyle=0')->sum($tq.'order.onumber');
        $sum['zhang']=$zhang;
		//买跌的手数。
		$die=$order->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($where.' and '.$tq.'order.ostyle=1')->sum($tq.'order.onumber');
        $sum['die']=$die;
        //查询所有商品信息
        $goods=$pinfo->distinct(true)->field('pid,ptitle')->select();
		
		//echo $order->getLastSql();
		$this->assign('goods',$goods);
		$this->assign('sum',$sum);
		$this->assign('orders',$result);

    	$this->display();
    }


	public function tlist(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		$tq=C('DB_PREFIX');
		$journal = D('journal');
		$bournal = D('bournal');
		$user = D('userinfo');
		$today = date("Y-m-d",time());
		$today = explode('-', $today);
		$begintime = mktime(0,0,0,$today[1],$today[2],$today[0]);
		$vid = R('Daili/Index/daili_lower',array(session('did')));
		$where['uid'] = array('in',$vid);
		$where['jtime'] = array('GT',$begintime);
		$tlist = $journal->order('jtime desc')->where($where)->select();		
		$lt = count($tlist);
		$where1['uid'] = array('in',$vid);
		$where1['btime'] = array('GT',$begintime);
		$blist = $bournal->order('btime desc')->where($where1)->select();
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
		$this->display();
	}
	 
}