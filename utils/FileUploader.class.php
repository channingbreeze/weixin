<?php 

require_once dirname ( __FILE__ ) . '/../qiniu/autoload.php';
require_once dirname ( __FILE__ ) . '/ConfigUtil.class.php';

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
		$this->accessKey = ConfigUtil::getInstance()->accessKey;
		$this->secretKey = ConfigUtil::getInstance()->secretKey;
		$this->bucket = ConfigUtil::getInstance()->bucket;
		$this->auth = new Auth($this->accessKey, $this->secretKey);
		$this->token = $this->auth->uploadToken($this->bucket);
		$this->uploadMgr = new UploadManager();
	}
	
	public function uploadFile($fileName, $filePath) {
		$this->uploadMgr->putFile($this->token, $fileName, $filePath);
	}
	
}


?>