<?php

session_start();
if(!(isset($_SESSION['login']) && ($_SESSION['login'] == "success"))) {
	header("Location: login.php");
}

require_once dirname ( __FILE__ ) . '/../utils/SQLHelper.class.php';

	if(!isset($_POST['content'])
	|| !isset($_POST['id']))
	{
		echo "fail";
	}
	else
	{
		$id = $_POST['id'];
		$content = $_POST['content'];
		$arr = split("\r\n|\n\r|\n|\r", $content);
		$result = "<li class=\"content\">";
		for($i=0; $i<count($arr); $i++)
		{
			$result = $result . "　　" . $arr[$i] . "<br/>";
		}
		$result = $result . "</li>";
		$sqlHelper = new SQLHelper();
		$sql = "update wx_content set gmt_modify=now(), content='" . $result . "' where id=" . $id;
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