<?php
namespace Web\Controller;
use Think\Controller;
class IndexController extends CommonController {
	
    public function index(){
       // $catgood  = M('catproduct')->where(array('status'=>1))->limit(3)->select();
		$catgood  = M('catproduct')->where(array('status'=>1))->select();
		//$count    = M('catproduct')->where(array('status'=>1))->limit(3)->count();
		$count    = 3;
		$goods    = M('productinfo')->select();
		$uid = $this->uid;
		$userinfo = R('Web/Common/userinfo',array($uid));
		$user     = R('Web/Common/accountinfo',array($uid));
		$user['portrait'] = $userinfo['portrait'];
		$user['upwd'] 	  = $userinfo['upwd'];
		$user['username'] = $userinfo['username'];
		$user['utel']     = $userinfo['utel'];
		$user['balance']     = $userinfo['balance'];
		// dump(1);die;
		$this->assign('user',$user);
        $isopen=$this->isopen();
        $this->assign('isopen',$isopen);
		$this->assign('count',$count);
        $this->assign('goods',$goods);
		$this->assign('catgood',$catgood);
		//所有的优惠券
		$tq	  = C('DB_PREFIX');
		$sum  = M('experienceinfo')->join($tq.'experience on '.$tq.'experienceinfo.eid='.$tq.'experience.eid')->where($tq.'experienceinfo.uid='.$uid.' and '.date(time()).' < '.$tq.'experienceinfo.endtime and '.$tq.'experienceinfo.getstyle=0')->count();
		$this->assign('sum',$sum);
		include 'phpqrcode.php';   
		$confirm=rand(100000,999999);
		// cookie('yz',$confirm,600);
		// $data['wecha_id']='';
		$data['zt']=0;
		S($confirm,$data,600);
		S(cookieyz,$confirm,600);
		$value = 'http://'.$_SERVER['SERVER_NAME'].'/index.php/Web/Index/wxcode/codename/'.$confirm.'.html';
		//二维码内容   
		$errorCorrectionLevel = 'L';//容错级别   
		$matrixPointSize = 4.5;//生成图片大小   
		//生成二维码图片   
		\QRcode::png($value, './Uploads/qcode/qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);   
		$logo = './Uploads/qcode/logo.png';//准备好的logo图片   
		$QR = './Uploads/qcode/qrcode.png';//已经生成的原始二维码图   
		if ($logo !== FALSE) {   
			$QR = imagecreatefromstring(file_get_contents($QR));   
			$logo = imagecreatefromstring(file_get_contents($logo));   
			$QR_width = imagesx($QR);//二维码图片宽度   
			$QR_height = imagesy($QR);//二维码图片高度   
			$logo_width = imagesx($logo);//logo图片宽度   
			$logo_height = imagesy($logo);//logo图片高度   
			$logo_qr_width = $QR_width / 5;   
			$scale = $logo_width/$logo_qr_width;   
			$logo_qr_height = $logo_height/$scale;   
			$from_width = ($QR_width - $logo_qr_width) / 2;   
			//重新组合图片并调整大小   
			imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,   
			$logo_qr_height, $logo_width, $logo_height);   
		}   
		//输出图片   
		imagepng($QR, './Uploads/qcode/'.$confirm.'.png');  
		$code='/Uploads/qcode/'.$confirm.'.png';
		$this->assign('code',$code);	
		$this->display();
    }
	public function check(){
		$code=S('cookieyz');
		if($code['zt']==1){
			S('cookieyz',null);
			S($confirm,null);
			$this->ajaxreturn(1);
		}else{
			$this->ajaxreturn(2);
		}
	}
	public function yanzheng(){
		$info['zt']=1;
		S('cookieyz',$info,600);
		$code=S('cookieyz');
		if($code){
			$this->ajaxreturn(1);
		}else{
			$this->ajaxreturn(2);
		}
	}
	public function wxcode(){
		$sessionuid = S('sessionuid');
		if($sessionuid){
			$login='ok';
		}else{
			if(S($_GET['codename'])){
				R('Home/Oauth/index',array(ACTION_NAME,$_GET));die;
			}else{
				$login='no';
			}
		}	
		session('code',$_GET['code']);
		$data=M('qymyapp')->where(array('userid'=>cookie('user_id')))->find();
		$jssdk_info=R('Qyapp/Jssdk/wap_index',array($data['id']));
		$this->assign('jssdk_info',$jssdk_info);
		$this->display($login);
	}
	public function tuichu(){
		S('sessionuid',null);
		$this->success('退出成功');
	}
	
	 //查询网站是否关闭，关闭则不能购买，并且现价变成休市
    public function isopen(){
        $stye = M('webconfig')->where("id=1")->find();
        return $stye;
    }
}