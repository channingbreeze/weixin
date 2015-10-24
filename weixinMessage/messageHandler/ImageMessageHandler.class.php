<?php

require_once dirname ( __FILE__ ) . '/MessageHandler.class.php';
require_once dirname ( __FILE__ ) . '/../messageService/FaceppMessageService.class.php';

class ImageMessageHandler extends MessageHandler {
	
	public function handleMessage($postObj) {
		$messageService = new FaceppMessageService();
		return $messageService->generateMessage($postObj);
	}

}

?>