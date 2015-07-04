<?php

	if(isset($_POST['username']) && isset($_POST['password']))
	{
		if($_POST['username'] == "eGlueGlud2Vi" && $_POST['password'] == "cGFzc3dvcmQ=")
		{
			session_start();
			$_SESSION['login'] = "success";
			header("Location: ../index.php");
		}
		else
		{
			header("Location: ../login.php");
		}
	}
	else
	{
		header("Location: login.php");
	}

?>