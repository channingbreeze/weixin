<?php

require_once dirname ( __FILE__ ) . '/MessageHandler.class.php';
require_once dirname ( __FILE__ ) . '/../messageService/NoneMessageService.class.php';

class NonsenseMessageHandler extends MessageHandler {
	
	public function handleMessage($postObj) {
		
		$messageService = new NoneMessageService();
		return $messageService->generateMessage($postObj);
		
	}

}

?>