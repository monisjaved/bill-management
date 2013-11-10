<?php
session_start();

if($_SESSION['logged']!=true || $_SESSION['account']!="customer"){
	header("Location:index.php");
}

$user=$_SESSION['user'];

?>
<html>
<head> 
<title> Electricity Billing Management System </title>
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
	background-color: #DADDDF;
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
scripts[4] = "customer/complaint/complaint.php";
scripts[5] = "customer/deactivate.php";
scripts[6] = "customer/terminate.php";
function chosen (id) {

	for(i=1;i<=6;++i){
		$("#olc"+i).css('background-color','');
		$("#lc"+i).css('color','black');

	}

	$("#dash-choices").slideUp("slow");
	setTimeout(function(){$("#list-options").slideDown("slow")},500);

	$("#olc"+id).css('background-color','#47a447');
	$("#lc"+id).css('color','white');
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
    	echo "<span class=\"navbar-brand navbar-right\">Welcome $user</span>";
?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>
<?php
	if(isset($user)){
    	echo "<button type=\"button\" class=\"btn btn-success\" style=\"float:right; \" value=\"Click me\" onclick=\"window.location = 'logout.php'\">Sign out</button>";
    }	
?>
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

    <div id="list-options" class="list-group" style="width:250px; float:left; display:none; margin-left: 1%; margin-top: 2%; ont-weight: normal; font-family: Conv_rubrik_medium;font-size: 15px;">
	  <a href="#" id="olc1" class="list-group-item" onclick="chosen(1);"> <div id="lc1" >Pay Pending Bill</div></a>
	  <a href="#" id="olc2" class="list-group-item" onclick="chosen(2);"><div id="lc2" >View Monthly Bills</div></a>
	  <a href="#" id="olc3" class="list-group-item" onclick="chosen(3);"><div id="lc3" >Update Profile</div></a>
	  <a href="#" id="olc4" class="list-group-item" onclick="chosen(4);"><div id="lc4" >Complaints </div></a>
	  <a href="#" id="olc5"class="list-group-item" onclick="chosen(5);"><div id="lc5" >Deactivate Connection</div></a>
	  <a href="#" id="olc6" class="list-group-item" onclick="chosen(6);"><div id="lc6" >Terminate Connection </div></a>
	</div>

	<div id="content" style="float:left; display:none;padding-left: 21px; padding-top: 27px;
}" >


	</div>

</body>
</html>