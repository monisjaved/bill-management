<?php
session_start();
$logged = false;

if(isset($_SESSION['logged']))
	if($_SESSION['logged']==true)
	{
		$logged=true;
		$user=$_SESSION['user'];
		if($_SESSION['account'] == "admin")
		{
			//header("Location:admindashboard.php");
		}
		if($_SESSION['account'] == "customer")
		{
			header("Location:dashboard.php");
		}
	}
else $logged=false;

$auth=true;
if($logged!=true){
	include "config.php";
	if(isset($_POST['username']) && isset($_POST['pass'])){

		$username=$_POST['username']; 
		$password=$_POST['pass']; 
		//echo $username." ".$password;
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		$sql="SELECT * FROM admin WHERE username='$username' and pass='$password'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);

		$count=mysql_num_rows($result);
		if($count==1){
			$_SESSION['logged']=true;
			$_SESSION['user']=$username;
			$_SESSION['account']="admin";
			$_SESSION['perm']=$row['permission'];
			header("Location:admindashboard.php");

		}

		$sql="SELECT * FROM customer WHERE email='$username' and pass='$password'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);	

		if($count==1){
			$logged =true;
			$_SESSION['logged']=true;
			$_SESSION['user']=$username;
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
<script>
function prf(a)
{
if(a == "customer")
{
	window.location = "dashboard.php";
}
if(a == "admin")
{
	window.location = "admindashboard.php";
}
}
</script>
<script>
function logout()
{
window.location = "logout.php";
}
</script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>

<link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">

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
   	if($logged!=true){
?>
          <form method="post" class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" name="username" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="pass" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
           <button type="button" class="btn btn-success" value="Click me" onclick="window.location = 'signup.php';">Sign up</button>
          </form>
<?php
    }else{

    	echo "<span class=\"navbar-brand navbar-right\">Welcome $user  ".'<button type="button" class="btn btn-success" value="Click me" onclick="prf(\''.$_SESSION['account'].'\')">Dashboard</button>'.'  '.'<button type="button" class="btn btn-success" value="Click me" onclick="logout()">Sign out</button>'."</span>";
    }
?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
<?php
	
?>
<center>
<img style="width:850px; padding-top: 75px;" src="images/bulb.jpg"/>
</center>
</body>


</html>