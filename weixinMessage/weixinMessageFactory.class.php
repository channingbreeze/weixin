<?php

require_once dirname ( __FILE__ ) . '/weixinTextMessageFactory.class.php';
require_once dirname ( __FILE__ ) . '/weixinPictureArticalMessageFactory.class.php';

class WeixinMessageFactory
{
	private $weixinTextMessageFactory;
	private $weixinPictureArticalMessageFactory;
	
	function __construct() {
		$this->weixinTextMessageFactory = new WeixinTextMessageFactory();
		$this->weixinPictureArticalMessageFactory = new WeixinPictureArticalMessageFactory();
	}
	
	public function responseTextMessage($postObj)
	{
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$time = time();
		$keyword = trim($postObj->Content);
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
			$contentStr = $this->weixinTextMessageFactory->responseText($keyword);
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			echo $resultStr;
		}else{
			echo "Input something...";
		}
	}
	
	public function responseEventMessage($postObj)
	{
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$time = time();
		$event = trim($postObj->Event);
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
		if(!empty( $event ))
		{
			$msgType = "text";
			if($event == "subscribe") {
				$contentStr = $this->weixinTextMessageFactory->responseSubscribe();
			} else if($event == "unsubscribe") {
				$contentStr = $this->weixinTextMessageFactory->responseUnsubscribe();
			}
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			echo $resultStr;
		}else{
			echo "Input something...";
		}
	}
	
	public function responsePictureArticalMessage($postObj)
	{
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$time = time();
		$keyword = trim($postObj->Content);
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<ArticleCount>1</ArticleCount>
					<Articles>
					<item>
					<Title><![CDATA[%s]]></Title> 
					<Description><![CDATA[%s]]></Description>
					<PicUrl><![CDATA[%s]]></PicUrl>
					<Url><![CDATA[%s]]></Url>
					</item>
					</Articles>
					</xml>";
		if(!empty( $keyword ))
		{
			$msgType = "news";
			$arr = $this->weixinPictureArticalMessageFactory->responseHeiGame($keyword);
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $arr['title'], $arr['des'], $arr['pic'], $arr['url']);
			echo $resultStr;
		}else{
			echo "Input something...";
		}
	}
}

?>