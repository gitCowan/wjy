<?php
namespace Home\Controller;

use Think\Controller;

class ShujuController extends Controller
{
    //新浪抓取欧元美元等货币的数据；
    public function allOrder3(){
        if(date('H') == '5'){
            $time = strtotime(date('Y-m-d',strtotime('-3 day')));
            M("Api")->where(array('time'=>array('LT',$time)))->delete();
        }
        $url = 'http://hq.sinajs.cn/?_/&list=fx_susdjpy,fx_sgbpusd,fx_seurusd,fx_saudusd,fx_susdchf';//,hf_SI,hf_GC
        $data = $this->httpGet($url);
        $data2 = explode(';',$data);
        $data3 ="";
        //echo count($data2)-1;exit;
        for($index=0;$index<count($data2)-1;$index++)
        {
            $one = substr( $data2[$index], stripos($data2[$index], "\"")+1, -1);
            $onellist = explode(',',$one);
            $kine = "";
            if(strpos($data2[$index], "hq_str_fx_susdjpy"))//美元兑日元
            {
                //18:01:09,111.331,111.334,111.766,6930,111.776    ,111.81,111.117,111.331,美元兑日元即期汇率,-0.39,      -0.435,0.0062,DUBA-GVA-EUR,118.665,98.989,+***++-+,2017-03-22
                //	现价，         昨收          今开       最高    最低                             涨跌%        涨跌幅  振幅
                //48.62,1.8860,48.62,48.63,   48.87,48.31,22:24:42,47.72,48.76,    18043,0,0,2017-03-15,NYMEX原油
                //现价，涨跌幅，买价，卖价，  最高价，最低价，   ，收盘价，开盘价       持仓量，买量，卖量，名称
                $kine['cid'] = 41;
                $kine['code'] = "USDJPY";
				$kine['price'] =  $onellist[1]*1000;//number_format($onellist[1]*1000, 3, '.', ''); //现价
				$kine['high'] = $onellist[6]*1000;//最高
				$kine['low'] = $onellist[7]*1000;//最低
				$kine['close'] = $onellist[3]*1000;//昨收
				$kine['open'] = $onellist[5]*1000;//今开
				$kine['diff'] = $onellist[11]*1000;//涨跌幅
			}else if(strpos($data2[$index], "hq_str_fx_sgbpusd")){//英镑美元
                //16.870,-0.2955,16.870,16.870,16.980,16.820,22:50:23,16.920,16.890,1076,0,0,2017-03-15,COMEX白银
                //现价，涨跌幅，买价，卖价，  最高价，最低价，   ，收盘价，开盘价       持仓量，买量，卖量，名称
                $kine['cid'] = 39;
                $kine['code'] = "GBPUSD";
				$kine['price'] = $onellist[1]*100000;//number_format($onellist[1], 5, '.', ''); //round($onellist[1], 5);//现价
				$kine['high'] = $onellist[6]*100000;//最高
				$kine['low'] = $onellist[7]*100000;//最低
				$kine['close'] = $onellist[3]*100000;//昨收
				$kine['open'] = $onellist[5]*100000;//今开
				$kine['diff'] = $onellist[11]*100000;//涨跌幅
            }else if(strpos($data2[$index], "hq_str_fx_seurusd")){//欧元美元
                //1199.0,-0.2993,1198.9,1199.0,1204.8,1196.8,22:50:53,1202.6,1198.7,10300,0,0,2017-03-15,COMEX黄金
                //现价，涨跌幅，买价，卖价，  最高价，最低价，   ，收盘价，开盘价       持仓量，买量，卖量，名称
                $kine['cid'] = 42;//编号
                $kine['code'] = "EURUSD";//编码
				$kine['price'] =  $onellist[1]*100000;//number_format($onellist[1], 5, '.', ''); //round($onellist[1], 5);//现价
				$kine['high'] = $onellist[6]*100000;//最高
				$kine['low'] = $onellist[7]*100000;//最低
				$kine['close'] = $onellist[3]*100000;//昨收
				$kine['open'] = $onellist[5]*100000;//今开
				$kine['diff'] = $onellist[11]*100000;//涨跌幅
            }else if(strpos($data2[$index], "hq_str_fx_saudusd")){//澳大利亚元美元
                //1199.0,-0.2993,1198.9,1199.0,1204.8,1196.8,22:50:53,1202.6,1198.7,10300,0,0,2017-03-15,COMEX黄金
                //现价，涨跌幅，买价，卖价，  最高价，最低价，   ，收盘价，开盘价       持仓量，买量，卖量，名称
                $kine['cid'] = 43;//编号
                $kine['code'] = "AUDUSD";//编码
				$kine['price'] =  $onellist[1]*100000;//number_format($onellist[1], 5, '.', ''); //round($onellist[1], 5);//现价
				$kine['high'] = $onellist[6]*100000;//最高
				$kine['low'] = $onellist[7]*100000;//最低
				$kine['close'] = $onellist[3]*100000;//昨收
				$kine['open'] = $onellist[5]*100000;//今开
				$kine['diff'] = $onellist[11]*100000;//涨跌幅
            }else if(strpos($data2[$index], "hq_str_fx_susdchf")){//美元瑞士法郎
                //1199.0,-0.2993,1198.9,1199.0,1204.8,1196.8,22:50:53,1202.6,1198.7,10300,0,0,2017-03-15,COMEX黄金
                //现价，涨跌幅，买价，卖价，  最高价，最低价，   ，收盘价，开盘价       持仓量，买量，卖量，名称
                $kine['cid'] = 44;//编号
                $kine['code'] = "USDCHF";//编码
				$kine['price'] =  $onellist[1]*100000;//number_format($onellist[1], 5, '.', ''); //round($onellist[1], 5);//现价
				$kine['high'] = $onellist[6]*100000;//最高
				$kine['low'] = $onellist[7]*100000;//最低
				$kine['close'] = $onellist[3]*100000;//昨收
				$kine['open'] = $onellist[5]*100000;//今开
				$kine['diff'] = $onellist[11]*100000;//涨跌幅
            }/*else if(strpos($data2[$index], "hq_str_btc_btcokcoin")){//比特币
				//18:49:03,7069.0000,   7080.0000,7260.2000,1100,0.0000,    7445.0000,7010.0100,    0.0000,OKCoin,6408.3100
							//现价，    涨跌幅，买价，卖价，                    最高价，最低价，      ，收盘价，开盘价       持仓量，买量，卖量，名称
				$kine['cid'] = 30;//编号
				$kine['code'] = "BIT";//编码
			}*/
            
            
            $kine['diffRate'] = $onellist[10].'%';//涨跌百分比
            $kine['time'] = time();//更新时间
            
            $kine['name'] = $onellist[9];//名称
            $data3[$index] = $kine;

        }
        //print_r($data3);//exit;

        //F('cc'.time(),$data);
        $data_list = $data3;//json_decode($data);
        foreach($data_list as $k=>$v){
            $acc = S('apiDataPrice'.$v['code']);
            $aee = $this->catproductcode($v['code']);
            $cid = $aee['cid'];
            $v['cid'] = $cid;
            if((($acc['price'] != $v['price']) || ((date('w') == 6 && 4 <= date("H")) || (date('w') == 0) || (date('w') == 1 && date("H") <= 8) || (4 <= date("H") && date("H") <= 8))) && strstr($v['low'],'-') === false && strstr($v['price'],'..') === false && strstr($v['price'],'-') === false && strstr($v['high'],'%') === false && strstr($v['high'],'-') === false){
                S('apiDataPrice'.$v['code'],$v);
                if($cid){
                    $zuoclose = S('zuoclose'.$v['code']);
                    if(!$zuoclose){
                        $aqq['code']  =  $v['code'];
                        $time = strtotime(date('Y-m-d'))+4*3600;
                        $aqq['time'] = array('ELT',$time);
                        $zuoclose = M('Api')->where($aqq)->order('time desc')->field('price')->find();
                        S('zuoclose'.$v['code'],$zuoclose['price'],24*3600);
                    }
                    //$v['close'] = $zuoclose;
                    S('price'.$v['code'],$v);
                    if($acc['high'] != $v['high']){
                        S('high'.$v['code'],$v['high']);
                    }
                    if($acc['low'] != $v['low']){
                        S('low'.$v['code'],$v['low']);
                    }

                    if($acc['open'] != $v['open']){
                        S('open'.$v['code'],$v['open']);
                    }
                    //S('close'.$v['code'],$zuoclose);
                    $arr['cid']   = $cid;
                    $arr['code']  = $v['code'];
                    $arr['price'] = $v['price'];
                    $arr['high']  = $v['high'];
                    $arr['low']   = $v['low'];
                    $arr['open']  = $v['open'];
                    //$arr['close'] = $zuoclose;
                    $arr['time']  = $v['time'];
                    $arr['diff']  = $v['diff'];
                    $arr['diffRate']  = $v['diffRate'];
                    M('api')->add($arr);
                }
            }

        }

        $config = M('Webconfig')->where('id=1')->field('day,hour,minute')->find();
        $time   = $config['day']*24*3600 + $config['hour']*3600 + $config['minute']*60 + F('qiangp');
        //查询所有正在交易的订单
        $arraynow = M('order')->where(array('ostaus'=>0))->select();
        //逐个判断盈亏比例
        foreach($arraynow as $k=>$v){
            $product = $this->productpid($v['pid']);
            if($product){
                $cid  = $product['cid'];
                $aff  = $this->catproductcid($cid);
                $code = $aff['title'];
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
                $order['eid']       = $v['eid'];
                $order['uprice']    = $product['uprice'];
                $order['onumber']   = $v['onumber'];
                $order['buyprice']  = $v['buyprice'];
                $order['wave']      = $product['wave'];
                $order['ostyle']    = $v['ostyle'];
                $order['endprofit'] = $v['endprofit'];
                $order['endloss']   = $v['endloss'];
                $orderid = $this->trends($youjia,$order);
                //F('ww'.time(),$orderid);
                //盈亏百分百
                $ykbfb   = round($orderid['ykbfb']*100,2);
                $bdyy    = $orderid['bdyy'];    //本单盈余
                $jiancj  = $orderid['jc'];      //建仓金额
                $ykzj    = $orderid['ykzj'];	//盈亏资金

                $user = M('accountinfo')->where('uid='.$v['uid'])->find();
                //达到客户设置止盈或止亏的百分比时强制平仓
                if($time <= time()){
                    //平仓
                    $msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
                }
                if($v['ostyle'] == 0){//涨
                    if($ykzj > 0){//盈
                        if($v['endprofit'] == 1){

                        }else{
                            if(abs($ykbfb) >= $v['endprofit']){
                                //平仓
                                $msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
                            }
                        }
                    }else{
                        if(abs($ykbfb) >= $v['endloss']){
                            //平仓
                            $msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
                        }
                    }
                }else{   //跌
                    if($ykzj > 0){ //赚
                        if($v['endprofit'] == 1){

                        }else{
                            if(abs($ykbfb) >= $v['endprofit']){
                                //平仓
                                $msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
                            }
                        }

                    }else{

                        if(abs($ykbfb) >= $v['endloss']){
                            //平仓
                            $msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
                        }

                    }
                }

            }
        }
        if($time <= time()){
            F('qiangp',time());
            $this->ajaxReturn($msg);
        }
    }


    //新浪抓取黄金、白银、原油的数据；
	public function allOrder2(){
		if(date('H') == '5'){
			$time = strtotime(date('Y-m-d',strtotime('-3 day')));
			M("Api")->where(array('time'=>array('LT',$time)))->delete();
		}
		$url = 'http://hq.sinajs.cn/?_/&list=hf_CL,hf_SI,hf_GC';//,hf_SI,hf_GC
		$data = $this->httpGet($url);
		$data2 = explode(';',$data);
		$data3 ="";
		//echo count($data2)-1;exit;
		for($index=0;$index<count($data2)-1;$index++)
		{
			$one = substr( $data2[$index], stripos($data2[$index], "\"")+1, -1);
			$onellist = explode(',',$one);
			$kine = "";
			if(strpos($data2[$index], "hq_str_hf_CL"))//沥青
			{
				//48.62,1.8860,48.62,48.63,   48.87,48.31,22:24:42,47.72,48.76,    18043,0,0,2017-03-15,NYMEX原油
				//现价，涨跌幅，买价，卖价，  最高价，最低价，   ，收盘价，开盘价       持仓量，买量，卖量，名称
				$kine['cid'] = 28;
				$kine['code'] = "CONO";
			}else if(strpos($data2[$index], "hq_str_hf_SI")){//白银
				//16.870,-0.2955,16.870,16.870,16.980,16.820,22:50:23,16.920,16.890,1076,0,0,2017-03-15,COMEX白银
				//现价，涨跌幅，买价，卖价，  最高价，最低价，   ，收盘价，开盘价       持仓量，买量，卖量，名称
				$kine['cid'] = 15;
				$kine['code'] = "XAG";
			}else if(strpos($data2[$index], "hq_str_hf_GC")){//黄金
				//1199.0,-0.2993,1198.9,1199.0,1204.8,1196.8,22:50:53,1202.6,1198.7,10300,0,0,2017-03-15,COMEX黄金
				//现价，涨跌幅，买价，卖价，  最高价，最低价，   ，收盘价，开盘价       持仓量，买量，卖量，名称
				$kine['cid'] = 26;
				$kine['code'] = "XAU";
			}
			$kine['price'] = $onellist[0];
			$kine['diff'] = round($onellist[0]-$onellist[7],2);
			$kine['diffRate'] = round($onellist[1],2).'%';
			$kine['time'] = time();
			$kine['high'] = $onellist[4];
			$kine['low'] = $onellist[5];
			$kine['closes'] = $onellist[7];
			$kine['open'] = $onellist[8];
			$kine['name'] = $onellist[13];
			$data3[$index] = $kine;

		}
		//print_r($data3);exit;

		//F('cc'.time(),$data);
		$data_list = $data3;//json_decode($data);
		foreach($data_list as $k=>$v){
			$acc = S('apiDataPrice'.$v['code']);
			$aee = $this->catproductcode($v['code']);
			$cid = $aee['cid'];
			$v['cid'] = $cid;
			if((($acc['price'] != $v['price']) || ((date('w') == 6 && 4 <= date("H")) || (date('w') == 0) || (date('w') == 1 && date("H") <= 8) || (4 <= date("H") && date("H") <= 8))) && strstr($v['low'],'-') === false && strstr($v['price'],'..') === false && strstr($v['price'],'-') === false && strstr($v['high'],'%') === false && strstr($v['high'],'-') === false){
				S('apiDataPrice'.$v['code'],$v);
				if($cid){
					$zuoclose = S('zuoclose'.$v['code']);
					if(!$zuoclose){
						$aqq['code']  =  $v['code'];
						$time = strtotime(date('Y-m-d'))+4*3600;
						$aqq['time'] = array('ELT',$time);
						$zuoclose = M('Api')->where($aqq)->order('time desc')->field('price')->find();
						S('zuoclose'.$v['code'],$zuoclose['price'],24*3600);
					}
					$v['close'] = $zuoclose;
					S('price'.$v['code'],$v);
					if($acc['high'] != $v['high']){
						S('high'.$v['code'],$v['high']);
					}
					if($acc['low'] != $v['low']){
						S('low'.$v['code'],$v['low']);
					}

					if($acc['open'] != $v['open']){
						S('open'.$v['code'],$v['open']);
					}
					S('close'.$v['code'],$zuoclose);
					$arr['cid']   = $cid;
					$arr['code']  = $v['code'];
					$arr['price'] = $v['price'];
					$arr['high']  = $v['high'];
					$arr['low']   = $v['low'];
					$arr['open']  = $v['open'];
					$arr['close'] = $zuoclose;
					$arr['time']  = $v['time'];
					$arr['diff']  = $v['diff'];
					$arr['diffRate']  = $v['diffRate'];
					M('api')->add($arr);
				}
			}

		}

		$config = M('Webconfig')->where('id=1')->field('day,hour,minute')->find();
		$time   = $config['day']*24*3600 + $config['hour']*3600 + $config['minute']*60 + F('qiangp');
		//查询所有正在交易的订单
		$arraynow = M('order')->where(array('ostaus'=>0))->select();
		//逐个判断盈亏比例
		foreach($arraynow as $k=>$v){
			$product = $this->productpid($v['pid']);
			if($product){
				$cid  = $product['cid'];
				$aff  = $this->catproductcid($cid);
				$code = $aff['title'];
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
				$order['eid']       = $v['eid'];
				$order['uprice']    = $product['uprice'];
				$order['onumber']   = $v['onumber'];
				$order['buyprice']  = $v['buyprice'];
				$order['wave']      = $product['wave'];
				$order['ostyle']    = $v['ostyle'];
				$order['endprofit'] = $v['endprofit'];
				$order['endloss']   = $v['endloss'];
				$orderid = $this->trends($youjia,$order);
				//F('ww'.time(),$orderid);
				//盈亏百分百
				$ykbfb   = round($orderid['ykbfb']*100,2);
				$bdyy    = $orderid['bdyy'];    //本单盈余
				$jiancj  = $orderid['jc'];      //建仓金额
				$ykzj    = $orderid['ykzj'];	//盈亏资金

				$user = M('accountinfo')->where('uid='.$v['uid'])->find();
				//达到客户设置止盈或止亏的百分比时强制平仓
				if($time <= time()){
					//平仓
					$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
				}
				if($v['ostyle'] == 0){//涨
					if($ykzj > 0){//盈
						if($v['endprofit'] == 1){

						}else{
							if(abs($ykbfb) >= $v['endprofit']){
								//平仓
								$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
							}
						}
					}else{
						if(abs($ykbfb) >= $v['endloss']){
							//平仓
							$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
						}
					}
				}else{   //跌
					if($ykzj > 0){ //赚
						if($v['endprofit'] == 1){

						}else{
							if(abs($ykbfb) >= $v['endprofit']){
								//平仓
								$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
							}
						}

					}else{

						if(abs($ykbfb) >= $v['endloss']){
							//平仓
							$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
						}

					}
				}

			}
		}
		if($time <= time()){
			F('qiangp',time());
			$this->ajaxReturn($msg);
		}
	}
	/**
     * 达到客户设定的盈亏点进行平仓 及  达到后台设置止盈或止亏的百分比时消息提醒  
     */
	public function allOrder(){
		if(date('H') == '5'){
			$time = strtotime(date('Y-m-d',strtotime('-3 day')));
			M("Api")->where(array('time'=>array('LT',$time)))->delete(); 
		}
		$url = 'http://api.workwx.cn/index.php/Api/123';
		$data = $this->httpGet($url);

		//F('cc'.time(),$data);
		$data = json_decode($data);
		foreach($data as $k=>$v){
			$v = get_object_vars($v);
			$acc = S('apiDataPrice'.$v['code']);
			$aee = $this->catproductcode($v['code']);
			$cid = $aee['cid'];
			$v['cid'] = $cid;
			if((($acc['price'] != $v['price']) || ((date('w') == 6 && 4 <= date("H")) || (date('w') == 0) || (date('w') == 1 && date("H") <= 8) || (4 <= date("H") && date("H") <= 8))) && strstr($v['low'],'-') === false && strstr($v['price'],'..') === false && strstr($v['price'],'-') === false && strstr($v['high'],'%') === false && strstr($v['high'],'-') === false){
				S('apiDataPrice'.$v['code'],$v);
				if($cid){
					$zuoclose = S('zuoclose'.$v['code']);
					if(!$zuoclose){
						$aqq['code']  =  $v['code'];
						$time = strtotime(date('Y-m-d'))+4*3600;
						$aqq['time'] = array('ELT',$time);
						$zuoclose = M('Api')->where($aqq)->order('time desc')->field('price')->find();
						S('zuoclose'.$v['code'],$zuoclose['price'],24*3600);
					} 
					$v['close'] = $zuoclose;
					S('price'.$v['code'],$v);
					if($acc['high'] != $v['high']){
						S('high'.$v['code'],$v['high']);
					}
					if($acc['low'] != $v['low']){
						S('low'.$v['code'],$v['low']);
					}
					
					if($acc['open'] != $v['open']){
						S('open'.$v['code'],$v['open']);
					}
					S('close'.$v['code'],$zuoclose);
					$arr['cid']   = $cid;
					$arr['code']  = $v['code'];
					$arr['price'] = $v['price'];
					$arr['high']  = $v['high'];
					$arr['low']   = $v['low'];
					$arr['open']  = $v['open'];
					$arr['close'] = $zuoclose;
					$arr['time']  = $v['time'];
					$arr['diff']  = $v['diff'];
					$arr['diffRate']  = $v['diffRate'];
					M('api')->add($arr);
				}
			}
			
		}

		$config = M('Webconfig')->where('id=1')->field('day,hour,minute')->find();
		$time   = $config['day']*24*3600 + $config['hour']*3600 + $config['minute']*60 + F('qiangp');
		//查询所有正在交易的订单
		$arraynow = M('order')->where(array('ostaus'=>0))->select();
		//逐个判断盈亏比例
		foreach($arraynow as $k=>$v){
			$product = $this->productpid($v['pid']);
			if($product){
				$cid  = $product['cid'];
				$aff  = $this->catproductcid($cid);
				$code = $aff['title'];
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
				$order['eid']       = $v['eid'];
				$order['uprice']    = $product['uprice'];
				$order['onumber']   = $v['onumber'];
				$order['buyprice']  = $v['buyprice'];
				$order['wave']      = $product['wave'];
				$order['ostyle']    = $v['ostyle'];
				$order['endprofit'] = $v['endprofit'];
				$order['endloss']   = $v['endloss'];
				$orderid = $this->trends($youjia,$order);
				//F('ww'.time(),$orderid);
				//盈亏百分百
				$ykbfb   = round($orderid['ykbfb']*100,2);
				$bdyy    = $orderid['bdyy'];    //本单盈余
				$jiancj  = $orderid['jc'];      //建仓金额
				$ykzj    = $orderid['ykzj'];	//盈亏资金
				
				$user = M('accountinfo')->where('uid='.$v['uid'])->find();
				//达到客户设置止盈或止亏的百分比时强制平仓
				if($time <= time()){
					//平仓
					$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
				}
				if($v['ostyle'] == 0){//涨
					if($ykzj > 0){//盈
						if($v['endprofit'] == 1){
							
						}else{
							if(abs($ykbfb) >= $v['endprofit']){
								//平仓
								$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
							}
						}
					}else{
						if(abs($ykbfb) >= $v['endloss']){
							//平仓
							$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
						}
					}
				}else{   //跌
					if($ykzj > 0){ //赚
						if($v['endprofit'] == 1){
							
						}else{
							if(abs($ykbfb) >= $v['endprofit']){
								//平仓
								$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
							}
						}
						
					}else{
						
						if(abs($ykbfb) >= $v['endloss']){
							//平仓
							$msg = $this->closeTrade($v['uid'],$user['balance'],$youjia,$v['oid'],$bdyy,$jiancj,$ykzj,$product['uprice']);
						}
						
					}
				}
				
			}
		}
		if($time <= time()){
			F('qiangp',time());
			$this->ajaxReturn($msg);
		}
	}
	
	function productpid($pid){
		$goods = S('productpidList'.$pid);
		if(!$goods){
			$goods = M('productinfo')->where("pid=$pid")->find();
			S('productpidList'.$pid,$goods,600);
		}
		return $goods;
	}
	
	function catproductcid($cid){
		$catgood = S('catproductcid'.$cid);
		if(!$catgood){
			$catgood = M('catproduct')->where(array('status'=>1,'cid'=>$cid))->find();
			S('catproductcid'.$cid,$catgood,600);
		}
		return $catgood;
	}
	
	function catproductcode($code){
		$catgood = S('catproductcode'.$code);
		if(!$catgood){
			$catgood = M('catproduct')->where(array('status'=>1,'title'=>$code))->find();
			S('catproductcode'.$code,$catgood,600);
		}
		return $catgood;
	}
	
	function tc(){
		$data = S('tc');
		if(!$data){
			$data = M('tc')->order('id asc')->select();
			S('tc',$data,600);
		}
		return $data;
	}
	
	function httpGet($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
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
			//盈亏百分百 
			$orderid['ykbfb'] = round($orderid['ykzj']/ $order['uprice'],2); 
			if($orderid['ykzj'] < 0){
				$orderid['ykzj'] = 0;
				$orderid['bdyy'] = 0; 
			}else{
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
	 * @param     char      $fee           手续费
	 * @param     char      $storage       储仓费
	 */
	public function closeTrade($uid,$balance,$youjia,$oid,$bdyy,$jiancj,$ykzj,$uprice){
		$config = M('Webconfig')->where('id=1')->field('fee,storage,Pscale')->find();
		//先修改订单信息，返回成功信息后修改账户余额和添加日志记录
		$users    = D('userinfo');
		$orderno  = $this->build_order_no();
		$tq       = C('DB_PREFIX');
		$myorder  = M('order')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')->where($tq.'order.oid='.$oid)->find();
		if($myorder['ostaus'] == 1){
			$msg="平仓失败，稍后平仓";
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
			$orders['fee']   = $fee;
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
					
					if($thisuser['agenttype'] != 2){
						//不是代理商
						if($thisuser['vid']){
							//平台给用户分成
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
						}//用户不在代理商的下面				
						if($thisuser['oid'] && $thisuser['oid'] != 0){                                       //判断是否有上级
							$this->tree($thisuser['oid'],0,$fee,$orderno,$oid,$uid,2);
						}
					}
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
				$journal['type'] = 1;                           	 
				$myjournal->add($journal);
				$order->where('oid='.$oid)->setField('commission',$journal['balance']);
			}else{
			   $msg="平仓失败，稍后平仓";
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
	
	//随机生成订单编号
    function build_order_no(){
        return date(time()).substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 3);
    }
	
	/**
     * 递归
	 * @param          $status         int           1代理 2用户
	 * @param          $uid            int           谁分成用户
	 * @param          $pid            int           给谁分成用户
	 * @param          $num            int           分销等级
	 */
	public function tree($pids,$num,$price,$orderno,$oid,$uid){
		$data = $this->tc();
		$money = $price*$data[$num]['tc']/100;
		//计算提成
		$user   = M('accountinfo');
		$pid   = M('userinfo')->where("uid=$pids")->find();
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
		$user->where(array('uid'=>$disj['uid']))->save(array('balance'=>$disj['balance']));
		if($money>0){
			$distribution->add($disj);
		}
		if($pid['oid'] && $data[$num]['id']!=='' ){
			$this->tree($pid['oid'],$num+1,$price,$orderno,$oid,$pid['uid'],$status);
		}
	}
	

}