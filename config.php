<?php
$host="localhost";
$mysql_user="monis";
$mysql_pwd="root";
$dbms="edbms";
$con = mysql_connect($host,$mysql_user,$mysql_pwd);
if (!$con) die('Could not connect: ' . mysql_error());
mysql_select_db($dbms)or die("cannot select DB");
?>