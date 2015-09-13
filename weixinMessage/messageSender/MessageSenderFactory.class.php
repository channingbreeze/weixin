<?php

require_once dirname ( __FILE__ ) . '/TextMessageSender.class.php';
require_once dirname ( __FILE__ ) . '/NewsMessageSender.class.php';
require_once dirname ( __FILE__ ) . '/NoneMessageSender.class.php';

class MessageSenderFactory {
	
	/**
	 * @param unknown_type $message
	 * @return TextMessageSender|NewsMessageSender|NoneMessageSender
	 */
	public function getMessageSender($message) {
		if($message->Type == "text") {
			return new TextMessageSender();
		} else if($message->Type == "news") {
			return new NewsMessageSender();
		} else {
			return new NoneMessageSender();
		}
	}
	
}

?>