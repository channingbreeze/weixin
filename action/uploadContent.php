<?php

session_start();
if(!(isset($_SESSION['login']) && ($_SESSION['login'] == "success"))) {
	header("Location: login.php");
}

require_once dirname ( __FILE__ ) . '/../utils/SQLHelper.class.php';

	if(!isset($_POST['content']))
	{
		echo "fail";
	}
	else
	{
		$content = $_POST['content'];
		$arr = split("\r\n|\n\r|\n|\r", $content);
		$result = "<li class=\"content\">";
		for($i=0; $i<count($arr); $i++)
		{
			$result = $result . "　　" . $arr[$i] . "<br/>";
		}
		$result = $result . "</li>";
		$sqlHelper = new SQLHelper();
		$sql = "insert into wx_content (gmt_create, gmt_modify, content) values (now(), now(), '" . $result . "')";
		$res = $sqlHelper->execute_dqm($sql);
		if($res == 1)
		{
			header("Location: ../index.php");
		}
		else
		{
			echo "fail";
		}
	}

?>