<?php 

session_start();
if(!(isset($_SESSION['login']) && ($_SESSION['login'] == "success"))) {
	header("Location: login.php");
}

require_once dirname ( __FILE__ ) . '/../utils/SQLHelper.class.php';
require_once dirname ( __FILE__ ) . '/../utils/UniqueIdGenerator.class.php';
require_once dirname ( __FILE__ ) . '/../utils/FileUploader.class.php';

if(isset($_FILES['pic'])) {
	if(is_uploaded_file($_FILES['pic']['tmp_name'])) {
		$extension = substr($_FILES['pic']['name'], strpos($_FILES['pic']['name'], "."));
		$uniqueIdGenerator = new UniqueIdGenerator();
		$fileUploader = new FileUploader();
		$fileName = $uniqueIdGenerator->getUniqueId() . $extension;
		$filePath = $_FILES["pic"]["tmp_name"];
		$fileUploader->uploadFile($fileName, $filePath);
		$host = "http://7xjv6k.com1.z0.glb.clouddn.com/";
		$url = $host . $fileName;
		$sqlHelper = new SQLHelper();
		$sql = "insert into wx_pic (gmt_create, gmt_modify, url, resolution) values (now(), now(), '" . $url . "' ,'360x200')";
		$res = $sqlHelper->execute_dqm($sql);
		if($res != 1) {
			echo "fail";
		} else {
			header("Location: ../index.php");
		}
	} else {
		echo "fail";
	}
} else {
	echo "fail";
}

?>
