<?php
session_start();

if($_SESSION['logged']!=true || $_SESSION['account']!="customer"){
	header("Location:../login.php");

}
$logged=true;
$user=$_SESSION['user'];
require "../config.php";


 
	$month=date('m');
	$year=date('Y');
	$amount=0;
	$pmount=0;
	if ($month==1){
		$month=12;
		$year--;
	}
	else
		$month--;
	
	$result=mysql_query("select sum(amount) as tamount from bill where cid=(select cid from customer where email='$user') and status ='DUE' and bill_date >= '$year-$month-01'");
	$count=mysql_num_rows($result);
	if($count != 0){
		$row=mysql_fetch_array($result);
		$amount=$row['tamount'];
	}
	
	$result=mysql_query("select sum(amount) as pamount from bill where cid=(select cid from customer where email='$user') and status ='DUE' and bill_date < '$year-$month-01'");
	$count=mysql_num_rows($result);
	if($count != 0){
		$row=mysql_fetch_array($result);
		$pamount=$row['pamount']+$row['pamount']*5/100;
	}
	?>
<html>
<head> 
<title> Electricity Bill Payment </title>
<script src="../js/jquery.js"></script>
<script src="../bootstrap/dist/js/bootstrap.min.js"></script>

<link href="../bootstrap/dist/css/bootstrap.css" rel="stylesheet">
<script>

var options = new Array();
options[0] = "";
options[1] = "<div class='input-group'>  <span class='input-group-addon'>A/C</span>  <input id='num' type='text' class='form-control' placeholder='A/C No'></div>";

options[2] = "<div class='input-group'><span class='input-group-addon'>CC</span><input id='num' type='text' class='form-control' placeholder='Credit Card No.'></div>";

options[3] = "<div class='input-group'><span class='input-group-addon'>DD</span><input id='num' type='text' class='form-control' placeholder='DD/Cheque No.'></div>";

function start(){
	
	document.getElementById('opt').innerHTML=options[1];
}

function showpdf () {
	window.open('../getbill/bill.php','_blank');
}

function pay () {
	if($("#id").val()==""){
		alert("A/c or /Cc  or DD number cant be  empty");
	}
	else{
		var stat=document.getElementById('num').placeholder;
		if(stat =='A/C No' || stat=='Credit Card No.') {
			stat='Completed';
		}
		else stat='Pending';

		var co =$("#num").val();
		$.post("completetran.php",
			{
				amount:"<?php echo ($amount+$pamount); ?>",
				status: stat
				
			},
			function(result){
	    		alert("Your Transaction Completed Successfully with a/c or c/c no="+co);
	    		window.location.replace("../dashboard.php");
	  		}
	  	);
	}
}

function showoptions(ch){
	document.getElementById('opt').innerHTML=options[ch];
	$("#opt").hide();
	$("#opt").show("fast");
	/*if(ch==3){
		$("#pay").hide("fast");
	}
	else
		$("#pay").show("fast");*/
}

</script>
</head>
<body onload="start();">
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Electricity Billing System</a>
        </div>
        <div class="navbar-collapse collapse">
    	<span class="navbar-brand navbar-right">Welcome <?php echo $user;?> </span>

    

        </div><!--/.navbar-collapse -->
      </div>
     </div>
<div  style="padding-top: 8%;padding-left:20%" >
	<div class="panel panel-default" style="width:700px;" >
	<div class="panel-heading"><b>Your Bill:</b></div>
	<table class= "table" style="width:700px;">
		<thead>
			<tr>
				<th>Name</th>
				<th>Amount</th>
			</tr>
		</thead>

	<?php 
	echo "<tr class=\"warning\"><td><b>Current Bill : </b><td>". ($amount!=0?$amount:0) ."</td></tr><br>";
	echo "<tr class=\"danger\"><td><b>Pending Bill Amount (IncludingSurcharge of 5%):</b><td>$pamount</td></tr><br>";
	echo "<tr style=\"border-top:13px;\" class=\"success\"><td><b>Total Amount :</b><td><b> ".($amount+$pamount)."</b></td></tr><br>";
	?>
	</table>
</div>
<button type="button" class="btn btn-primary" style="margin-bottom:5px; margin-top:-18px;" id="pdf" onclick="showpdf();">Get PDF</button><br><br>
<table>
	<tr><td style="padding-right:15px;">
<select class="form-control" style="width:200px; " onchange="showoptions(this.value);">
  <option value="1" onSelect="showoptions(1);">Online Banking</option>
  <option value="2" onSelect="showoptions(2);">Credit Card</option>
  <option value="3" onSelect="showoptions(3);">Demand Draft</option>
 </select></td><td>
 <div id="opt">
 </div></td>
</tr>
</table>
<br>
<div id="paybill" >
	<button type="button" class="btn btn-primary" style="margin-bottom:5px;" id="pay" onclick="pay();">Pay Bill</button>
</div>


</div>

</body>