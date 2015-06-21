<?php

require_once dirname ( __FILE__ ) . '/check.class.php';

define("TOKEN", "lixin");
$check = new Check();
$check->valid();

?>