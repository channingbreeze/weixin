<?php 
	session_start();
	if(!(isset($_SESSION['login']) && ($_SESSION['login'] == "success"))) {
		header("Location: login.php");
	}
?>
<!DOCTYPE html>
<head>
	<meta charset=utf-8 />
	<title>爱奇艺会员</title>
</head>
<body>
	
</body>