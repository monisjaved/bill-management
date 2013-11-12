<?php

session_start();

include "../config.php";

if(isset($_POST['check_pass'])){
  $pass=stripslashes(mysql_real_escape_string($_POST['check_pass']));
  $result=mysql_query("select * from customer where email='".$_SESSION['user']."' and pass='".$pass."'");
  $count=mysql_num_rows($result);
  if($count==1){
    mysql_query("UPDATE customer set status ='TERMINATED' where email='".$_SESSION['user']."'");
    echo "yes";
  }else
    echo "no";
    exit();

}

?>
<script type="text/javascript">

function c_pass () {

  var pas=$("#check_pass").val();
  $.post("customer/terminate.php",
    {
      check_pass : pas
    },
    function(result){
      if(result=="yes"){
        $("#check_p").html("Your Customer account is currently in the state <span style=\"color:red;\"><b>TERMINATED</b></span>");
      }else
        alert("Wrong Password");
      }
    );  
}


</script>

<?php
	$result=mysql_query("select * from customer where email='".$_SESSION['user']."'");
	$row=mysql_fetch_array($result);
	if($row['status']=='ACTIVE' || $row['status']=='DEACTIVATED'){

?>
<div id="check_p">
    <label for="check_pass">Enter password to terminate Customer connection</label>
    <input type="password" class="form-control" id="check_pass" size="40" >
    <button class="btn btn-default" onclick="c_pass();">Submit</button>
</div>



<?php
}else{
	echo "Your Customer account is currently in the state <span style=\"color:red;\"><b>".$row['status']."</b></span>";
}
?>
