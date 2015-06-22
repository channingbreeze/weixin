<?php

class WeixinMessageFactory
{
	public function responseText($fromUser, $toUser, $msg)
	{
		$str = "从" . $fromUser . "到" . $toUser . "消息为" . $msg;
		return $str;
	}
}

?>