<script >
function pay(){
	window.location.replace("./transaction/transaction.php");
}
</script>




<button type="button" class="btn btn-primary" style="margin-bottom:5px;" id="pay" onclick="pay();">Pay Bill</button>

<div class="panel panel-default" style="width: 700px;">
  <div class="panel-heading"><b>Pending Electricity Bills</b></div>

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
$result=mysql_query("select * from bill where bill.cid =( select cid from customer where email='".$user."' ) and status='DUE'");

while($row=mysql_fetch_array($result)){
	echo "<tr>";
	echo "<td > ".$row['bill_date']." </td>";
	echo "<td> ".$row['amount']." </td>";
	echo "<td> ".$row['bill_date']." </td>";
	echo "<td style=\"color:red;\"><b> ".$row['status']."</b> </td>";
	echo "</tr>";
}

?>



  </table>
</div>
