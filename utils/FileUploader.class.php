<?php 

require_once dirname ( __FILE__ ) . '/../qiniu/autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class FileUploader
{
	private $accessKey;
	private $secretKey;
	private $bucket;
	private $auth;
	private $token;
	private $uploadMgr;
	
	function __construct() {
		$this->accessKey = 'SLaMlSIvFkz8Y9lG5AKtK-EhYHT57VKgn9xrKsIp';
		$this->secretKey = 'pidQCRSmTPSFKO7GkxJCb7AlKuDZq61_W6WTtepK';
		$this->bucket = 'webxinxin';
		$this->auth = new Auth($this->accessKey, $this->secretKey);
		$this->token = $this->auth->uploadToken($this->bucket);
		$this->uploadMgr = new UploadManager();
	}
	
	public function uploadFile($fileName, $filePath) {
		$this->uploadMgr->putFile($this->token, $fileName, $filePath);
	}
	
}


?>