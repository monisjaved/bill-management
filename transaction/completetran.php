<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['logged']) && $_SESSION['logged']==true){
	include "../config.php";

	$user=$_SESSION['user'];
	$ip= $_SERVER['REMOTE_ADDR'];
	$amount=$_POST['amount'];
	$status=$_POST['status'];
	
	
	$result=mysql_query("select max(tid) as max from transaction");
	
	$count=mysql_num_rows($result);
	if($count ==1 ){
	$row=mysql_fetch_array($result);
	$max=$row['max'];
	$max++;
	}
	else $max = 1;

	$query="select bill_id from bill where cid=(select cid from customer where email='$user') and status ='DUE'";
	echo $query;
	$result= mysql_query($query);
	while($row=mysql_fetch_array($result)){
		
		$sql = "INSERT INTO `transaction`(`tid`,`ip`, `bill_id`, `amount`, `status`) VALUES ($max,'$ip',".$row['bill_id'].",$amount,'$status')";
		mysql_query("$sql");
	}
//UPDATE  `bill` SET STATUS =  "DUE" WHERE 1
	if($status == 'Completed'){
		$sql= "UPDATE `bill` SET `status`='PAID' WHERE `cid`=(select cid from customer where email='$user') and `status`='DUE'";
		mysql_query($sql);
	}
	
	#echo $max;
	
}
?>