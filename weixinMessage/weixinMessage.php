<?php

require_once dirname ( __FILE__ ) . '/weixinHelper.class.php';

define("TOKEN", "lixin");
$weixinHelper = new WeixinHelper();
$weixinHelper->check();

$weixinHelper->responseMessage();

?>