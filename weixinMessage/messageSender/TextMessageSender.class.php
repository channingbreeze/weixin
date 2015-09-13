<?php

require_once dirname ( __FILE__ ) . '/MessageSender.class.php';

class TextMessageSender extends MessageSender {
	
	/**
	 * (non-PHPdoc)
	 * @see MessageSender::sendMessage()
	 * $message->Type = "text"
	 * $message->FromUserName
	 * $message->ToUserName
	 * $message->Content
	 */
	public function sendMessage($message) {
		
		$fromUsername = $message->FromUserName;
		$toUsername = $message->ToUserName;
		$time = time();
		$contentStr = $message->Content;
		$type = $message->Type;
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
		
		$resultStr = sprintf($textTpl, $toUsername, $fromUsername, $time, $type, $contentStr);
		echo $resultStr;
		
	}
	
}

?>