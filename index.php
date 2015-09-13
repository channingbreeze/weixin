<?php 
	session_start();
	if(!(isset($_SESSION['login']) && ($_SESSION['login'] == "success"))) {
		header("Location: login.php");
	}
?>
<!DOCTYPE html>
<head>
	<meta charset=utf-8 />
	<title>首页</title>
</head>
<body>
	<a href="hei.php">嘿嘿</a>
	<a href="answer.php">智力题答案</a>
</body>