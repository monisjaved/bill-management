<?php
	include "config.php";
	$hash = $_GET['hash'];
	$user = $_GET['user'];
	$passErr = $confpassErr = $status = "";
	$flag = 0;
	$sql = "SELECT * from customer where email='$user'";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count == 1)
	{
		$row=mysql_fetch_array($result);
		$str = $user.":".$row['email'];
		if(md5($str) == $hash)
		{
			$user = $row['email'];
		}
	}
	$sql = "SELECT * from admin where username='$user'";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count == 1)
	{
		$row=mysql_fetch_array($result);
		$str = $user.":".$row['email'];
		if(md5($str) == $hash)
		{
			$user = $row['email'];
		}
	}
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(isset($_POST['password']) && isset($_POST['confpassword']))
		{
			if (empty($_POST["password"])) 
			{
				$passErr = "Missing";
				$flag=1;
			}
			else 
			{
				$pass = $_POST["confpassword"];
			}
			if (empty($_POST["confpassword"])) 
			{
				$confpassErr = "Missing";
				$flag=1;
			}
			else 
			{
				if($_POST["confpassword"] == $_POST["password"])
				{
					$confpass = $_POST["confpassword"];
				}
				else
				{
					$confpassErr = "Password doesnt match";
					$flag = 1;
				}
			}
			if($flag == 0)
			{
				$sql = "UPDATE admin set pass=\"$pass\" where email=\"$user\"";
				$result=mysql_query($sql);
				$count = mysql_affected_rows();
				if($result == 1)
				{
					$status = "PASSWORD CHANGED SUCCESSFULLY";
				}
				$sql = "UPDATE customer set pass=\"$pass\" where email=\"$user\"";
				$result=mysql_query($sql);
				$count = mysql_affected_rows();
				if($result == 1)
				{
					$status = "PASSWORD CHANGED SUCCESSFULLY";
				}
			}
		}
	}
?>	
<html>			
	<head> 
	<title> Eletricity Billing Management System </title>
	<script src="js/jquery.js"></script>
	<script src="bootstrap/dist/js/bootstrap.min.js"></script>

	<link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">
	<style type="text/css">
	body {
	  padding-top: 40px;
	  padding-bottom: 40px;
	  background-color: #eee;
	}

	.form-signin {
	  max-width: 330px;
	  padding: 15px;
	  margin: 0 auto;
	}
	.form-signin .form-signin-heading,
	.form-signin .checkbox {
	  margin-bottom: 10px;
	}
	.form-signin .checkbox {
	  font-weight: normal;
	}
	.form-signin .form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
	  -webkit-box-sizing: border-box;
		 -moz-box-sizing: border-box;
			  box-sizing: border-box;
	}
	.form-signin .form-control:focus {
	  z-index: 2;
	}
	.form-signin input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}
	.form-signin input[type="password"] {
	  margin-bottom: 10px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
	</style>

	</head>

	<body>
		<div class="container">
		  <form method="post" class="form-signin">
			<h2 class="form-signin-heading">Password Change</h2>
			<label><?php echo $status; ?></label>
			<input type="password" name="password" class="form-control" placeholder="Password" required autofocus>
			<label><?php echo $passErr; ?></label>
			<input type="password" name="confpassword" class="form-control" placeholder="Confirm Password" required>
			<label><?php echo $confpassErr; ?></label>
			<button class="btn btn-lg btn-success btn-block" type="submit">Reset</button>
		  </form>
		</div>
	<?php include "footer.php"; ?>
	</body>
</html>
	