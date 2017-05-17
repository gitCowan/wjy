<?php

namespace Daili\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
		
    	header("Content-type: text/html; charset=utf-8");
    	
		R('Daili/User/checklogin');
		
		$tq=C('DB_PREFIX');
    	$user = D("userinfo");
		$order = D("order");
		$product = D("productinfo");
		$account = D("accountinfo");
    	//访问量
		$vid = $this->daili_lower(session('did'));
    	//用户数量
    	$userCount = $user->where('ustatus=0')->count();
    	//今日订单数量，最近7天订单数量，最近30天交易总金额，订单信息
		$where1['selltime'] = array('GT',strtotime(date('Y-m-d')));
		$where1['uid'] 		= array('in',$vid);
    	$orderDay = $order->where($where1)->count();
		$where2['selltime'] = array('GT',strtotime("-7 day"));
		$where2['uid'] 		= array('in',$vid);
		$orderCount = $order->where($where2)->count();
		$where3['selltime'] = array('GT',strtotime("-30 day"));
		$where3['uid'] 		= array('in',$vid);
		$result = $order->where($where3)->select();
		for($i=0;$i<count($result);$i++){
			$total += ($result[$i]['onumber']*$result[$i]['buyprice']);
		}
		
		//最近30天交易总金额
		$total = number_format($total);
		$orders = $order->where(array('uid'=>array('in',$vid)))->field('uid,pid,orderno,fee,onumber,ostyle,ostaus,buytime')->select();
		foreach($orders as $k=>$v){
			$products = $product->where(array('pid'=>$v['pid']))->field('ptitle,uprice')->find();
			$orders[$k]['ptitle'] = $products['ptitle'];
			$orders[$k]['uprice'] = $products['uprice'];
			$userinfo = $user->where(array('uid'=>$v['uid']))->field('username')->find();
			$orders[$k]['username'] = $userinfo['username'];
		}
		//产品信息展示
		$plist = $product->order('pid desc')->limit(5)->select();
		$this->assign('orderDay',$orderDay);
    	$this->assign('userCount',$userCount);
		$this->assign('orderCount',$orderCount);
		$this->assign('total',$total);
		$this->assign('orders',$orders);
		$this->assign('plist',$plist);
		
		$this->display();
	}

	public function daili_lower($did){
		$userinfo = M('userinfo')->where("uid=$did")->find();
		$data = M('userinfo')->where(array('vid'=>$userinfo['uid']))->field('uid')->select();
		
		if($data){
			foreach($data as $k=>$v){
				$acc .= $v['uid'].',';
			}
		}
		return $acc;
	}

	
	public function olist(){
		//获取所有没有平仓的订单
		$tq=C('DB_PREFIX');
		$orders = D('order');
		$jo = D('journal');
		$detailed = A('Home/Detailed');
		$orderno = $detailed->build_order_no();
		$field = $tq.'order.oid as oid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.onumber as onumber,'.$tq.'productinfo.wave as wave,'.$tq.'order.endprofit as endprofit,'.$tq.'order.endloss as endloss,'.$tq.'catproduct.cid as cid,'.$tq.'productinfo.uprice as uprice,'.$tq.'order.uid as uid,'.$tq.'order.ptitle as ptitle,'.$tq.'order.pid as pid,'.$tq.'accountinfo.balance as balance,'.$tq.'userinfo.username as username,'.$tq.'order.ostyle as ostyle,'.$tq.'order.fee as fee,'.$tq.'catproduct.myat as myat';
		//$olist = $orders->where('ostaus=0')->select();
		$order=$orders->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')
        ->join($tq.'catproduct on '.$tq.'productinfo.cid='.$tq.'catproduct.cid')->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid')->join($tq.'accountinfo on '.$tq.'order.uid='.$tq.'accountinfo.uid')->field($field)->where('ostaus=0')->select();
		//获取最新产品价格
		$yprice = $this->price();//油价
		$byprice = $this->byprice();//白银价
		$toprice = $this->toprice();//铜价
		//设置盈亏比，爆仓
		foreach($order as $k => $v){
			$uid = $order[$k]['uid'];					//用户id
			$pid = $order[$k]['pid'];					//产品id
			$uoid = $order[$k]['uoid'];					//上级用户id
			$balance = $order[$k]['balance'];			//账户余额
			$username = $order[$k]['username'];			//用户名
			$fee = $order[$k]['fee'];					//手续费
			$ptitle = $order[$k]['ptitle'];				//产品
			$endprofit = $order[$k]['endprofit'];		//止盈
			$endloss = $order[$k]['endloss'];			//止亏
			$buyprice = $order[$k]['buyprice'];			//买入价格
			$onumber = $order[$k]['onumber'];			//买入数量
			$cid = $order[$k]['cid'];					//产品分类id，用于区分产品现价，1代表油价、2代表白银、3代表铜
			$ostyle = $order[$k]['ostyle'];				//涨、跌，0代表涨、1代表跌
			$wave = $order[$k]['wave'];					//浮动
			$uprice = $order[$k]['uprice'];				//单价
			$oid = $order[$k]['oid'];					//订单id
			$myat = $order[$k]['myat'];					//波动，目前只有油的波动是100，其他的都是1
			$payprice = $onumber*$uprice;				//保障金
			$min_payprice = $payprice*0.3;				//最低限制
			if($ostyle==0){
				if($cid==1){
					$ploss = round(($yprice-$buyprice)*$onumber*$wave*$myat,2);			//盈亏资金	
				}elseif($cid==2){
					$ploss = round(($byprice-$buyprice)*$onumber*$wave*$myat,2);		//盈亏资金
				}else{
					$ploss = round(($toprice-$buyprice)*$onumber*$wave*$myat,2);		//盈亏资金
				}
			}else{
				if($cid==1){
					$ploss = round(($buyprice-$yprice)*$onumber*$wave*$myat,2);			//盈亏资金	
				}elseif($cid==2){
					$ploss = round(($buyprice-$byprice)*$onumber*$wave*$myat,2);		//盈亏资金
				}else{
					$ploss = round(($buyprice-$toprice)*$onumber*$wave*$myat,2);		//盈亏资金
				}
			}
			$percentage = round($ploss/($uprice*$onumber)*$myat,2);			//盈亏百分比
			$surplus = $payprice+$ploss;									//本单盈余	
			
			$myprice=M('accountinfo')->where('uid='.$uid)->find();
            $acco= M('accountinfo');
            $acco->uid=$uid;
            $acco->balance=$myprice['balance']+$surplus;
            $acco->save();
			/**
			 * 写入记录
			 * 爆仓记录
			 * */
			$jour['jno'] = $orderno;			
			$jour['uid'] = $uid;
			$jour['jtype'] = '爆仓';
			$jour['jtime'] = date(time());
			$jour['number'] = $onumber;
			$jour['remarks'] = $ptitle;
			$jour['balance'] = $balance+$surplus;
			$jour['jusername'] = $username;
			$jour['jostyle'] = $ostyle;
			$jour['juprice'] = $uprice;
			$jour['jfee'] = $fee;
			$jour['jbuyprice'] = $buyprice;
			if($cid==1){
				$jour['jsellprice'] = $yprice;	
			}elseif($cid==2){
				$jour['jsellprice'] = $byprice;
			}else{
				$jour['jsellprice'] = $toprice;
			}
			$jour['jaccess'] = $surplus;
			$jour['jploss'] = $ploss;
			$jour['oid'] = $oid;
			$jour['explain'] = '系统自动爆仓';
			
			/**
			 * 保障金亏空，自动平仓
			 * 按盈亏比判断是否爆仓
			 * */
			//判断盈余是否为0，小于0表示保证金已经亏空自动平仓
			if($surplus<=$min_payprice){				
				$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$yprice,'ploss'=>$ploss));
				$jo->add($jour);
			}else{
				//涨，求盈亏以及盈亏百分比
				if($ostyle==0){
					//判断当前百分比，如果大于等于0，和止盈作比较
					if($percentage>=0){
						//如果止盈不为0，继续执行爆仓操作，否则不执行任何操作
						if($endprofit!=0){
							//比较当前盈亏百分比，如果大于设置盈亏百分比，爆仓立即平仓，如果超出设置百分比按照设置百分比盈利	
							if($percentage>=$endprofit){
								//平仓
								$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$yprice,'ploss'=>$ploss));
								$jo->add($jour);
							}
						}	
					}else{
						//如果止亏不为0，继续执行，否则不执行任何操作
						if($endloss!=0){
							//比较当前盈亏百分比，如果大于设置盈亏百分比，爆仓立即平仓，如果超出设置百分比按照设置百分比盈利
							if(abs($percentage)>=$endloss){
								//平仓
								$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$yprice,'ploss'=>$ploss));
								$jo->add($jour);
							}
						}
					}
				}else{
					//跌，求盈亏百分百
					//判断当前百分比，如果大于等于0，和止盈作比较
					if($percentage>=0){
						//如果止盈不为0，继续执行爆仓操作，否则不执行任何操作
						if($endprofit!=0){
							//比较当前盈亏百分比，如果大于设置盈亏百分比，爆仓立即平仓，如果超出设置百分比按照设置百分比盈利	
							if($percentage>=$endprofit){
								//平仓
								$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$yprice,'ploss'=>$ploss));
								$jo->add($jour);
							}
						}	
					}else{
						//如果止亏不为0，继续执行，否则不执行任何操作
						if($endloss!=0){
							//比较当前盈亏百分比，如果大于设置盈亏百分比，爆仓立即平仓，如果超出设置百分比按照设置百分比盈利
							if(abs($percentage)>=$endloss){
								//平仓
								$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$yprice,'ploss'=>$ploss));
								$jo->add($jour);
							}
						}
					}
				}
			}
		}
		
		
		//echo $orders->getLastSql();
		$this->assign('olist',$order);
		$this->display();
	}
		//调取分类的点差
    function selectcid($cid){
        $str=M('catproduct')->where('cid='.$cid)->find();
        return  $str;
    }
}