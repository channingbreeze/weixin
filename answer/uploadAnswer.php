<?php

session_start ();
if (! (isset ( $_SESSION ['login'] ) && ($_SESSION ['login'] == "success"))) {
	header ( "Location: login.php" );
}

require_once dirname ( __FILE__ ) . '/../utils/SQLHelper.class.php';

if (! isset ( $_POST ['keyword'] ) || ! isset ( $_POST ['answer'] )) {
	echo "fail";
} else {
	$keyword = $_POST ['keyword'];
	$answer = $_POST ['answer'];
	
	$sqlHelper = new SQLHelper ();
	$sql = "insert into wx_answer (gmt_create, gmt_modify, keyword, answer) values (now(), now(), '" . $keyword . "', '" . $answer . "')";
	$res = $sqlHelper->execute_dqm ( $sql );
	if ($res == 1) {
		header ( "Location: ../answer.php" );
	} else {
		echo "fail";
	}
}

?>