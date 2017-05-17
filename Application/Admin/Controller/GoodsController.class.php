<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller {
    public function gadd()
	{
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		
		//实例化数据表
		$goods = D('productinfo');
		$goodtype = D('catproduct');
		//获取所有商品分类			
		$catgood = $goodtype->where(array('status'=>1))->select();
		$this->assign('catgood',$catgood);
		//判断如果是post提交，则添加数据，否则显示视图
		if(IS_POST){
			if($goods->create()){
				$result = $goods->add();
				if($result){
					S('productinfoList',null);
					S('productcidList'.I('post.cid'),null);
					$this->success('添加商品成功',U('Goods/glist'));
				}else{
					$this->error('添加商品失败');
				}
			}else{
				$this->error($goods->getError());
			}
		}else{
			$this->display();
		}
	}
	public function glist(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		
		if($_POST){
			$keywords = '%'.I('post.keyword').'%';
			$where['ptitle'] = array('like',$keywords);
		}
		$productinfo = M('productinfo'); // 实例化User对象
		$count      = $productinfo->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$goodlist = $productinfo->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach($goodlist as $k=>$v){
			$cid=M('catproduct')->where(array('cid'=>$v['cid']))->find();
			$price=M('api')->where(array('cid'=>$cid['cid']))->order('id desc')->find();
			$goodlist[$k]['price']=$price['price'];
			$goodlist[$k]['em']=$price['diff'];
			$goodlist[$k]['cname']=$cid['cname'];
			$goodlist[$k]['title']=$cid['title'];
		}
		$this->assign('goodlist',$goodlist);// 赋值数据集
		//$Page -> setConfig('header','共%TOTAL_ROW%条');
		$Page -> setConfig('first','首页');
		$Page -> setConfig('last','共%TOTAL_PAGE%页');
		$Page -> setConfig('prev','上一页');
		$Page -> setConfig('next','下一页');
		$Page -> setConfig('link','indexpagenumb');//pagenumb 会替换成页码
		$Page -> setConfig('theme',' %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$this->assign('page',$Page->show());// 赋值分页输出
		$this->display(); // 输出模板

	}
	public function gtype()
	{
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		
		$goodtype = D('catproduct');
		$typelist = $goodtype->select();
		
		$this->assign('typelist',$typelist);
		$this->display();
	}
	public function api_list()
	{
		
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		
		$goodtype = D('api');
		$count = $goodtype->count();
		$pagecount  = 20;
		$Page       = new \Think\Page($count,$pagecount);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$typelist = $goodtype->where(array('cid'=>$_GET['cid']))->order('time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$Page -> setConfig('first','首页');
		$Page -> setConfig('last','共%TOTAL_PAGE%页');
		$Page -> setConfig('prev','上一页');
		$Page -> setConfig('next','下一页');
		$Page -> setConfig('link','indexpagenumb');//pagenumb 会替换成页码
		$Page -> setConfig('theme',' %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$this->assign('page',$Page->show());// 赋值分页输出
		$this->assign('typelist',$typelist);
		
		$this->display();
	}
	public function editPrice(){
		if($_POST){
			$data = D('api')->where(array("id"=>$_POST['id']))->save(array("price"=>$_POST['price']));
			if($data){
				$this->ajaxReturn(1);
			}else{
				$this->ajaxReturn(2);
			}
		}
	}

	public function addPrice(){
		if($_POST){
			$title = M('Catproduct')->where(array('cid'=>$_POST['cid']))->getfield('title');
			$_POST['code']  = $title;
			$_POST['time']  = time()+$_POST['hour']*3600+$_POST['minute']*60+$_POST['second'];
			$_POST['high']  = S('high'.$title);
			$_POST['low']   = S('low'.$title);
			$_POST['close'] = S('close'.$title);
			$_POST['open']  = S('open'.$title);
			$data = D('api')->add($_POST);
			if($data){
				$arr = array('high'=>S('high'.$title),
							 'low'=>S('low'.$title),
							 'close'=>S('close'.$title),
							 'open'=>S('open'.$title),
							 'price'=>$_POST['price'],
							 'diff'=>$_POST['diff'],
							 'diffRate'=>$_POST['diffRate'],
							 'cid'=>$_POST['cid'],
							 'code'=>$title,
							 'time'=>time()
							);
				S('CheatPrice'.$title,$arr,$_POST['time']+10);
				S('CheatTime'.$title,$_POST['time'],$_POST['time']+5);
				S('CheatTimes'.$title,$_POST['time']+1,$_POST['time']+5);
				
				
				
				$this->ajaxReturn(1);
			}else{
				D('api')->where("id=$data")->delete();
				$this->ajaxReturn(2);
			}
		}
	}

	public function gtedit(){
		$title = M('catproduct')->where(array('cid'=>$_GET['cid']))->getfield('title');
		S('catproductList',null);
		S('catproductcid'.$_GET['cid'],null);
		S('catproductcode'.$title,null);
		if($_GET['status']==1){
			M('catproduct')->where(array('cid'=>$_GET['cid']))->save(array('status'=>0));
		}else{
			M('catproduct')->where(array('cid'=>$_GET['cid']))->save(array('status'=>1));
		}
		$this->success('操作成功');
	}
	
	public function gtypeadd()
	{
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		if(IS_POST){
			//实例化数据表
			$goodtype = D('catproduct');
			//自动验证表单
			if($goodtype->create()){
				//添加数据
				$result = $goodtype->add();
				if($result){
					S('catproductList',null);
					$this->success('添加成功',U('Goods/gtype'));
				}else{
					$this->error('添加失败');
				}
			}else{
				//自动验证返回结果
				$this->error($goodtype->getError());
			}
		}else{
			$this->display();	
		}		
	}
	public function gedit()
	{
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		
		$tq=C('DB_PREFIX');
		$pinfo = D('productinfo');
		$catp = D('catproduct');
		//判断执行，如果是post提交，执行修改方法，否则显示页面
		if(IS_POST){
			
			//自动验证表单
			if($pinfo->create()){
				//获取修改表单的数据，并做处理
				$postpid = I('post.pid');
				$data['ptitle'] = I('post.ptitle');
				$data['company'] = I('post.company');
				$data['cid'] = I('post.cid');
				$data['uprice'] = I('post.uprice');
				$data['feeprice'] = I('post.feeprice');
				$data['wave'] = I('post.wave');
				$data['patx'] = I('post.patx');
				$data['patj'] = I('post.patj');
				$data['num'] = I('post.num');
				$result = $pinfo->where('pid='.$postpid)->save($data);

				if($result === FALSE){
					$this->error("修改失败！");
				}else{
					S('productinfoList',null);
					S('productcidList'.I('post.cid'),null);
					$this->success("修改成功",U('Goods/glist'));
				}
			}else{
				//自动验证返回结果
				$this->error($pinfo->getError());
			}
		}else{
			//通过获取的id查找该条数据
			$getpid = I('get.pid');
			$editgood = $pinfo->join($tq.'catproduct on '.$tq.'productinfo.cid='.$tq.'catproduct.cid')->where('pid='.$getpid)->find();
			//print_r($editgood);die;
			//商品分类获取
			$pclist = $catp->where(array('status'=>1))->select();
			//获取油，白银，铜的实时价格

			//当前期数
			$allorder=M('order')->where(array('pid'=>$getpid))->count();
			$qishu=ceil($allorder/100);
			for ($a=0; $a <$qishu ; $a++) {
				//判断是否平仓
				$is_pingcang=M('order')->where(array('pid'=>$getpid,'ostaus'=>0))->limit($i*100,($i+1)*100)->select();

				//买涨的多少手
				$order=M('order')->where(array('pid'=>$getpid,'ostyle'=>0))->limit($i*100,($i+1)*100)->select();
				$ab=0;
				for ($i=0; $i <count($order) ; $i++) { 
					$ab+=$order[$i]['onumber'];
				}
				$ad[$a]=$ab;

				//买跌的
				$order2=M('order')->where(array('pid'=>$getpid,'ostyle'=>1))->limit($i*100,($i+1)*100)->select();
				$ab1=0;
				for ($i=0; $i <count($order2) ; $i++) { 
					$ab1+=$order2[$i]['onumber'];
				}
				$ac[$a]=$ab1;
			}
			$this->assign('is_pingcang',$is_pingcang);
			$this->assign('qishu',$qishu);
			$this->assign('order',$ad);
			$this->assign('order2',$ac);

			$this->assign('pclist',$pclist);
			$this->assign('editgood',$editgood);
			$this->display();
		}
	}

	public function pingcangcl(){
		if (IS_POST) {
			$data_p=I('post.');
			$order=M('order')->where(array('pid'=>$data_p['pid'],'ostaus'=>0))->limit(($data_p['qishu']-1)*100,$data_p['qishu']*100)->select();
			$danjia=M('productinfo')->where(array('pid'=>$data_p['pid']))->getField('uprice');
			for ($i=0; $i <count($order) ; $i++) { 
				if ($order[$i]['ostyle']==0) {
					if ($data_p['pingcang']==0) {
						$yingli=$danjia*$order[$i]['onumber']*(1+$data_p['wave']/100);
						M('accountinfo')->where(array('uid'=>$order[$i]['uid']))->setInc('balance',$yingli);
						$data['ostaus']=1;
						$data['sellprice']=$order[$i]['buyprice'];
						$data['selltime']=time();
						$data['ploss']=$yingli;
						M('order')->where(array('oid'=>$order[$i]['oid']))->save($data);
					}else{
						$yingli=$danjia*$order[$i]['onumber'];
						$data['ostaus']=1;
						$data['sellprice']=$order[$i]['buyprice'];
						$data['selltime']=time();
						$data['ploss']='-'.$yingli;
						M('order')->where(array('oid'=>$order[$i]['oid']))->save($data);
					}
					
				}else{
					if ($data_p['pingcang']==1) {
						$yingli=$danjia*$order[$i]['onumber']*(1+$data_p['wave']/100);
						M('accountinfo')->where(array('uid'=>$order[$i]['uid']))->setInc('balance',$yingli);
						$data['ostaus']=1;
						$data['sellprice']=$order[$i]['buyprice'];
						$data['selltime']=time();
						$data['ploss']=$yingli;
						M('order')->where(array('oid'=>$order[$i]['oid']))->save($data);
					}else{
						$yingli=$danjia*$order[$i]['onumber'];
						$data['ostaus']=1;
						$data['sellprice']=$order[$i]['buyprice'];
						$data['selltime']=time();
						$data['ploss']='-'.$yingli;
						M('order')->where(array('oid'=>$order[$i]['oid']))->save($data);
					}

				}
			}
			$this->success("平仓成功！",U("/Admin/Goods/gedit/pid/".$data_p['pid'].""));
		}
	}
	public function gdel(){
		$pinfo = D('productinfo');
		//批量删除id
		$arrpid = I('post.pid');
		//单个删除
		$pid = I('get.pid');
		if(IS_POST){
			//批量删除
			$result = $pinfo->where('pid in('.implode(',',$arrpid).')')->delete();
			if($result!==FALSE){
				S('productinfoList',null);
				$this->success("成功删除{$result}条！",U("Goods/glist"));
			}else{
				$this->error('删除失败！');
			}
		}else{
			$cid = $pinfo->where('pid='.$pid)->getfield('cid');
			//单条记录删除
			$result = $pinfo->where('pid='.$pid)->delete();
			if($result!==FALSE){
				S('productinfoList',null);
				S('productcidList'.$cid,null);
				$this->success("成功删除！",U("Goods/glist"));
			}else{
				$this->error('删除失败！');
			}
		}
	}
	//	//删除栏目
	public function gtdel(){
       $goodtype = D('catproduct');

		//单个删除
		$cid = I('get.cid');
		$result = $goodtype->where('cid='.$cid)->delete();
		if($result!==FALSE){
			$this->success("成功删除！",U("Goods/gtype"));
		}else{
			$this->error('删除失败！');
		}
	}

	//最新价格
	public function zuixin_price(){
		$data = M('catproduct')->where("status=1")->field('cid,title')->select();
		foreach($data as $k=>$v){
			
			$arr[$k]['cid']   = $v['cid'];		
			$arr[$k]['title'] = $v['title'];
			if(time() == S('CheatTime'.$v['title']) || time() == S('CheatTimes'.$v['title'])){
				$price = S('CheatPrice'.$v['title']);
			}else{
				$price = S('price'.$v['title']);
			}
			$arr[$k]['price'] = $price['price'];
		}	
		$this->ajaxReturn($arr);
	}

	
	//调取分类的点差
    public function diancha($cname){
        $at= M('catproduct')->where("cname='$cname'")->find();
        return $at;
    }
}