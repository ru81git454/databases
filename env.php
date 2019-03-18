<?php
/*
範例檔名：env.php
程式功能：PHP中伺服器變數($_SERVER)的應用
程式設計：H.T.Wang
設計日期：2003-10-12
程式版本：1.0
*/

header("Content-Type:text/html; charset=utf-8");
echo "伺服器主機的IP是 <big><b>".$_SERVER['SERVER_ADDR']." ( </b></big> \n";
echo "伺服器主機名稱是 <big><b>".$_SERVER['HTTP_HOST']." )</b></big> \n<BR \>";
echo "用戶端電腦的IP是 <big><b>".$_SERVER['REMOTE_ADDR']."</b></big> \n<BR \>";
echo "用戶端電腦的瀏覽器是 <big><b>".$_SERVER['HTTP_USER_AGENT']."</b></big> \n<BR \>";
echo "伺服器端的作業系統是 <big><b>".PHP_OS."</b></big> \n<BR \>";
?>
