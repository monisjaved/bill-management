<script type="text/javascript">
function view(){
	window.open('getbill/view.php','_blank');
}
</script>
<button type="button" class="btn btn-primary" style="margin-bottom:5px;" id="pay" onclick="view();">Get PDF</button>
<div class="panel panel-default" style="width: 700px;">
  <div class="panel-heading"><b>Monthly Electricity Bills</b></div>

  <table class="table">
 <thead>
<tr> 
<th style=" width:10px;"> Month </th> 
<th> Amount</th> 
<th> Due Date </th>
<th>Status </th></tr>
</thead>


<?php
session_start();
include "../config.php";
$user=$_SESSION['user'];
$result=mysql_query("select * from bill where bill.cid =( select cid from customer where email='".$user."' )");

while($row=mysql_fetch_array($result)){
	echo "<tr>";
	echo "<td > ".$row['bill_date']." </td>";
	echo "<td> ".$row['amount']." </td>";
	$array=explode('-',$row['bill_date']);
	if($array[1]==12){
		$array[0]+=1;
		$array[1]=1;
	}
	else
		$array[1]+=1;
	echo "<td> ".$array[0]."-".$array[1]."-".$array[2]." </td>";
	if($row['status']=="PAID")
		echo "<td style=\"color:green;\"><b> ".$row['status']."</b> </td>";
	else	
		echo "<td style=\"color:red;\"><b> ".$row['status']."</b> </td>";
	echo "</tr>";
}

?>



  </table>
</div>
