<?php
namespace Home\Controller;
use Think\Controller;
class WxopenController extends Controller {
	private  $data = array ();
	private $type=array();
	public function __construct()	
	{
		if (IS_GET){
			$this->auth($_GET['token'],$_GET["signature"],$_GET["timestamp"],$_GET["nonce"],$_GET['echostr']);
		}
		else{		
			$content = file_get_contents ( 'php://input' );
			! empty ( $content ) || die ( '内容获取失败' );
			$data=simplexml_load_string($content,'SimpleXMLElement',LIBXML_NOCDATA);
			$conf=(json_decode(json_encode($data)));
			
			$this->data=$this->object_array($conf);
			F('ddddd',$this->data);
			
		}
		$this->type=array(
			'text',
			'music',
			'news',
			'voice',
			'image',
			'video',
			'voice'
		);
	}
	 function object_array($array) {  
		if(is_object($array)) {  
			$array = (array)$array;  
		 } 
		 if(is_array($array)) {  
			foreach($array as $key=>$value) {  
				$array[$key] = $this->object_array($value);  
			}  
		}  
			return $array;  
	}
	/* 获取微信平台请求的信息 */
	public function getData(){
		F('ewr','34234');
		return $this->data;
	}
	public function xml_parser($str){ 
		$xml_parser = xml_parser_create(); 
		if(!xml_parse($xml_parser,$str,true)){ 
			xml_parser_free($xml_parser); 
			return false; 
		} else { 
			return (json_decode(json_encode(simplexml_load_string($str)),true)); 
		} 
	} 
	public function response($content,$type='text'){	
		if(in_array($type,$this->type))
			$this->{$type}($content);
		else
			$this->_replyData('找不到应用','text');
	}				
	/* ========================发送被动响应消息 begin================================== */
	/* 回复文本消息 */
	private function text($content){
		$msg ['Content'] = $content;
		$this->_replyData ( $msg,'text');
	}
	/* 回复图片消息 */
	private function image($media_id) {
		$msg ['Image'] ['MediaId'] = $media_id;
		$this->_replyData ($msg, 'image' );
	}
	/* 回复语音消息 */
	private function voice($media_id) {
		$msg ['Voice'] ['MediaId'] = $media_id;
		$msg ['Voice'] ['MediaId'] = $media_id;
		$this->_replyData ( $msg, 'voice' );
	}
	/* 回复视频消息 */
	private function video($media_id, $title = '', $description = '') {
		$msg ['Video'] ['MediaId'] = $media_id;
		$msg ['Video'] ['Title'] = $title;
		$msg ['Video'] ['Description'] = $description;
		$this->_replyData ( $msg, 'video' );
	}
	/* 回复音乐消息 */
	private function music($content) 
	{
		list($media_id,$title,$description,$music_url, $HQ_music_url)=$content;
		//$msg ['Music'] ['ThumbMediaId'] = $media_id;
		$msg ['Music'] ['Title'] = $title;
		$msg ['Music'] ['Description'] = $description;
		$msg ['Music'] ['MusicURL'] = $music_url;
		$msg ['Music'] ['HQMusicUrl'] = $HQ_music_url;
		$this->_replyData ( $msg, 'music');
	}
	/*
	 * 回复图文消息 articles array 格式如下： array( array('Title'=>'','Description'=>'','PicUrl'=>'','Url'=>''), array('Title'=>'','Description'=>'','PicUrl'=>'','Url'=>'') );
	 */
	private function news($articles){
		$msg ['ArticleCount'] = count ( $articles );
		$msg ['Articles'] = $articles;
		$this->_replyData ( $msg,'news');
	}
	/* 发送回复消息到微信平台 */
	private function _replyData($msg, $msgType) 
	{
		$msg ['ToUserName'] = $this->data ['FromUserName'];
		$msg ['FromUserName'] = $this->data ['ToUserName'];
		$msg ['CreateTime'] = NOW_TIME;
		$msg ['MsgType'] = $msgType;	
		$xml = new \SimpleXMLElement( '<xml></xml>' );
		$dt=$this->_data2xml ( $xml, $msg );	
		$str = $xml->asXML();		
		die($str);	
	}
	/* 组装xml数据 */
	private function _data2xml($xml, $data, $item = 'item') {
		foreach ( $data as $key => $value ) {
			is_numeric ( $key ) && ($key = $item);
			if (is_array ( $value ) || is_object ( $value )) {
				$child = $xml->addChild ( $key );
				$this->_data2xml ( $child, $value, $item );
			} else {
				if (is_numeric ( $value )) {
					$child = $xml->addChild ( $key, $value );
				} else {
					$child = $xml->addChild ( $key );
					$node = dom_import_simplexml ( $child );
					$node->appendChild ( $node->ownerDocument->createCDATASection ( $value ) );
				}
			}
		}
	}
	/* ========================发送被动响应消息 end================================== */
	/* 上传多媒体文件 */
	private function uploadFile($file, $type = 'image', $acctoken = '') {
		$post_data ['type'] = $type; // 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
		$post_data ['media'] = $file;
		
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=$acctoken&type=image";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
		ob_start ();
		curl_exec ( $ch );
		$result = ob_get_contents ();
		ob_end_clean ();
		
		return $result;
	}
	/* 下载多媒体文件 */
	private function downloadFile($media_id, $acctoken = '') {
		// TODO
	}
	/**
	 * GET 请求
	 *
	 * @param string $url        	
	 */
	private function http_get($url) {
		$oCurl = curl_init ();
		if (stripos ( $url, "https://" ) !== FALSE) {
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYHOST, FALSE );
		}
		curl_setopt ( $oCurl, CURLOPT_URL, $url );
		curl_setopt ( $oCurl, CURLOPT_RETURNTRANSFER, 1 );
		$sContent = curl_exec ( $oCurl );
		$aStatus = curl_getinfo ( $oCurl );
		curl_close ( $oCurl );
		if (intval ( $aStatus ["http_code"] ) == 200) {
			return $sContent;
		} else {
			return false;
		}
	}
	
	/**
	 * POST 请求
	 *
	 * @param string $url        	
	 * @param array $param        	
	 * @return string content
	 */
	private function http_post($url, $param) 
	{
		$oCurl = curl_init ();
		if (stripos ( $url, "https://" ) !== FALSE) {
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYHOST, false );
		}
		if (is_string ( $param )) {
			$strPOST = $param;
		} else {
			$aPOST = array ();
			foreach ( $param as $key => $val ) {
				$aPOST [] = $key . "=" . urlencode ( $val );
			}
			$strPOST = join ( "&", $aPOST );
		}
		curl_setopt ( $oCurl, CURLOPT_URL, $url );
		curl_setopt ( $oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $oCurl, CURLOPT_POST, true );
		curl_setopt ( $oCurl, CURLOPT_POSTFIELDS, $strPOST );
		$sContent = curl_exec ( $oCurl );
		$aStatus = curl_getinfo ( $oCurl );
		curl_close ( $oCurl );
		if (intval ( $aStatus ["http_code"] ) == 200) {
			return $sContent;
		} else {
			return false;
		}
	}
	//来源认证
	private function auth($token,$signature,$timestamp,$nonce,$echostr)
	{	
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature )
{
			echo $echostr;die;
		}
		else{
			echo '';die;
		}
	}
}