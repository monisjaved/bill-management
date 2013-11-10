<?php
session_start();

if($_SESSION['logged'] == true)
{
	$logged=true;
	$user=$_SESSION['user'];
}
else $logged=false;
$auth=true;
include "config.php";
if($logged!=true)
{
	
	if(isset($_POST['username']) && isset($_POST['pass'])){

		$username=$_POST['username']; 
		$password=$_POST['pass']; 
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		$sql="SELECT * FROM admin WHERE username='$username' and pass='$password'";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		$count=mysql_num_rows($result);
		if($count==1)
		{
			$_SESSION['logged']=true;
			$_SESSION['user']=$username;
			$_SESSION['account']="admin";
			$_SESSION['perm']=$row['permission'];
			header("Location:admindashboard.php");

		}
?>


<?php
		$sql="SELECT * FROM customer WHERE email='$username' and pass='$password'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);	
		$row = mysql_fetch_array($result);
		if($count==1)
		{
			$logged =true;
			$_SESSION['logged']=true;
			$_SESSION['user']=$username;
			$_SESSION['test']=$row['name'];
			$_SESSION['account']="customer";
			$auth=true;
			header("Location:dashboard.php");

		}else $auth=false;
	}
}

?>

<html>
<head> 
<title> Eletricity Billing Management System </title>
<script src="js/jquery.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>

<link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">
<script>
function sgn()
{
window.location = "sign.php";
}
</script>
<script>
function prf()
{
window.location = "dashboard.php";
}
</script>
<script>
function logout()
{
window.location = "logout.php";
}
</script>

</head>



<body>
<?php
	if($auth==false) 
		echo '<script type="text/javascript"> alert("Wrong username pass combination");</script>'	
?>
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Electricity Billing System</a>
        </div>
        <div class="navbar-collapse collapse">
<?php
   	if($logged!=true)
	{
?>
          <form method="post" class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" name="username" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="pass" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
			<button type="button" class="btn btn-success" value="Click me" onclick="sgn()">Sign up</button>
          </form>
		  
<?php
    }
	else
	{
    	echo "<span class=\"navbar-brand navbar-right\">Welcome ".$_SESSION['test']."  ".'<button type="button" class="btn btn-success" value="Click me" onclick="prf()">Dashboard</button>'.'  '.'<button type="button" class="btn btn-success" value="Click me" onclick="logout()">Sign out</button>'."</span>";
    }
?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>


<?php
	if($logged!=true)
	{
?>
<?php
    }else
	{
    	echo "<span class=\"navbar-brand navbar-right\">Welcome User</span>";

    }
?>



</body>


</html>