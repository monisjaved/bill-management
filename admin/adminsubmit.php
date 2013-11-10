<?php
	echo '<h1>HI</h1>';
	if(file_exists('../config.php'))
	{
		include '../config.php';
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			if(isset($_POST['name']))
			{
				$cnt = count($_POST['name']);
				echo "<h2>".$_POST['user'][0]."<t>".$cnt."</h2>";
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
			else
			{
				echo '<p><h1>failed</h1>';
			}
		}
	
?>