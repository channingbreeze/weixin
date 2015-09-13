<?php

require_once dirname ( __FILE__ ) . '/MessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageObject/MessageObject.class.php';
require_once dirname ( __FILE__ ) . '/../../utils/SQLHelper.class.php';

class QAnswerMessageService extends MessageService {
	
	private $notFoundAnswer;
	
	function __construct() {
		$this->notFoundAnswer = "没有对应的题目哦，请输入正确题目+答案，如：猜古诗答案";
	}
	
	private function responseQAnswer($keyword) {
		
		$name = mb_substr($keyword, 0, mb_strlen($keyword, 'UTF-8') - 2, 'UTF-8');
		if(strlen($name) == 0) {
			return $this->notFoundAnswer;
		}
	
		$sql = "select * from wx_answer where keyword='" . $name . "' limit 0,1";
		$sqlHelper = new SQLHelper();
		$arr = $sqlHelper->execute_dql_array($sql);
	
		if(count($arr) == 0) {
			return $this->notFoundAnswer;
		} else {
			return $arr[0]['answer'];
		}
	
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
		$message->Type = "text";
	    $message->FromUserName = $postObj->ToUserName;
		$message->ToUserName = $postObj->FromUserName;
		$message->Content = $this->responseQAnswer(trim($postObj->Content));
		return $message;
		
	}
	
}

?>