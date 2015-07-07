<?php

session_start();
if(!(isset($_SESSION['login']) && ($_SESSION['login'] == "success"))) {
	header("Location: login.php");
}

require_once dirname ( __FILE__ ) . '/../utils/SQLHelper.class.php';

	if(!isset($_POST['title']))
	{
		echo "fail";
	}
	else
	{
		$title = $_POST['title'];
		$sqlHelper = new SQLHelper();
		$sql = "insert into wx_title (gmt_create, gmt_modify, title) values (now(), now(), '" . $title . "')";
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