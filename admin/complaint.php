<?php
include "../config.php";
if(isset($_POST['coid'])){
	mysql_query("UPDATE complaint set status = 'SOLVED' where coid=".$_POST['coid']);
	exit();
}
?>

<script>
	
function show_comments(id){
	$.get("customer/complaint/comment.php",
		{
			coid: id
		},
		function(result){
			$("#backlight").show();
			$("#lightbox").show();
			$("#lightbox").html(result);

  		}
  	);
}

function close_comments(){
	$("#backlight").hide();
	$("#lightbox").hide();
	$("#lightbox").html("");
}

function end_comp(id){
	$.post("admin/complaint.php",
		{
			coid: id
		},
		function(result){
			chosen(4);
  		}
  	);

}


</script>

<div class="panel panel-default" style="width: 700px;">
  <div class="panel-heading"><b>Complaints Section</b></div>
   <table class="table table">
 <thead>
<tr> 
<th> Complaint</th> 
<th>Status</th>
<th>Comments</th>
<th>Action</th>
</tr>

</thead>

<?php
session_start();
include "../config.php";
$user=$_SESSION['user'];

$sql="SELECT * from complaint where status='PENDING' order by coid desc";
$result=mysql_query($sql);

while($row=mysql_fetch_array($result)){

	$re=mysql_query("select text from comment where coid=".$row['coid']." order by time limit 1");
	$ro=mysql_fetch_array($re);
	
	echo "<tr>";

	if(strlen($ro['text'])<=25)
		echo "<td> ".$ro['text']." </td>";
	else
		echo"<td>".substr($ro['text'],0,20)."... </td>";
	
	echo "<td style=\"color:red;\"><b> ".$row['status']."</b> </td>";
	
	echo "<td> <a class='comment' href=\"#\" onclick=\"show_comments(".$row['coid'].");\"'>View Response</a> </td>";
	echo "<td>";
	echo "<button type=\"button\" class=\"btn btn-success\" onclick=\"end_comp(".$row['coid'].");\">Close</button>";
	echo "</td></tr>";

}?>
</table>


<div id="lightbox" style="z-index:900; position:absolute; padding-bottom:4px; left:20%; width:60%; top:10%; align:middle; background-color:white; display:none;">


</div>
<div id="backlight" style="display:none; width:100%; left:0px; top:0px; height:100%; background-color: black;opacity: 0.8;position: fixed;"></div>



