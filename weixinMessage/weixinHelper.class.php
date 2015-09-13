<?php

require_once dirname ( __FILE__ ) . '/messageHandler/MessageHandlerFactory.class.php';
require_once dirname ( __FILE__ ) . '/messageSender/MessageSenderFactory.class.php';

class WeixinHelper
{
	private $messageHandlerFactory;
	private $messageSenderFactory;

	function __construct() {
		$this->messageHandlerFactory = new MessageHandlerFactory();
		$this->messageSenderFactory = new MessageSenderFactory();
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
			$messageHandler = $this->messageHandlerFactory->getMessageHandler($postObj);
			$message = $messageHandler->handleMessage($postObj);
			$messageSender = $this->messageSenderFactory->getMessageSender($message);
			$messageSender->sendMessage($message);
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