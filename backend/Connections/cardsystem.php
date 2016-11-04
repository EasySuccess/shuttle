<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cardsystem = "localhost";
$database_cardsystem = "kingipmo";
$username_cardsystem = "kingipmo";
$password_cardsystem = "e8R0ruVx";
$cardsystem = mysql_pconnect($hostname_cardsystem, $username_cardsystem, $password_cardsystem) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8',$cardsystem);
?>