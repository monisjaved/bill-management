

<script>
	
    $("#complaint_box").hide();
    $("#add_comp").click(function(){
   	 	$("#complaint_box").show("slow");
  	});


function add_complaint() {

	var co =$("#complaintname").val();
	$.post("customer/complaint/add_complaint.php",
		{
			complaint: co
		},
		function(result){
    		$("#complaint_box").hide();
    		chosen(4);
  		}
  	);
	
}


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


</script>

<button type="button" class="btn btn-primary" style="margin-bottom:5px;" id="add_comp">Add a Complaint</button>
<div class="panel panel-default" style="width: 700px;">
  <div class="panel-heading"><b>Complaints Section</b></div>
   <table class="table table">
 <thead>
<tr> 
<th> Complaint</th> 
<th>Status</th>
<th>Comments</th></tr>

</thead>
<tr>

<div id="complaint_box" >
	<textarea class="form-control" rows="3" placeholder="Your Comment...." id="complaintname" name="complaint"></textarea>
	<input onclick="add_complaint()" class="btn btn-primary" style="margin-bottom:5px; float:right;" value="Submit" />
</div>
</tr>

<?php
session_start();
include "../../config.php";
$user=$_SESSION['user'];
$result=mysql_query("select * from complaint where cid=( select cid from customer where email='".$user."' ) order by `coid` desc");

while($row=mysql_fetch_array($result)){

	$re=mysql_query("select text from comment where coid=".$row['coid']." order by time limit 1");
	$ro=mysql_fetch_array($re);
	
	if($row['status']=='SOLVED')
		echo "<tr class='success'>";
	else
		echo "<tr>";

	if(strlen($ro['text'])<=25)
		echo "<td> ".$ro['text']." </td>";
	else
		echo"<td>".substr($ro['text'],0,20)."... </td>";

	//echo "<td> ".$row['status']." </td>";
	
	if($row['status']=='SOLVED')
		echo "<td style=\"color:green;\"><b> ".$row['status']."</b> </td>";
	else	
		echo "<td style=\"color:red;\"><b> ".$row['status']."</b> </td>";
	echo "<td> <a class='comment' href=\"#\" onclick=\"show_comments(".$row['coid'].");\"'>View Response</a> </td>";
	echo "</tr>";

}?>
</table>


<div id="lightbox" style="z-index:900; position:absolute; padding-bottom:4px; left:20%; width:60%; top:10%; align:middle; background-color:white; display:none;">


</div>
<div id="backlight" style="display:none; width:100%; left:0px; top:0px; height:100%; background-color: black;opacity: 0.8;position: fixed;"></div>



