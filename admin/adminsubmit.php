<?php
	if(file_exists('../config.php'))
	{
		include '../config.php';
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
				$cnt = 0;
				$cnt = count($_POST['name']);
				//echo "<h2>".$_POST['user'][0]."<t>".$cnt."</h2>";
				for($i=0;$i<=$cnt;$i++)
				{
					$a="r";
					$user=$_POST['user'][$i];
					$email=$_POST['email'][$i];
					if(isset($_POST['w'][$i]))
					{
						$a = $a."w";
					}
					if(isset($_POST['x'][$i]))
					{
						$a = $a."x";
					}
					$sql = "UPDATE admin SET permission='$a' WHERE email='$email'";
					$result=mysql_query($sql);
				}
		}
	
?>
<script type="text/javascript"> window.location='../dashboard.php'; </script>