<?php
	session_start();
	$userErr = $emailErr = $sent = "";
	if(isset($_SESSION['logged']))
	{
		header("Location:index.php");
	}
	if(isset($_GET['user']))
	{
		$user = $_GET['user'];
		//echo $user;
	}
	else
	{
		$user="";
	}
	include "config.php";
	$flag = 0;
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(isset($_POST['username']) && isset($_POST['email']))
		{
			if (empty($_POST["username"])) 
			{
				$userErr = "Missing";
				$flag=1;
			}
			else 
			{
				$name = $_POST["username"];
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
					$emailErr = "Invalid";
					$flag=1;
				}
			}
			if($flag == 0)
			{
				$str = $name.":".$email;
				//echo '<h2>'.$str.'</h2>';
				$hash = md5($str);
				//echo '<h2>'.$hash.'</h2>';
				$subject = "Password Recovery";
				//echo "sadk;lfjkadsljfklasdj".$name;
				$message = "Hello ".$name."!This is a password recovery message.<br>Click on <a href = \"reset.php?hash=".$hash."&user=".$user."\" target = \"_blank\">THIS LINK</a> to change your password";
				echo '<h4>'.$message.'</h4>';
				$from = "admin@edbms.com";
				$headers = "From:" . $from;
				mail($email,$subject,$message,$headers);
				$sent = "MAIL SENT";
			}
		}
	}
	//echo '<h1>'.$user.'</h1>';
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
        <h2 class="form-signin-heading">Enter Account Details</h2>
		<label><?php echo $sent; ?></label>
        <input type="text" name="username" class="form-control" value="<?php echo $user; ?>" required>
		<label><?php echo $userErr;?></label>
        <input type="text" name="email" class="form-control" placeholder="email for <?php echo $user; ?>" required>
		<label><?php echo $emailErr;?></label>
        <button class="btn btn-lg btn-success btn-block" type="submit" name="submit">Send Mail</button>
      </form>

    </div>
	<?php include "footer.php"; ?>

</body>


</html>