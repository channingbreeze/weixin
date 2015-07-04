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
	<h1>请谨慎处理每一次提交</h1>
	<div>请用[[name]]表示姓名</div>
	<div>图片请用360X200的png或者jpg图片</div>
	<br/>
	<div>上传图片：</div>
	<form action="action/uploadPic.php" method="post" enctype="multipart/form-data">
		<input type="file" name="pic" />
		<input type="submit" value="提交" />
	</form>
	<br/>
	<div>上传标题：</div>
	<form action="action/uploadTitle.php" method="post">
		<input type="text" name="title" />
		<input type="submit" value="提交" />
	</form>
	<br/>
	<div>上传笑话：</div>
	<form action="action/uploadContent.php" method="post">
		<textarea rows="10" cols="100" name="content"></textarea>
		<input type="submit" value="提交" />
	</form>
	<div>修改Range：</div>
	<form action="action/updateRange.php" method="post">
		请输入Type：(pic, title, content)<input type="text" name="range_type" /><br/>
		请输入minIndex：<input type="text" name="min_index" /><br/>
		请输入maxIndex：<input type="text" name="max_index" /><br/>
		<input type="submit" value="提交" />
	</form>
	<div>修正笑话：</div>
	<form action="action/updateContent.php" method="post">
		请输入ID：<input type="text" name="id" /><br/>
		<textarea rows="10" cols="100" name="content"></textarea>
		<input type="submit" value="提交" />
	</form>
</body>