<?php

namespace Admin\Controller;
use Think\Controller;
class SuperController extends Controller {
	
	//管理员列表
    public function slist()
    {
    	//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		
		$users = D('userinfo');
		//分页
		$count = $users->where('otype=3')->count();
        $pagecount = 20;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
		//查询用户和账户信息
		$ulist = $users->where('otype=3')->order(	'uid desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		$this->assign('page',$show);
		$this->assign('ulist',$ulist);
		$this->display();
		
	}
	//添加管理员
	public function sadd()
	{
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		//实例化userinfo表
		$users = D('userinfo');
		if(IS_POST){
			if($users->create()){
				$users->utime = time();
				$users->upwd  = md5(I('post.upwd'));
				$users->otype = 3;
				$result = $users->add();
				if($result){
					$this->success('添加管理员成功',U('Super/slist'));
				}else{
					$this->error('添加失败');
				}
			}else{
				$this->error($users->getError());
			}
		}else{
			$this->display();	
		}
	}
	
	public function ftype(){
		$result = M('Tc')->select();
		$this->assign('typelist',$result);
		$this->display();
	}

	public function ftypeadd(){
		$data = M('Tc')->where(array('id'=>$_GET['id']))->find();
		if(IS_POST){
			if($_POST['pid']){
				$result = M('Tc')->where(array('id'=>$_POST['pid']))->save($_POST);
			}else{
				$result = M('Tc')->add($_POST);
			}
			if($result){
				S('tc',null);
				$this->success('操作成功',U('Super/ftype'));
			}else{
				$this->error('操作失败');
			}
		}else{
			$this->assign('conf',$data);
			$this->display();	
		}
	}

	public function config_ajax(){
		// dump($_POST['name']);die;
		$data=M('pay')->where(array('type'=>$_POST['name']))->find();
		
		//$data=F('pay_'.$_POST['name']);
		$this->ajaxReturn($data);
	}
	public function config(){
		if(IS_POST){
			$_POST['CALLBACK']=U('Home/Index/callback',array('type'=>$_POST['type']));
			F('THINK_SDK_'.$_POST['type'],$_POST);
			$this->success('修改成功！');
		}else{
			$data=F('THINK_SDK_qq');
			$this->assign('data',$data);
			$this->display();	
		}
	}
	public function pay(){
		if(IS_POST){
			//$_POST['CALLBACK']=U('Home/Index/callback',array('type'=>$_POST['type']));
			$data=M('pay')->where(array('type'=>$_POST['type']))->find();
			if($_POST['status'] == 1){
				M('pay')->where(array('status'=>1))->save(array('status'=>0));
			}
			if($data){
				M('pay')->where(array('type'=>$_POST['type']))->save($_POST);
			}else{
				M('pay')->add($_POST);
			}
			$this->success('修改成功！');
		}else{
			$data=M('pay')->where(array('type'=>'Wxpay'))->find();
			// dump($data);die;
			$this->assign('data',$data);
			$this->display();	
		}
	}
	//基本设置
	public function esystem(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		$config = D('webconfig');
		//print_r($_POST);die;
		$where = array('id'=>1);
		$conf = $config->where($where)->find();	
		if(IS_POST){
			
			if($_FILES['input-file']['name']){
				header("Content-type: text/html; charset=utf-8");
				$upload = new \Think\Upload();// 实例化上传类
				$upload->maxSize   =     3145728 ;// 设置附件上传大小
				$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->rootPath  =     'Public/Uploads/'; // 设置附件上传根目录
				$info   =   $upload->upload();
				if(!$info){						// 上传错误提示错误信息    
					$this->error($upload->getError());
				}else{							// 上传成功 获取上传文件信息 
					foreach($info as $file){      
						$idcover= $file['savepath'].$file['savename'];    
					}
				}
				$_POST['code'] = 'http://'.$_SERVER['SERVER_NAME'].'/Public/Uploads/'.$idcover;
			}
			$result = $config->where($where)->save($_POST);
			//print_r($where);die;
			if($_POST['day'] != $conf['day'] || $_POST['hour'] != $conf['hour'] || $_POST['minute'] != $conf['minute']){
		
				F('qiangp',time());
			}
			if($result){
				S('Webconfig',null);
				$this->success("修改成功");
			}else{
				$this->error("修改失败");
			}
		}	
        else{
				
			$this->assign('conf',$conf);
			$this->display();
		}
		
	}
	//修改管理员
	public function sedit()
    {
    	//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		$users = D('userinfo');
		if(IS_POST){
			if($users->create()){
				$uid = I('post.uid'); 
				$data['otype'] = I('post.otype'); 
				$data['ustatus'] = I('post.ustatus');
				$data['oid'] = I('post.oid');
				$data['utime'] = I('post.utime');
				$data['upwd'] = md5(I('post.upwd'));
				$data['utel'] = I('post.utel');
				$result = $users->where('uid='.$uid)->save($data);
				if($result === FALSE){
					$this->error("管理员修改失败！");
				}else{
					$this->success("管理员修改成功",U('Super/slist'));
				}
			}else{
				$this->error($users->getError());
			}
		}else{
			//根据修改管理员的id读取数据
			$uid = I('get.uid');
			$ult = $users->where('uid='.$uid)->find();			
			$this->assign('ult',$ult);
			$this->display();
		}
	}
	//删除管理员
	public function sdel()
    {
    	$user = D('userinfo');
		//单个删除
		$uid = I('get.uid');
		$result = $user->where('uid='.$uid)->delete();
		if($result!==FALSE){
			$this->success("成功删除管理员！",U("Super/slist"));
		}else{
			$this->error('删除失败！');
		}
	}
	//备份数据
	public function backupdb()
	{
		//判断用户是否登录
		$user=A('Admin/User');//实例化其他模块中的方法
		$user->checklogin();
		
		$users=D('userinfo');//获取用户信息
		$username=$users->field('username')->find();
		
		
		
		
		mysql_query("set names 'utf8'");
		$mysql = "set charset utf8;\r\n";
		$q1 = mysql_query("show tables");
		while ($t = mysql_fetch_array($q1))
		{
		$table = $t[0];
		$q2 = mysql_query("show create table `$table`");
		$sql = mysql_fetch_array($q2);
		$mysql .= $sql['Create Table'] . ";\r\n";
		$q3 = mysql_query("select * from `$table`");
		while ($data = mysql_fetch_assoc($q3))
			{
				$keys = array_keys($data);
				$keys = array_map('addslashes', $keys);
				$keys = join('`,`', $keys);
				$keys = "`" . $keys . "`";
				$vals = array_values($data);
				$vals = array_map('addslashes', $vals);
				$vals = join("','", $vals);
				$vals = "'" . $vals . "'";
				$mysql .= "insert into `$table`($keys) values($vals);\r\n";
			} 
		} 
 
		$filename = APP_PATH.'backup/'.date('Y-m-d_H-i-s').".sql"; //存放路径，默认存放到项目最外层
		//echo $filename;
		$fp = fopen($filename, 'w');
		fputs($fp, $mysql);
		fclose($fp);
/* 		echo "数据备份成功";
				$this->display(); */
				$this->success("数据备份成功",U('Index/index'));
	}
	
	//短信设置
	public function sms()
	{	
		$table = D('Message');
		$data  = $table->find(); 
		if($_POST){
			if(!$data){
				$acc = $table->add($_POST);
			}else{
				$acc = $table->where(array('id'=>$data['id']))->save($_POST);
			}
			if($acc){
				S('Message',null);
				$this->success('操作成功');
			}else{
				$this->error('操作失败');
			}
		}else{
			$yu = S('message_yu',$yu);
			if(!$yu){
				vendor('ChuanglanSmsHelper.ChuanglanSmsApi');
				$clapi  = new \ChuanglanSmsApi();
				$result = $clapi->queryBalance();
				$arr    = $clapi->execResult($result);
				
				$data['yu'] = $arr[3];
				$table->where(array('id'=>$data['id']))->save(array('yu'=>$arr[3]));
				S('message_yu',$arr[3],600);
			}
			$this->assign('data',$data);
			$this->display();
		}
	}
	
	
}