<?php

session_start();
$nameErr = $phoneErr = $addrErr = $emailErr = $passwordErr = $confpasswordErr = "";
include "config.php";
$flag=0;
if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{	

		if (empty($_POST["name"])) 
		{
			$nameErr = "Missing";
			$flag=1;
		}
		else 
		{
			$name = $_POST["name"];
		}

		
		if (empty($_POST["phone"])) 
		{
			$phoneErr = "Missing";
			$flag=1;
		}
		else 
		{
			if(is_numeric($_POST['phone']))
			{
				$phone = $_POST["phone"];
			}
			else
			{
				$phoneErr = "Phone number can contain only numbers";
				$flag=1;
			}
		}
		if (!isset($_POST["pass"])) 
		{
			$passwordErr = "missing";
			$flag=1;
		}
		else 
		{
			$password = $_POST["pass"];
		}
	 		
		if (empty($_POST["confpass"])) 
		{
			$confpasswordErr = "missing";
			$flag=1;
		}
		else 
		{
			if($_POST['confpass'] == $password)
			{
				$confpassword = $_POST["confpass"];
			}
			else
			{
				$confpasswordErr = "not same as password";
				$flag = 1;
			}
		}
		
		if (empty($_POST["address"])) 
		{
			$addrErr = "Missing";
			$flag=1;
		}
		else 
		{
			$address = $_POST["address"];
		}
		
	 
		if (empty($_POST["email"])) 
		{
			$emailErr = "Missing";
			$flag=1;
		}
		else 
		{
			if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
			{
				$email = $_POST['email'];
				
			}
			else
			{
				$emailErr = "Invalid Mail";
				$flag=1;
			}
		}
		
	 
		/*if (!isset($_POST["pass"])) 
		{
			$passwordErr = "missing";
			$flag=1;
		}
		else 
		{
			$password = $_POST["pass"];
		}
	 		
		if (empty($_POST["confpass"])) 
		{
			$confpassword = "missing";
			$flag=1;
		}
		else 
		{
			if($_POST['confpass'] == $password)
			{
				$confpassword = $_POST["confpass"];
			}
			else
			{
				$confpassword = "not same as password";
				$flag = 1;
			}
		}*/
		//echo $flag;
		if($flag == 0)
		{

			include "config.php";
			$sql = "INSERT INTO customer (name,email,phone,pass,status,address)
							VALUES ('$name','$email','$phone','$password','INACTIVE','$address')";
			if (!mysql_query($sql))
			{
				die('Error: ' . mysql_error($con));
			}
			header("Location:login.php");
		}
	
	}
?>

<html>

<head>
	<title></title>

<script src="js/jquery.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>

<link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">
</title>


<body>
<b><center style="font-size:40px;"> Signup </center></b>
<div style="padding-top:15px;padding-left:20px;">
	<form id="tab" method="post" style="width:45%">
		<label>Name</label>
		<input type="text" name="name" placeholder="name" class="form-control">
		<label><?php echo $nameErr;?></label>
		<br/>
		<label>Password</label>
		<input type="password" name="pass" placeholder="password" class="form-control">
		<label><?php echo $passwordErr;?></label>
		<br/>
		<label>Confirm Password</label>
		<input type="password" name="confpass" placeholder="confirm password" class="form-control">
		<label><?php echo $confpasswordErr;?></label>
		<br/>
		<label>Email</label>
		<input type="text" name="email" placeholder="Email" class="form-control">
		<label><?php echo $emailErr;?></label>
		<br/>
		<label>Phone</label>
		<input type="text" name="phone" placeholder="phone" class="form-control">
		<label><?php echo $phoneErr;?></label>
		<br/>
		<label>Address</label>
		<textarea rows="3" name="address" placeholder="address" class="form-control">
		</textarea>
		<label><?php echo $addrErr;?></label>
			
		<div>
			<button type = "submit" class="btn btn-primary">Create Account</button>
		</div>
	</form>
</div>
<?php include "footer.php"; ?>
</body>



</html>