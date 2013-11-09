<?php
session_start();

if($_SESSION['logged']!=true || $_SESSION['account']!="customer"){
	header("Location:index.php");
}
else $logged=false;


?>
<html>
<head> 
<title> Eletricity Billing Management System </title>
<script src="js/jquery.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>

<link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">

</head>

<style type="text/css">
body {
  padding-top: 50px;
  padding-bottom: 20px;
}
.choice{
	float: left;
	width: 275px;
	text-align: center;
	background-color: #F3F4F5;
	margin-bottom: 2;
	margin-left: 2;
	height: 168px;
	padding-top: 63px;
	font-size: 20px;
	font-family: Conv_rubrik_medium;
	font-weight: normal;
}
.choice:hover{
	background-color: #47a447;
}
#list-options.a{
	background-color: #47a447;
}
</style>

<script type="text/javascript">
var scripts = new Array();
scripts[0] = "";
scripts[1] = "customer/paybill.php";
scripts[2] = "customer/viewbills.php";
scripts[3] = "customer/profile.php";
scripts[4] = "customer/complaint.php";
scripts[5] = "customer/deactivate.php";
scripts[6] = "customer/terminate.php";
function chosen (id) {

	for(i=1;i<=6;++i) $("#lc"+i).removeClass('active');

	$("#dash-choices").slideUp("slow");
	setTimeout(function(){$("#list-options").slideDown("slow")},500);

	$("#lc"+id).addClass('active');
	$("#content").slideDown("slow");

	$.get(scripts[id],function(data,status){
    //alert("Data: " + data + "\nStatus: " + status);
  	$("#content").html(data);
  });


	
}
</script>



<body>



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
<?php
    	echo "<span class=\"navbar-brand navbar-right\">Welcome ".$_SESSION['test'].'  '.'<button type="button" class="btn btn-success" value="Click me" onclick="logout()">Sign out</button>'."</span>";
?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>


    <div id="dash-choices" style="padding-left: 19%; padding-top: 5%;">
    	<div>
    	<a href ="#" style="color:black" onclick="chosen(1);" >
	    	<div id ="c1" class="choice">   
	    		Pay Pending Bill
	    	</div>
	    </a>
    	<a href ="#" style="color:black" onclick="chosen(2);" >
	    	<div id ="c1" class="choice"> 
	    		View Monthly Bills
	    	</div>
    	</a>
    	<a href ="#" style="color:black" onclick="chosen(3);" >
	    	<div id ="c1" class="choice">
	    		Update Profile
	    	</div>
    	</a>
    	<br/>
    	</div>
    	<div>
    	<a href ="#" style="color:black" onclick="chosen(4);" >
	    	<div id ="c1" class="choice">
	    		Complaints
	    	</div>
    	</a>
    	<a href ="#" style="color:black" onclick="chosen(5);" >
	    	<div id ="c1" class="choice">
	    		Deactivate Connection 
	    	</div>
    	</a>
    	<a href ="#" style="color:black" onclick="chosen(6);" >
	    	<div id ="c1" class="choice">
	    		Terminate Connection 
	    	</div>
    	</a>
    	</div>
    </div>

    <div id="list-options" class="list-group" style="width:250px; float:left; display:none; margin-left: 1%; margin-top: 2%;">
	  <a href="#" id="lc1" class="list-group-item" onclick="chosen(1);">Pay Pending Bill</a>
	  <a href="#" id="lc2" class="list-group-item" onclick="chosen(2);">View Monthly Bills</a>
	  <a href="#" id="lc3" class="list-group-item" onclick="chosen(3);">Update Profile</a>
	  <a href="#" id="lc4" class="list-group-item" onclick="chosen(4);">Complaints </a>
	  <a href="#" id="lc5" class="list-group-item" onclick="chosen(5);">Deactivate Connection</a>
	  <a href="#" id="lc6" class="list-group-item" onclick="chosen(6);">Terminate Connection </a>
	</div>

	<div id="content" style="float:left; display:none;" >
vg

	</div>

</body>
</html>