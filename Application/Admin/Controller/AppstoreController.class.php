<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class AppstoreController extends Controller {
	
	/***************版本升级*******************/
	
	public function version(){
		//获取版本信息
		$post_data['type'] = 'versionInfo';
		$post_data['url']  = $_SERVER['HTTP_HOST'];
		$versionInfo=$this->https_request('http://weipanup.workwx.cn/index.php/Market/Index/query',$post_data);
		$info=json_decode($versionInfo,true);
		$this->assign('info',$info['msg']);
		//读取本文件的版本号
		$files = './Application/Admin/Controller/VersioninfoAction.class.php';
		$contents = file_get_contents($files);
		$this->assign('nowversion',$contents);
		//判断是否有安装
		$nowversion=str_replace('.','',$info['msg']['No_id']);
		$contents=str_replace('.','',$contents);
		if($nowversion>$contents){
			$this->assign('status',1);		
		}
		//获取更新记录
		$post_data['type'] = 'up_record';
		$post_data['url']  = $_SERVER['HTTP_HOST'];
		$up_record=$this->https_request('http://weipanup.workwx.cn/index.php/Market/Index/query',$post_data);
		$up_record=json_decode($up_record,true);
		$this->assign('up_record',$up_record['msg']);
		
		$this->display();
	}


	public function query(){
		if($_POST['query']==1){
			//一键更新步骤  发出去自己的版本和自己需要更新的请求，根据返回的文件包 下载并解压到本地 执行数据库  返回更新成功一个版本，向文件写入最高版本
			$files = './Application/Admin/Controller/VersioninfoAction.class.php';
			$contents = file_get_contents($files); //读取版本号
			
			$post_data['type']='version_up';
			$post_data['p_v']=$contents;
			$post_data['url']=$_SERVER['HTTP_HOST'];
			$versionInfo=$this->https_request('http://weipanup.workwx.cn/index.php/Market/Index/query',$post_data);
			$content=json_decode($versionInfo,true);
			if($content['msgcode']==1004) {echo json_encode(array('status'=>7));exit;}//您未经授权
			if($content['msgcode']==1003) {echo json_encode(array('status'=>2));exit;}//您已经是最新版本
			$fileTemp='./Data/Conf/logs/Temp/updatax_'.$content['msg']["id"].strrchr($content['msg']['path'],'.');//存放路劲
			
			if(file_exists('')) unlink($fileTemp);
			$down_file=$this->httpcopy('http://'.$content['msg']['path'],$fileTemp);
			
			if(!$down_file['http_code']){
				echo json_encode(array('status'=>3));exit;//下载失败
			}
			$zip = new \Think\Phpzip();
			
			$status=$zip->unZip($fileTemp,'./');
			
			unlink($fileTemp);
			if(!$status){
				echo json_encode(array('status'=>5));exit;
			}
			$sql_file='sql.sql';
			if(file_exists($sql_file))
			{
				$sql= file($sql_file);
				$this->sql_query($sql);
				unlink($sql_file);
			} 
			
			file_put_contents($files,$content['msg']['No_id']);
			echo json_encode(array('status'=>6));
			exit;
		}	
	}
	//跳过
	public function jump(){
		if($_POST['jump']==1){
			$files = './Application/Admin/Controller/VersioninfoAction.class.php';
			$contents = file_get_contents($files); //读取版本号	
			$post_data['type']='jump_version';
			$post_data['p_v']=$contents;
			$post_data['url']=$_SERVER['HTTP_HOST'];
			$versionInfo=$this->https_request('http://weipanup.workwx.cn/index.php/Market/Index/query',$post_data);			
			$content=json_decode($versionInfo,true);
			dump($content);die;
			if($content['msgcode']==1003){				//您已经是最新版本
				echo json_encode(array('status'=>11));exit;
			}
			if($content['msgcode']==1100){
				file_put_contents($files,$content['msg']['No_id']);
				echo json_encode(array('status'=>10,'up_id'=>$content['msg']['up_id']));exit;
			}
			
		}
	}
	function https_request($url, $data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); //设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_REFERER,'http://'.$_SERVER["SERVER_NAME"]);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		$output = curl_exec($curl);
		
		curl_close($curl);
		return $output;
	}
		
	private function httpcopy($url, $file="", $timeout=60)
	{
		$file = empty($file) ? pathinfo($url,PATHINFO_BASENAME) : $file;
		$dir = pathinfo($file,PATHINFO_DIRNAME);
		!is_dir($dir) && @mkdir($dir,0755,true);
		$url = str_replace(" ","%20",$url);
		if(function_exists('curl_init')) {		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$temp = curl_exec($ch);
			$status=curl_getinfo($ch);			
			if(file_exists($file))
				unlink($file);
			if(@file_put_contents($file, $temp) && !curl_error($ch)) {
				return $status;
			} else {
				return false;
			}
		}else{
			$opts = array(
				"http"=>array(
				"method"=>"GET",
				"header"=>"",
				"timeout"=>$timeout)
			);
			$context = stream_context_create($opts);
			if(@copy($url, $file, $context)) {
				return $file;
			} else {
				return false;
			}
		}
	}
	
	

	
	
	
	
	
	
	
}