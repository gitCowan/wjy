<?php
// 明细表，包括收支明细和交易明细
namespace Home\Controller;

use Think\Controller;

class DetailedController extends Controller{
	public function _initialize(){
		
		$this->assign('tpl','2');
    }
	
    //交易明细列表
    public function dtrading(){
        $uid=session('uid');
        //根据传来的时间查询对应的数据(只传递月份和时间便可以)
        $mytoday=I('get.today');
        // 判断是否是点击月份左右的按钮
        if($mytoday){
            // 判断是上个月的
            if(I('get.no')==1) {
                $timestamp=strtotime($mytoday);
                $firstday=date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)-1).'-01'));
                $lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
            //判断如果是本月的，则下个月数据不存在。
            }else if(I('get.no')==2&&$mytoday==date('Y-m-01', strtotime(date("Y-m-d")))){
                $firstday=date('Y-m-01', strtotime(date("Y-m-d")));
                $lastday=date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
            //判断是下个月的
            }else{
                $timestamp=strtotime($mytoday);
                $arr=getdate($timestamp);
                if($arr['mon'] == 12){
                    $year=$arr['year'] +1;
                    $month=$arr['mon'] -11;
                    $firstday=$year.'-0'.$month.'-01';
                    $lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
                }else{
                    $firstday=date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)+1).'-01'));
                    $lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
                }
            }
             
            $begintime=$firstday;
            $endtime=$lastday;
        }else{
            $begintime=date('Y-m-01', strtotime(date("Y-m-d")));
            $endtime=date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
        }
        $tq=C('DB_PREFIX');
        $last_day1 =  strtotime(date('Y-m-01', strtotime($begintime)));
        $last_day2 =  strtotime(date('Y-m-d', strtotime($endtime)));
        $where = $last_day1.'<='.$tq.'order.selltime and '.$last_day2.'>='.$tq.'order.selltime';
        //查询多条记录
        $count = M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($tq.'order.uid='.$uid.' and '.$tq.'order.ostaus=1 and '.$where)->count();
        $pagecount = 50;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %DOWN_PAGE% %END% <br> 第 '.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)');
        $show = $page->show();
        $list = M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($tq.'order.uid='.$uid.' and '.$tq.'order.ostaus=1 and '.$where)->order($tq.'order.oid desc' )->limit($page->firstRow.','.$page->listRows)->select();   
        //计算出一段时间的盈亏beg

        //计算总收益
        $trading['money']=M('order')->where($tq.'order.uid='.$uid.' and '.$tq.'order.ostaus=1 and '.$where)->sum('ploss');
        //end
        //总单数
        $sumcount=M('order')->where($tq.'order.uid='.$uid.' and '.$tq.'order.ostaus=1 and '.$where)->count();
        $trading['count']=$sumcount;
        //总手数
        $sumonumber=M('order')->where($tq.'order.uid='.$uid.' and '.$tq.'order.ostaus=1 and '.$where)->sum('onumber');
        $trading['onumber']=$sumonumber;
        //时间
        $trading['time'] = date('Y-m-d',$last_day1);
        $this->assign('trading',$trading);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();//显示模板
    }
    //交易详情页
    public function tradingid(){
        $tq=C('DB_PREFIX');
        $order=M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->join($tq.'catproduct on '.$tq.'productinfo.cid='.$tq.'catproduct.cid')->where($tq.'order.oid='.I('oid'))->find();
        $orderid=$order;
        //建仓金额
        $orderid['jc']   = $order['uprice']*$order['onumber'];
        //盈亏资金
		$orderid['ykzj'] = $order['ploss'];
        //百分比
        $orderid['bfb']  = $orderid['ykzj']/$orderid['jc']*100;
        //本单盈余
        $orderid['bdyy'] = $order['uprice']*$order['onumber']+$order['ploss']-$order['fee'];
        //平仓收入
        $orderid['pdsr'] = $orderid['bdyy']-$order['feeprice']*$order['onumber'];
        $this->assign('order',$orderid);
        $this->display();
    }
     //收支明细列表(显示日志记录)
    public function drevenue(){
        $uid=session('uid');
        $count =M('journal')->where('uid='.$uid)->count();
        $pagecount = 5;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE%  %DOWN_PAGE% %END% <br> 第 '.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)');
        $show = $page->show();
        $list = M('journal')->where('uid='.$uid)->order('jtime desc' )->limit($page->firstRow.','.$page->listRows)->select();   
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
     //收支详细页
    public function revenueid(){
        $jno=I('id');
        $order=M('journal')->where('id='.$jno)->find();
        $this->assign('order',$order);
        $this->display();
    }
     //购买商品，获取信息，生成订单表。
    public function addorder(){

        $tq=C('DB_PREFIX');
        //数量
        $mysum=I('post.mysum');
        //所用费用
        $myfy=I('post.myfy');

        //方向
        $myfx=I('post.myfx');
        if ($myfx == '买涨') {
		   $data['ostyle']=0; 
		}else{
		   $data['ostyle']=1; 
		}    
        //体验卷值
        $mytyj=I('post.mytyj');
        //商品id
        $mypid=I('post.mypid');
        //根据商品id查询商品
        $goods=M('productinfo')->where('pid='.$mypid)->find();
        $myfy = $goods['uprice']*$mysum;
		$code = I('post.code');
		if(time() == S('CheatTime'.$code) || time() == S('CheatTimes'.$code)){
			$price = S('CheatPrice'.$code);
		}else{
			$price = S('price'.$code);
		}
		$mygetpeice = $price['price'];
		

        /*
        * 添加订单表。修改对应体验卷价格的状态。添加日志表。扣除用户账号余额
        * 添加订单之前再次判断账户余额（后续写）
        */
       
     
        $uid=session('uid');
        $username = M('userinfo')->where('uid='.$uid)->getfield('username');
       
		
		//获取账户余额
		
		$accoun=M('accountinfo');
		$user=$accoun->where('uid='.$uid)->find();
		$yu = $user['balance']-$myfy;
		if($yu < 0){
			$this->ajaxReturn('-1');exit();
		}


		//随机生成订单号
		$orderno=  $this->build_order_no();
		$order=M('order');
		//编写订单需要的数据
		$data['uid']=$uid;
		$data['pid']=$mypid;
		
		$data['buytime']=date(time());
		$data['selltime']=0;
		$data['onumber']=$mysum;
		$data['ostaus']=0;
		if($mytyj==1){
			$mysxf = 0;
			$data['eid']=1;  
			$data['fee']=0;
			$data['onumber']=1;
		}else{
			//手续费
			$mysxf=I('post.mysxf'); 
			$data['fee']=$mysxf;
		}
		$data['buyprice']	= $mygetpeice;
		$data['orderno']	= $orderno;
		$data['ptitle']		= $goods['ptitle'];
		$data['endprofit']  = I('post.endprofit');
		$data['endloss']	= I('post.endloss');
		$orderid = $order->add($data);
		if($orderid) {
			//扣除用户账号金额，若是体验卷则不扣除。
			if($mytyj==0){
				$accoun->aid=$user['aid'];
				$accoun->uid=$uid;
				//剩余余额 = 总余额 - 减去买的本金
				//$accoun->balance=$user['balance']-$myfy-$mysxf;
				$accoun->balance=$user['balance']-$myfy;
				
				$accoun->save();
			}
			//判断是否使用优惠卷，然后改变优惠卷状态
			if($mytyj==1){
				//查询使用体验卷的信息
				$experienceinfo= M('experienceinfo');
				$tiyan=$experienceinfo->join($tq.'experience on '.$tq.'experienceinfo.eid='.$tq.'experience.eid')->where($tq.'experienceinfo.uid='.$uid.' and '.date(time()).' < '.$tq.'experienceinfo.endtime and '.$tq.'experienceinfo.getstyle=0 and '.$tq.'experience.eprice='.$goods['uprice'])->find();
				$experienceinfo->exid=$tiyan['exid'];
				$experienceinfo->getstyle=1;
				$experienceinfo->save();
			}
			//添加日志表
			//随机生成订单号
			$orderno=  $this->build_order_no();
			$myjournal=M('journal');                                
			$journal['jno']=$orderno;                                       //订单号
			$journal['uid'] = $uid;                                         //用户id
			$journal['jtype'] = '建仓';                                     //类型    
			$journal['jtime'] = date(time());                               //操作时间
			$journal['jincome'] = $myfy;                                    //收支金额【要予以删除】
			$journal['number'] = $mysum;                                    //数量
			$journal['remarks'] = $goods['ptitle'];                         //产品名称  
			$journal['balance'] = $user['balance']-$myfy;                   //账户余额  
			$journal['jstate'] = 0;                                         //盈利还是亏损
			$journal['jusername'] = $username;                              //用户名
			$journal['jostyle'] = $data['ostyle'];                          //涨、跌
			$journal['juprice'] = $myfy/$mysum;                             //单价
			$journal['jfee'] = $mysxf;                                      //手续费
			$journal['jbuyprice'] = $mygetpeice;                            //入仓价
			$journal['jaccess'] = ($myfy)-($myfy)*2;        			    //支持金额，求负数
			$journal['oid'] = $orderid;                                     //改订单流水的订单id
		
			$myjournal->add($journal);
			$order->where('oid='.$orderid)->setField('commission',$journal['balance']);
		}else{
			$orderid=0;
		}
		$this->ajaxReturn($orderid); 
    }
    //判断是否购买过此类商品
    public function judgment(){ 
        //商品id
		$tq      = C('DB_PREFIX');
        $mypid   = I('post.mypid');
		$code    = I('post.code');
        $uid     = session('uid');
        $porder  = M('order')->where('uid='.$uid.' and pid='.$mypid.' and ostaus=0')->sum('onumber');
		$yu      = R('Home/Common/productpid',array($mypid)); 
		$yu['yu'] = $yu['num'] - $porder;
		if(time() == S('CheatTime'.$code) || time() == S('CheatTimes'.$code)){
			$price = S('CheatPrice'.$code);
		}else{
			$price = S('price'.$code);
		}
		$yu['prices'] = $price['price'];
		$sum  = M('experienceinfo')->join($tq.'experience on '.$tq.'experienceinfo.eid='.$tq.'experience.eid')->where($tq.'experienceinfo.uid='.$uid.' and '.date(time()).' < '.$tq.'experienceinfo.endtime and '.$tq.'experienceinfo.getstyle=0 and '.$tq.'experience.eprice='.$yu['uprice'])->count();
		
		if(!$sum){
			$sum = 0;
		}	
		$yu['sum']=$sum;
        $this->ajaxReturn($yu); 
         
    }

    //查询订单信息(接收修改后的订单，或者直接平仓，或者购买完后平仓，3中情况)
    public function orderid(){
        $tq=C('DB_PREFIX');
        $orderid=I('orderid');
        $order=M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')
        ->join($tq.'catproduct on '.$tq.'productinfo.cid='.$tq.'catproduct.cid')->where('oid='.$orderid)->find();
		$code     = $order['title'];
		if(time() == S('CheatTime'.$code) || time() == S('CheatTimes'.$code)){
			$arr = S('CheatPrice'.$code);
		}else{
			$arr = S('price'.$code);
		}
		$youjia  = (float)$arr['price'];
        
		$config = R('Home/Common/webconfig');
		$time   = $config['day']*24*3600 + $config['hour']*3600 + $config['minute']*60 + F('qiangp');
		$differ = $time - time();
		//计算天数
		$timediff = $time-time();
		$date['day']    = intval($timediff/86400);
		//计算小时数
		$remain = $timediff%86400;
		$date['hour']   = intval($remain/3600);
		//计算分钟数
		$remain = $remain%3600;
		$date['minute'] = intval($remain/60);
		$order['price'] = $youjia;
        $this->assign('order',$order);
        $this->assign('date',$date);
        $this->assign('isopen',$config);
        $this->display();
    }
   
	/** 
	 * 一键平仓
	 */
	public function ajaxAllclose(){
		$uid      = session('uid');
        $user 	  = M('accountinfo')->where('uid='.$uid)->find();
		if($_POST){
			$oid = array_filter(explode(',',$_POST['allOid']));
			$tq=C('DB_PREFIX');
			foreach($oid as $k=>$v){
				$order   = M('Order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')
				->join($tq.'catproduct on '.$tq.'productinfo.cid='.$tq.'catproduct.cid')->where('oid='.$v)->find();
				if($order['ostaus'] == 1){
					$this->ajaxReturn('-2');exit();
				}
				$code     = $order['title'];
				if(time() == S('CheatTime'.$code) || time() == S('CheatTimes'.$code)){
					$arr = S('CheatPrice'.$code);
				}else{
					$arr = S('price'.$code);
				}
				$youjia  = (float)$arr['price'];
				if($youjia < 0 || !$youjia){
					$where['code']  = $code;
					$where['time'] = array('ELT',time());
					$aee = M('Api')->where($where)->order('time desc')->field('price')->find();
					$youjia = $aee['price'];
				}
				$orderid = $this->trends($youjia,$order);
				$bdyy    = $orderid['bdyy'];    //本单盈余
				$jiancj  = $orderid['jc'];      //建仓金额
				$ykzj    = $orderid['ykzj'];	//盈亏资金
				$uprice  = $order['uprice'];	//产品单价
				$msg[]   = $this->closeTrade($uid,$user['balance'],$youjia,$v,$bdyy,$jiancj,$ykzj,$uprice,3);
				
			}
			$this->ajaxReturn($msg);
		}
	}
	
	
	/**
	 * 获取随时的动态值，计算盈亏金额和盈余数据
	 * @param    float    youjia     最新价格
	 * @param    int      cid        产品ID
	 * @param    int      oid        订单ID
	 */
    public function orderxq(){
		$oid    = I('oid');
        
		$tq    = C('DB_PREFIX');
		$order = M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($tq.'order.oid='.$oid)->find();
		$code  = M('catproduct')->where(array('cid'=>$order['cid']))->getfield('title');
		if(time() == S('CheatTime'.$code) || time() == S('CheatTimes'.$code)){
			$arr = S('CheatPrice'.$code);
		}else{
			$arr = S('price'.$code);
		}
		$youjia  = (float)$arr['price'];
		if($youjia < 0 || !$youjia){
			$where['code']  = $code;
			$where['time'] = array('ELT',time());
			$aee = M('Api')->where($where)->order('time desc')->field('price')->find();
			$youjia = $aee['price'];
		}
		$orderid = $this->trends($youjia,$order);
		$orderid['price'] = $youjia;
		$this->ajaxReturn($orderid);
        
    }
	
	/**
	 * 获取随时的动态值，计算盈亏金额和盈余数据
	 */
	public function trends($youjia,$order){
		//建仓金额
		if ($order['eid']==0){  
			$orderid['jc'] = round($order['uprice']*$order['onumber'],1); 
			//判断是买张还是买跌。0涨，1跌
			if ($order['ostyle'] == 0) {
				//盈亏资金 = 相差的点数*手数*波动盈亏
				$orderid['ykzj'] = round(($youjia-$order['buyprice'])*$order['onumber']*$order['wave'],2);
			}else{
				//跌
				$orderid['ykzj'] = round(($order['buyprice']-$youjia)*$order['onumber']*$order['wave'],2);
			}
			//盈亏百分百
			$orderid['ykbfb']    = round($orderid['ykzj']/$orderid['jc'],2); 
			
			if($orderid['ykbfb'] > 0 && ($orderid['ykbfb']*100) >= $order['endprofit']){
				if($order['endprofit'] != 1){
					$orderid['ykzj'] = round($orderid['jc']*$order['endprofit']/100,2);
				}
			}elseif($orderid['ykbfb'] < 0 && abs($orderid['ykbfb']*100) >= $order['endloss']){
				$orderid['ykzj'] = round((-$orderid['jc'])*$order['endloss']/100,2);
			}
			
			//本单盈余
			$orderid['bdyy']     = round($orderid['jc']+$orderid['ykzj'],1);
			
		}else{
			$orderid['jc'] = 0;
			//判断是买张还是买跌。0涨，1跌
			if ( $order['ostyle']==0) {
				//盈亏资金
				$orderid['ykzj']  = round(($youjia-$order['buyprice'])*$order['onumber']*$order['wave'],2);
			}else{
				//盈亏资金
				$orderid['ykzj']  = round(($order['buyprice']-$youjia)*$order['onumber']*$order['wave'],2);
			}
			if($orderid['ykzj'] < 0){
				$orderid['ykzj'] = 0;
				$orderid['bdyy'] = 0; 
			}else{
				//盈亏百分百 
				$orderid['ykbfb'] = round($orderid['ykzj']/ $order['uprice'],2); 
				if($orderid['ykbfb'] > 0 && ($orderid['ykbfb']*100) >= $order['endprofit']){
					if($order['endprofit'] != 1){
						$orderid['ykzj'] = round($order['uprice']*$order['endprofit']/100,2);
					}
				}elseif($orderid['ykbfb'] < 0 && abs($orderid['ykbfb']*100) >= $order['endloss']){
					$orderid['ykzj'] = round($order['uprice']*$order['endloss']/100,2);
				}
				//本单盈余
				$orderid['bdyy']  = round($orderid['ykzj'],1);
			}
		}
		return $orderid;
	}
	

	/**
	 * 平仓
	 * @param    int     uid          用户账户ID
	 * @param    float   youjia       该产品最新价格
	 * @param    int     oid          订单ID
	 * @param    float   bdyy         结余的金额，需要给当前用户的账户添加
	 * @param    float   jiancj       建仓金额
	 * @param    float   ykzj         盈亏资金
	 * @param    float   uprice       产品单价
	 */
    public function updateore(){
        //获取账户余额
        $uid   = session('uid');
        $user  = M('accountinfo')->where('uid='.$uid)->find();
        //获取传递过来的值
        $oid   = I('post.oid');
		$tq    = C('DB_PREFIX');
		$order = M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($tq.'order.oid='.$oid)->find();
		$code  = M('catproduct')->where(array('cid'=>$order['cid']))->getfield('title');
		if(time() == S('CheatTime'.$code) || time() == S('CheatTimes'.$code)){
			$arr = S('CheatPrice'.$code);
		}else{
			$arr = S('price'.$code);
		}
		$youjia  = (float)$arr['price'];
		if($youjia < 0 || !$youjia){
			$where['code']  = $code;
			$where['time'] = array('ELT',time());
			$aee = M('Api')->where($where)->order('time desc')->field('price')->find();
			$youjia = $aee['price'];
		}
		$orderid = $this->trends($youjia,$order);
		$bdyy    = $orderid['bdyy'];    //本单盈余
		$jiancj  = $orderid['jc'];      //建仓金额
		$ykzj    = $orderid['ykzj'];	//盈亏资金
		$uprice  = $order['uprice'];	//产品单价
		$msg    = $this->closeTrade($uid,$user['balance'],$youjia,$oid,$bdyy,$jiancj,$ykzj,$uprice,2);
		$this->ajaxReturn($msg); 
    }

	
	/**
	 * @param     char      $fee           手续费
	 * @param     char      $storage       储仓费
	 */
	public function closeTrade($uid,$balance,$youjia,$oid,$bdyy,$jiancj,$ykzj,$uprice,$type){
		$config = M('Webconfig')->where('id=1')->field('fee,storage,Pscale')->find();
		//先修改订单信息，返回成功信息后修改账户余额和添加日志记录
		$users    = D('userinfo');
		$orderno  = $this->build_order_no();
		$tq       = C('DB_PREFIX');
		$myorder  = M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($tq.'order.oid='.$oid)->find();
		if($myorder['ostaus'] == 1){
			$msg="-1";
		}else{
			$order	  = M('order');
			$orders['selltime']  = date(time());
			$orders['ostaus']    = 1;
			$orders['sellprice'] = $youjia;
			//盈亏资金	
			$orders['ploss']     = $ykzj;
			if($myorder['eid'] == 0){
				//手续费   
				$fee = $myorder['feeprice']*$myorder['onumber'];
				//储仓费
				$storage  = $config['storage']*$myorder['onumber'];
			}else{
				$fee = 0;
				$storage = 0;
			}
			$orders['fee']      = $fee;
			$msg = $order->where(array('oid'=>$oid))->save($orders);
			if ($msg){
				$myprice     = M('accountinfo')->where('uid='.$uid)->find();
				$acco        = M('accountinfo');
				$acco->uid   = $uid;
				$storagetime = $myorder['selltime'] - $myorder['buytime'];
				$num         = intval($storagetime/86400);
				if($num > 0){
					//剩余金额 = 本单盈余 - 本单储仓费 - 本单手续费
					$totalstorage = $storage*$num;
					$bdyy      = $bdyy - $totalstorage - $fee;
				}else{
					$bdyy = $bdyy - $fee; //剩余金额 = 本单盈余 - 本单手续费
				}
				$acco->balance = $myprice['balance']+$bdyy;
				$acco->save();
				//根据商品id查询商品
				$goods     = M('productinfo')->where('pid='.$myorder['pid'])->find();
				//平仓后给代理商分成 用手续费分成
				$thisuser  = $users->field('uid,oid,username,nickname,vid,agenttype')->where('uid='.$uid)->find();
				$otype = $thisuser['otype'];             //用户类型
				$username  = $_SESSION['husername'];
				if(!$_SESSION['husername']){
					$username = $thisuser['nickname'];
					if(!$thisuser['nickname']){
						$username = $thisuser['username'];
					}
				}
				if($fee && $fee != '0'){
					//用户是代理商的下级
					//if($thisuser['vid'] && $thisuser['vid'] != $uid){
						//给代理分成
						$ouid = $thisuser['vid'];
						$agent = $users->field('uid,oid,username')->where('uid='.$ouid)->find();
						$agent_user = M('accountinfo')->where('uid='.$ouid)->find();
						$distribution      = M('journal');
						
						//if($thisuser['agenttype'] != 2){
							//不是代理商
							if($thisuser['vid']){
								$Pscale = M('managerinfo')->where(array('uid'=>$thisuser['vid']))->getfield('Pscale');
								if(!$Pscale){
									$Pscale = $config['Pscale'];
								}
								$money = $fee*$Pscale/100;
								$disj['explain']   = '代理反金';   //操作标记
								$disj['jno']       = $orderno;                         //订单号
								$disj['uid']       = $ouid;                            //用户id   
								$disj['jusername'] = $agent['username'];               //用户名
								$disj['jtype']     = '返点';                           //类型
								$disj['jtime']     = date(time());                     //操作时间
								$disj['balance']   = $agent_user['balance']+$money;    //账户余额
								$disj['jfee']      = $money;                           //手续费反金
								$disj['oid']       = $oid;                             //订单id
								$disj['pid']       = $uid;                             //分销ID
								if($money>0){
									M('accountinfo')->where(array('uid'=>$ouid))->save(array('balance'=>$disj['balance']));
									$distribution->add($disj);
								}
							}
							//}else{															//用户不在代理商的下面				
							if($thisuser['oid'] && $thisuser['oid'] != 0){                                       //判断是否有上级
								$this->tree($thisuser['oid'],0,$fee,$orderno,$oid,$uid,2);
							}
						//}
						//}
				}
				//添加平仓日志表
				//随机生成订单号
				$myjournal=M('journal');
				$journal['jno']=$orderno;                                       //订单号
				$journal['uid'] = $uid;                                         //用户id
				$journal['jtype'] = '平仓';                                       //类型    
				$journal['jtime'] = date(time());                               //操作时间
				$journal['jincome'] = $bdyy;                                    //收支金额【要予以删除】
				$journal['number'] = $myorder['onumber'];                       //数量            
				$journal['remarks'] = $goods['ptitle'];                         //产品名称  
				$journal['balance'] = $balance+$bdyy;                   //账户余额  
				if ($bdyy>$jiancj){
					$journal['jstate']=1;                                     //盈利还是亏损
				}else{
					$journal['jstate']=0;
				}           
				$journal['jusername'] = $username;                              //用户名
				$journal['jostyle'] = $myorder['ostyle'];                       //涨、跌
				$journal['juprice'] = $uprice;                                  //单价
				$journal['jfee'] = $fee;                                        //手续费
				$journal['jbuyprice'] = $myorder['buyprice'];                   //入仓价
				$journal['jsellprice'] = $youjia;                               //平仓价
				$journal['jaccess'] = $bdyy;                                    //出入金额
				$journal['jploss'] = $ykzj;                                     //出入金额
				$journal['oid'] = $oid;                                         //改订单流水的订单id
				$journal['explain'] = $otype.'平仓';
				$journal['storage'] = $totalstorage;                            //储仓费
				$journal['type'] = $type;	
				$myjournal->add($journal);
				$order->where('oid='.$oid)->setField('commission',$journal['balance']);
			}else{
			   $msg="-1";
			}
		}
		return $msg;
	}

	public function tree_num($pid,$num=0){
		$oid = M('Userinfo')->where(array('uid'=>$pid))->getfield('oid');
		if($oid && $oid != 0){
			$a = $num + 1;
			$b= $this->tree_num($oid,$a);
			if(isset($b)){
				$a = $b;
			}
		}
		return $a;
	}

	
	/**
     * 递归
	 * @param          $status         int           1代理 2用户
	 * @param          $uid            int           谁分成用户
	 * @param          $pid            int           给谁分成用户
	 * @param          $num            int           分销等级
	 */
	public function tree($pids,$num,$price,$orderno,$oid,$uid){
		$data = M('tc')->order('id asc')->select();
		$money = $price*$data[$num]['tc']/100;
		//计算提成
		$user   = M('accountinfo');
		$pid   = R('Home/Common/userinfo',array($pids));
		$disj['explain'] = '分销反金';                              //操作标记
		$agent_user = $user->where('uid='.$pids)->find();
		$disj['uid']    = $pids;                                    //用户id
		$disj['jusername'] = $pid['username'];                    //用户名
		$distribution   = M('journal');
		$disj['jno']    = $orderno;                                 //订单号
		
		$disj['jtype']  = '返点';                                   //类型
		$disj['jtime']  = date(time());                             //操作时间
		$disj['balance'] = $agent_user['balance']+$money; 		 //账户余额
		$disj['jfee'] = $money;                           			 //手续费反金
		
		$disj['oid'] = $oid;                                        //订单id
		$disj['pid']  = $uid;                          				 //分销ID
		if($money>0){
			$user->where(array('uid'=>$disj['uid']))->save(array('balance'=>$disj['balance']));
			$distribution->add($disj);
		}
		if($pid['oid'] && $data[$num]['id']!=='' ){
			$this->tree($pid['oid'],$num+1,$price,$orderno,$oid,$pid['uid'],$status);
		}
	}
	
	/**
     * 达到客户设定的盈亏点进行平仓 及  达到后台设置止盈或止亏的百分比时消息提醒  
     */
	/* public function allOrder(){
		$tq = C('DB_PREFIX');
		$config = M('Webconfig')->where('id=1')->field('day,hour,minute')->find();
		$time   = $config['day']*24*3600 + $config['hour']*3600 + $config['minute']*60 + F('qiangp');
		//查询所有正在交易的订单
		$arraynow = M('order')->where(array('ostaus'=>0))->select();
		//dump($arraynow);die;
		//逐个判断盈亏比例
		foreach($arraynow as $k=>$v){
			$product = M('productinfo')->where(array('pid'=>$v['pid']))->find();
			if($product){
				$cid     = $product['cid'];
				$code  = M('catproduct')->where(array('cid'=>$cid))->getfield('title');
				if(time() == S('CheatTime'.$code) || time() == S('CheatTimes'.$code)){
					$arr = S('CheatPrice'.$code);
				}else{
					$arr = S('price'.$code);
				}
				$youjia  = (float)$arr['price'];
				if($youjia < 0 || !$youjia){
					$where['code']  = $code;
					$where['time'] = array('ELT',time());
					$aee = M('Api')->where($where)->order('time desc')->field('price')->find();
					$youjia = $aee['price'];
				}
				$order['eid']      = $v['eid'];
				$order['uprice']   = $product['uprice'];
				$order['onumber']  = $v['onumber'];
				$order['buyprice'] = $v['buyprice'];
				$order['wave']     = $product['wave'];
				$order['ostyle']    = $v['ostyle'];
				$order['endprofit'] = $v['endprofit'];
				$order['endloss']   = $v['endloss'];
				$orderid = $this->trends($youjia,$order);
				//盈亏百分百
				$ykbfb = $orderid['ykbfb'];
				//$ykbfb = $orderid['ykbfb']*100;
				//达到客户设置止盈或止亏的百分比时强制平仓
				if($ykbfb >= $v['endprofit'] || $ykbfb >= $v['endloss'] || $time <= time()){
					$bdyy    = $orderid['bdyy'];    //本单盈余
					$jiancj  = $orderid['jc'];      //建仓金额
					$ykzj    = $orderid['ykzj'];	//盈亏资金
					$user = M('accountinfo')->where('uid='.$v['uid'])->find();
					$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
				}
			}
		}
		if($time <= time()){
			F('qiangp',time());
			$this->ajaxReturn($msg);
		}
	} */
	
    //随机生成订单编号
    function build_order_no(){
        return date(time()).substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 3);
    }
        
	
    
}
