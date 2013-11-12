<?php
	session_start();
	if(file_exists('../config.php'))
	{
		include '../config.php';
	}
		
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		
		$cid = $_POST['cid'];
		$month=$_POST['month'];
		$month = date('Y')."-".$month;
		$reading=$_POST['reading'];
		$bill=$reading*4;
		$sql = "SELECT * from bill WHERE cid='$cid' and status='DUE' AND bill_date like '$month%'";
		//SELECT * from bill WHERE cid='1' and status='DUE' AND bill_date like '2013-11%'
		//echo $sql."<br>";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		$cnt=mysql_num_rows($result);
		echo $cnt;
		if($cnt == 0)
		{
			$month=$month."-1";
			$sql = "INSERT into bill VALUES (NULL,'$cid','$bill','$month',\"DUE\",'$reading',(SELECT aid from admin WHERE username='".$_SESSION['user']."'),'0')";
			//echo $sql;
			$result=mysql_query($sql);                      
		}	
		else
		{
			//echo $row['bill_date'];
			$a = explode("-", $row['bill_date']);
			$date=date('Y')."-".$a[1];
			//echo $date."".$a[1]."<br>";
			$sql = "UPDATE bill set amount=amount+$bill,reading=reading+$reading WHERE bill_date like '%$date%' AND cid=$cid";
			//echo $sql;
			$result=mysql_query($sql);
		}

	}
	
?>
<!--<script type="text/javascript"> window.location='../dashboard.php'; </script>-->