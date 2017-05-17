<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {

    public function index(){
		$catgood = R('Home/Common/catproduct');
		$uid      = session('uid');
		$userinfo = R('Home/Common/userinfo',array($uid));
		if(!$userinfo){
			R('Home/Oauth/index',array(ACTION_NAME,$_GET));
		}
		$user     = R('Home/Common/accountinfo',array($uid));
		$user['portrait'] = $userinfo['portrait'];
		$user['upwd'] 	  = $userinfo['upwd'];
		$user['username'] = $userinfo['username'];
		$user['utel']     = $userinfo['utel'];
		$this->assign('user',$user);
        $isopen=$this->isopen();
        $this->assign('isopen',$isopen);
		$this->assign('catgood',$catgood);
		//所有的优惠券
		$tq	  = C('DB_PREFIX');
		$sum  = M('experienceinfo')->join($tq.'experience on '.$tq.'experienceinfo.eid='.$tq.'experience.eid')->where($tq.'experienceinfo.uid='.$uid.' and '.date(time()).' < '.$tq.'experienceinfo.endtime and '.$tq.'experienceinfo.getstyle=0')->count();
		$num = S('visitsNum'.date('d'));
		if(!$num){
			S('visitsNum'.date('d'),1,24*3600);
		}else{
			$num = $num + 1;
			S('visitsNum'.date('d'),$num,24*3600);
		}
        $color = M('Webconfig')->where('id=1')->getField('tpl');
        $tpl = "tp".$color;

        $this->assign('sum',$sum);
		$this->display($tpl);
    }

	
	public function productList(){
		$data  = R('Home/Common/productcid',array($_POST['cid']));
		$this->ajaxReturn($data);
	}
	
	public function dtrading(){
		$uorder=$this->userorder();
		$this->assign('nolist',$uorder);
		$config = R('Home/Common/webconfig');
		$time   = ($config['day']*24*3600 + $config['hour']*3600 + $config['minute']*60 + F('qiangp')) - time();
		$catgood = R('Home/Common/catproduct');
		$this->assign('catgood',$catgood);
		$this->assign('time',$time);
		$this->assign('isopen',$config);
		$this->display();
	}	
	
    //查询网站是否关闭，关闭则不能购买，并且现价变成休市
    public function isopen(){
		$config = R('Home/Common/webconfig');
        return $config;
    }
    //显示最新资讯
    public function information(){
        $news=M('newsinfo')->where('ncategory=1')->order('nid desc')->limit(3)->select();
        return $news;
    }
    //显示财经要闻Focus
    public function focus(){
		$news = M('newsinfo')->where('ncategory=2')->order('nid desc')->limit(3)->select();
		return $news;
    }
    //显示系统公告Notice
    public function notice(){
		$news = M('newsinfo')->where('ncategory=3')->order('nid desc')->limit(3)->select();
		return $news;
    }
	
	public function newsdata(){
		$code = array_filter(explode(',',$_POST['code']));
		foreach($code as $k=>$v){
			if(time() == S('CheatTime'.$v) || time() == S('CheatTimes'.$v)){
				$price = S('CheatPrice'.$v);
			}else{
				$price = S('price'.$v);
			}
			$result[$k]['code']  	= $v;
			$result[$k]['price'] 	= $price['price'];
			$result[$k]['cid']   	= $price['cid'];
			$result[$k]['diff']  	= $price['diff'];
			$result[$k]['high']  	= $price['high'];
			$result[$k]['open']  	= $price['open'];
			$result[$k]['close'] 	= $price['close'];
			$result[$k]['low']   	= $price['low'];
			$result[$k]['diffRate'] = $price['diffRate'];
		}
		$this->ajaxReturn($result);
	}
	
	
	
    //获取动态油的价格，显示到页面
	public function price(){
		$code = array_filter(explode(',',$_POST['code']));
		foreach($code as $k=>$v){
			if(time() == S('CheatTime'.$v) || time() == S('CheatTimes'.$v)){
				$price = S('CheatPrice'.$v);
			}else{
				$price = S('price'.$v);
			}
			$result[$k]['code']   = $v;
			$result[$k]['price'] = $price['price'];
		}
        $this->ajaxReturn($result);
    }
	
    //根据传回来的id获取商品的信息
    public function selectid(){
        $code  = I('post.code');
		if(time() == S('CheatTime'.$code) || time() == S('CheatTimes'.$code)){
			$price = S('CheatPrice'.$code);
		}else{
			$price = S('price'.$code);
		}
		$good['prices'] = $price['price'];
        $this->ajaxReturn($good);
    }

    //查询当前用户正在交易的订单
    public function userorder(){
        $tq=C('DB_PREFIX');
        $uid = session('uid');
        $userorders=M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')
        ->join($tq.'catproduct on '.$tq.'productinfo.cid='.$tq.'catproduct.cid')->where($tq.'order.uid='.$uid.' and ostaus=0')->select();
		foreach($userorders as $k=>$v){
			$goods = S('price'.$v['title']);
			$userorders[$k]['xinprice'] = $goods['price'];
			
		}
        return $userorders;
    }
	
	//查询订单信息(接收修改后的订单，或者直接平仓，或者购买完后平仓，3中情况)
    public function orderid(){
        $tq=C('DB_PREFIX');
        $orderid=I('orderid');
        $order=M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')
        ->join($tq.'catproduct on '.$tq.'productinfo.cid='.$tq.'catproduct.cid')->where('oid='.$orderid)->find();
    	$order['expend'] = $order['onumber']*$order['uprice'];	//支出
    	$order['paytime'] = date('Y-m-d',$order['buytime']);
		$this->ajaxReturn($order);
    }
	
	//修改订单的止盈和止亏
    public function edityk(){
		$order      = M('order');
        $oid = I('post.oid');
        $arr['endprofit'] = I('post.profit');
        $arr['endloss']   = I('post.loss');
		
        $save = $order->where(array('oid'=>$oid))->save($arr);
		if($save){
			$this->ajaxReturn(1);
		}
    }
		
	public function landpwd(){
		$uid   = session('uid');
		$upwd  = md5($_POST['upwd']);
		$uname = $_POST['username'];
		$arr   = M('Userinfo')->where(array('utel'=>$_POST['utel']))->find();
		$acc   = M('Userinfo')->where("uid=".$uid)->find();
		if($arr){	
			$att['openid']   = $acc['openid'];
			$att['portrait'] = $acc['portrait'];
			$att['portrait'] = $acc['portrait'];
			$att['upwd']     = $upwd;
			if($acc['oid'] && !$arr['oid']){
				$att['oid'] = $acc['oid'];
				$att['cid'] = $acc['cid'];
				$att['vid'] = $acc['vid'];
			}
			M('Userinfo')->where("uid=".$uid)->delete();
			session('uid',$arr['uid']);
			M('Userinfo')->where(array("uid"=>$arr['uid']))->save($att);
		}else{
			$_POST['upwd']  = $upwd;
			$_POST['uname'] = $uname;
			$_POST['utel']  = $_POST['utel'];
			M('Userinfo')->where("uid=".$uid)->save($_POST);
			
			M('accountinfo')->add(array('uid'=>$uid));
		}
		$this->redirect('Index/index');
	}

	public function wap_reset_msg(){
		$result = R('Home/Common/wap_phone',array($_POST['phone']));
		$result['codes'] = $_SESSION['code'];
		$this->ajaxReturn($result);
	}	
}