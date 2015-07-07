<?php

require_once dirname ( __FILE__ ) . '/weixinMessageFactory.class.php';
require_once dirname ( __FILE__ ) . '/../utils/StringUtil.class.php';

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

	public function responseMessage()
	{
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

		if (!empty($postStr)){
			
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$msgType = $postObj->MsgType;
			
			if($msgType == "text") {
				$keyword = trim($postObj->Content);
				if(StringUtil::startsWith($keyword, "嘿嘿")) {
					return $this->weixinMessageFactory->responsePictureArticalMessage($postObj);
				} else if(StringUtil::endsWith($keyword, "答案")) {
					$this->weixinMessageFactory->responseTextMessage($postObj);
				} else {
					$this->weixinMessageFactory->responseTextMessage($postObj);
				}
			} else if($msgType == "event") {
				$this->weixinMessageFactory->responseEventMessage($postObj);
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