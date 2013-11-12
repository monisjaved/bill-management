
<html>
<link href="../bootstrap/dist/css/bootstrap.css" rel="stylesheet"> 
<script type="text/javascript">

function subm(){
	var cid=$("#cid").val();
	var month=$("#month").val();
	var reading=$("#reading").val();
	$.post("admin/billsubmit.php",
				{
					cid:cid,
					month: month,
					reading:reading
					
				},
				function(result){
		    		alert("success");
		    		chosen(3);
		  		}
		  	);
}
</script>
<body>
<p>
<?php
session_start();
if (strpos($_SESSION['perm'], 'r') !== false)
{
	if(file_exists('../config.php'))
	{
		include '../config.php';
	}
	$user = $_SESSION['user'];
	//$sql="SELECT * FROM customer as a,bill WHERE status='ACTIVE'";
	//$result=mysql_query($sql);
?>
	<div class="panel panel-default" style="">
  <div class="panel-heading"><b>Bill</b></div>
	
	<table class="table">
        <thead>
          <tr>
            <th>Customer ID</th>
            <th>Month</th>
            <th>Reading</th>
          </tr>
        </thead>
		<tbody>

        <tr>
        <td><input id="cid" type="text" value="" name="cid" class="form-control"></td>
        <td><input id="month" type="text" value="" name="month" class="form-control"></td>
		<td><input id="reading" type="text" value="" name="reading" class="form-control"></td>
        </tr>

       </tbody>
    </table>
	<button type="submit" class="btn btn-lg btn-success" value="submit" onclick="subm();">Save Changes</button>
	
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