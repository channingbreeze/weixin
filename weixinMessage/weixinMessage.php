<?php

require_once dirname ( __FILE__ ) . '/weixinHelper.class.php';
require_once dirname ( __FILE__ ) . '/../utils/ConfigUtil.class.php';

define("TOKEN", ConfigUtil::getInstance()->token);
$weixinHelper = new WeixinHelper();
$weixinHelper->check();

$weixinHelper->responseMessage();

?>