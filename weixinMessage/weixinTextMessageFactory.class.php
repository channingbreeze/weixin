<?php

require_once dirname ( __FILE__ ) . '/weixinQAnswer.class.php';
require_once dirname ( __FILE__ ) . '/../utils/StringUtil.class.php';

class WeixinTextMessageFactory
{
	
	private $weixinQAnswer;
	
	function __construct() {
		$this->weixinQAnswer = new WeixinQAnswer();
	}
	
	public function responseText($keyword)
	{
		return "对不起哦，欣欣暂时不在，我会让他稍后联系你的^_^！\r\n
				回复：嘿嘿xxx，可生成一条笑话消息，xxx即故事主人公\r\n
				回复：xxx答案，可查看智力题答案，xxx为智力题标题。例回复：猜古诗答案，可查看智力猜古诗的答案";
	}
	
	public function responseSubscribe()
	{
		return "欢迎关注欣欣网站制作，这里会带给你不一样的体验！\r\n
				回复：嘿嘿xxx，可生成一条笑话消息，xxx即故事主人公\r\n
				回复：xxx答案，可查看智力题答案，xxx为智力题标题。例回复：猜古诗答案，可查看智力猜古诗的答案";
	}
	
	public function responseUnsubscribe()
	{
		return "欢迎下次订阅";
	}
	
	public function responseQAnswer($keyword)
	{
		$res = "";
		
		if(StringUtil::endsWith($keyword, "答案")) {
			$res = $this->weixinQAnswer->responseQAnswer($keyword);
		}
		
		return $res;
	}
	
}

?>