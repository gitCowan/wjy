<?php
// 本类由系统自动生成，仅供测试用途
namespace Daili\Controller;
use Think\Controller;
class OrderController extends Controller {
    public function ocontent()
	{
		//判断用户是否登陆
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
        //重命名数据库字段名，以免多表查询字段重复
        $liestr = $tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.ostaus as ostaus,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.endprofit as endprofit,'.$tq.'order.endloss as endloss,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave,'.$tq.'productinfo.uprice as uprice';
        $param = array();
        //获取订单号，生产模糊条件
        $orderno = I('orderno');
        //获取用户名，生产模糊条件
        $username = I('username');
        //获取订单时间
        $buytime = I('buytime');
        //获取订单类型
        $ostyle = I('ostyle');
        if($orderno){
            $where['orderno'] = array('like','%'.I('orderno').'%');
        }
        if($username){
            $where['username'] = array('like','%'.I('username').'%');
        }
        if($buytime){
            $today = date("Y-m-d",strtotime($buytime));
            $today = explode('-', $today);
            $begintime = mktime(0,0,0,$today[1],$today[2],$today[0]);
            $endtime = mktime(23,59,59,$today[1],$today[2],$today[0]);
            $where['buytime'] = array('between',array($begintime,$endtime));
        }
        if($ostyle!=""){
            if($ostyle == 1){
                $where['ostyle'] = 0;
                $param['ostyle'] = 1;
            }
            if($ostyle == 2){
                $where['ostyle'] = 1;
                $param['ostyle'] = 2;
            }
        }
        $param['orderno'] = $orderno;
        $param['username'] = $username;
        $param['buytime'] = $buytime;
        $where['wp_order.ostaus'] = 0;
        $vid = R('Daili/Index/daili_lower',array(session('did')));
        $where['wp_order.uid'] = array('in',$vid);
        //分页
        $count = $order->where($where)->count();
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
        $orders = $order->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')->field($liestr)->order($tq.'order.oid desc')->where($where)->limit($page->firstRow.','.$page->listRows)->select();



        $this->assign('param',$param);
        $this->assign('page',$show);
        $this->assign('orders',$orders);
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
        $journal = D('journal');

        //查询条件
//        $nowpage = I('nowpage');
        //获取订单号，生产模糊条件
        $orderno = trim(I('orderno'));
        //获取用户名，生产模糊条件
        $username = trim(I('username'));
        //获取开始时间
        $buytime = str_replace(array("+")," ",I('buytime'));
        //获取结束时间
        $endtime = str_replace(array("+")," ",I('endtime'));
        //获取订单类型
        $ostyle = trim(I('ostyle'));
        //获取订单盈亏
        $ploss = trim(I('ploss'));
        //获取订单状态
        $ostaus = trim(I('ostaus'));

        $param = array();
        $param['orderno'] = $orderno;
        $param['username']= $username;
        $param['buytime']= $buytime;
        $param['endtime']= $endtime;
        $param['ostyle']= $ostyle;
        $param['ploss']= $ploss;
        $param['ostaus']= $ostaus;

        $where = array();
        if($orderno){
            $where['jno'] = array('like','%'.$orderno.'%');
        }
        if($username){
            $where['jusername'] = array('like','%'.$username.'%');
        }
        $today = date("Y-m-d",strtotime($buytime));
        $today = explode('-', $today);
        $endtime =strtotime($endtime);
        if($buytime &&empty($endtime)){
            $nowtime = time();
            $begintime = mktime(0,0,0,$today[1],$today[2],$today[0]);
            $endtime = $nowtime;
            $where['jtime'] = array('between',array($begintime,$endtime));
        }elseif($endtime &&empty($buytime)){
            $begintime = mktime(0,0,0,1,1,2010);
            $where['jtime'] = array('between',array($begintime,$endtime));
        }elseif($buytime &&$endtime){
            $begintime = mktime(0,0,0,$today[1],$today[2],$today[0]);
            $where['jtime'] = array('between',array($begintime,$endtime));
        }
        if($ostyle=='1'){
            $where['jostyle'] = 0;
        }else if($ostyle=='2'){
            $where['jostyle'] = 1;
        }
        if($ploss=='1'){
            $where['jstate'] = 1;
        }else if($ploss=='2'){
            $where['jstate'] = 0;
        }

        if($ostaus!=""){
            $where['jtype'] = $ostaus;
        }
        $vid = R('Daili/Index/daili_lower',array(session('did')));
        $where['uid'] = array('in',$vid);
        $count = $journal->where($where)->count();
        $pagecount = 15;
        $page = new \Think\Page($count , $pagecount);
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $show = $page->show();
        $tlist = $journal->limit($page->firstRow.','.$page->listRows)->where($where)->order('jtime desc')->select();
        //总盈亏计算（不牵扯建仓）
        if($ostaus == "建仓"){
            $yingkui = 0;
        }else{
            $where['jtype'] = "平仓";
            $jploss_all = $journal->where($where)->sum('jploss');
            $jfee_all = $journal->where($where)->sum('jfee');
            $yingkui = $jfee_all-$jploss_all;
        }
        $this->assign('yingkui',$yingkui);
        $this->assign('tlist',$tlist);
        $this->assign('page',$show);
        $this->assign('param',$param);
        $this->display();
    }


}