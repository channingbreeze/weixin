<?php

require_once dirname ( __FILE__ ) . '/MessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageObject/MessageObject.class.php';

class SubscribeMessageService extends MessageService {
	
	/**
	 * $message->Type 必须
	 * text:
	 * $message->Type = "text"
	 * $message->FromUserName
	 * $message->ToUserName
	 * $message->Content
	 * news:
	 * $message->Type = "news"
	 * $message->FromUserName;
	 * $message->ToUserName;
	 * $message->newsArr;
	 *           foreach ($message->newsArr as $news)
	 	*           $news['Title']
	 *           $news['Description']
	 *           $news['PicUrl']
	 *           $news['Url']
	 * none:
	 * $message->Type = "none"
	 */
	public function generateMessage($postObj) {
	
		$message = new MessageObject();
		$message->Type = "text";
		$message->FromUserName = $postObj->ToUserName;
		$message->ToUserName = $postObj->FromUserName;
		$message->Content = "欢迎关注欣欣网站制作，这里会带给你不一样的体验！\r\n
				回复文字：嘿嘿xxx，可生成一条笑话消息，xxx即故事主人公\r\n
				回复图片：可生成一条图文消息，包含图片中人物的年龄信息\r\n";
		return $message;
	
	}
	
}

?>