<?php

require_once dirname ( __FILE__ ) . '/MessageSender.class.php';

class NewsMessageSender extends MessageSender {
	
	/**
	 * (non-PHPdoc)
	 * @see MessageSender::sendMessage()
	 * $message->Type = "news"
	 * $message->FromUserName;
	 * $message->ToUserName;
	 * $message->newsArr;
	 *           foreach ($message->newsArr as $news)
	 *           $news['Title']
	 *           $news['Description']
	 *           $news['PicUrl']
	 *           $news['Url']
	 */
	public function sendMessage($message) {
		$fromUsername = $message->FromUserName;
		$toUsername = $message->ToUserName;
		$time = time();
		$type = $message->Type;
		$newsArr = $message->newsArr;
		$newsCount = count($newsArr);
		
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<ArticleCount>%s</ArticleCount>
					<Articles>
					%s
					</Articles>
					</xml>";
		
		$newsTpl = "<item>
					<Title><![CDATA[%s]]></Title>
					<Description><![CDATA[%s]]></Description>
					<PicUrl><![CDATA[%s]]></PicUrl>
					<Url><![CDATA[%s]]></Url>
					</item>";
		
		$newsXml = "";
		foreach($newsArr as $news) {
			$newsStr = sprintf($newsTpl, $news['Title'], $news['Description'], $news['PicUrl'], $news['Url']);
			$newsXml = $newsXml . $newsStr;
		}
		
		$resultStr = sprintf($textTpl, $toUsername, $fromUsername, $time, $type, $newsCount, $newsXml);
		echo $resultStr;
		
	}
	
}

?>