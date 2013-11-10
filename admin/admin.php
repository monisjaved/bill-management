<html>
<link href="../../edbms/bootstrap/dist/css/bootstrap.css" rel="stylesheet"> 
<script>
    $(function js() {
        $('form#person').on('submit', function(e) {
            $.ajax({
                type: 'post',
                url: 'adminsubmit.php',
                data: $(this).serialize(),
                success: function (o) {
                         // =====>    console.log(o); <=== I TRIED DOING THIS BUT NOTHING IS PRINTED
                    alert('MUST ALERT TO DETERMINE SUCCESS PAGE');
                }
            });
            e.preventDefault();
        });
    });     
</script>
<script type="text/javascript">
		$(function(){
			$('#ff').form({
				success:function(data){
					$.messager.alert('Info', data, 'info');
				}
			});
		});
	</script>

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
if(file_exists('../config.php'))
{
	include '../config.php';
}
if (strpos($_SESSION['perm'], 'x') !== false)
{
	if (isset($_POST["submit"])) 
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			$cnt = count($_POST['name']);
			for($i=0;$i<$cnt;$i++)
			{
				$a="r";
				$user=$_POST['user'][$i];
				$email=$_post['email'][$i];
				if(isset($_POST['w'][$i]))
				{
					$a = $a+"w";
				}
				if(isset($_POST['x'][$i]))
				{
					$a = $a+"x";
				}
				$sql = "UPDATE admin SET permission='$a' WHERE username='$user' AND email='$email'";
				$result=mysql_query($sql);
				echo $a;
			}
			if($i == $cnt)
			{
				echo '<p><h1>success</h1>';
			}
		}
	}
	$user = $_SESSION['user'];
	$sql="SELECT * FROM admin where username!='$user'";
	$result=mysql_query($sql);
?>
	<div class="panel panel-default" style="width: 700px;">
  <div class="panel-heading"><b>Change Admin Permissions</b></div>
	<form method="POST" id="person" action="admin/adminsubmit.php">
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
	<button type="submit" class="btn btn-lg btn-success" value="submit" onclick="js()">Save Changes</button>
	</form>
	</div>
	</div>
<?php
}
else
{
	echo '<h2>YOU ARE NOT ALLOWED TO CHANGE PERMISSIONS</h2>';
}
?>
</body>
</html>