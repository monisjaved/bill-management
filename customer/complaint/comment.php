<?php

session_start();

include "../../config.php";
$user=$_SESSION['user'];
$coid=$_REQUEST['coid'];

?>
<head>
<script src="../../js/jquery.js"></script>
<script src="../../bootstrap/dist/js/bootstrap.min.js"></script>

<link href="../../bootstrap/dist/css/bootstrap.css" rel="stylesheet">
<script>

function add_comment() {

	var te=$("#commentbox").val();


	$.post("customer/complaint/add_comment.php",
		{
			comment: te,
			coid:<?php echo $coid; ?>
		},
		function(result){
			close_comments();
			show_comments(<?php echo $coid ?>);

  		}
  	);
	
}

</script>
</head>
<body>
	<div class="panel panel-default" style="width: 100%;text-align:center;">
	<div class="panel panel-default">
  
  	<div class="panel-heading"><b>Conversation Thread  </b>
  		<a href="#" style="float:right;" onclick="close_comments()"> Close </a>
  	</div>
  	<ul class="list-group">
	<?php
		$result=mysql_query("Select * from comment where coid=$coid");
		$count=mysql_num_rows($result);
		if($count == 0)
			echo "<b>No comments</b>";
		while($row=mysql_fetch_array($result))
			echo " <li class='list-group-item' style=\"text-align:left;\"><b>".$row['sender']." </b>(".$row['time'].")<br/>".$row['text']."&nbsp&nbsp&nbsp<small></small>"."</li>";
	?>

	</div>

<?php
	$result=mysql_query("Select * from complaint where coid=$coid");
	$row=mysql_fetch_array($result);
	if($row['status']!="SOLVED"){

?>
<div id="comment_box">	
	<textarea class="form-control" rows="3" placeholder="Your Comment...." id="commentbox" name="comment"></textarea>
	<input type="submit" onclick="add_comment()" class="btn btn-primary" style="float:right;" value="Add Comment" />
</div>	
<?php
}else
echo "<span style=\"color:green; font-size:20px;\" > <b>Thread closed</b> </span>";

?>


</div>
<body>
