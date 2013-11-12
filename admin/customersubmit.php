<?php
	if(file_exists('../config.php'))
	{
		include '../config.php';
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if(isset($_POST['user']))
		{
			$cnt = count($_POST['user']);
				//echo "<h2>".$_POST['user'][0]."<t>".$cnt."</h2>";
			for($i=0;$i<$cnt;$i++)
			{
				$a="INACTIVE";
				$email=$_POST['email'][$i];
				if(isset($_POST['app'][$i]))
				{
					$a = "ACTIVE";
				}
				$sql = "UPDATE customer SET status='$a' WHERE email='$email'";
				$result=mysql_query($sql);
				
			}
		}
	}
?>
<script type="text/javascript"> window.location='../admindashboard.php';</script>	
