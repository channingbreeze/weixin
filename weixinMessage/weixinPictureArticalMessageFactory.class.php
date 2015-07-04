<?php

require_once dirname ( __FILE__ ) . '/weixinHeiGame.class.php';
require_once dirname ( __FILE__ ) . '/../utils/StringUtil.class.php';

class WeixinPictureArticalMessageFactory
{
	private $weixinHeiGame;
	
	function __construct() {
		$this->weixinHeiGame = new WeixinHeiGame();
	}
	
	public function responseHeiGame($keyword) {
		
		$arr = array();
		
		if(StringUtil::startsWith($keyword, "嘿嘿")) {
			$arr = $this->weixinHeiGame->responseHei($keyword);
		}
		
		return $arr;
		
	}
}

?>