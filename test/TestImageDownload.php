<?php
/* 
//too slow
$imgData = file_get_contents("http://mmbiz.qpic.cn/mmbiz/9hHl4cxPLIsAuXRBWXx8AVEqHfhMT32J3MibDTrOunIQ2gkCvHzFYWJojxpkf3tQnPXG6fsic24tcCdLOXNBjK0g/0");
file_put_contents(dirname ( __FILE__ ) . "/../html/" . "test" . ".jpg", $imgData);
*/
$file_url = "http://mmbiz.qpic.cn/mmbiz/9hHl4cxPLIsAuXRBWXx8AVEqHfhMT32J3MibDTrOunIQ2gkCvHzFYWJojxpkf3tQnPXG6fsic24tcCdLOXNBjK0g/0";
$save_to = dirname ( __FILE__ ) . "/../html/" . "test" . ".jpg";
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch,CURLOPT_URL,$file_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$file_content = curl_exec($ch);
curl_close($ch);

$downloaded_file = fopen($save_to, 'w');
fwrite($downloaded_file, $file_content);
fclose($downloaded_file);
?>