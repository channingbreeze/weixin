<?php 
	session_start();
	if(!(isset($_SESSION['login']) && ($_SESSION['login'] == "success"))) {
		header("Location: ../login.php");
	}
	
require_once dirname ( __FILE__ ) . '/../utils/SQLHelper.class.php';
	
	$sql = "select * from wx_title";
	$sqlHelper = new SQLHelper();
	$arr = $sqlHelper->execute_dql_array($sql);	
	echo "<xmp>";
	foreach ($arr as $obj) {
		echo "insert into wx_title (gmt_create, gmt_modify, title) values (now(), now(), '" . $obj['title'] . "');\r\n";
	}
	echo "</xmp>";
?>