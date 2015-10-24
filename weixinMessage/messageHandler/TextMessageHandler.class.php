<?php

require_once dirname ( __FILE__ ) . '/MessageHandler.class.php';
require_once dirname ( __FILE__ ) . '/../messageService/NoneMessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageService/HeiMessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageService/QAnswerMessageService.class.php';
require_once dirname ( __FILE__ ) . '/../messageService/GameMessageService.class.php';
require_once dirname ( __FILE__ ) . '/../../utils/StringUtil.class.php';

class TextMessageHandler extends MessageHandler {
	
	public function handleMessage($postObj) {
		
		$keyword = trim($postObj->Content);
		if(!empty( $keyword )) {
			if(StringUtil::startsWith($keyword, "嘿嘿")) {
				$messageService = new HeiMessageService();
			} else if(StringUtil::endsWith($keyword, "答案")) {
				$messageService = new QAnswerMessageService();
			} else if($keyword == "flappybird") {
				$messageService = new GameMessageService($keyword);
			} else {
				$messageService = new NoneMessageService();
			}
		} else {
			$messageService = new NoneMessageService();
		}
		
		return $messageService->generateMessage($postObj);
	}

}

?>