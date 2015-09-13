<?php

require_once dirname ( __FILE__ ) . '/MessageHandler.class.php';
require_once dirname ( __FILE__ ) . '/../messageService/NoneMessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageService/SubscribeMessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageService/UnsubscribeMessageService.class.php';

class EventMessageHandler extends MessageHandler {
	
	public function handleMessage($postObj) {
		$event = trim($postObj->Event);
		
		if($event == "subscribe") {
			$messageService = new SubscribeMessageService();
		} else if($event == "unsubscribe") {
			$messageService = new UnsubscribeMessageService();
		} else {
			$messageService = new NoneMessageService();
		}
		
		return $messageService->generateMessage($postObj);
	}

}

?>