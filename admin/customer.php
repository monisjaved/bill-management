<html>
<link href="../../edbms/bootstrap/dist/css/bootstrap.css" rel="stylesheet"> 
<body>
<p>
<?php
session_start();
if (strpos($_SESSION['perm'], 'w') !== false)
{
	if(file_exists('../config.php'))
	{
		include '../config.php';
	}
	$user = $_SESSION['user'];
	$sql="SELECT * FROM customer WHERE status='INACTIVE'";
	$result=mysql_query($sql);
?>
	<form action="" method="POST">
	<table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>email</th>
            <th>Phone</th>
            <th>Address</th>
			<th>Approve</th>
          </tr>
        </thead>
		<tbody>
<?php
	while($row = mysql_fetch_array($result))
	{
        echo '<tr>';
        echo '<td><input type="text" value="'.$row['name'].'" name="user[]" readonly></td>';
        echo '<td><input type="text" value="'.$row['email'].'" name="email[]" readonly></td>';
		echo '<td><input type="text" value="'.$row['phone'].'" name="phone[]" readonly></td>';
		echo '<td><input type="text" value="'.$row['address'].'" name="address[]" readonly></td>';
		echo '<td><input type="checkbox" name="app[]" value="r"></td>';
        echo '</tr>';
    }
?>
       </tbody>
    </table>
	<button type="submit" class="btn btn-lg btn-success" value="submit">Save Changes</button>
	</form>
<?php
if (isset($_POST["submit"])) 
{
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		foreach($_POST['user'] as $user)
		{
			$a="INACTIVE";
			$user=$_POST['user'];
			$email=$_post['email'];
			if(isset($_POST['app']))
			{
				$a = "ACTIVE";
			}
			$sql = "UPDATE customer SET status='$a' WHERE username='$user' AND email='$email'";
			$result=mysql_query($sql);
		}
	}
}
	
}
else
{
	echo '<h2>YOU ARE NOT ALLOWED TO APPROVE USER REQUEST</h2>';
}
?>
</body>
</html>