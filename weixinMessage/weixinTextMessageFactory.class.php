<?php

class WeixinTextMessageFactory
{
	public function responseText($keyword)
	{
		return "对不起哦，欣欣暂时不在，我会让他稍后联系你的^_^！\r\n
				欣欣网站制作是一个帮助创业者制作网站的平台，保证原创网站，详情可访问官网：http://www.webxinxin.com\r\n
				想学习建站知识，请访问欣欣网站制作的官方教程，玩命牛的成长记录：http://www.calfnote.com\r\n
				回复：嘿嘿xxx，可生成一条笑话消息，xxx即故事主人公";
	}
	
	public function responseSubscribe()
	{
		return "欢迎关注欣欣网站制作，这里会带给你不一样的体验！\r\n
				欣欣网站制作是一个帮助创业者制作网站的平台，保证原创网站，详情可访问官网：http://www.webxinxin.com\r\n
				想学习建站知识，请访问欣欣网站制作的官方教程，玩命牛的成长记录：http://www.calfnote.com\r\n
				回复：嘿嘿xxx，可生成一条笑话消息，xxx即故事主人公";
	}
	
	public function responseUnsubscribe()
	{
		return "欢迎下次订阅";
	}
}

?>