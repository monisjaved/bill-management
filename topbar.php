<?php
	session_start();
	echo "LOL";
   	if($_SESSION['logged']!=true)
	{
?>
          <form method="post" class="navbar-form navbar-right" action="index.php">
            <div class="form-group">
              <input type="text" name="username" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="pass" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
			<button type="button" class="btn btn-success" value="Click me" onclick="sgn()">Sign up</button>
          </form>
		  
<?php
    }
	else
	{
    	echo "<span class=\"navbar-brand navbar-right\">Welcome ".$user."  ".'<button type="button" class="btn btn-success" value="Click me" onclick="prf()">My Account</button>'.'<button type="button" class="btn btn-success" value="Click me" onclick="logout()">Sign out</button>'."</span>";
    }
?>