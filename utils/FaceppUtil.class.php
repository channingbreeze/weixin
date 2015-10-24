<?php

require_once dirname ( __FILE__ ) . '/../facepp/facepp_sdk.php';
require_once dirname ( __FILE__ ) . '/ConfigUtil.class.php';

class FaceppUtil {
	
	public function getFaceppRes($url) {
		
		$facepp = new Facepp();
		$facepp->api_key = ConfigUtil::getInstance()->faceppKey;
		$facepp->api_secret = ConfigUtil::getInstance()->faceppSecret;
		$params = array();
		$params['url'] = $url . "";
		$params['attribute'] = "glass,pose,gender,age,race,smiling";
		$response = $facepp->execute('/detection/detect', $params);
		return $response;
		
	}
	
}