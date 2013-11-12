<?php
session_start();
$logged=false;
$forgot=false;
if(isset($_SESSION['logged']))
	if($_SESSION['logged']==true)
	{
		$logged=true;
		$user=$_SESSION['user'];
	}
else $logged=false;

$auth=true;
if($logged!=true)
{
	$user = "";
	include "config.php";
	if(isset($_POST['username']) && isset($_POST['pass']))
	{

		$username=$_POST['username']; 
		$user = $username;
		$password=$_POST['pass']; 
		//echo $username." ".$password;
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		$sql="SELECT * FROM admin WHERE username='$username' and pass='$password'";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		if($count==1)
		{
			$row = mysql_fetch_array($result);
			$_SESSION['logged']=true;
			$_SESSION['user']=$username;
			$_SESSION['account']="admin";
			$_SESSION['perm']=$row['permission'];
 	      	header("Location:admindashboard.php");
		}

		$sql="SELECT * FROM customer WHERE email='$username' and pass='$password' and status='ACTIVE'";
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
<title> Electricity Billing Management System </title>
<script src="js/jquery.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>

<link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">

</head>


<body>
<?php
	if($auth==false) 
	{
		echo '<script type="text/javascript"> alert("Wrong username pass combination");</script>';	
		$forgot = true;
	}
?>
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <?php
		  if(!isset($_SESSION['user']))
		  {
			?>
			<a class="navbar-brand" href="#">Electricity Billing System</a>
	      <?php
		  }
		  else
		  {
		   ?>
          <a class="navbar-brand" href="<?php echo (($_SESSION['account'] == 'customer')?'./dashboard.php':'./admindashboard.php');?>">Electricity Billing System</a>
        
<?php
		   }
		   echo '</div>';
		   echo '<div class="navbar-collapse collapse">';
   	if(!isset($_SESSION['user']))
	{
?>
          <form method="post" class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" name="username" placeholder="Email" value="<?php echo $user; ?>" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="pass" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
           <button type="button" class="btn btn-success" value="Click me" onclick="window.location = 'signup.php';">Sign up</button>
<?php
		if($forgot == true)
		{
?>
			<button type="button" class="btn btn-success" value="Click me" onclick="window.location = 'forgot.php?user=<?php echo $user; ?>';">Forgot?</button>
          </form>
<?php
		}
    }else
	{
    	echo "<span class=\"navbar-brand navbar-right\">Welcome $user </span>";
    }
?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
<?php
	if($logged==true)
	{
    	echo "<button type=\"button\" class=\"btn btn-success\" style=\"float:right; margin-top: 52px;\" value=\"Click me\" onclick=\"window.location = 'logout.php'\">Sign out</button>";
    }	
?>
<center>
<img style="width:850px; padding-top: 75px;" src="images/bulb.jpg"/>
</center>
<?php include "footer.php"; ?>
</body>


</html>