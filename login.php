<?php
session_start();
if(isset($_SESSION['logged']))
{
	if($_SESSION['logged']==true)
	{
		header("Location:index.php");
	}
}
	if(isset($_POST['username']) && isset($_POST['pass']))
	{
		include "config.php";
		$username=$_POST['username']; 
		$password=$_POST['pass']; 
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		$sql="SELECT * FROM admin WHERE username='$username' and pass='$password'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		if($count==1)
		{
		  $_SESSION['logged']=true;
		  $_SESSION['user']=$username;
		  $_SESSION['account']="admin";
		  header("Location:admin/index.php");
		}
		$sql="SELECT * FROM customer WHERE email='$username' and pass='$password' and status='ACTIVE'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result); 
		if($count==1)
		{
		  $_SESSION['logged']=true;
		  $_SESSION['user']=$username;
		  $_SESSION['account']="customer";
		  header("Location:dashboard.php");
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
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="username" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" name="pass" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
      </form>

    </div>

<h1></h1><h1></h1><h1></h1><?php include "footer.php"; ?>
</body>


</html>