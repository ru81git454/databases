<?php
/*
範例檔名：dir.php
程式功能：PHP中倒單引號(`)的應用
程式設計：H.T.Wang
設計日期：2003-10-12
程式版本：1.0
*/

header("Content-Type:text/html; charset=big5");
$l=`ls -l`;
echo "<pre>$l</pre>";
?>