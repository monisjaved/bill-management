<html>
<link href="../../edbms/bootstrap/dist/css/bootstrap.css" rel="stylesheet"> 
<script>
function ale(string a)
{
alert($a);
}
</script>
<body>
<p>
<?php
session_start();
if (strpos($_SESSION['perm'], 'x') !== false)
{
	if (isset($_POST["submit"])) 
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			foreach($_POST['user'] as $user)
			{
				$a="r";
				$user=$_POST['user'];
				$email=$_post['email'];
				if(isset($_POST['w']))
				{
					$a = $a+"w";
				}
				if(isset($_POST['x']))
				{
					$a = $a+"x";
				}
				$sql = "UPDATE admin SET permission='$a' WHERE username='$user' AND email='$email'";
				$result=mysql_query($sql);
				echo $a;
			}
		}
	}
	if(file_exists('../config.php'))
	{
		include '../config.php';
	}
	$user = $_SESSION['user'];
	$sql="SELECT * FROM admin where username!='$user'";
	$result=mysql_query($sql);
?>
	<form action=""" method="POST">
	<table class="table">
        <thead>
          <tr>
            <th>Admin</th>
            <th>email</th>
            <th>read bills</th>
            <th>edit bills</th>
			<th>change admin permissions</th>
          </tr>
        </thead>
		<tbody>
<?php
	while($row = mysql_fetch_array($result))
	{
        echo '<tr>';
        echo '<td><input type="text" value="'.$row['username'].'" name="user[]" readonly></td>';
        echo '<td><input type="text" value="'.$row['email'].'" name="email[]" readonly></td>';
		echo '<td><input type="checkbox" name="r[]" value="r" checked></td>';
        if(strpos($row['permission'], 'w') != false)
		{
			echo '<td><input type="checkbox" name="w[]" value="w" checked></td>';
		}
		else
		{
			echo '<td><input type="checkbox" name="w[]" value="w"></td>';
		}
		if(strpos($row['permission'], 'x') != false)
		{
			echo '<td><input type="checkbox" name="x[]" value="x" checked></td>';
		}
		else
		{
			echo '<td><input type="checkbox" name="x[]" value="x"></td>';
		}
        echo '</tr>';
    }
?>
       </tbody>
    </table>
	<button type="submit" class="btn btn-lg btn-success" value="submit">Save Changes</button>
	</form>
<?php
}
else
{
	echo '<h2>YOU ARE NOT ALLOWED TO CHANGE PERMISSIONS</h2>';
}
?>
</body>
</html>