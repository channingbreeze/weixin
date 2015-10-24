<?php

require_once dirname ( __FILE__ ) . '/MessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageObject/MessageObject.class.php';
require_once dirname ( __FILE__ ) . '/../../utils/SQLHelper.class.php';

class GameMessageService extends MessageService {
	
	function __construct() {
		
	}
	
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
		$message->Type = "news";
	    $message->FromUserName = $postObj->ToUserName;
		$message->ToUserName = $postObj->FromUserName;
		$message->newsArr = array();
		$news = array();
		$news['Title'] = "flappy bird";
		$news['Description'] = "经典游戏";
		$news['PicUrl'] = "http://7xjv6k.com1.z0.glb.clouddn.com/flappybird.JPG";
		$news['Url'] = "http://game.webxinxin.com/flappybird/";
		$message->newsArr[0] = $news;
		return $message;
		
	}
	
}

?>