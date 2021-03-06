<?php

class ConfigUtil {
	
	private static $instance;
	public $token;
	public $accessKey;
	public $secretKey;
	public $bucket;
	public $debug;
	public $faceppKey;
	public $faceppSecret;
	
	private function __construct() {
		$arr = parse_ini_file ( dirname ( __FILE__ ) . "/../config/env.ini" );
		$this->token = $arr ['token'];
		$this->accessKey = $arr ['accessKey'];
		$this->secretKey = $arr ['secretKey'];
		$this->bucket = $arr ['bucket'];
		$this->debug = $arr ['debug'];
		$this->faceppKey = $arr ['faceppKey'];
		$this->faceppSecret = $arr ['faceppSecret'];
	}
	
	public static function getInstance(){
		if(!(self::$instance instanceof self)){
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function isInDebugMode() {
		if($this->debug == "true") {
			return true;
		} else {
			return false;
		}
	}
	
}