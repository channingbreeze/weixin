<?php

require_once dirname ( __FILE__ ) . '/weixinMessageFactory.class.php';

class WeixinHelper
{
	private $weixinMessageFactory;
	
	function __construct() {
		$this->weixinMessageFactory = new WeixinMessageFactory();
	}
	
	public function check()
	{
		if(!isset($_GET["echostr"])) {
			return;
		}
		
		$echoStr = $_GET["echostr"];

		if($this->checkSignature()){
			echo $echoStr;
			exit;
		}
	}

	public function responseTextMessage()
	{
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

		if (!empty($postStr)){
			
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim($postObj->Content);
			$time = time();
			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";
			if(!empty( $keyword ))
			{
				$msgType = "text";
				$contentStr = $this->weixinMessageFactory->responseText($fromUsername, $toUsername, $keyword);
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				echo $resultStr;
			}else{
				echo "Input something...";
			}

		}else {
			echo "";
			exit;
		}
	}

	private function checkSignature()
	{
		if (!defined("TOKEN")) {
			throw new Exception('TOKEN is not defined!');
		}

		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>