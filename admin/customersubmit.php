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
	