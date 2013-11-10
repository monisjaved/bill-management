<?php

session_start();


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['logged']) && $_SESSION['logged']==true){
	include "../../config.php";

	$user=$_SESSION['user'];
	
	$text=mysql_real_escape_string(stripslashes($_POST['comment']));

	$sql="INSERT INTO `comment`(`coid`,`text`,`sender`) VALUES (".$_REQUEST['coid'].",'".$text."','".$_SESSION['user']."')";
	$result=mysql_query($sql);

}











?>