<?php

require_once dirname ( __FILE__ ) . '/MessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageObject/MessageObject.class.php';

class UnsubscribeMessageService extends MessageService {
	
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
		$message->Content = "欢迎下次订阅";
		return $message;
	
	}
	
}

?>