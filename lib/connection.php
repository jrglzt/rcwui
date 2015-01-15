<?php
/*
 *Variables auxiliares de conexión a mysql
 *
 */
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "35060";
$mysql_database = "bdrcwui";
$prefix = "";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");
?>
