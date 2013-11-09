<html>
<head>
<title>Sign Up</title>
<link class="cssdeck" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" class="cssdeck">
</head>
<body>
<?php
$nameErr = $addrErr = $emailErr = $passwordErr = $confpasswordErr = $phoneErr = "";
	$name = $address = $email = $password = $confpassword = $phone = "";
	$flag=0; 
if (isset($_GET["submit"])) 
{
 
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
				$phonee = $_POST["phone"];
			}
			else
			{
				$phoneErr = "Phone number can contain only numbers";
				$flag=1;
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
				$email = "invalid";
				$flag=1;
			}
			else
			{
				$email = $_POST['email'];
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
		}
		if($flag == 0)
		{
			include "config.php";
			$sql = "INSERT INTO customer (name,email,phone,pass,status,address)
							VALUES ('$name','$email','$phone','$password','INACTIVE','$address')";
			if (!mysqli_query($con,$sql))
			{
				die('Error: ' . mysqli_error($con));
			}
			header("Location:dashboard.php");
		}
		
		
		
	}
}
?>
<div class="" id="loginModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>Have an Account?</h3>
	</div>
	<!--<div class="modal-body">-->
		<div class="well">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#create" data-toggle="tab">Create Account</a></li>
				<li ><a href="#login" data-toggle="tab">Login</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade" id="login">
					<form class="form-horizontal" action='' method="POST">
						<fieldset>
							<div id="legend">
								<legend class="">Login</legend>
							</div>    
							<div class="control-group">
								<!-- Username -->
								<label class="control-label"  for="username">Username</label>
								<div class="controls">
									<input type="text" id="username" name="username" placeholder="" class="input-xlarge">
								</div>
							</div>
							
							<div class="control-group">
								<!-- Password-->
								<label class="control-label" for="password">Password</label>
								<div class="controls">
									<input type="password" id="password" name="password" placeholder="" class="input-xlarge">
								</div>
							</div>
							
							
							<div class="control-group">
								<!-- Button -->
								<div class="controls">
									<button class="btn btn-success">Login</button>
								</div>
							</div>
						</fieldset>
					</form>                
				</div>
				<div class="tab-pane active" id="create">
					<form id="tab" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<label>Name</label>
						<input type="text" name="name" placeholder="name" value="" class="input-xlarge">
						<label><?php echo $nameErr;?></label>
						<label>Password</label>
						<input type="password" name="pass" placeholder="password" value="" class="input-xlarge">
						<label><?php echo $passwordErr;?></label>
						<label>Confirm Password</label>
						<input type="password" name="confpass" placeholder="confirm password" value="" class="input-xlarge">
						<label><?php echo $confpasswordErr;?></label>
						<label>Email</label>
						<input type="text" name="email" placeholder="Email" value="" class="input-xlarge">
						<label><?php echo $emailErr;?></label>
						<label>Phone</label>
						<input type="text" name="phone" placeholder="phone" value="" class="input-xlarge">
						<label><?php echo $phoneErr;?></label>
						<label>Address</label>
						<textarea value="" rows="3" name="address" placeholder="address" class="input-xlarge">
						</textarea>
						<label><?php echo $addrErr;?></label>
						
						<div>
							<button type = "submit" class="btn btn-primary">Create Account</button>
						</div>
					</form>
				</div>
			</div>
		<!--</div>-->
	</div>
</body>
<script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>