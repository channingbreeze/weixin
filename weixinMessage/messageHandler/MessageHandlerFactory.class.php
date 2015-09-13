<?php

require_once dirname ( __FILE__ ) . '/TextMessageHandler.class.php';
require_once dirname ( __FILE__ ) . '/ImageMessageHandler.class.php';
require_once dirname ( __FILE__ ) . '/EventMessageHandler.class.php';
require_once dirname ( __FILE__ ) . '/NonsenseMessageHandler.class.php';

class MessageHandlerFactory {
	
	public function getMessageHandler($postObj) {
		
		if($postObj->MsgType == "text") {
			return new TextMessageHandler($postObj);
		} else if($postObj->MsgType == "image") {
			return new ImageMessageHandler($postObj);
		} else if($postObj->MsgType == "event") {
			return new EventMessageHandler($postObj);
		} else {
			return new NonsenseMessageHandler($postObj);
		}
	}
	
}

?>