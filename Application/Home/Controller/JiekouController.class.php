<?php
namespace Home\Controller;

use Think\Controller;

class JiekouController extends Controller
{	
	
	

	public function tree($code){
		$where['code'] = $code;
		$where['time'] = array('ELT',time());
		$list = M('Api')->where($where)->order('time desc')->limit(150)->select();
		foreach($list as $k=>$v){
			$a = '';
			$arr = date('Y-m-d H:i',$v['time']);
			$a[] = $v['time']*1000;
			$a[] = (float)$v['open'];
			$a[] = (float)$v['high'];
			$a[] = (float)$v['low'];
			$a[] = (float)$v['close'];
			$a[] = $arr;
			$a[] = (float)$v['price'];
			$b[] = $a;
		}
		return $b;
	}
	
	
	public function ajaxKchart(){
		if($_GET['interval'] == '1'){
			$aqq = $this->tree($_GET['code']);
			sort($aqq);
			$this->ajaxReturn($aqq);
		}else{
			$att = S('ajaxKchart'.$_GET['code'].$_GET['interval']);
			if(!$att){
				$str = date('YmdHi',time());
				$c = $this->w_time($str,$_GET['interval']);
				for($i=0;$i<40;$i++){
					$interval = $_GET['interval']*60;
					$where['time'] = array('between',array($c-$interval*($i+1),$c-$interval*$i)); 
					$time = $c-$interval*$i;
					$where['code'] = $_GET['code'];
					$data = M('api')->where($where)->order('time asc')->field('price')->select();
					if($data){
						foreach($data as $k=>$v){
							$aee[] = $v['price'];
						}
						$att[] = $this->w_list($aee,$time);
						$aee='';
						sort($att);
					}
				}
				S('ajaxKchart'.$_GET['code'].$_GET['interval'],$att,$interval);
			}

			$this->ajaxReturn($att);

		}
	}
	
	public function w_time($str,$interval){
		if($interval == '1d'){
			$a = substr($str, 0, -4);
			$b = $a.'0000';
		}elseif($interval == '10'){
			$a = substr($str, 0, -1);
			$b = $a.'0';
		}else{
			$wei = substr($str, -2);
			$a = substr($str, 0, -2);
			if($wei<30 || $interval == '60'){
				$b = $a.'00';
			}else{
				$b = $a.'30';
			}
		}
		$c = strtotime($b);
		return $c;
	}

	public function w_list($list,$time){
		$coun  = count($list)-1;
		$open  = $list[0];
		$close = $list[$coun];
		rsort($list);
		$high  = $list[0];
		$low   = $list[$coun];
		$a = '';
		$a[] = $time*1000;
		$a[] = (float)$open;
		$a[] = (float)$high;
		$a[] = (float)$low;
		$a[] = (float)$close;
		$a[] = date('Y-m-d H:i',$time);
		return $a;
	}
	
	public function ajaxLatest(){ 
		if(time() == S('CheatTime'.$_GET['code']) || time() == S('CheatTimes'.$_GET['code'])){
			$afterprice = S('CheatPrice'.$_GET['code']);
		}else{
			$afterprice = S('price'.$_GET['code']);
		}
		
		
		$lastPrice  = S('beforeprice'.$_GET['code']);
		if((float)$afterprice['price'] != (float)$lastPrice){
			$time = date('Y-m-d H:i',$afterprice['time']);
			$a[]  = $afterprice['time']*1000;
			$a[]  = (float)$afterprice['open'];
			$a[]  = (float)$afterprice['high'];
			$a[]  = (float)$afterprice['low'];
			$a[]  = (float)$afterprice['price'];
			$a[]  = $time;
			$a[]  = (float)$afterprice['price'];
			S('beforeprice'.$_GET['code'],$afterprice['price']);
			$this->ajaxreturn($a);
		}
		
	}
	
	public function cid($code){
		$list = M('Catproduct')->where(array('title'=>$code))->find();
		return $list['cid'];
	} 
}

