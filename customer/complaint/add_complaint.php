<?php

session_start();


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['logged']) && $_SESSION['logged']==true){
	include "../../config.php";

	$user=$_SESSION['user'];
	
	$sql="SELECT cid FROM customer WHERE email='$user'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);

	$userid=$row['cid'];
	$text=mysql_real_escape_string(stripslashes($_POST['complaint']));

	$sql="INSERT INTO `complaint`(`cid`,`status`) VALUES (".$userid.",'PENDING')";
	$result=mysql_query($sql);

	$sql="INSERT INTO `comment`(`coid`,`text`,`sender`) VALUES (LAST_INSERT_ID(),'$text','$user')";
	$result=mysql_query($sql);

}











?>