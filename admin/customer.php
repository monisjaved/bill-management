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
	<div class="panel panel-default" style="">
  <div class="panel-heading"><b>Pending Customer Approvals</b></div>
	<form action="admin/customersubmit.php" method="POST">
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
        echo '<td><input type="text" value="'.$row['name'].'" name="user[]" readonly class="form-control"></td>';
        echo '<td><input type="text" value="'.$row['email'].'" name="email[]" readonly class="form-control"></td>';
		echo '<td><input type="text" value="'.$row['phone'].'" name="phone[]" readonly class="form-control"></td>';
		echo '<td><input type="text" value="'.$row['address'].'" name="address[]" readonly class="form-control"></td>';
		echo '<td><input type="checkbox" name="app[]" value="r"></td>';
        echo '</tr>';
    }
?>
       </tbody>
    </table>
	<button type="submit" class="btn btn-lg btn-success" value="submit">Save Changes</button>
	</form>
	</div>
	</div>
<?php
}
else
{
	echo '<h2>YOU ARE NOT ALLOWED TO APPROVE USER REQUEST</h2>';
}
?>
</body>
</html>