<?php 
	session_start();
	if(!(isset($_SESSION['login']) && ($_SESSION['login'] == "success"))) {
		header("Location: login.php");
	}
?>
<!DOCTYPE html>
<head>
	<meta charset=utf-8 />
	<title>智力题答案</title>
</head>
<body>
	<div>设置答案：</div>
	<form action="answer/uploadAnswer.php" method="post">
		请输入关键词：<input type="text" name="keyword" /><br/>
		请输入答案：<textarea rows="10" cols="100" name="answer"></textarea><br/>
		<input type="submit" value="提交" /><br/>
	</form>
</body>