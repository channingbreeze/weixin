<?php

require_once dirname ( __FILE__ ) . '/../utils/FileUploader.class.php';

$f = new FileUploader();
$res = $f->fetchFile("test.jpg", "http://mmbiz.qpic.cn/mmbiz/9hHl4cxPLIsAuXRBWXx8AVEqHfhMT32J3MibDTrOunIQ2gkCvHzFYWJojxpkf3tQnPXG6fsic24tcCdLOXNBjK0g/0");
echo $res;
?>