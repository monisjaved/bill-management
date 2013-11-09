<?php

session_start();

if($_SESSION['logged']!=true || $_SESSION['account']!="admin")
	header("Location:../index.php");


echo "Hello Admin";

?>