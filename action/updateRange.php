<?php

session_start();
if(!(isset($_SESSION['login']) && ($_SESSION['login'] == "success"))) {
	header("Location: login.php");
}

require_once dirname ( __FILE__ ) . '/../utils/SQLHelper.class.php';

	if(!isset($_POST['range_type'])
	|| !isset($_POST['min_index'])
	|| !isset($_POST['max_index']))
	{
		echo "fail";
	}
	else
	{
		$rangeType = $_POST['range_type'];
		$minIndex = $_POST['min_index'];
		$maxIndex = $_POST['max_index'];
		
		$sql = "update wx_range set gmt_modify=now(), min_index=" . $minIndex . ", max_index=" . $maxIndex . " where range_type='" . $rangeType . "'";
		$sqlHelper = new SQLHelper();
		$res = $sqlHelper->execute_dqm($sql);
		if($res == 0) {
			echo "fail";
		} else {
			header("Location: ../index.php");
		}
	}

?>